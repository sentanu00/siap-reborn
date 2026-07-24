<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_ws4 extends SB_Controller
{

    private $api_mws_token;
    private $sso_token;


    function __construct()
    {
        parent::__construct();
        // Mengatur tipe konten header sebagai application/json
        header('Content-Type: application/json');

        $this->load->model('apimodel');

        $this->api_mws_token = $this->apimodel->getApiMwsToken();
    }



    public function setDataTerakhiradd_batch()
    {
        // echo "ww";
        // Matikan output buffering biar realtime
        ob_implicit_flush(true);
        ob_end_flush();

        header('Content-Type: text/plain'); // biar enak dilihat (atau text/html kalau mau)

        // Ambil dari POST
        $pegawai_ids = $this->input->post('pegawai_id');
        echo $pegawai_ids . "\n";

        // Handle string: '123','231','123'
        if (is_string($pegawai_ids)) {
            $pegawai_ids = str_replace("'", "", $pegawai_ids);
            $pegawai_ids = explode(",", $pegawai_ids);
        }

        foreach ($pegawai_ids as $pegawai_id) {

            $pegawai_id = trim($pegawai_id);

            try {

                echo "Proses pegawai: $pegawai_id ... ";
                flush();

                $query = $this->db->query("
                    SELECT 
                        j.JABATAN_RIWAYAT_ID, 
                        j.FLAG_DATA_TERAKHIR, 
                        j.KETERANGAN_BUP, 
                        j.JENIS_JABATAN_SAPK, 
                        DATE_FORMAT(
                            DATE_ADD(
                                DATE_ADD(p.TANGGAL_LAHIR, INTERVAL j.KETERANGAN_BUP YEAR), 
                                INTERVAL 1 MONTH
                            ), '%Y-%m-01'
                        ) AS TMT_PENSIUN
                    FROM jabatan_riwayat AS j 
                    JOIN pegawai AS p ON p.PEGAWAI_ID = j.PEGAWAI_ID
                    WHERE j.PEGAWAI_ID = '$pegawai_id'
                    ORDER BY j.TANGGAL_SK DESC 
                    LIMIT 1
                ");

                $result = $query->row();

                if (!$result) {
                    echo "❌ Gagal (data tidak ditemukan)\n";
                    flush();
                    continue;
                }


                $this->db->query("
                        UPDATE jabatan_riwayat 
                        SET FLAG_DATA_TERAKHIR = 0 
                        WHERE PEGAWAI_ID = '$pegawai_id'
                    ");

                $this->db->query("
                        UPDATE jabatan_riwayat 
                        SET FLAG_DATA_TERAKHIR = 1 
                        WHERE JABATAN_RIWAYAT_ID = '$result->JABATAN_RIWAYAT_ID'
                    ");

                $tipe_pegawai = null;
                if ($result->JENIS_JABATAN_SAPK == 1) {
                    $tipe_pegawai = 11;
                } elseif ($result->JENIS_JABATAN_SAPK == 2) {
                    $tipe_pegawai = 2;
                } elseif ($result->JENIS_JABATAN_SAPK == 4) {
                    $tipe_pegawai = 12;
                }

                $this->db->query("
                        UPDATE pegawai AS p 
                        SET 
                            p.TIPE_PEGAWAI_ID = '$tipe_pegawai',
                            p.TANGGAL_PENSIUN = '$result->TMT_PENSIUN',
                            p.JABATAN_ID_TERAKHIR = '$result->JABATAN_RIWAYAT_ID'
                        WHERE p.PEGAWAI_ID = '$pegawai_id'
                    ");

                echo "✅ Sukses\n";

                flush();

                // optional: kasih jeda biar kelihatan progres
                usleep(200000); // 0.2 detik

            } catch (Exception $e) {
                echo "❌ Error: " . $e->getMessage() . "\n";
                flush();
            }
        }

        echo "\n=== SELESAI ===\n";
    }



    public function update_data_terakhir_tbl_pegawai()
    {
        $sql = "UPDATE pegawai p
        SET 
            PANGKAT_ID_TERAKHIR = (
                SELECT pr.pangkat_riwayat_id
                FROM pangkat_riwayat pr
                WHERE pr.PEGAWAI_ID = p.PEGAWAI_ID
                ORDER BY pr.TMT_PANGKAT DESC
                LIMIT 1
            ),
            JABATAN_ID_TERAKHIR = (
                SELECT jr.JABATAN_RIWAYAT_ID
                FROM jabatan_riwayat jr
                WHERE jr.PEGAWAI_ID = p.PEGAWAI_ID
                ORDER BY jr.TMT_JABATAN DESC
                LIMIT 1
            ),
            PENDIDIKAN_ID_TERAKHIR = (
                SELECT pd.PENDIDIKAN_RIWAYAT_ID
                FROM pendidikan_riwayat pd
                WHERE pd.PEGAWAI_ID = p.PEGAWAI_ID
                ORDER BY pd.TANGGAL_STTB DESC
                LIMIT 1
            ),
            SATKER_INDUK_ID = (
                SELECT s.SATKER_INDUK_ID  
                FROM satker s 
                WHERE s.SATKER_ID = p.SATKER_ID
            )
        WHERE p.STATUS_PEGAWAI IN ('2');";

        // Mulai transaksi
        $this->db->trans_start();

        // Eksekusi query
        $this->db->query($sql);

        // Selesaikan transaksi
        $this->db->trans_complete();

        // Cek status transaksi
        if ($this->db->trans_status() === FALSE) {
            $error = $this->db->error();
            echo "Gagal update data: " . $error['message'] . " (Kode error: " . $error['code'] . ")";
        } else {
            $affected = $this->db->affected_rows();
            echo "Update data berhasil. Jumlah pegawai yang diupdate: " . $affected;
        }
    }

    public function set_flag_data_utama()
    {
        $this->db->trans_start();

        // Tambahkan pegawai baru ke tabel siasnpegawaiid
        $this->db->query("
            INSERT INTO siasnpegawaiid (pegawai_id, nip)
            SELECT
                p.PEGAWAI_ID,
                p.NIP_BARU
            FROM pegawai p
            WHERE p.STATUS_PEGAWAI IN ('1','2','10','18')
            AND NOT EXISTS (
                SELECT 1
                FROM siasnpegawaiid s
                WHERE s.pegawai_id = p.PEGAWAI_ID
            )
        ");

        $inserted = $this->db->affected_rows();

        // Set flag data utama
        $this->db->query("
            UPDATE siasnpegawaiid
            SET
                flag_data_utama = 1,
                retry_count_data_utama = 0
            WHERE flag_data_utama IN (1,3)
            OR retry_count_data_utama > 0
        ");

        $updated = $this->db->affected_rows();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $error = $this->db->error();
            echo "Gagal: {$error['message']}";
        } else {
            echo "Berhasil. "
                . "Pegawai baru ditambahkan: {$inserted}. "
                . "Data yang di-set flag: {$updated}. "
                . date('Y-m-d H:i:s');
        }
    }

    public function sync_data_utama_batch($limit = 50, $batastolreansi = 50)
    {
        echo "================================ mulai ambil data utama " . date('Y-m-d H:i:s') . " ================================\n\n";

        $token = $this->api_mws_token;

        $pegawai = $this->db
            ->where('flag_data_utama', 1)
            ->where('retry_count_data_utama <', $batastolreansi)
            ->order_by('id')
            ->limit($limit)
            ->get('siasnpegawaiid')
            ->result();

        foreach ($pegawai as $p) {

            echo "\nSedang diproses : {$p->nip}";

            $json = $this->get_data_utama($token, $p->nip);

            $retry = $p->retry_count_data_utama + 1;

            /**
             * 1. Response kosong
             */
            if (empty($json)) {

                $this->db
                    ->where('id', $p->id)
                    ->update('siasnpegawaiid', array(
                        'flag_data_utama'       => ($retry >= $batastolreansi ? 3 : 1),
                        'retry_count_data_utama' => $retry
                    ));

                echo " ==> Response kosong ({$retry}/{$batastolreansi})";

                continue;
            }

            /**
             * 2. Decode JSON
             */
            $response = json_decode($json, true);

            if (json_last_error() != JSON_ERROR_NONE) {

                $this->db
                    ->where('id', $p->id)
                    ->update('siasnpegawaiid', array(
                        'flag_data_utama'       => ($retry >= $batastolreansi ? 3 : 1),
                        'retry_count_data_utama' => $retry
                    ));

                echo " ==> JSON tidak valid ({$retry}/{$batastolreansi})";
                echo "\nResponse : " . substr($json, 0, 200);

                continue;
            }

            /**
             * 3. Response sukses
             */
            if (isset($response['code']) && $response['code'] == 1) {

                $save = $this->insertOrUpdateDataUtama($response, $p->pegawai_id);

                if ($save['success']) {

                    $this->db
                        ->where('id', $p->id)
                        ->update('siasnpegawaiid', array(
                            'flag_data_utama'       => 0,
                            'retry_count_data_utama' => 0
                        ));

                    echo " ==> SUKSES";
                } else {

                    $this->db
                        ->where('id', $p->id)
                        ->update('siasnpegawaiid', array(
                            'flag_data_utama'       => ($retry >= $batastolreansi ? 3 : 1),
                            'retry_count_data_utama' => $retry
                        ));

                    echo " ==> Gagal menyimpan data";
                }

                continue;
            }

            /**
             * 4. Response gagal dari SIASN
             */

            $this->db
                ->where('id', $p->id)
                ->update('siasnpegawaiid', array(
                    'flag_data_utama'       => ($retry >= $batastolreansi ? 3 : 1),
                    'retry_count_data_utama' => $retry
                ));

            $pesan = isset($response['message']) ? $response['message'] : 'Unknown Error';

            echo " ==> GAGAL ({$retry}/{$batastolreansi}) : {$pesan}";
        }

        echo "\n\n================================ selesai ambil data utama " . date('Y-m-d H:i:s') . " ================================\n";
    }

    public function get_data_utama($api_mws_token, $nip_baru)
    {
        // $api_mws_token = $this->session->userdata('token_apimws');
        // $sso_token = $this->session->userdata('token_sso');


        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama/' . $nip_baru,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token,
                'Cookie: ff8d625df24f2272ecde05bd53b814bc=ce158eaac3b25204bfaa39e480fc50f7; pdns=1091068938.13088.0000'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // $hasil['data']['sso_token'] = $sso_token;
        // $hasil['data']['api_mws_token'] = $api_mws_token;
        // $hasil['data']['return'] = $response;

        // return $response;
        return $response;
    }

    private function insertOrUpdateDataUtama($response_data, $pegawai_id)
    {
        $data = $response_data['data'];

        // Format tanggal dari string ke format database
        $formatDate = function ($date_str) {
            if (empty($date_str) || $date_str == 'null') return null;
            $date = DateTime::createFromFormat('d-m-Y', $date_str);
            return $date ? $date->format('Y-m-d') : null;
        };

        // Format tahun lulus
        $tahunLulus = null;
        if (!empty($data['tahunLulus'])) {
            $tahun = DateTime::createFromFormat('d-m-Y', $data['tahunLulus']);
            $tahunLulus = $tahun ? $tahun->format('Y') : null;
        }

        // Prepare data untuk insert
        $insert_data = array(
            'id' => $data['id'],
            'nipBaru' => $data['nipBaru'],
            'nipLama' => $data['nipLama'],
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'gelarBelakang' => $data['gelarBelakang'],
            'gelarDepan' => $data['gelarDepan'],
            'statusPegawai' => $data['statusPegawai'],
            'jenisKelamin' => $data['jenisKelamin'],
            'jenisPegawaiNama' => substr($data['jenisPegawaiNama'], 0, 10), // truncate to fit column
            'tempatLahir' => substr($data['tempatLahir'], 0, 20),
            'tglLahir' => $formatDate($data['tglLahir']),
            'agama' => $data['agama'],
            'alamat' => $data['alamat'],
            'email' => substr($data['email'], 0, 50),
            'emailGov' => substr($data['emailGov'], 0, 50),
            'masaKerja' => $data['masaKerja'],
            'mkBulan' => $data['mkBulan'],
            'mkTahun' => $data['mkTahun'],
            'noHp' => $data['noHp'],
            'noTelp' => $data['noTelp'],
            'statusPerkawinan' => $data['statusPerkawinan'],
            'statusHidup' => $data['statusHidup'],
            'tglMeninggal' => $formatDate($data['tglMeninggal']),
            'agamaId' => $data['agamaId'],
            'akteKelahiran' => $data['akteKelahiran'],
            'akteMeninggal' => $data['akteMeninggal'],
            'bahasa' => $data['bahasa'],
            'bpjs' => $data['bpjs'],
            'jenisKawinId' => $data['jenisKawinId'],
            'jenisPegawaiId' => $data['jenisPegawaiId'],
            'kanregId' => $data['kanregId'],
            'kanregNama' => $data['kanregNama'],
            'kartuAsn' => $data['kartuAsn'],
            'kedudukanPnsId' => $data['kedudukanPnsId'],
            'kedudukanPnsNama' => $data['kedudukanPnsNama'],
            'kodePos' => $data['kodePos'],
            'lokasiKerja' => $data['lokasiKerja'],
            'lokasiKerjaId' => $data['lokasiKerjaId'],
            'noAskes' => $data['noAskes'],
            'noNpwp' => $data['noNpwp'],
            'noSeriKarpeg' => $data['noSeriKarpeg'],
            'noTaspen' => $data['noTaspen'],
            'taspenId' => $data['taspenId'],
            'taspenNama' => $data['taspenNama'],
            'tempatLahirId' => $data['tempatLahirId'],
            'tglNpwp' => $formatDate($data['tglNpwp']),
            'tmtPns' => $formatDate($data['tmtPns']),
            'nomorSkPns' => $data['nomorSkPns'],
            'tglSkPns' => $formatDate($data['tglSkPns']),
            'tglSttpl' => $formatDate($data['tglSttpl']),
            'nomorSttpl' => $data['nomorSttpl'],
            'tglSuratKeteranganDokter' => $formatDate($data['tglSuratKeteranganDokter']),
            'noSuratKeteranganDokter' => $data['noSuratKeteranganDokter'],
            'jenjang' => $data['jenjang'],
            'pendidikanTerakhirNama' => substr($data['pendidikanTerakhirNama'], 0, 20),
            'tkPendidikanTerakhir' => $data['tkPendidikanTerakhir'],
            'tahunLulus' => $tahunLulus,
            'pendidikanTerakhirId' => $data['pendidikanTerakhirId'],
            'tkPendidikanTerakhirId' => $data['tkPendidikanTerakhirId'],
            'jumlahIstriSuami' => $data['jumlahIstriSuami'],
            'golRuangAkhir' => $data['golRuangAkhir'],
            'golRuangAkhirId' => $data['golRuangAkhirId'],
            'pangkatAkhir' => substr($data['pangkatAkhir'], 0, 20),
            'tmtGolAkhir' => $formatDate($data['tmtGolAkhir']),
            'golRuangAwal' => $data['golRuangAwal'],
            'golRuangAwalId' => $data['golRuangAwalId'],
            'jenisIdDokumenId' => $data['jenisIdDokumenId'],
            'jenisIdDokumenNama' => $data['jenisIdDokumenNama'],
            'kpknId' => $data['kpknId'],
            'kpknNama' => $data['kpknNama'],
            'kppnId' => $data['kppnId'],
            'kppnNama' => $data['kppnNama'],
            'ktuaId' => $data['ktuaId'],
            'ktuaNama' => $data['ktuaNama'],
            'nomorIdDocument' => $data['nomorIdDocument'],
            'tmtJabatan' => $formatDate($data['tmtJabatan']),
            'jabatanNama' => $data['jabatanNama'],
            'jenisJabatan' => $data['jenisJabatan'],
            'eselon' => $data['eselon'],
            'unorNama' => $data['unorNama'],
            'unorIndukNama' => $data['unorIndukNama'],
            'instansiKerjaNama' => $data['instansiKerjaNama'],
            'bupPensiun' => $data['bupPensiun'],
            'tmtPensiun' => $formatDate($data['tmtPensiun']),
            'eselonId' => $data['eselonId'],
            'eselonLevel' => $data['eselonLevel'],
            'instansiIndukId' => $data['instansiIndukId'],
            'instansiIndukNama' => $data['instansiIndukNama'],
            'instansiKerjaId' => $data['instansiKerjaId'],
            'instansiKerjaKodeCepat' => $data['instansiKerjaKodeCepat'],
            'jabatanAsn' => $data['jabatanAsn'],
            'jabatanFungsionalId' => $data['jabatanFungsionalId'],
            'jabatanFungsionalNama' => $data['jabatanFungsionalNama'],
            'jabatanFungsionalUmumId' => $data['jabatanFungsionalUmumId'],
            'jabatanFungsionalUmumNama' => $data['jabatanFungsionalUmumNama'],
            'jabatanStrukturalId' => $data['jabatanStrukturalId'],
            'jabatanStrukturalNama' => $data['jabatanStrukturalNama'],
            'jenisJabatanId' => $data['jenisJabatanId'],
            'satuanKerjaIndukId' => $data['satuanKerjaIndukId'],
            'satuanKerjaIndukNama' => $data['satuanKerjaIndukNama'],
            'satuanKerjaKerjaId' => $data['satuanKerjaKerjaId'],
            'satuanKerjaKerjaNama' => $data['satuanKerjaKerjaNama'],
            'tmtEselon' => $formatDate($data['tmtEselon']),
            'unorId' => $data['unorId'],
            'unorIndukId' => $data['unorIndukId'],
            'gajiPokok' => $data['gajiPokok'],
            'tmtCpns' => $formatDate($data['tmtCpns']),
            'nomorSkCpns' => $data['nomorSkCpns'],
            'tglSkCpns' => $formatDate($data['tglSkCpns']),
            'noSpmt' => $data['noSpmt'],
            'skck' => $data['skck'],
            'tglSkck' => $formatDate($data['tglSkck']),
            'noSuratKeteranganBebasNarkoba' => $data['noSuratKeteranganBebasNarkoba'],
            'tglSuratKeteranganBebasNarkoba' => $formatDate($data['tglSuratKeteranganBebasNarkoba']),
            'jumlahAnak' => $data['jumlahAnak'],
            'status_singkron' => '1', // sukses
            'sync_date' => date('Y-m-d H:i:s'),
            'pegawai_id' => $pegawai_id
        );

        // Cek apakah data sudah ada
        $this->db->where('id', $data['id']);
        $existing = $this->db->get('data_utama')->row();

        if ($existing) {
            // Update data yang sudah ada
            $this->db->where('id', $data['id']);
            $result = $this->db->update('data_utama', $insert_data);
            $action = 'updated';
        } else {
            // Insert data baru
            $result = $this->db->insert('data_utama', $insert_data);
            $action = 'inserted';
        }
        return array('success' => $result, 'action' => $action);
    }
}
