<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Devmodmodel extends SB_Model
{

    public $table = 'pegawai';
    public $primaryKey = 'PEGAWAI_ID';

    public function __construct()
    {
        parent::__construct();
    }

    // public static function querySelect(  ){


    // 	return "   SELECT pegawai.* FROM pegawai   ";
    // }
    // public static function queryWhere(  ){

    // 	return "  WHERE pegawai.PEGAWAI_ID IS NOT NULL   ";
    // }

    // public static function queryGroup(){
    // 	return "   ";
    // }


    public function getProgressDataUtama()
    {
        return $this->db->query("
        SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN flag_data_utama = 1 THEN 1 ELSE 0 END) AS antrian,
            SUM(CASE WHEN flag_data_utama = 0 THEN 1 ELSE 0 END) AS sukses,
            SUM(CASE WHEN flag_data_utama = 3 THEN 1 ELSE 0 END) AS gagal,
            ROUND(
                SUM(CASE WHEN flag_data_utama = 1 THEN 1 ELSE 0 END) * 100 / COUNT(*),
                2
            ) AS persen_antrian,
            ROUND(
                SUM(CASE WHEN flag_data_utama = 0 THEN 1 ELSE 0 END) * 100 / COUNT(*),
                2
            ) AS persen_sukses,
            ROUND(
                SUM(CASE WHEN flag_data_utama = 3 THEN 1 ELSE 0 END) * 100 / COUNT(*),
                2
            ) AS persen_gagal
        FROM siasnpegawaiid where statusPegawai in ('PNS', 'CPNS','PPPK','PPPK PARUH WAKTU')
    ")->row();
    }

    public function getDashboardMonitoring()
    {
        $dashboard = array();

        /*
    |--------------------------------------------------------
    | DATA UTAMA
    |--------------------------------------------------------
    */

        $p = $this->getProgressDataUtama();

        $dashboard[] = array(
            'judul'             => 'Sinkronisasi Data Utama ASN',
            'icon'              => 'fa-user',
            'total'             => $p->total,
            'sukses'            => $p->sukses,
            'antrian'           => $p->antrian,
            'gagal'             => $p->gagal,
            'persen_sukses'     => $p->persen_sukses,
            'persen_antrian'    => $p->persen_antrian,
            'persen_gagal'      => $p->persen_gagal,

            'anomali' => array(
                // nanti isi disini
            )
        );

        /*
    |--------------------------------------------------------
    | Nanti tinggal tambah seperti ini
    |--------------------------------------------------------
    */

        // $dashboard[] = $this->getProgressPendidikan();
        // $dashboard[] = $this->getProgressPangkat();
        // $dashboard[] = $this->getProgressJabatan();

        return $dashboard;
    }


    public function getAnomaliPangkat()
    {
        $sql = "
        SELECT
            CASE p.STATUS_PEGAWAI
                WHEN '1' THEN 'CPNS'
                WHEN '2' THEN 'PNS'
                WHEN '10' THEN 'PPPK'
                WHEN '18' THEN 'PPPK Paruh Waktu'
            END AS jenis_pegawai,

            COUNT(*) AS total_dicek,

            SUM(
                CASE
                    WHEN pa.KODE IS NOT NULL
                     AND du.golRuangAkhir IS NOT NULL
                     AND pa.KODE = du.golRuangAkhir
                    THEN 1 ELSE 0
                END
            ) AS sama,

            SUM(
                CASE
                    WHEN pa.KODE IS NOT NULL
                     AND du.golRuangAkhir IS NOT NULL
                     AND pa.KODE <> du.golRuangAkhir
                    THEN 1 ELSE 0
                END
            ) AS berbeda,

            SUM(
                CASE
                    WHEN du.golRuangAkhir IS NULL
                      OR TRIM(du.golRuangAkhir) = ''
                    THEN 1 ELSE 0
                END
            ) AS kosong_siasn,

            SUM(
                CASE
                    WHEN pa.KODE IS NULL
                      OR TRIM(pa.KODE) = ''
                    THEN 1 ELSE 0
                END
            ) AS kosong_siap

        FROM pegawai p

        LEFT JOIN pangkat_riwayat pr
            ON p.PANGKAT_ID_TERAKHIR = pr.pangkat_riwayat_id

        LEFT JOIN pangkat pa
            ON pr.PANGKAT_ID = pa.PANGKAT_ID

        LEFT JOIN data_utama du
            ON p.NIP_BARU = du.nipBaru

        WHERE p.STATUS_PEGAWAI IN ('1','2','10')

        GROUP BY p.STATUS_PEGAWAI

        ORDER BY FIELD(p.STATUS_PEGAWAI,'1','2','10')
    ";

        return $this->db->query($sql)->result();
    }

    public function getAnomaliPangkatFormatted()
    {
        $raw = $this->getAnomaliPangkat();
        $anomali = [];

        foreach ($raw as $row) {
            if ($row->berbeda > 0) {
                $anomali[] = [
                    'nama'   => 'Pangkat tidak sesuai (' . $row->jenis_pegawai . ')',
                    'jumlah' => $row->berbeda,
                    'url'    => '#',
                ];
            }
            if ($row->kosong_siasn > 0) {
                $anomali[] = [
                    'nama'   => 'Pangkat kosong di SIASN (' . $row->jenis_pegawai . ')',
                    'jumlah' => $row->kosong_siasn,
                    'url'    => '#',
                ];
            }
            if ($row->kosong_siap > 0) {
                $anomali[] = [
                    'nama'   => 'Pangkat kosong di SIAP (' . $row->jenis_pegawai . ')',
                    'jumlah' => $row->kosong_siap,
                    'url'    => '#',
                ];
            }
        }

        return $anomali;
    }

    public function downloadAnomaliPangkat()
    {
        $sql = "

    SELECT

        p.NIP_BARU,

        p.NAMA,

        sp.NAMA AS status_pegawai,

        s1.NAMA AS satker,

        s2.NAMA AS satker_induk,

        jr.NAMA as jabatan,

        pa.KODE AS golongan_siap,

        du.golRuangAkhir AS golongan_siasn

    FROM pegawai p

    LEFT JOIN pangkat_riwayat pr
        ON p.PANGKAT_ID_TERAKHIR = pr.pangkat_riwayat_id

    LEFT JOIN pangkat pa
        ON pr.PANGKAT_ID = pa.PANGKAT_ID

    LEFT JOIN data_utama du
        ON p.NIP_BARU = du.nipBaru

    JOIN status_pegawai sp
        ON p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID

    JOIN satker s1
        ON p.SATKER_ID = s1.SATKER_ID

    JOIN satker s2
        ON p.SATKER_INDUK_ID = s2.SATKER_ID

    JOIN jabatan_riwayat jr
        ON p.JABATAN_ID_TERAKHIR = jr.JABATAN_RIWAYAT_ID

   WHERE
    p.STATUS_PEGAWAI IN ('1','2','10')
    AND pa.KODE IS NOT NULL
    AND du.golRuangAkhir IS NOT NULL
    AND pa.KODE <> du.golRuangAkhir

    GROUP BY

        p.NIP_BARU

    ORDER BY

        s2.NAMA,

        s1.NAMA,

        p.NAMA

    ";

        return $this->db->query($sql)->result();
    }

    /**
     * Ambil detail anomali pangkat (data pegawai yang berbeda)
     * @return array|object
     */
    public function getDetailAnomaliPangkat()
    {
        $sql = "
        SELECT 
            p.nip_baru, 
            p.NAMA, 
            sp.NAMA AS status_pegawai, 
            jr.NAMA AS jabatan, 
            s1.NAMA AS satker, 
            s2.NAMA AS satker_induk, 
            pa.KODE AS golongan_siap, 
            du.golRuangAkhir AS golongan_siasn 
        FROM pegawai p 
        LEFT JOIN pangkat_riwayat pr ON p.PANGKAT_ID_TERAKHIR = pr.pangkat_riwayat_id 
        LEFT JOIN pangkat pa ON pr.PANGKAT_ID = pa.PANGKAT_ID 
        LEFT JOIN data_utama du ON p.NIP_BARU = du.nipBaru 
        JOIN status_pegawai sp ON p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID 
        JOIN satker s1 ON p.SATKER_ID = s1.SATKER_ID 
        JOIN satker s2 ON p.SATKER_INDUK_ID = s2.SATKER_ID 
        JOIN jabatan_riwayat jr ON p.JABATAN_ID_TERAKHIR = jr.JABATAN_RIWAYAT_ID 
        WHERE pa.KODE != du.golRuangAkhir 
          AND p.STATUS_PEGAWAI IN ('1','2','10') 
        GROUP BY p.NIP_BARU
    ";

        return $this->db->query($sql)->result();
    }

    /**
     * Agregasi anomali gelar per status pegawai
     * Total pegawai tetap (semua yang sesuai filter)
     * beda_depan = jumlah yang gelar depannya berbeda (termasuk kosong vs isi)
     * beda_belakang = jumlah yang gelar belakangnya berbeda
     * total_berbeda = jumlah pegawai yang setidaknya salah satu gelar berbeda
     */
    public function getAnomaliGelar()
    {
        $sql = "
    SELECT
        CASE p.STATUS_PEGAWAI
            WHEN '1' THEN 'CPNS'
            WHEN '2' THEN 'PNS'
            WHEN '10' THEN 'PPPK'
            WHEN '18' THEN 'PPPK Paruh Waktu'
        END AS jenis_pegawai,
        COUNT(*) AS total_dicek,
        SUM(
            CASE
                WHEN COALESCE(TRIM(p.GELAR_DEPAN), '') != COALESCE(TRIM(d.gelarDepan), '')
                THEN 1 ELSE 0
            END
        ) AS beda_depan,
        SUM(
            CASE
                WHEN COALESCE(TRIM(p.GELAR_BELAKANG), '') != COALESCE(TRIM(d.gelarBelakang), '')
                THEN 1 ELSE 0
            END
        ) AS beda_belakang,
        SUM(
            CASE
                WHEN COALESCE(TRIM(p.GELAR_DEPAN), '') != COALESCE(TRIM(d.gelarDepan), '')
                  OR COALESCE(TRIM(p.GELAR_BELAKANG), '') != COALESCE(TRIM(d.gelarBelakang), '')
                THEN 1 ELSE 0
            END
        ) AS total_berbeda
    FROM pegawai p
    LEFT JOIN data_utama d ON p.NIP_BARU = d.nipBaru
    WHERE p.STATUS_PEGAWAI IN ('1','2','10','18')
    GROUP BY p.STATUS_PEGAWAI
    ORDER BY FIELD(p.STATUS_PEGAWAI,'1','2','10','18')
    ";

        return $this->db->query($sql)->result();
    }

    /**
     * Format anomali gelar untuk tampilan dashboard (array per kategori)
     */
    public function getAnomaliGelarFormatted()
    {
        $raw = $this->getAnomaliGelar();
        $anomali = [];

        foreach ($raw as $row) {
            if ($row->beda_depan > 0) {
                $anomali[] = [
                    'nama'   => 'Gelar depan tidak sesuai (' . $row->jenis_pegawai . ')',
                    'jumlah' => $row->beda_depan,
                    'url'    => '#',
                ];
            }
            if ($row->beda_belakang > 0) {
                $anomali[] = [
                    'nama'   => 'Gelar belakang tidak sesuai (' . $row->jenis_pegawai . ')',
                    'jumlah' => $row->beda_belakang,
                    'url'    => '#',
                ];
            }
            // (Opsional) Tampilkan total_berbeda jika ingin
            // if ($row->total_berbeda > 0) { ... }
        }

        return $anomali;
    }


    /**
     * Ambil detail anomali pangkat (data pegawai yang berbeda)
     * @return array|object
     */
    public function DownloadAnomaliGelar()
    {
        $sql = "
    SELECT 
    p.nip_baru, 
    p.NAMA, 
    p.STATUS_PEGAWAI,
    p.GELAR_DEPAN AS gelar_depan_siap, 
    d.gelarDepan AS gelar_depan_siasn, 
    CASE 
	    WHEN COALESCE(TRIM(p.GELAR_DEPAN ), '') != COALESCE(TRIM(d.gelarDepan), '')
    		THEN 'beda'
    		ELSE 'sama'
    	END as cek_gelar_depan,
    p.GELAR_BELAKANG AS gelar_belakang_siap, 
    d.gelarBelakang AS gelar_belakang_siasn,
    CASE 
	    WHEN COALESCE(TRIM(p.GELAR_BELAKANG), '') != COALESCE(TRIM(d.gelarBelakang), '')
    		THEN 'beda'
    		ELSE 'sama'
    	END as cek_gelar_belakang
    FROM pegawai p 
    LEFT JOIN data_utama d ON p.NIP_BARU = d.nipBaru 
    WHERE p.STATUS_PEGAWAI IN ('1','2','10','18') 
    AND (COALESCE(TRIM(p.GELAR_DEPAN), '') != COALESCE(TRIM(d.gelarDepan), '') 
        OR COALESCE(TRIM(p.GELAR_BELAKANG), '') != COALESCE(TRIM(d.gelarBelakang), ''))
    GROUP BY p.NIP_BARU
    ";

        return $this->db->query($sql)->result();
    }


    //----------------------------------------------------

    public function getProgressRwGolongan()
    {
        return $this->db->query("
        SELECT
            COUNT(*) AS total,

            SUM(CASE WHEN s.golongan = 1 THEN 1 ELSE 0 END) AS antrian,

            SUM(CASE WHEN s.golongan = 0 THEN 1 ELSE 0 END) AS selesai,

            SUM(CASE WHEN s.golongan = 3 THEN 1 ELSE 0 END) AS gagal,

            ROUND(
                SUM(CASE WHEN s.golongan = 1 THEN 1 ELSE 0 END) * 100 / COUNT(*),
                2
            ) AS persen_antrian,

            ROUND(
                SUM(CASE WHEN s.golongan = 0 THEN 1 ELSE 0 END) * 100 / COUNT(*),
                2
            ) AS persen_selesai,

            ROUND(
                SUM(CASE WHEN s.golongan = 3 THEN 1 ELSE 0 END) * 100 / COUNT(*),
                2
            ) AS persen_gagal

        FROM siasnpegawaiid s

        JOIN pegawai p
            ON p.PEGAWAI_ID = s.pegawai_id

        WHERE
            p.STATUS_PEGAWAI = '2'
    ")->row();
    }

    public function getDashboardRwGolongan()
    {
        $dashboard = array();

        $p = $this->getProgressRwGolongan();

        $dashboard[] = array(
            'judul'             => 'Sinkronisasi Rw Golongan PNS',
            'icon'              => 'fa-users',
            'total'             => $p->total,
            'sukses'            => $p->selesai,   // <- ubah dari $p->sukses menjadi $p->selesai
            'antrian'           => $p->antrian,
            'gagal'             => $p->gagal,
            'persen_sukses'     => $p->persen_selesai, // <- ubah dari $p->persen_sukses menjadi $p->persen_selesai
            'persen_antrian'    => $p->persen_antrian,
            'persen_gagal'      => $p->persen_gagal,
            'anomali' => array()
        );

        return $dashboard;
    }
}
