<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_ws2 extends SB_Controller
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

        // $this->sso_token = $this->apimodel->getSsoToken();
    }

    public function coba()
    {
        echo "coba aja yuhu";
    }

    public function syncTabelSingkronSiasn()
    {
        $this->db->trans_begin();

        try {

            /* ============================
         * 1. INSERT / UPDATE
         * ============================ */
            $sqlUpsert = "
            INSERT INTO singkron_siasn (pegawai_id, nip_baru, status_pegawai)
            SELECT 
                p.PEGAWAI_ID,
                p.NIP_BARU,
                p.STATUS_PEGAWAI
            FROM pegawai p
            WHERE p.STATUS_PEGAWAI IN (1,2,10,18)
            ON DUPLICATE KEY UPDATE
                nip_baru       = VALUES(nip_baru),
                status_pegawai = VALUES(status_pegawai)
        ";
            $this->db->query($sqlUpsert);

            /* ============================
         * 2. DELETE data tidak valid
         * ============================ */
            $sqlDelete = "
            DELETE s
            FROM singkron_siasn s
            LEFT JOIN pegawai p 
                ON p.PEGAWAI_ID = s.pegawai_id
                AND p.STATUS_PEGAWAI IN (1,2,10,18)
            WHERE p.PEGAWAI_ID IS NULL
        ";
            $this->db->query($sqlDelete);

            /* ============================
         * VALIDASI TRANSAKSI
         * ============================ */
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal sinkronisasi data');
            }

            $this->db->trans_commit();

            // =============================
            // OUTPUT SUKSES
            // =============================
            echo json_encode([
                'success' => true,
                'message' => 'Sinkronisasi singkron_siasn BERHASIL'
            ]);
            return;
        } catch (Exception $e) {

            $this->db->trans_rollback();

            log_message('error', 'syncSingkronSiasn error: ' . $e->getMessage());

            // =============================
            // OUTPUT GAGAL
            // =============================
            echo json_encode([
                'success' => false,
                'message' => 'Sinkronisasi GAGAL',
                'error'   => $e->getMessage()
            ]);
            return;
        }
    }

    public function updateRiwayatCronjob()
    {

        if (isset($_GET['nama_cronjob'])) {
            $nama_cronjob = $_GET['nama_cronjob'];
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'nama_cronjob wajib diisi',
                'kode'    => ''
            ]);
            exit();
        }
        // generate yyyymmddhhmm (contoh: 202601150742)
        $kode = date('YmdHi');

        $this->db->where('nama_cronjob', $nama_cronjob);
        $this->db->set('kode', $kode);
        $update = $this->db->update('riwayat_cronjob');

        if ($update && $this->db->affected_rows() > 0) {

            echo json_encode([
                'success' => true,
                'message' => 'Update riwayat_cronjob berhasil',
                'kode'    => $kode
            ]);
        } else {

            echo json_encode([
                'success' => false,
                'message' => 'Update riwayat_cronjob gagal atau data tidak berubah atau nam_cronjob tidak ditemukan',
                'kode'    => $kode
            ]);
        }
    }

    private function _safeDate($date)
    {
        if (empty($date) || $date == '01-01-0001') {
            return null;
        }

        return date('Y-m-d', strtotime($date));
    }


    public function loopSingkronSiasnRwKursus()
    {
        header('Content-Type: text/html; charset=utf-8');
        // ambil kode cron
        $kodeCron = $this->db->select('kode')
            ->from('riwayat_cronjob')
            ->where('nama_cronjob', 'cek_riwayat_kursus')
            ->get()
            ->row('kode');

        if (!$kodeCron) {
            echo "Kode cron tidak ditemukan<br>";
            return;
        }

        $sql = "
        SELECT ss.*
        FROM singkron_siasn ss
        WHERE ss.status_pegawai IN ('1','2','10','18') AND (ss.get_rw_kursus <> ?
           OR ss.get_rw_kursus IS NULL) order by ss.nip_baru DESC ";

        $query = $this->db->query($sql, [$kodeCron]);

        if ($query->num_rows() == 0) {
            echo "Tidak ada data yang perlu diproses.<br>";
            return;
        }

        $total = $success = $failed = 0;

        foreach ($query->result() as $row) {
            $total++;

            echo "<b>Proses:</b> Pegawai ID: {$row->pegawai_id} | NIP: {$row->nip_baru}<br>";

            try {

                $response = $this->get_siasn(
                    $this->api_mws_token,
                    '/pns/rw-kursus/',
                    $row->nip_baru,
                    'GET'
                );

                /**
                 * NORMALISASI RESPONSE
                 */
                if (is_string($response)) {
                    $decoded = json_decode($response, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $response = $decoded;
                    }
                }

                if (is_object($response)) {
                    $response = json_decode(json_encode($response), true);
                }


                // ===== VALIDASI =====
                $v = 1;
                $dataSiasn = $response['data'] ?? null;

                if ($dataSiasn === null) {
                    echo "<i>Tidak ada data kursus SIASN</i><br>";
                    echo $response['data'];

                    $v = 0;
                    /** -------------------------
                     * UPDATE STATUS SINGKRON
                     * ------------------------*/
                    $this->db->where('pegawai_id', $row->pegawai_id)
                        ->update('singkron_siasn', [
                            'get_rw_kursus' => $kodeCron
                        ]);
                    // return;
                } else if ((int)$response['code'] !== 1) {
                    $v = 0;
                    throw new Exception('Response SIASN code != 1');
                } else if (!is_array($response)) {
                    $v = 0;
                    throw new Exception('Response SIASN bukan array');
                } else if (!is_array($dataSiasn)) {
                    $v = 0;
                    throw new Exception('Data SIASN bukan array');
                } else if (!array_key_exists('code', $response)) {
                    $v = 0;
                    throw new Exception('Response SIASN tidak memiliki code');
                } else if (count($dataSiasn) === 0) {
                    $v = 0;
                    echo "<i>Riwayat kursus kosong</i><br>";
                    return;
                }


                if ($v == 1) {
                    $dataSiasn = $response['data'];
                    $siasnIds  = [];

                    /** -------------------------
                     * UPSERT DATA SIASN
                     * ------------------------*/
                    foreach ($dataSiasn as $rwkursus) {

                        if (!isset($rwkursus['id'])) {
                            continue; // data rusak → skip baris ini
                        }
                        $siasnIds[] = $rwkursus['id'];

                        $payload = [
                            'PEGAWAI_ID' => $row->pegawai_id,
                            'kursus_id_siasn'   => $rwkursus['id'],

                            'pnsOrangId' => $rwkursus['idPns'],
                            'jenisDiklatId' => $rwkursus['jenisDiklatId'],
                            'jenisKursus' => $rwkursus['jenisKursusId'],
                            'jenisKursusNama' => $rwkursus['jenisKursusNama'],
                            'jenisKursusSertipikat' => $rwkursus['jenisKursusSertifikat'],

                            'namaKursus' => $rwkursus['namaKursus'],
                            'institusiPenyelenggara' => $rwkursus['institusiPenyelenggara'],
                            'nomorSertipikat' => $rwkursus['noSertipikat'],
                            'tanggalKursus' => $this->_safeDate($rwkursus['tanggalSelesaiKursus']),
                            'tanggalSelesaiKursus' => $this->_safeDate($rwkursus['tanggalKursus']),
                            'tahunKursus' => $rwkursus['tahunKursus'],
                            'jumlahJam' => $rwkursus['jumlahJam'],

                            'insert_date' => $this->_safeDate($rwkursus['createdAt']),
                            'udpate_date' => $this->_safeDate($rwkursus['updatedAt']),

                            'path' => $rwkursus['path']
                                ? json_encode($rwkursus['path'])
                                : null,
                        ];

                        // cek existing
                        $exists = $this->db->get_where(
                            'kursus_riwayat',
                            [
                                'pegawai_id' => $row->pegawai_id,
                                'kursus_id_siasn'   => $rwkursus['id']
                            ]
                        )->row();

                        if ($exists) {
                            $this->db->where('kursus_id_siasn', $exists->kursus_id_siasn)
                                ->update('kursus_riwayat', $payload);
                        } else {
                            $this->db->insert('kursus_riwayat', $payload);
                        }
                    }

                    /** -------------------------
                     * DELETE DATA YANG SUDAH TIDAK ADA DI SIASN
                     * ------------------------*/
                    if (!empty($siasnIds)) {
                        $this->db->where('pegawai_id', $row->pegawai_id)
                            ->where_not_in('kursus_id_siasn', $siasnIds)
                            ->where('messageFile IS NOT NULL', null, false)
                            ->delete('kursus_riwayat');
                    }

                    /** -------------------------
                     * UPDATE STATUS SINGKRON
                     * ------------------------*/
                    $this->db->where('pegawai_id', $row->pegawai_id)
                        ->update('singkron_siasn', [
                            'get_rw_kursus' => $kodeCron
                        ]);

                    $success++;
                    echo "<span style='color:green;'>✓ Sukses sinkron</span><br>";
                } else if ($v == 0) {
                    $success++;
                }
            } catch (Exception $e) {

                $failed++;
                echo "<span style='color:red;'>✗ Gagal: {$e->getMessage()}</span><br>";
            }


            echo "<hr>";
            ob_flush();
            flush();
        }

        echo "<br><b>SUMMARY</b><br>";
        echo "Total diproses : $total<br>";
        echo "Berhasil       : <span style='color:green;'>$success</span><br>";
        echo "Gagal          : <span style='color:red;'>$failed</span><br>";
    }




    public function getTestingWSSiasn()
    {
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        @ini_set('output_buffering', 'off');
        @ini_set('zlib.output_compression', false);
        @ini_set('implicit_flush', true);
        ob_implicit_flush(true);
        ob_end_flush();

        if (isset($_GET['nip'])) {
            $nip = $_GET['nip'];
        }
        if (isset($_GET['ws'])) {
            $ws = $_GET['ws'];
        }
        if (isset($_GET['HttpMethod'])) {
            $HttpMethod = $_GET['HttpMethod'];
        }

        $sql1 = "SELECT p.pegawai_id, p.nip_baru 
        FROM pegawai AS p 
        WHERE p.status_pegawai IN ('1','2','10','18') 
        AND p.nip_baru = '$nip'
        ORDER BY p.pegawai_id";

        $result1 = $this->db->query($sql1);

        if ($result1->num_rows() == 0) {
            echo "<span style='color:red;'>
            Data pegawai dengan NIP <b>$nip</b> tidak ditemukan
          </span><br>";
            return; // hentikan fungsi
        }


        if ($result1->num_rows() > 0) {
            $total = $success = $failed = 0;

            foreach ($result1->result() as $row) {
                $nip_baru = $row->nip_baru;
                $pegawai_id = $row->pegawai_id;
                $total++;

                echo "<b>Mulai cek WS<br> $ws$nip</b><br><br>" . PHP_EOL;

                try {
                    $response = $this->get_siasn($this->api_mws_token, $ws, $nip_baru, $HttpMethod);
                    print_r($response);
                } catch (Exception $e) {
                    $failed++;
                    echo "<span style='color:red;'>✗ Error: {$e->getMessage()}</span><br>";
                }
                // $this->update_proses_cronjob($pegawai_id, 'cek riwayat angka kredit', $response_data['message']);
                echo "<br><br><b>--- Selesai cek : $pegawai_id ---</b><br><br>" . PHP_EOL;
                // ob_flush();
                flush();
            }

            echo "<br><b>Summary:</b><br>";
            echo "Total diproses: $total<br>";
            echo "Berhasil: <span style='color:green;'>$success</span><br>";
            echo "Gagal: <span style='color:red;'>$failed</span><br>";
            echo "<b>Selesai kirim semua data.</b>";
        } else {
            echo "Tidak ada data yang perlu dikirim.";
        }

        // ob_flush();
        flush();
    }



    public function download_file_ak_all()
    {
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        @ini_set('output_buffering', 'off');
        @ini_set('zlib.output_compression', false);
        @ini_set('implicit_flush', true);
        ob_implicit_flush(true);
        ob_end_flush();

        $sql1 = "select * from riwayat_angka_kredit as r 
        where (r.dok_uri is not null and r.dok_uri != '') 
        and (r.FILE_PDF is null or r.FILE_PDF = '') 
        order by r.dok_uri";

        $result1 = $this->db->query($sql1);

        if ($result1->num_rows() > 0) {
            // $total = $success = $failed = 0;

            foreach ($result1->result() as $row) {
                $id = $row->riwayat_angka_kredit_id;

                echo "<b>Mulai GET data riwayat angka kredit :</b> $row->PEGAWAI_ID<br>" . PHP_EOL;
                $this->download_pdf($id);
                // $total++;
                echo "<br>--------------<br><br>";
            }
        }
        echo "<b>Selesai kirim semua data.</b>";
    }



    public function update_proses_cronjob($pegawai_id, $nama_cronjob, $hasil_cronjob)
    {
        $now = date('Y-m-d H:i:s'); // format: 2025-09-19 14:23:45

        $sql = "
        UPDATE riwayat_cronjob AS r
        SET 
            r.tanggal_eksekusi = ?,
            r.pegawai_id = ?,
            r.hasil_cronjob = ?
        WHERE r.nama_cronjob = '" . $nama_cronjob . "'";

        $result = $this->db->query($sql, [$now, $pegawai_id, $hasil_cronjob]);

        // Mengembalikan hasil sukses / gagal
        if ($result) {
            return [
                'status' => true,
                'message' => 'Update berhasil dilakukan'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Update gagal dilakukan'
            ];
        }
    }

    public function download_pdf($id)
    {
        // $id = '16';
        // ambil data lengkap berdasarkan ID (riwayat_angka_kredit_id)
        $this->db->select('p.NIP_BARU, r.*');
        $this->db->from('riwayat_angka_kredit r');
        $this->db->join('pegawai p', 'r.PEGAWAI_ID = p.PEGAWAI_ID', 'left');
        $this->db->where('r.riwayat_angka_kredit_id', $id);

        $row = $this->db->get()->row();

        if (!$row) {
            echo "Data tidak ditemukan";
            return;
        }

        // ambil nilai dari objek row
        $filePath = $row->dok_uri;   // contoh: peremajaan/usulan/xxx.pdf
        $nip      = $row->NIP_BARU;   // nip baru pegawai
        $skDate      = $row->skDate;   // nip baru pegawai

        echo "<br>" . $filePath . "<br>";


        // ambil token API dari session
        // $api_mws_token = $this->session->userdata('token_apimws');

        // panggil fungsi download ke SIASN
        $fileContent = $this->get_file_siasn($this->api_mws_token, $filePath);

        // CEK: jika kosong atau sangat kecil
        if (!$fileContent || strlen($fileContent) < 5000) {
            echo "File gagal diunduh atau terlalu kecil.";
            return;
        }

        // CEK: apakah error JSON?
        if (strpos($fileContent, '{') === 0) {
            echo "Terjadi error dari server SIASN.";
            return;
        }

        // CEK: file harus mulai dengan %PDF-
        if (substr($fileContent, 0, 5) !== "%PDF-") {
            echo "Respons bukan PDF valid.";
            return;
        }

        // cek apakah respons valid
        if (!$fileContent || strlen($fileContent) < 100) {
            echo "Gagal mengambil file dari SIASN";
            return;
        }

        $tanggal_jam = date('YmdHis');

        // tentukan nama file lokal
        $newFilename = "ANGKAKREDIT_" . $nip . "_" . $skDate . "_" . $tanggal_jam . ".pdf";

        // direktori penyimpanan
        // $savePath = FCPATH . "uploads/ak_pdf/" . $newFilename;
        $savePath = FCPATH . "./dokumen/" . $nip . "/" . $newFilename;

        // pastikan folder ada
        if (!is_dir(FCPATH . "./dokumen/" . $nip . "/")) {
            mkdir(FCPATH . "./dokumen/" . $nip . "/", 0777, true);
        }

        // simpan file
        file_put_contents($savePath, $fileContent);

        // jika ingin langsung download ke user
        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment; filename="' . $newFilename . '"');
        // echo $fileContent;

        //dokumen/197206082008012015/05_riwayat_jabatan_16.pdf

        echo "File berhasil disimpan ke: " . $savePath;
        // ====== UPDATE DATABASE ======
        $this->db->where('riwayat_angka_kredit_id', $id);
        $this->db->update('riwayat_angka_kredit', [
            'FILE_PDF' => "/dokumen/" . $nip . "/" . $newFilename
        ]);
        return;
    }



    public function download_pdf_kusus($filePath, $skDate, $nip, $namafile, $lokasi_folder, $nama)
    {
        // $id = '16';
        // ambil data lengkap berdasarkan ID (riwayat_angka_kredit_id)
        // $this->db->select('p.NIP_BARU, r.*');
        // $this->db->from('riwayat_angka_kredit r');
        // $this->db->join('pegawai p', 'r.PEGAWAI_ID = p.PEGAWAI_ID', 'left');
        // $this->db->where('r.riwayat_angka_kredit_id', $id);

        // $row = $this->db->get()->row();

        // if (!$row) {
        //     echo "Data tidak ditemukan";
        //     return;
        // }

        // ambil nilai dari objek row
        // $filePath = $row->dok_uri;   // contoh: peremajaan/usulan/xxx.pdf
        // $nip      = $row->NIP_BARU;   // nip baru pegawai
        // $skDate      = $row->skDate;   // nip baru pegawai

        echo "<br>" . $filePath . "<br>";


        // ambil token API dari session
        // $api_mws_token = $this->session->userdata('token_apimws');

        // panggil fungsi download ke SIASN
        $fileContent = $this->get_file_siasn($this->api_mws_token, $filePath);

        // CEK: jika kosong atau sangat kecil
        if (!$fileContent || strlen($fileContent) < 5000) {
            echo "File gagal diunduh atau terlalu kecil.";
            return;
        }

        // CEK: apakah error JSON?
        if (strpos($fileContent, '{') === 0) {
            echo "Terjadi error dari server SIASN.";
            return;
        }

        // CEK: file harus mulai dengan %PDF-
        if (substr($fileContent, 0, 5) !== "%PDF-") {
            echo "Respons bukan PDF valid.";
            return;
        }

        // cek apakah respons valid
        if (!$fileContent || strlen($fileContent) < 100) {
            echo "Gagal mengambil file dari SIASN";
            return;
        }

        $tanggal_jam = date('YmdHis');

        // tentukan nama file lokal
        // $newFilename = $namafile . "_" . $nip . "_" . $skDate . "_" . $tanggal_jam . "_" . $nama . ".pdf";
        $newFilename = $namafile . "_" . $nip . "_" . $skDate . "_" . $nama . ".pdf";

        // direktori penyimpanan
        // $savePath = FCPATH . "uploads/ak_pdf/" . $newFilename;
        $savePath = FCPATH . "./dokumen/" . $lokasi_folder . "/" . $newFilename;

        // pastikan folder ada
        if (!is_dir(FCPATH . "./dokumen/" . $lokasi_folder . "/")) {
            mkdir(FCPATH . "./dokumen/" . $lokasi_folder . "/", 0777, true);
        }

        // simpan file
        file_put_contents($savePath, $fileContent);

        // jika ingin langsung download ke user
        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment; filename="' . $newFilename . '"');
        // echo $fileContent;

        //dokumen/197206082008012015/05_riwayat_jabatan_16.pdf

        echo "File berhasil disimpan ke: " . $savePath;
        // ====== UPDATE DATABASE ======
        // $this->db->where('riwayat_angka_kredit_id', $id);
        // $this->db->update('riwayat_angka_kredit', [
        //     'FILE_PDF' => "/dokumen/" . $nip . "/" . $newFilename
        // ]);
        return;
    }



    //------------------------------------------------ API MWS BKN ------------------------------------------------//

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


    // $jenis_ws = '/pns/data-utama/';
    // $jenis_ws = '/pns/rw-angkakredit/';
    public function get_siasn($api_mws_token, $jenis_ws, $nip_baru, $HttpMethod)
    {
        // $api_mws_token = $this->session->userdata('token_apimws');
        // $sso_token = $this->session->userdata('token_sso');

        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0' . $jenis_ws . $nip_baru,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $HttpMethod,
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

    public function get_file_siasn($api_mws_token, $dok_uri)
    {
        // $api_mws_token = $this->session->userdata('token_apimws');
        // $sso_token = $this->session->userdata('token_sso');
        // echo "<br>" . 'https://apimws.bkn.go.id:8243/apisiasn/1.0/download-dok?filePath=' . $dok_uri . "<br>";

        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/download-dok?filePath=' . $dok_uri,
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

        // return $response;
        return $response;
    }


    public function setDataTerakhirjabatan()
    {

        $pegawai_ids = ['235754800042', '235754800031', '235753300008', '235759903441', '235759902863', '235759903424', '235751900030', '235759901034', '235750304668', '235752000125', '235759902180', '235759901673', '235759901750', '235754800045', '235759903534', '235751100053', '235750305158', '235753000006', '235759904595', '235759901941', '235759902138', '235751200033', '235759902168', '2357599042381', '2357599042372', '2357599042382', '235759902151', '235752800039', '235750100158', '235759901842', '235750100216', '235750100215', '235759902165', '235750100014', '235750100011', '235753400025', '235759903604', '235759903698', '235759903603', '235759904593', '235759904548', '235759902884', '235750700089', '235755500022', '235759902065', '235752600024', '235752000058', '235752600026', '235753300034', '235752400131', '235759901657', '235759901925', '235750200019', '235752600028', '235759902776', '235759902903', '235752100016', '235759901696', '235750100002', '235759902599', '235759902781', '235752800042', '235759901799', '235751600074', '235752800051', '235759902860', '235752800016', '235759902532', '235759902908', '235759902861', '235759902256', '235759902909', '235759901656', '235759903470', '235759903440', '235752800004', '235751900036', '235759903982', '235752900006', '235759902831', '235752000105', '235752000130', '235759901735', '235759903433', '235759904592', '235759904539', '235752900014', '235759904531', '2357599047559', '235759903602', '235759903983', '235759902174', '235759903981', '235759902011', '235752200041', '235759902786', '235751100183', '235752200043', '235751000025', '235751500051', '235752200040', '235752200025', '235759901605', '235751900031', '235759902028', '235752300023', '235759902676', '235752300024', '235750100012', '235752300025', '235754000016', '235753300046', '235759902113', '235752000146', '235759901711', '235750800026', '235759904533', '235759902133', '235759904409', '235759904353', '235759904534', '235759900001', '235752400102', '235752400029', '235751900025', '235759903437', '235759903469', '235753500035', '235751700016', '235751700022', '235759901752', '235759903413', '235759903004', '235750400412', '235759902774', '235759903434', '235750306383', '235750400237', '235759901837', '235759901836', '235750400597', '235750400373', '235755800058', '235750400527', '235759902357', '235750400238', '235759901833', '235759901822', '235750400236', '235759901819', '235755800298', '235750400410', '235759903447', '235750400324', '235759903540', '235759901603', '235759901828', '235750400156', '235750400155', '235755800163', '235759902215', '235759902874', '235759904549', '235759902263', '235759901584', '235759900261', '235759904355', '235759900005', '235750400260', '235759904598', '235759902725', '235750400169', '235750400376', '235759903605', '235750400431', '235759902500', '235759902445', '235759901621', '235759901622', '235759902341', '235759902799', '235759902267', '235759903638', '235759902488', '235750400328', '235750400332', '235759903649', '235759902685', '235759901567', '235750400506', '235759901876', '235759901625', '235759901620', '235759902404', '235759901574', '235759902279', '235759901597', '235759903678', '235750400478', '235759902882', '235759903062', '235759902873', '235750400345', '235759901839', '235759902427', '235750400603', '235759902797', '235750400600', '235759901881', '235759901616', '235759901613', '235750400601', '235750400604', '235759903736', '235750400605', '235759901636', '235759902408', '235759901588', '235759903753', '235759902486', '235759902484', '235759902485', '235759901587', '235759902483', '235759901602', '235759902504', '235750305848', '235759902505', '235750400432', '235759903779', '235755800213', '235755800147', '235759902214', '235759902208', '235759902259', '235759902251', '235759902679', '235759902265', '235755800207', '235755800170', '235755800171', '235755800164', '235755800251', '235755800122', '235755800183', '235759902261', '235755800267', '235755800279', '235755800178', '235755800220', '235755800215', '235755800239', '235755800166', '235755800214', '235759902238', '235751800039', '235755800209', '235755800274', '235755800247', '235755800246', '235755800186', '235755800226', '235755800184', '235755800222', '235759902260', '235755800219', '235755800212', '235755800211', '235755800210', '235755800238', '235755800185', '235759902249', '235759902253', '235755800237', '235755800223', '235759901649', '235755800012', '235755800221', '235755800257', '235755800260', '235755800208', '235755800216', '235755800294', '235759902163', '235755900051', '235759902097', '235759902167', '235755900054', '235759902155', '235759902171', '235755900024', '235755900053', '235759902156', '235759902158', '235759902152', '235755900056', '235759902135', '235759902143', '235759902160', '235755900048', '235759902150', '235755900039', '235759902137', '235759902516', '235759902175', '235755900055', '235759902164', '235759902141', '235759902148', '235759902136', '235755900040', '235759902154', '235750100024', '235751100187', '235752000065', '235750100025', '235759902049', '235759903415', '235759904576', '235752000163', '235750100161', '235750100017', '235751200034', '235751200031', '235751200026', '235759901671', '235759904596', '235759904591', '235759904587', '235759903070', '235759904590', '235752000118', '235759902827', '235759901780', '235753300020', '235750100137', '235753300032', '235752000151', '235752000165', '235753400011', '235752000101', '235752000153', '235752000128', '235752000042', '235752000168', '235753300017', '235753300066', '235752000089', '235752000158', '235759901790', '235752000178', '235750305571', '235752000170', '235752000177', '235753300026', '235752000166', '235752000079', '235752000217', '235752000171', '235753300062', '235752000184', '235752000137', '235752000136', '235753300021', '235752000076', '235759901798', '235752000102', '235752000083', '235752000082', '235752000121', '235752000080', '235759901797', '235752000087', '235752000169', '235752000160', '235752000067', '235752000129', '235752000209', '235752000214', '235752000085', '235752000174', '235759901795', '235752000176', '235751100180', '235759901792', '235752000208', '235759900881', '235752000120', '235759901791', '235752000110', '235752000113', '235751300023', '235752000127', '235752000161', '235752000210', '235752000159', '235759901801', '235752000135', '235751300004', '235759901805', '235751400047', '235759902166', '235752400106', '235759903932', '235759903947', '235759904571', '235752400095', '235752400087', '235759901670', '235752400133', '235752400043', '235752400097', '235752400039', '235752400040', '235752400042', '235752400112', '235752400103', '235752400117', '235752400049', '235752400139', '235752400135', '235752400003', '235752400121', '235752400030', '235752400100', '235752400129', '235759904535', '235752400094', '235752400104', '235752400109', '235752400085', '235752400101', '235752500077', '235752400098', '235752400034', '235759901639', '235752400113', '235752400022', '235752400027', '235752400016', '235752400088', '235752400108', '235752400105', '235752400031', '235752400033', '235752400036', '235752400128', '235752400122', '235752400110', '235752400048', '235752400041', '235752400001', '235759901676', '235759904536', '235759901817', '235750400340', '235751100170', '235751100163', '235751100179', '235759904569', '235751100052', '235751000049', '235752000157', '235752400083', '235750900121', '235750900119', '235750900131', '235750900137', '235751000045', '235759902782', '235752000112', '235751100169', '235752200021', '235751000026', '235759901753', '235759903423', '235759903419', '235759904543', '235752000072', '235751000038', '235759901793', '235759901755', '235751000050', '235751000048', '235759902687', '235759903539', '235755900050', '235759901633', '235759902794', '235759901816', '235751900008', '235755900052', '235750305840', '235750400579', '235759902543', '235759902287', '235759902914', '235752400114', '235752400137', '235750400137', '235750400308', '235759903952', '235759901827', '235751800017', '235750305518', '235750800030', '235759902830', '235750600040', '235759901834', '235759902178', '235752400127', '235759902059', '235754200014', '235759901882', '235750200002', '235759901778', '235759901751', '235752400130', '235750700096', '235759902916', '235759902915', '235751800035', '235751000039', '235759902875', '235759902902', '235759902785', '235750306114', '235750305578', '235759902864', '235750305849', '235750305853', '235750305533', '235750305562', '235750305880', '235750305879', '235759902881', '235759902910', '235750305847', '235750305517', '235759902769', '235750306115', '235750305850', '235750305579', '235759902805', '235750305577', '235750305560', '235750305855', '235750305844', '235759902801', '235759900962', '235750305883', '235750305890', '235750305574', '235750305858', '235750306043', '235759902770', '235750305889', '235750305561', '235750306054', '235750305842', '235759902626', '235759902773', '235750305558', '235759902778', '235750306030', '235750305854', '235750305551', '235759903414', '235750305157', '235759902880', '235759902828', '235750306459', '235750306361', '235759902315', '235750306508', '235750306278', '235750100186', '235750305757', '235750306252', '235750305566', '235750305903', '235750305871', '235750305818', '235130300037', '235130300038', '235750306516', '235750306515', '235759902829', '235750306220', '235750306229', '235750306509', '235759902559', '235750305739', '235750306392', '235750300185', '235750306279', '235750700098', '235759902274', '235759902698', '235750306461', '235750100179', '235750305877', '235759902628', '235750300184', '235759902779', '235750305783', '235759902629', '235759902636', '235759902765', '235750305829', '235750305878', '235750305781', '235759902713', '235759902716', '235759902702', '235750306495', '235750306100', '235759902878', '235750100190', '235750305864', '235750305822', '235750305867', '235750305823', '235750305824', '235750305755', '235750306212', '235750300380', '235750300381', '235750305552', '235759902359', '235759902538', '235754900027', '235759902616', '235750306200', '235750306421', '235759902649', '235750305573', '235750305817', '235759902652', '235759902804', '235759902646', '235750305866', '235750306143', '235750306140', '235750306505', '235750305812', '235759902677', '235750306506', '235750306504', '235759902579', '235759902575', '235750306507', '235759902247', '235759902912', '235750305554', '235750306204', '235750305748', '235759902330', '235759902905', '235750300118', '235750306496', '235759902917', '235750306510', '235759903398', '235759902534', '235750305870', '235759903931', '235753100006', '235751800043', '235751800036', '235750700072', '235750400357', '235751800034', '235751800031', '235751800046', '235751800044', '235750100169', '235759901759', '235753100008', '235751800042', '235751800033', '235751800032', '235751800045', '235751800040', '235752400138', '235750700068', '235750700105', '235750700103', '235750700077', '235750700088', '235750700070', '235750700023', '235750700054', '235750700058', '235750700051', '235750700081', '235750700045', '235750700101', '235759901756', '235750700093', '235759902184', '235750700050', '235750700079', '235750700064', '235750700052', '235750700071', '235750700086', '235750700066', '235750700087', '235750700056', '235750700053', '235750700100', '235750700057', '235750700094', '235759902927', '235750700001', '235750700048', '235750700063', '235750700074', '235751400048', '235759901789', '235759902613', '235759902495', '235759901773', '235752500089', '235752500009', '235751500058', '235751600028', '235751600017', '235751600036', '235759901765', '235751600060', '235751600072', '235751600043', '235759901746', '235759901742', '235751600059', '235751600046', '235751600064', '235751600045', '235759904529', '235759904542', '235759904545', '235759904530', '235759904572', '235751500052', '235751600047', '235751600067', '235751600057', '235751600053', '235751600063', '235751600075', '235759904486', '235759904369', '235752700024', '235753100004', '235759902055', '235751300003', '235750500021', '235750100026', '235750305845', '235759902031', '235750500023', '235752200044', '235755800252', '235753300060', '235759903843', '235759903842', '235750305512', '235755200003', '235753300033', '235752000111', '235759902680', '235752000207', '235753800004', '235753500001', '235759901902', '235759902669', '235759902017', '235759902085', '235759902090', '235759902098', '235759902105', '235759902107', '235759901924', '235753300063', '235753300050', '235753300049', '235755800007', '235754800002', '235752400004', '235755300017', '235752000187', '235759901892', '235759901907', '235759901970', '235752000117', '235759902009', '235753400027', '235759902025', '235750400363', '235752000041', '235754500018', '235754500012', '235752000164', '235754500025', '235754500026', '235754500019', '235759901911', '235759901912', '235753300001', '235759902047', '235759902006', '235759901914', '235752400038', '235759901913', '235759901984', '235752400123', '235754400018', '235759902475', '235759901674', '235759902601', '235759901967', '235759902477', '235759902069', '235750306020', '235752000070', '235754800032', '235750305868', '235750305686', '235750304127', '235755800218', '235759901635', '235750100035', '235759901931', '235752000145', '235752400023', '235759902476', '235759901949', '235759901961', '235759902780', '235750800023', '235750305550', '235753900017', '235759902048', '235750600042', '235753900018', '235759902176', '235753200001', '235752400119', '235759902007', '235752000077', '235759902026', '235754100018', '235759901073', '235753300023', '235759902035', '235752000150', '235753800001', '235752000144', '235752000095', '235759901979', '235759902479', '235750100170', '235759902682', '235755500002', '235752000216', '235759901962', '235759902673', '235750700060', '235752000147', '235750306112', '235759902046', '235759903587', '235759901926', '235759901958', '235759901999', '235752400107', '235755800227', '235752000215', '235759903989', '235759902771', '235753700004', '235754700032', '235753700005', '235759902029', '235750305882', '235759902054', '235759902015', '235754000014', '235759902012', '235759902033', '235759902030', '235759902118', '235750303931', '235759902040', '235759902179', '235750100219', '235759902764', '235759901794', '235752000155', '235750305839', '235759902021', '235754300009', '235750305535', '235755300016', '235759901900', '235759901901', '235759902883', '235755300018', '235752000175', '235759902027', '235753400028', '235750100008', '235753500009', '235759902072', '235759902078', '235759902082', '235752000179', '235750305528'];

        $this->db->trans_start();

        foreach ($pegawai_ids as $pegawai_id) {

            $pegawai_id = trim($pegawai_id);

            echo "<b>Proses Pegawai ID: {$pegawai_id}</b><br>";

            // Query cek jabatan terakhir
            $query = $this->db->query("SELECT 
        j.JABATAN_RIWAYAT_ID, 
        j.SATKER_ID, 
        j.FLAG_DATA_TERAKHIR, 
        j.KETERANGAN_BUP, 
        j.JENIS_JABATAN_SAPK, 
        j.jenisMutasiId, 
        DATE_FORMAT(
            DATE_ADD(
                DATE_ADD(p.TANGGAL_LAHIR, INTERVAL j.KETERANGAN_BUP YEAR),
                INTERVAL 1 MONTH
            ), '%Y-%m-01'
        ) AS TMT_PENSIUN
    FROM jabatan_riwayat AS j
    JOIN pegawai AS p ON p.PEGAWAI_ID = j.PEGAWAI_ID
    WHERE j.PEGAWAI_ID = '" . $pegawai_id . "'
    ORDER BY j.TANGGAL_SK DESC 
    LIMIT 1");

            $error_no  = $this->db->_error_number();
            $error_msg = $this->db->_error_message();

            if ($error_no != 0) {
                echo "❌ Query gagal: " . $error_msg . "<br><hr>";
                continue;
            }

            $result = $query->row();

            if (!$result) {
                echo "⚠️ Tidak ada data jabatan_riwayat<br><hr>";
                continue;
            }

            if ($result->FLAG_DATA_TERAKHIR == 0) {

                // reset flag
                $this->db->query("UPDATE jabatan_riwayat 
        SET FLAG_DATA_TERAKHIR = 0 
        WHERE PEGAWAI_ID = '" . $pegawai_id . "'");

                $error_no  = $this->db->_error_number();
                $error_msg = $this->db->_error_message();

                if ($error_no != 0) {
                    echo "❌ Gagal reset FLAG_DATA_TERAKHIR: " . $error_msg . "<br><hr>";
                    continue;
                }

                // set jabatan terakhir
                $this->db->query("UPDATE jabatan_riwayat 
        SET FLAG_DATA_TERAKHIR = 1 
        WHERE JABATAN_RIWAYAT_ID = '" . $result->JABATAN_RIWAYAT_ID . "'");

                $error_no  = $this->db->_error_number();
                $error_msg = $this->db->_error_message();

                if ($error_no != 0) {
                    echo "❌ Gagal set FLAG_DATA_TERAKHIR=1: " . $error_msg . "<br><hr>";
                    continue;
                }

                // mapping tipe pegawai
                $tipe_pegawai = null;

                if ($result->JENIS_JABATAN_SAPK == 1) {
                    $tipe_pegawai = 11;
                } elseif ($result->JENIS_JABATAN_SAPK == 2) {
                    $tipe_pegawai = 2;
                } elseif ($result->JENIS_JABATAN_SAPK == 4) {
                    $tipe_pegawai = 12;
                }

                // update pegawai
                $this->db->query("UPDATE pegawai AS p 
        SET 
            p.TIPE_PEGAWAI_ID = '" . $tipe_pegawai . "',
            p.TANGGAL_PENSIUN = '" . $result->TMT_PENSIUN . "',
            p.JABATAN_ID_TERAKHIR = '" . $result->JABATAN_RIWAYAT_ID . "'
        WHERE p.PEGAWAI_ID = '" . $pegawai_id . "'");

                $error_no  = $this->db->_error_number();
                $error_msg = $this->db->_error_message();

                if ($error_no != 0) {
                    echo "❌ Gagal update pegawai: " . $error_msg . "<br><hr>";
                } else {
                    echo "✅ Berhasil update jabatan terakhir<br><hr>";
                }
            } else {

                echo "ℹ️ FLAG_DATA_TERAKHIR sudah benar<br><hr>";
            }
        }

        $this->db->trans_complete();
    }
}
