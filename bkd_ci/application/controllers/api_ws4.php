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

    public function sync_data_utama_batch($limit = 50, $batastolreansi = 15)
    {
        echo "================================ mulai ambil data utama " . date('Y-m-d H:i:s') . " ================================\n\n";

        $token = $this->api_mws_token;

        $pegawai = $this->db
            ->where('flag_data_utama', 1)
            ->where_in('statusPegawai', ['PNS', 'CPNS', 'PPPK', 'PPPK PARUH WAKTU'])
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

    public function coba()
    {
        echo "coba";
    }


    public function sync_rw_golongan_batch($limit = 50, $batastolreansi = 15)
    {
        echo "================================ mulai ambil rw golongan " . date('Y-m-d H:i:s') . " ================================\n\n";

        $token = $this->api_mws_token;

        $pegawai = $this->db
            ->where('golongan', 1)
            ->where_in('statusPegawai', ['PNS', 'CPNS', 'PPPK', 'PPPK PARUH WAKTU'])
            ->where('retry_count_golongan <', $batastolreansi)
            ->order_by('id')
            ->limit($limit)
            ->get('siasnpegawaiid')
            ->result();

        foreach ($pegawai as $p) {

            echo "\nSedang diproses : {$p->nip}";

            $json = $this->get_golongan($token, $p->nip);

            $retry = $p->retry_count_golongan + 1;

            /**
             * 1. Response kosong
             */
            if (empty($json)) {
                $this->db
                    ->where('id', $p->id)
                    ->update('siasnpegawaiid', array(
                        'golongan'       => ($retry >= $batastolreansi ? 3 : 1),
                        'retry_count_golongan' => $retry
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
                        'golongan'       => ($retry >= $batastolreansi ? 3 : 1),
                        'retry_count_golongan' => $retry
                    ));
                echo " ==> JSON tidak valid ({$retry}/{$batastolreansi})";
                continue;
            }

            /**
             * 3. Response sukses dari SIASN
             */
            if (isset($response['code']) && $response['code'] == 1) {

                // Panggil fungsi sinkronisasi dan tangkap return value
                $save = $this->SingkronGolonganBkn($p->pegawai_id);

                if ($save['success']) {
                    $this->db
                        ->where('id', $p->id)
                        ->update('siasnpegawaiid', array(
                            'golongan'       => 0,
                            'retry_count_golongan' => 0
                        ));
                    echo " ==> SUKSES (Insert: {$save['inserted']}, Update: {$save['updated']})";
                } else {
                    $this->db
                        ->where('id', $p->id)
                        ->update('siasnpegawaiid', array(
                            'golongan'       => ($retry >= $batastolreansi ? 3 : 1),
                            'retry_count_golongan' => $retry
                        ));
                    echo " ==> Gagal menyimpan data: {$save['message']}";
                }
                continue;
            }

            /**
             * 4. Response gagal dari SIASN
             */
            $this->db
                ->where('id', $p->id)
                ->update('siasnpegawaiid', array(
                    'golongan'       => ($retry >= $batastolreansi ? 3 : 1),
                    'retry_count_golongan' => $retry
                ));

            $pesan = isset($response['message']) ? $response['message'] : 'Unknown Error';
            echo " ==> GAGAL ({$retry}/{$batastolreansi}) : {$pesan}";
        }

        echo "\n\n================================ selesai ambil rw golongan " . date('Y-m-d H:i:s') . " ================================\n";
    }

    public function SingkronGolonganBkn($peg_id)
    {
        $result = [
            'success' => false,
            'message' => '',
            'total' => 0,
            'inserted' => 0,
            'updated' => 0
        ];

        if (empty($peg_id)) {
            $result['message'] = 'Parameter pegawai_id wajib diisi.';
            return $result;
        }

        // Cek data pegawai
        $data_peg = $this->db->get_where('pegawai', ['pegawai_id' => $peg_id])->row();
        if (!$data_peg) {
            $result['message'] = 'Pegawai tidak ditemukan.';
            return $result;
        }

        // Panggil web service SIASN
        $golonganData = $this->get_golongan($this->api_mws_token, $data_peg->NIP_BARU);
        $data = json_decode($golonganData, true);

        if (!isset($data['data']) || empty($data['data'])) {
            $result['message'] = $data['message'] ?? $data['description'] ?? 'Tidak ada data riwayat golongan dari SIASN.';
            return $result;
        }

        $total = 0;
        $inserted = 0;
        $updated = 0;

        foreach ($data['data'] as $golongan) {
            $total++;

            $siasn_id           = $golongan['id'];
            $pangkat_id         = $golongan['golonganId'];
            $tmt                = date('Y-m-d', strtotime($golongan['tmtGolongan']));
            $nipBaru            = $golongan['nipBaru'];
            $no_nota            = $golongan['noPertekBkn'] ?? '';
            $tgl_nota           = !empty($golongan['tglPertekBkn']) ? date('Y-m-d', strtotime($golongan['tglPertekBkn'])) : null;
            $no_sk              = $golongan['skNomor'] ?? '';
            $tgl_sk             = !empty($golongan['skTanggal']) ? date('Y-m-d', strtotime($golongan['skTanggal'])) : null;
            $mk_tahun           = $golongan['masaKerjaGolonganTahun'] ?? 0;
            $mk_bulan           = $golongan['masaKerjaGolonganBulan'] ?? 0;
            $jumlah_kredit_utama    = $golongan['jumlahKreditUtama'] ?? 0;
            $jumlah_kredit_tambahan = $golongan['jumlahKreditTambahan'] ?? 0;
            $jenis_kp_id        = $golongan['jenisKPId'] ?? null;
            $jenis_kp_nama      = $golongan['jenisKPNama'] ?? '';
            $idPns              = $golongan['idPns'] ?? '';
            // Ambil dok_uri jika ada
            $dok_uri = '';
            if (isset($golongan['path']) && is_array($golongan['path']) && !empty($golongan['path'])) {
                // Ambil dok_uri dari path pertama atau sesuai struktur
                $firstPath = reset($golongan['path']);
                $dok_uri = $firstPath['dok_uri'] ?? '';
            }

            // Cek existing
            $existing = $this->db->get_where('pangkat_riwayat', [
                'PANGKAT_ID' => $pangkat_id,
                'PEGAWAI_ID' => $peg_id
            ])->row();

            if ($existing) {
                // UPDATE
                $update_data = [
                    'PANGKAT_ID'            => $pangkat_id,
                    'NO_NOTA'               => $no_nota,
                    'TANGGAL_NOTA'          => $tgl_nota,
                    'NO_SK'                 => $no_sk,
                    'TANGGAL_SK'            => $tgl_sk,
                    'TMT_PANGKAT'           => $tmt,
                    'MASA_KERJA_TAHUN'      => $mk_tahun,
                    'MASA_KERJA_BULAN'      => $mk_bulan,
                    'JUMLAHKREDITUTAMA'     => $jumlah_kredit_utama,
                    'JUMLAHKREDITTAMBAHAN'  => $jumlah_kredit_tambahan,
                    'JENISKPID'             => $jenis_kp_id,
                    'JENISKPNAMA'           => $jenis_kp_nama,
                    'SIASN_PANGKAT_ID'      => $siasn_id,
                    'SIASN_IDPNS'           => $idPns,
                    'NIPBARU'               => $nipBaru,
                    'DOK_URI'               => $dok_uri,
                    'KETERANGAN'            => "UPDATE BY WS SIASN",
                    'TANGGAL_UPDATE'        => date('Y-m-d'),
                    'LAST_UPDATE_DATE'      => date('Y-m-d')
                ];
                $this->db->where('PANGKAT_ID', $pangkat_id)
                    ->where('PEGAWAI_ID', $peg_id)
                    ->update('pangkat_riwayat', $update_data);
                $updated++;
            } else {
                // INSERT
                $insert_data = [
                    'PEGAWAI_ID'            => $peg_id,
                    'PANGKAT_ID'            => $pangkat_id,
                    'NO_NOTA'               => $no_nota,
                    'TANGGAL_NOTA'          => $tgl_nota,
                    'NO_SK'                 => $no_sk,
                    'TANGGAL_SK'            => $tgl_sk,
                    'TMT_PANGKAT'           => $tmt,
                    'MASA_KERJA_TAHUN'      => $mk_tahun,
                    'MASA_KERJA_BULAN'      => $mk_bulan,
                    'JUMLAHKREDITUTAMA'     => $jumlah_kredit_utama,
                    'JUMLAHKREDITTAMBAHAN'  => $jumlah_kredit_tambahan,
                    'JENISKPID'             => $jenis_kp_id,
                    'JENISKPNAMA'           => $jenis_kp_nama,
                    'SIASN_PANGKAT_ID'      => $siasn_id,
                    'SIASN_IDPNS'           => $idPns,
                    'NIPBARU'               => $nipBaru,
                    'DOK_URI'               => $dok_uri,
                    'KETERANGAN'            => "INSERT BY WS SIASN",
                    'LAST_CREATE_DATE'      => date('Y-m-d')
                ];
                $this->db->insert('pangkat_riwayat', $insert_data);
                $inserted++;
            }
        }

        $result['success'] = true;
        $result['message'] = "Sinkronisasi selesai. Total data: $total, Insert: $inserted, Update: $updated";
        $result['total'] = $total;
        $result['inserted'] = $inserted;
        $result['updated'] = $updated;

        return $result;
    }


    public function get_golongan($api_mws_token, $nip_baru)
    {


        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/rw-golongan/' . $nip_baru,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Auth: bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA',
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

        return $response;
        // return $hasil;
    }
}
