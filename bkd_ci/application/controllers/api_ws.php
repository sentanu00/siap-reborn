<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_ws extends SB_Controller
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


    public function loopSingkronSiasnRwJabatan()
    {
        // ambil kode cron
        $kodeCron = $this->db->select('kode')
            ->from('riwayat_cronjob')
            ->where('nama_cronjob', 'cek_riwayat_jabatan')
            ->get()
            ->row('kode');

        if (!$kodeCron) {
            echo "Kode cron tidak ditemukan<br>";
            return;
        }

        $sql = "
        SELECT ss.*
        FROM singkron_siasn ss
        WHERE ss.status_pegawai IN ('1','2') AND (ss.get_rw_jabatan <> ?
           OR ss.get_rw_jabatan IS NULL) order by ss.nip_baru DESC ";

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
                    '/jabatan/pns/',
                    $row->nip_baru
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
                if (!is_array($response)) {
                    throw new Exception('Response SIASN bukan array');
                }

                if (!array_key_exists('code', $response)) {
                    throw new Exception('Response SIASN tidak memiliki code');
                }

                if ((int)$response['code'] !== 1) {
                    throw new Exception('Response SIASN code != 1');
                }

                $dataSiasn = $response['data'] ?? null;

                if ($dataSiasn === null) {
                    echo "<i>Tidak ada data jabatan SIASN</i><br>";
                    return;
                }

                if (!is_array($dataSiasn)) {
                    throw new Exception('Data SIASN bukan array');
                }

                if (count($dataSiasn) === 0) {
                    echo "<i>Riwayat jabatan kosong</i><br>";
                    return;
                }

                $dataSiasn = $response['data'];
                $siasnIds  = [];

                /** -------------------------
                 * UPSERT DATA SIASN
                 * ------------------------*/
                foreach ($dataSiasn as $jabatan) {

                    if (!isset($jabatan['id'])) {
                        continue; // data rusak → skip baris ini
                    }
                    $siasnIds[] = $jabatan['id'];

                    $payload = [
                        'pegawai_id' => $row->pegawai_id,
                        'siasn_id'   => $jabatan['id'],
                        'id_pns'     => $jabatan['idPns'],
                        'nip_baru'   => $jabatan['nipBaru'],
                        'nip_lama'   => $jabatan['nipLama'],
                        'jenis_jabatan' => $jabatan['jenisJabatan'],

                        'instansi_kerja_id'   => $jabatan['instansiKerjaId'],
                        'instansi_kerja_nama' => $jabatan['instansiKerjaNama'],

                        'satuan_kerja_id'   => $jabatan['satuanKerjaId'],
                        'satuan_kerja_nama' => $jabatan['satuanKerjaNama'],

                        'unor_id'         => $jabatan['unorId'],
                        'unor_nama'       => $jabatan['unorNama'],
                        'unor_induk_id'   => $jabatan['unorIndukId'],
                        'unor_induk_nama' => $jabatan['unorIndukNama'],

                        'jabatan_fungsional_id'   => $jabatan['jabatanFungsionalId'],
                        'jabatan_fungsional_nama' => $jabatan['jabatanFungsionalNama'],

                        'nama_jabatan' => $jabatan['namaJabatan'],
                        'nama_unor'    => $jabatan['namaUnor'],

                        'tmt_jabatan' => $this->_safeDate($jabatan['tmtJabatan']),
                        'tanggal_sk'  => $this->_safeDate($jabatan['tanggalSk']),
                        'nomor_sk'    => $jabatan['nomorSk'],

                        'path' => $jabatan['path']
                            ? json_encode($jabatan['path'])
                            : null,
                    ];

                    // cek existing
                    $exists = $this->db->get_where(
                        'riwayat_jabatan_siasn',
                        [
                            'pegawai_id' => $row->pegawai_id,
                            'siasn_id'   => $jabatan['id']
                        ]
                    )->row();

                    if ($exists) {
                        $this->db->where('id', $exists->id)
                            ->update('riwayat_jabatan_siasn', $payload);
                    } else {
                        $this->db->insert('riwayat_jabatan_siasn', $payload);
                    }
                }

                /** -------------------------
                 * DELETE DATA YANG SUDAH TIDAK ADA DI SIASN
                 * ------------------------*/
                if (!empty($siasnIds)) {
                    $this->db->where('pegawai_id', $row->pegawai_id)
                        ->where_not_in('siasn_id', $siasnIds)
                        ->delete('riwayat_jabatan_siasn');
                }

                /** -------------------------
                 * UPDATE STATUS SINGKRON
                 * ------------------------*/
                $this->db->where('pegawai_id', $row->pegawai_id)
                    ->update('singkron_siasn', [
                        'get_rw_jabatan' => $kodeCron
                    ]);

                $success++;
                echo "<span style='color:green;'>✓ Sukses sinkron</span><br>";
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


    public function loopSingkronSiasnRwKinerja()
    {
        // ambil kode cron
        $kodeCron = $this->db->select('kode')
            ->from('riwayat_cronjob')
            ->where('nama_cronjob', 'cek_riwayat_kinerja')
            ->get()
            ->row('kode');

        if (!$kodeCron) {
            echo "Kode cron tidak ditemukan<br>";
            return;
        }

        $sql = "
        SELECT ss.*
        FROM singkron_siasn ss
        WHERE ss.status_pegawai IN ('1','2','10') AND (ss.get_rw_kinerja <> ?
           OR ss.get_rw_kinerja IS NULL) order by ss.pegawai_id ASC ";

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
                    '/pns/rw-skp22/',
                    $row->nip_baru
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
                if (!is_array($response)) {
                    throw new Exception('Response SIASN bukan array');
                }

                if (!array_key_exists('code', $response)) {
                    throw new Exception('Response SIASN tidak memiliki code');
                }

                if ((int)$response['code'] !== 1) {
                    throw new Exception('Response SIASN code != 1');
                }

                $dataSiasn = $response['data'] ?? null;

                if ($dataSiasn === null) {
                    // echo "<i>Tidak ada data kinerja SIASN</i><br>";

                    throw new Exception('Tidak ada data kinerja SIASN');
                    // return;
                }

                if (!is_array($dataSiasn)) {
                    throw new Exception('Data SIASN bukan array');
                }

                if (count($dataSiasn) === 0) {
                    // echo "<i>Riwayat kinerja kosong</i><br>";

                    throw new Exception('Riwayat kinerja kosong');
                    // return;
                }

                $dataSiasn = $response['data'];
                $siasnIds  = [];

                /** -------------------------
                 * UPSERT DATA SIASN
                 * ------------------------*/
                foreach ($dataSiasn as $kinerja) {

                    if (!isset($kinerja['id'])) {
                        continue; // data rusak → skip baris ini
                    }
                    $siasnIds[] = $kinerja['id'];

                    $payload = [
                        'pegawai_id' => $row->pegawai_id,
                        'nip_baru'   => $row->nip_baru,
                        'tipe' => 'setahun',
                        'keterangan' => 'Tersinkron dengan SIASN',
                        'message' => 'success',
                        'path' => $kinerja['path']
                            ? json_encode($kinerja['path'])
                            : null,

                        'id' => $kinerja['id'],
                        'hasilKinerja' => $kinerja['hasilKinerja'],
                        'hasilKinerjaNilai' => $kinerja['hasilKinerjaNilai'],
                        'kuadranKinerja' => $kinerja['kuadranKinerja'],
                        'KuadranKinerjaNilai' => $kinerja['KuadranKinerjaNilai'],
                        'namaPenilai' => $kinerja['namaPenilai'],
                        'nipNrpPenilai' => $kinerja['nipNrpPenilai'],
                        'penilaiGolonganId' => $kinerja['penilaiGolonganId'],
                        'penilaiJabatanNm' => $kinerja['penilaiJabatanNm'],
                        'penilaiUnorNm' => $kinerja['penilaiUnorNm'],
                        'perilakuKerja' => $kinerja['perilakuKerja'],
                        'PerilakuKerjaNilai' => $kinerja['PerilakuKerjaNilai'],
                        'pnsDinilaiId' => $kinerja['pnsDinilaiId'],
                        'statusPenilai' => $kinerja['statusPenilai'],
                        'tahun' => $kinerja['tahun'],
                    ];

                    // cek existing
                    $exists = $this->db->get_where(
                        'skp22',
                        [
                            'pegawai_id' => $row->pegawai_id,
                            'tahun'   => $kinerja['tahun']
                        ]
                    )->row();

                    if ($exists) {
                        $this->db->where('pegawai_id', $exists->pegawai_id)
                            ->where('tahun', $exists->tahun)
                            ->update('skp22', $payload);
                    } else {
                        $this->db->insert('skp22', $payload);
                    }
                }

                /** -------------------------
                 * DELETE DATA YANG SUDAH TIDAK ADA DI SIASN
                 * ------------------------*/
                // if (!empty($siasnIds)) {
                //     $this->db->where('pegawai_id', $row->pegawai_id)
                //         ->where_not_in('tahun', $siasnIds)
                //         ->delete('skp22');
                // }

                /** -------------------------
                 * UPDATE STATUS SINGKRON
                 * ------------------------*/
                $this->db->where('pegawai_id', $row->pegawai_id)
                    ->update('singkron_siasn', [
                        'get_rw_kinerja' => $kodeCron
                    ]);

                $success++;
                echo "<span style='color:green;'>✓ Sukses sinkron</span><br>";
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


    public function getDataUtamaSiasn()
    {

        $sql1 = "SELECT p.pegawai_id, p.nip_baru 
         FROM pegawai AS p 
         WHERE p.pegawai_id > (
             SELECT MAX(r.pegawai_id) 
             FROM riwayat_cronjob AS r 
             WHERE r.nama_cronjob = 'cek profil pegawai'
         )
         AND p.status_pegawai IN ('1','2','10', '18') 
         ORDER BY p.pegawai_id";

        $result1 = $this->db->query($sql1);

        // Looping hasil query
        if ($result1->num_rows() > 0) {

            $total = 0;
            $success = 0;
            $failed = 0;

            foreach ($result1->result() as $row) {
                $nip_baru = $row->nip_baru;
                $pegawai_id = $row->pegawai_id;
                $total++;

                echo "<b>Mulai GET data utama:</b> $pegawai_id<br>" . PHP_EOL;

                // $this->get_data_utama($this->api_mws_token, $nip_baru);
                //ambil hasil dari fungsi ini dan tampilkan dlu


                try {
                    // Tangkap hasil return dari fungsi get_data_utama
                    $response = $this->get_data_utama($this->api_mws_token, $nip_baru);

                    // Decode JSON response
                    $response_data = json_decode($response, true);

                    if (json_last_error() === JSON_ERROR_NONE && isset($response_data['code']) && $response_data['code'] == 1) {

                        // Insert/Update ke database
                        $db_result = $this->insertOrUpdateDataUtama($response_data, $pegawai_id);

                        if ($db_result['success']) {
                            $success++;
                            echo "<span style='color: green;'>✓ Data berhasil di-" . $db_result['action'] . " ke database</span><br>";
                        } else {
                            $failed++;
                            echo "<span style='color: red;'>✗ Gagal menyimpan data ke database</span><br>";
                        }
                    } else {
                        $failed++;
                        echo "<span style='color: red;'>✗ Response API tidak valid</span><br>";
                        if (isset($response_data['message'])) {
                            echo "<span style='color: red;'>Pesan: " . $response_data['message'] . "</span><br>";
                        }
                    }
                } catch (Exception $e) {
                    $failed++;
                    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>";
                }


                echo "<br>--- Selesai GET data utama: $pegawai_id ---<br><br>" . PHP_EOL;
                ob_flush();
                flush(); // agar tampil realtime kalau via browser
                // sleep(1); // opsional: beri delay agar tidak overload
                // exit();
            }
            // Summary
            echo "<br><b>Summary:</b><br>";
            echo "Total diproses: $total<br>";
            echo "Berhasil: <span style='color: green;'>$success</span><br>";
            echo "Gagal: <span style='color: red;'>$failed</span><br>";
            echo "<b>Selesai kirim semua data.</b>";
        } else {
            echo "Tidak ada data yang perlu dikirim.";
        }

        // $now = date('Y-m-d'); // format: 2025-09-19 14:23:45

    }

    public function getDataUtamaParuhWaktuSiasn()
    {

        $sql1 = "SELECT p.pegawai_id, p.nip_baru 
         FROM pegawai AS p 
         WHERE p.pegawai_id > (
             SELECT MAX(r.pegawai_id) 
             FROM riwayat_cronjob AS r 
             WHERE r.nama_cronjob = 'cek profil pegawai paruh waktu'
         )
         AND p.status_pegawai IN ('18') 
         and p.pegawai_id in ('2357599051664')
         ORDER BY p.pegawai_id";

        $result1 = $this->db->query($sql1);

        // Looping hasil query
        if ($result1->num_rows() > 0) {

            $total = 0;
            $success = 0;
            $failed = 0;

            foreach ($result1->result() as $row) {
                $nip_baru = $row->nip_baru;
                $pegawai_id = $row->pegawai_id;
                $total++;

                echo "<b>Mulai GET data utama:</b> $pegawai_id<br>" . PHP_EOL;

                // $this->get_data_utama($this->api_mws_token, $nip_baru);
                //ambil hasil dari fungsi ini dan tampilkan dlu


                try {
                    // Tangkap hasil return dari fungsi get_data_utama
                    // $response = $this->get_data_utama($this->api_mws_token, $nip_baru);
                    $response = $this->get_siasn($this->api_mws_token, '/pns/data-utama/paruhwaktu/', $nip_baru);
                    print_r($response);
                    // Decode JSON response
                    $response_data = json_decode($response, true);

                    if (json_last_error() === JSON_ERROR_NONE && isset($response_data['code']) && $response_data['code'] == 1) {

                        // Insert/Update ke database
                        $db_result = $this->insertOrUpdateDataUtamaParuhWaktu($response_data, $pegawai_id);

                        if ($db_result['success']) {
                            $success++;
                            echo "<span style='color: green;'>✓ Data berhasil di-" . $db_result['action'] . " ke database</span><br>";
                        } else {
                            $failed++;
                            echo "<span style='color: red;'>✗ Gagal menyimpan data ke database</span><br>";
                        }
                    } else {
                        $failed++;
                        echo "<span style='color: red;'>✗ Response API tidak valid</span><br>";
                        if (isset($response_data['message'])) {
                            echo "<span style='color: red;'>Pesan: " . $response_data['message'] . "</span><br>";
                        }
                    }
                } catch (Exception $e) {
                    $failed++;
                    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>";
                }


                echo "<br>--- Selesai GET data utama: $pegawai_id ---<br><br>" . PHP_EOL;
                ob_flush();
                flush(); // agar tampil realtime kalau via browser
                // sleep(1); // opsional: beri delay agar tidak overload
                // exit();
            }
            // Summary
            echo "<br><b>Summary:</b><br>";
            echo "Total diproses: $total<br>";
            echo "Berhasil: <span style='color: green;'>$success</span><br>";
            echo "Gagal: <span style='color: red;'>$failed</span><br>";
            echo "<b>Selesai kirim semua data.</b>";
        } else {
            echo "Tidak ada data yang perlu dikirim.";

            $now = date('Y-m-d H:i:s'); // format: 2025-09-19 14:23:45
            $sql = "
        UPDATE riwayat_cronjob AS r
        SET 
            r.tanggal_eksekusi = ?,
            r.pegawai_id = ?,
            r.hasil_cronjob = ?
        WHERE r.nama_cronjob = 'cek profil pegawai paruh waktu'";

            $result = $this->db->query($sql, [$now, '0', '0']);
        }

        // $now = date('Y-m-d'); // format: 2025-09-19 14:23:45

    }


    public function getDataUtamaParuhWaktuSiasnbelakang()
    {

        $sql1 = "SELECT p.pegawai_id, p.nip_baru 
         FROM pegawai AS p 
         WHERE p.pegawai_id < (
             SELECT MAX(r.pegawai_id) 
             FROM riwayat_cronjob AS r 
             WHERE r.nama_cronjob = 'cek profil pegawai paruh waktu belakang'
         )
         AND p.status_pegawai IN ('18') 
         and p.pegawai_id in ('2357599051749','2357599051753','2357599051754','2357599051757','2357599051758','2357599051759','2357599051760','2357599051761','2357599051764','2357599051767','2357599051771','2357599051772','2357599051775','2357599051776','2357599051777','2357599051780','2357599051781','2357599051782','2357599051785','2357599051786','2357599051790','2357599051791','2357599051793','2357599051798','2357599051804','2357599051812','2357599051814','2357599051815','2357599051817','2357599051830','2357599051831','2357599051848','2357599051854','2357599051866','2357599051868','2357599051869','2357599051876','2357599051877','2357599051887','2357599051890','2357599051901','2357599051903','2357599051905','2357599051906','2357599051908','2357599051911','2357599051919','2357599051929','2357599051934','2357599051952','2357599051959','2357599051963','2357599051973','2357599052014','2357599052022','2357599052023','2357599052030','2357599052036','2357599052047','2357599052059','2357599052082','2357599052083','2357599052114','2357599052115','2357599052116','2357599052119','2357599052121','2357599052131','2357599052140','2357599052193','2357599052210','2357599052218','2357599052232','2357599052235','2357599052249','2357599052265','2357599052267','2357599052288','2357599052289','2357599052297','2357599052311','2357599052314','2357599052318','2357599052328','2357599052355','2357599052430','2357599052542','2357599052543','2357599052574','2357599052575','2357599052588','2357599052590','2357599052611','2357599052618','2357599052641','2357599052642','2357599052647','2357599052657','2357599052683','2357599052697','2357599052711','2357599052712','2357599052716','2357599052757','2357599052761','2357599052779','2357599052783','2357599052789','2357599052794','2357599052799','2357599052812','2357599052816','2357599052818','2357599052819','2357599052821','2357599052822','2357599052829','2357599052830','2357599052833','2357599052836','2357599052838','2357599052848','2357599052850','2357599052856','2357599052862','2357599052875','2357599052876','2357599052888','2357599052890','2357599052896','2357599052900','2357599052903','2357599052904','2357599052906','2357599052907','2357599052910','2357599052911','2357599052914','2357599052917','2357599052920','2357599052923','2357599052935','2357599052936','2357599052937','2357599052938','2357599052939','2357599052942','2357599052943','2357599052947','2357599052950','2357599052951','2357599052952','2357599052955','2357599052965','2357599053961')
         ORDER BY p.pegawai_id DESC";

        $result1 = $this->db->query($sql1);

        // Looping hasil query
        if ($result1->num_rows() > 0) {

            $total = 0;
            $success = 0;
            $failed = 0;

            foreach ($result1->result() as $row) {
                $nip_baru = $row->nip_baru;
                $pegawai_id = $row->pegawai_id;
                $total++;

                echo "<b>Mulai GET data utama:</b> $pegawai_id<br>" . PHP_EOL;

                // $this->get_data_utama($this->api_mws_token, $nip_baru);
                //ambil hasil dari fungsi ini dan tampilkan dlu


                try {
                    // Tangkap hasil return dari fungsi get_data_utama
                    // $response = $this->get_data_utama($this->api_mws_token, $nip_baru);
                    $response = $this->get_siasn($this->api_mws_token, '/pns/data-utama/paruhwaktu/', $nip_baru);
                    print_r($response);
                    // Decode JSON response
                    $response_data = json_decode($response, true);

                    if (json_last_error() === JSON_ERROR_NONE && isset($response_data['code']) && $response_data['code'] == 1) {

                        // Insert/Update ke database
                        $db_result = $this->insertOrUpdateDataUtamaParuhWaktuBelakang($response_data, $pegawai_id);

                        if ($db_result['success']) {
                            $success++;
                            echo "<span style='color: green;'>✓ Data berhasil di-" . $db_result['action'] . " ke database</span><br>";
                        } else {
                            $failed++;
                            echo "<span style='color: red;'>✗ Gagal menyimpan data ke database</span><br>";
                        }
                    } else {
                        $failed++;
                        echo "<span style='color: red;'>✗ Response API tidak valid</span><br>";
                        if (isset($response_data['message'])) {
                            echo "<span style='color: red;'>Pesan: " . $response_data['message'] . "</span><br>";
                        }
                    }
                } catch (Exception $e) {
                    $failed++;
                    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>";
                }


                echo "<br>--- Selesai GET data utama: $pegawai_id ---<br><br>" . PHP_EOL;
                ob_flush();
                flush(); // agar tampil realtime kalau via browser
                // sleep(1); // opsional: beri delay agar tidak overload
                // exit();
            }
            // Summary
            echo "<br><b>Summary:</b><br>";
            echo "Total diproses: $total<br>";
            echo "Berhasil: <span style='color: green;'>$success</span><br>";
            echo "Gagal: <span style='color: red;'>$failed</span><br>";
            echo "<b>Selesai kirim semua data.</b>";
        } else {
            echo "Tidak ada data yang perlu dikirim.";
        }

        // $now = date('Y-m-d'); // format: 2025-09-19 14:23:45

    }


    public function getRiwayatAngkaKreditSiasn()
    {
        $ws = ""; // '/pns/rw-angkakredit/'
        // /pns/data-utama/paruhwaktu/{nipBaru}
        $nip = "";

        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        @ini_set('output_buffering', 'off');
        @ini_set('zlib.output_compression', false);
        @ini_set('implicit_flush', true);
        ob_implicit_flush(true);
        ob_end_flush();

        if (isset($_GET['ws'])) {
            $ws = $_GET['ws'];
        }

        if (isset($_GET['nip'])) {
            $nip = $_GET['nip'];
            $sql1 = "SELECT p.pegawai_id, p.nip_baru 
            FROM pegawai AS p 
            where p.status_pegawai IN ('1','2','10', '18') 
            and p.nip_baru = '$nip' 
            ORDER BY p.pegawai_id";
        } else {
            $sql1 = "SELECT p.pegawai_id, p.nip_baru 
            FROM pegawai AS p 
            WHERE p.status_pegawai IN ('1','2','10', '18') 
            ORDER BY p.pegawai_id";
        }


        $result1 = $this->db->query($sql1);

        if ($result1->num_rows() > 0) {
            $total = $success = $failed = 0;

            foreach ($result1->result() as $row) {
                $nip_baru = $row->nip_baru;
                $pegawai_id = $row->pegawai_id;
                $total++;

                echo "<b>Mulai GET data riwayat angka kredit :</b> $pegawai_id<br>" . PHP_EOL;

                try {
                    // $response = $this->get_siasn($this->api_mws_token, '/pns/rw-angkakredit/', $nip_baru);
                    $response = $this->get_siasn($this->api_mws_token, $ws, $nip_baru);
                    print_r($response);
                    // $response_data = json_decode($response, true);

                } catch (Exception $e) {
                    $failed++;
                    echo "<span style='color:red;'>✗ Error: {$e->getMessage()}</span><br>";
                }
                // $this->update_proses_cronjob($pegawai_id, 'cek WS ', $response_data['message']);
                echo "<br>--- Selesai cek WS  : $pegawai_id ---<br><br>" . PHP_EOL;
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
                    $response = $this->get_siasn($this->api_mws_token, $ws, $nip_baru);
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



    public function getRiwayatPendidikanSiasn()
    {
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');

        @ini_set('output_buffering', 'off');
        @ini_set('zlib.output_compression', false);
        @ini_set('implicit_flush', true);
        ob_implicit_flush(true);

        $sql1 = "SELECT p.pegawai_id, p.nip_baru 
        FROM pegawai AS p 
        WHERE p.pegawai_id > (
            SELECT MAX(r.pegawai_id) 
            FROM riwayat_cronjob AS r 
            WHERE r.nama_cronjob = 'cek riwayat pendidikan'
        )
        AND p.status_pegawai IN ('1','2','10')
        ORDER BY p.pegawai_id";

        $result1 = $this->db->query($sql1);

        if ($result1->num_rows() === 0) {
            echo "Tidak ada data yang perlu dikirim.";
            return;
        }

        $total = $success = $failed = 0;

        echo str_repeat(' ', 4096);
        flush();
        foreach ($result1->result() as $row) {
            $pegawai_id = $row->pegawai_id;
            $nip_baru   = $row->nip_baru;
            $total++;

            echo "<b>Mulai GET data riwayat pendidikan :</b> $pegawai_id<br>";
            echo str_repeat(' ', 1024);
            flush();
            try {
                $response = $this->get_siasn(
                    $this->api_mws_token,
                    '/pns/rw-pendidikan/',
                    $nip_baru
                );

                print_r($response);

                $response_data = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    print_r($response);
                    throw new Exception('JSON decode gagal');
                }

                if (!isset($response_data['code']) || $response_data['code'] != 1) {
                    throw new Exception($response_data['message'] ?? 'Response API tidak valid');
                }

                $items = $response_data['data'] ?? [];

                if (empty($items)) {
                    echo "<span style='color:orange;'>⚠ Data kosong</span><br>";
                } else {
                    foreach ($items as $item) {
                        $db = $this->insertOrUpdateDataRiwayatPendidikan($item, $pegawai_id);
                        $db['success'] ? $success++ : $failed++;
                    }
                }

                $message = $response_data['message'] ?? 'OK';
            } catch (Exception $e) {
                $failed++;
                $message = $e->getMessage();
                echo "<span style='color:red;'>✗ {$message}</span><br>";
            }

            // update progress cron
            $this->update_proses_cronjob(
                $pegawai_id,
                'cek riwayat pendidikan',
                $message
            );

            echo "--- Selesai GET data riwayat pendidikan : $pegawai_id ---<br><br>\n";
            echo str_repeat(' ', 1024);
            flush();
        }

        echo "<br><b>Summary:</b><br>";
        echo "Total diproses: $total<br>";
        echo "Berhasil: <span style='color:green;'>$success</span><br>";
        echo "Gagal: <span style='color:red;'>$failed</span><br>";
        echo "<b>Selesai kirim semua data.</b>";
    }

    public function getRiwayatJabatanSiasn()
    {
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');

        @ini_set('output_buffering', 'off');
        @ini_set('zlib.output_compression', false);
        @ini_set('implicit_flush', true);
        ob_implicit_flush(true);

        $sql1 = "SELECT p.pegawai_id, p.nip_baru 
        FROM pegawai AS p 
        WHERE p.pegawai_id > (
            SELECT MAX(r.pegawai_id) 
            FROM riwayat_cronjob AS r 
            WHERE r.nama_cronjob = 'cek riwayat pendidikan'
        )
        AND p.status_pegawai IN ('1','2','10')
        ORDER BY p.pegawai_id";

        $result1 = $this->db->query($sql1);

        if ($result1->num_rows() === 0) {
            echo "Tidak ada data yang perlu dikirim.";
            return;
        }

        $total = $success = $failed = 0;

        echo str_repeat(' ', 4096);
        flush();
        foreach ($result1->result() as $row) {
            $pegawai_id = $row->pegawai_id;
            $nip_baru   = $row->nip_baru;
            $total++;

            echo "<b>Mulai GET data riwayat pendidikan :</b> $pegawai_id<br>";
            echo str_repeat(' ', 1024);
            flush();
            try {
                $response = $this->get_siasn(
                    $this->api_mws_token,
                    '/pns/rw-pendidikan/',
                    $nip_baru
                );

                print_r($response);

                $response_data = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    print_r($response);
                    throw new Exception('JSON decode gagal');
                }

                if (!isset($response_data['code']) || $response_data['code'] != 1) {
                    throw new Exception($response_data['message'] ?? 'Response API tidak valid');
                }

                $items = $response_data['data'] ?? [];

                if (empty($items)) {
                    echo "<span style='color:orange;'>⚠ Data kosong</span><br>";
                } else {
                    foreach ($items as $item) {
                        $db = $this->insertOrUpdateDataRiwayatPendidikan($item, $pegawai_id);
                        $db['success'] ? $success++ : $failed++;
                    }
                }

                $message = $response_data['message'] ?? 'OK';
            } catch (Exception $e) {
                $failed++;
                $message = $e->getMessage();
                echo "<span style='color:red;'>✗ {$message}</span><br>";
            }

            // update progress cron
            $this->update_proses_cronjob(
                $pegawai_id,
                'cek riwayat pendidikan',
                $message
            );

            echo "--- Selesai GET data riwayat pendidikan : $pegawai_id ---<br><br>\n";
            echo str_repeat(' ', 1024);
            flush();
        }

        echo "<br><b>Summary:</b><br>";
        echo "Total diproses: $total<br>";
        echo "Berhasil: <span style='color:green;'>$success</span><br>";
        echo "Gagal: <span style='color:red;'>$failed</span><br>";
        echo "<b>Selesai kirim semua data.</b>";
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



    public function pushAngkaKreditAll()
    {

        $sql1 = "SELECT * from riwayat_angka_kredit rak where rak.status_singkron  = '' and rak.rwJabatanId !='' ";
        // $sql1 = "SELECT * from riwayat_angka_kredit rak where rak.status_singkron  = '' and rak.PEGAWAI_ID ='235755800060'";

        $result1 = $this->db->query($sql1);

        // Looping hasil query
        if ($result1->num_rows() > 0) {

            $total = 0;
            $success = 0;
            $failed = 0;

            foreach ($result1->result() as $row) {
                // $nip_baru = $row->nip_baru;
                $pegawai_id = $row->PEGAWAI_ID;
                $total++;

                echo "<b>Mulai GET data utama:</b> $pegawai_id<br>" . PHP_EOL;

                // $this->get_data_utama($this->api_mws_token, $nip_baru);
                //ambil hasil dari fungsi ini dan tampilkan dlu


                try {
                    // Tangkap hasil return dari fungsi get_data_utama
                    $response = $this->postAngkaKredit($this->api_mws_token, $row->id, $row->pnsOrangId, $row->skNomor, $row->skDate, $row->rwJabatanId, $row->tahunMulaiPenilaian, $row->bulanMulaiPenilaian, $row->tahunSelesaiPenilaian, $row->bulanSelesaiPenilaian, $row->isIntegrasi, $row->isKonversi, $row->angkaKreditPenunjang, $row->angkaKreditUtama, $row->totalAngkaKredit, $row->isAngkaKreditPertama);
                    // decode response
                    $responseData = json_decode($response, true);

                    if (
                        isset($responseData['success']) &&
                        $responseData['success'] === true &&
                        !empty($responseData['mapData']['rwAngkaKreditId'])
                    ) {

                        $rwAngkaKreditId = $responseData['mapData']['rwAngkaKreditId'];

                        // UPDATE ke DB lokal
                        $this->db->where('riwayat_angka_kredit_id', $row->riwayat_angka_kredit_id);
                        $this->db->update('riwayat_angka_kredit', [
                            'id' => $rwAngkaKreditId,
                            'status_singkron' => '1',
                            'sync_date' => date('Y-m-d H:i:s')
                        ]);

                        $success++;
                        echo "<span style='color:green;'>✓ Sukses simpan ID: $rwAngkaKreditId</span><br>";
                    } else {
                        $failed++;
                        echo "<span style='color:red;'>✗ Gagal, response tidak valid</span><br>";
                        log_message('error', 'Push Angka Kredit gagal: ' . $response);
                    }
                    // echo $response;
                    print_r($response);
                    // Decode JSON response
                    // $response_data = json_decode($response, true);


                } catch (Exception $e) {
                    $failed++;
                    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>";
                }


                echo "<br>--- Selesai GET data utama: $pegawai_id tahun $row->tahunSelesaiPenilaian---<br><br>" . PHP_EOL;
                ob_flush();
                flush(); // agar tampil realtime kalau via browser
                // sleep(1); // opsional: beri delay agar tidak overload
                // exit();
            }
            // Summary
            echo "<br><b>Summary:</b><br>";
            echo "Total diproses: $total<br>";
            echo "Berhasil: <span style='color: green;'>$success</span><br>";
            echo "Gagal: <span style='color: red;'>$failed</span><br>";
            echo "<b>Selesai kirim semua data.</b>";
        } else {
            echo "Tidak ada data yang perlu dikirim.";
        }

        // $now = date('Y-m-d'); // format: 2025-09-19 14:23:45

    }


    //------------------------------------------------ tools ------------------------------------------------//
    public function update_isPendidikanTerakhir()
    {
        $sql = "
            UPDATE riwayat_pendidikan_siasn AS p
            JOIN (
                SELECT nipBaru, MAX(tglLulus) AS tglTerbaru
                FROM riwayat_pendidikan_siasn
                GROUP BY nipBaru
            ) AS t ON p.nipBaru = t.nipBaru
            SET p.isPendidikanTerakhir = (p.tglLulus = t.tglTerbaru)
        ";

        $result = $this->db->query($sql);

        // Kembalikan status hasil eksekusi
        if ($result) {
            return [
                'status' => true,
                'message' => 'Update kolom isPendidikanTerakhir berhasil dilakukan untuk semua pegawai.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Gagal melakukan update kolom isPendidikanTerakhir.'
            ];
        }
    }


    public function update_proses_CekProfilPegawai($pegawai_id, $hasil_cronjob)
    {
        $now = date('Y-m-d H:i:s'); // format: 2025-09-19 14:23:45

        $sql = "
        UPDATE riwayat_cronjob AS r
        SET 
            r.tanggal_eksekusi = ?,
            r.pegawai_id = ?,
            r.hasil_cronjob = ?
        WHERE r.nama_cronjob = 'cek profil pegawai'";

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
        $this->update_proses_CekProfilPegawai($pegawai_id, $response_data['message']);

        return array('success' => $result, 'action' => $action);
    }


    private function insertOrUpdateDataUtamaParuhWaktu($response_data, $pegawai_id)
    {
        $data = $response_data['data'];
        // ================== PARSE DOKUMEN DARI FIELD path ==================
        $dok_id = null;
        $dok_uri = null;
        $dok_nama = null;

        if (!empty($data['path'])) {
            $pathArray = json_decode($data['path'], true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($pathArray)) {
                // Ambil dokumen pertama (key dinamis, contoh: 889)
                $firstDoc = reset($pathArray);

                $dok_id   = $firstDoc['dok_id']   ?? null;
                $dok_uri  = $firstDoc['dok_uri']  ?? null;
                $dok_nama = $firstDoc['dok_nama'] ?? null;
            }
        }
        // ==================================================================

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
            'dok_id' => $dok_id,
            'dok_uri' => $dok_uri,
            'dok_nama' => $dok_nama,
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

        // ================== DOWNLOAD FILE DOKUMEN ==================
        $this->download_pdf_kusus($dok_uri, $formatDate($data['tmtCpns']), $data['nipBaru'], 'SK_ParuhWaktu', 'paruhwaktu', $data['nama']);

        // $this->update_proses_CekProfilPegawai($pegawai_id, $response_data['message']);
        $now = date('Y-m-d H:i:s'); // format: 2025-09-19 14:23:45

        $sql = "
        UPDATE riwayat_cronjob AS r
        SET 
            r.tanggal_eksekusi = ?,
            r.pegawai_id = ?,
            r.hasil_cronjob = ?
        WHERE r.nama_cronjob = 'cek profil pegawai paruh waktu'";

        $result = $this->db->query($sql, [$now, $pegawai_id, $action]);


        return array('success' => $result, 'action' => $action);
    }

    private function insertOrUpdateDataUtamaParuhWaktuBelakang($response_data, $pegawai_id)
    {
        $data = $response_data['data'];
        // ================== PARSE DOKUMEN DARI FIELD path ==================
        $dok_id = null;
        $dok_uri = null;
        $dok_nama = null;

        if (!empty($data['path'])) {
            $pathArray = json_decode($data['path'], true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($pathArray)) {
                // Ambil dokumen pertama (key dinamis, contoh: 889)
                $firstDoc = reset($pathArray);

                $dok_id   = $firstDoc['dok_id']   ?? null;
                $dok_uri  = $firstDoc['dok_uri']  ?? null;
                $dok_nama = $firstDoc['dok_nama'] ?? null;
            }
        }
        // ==================================================================

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
            'dok_id' => $dok_id,
            'dok_uri' => $dok_uri,
            'dok_nama' => $dok_nama,
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

        // ================== DOWNLOAD FILE DOKUMEN ==================
        $this->download_pdf_kusus($dok_uri, $formatDate($data['tmtCpns']), $data['nipBaru'], 'SK_ParuhWaktu', 'paruhwaktu', $data['nama']);

        // $this->update_proses_CekProfilPegawai($pegawai_id, $response_data['message']);
        $now = date('Y-m-d H:i:s'); // format: 2025-09-19 14:23:45

        $sql = "
        UPDATE riwayat_cronjob AS r
        SET 
            r.tanggal_eksekusi = ?,
            r.pegawai_id = ?,
            r.hasil_cronjob = ?
        WHERE r.nama_cronjob = 'cek profil pegawai paruh waktu belakang'";

        $result = $this->db->query($sql, [$now, $pegawai_id, $action]);


        return array('success' => $result, 'action' => $action);
    }

    private function insertOrUpdateDataAngkaKredit($data, $pegawai_id)
    {
        // Pastikan $data array
        if (empty($data) || !is_array($data)) {
            echo "<span style='color:red;'>⚠️ Data kosong atau bukan array untuk pegawai_id: {$pegawai_id}</span><br>";
            return ['success' => false, 'action' => 'invalid'];
        }

        $formatDate = function ($date_str) {
            if (empty($date_str) || $date_str == 'null') return null;
            $date = DateTime::createFromFormat('d-m-Y', $date_str);
            return $date ? $date->format('Y-m-d') : null;
        };
        $formatDateGetYear = function ($date_str) {
            if (empty($date_str) || $date_str == 'null') return null;

            // Coba format d-m-Y dulu
            $date = DateTime::createFromFormat('d-m-Y', $date_str);
            if (!$date) {
                // Kalau gagal, mungkin formatnya sudah Y (misal: "2023")
                $date = DateTime::createFromFormat('Y', $date_str);
            }
            return $date ? $date->format('Y') : null;
        };


        // 🔧 Ambil dok_uri dengan aman
        $dok_uri = null;
        if (!empty($data['path']) && is_array($data['path'])) {
            $firstPath = reset($data['path']);
            $dok_uri = $firstPath['dok_uri'] ?? null;
        }

        $insert_data = [
            'id' => $data['id'] ?? null,
            'isAngkaKreditPertama' => $data['isAngkaKreditPertama'] ?? null,
            'pnsOrangId' => $data['pns'] ?? null,
            'rwJabatanId' => $data['rwJabatan'] ?? null,
            'sumber' => $data['sumber'] ?? null,
            'skNomor' => $data['nomorSk'] ?? null,
            'skDate' => $formatDate($data['tanggalSk'] ?? null),
            'isIntegrasi' => $data['isIntegrasi'] ?? null,
            'isKonversi' => $data['isKonversi'] ?? null,
            'tahunMulaiPenilaian' => $data['tahunMulaiPenailan'] ?? null,
            'bulanMulaiPenilaian' => $data['bulanMulaiPenailan'] ?? null,
            'tahunSelesaiPenilaian' => $data['tahunSelesaiPenailan'] ?? null,
            'bulanSelesaiPenilaian' => $data['bulanSelesaiPenailan'] ?? null,
            'angkaKreditUtama' => $data['kreditUtamaBaru'] ?? null,
            'angkaKreditPenunjang' => $data['kreditPenunjangBaru'] ?? null,
            'totalAngkaKredit' => $data['kreditBaruTotal'] ?? null,
            'insert_date' => $formatDate($data['created_at'] ?? null),
            'update_date' => $formatDate($data['updated_at'] ?? null),
            'dok_uri' => $dok_uri,
            'tahun' => $formatDateGetYear($data['tanggalSk'] ?? null),
            'status_singkron' => '1',
            'sync_date' => date('Y-m-d H:i:s'),
            'pegawai_id' => $pegawai_id
        ];

        try {
            $this->db->where('id', $insert_data['id']);
            $existing = $this->db->get('riwayat_angka_kredit')->row();

            if ($existing) {
                $this->db->where('id', $insert_data['id']);
                $result = $this->db->update('riwayat_angka_kredit', $insert_data);
                $action = 'updated';
            } else {
                $result = $this->db->insert('riwayat_angka_kredit', $insert_data);
                $action = 'inserted';
            }

            if (!$result) {
                $db_error = $this->db->error();
                echo "<span style='color:red;'>⚠️ SQL Error [{$db_error['code']}] {$db_error['message']}</span><br>";
            } else {
                echo "<span style='color:green;'>✔️ Data {$action} untuk pegawai_id {$pegawai_id}</span><br>";
            }

            return ['success' => $result, 'action' => $action];
        } catch (Exception $e) {
            echo "<span style='color:red;'>⚠️ Exception saat insert/update: {$e->getMessage()}</span><br>";

            return ['success' => false, 'action' => 'error'];
        }
    }

    private function insertOrUpdateDataRiwayatPendidikan($data, $pegawai_id)
    {
        if (empty($data) || !is_array($data)) {
            return ['success' => false, 'action' => 'invalid'];
        }

        // ======================
        // Helper format tanggal
        // ======================
        $formatDate = function ($date) {
            if (empty($date)) return null;
            $d = DateTime::createFromFormat('d-m-Y', $date);
            return $d ? $d->format('Y-m-d') : null;
        };

        // ======================
        // Default dokumen
        // ======================
        $ijazah = $transkrip = $pg = [
            'dok_id'   => null,
            'dok_nama' => null,
            'dok_uri'  => null,
            'object'   => null,
            'slug'     => null,
            'sumber'   => null
        ];

        // ======================
        // Mapping PATH
        // ======================
        if (!empty($data['path']) && is_array($data['path'])) {
            foreach ($data['path'] as $dok) {
                if (empty($dok['dok_id'])) continue;

                switch ($dok['dok_id']) {
                    case '870': // IJAZAH
                        $ijazah = array_merge($ijazah, $dok);
                        $ijazah['sumber'] = 'siasn';
                        break;

                    case '871': // TRANSKRIP
                        $transkrip = array_merge($transkrip, $dok);
                        $transkrip['sumber'] = 'siasn';
                        break;

                    case '869': // PENCANTUMAN GELAR
                        $pg = array_merge($pg, $dok);
                        $pg['sumber'] = 'siasn';
                        break;
                }
            }
        }

        // ======================
        // DATA INSERT / UPDATE
        // ======================
        $insert_data = [
            'id' => $data['id'] ?? null,
            'pegawai_id' => $pegawai_id,
            'idPns' => $data['idPns'] ?? null,
            'nipBaru' => $data['nipBaru'] ?? null,
            'nipLama' => $data['nipLama'] ?? null,
            'pendidikanId' => $data['pendidikanId'] ?? null,
            'pendidikanNama' => $data['pendidikanNama'] ?? null,
            'tkPendidikanId' => $data['tkPendidikanId'] ?? null,
            'tkPendidikanNama' => $data['tkPendidikanNama'] ?? null,
            'tahunLulus' => $data['tahunLulus'] ?? null,
            'tglLulus' => $formatDate($data['tglLulus'] ?? null),
            'isPendidikanPertama' => $data['isPendidikanPertama'] ?? null,
            'nomorIjasah' => $data['nomorIjasah'] ?? null,
            'namaSekolah' => $data['namaSekolah'] ?? null,
            'gelarDepan' => $data['gelarDepan'] ?? null,
            'gelarBelakang' => $data['gelarBelakang'] ?? null,
            'createdAt' => $formatDate($data['createdAt'] ?? null),
            'updatedAt' => $formatDate($data['updatedAt'] ?? null),

            // IJAZAH
            'ijazah_dok_id' => $ijazah['dok_id'],
            'ijazah_dok_nama' => $ijazah['dok_nama'],
            'ijazah_dok_uri' => $ijazah['dok_uri'],
            'ijazah_object' => $ijazah['object'],
            'ijazah_slug' => $ijazah['slug'],
            'ijazah_sumber' => $ijazah['sumber'],

            // TRANSKRIP
            'transkrip_dok_id' => $transkrip['dok_id'],
            'transkrip_dok_nama' => $transkrip['dok_nama'],
            'transkrip_dok_uri' => $transkrip['dok_uri'],
            'transkrip_object' => $transkrip['object'],
            'transkrip_slug' => $transkrip['slug'],
            'transkrip_sumber' => $transkrip['sumber'],

            // PENCANTUMAN GELAR
            'pg_dok_id' => $pg['dok_id'],
            'pg_dok_nama' => $pg['dok_nama'],
            'pg_dok_uri' => $pg['dok_uri'],
            'pg_object' => $pg['object'],
            'pg_slug' => $pg['slug'],
            'pg_sumber' => $pg['sumber'],
        ];

        // ======================
        // INSERT / UPDATE
        // ======================
        $this->db->where('id', $insert_data['id']);
        $exists = $this->db->get('riwayat_pendidikan_siasn')->row();

        if ($exists) {
            unset($insert_data['id']);

            $this->db->where('id', $exists->id);
            $result = $this->db->update('riwayat_pendidikan_siasn', $insert_data);
            $action = 'updated';
        } else {
            $result = $this->db->insert('riwayat_pendidikan_siasn', $insert_data);
            $action = 'inserted';
        }

        return ['success' => $result, 'action' => $action];
    }


    public function download_pdf($id)
    // public function download_pdf()
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
    // public function download_pdf()
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
    public function get_siasn($api_mws_token, $jenis_ws, $nip_baru)
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
        // $hasil['data']['sso_token'] = $sso_token;
        // $hasil['data']['api_mws_token'] = $api_mws_token;
        // $hasil['data']['return'] = $response;

        // return $response;
        return $response;
    }

    public function postAngkaKredit($api_mws_token, $id, $pnsOrangId, $skNomor, $skDate, $rwJabatanId, $tahunMulaiPenilaian, $bulanMulaiPenilaian, $tahunSelesaiPenilaian, $bulanSelesaiPenilaian, $isIntegrasi, $isKonversi, $angkaKreditPenunjang, $angkaKreditUtama, $totalAngkaKredit, $isAngkaKreditPertama)
    {
        // $api_mws_token = $this->session->userdata('token_apimws');
        // $sso_token = $this->session->userdata('token_sso');

        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;

        $postData = [
            "id" => empty($id) ? null : (string)$id,
            "PnsID" => (string)$pnsOrangId,
            "NomorSk" => (string)$skNomor,
            "tanggalSk" => date('d-m-Y', strtotime($skDate)),
            "rwJabatanId" => (string)$rwJabatanId,

            "TahunMulaiPenailan" => (string)$tahunMulaiPenilaian,
            "BulanMulaiPenailan" => (string)$bulanMulaiPenilaian,
            "TahunSelesaiPenailan" => (string)$tahunSelesaiPenilaian,
            "BulanSelesaiPenailan" => (string)$bulanSelesaiPenilaian,

            // "KreditUtamaBaru" => (string)$angkaKreditUtama,
            // "KreditPenunjangBaru" => (string)$angkaKreditPenunjang,
            // "KreditBaruTotal" => (string)$totalAngkaKredit,

            "KreditUtamaBaru"      => (string) (($angkaKreditUtama === '' || $angkaKreditUtama === null) ? 0 : $angkaKreditUtama),
            "KreditPenunjangBaru"  => (string) (($angkaKreditPenunjang === '' || $angkaKreditPenunjang === null) ? 0 : $angkaKreditPenunjang),
            "KreditBaruTotal"     => (string) (($totalAngkaKredit === '' || $totalAngkaKredit === null) ? 0 : $totalAngkaKredit),


            "isAngkaKreditPertama" => (string)$isAngkaKreditPertama,
            "isIntegrasi" => (string)$isIntegrasi,
            "isKonversi" => (string)$isKonversi,

            "path" => []

        ];





        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/angkakredit/save',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));


        log_message('error', 'REQUEST AK JSON: ' . json_encode($postData));

        $response = curl_exec($curl);

        curl_close($curl);
        // $hasil['data']['sso_token'] = $sso_token;
        // $hasil['data']['api_mws_token'] = $api_mws_token;
        // $hasil['data']['return'] = $response;

        // return $response;
        return $response;
    }
}
