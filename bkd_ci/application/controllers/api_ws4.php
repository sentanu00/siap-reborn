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
}
