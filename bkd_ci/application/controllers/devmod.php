<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Devmod extends SB_Controller
{
	protected $layout = "layouts/main";
	public $module = 'devmod';
	public $per_page = '10';
	public $idx = '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('devmodmodel');
		$this->model = $this->devmodmodel;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);

		$this->data = array_merge($this->data, array(
			'pageTitle'  => $this->info['title'],
			'pageNote'   => $this->info['note'],
			'pageModule' => 'devmod',
		));

		$this->col = array();
		$this->con = array();

		$inf = SiteHelpers::array_sort($this->info['config']['grid'], 'sortlist', SORT_ASC);

		$in = 0;
		foreach ($inf as $t) {
			if ($t['view'] == '1') {
				$in++;
				$this->col[$in] = $t['field'];
				$this->con[$in] = $t['conn'];
			}
		}

		if (!$this->session->userdata('logged_in')) {
			redirect('user/login', 301);
		}
	}

	public function index()
	{
		$monitoring = $this->model->getDashboardMonitoring();
		$monitoringRwGolongan = $this->model->getDashboardRwGolongan();
		$monitoringRwJabatan = $this->model->getDashboardRwJabatan();
		$monitoringRwPendidikan = $this->model->getDashboardRwPendidikan();

		// Anomali gelar (untuk monitoring data utama)
		$anomali = [
			'gelar' => $this->model->getAnomaliGelarFormatted(),
		];
		$anomali = array_filter($anomali, function ($items) {
			return !empty($items);
		});

		if (!empty($monitoring[0])) {
			$monitoring[0]['anomali'] = $anomali;
		}

		// ====== ANOMALI UNTUK RW GOLONGAN ======
		$anomalipangkat = [
			'pangkat' => $this->model->getAnomaliPangkatFormatted(),
		];
		$anomalipangkat = array_filter($anomalipangkat, function ($items) {
			return !empty($items);
		});

		// Tambahkan anomali masa kerja
		$anomaliMasaKerja = [
			'masa_kerja' => $this->model->getAnomaliMasaKerjaFormatted(),
		];
		$anomaliMasaKerja = array_filter($anomaliMasaKerja, function ($items) {
			return !empty($items);
		});

		// Gabungkan anomali pangkat dan masa kerja
		$anomaliRwGolongan = array_merge($anomalipangkat, $anomaliMasaKerja);

		if (!empty($monitoringRwGolongan[0])) {
			$monitoringRwGolongan[0]['anomali'] = $anomaliRwGolongan;
		}



		// ====== ANOMALI UNTUK RW JABATAN ======


		$anomalijabatan = [
			'jabatan_unor' => $this->model->getAnomaliRwJabatanFormatted(),
		];
		$anomalijabatan = array_filter($anomalijabatan, function ($items) {
			return !empty($items);
		});

		// Gabungkan anomali 
		$anomaliRwJabatan = array_merge($anomalijabatan);

		if (!empty($monitoringRwJabatan[0])) {
			$monitoringRwJabatan[0]['anomali'] = $anomaliRwJabatan;
		}


		// ====== ANOMALI UNTUK RW PENDIDIKAN ======
		$anomalipendidikan = [
			// 'pendidikan' => $this->model->getAnomaliRwPendidikanFormatted(),
		];
		$anomalipendidikan = array_filter($anomalipendidikan, function ($items) {
			return !empty($items);
		});

		// Gabungkan anomali 
		$anomaliRwPendidikan = array_merge($anomalipendidikan);

		if (!empty($monitoringRwPendidikan[0])) {
			$monitoringRwPendidikan[0]['anomali'] = $anomaliRwPendidikan;
		}

		$this->data['monitoring'] = $monitoring;
		$this->data['monitoringRwGolongan'] = $monitoringRwGolongan;
		$this->data['monitoringRwJabatan'] = $monitoringRwJabatan;
		$this->data['monitoringRwPendidikan'] = $monitoringRwPendidikan;
		$this->data['access'] = $this->access;
		$this->data['content'] = $this->load->view('devmod/index', $this->data, true);
		$this->load->view($this->layout, $this->data);
	}


	public function download_anomali_pangkat()
	{
		// Cek login
		if (!$this->session->userdata('logged_in')) {
			redirect('user/login', 301);
		}

		// Ambil data detail
		$data = $this->model->getDetailAnomaliPangkat();

		if (empty($data)) {
			$this->session->set_flashdata('error', 'Tidak ada data anomali pangkat untuk didownload.');
			redirect('devmod');
			return;
		}

		// Nama file (bisa tetap .csv atau diganti .txt agar tidak membingungkan)
		$filename = 'detail_anomali_pangkat_' . date('Ymd_His') . '.csv';

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$output = fopen('php://output', 'w');
		fputs($output, "\xEF\xBB\xBF"); // BOM untuk UTF-8

		// ================================================
		// PERUBAHAN ADA DI SINI:
		// Tambahkan '|' sebagai delimiter (parameter ke-3)
		// ================================================
		fputcsv($output, [
			'NIP Baru',
			'Nama',
			'Status Pegawai',
			'Jabatan',
			'Satker',
			'Satker Induk',
			'Golongan SIAP',
			'Golongan SIASN'
		], '|'); // <-- Pemisah pipe

		foreach ($data as $row) {
			fputcsv($output, [
				$row->nip_baru,
				$row->NAMA,
				$row->status_pegawai,
				$row->jabatan,
				$row->satker,
				$row->satker_induk,
				$row->golongan_siap,
				$row->golongan_siasn
			], '|'); // <-- Pemisah pipe
		}

		fclose($output);
		exit;
	}

	public function download_anomali_jabatan_unor()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('user/login', 301);
		}

		$sql = "
        select 
        CASE
            WHEN COALESCE(p.SATKER_ID, '') = COALESCE(j.satker_id, '')
             AND COALESCE(sj1.SATKER_ID_SAPK, '') = COALESCE(du.unorId, '')
             AND COALESCE(j.TMT_JABATAN, '') = COALESCE(du.tmtJabatan, '')
            THEN 'Sama'
            ELSE 'Berbeda'
        END AS perbandingan_akhir,
        CASE
            WHEN COALESCE(p.SATKER_ID, '') = COALESCE(j.satker_id, '') 
                THEN 'Sama'
                ELSE 'Berbeda' 
        END AS perbandingan_satkerid_pg_jr,
        CASE
            WHEN COALESCE(sj1.SATKER_ID_SAPK, '') = COALESCE(du.unorId, '') 
                THEN 'Sama'
                ELSE 'Berbeda' 
        END AS perbandingan_unorid_jr_du,
        CASE
            WHEN COALESCE(j.TMT_JABATAN, '') = COALESCE(du.tmtJabatan, '') 
                THEN 'Sama'
                ELSE 'Berbeda' 
        END AS perbandingan_tmtjab_jr_du,
        sp.NAMA as p_status_pegawai,
        p.PEGAWAI_ID as p_PEGAWAI_ID, 
        p.NIP_BARU as p_NIP_BARU, 
        p.NAMA as p_NAMA, 
        p.SATKER_ID as p_satker_id, 
        sp1.NAMA as p_join_satker_nama, 
        sp2.NAMA as p_join_satker_induk_nama, 
        j.TMT_JABATAN as j_TMT_JABATAN, 
        j.satker_id as j_satker_id, 
        sj1.SATKER_ID_SAPK as J_unorId, 
        sj1.NAMA as j_unorNama, 
        sj2.NAMA as j_unor_induk_nama, 
        du.tmtJabatan AS du_tmtJabatan, 
        du.unorId AS du_unorId, 
        du.unorNama AS du_unorNama, 
        du.unorIndukNama AS du_unorIndukNama, 

        j.JABATAN_RIWAYAT_ID as j_JABATAN_RIWAYAT_ID, 
        j.RW_JABATAN_ID_SAPK as j_RW_JABATAN_ID_SAPK, 
        j.TMT_ESELON as j_TMT_ESELON, 
        j.UNOR_ID_SAPK as j_UNOR_ID_SAPK, 
        j.SATUAN_KERJA_ID_SAPK as j_SATUAN_KERJA_ID_SAPK, 
        j.SATUAN_KERJA_NAMA_SAPK as j_SATUAN_KERJA_NAMA_SAPK, 
        j.NAMA as j_NAMA, 
        j.INSTANSI_KERJA_ID_SAPK as j_INSTANSI_KERJA_ID_SAPK, 
        j.INSTANSI_KERJA_NAMA_SAPK as j_INSTANSI_KERJA_NAMA_SAPK, 
        j.JENIS_JABATAN_SAPK as j_JENIS_JABATAN_SAPK, 
        j.JFT_ID_SAPK as j_JFT_ID_SAPK, 
        j.JFT_NAMA_SAPK as j_JFT_NAMA_SAPK, 
        j.JFU_ID_SAPK as j_JFU_ID_SAPK, 
        j.JFU_NAMA_SAPK as j_JFU_NAMA_SAPK, 
        j.KETERANGAN_BUP as j_KETERANGAN_BUP, 
        j.ESELON_ID as j_ESELON_ID,

        du.pegawai_id AS du_pegawai_id,
        du.nipBaru AS du_nipBaru,
        du.id AS du_id,
        du.tmtEselon AS du_tmtEselon,
        du.satuanKerjaKerjaId AS du_satuanKerjaKerjaId,
        du.satuanKerjaKerjaNama AS du_satuanKerjaKerjaNama,
        du.jabatanNama AS du_jabatanNama,
        du.instansiKerjaId AS du_instansiKerjaId,
        du.instansiKerjaNama AS du_instansiKerjaNama,
        du.jenisJabatanId AS du_jenisJabatanId,
        du.jabatanFungsionalId AS du_jabatanFungsionalId,
        du.jabatanFungsionalNama AS du_jabatanFungsionalNama,
        du.jabatanFungsionalUmumId AS du_jabatanFungsionalUmumId,
        du.jabatanFungsionalUmumNama AS du_jabatanFungsionalUmumNama,
        du.bupPensiun AS du_bupPensiun,
        du.eselonId AS du_eselonId
        from pegawai p 
        join status_pegawai sp on p.STATUS_PEGAWAI  = sp.STATUS_PEGAWAI_ID 
        left join satker sp1 on p.SATKER_ID  = sp1.SATKER_ID 
        left join satker sp2 on sp2.SATKER_ID   = sp1.SATKER_INDUK_ID 
        left join jabatan_riwayat j on p.JABATAN_ID_TERAKHIR   = j.JABATAN_RIWAYAT_ID 
        left join satker sj1 on j.SATKER_ID  = sj1.SATKER_ID 
        left join satker sj2 on sj2.SATKER_ID   = sj1.SATKER_INDUK_ID
        join data_utama du on p.PEGAWAI_ID  = du.pegawai_id 
        where p.STATUS_PEGAWAI in ('1','2','10','18')
        group by p.PEGAWAI_ID
        order by perbandingan_tmtjab_jr_du desc, perbandingan_unorid_jr_du desc, perbandingan_satkerid_pg_jr desc, sp.nama, sp2.nama, sp1.nama, sj2.nama, sj1.nama, du.unorIndukNama, du.unorNama
    ";

		$data = $this->db->query($sql)->result();

		if (empty($data)) {
			$this->session->set_flashdata('error', 'Tidak ada data anomali riwayat jabatan.');
			redirect('devmod');
			return;
		}

		$filename = 'detail_anomali_riwayat_jabatan_' . date('Ymd_His') . '.csv';
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$output = fopen('php://output', 'w');
		fputs($output, "\xEF\xBB\xBF"); // BOM UTF-8

		// Ambil nama kolom dari baris pertama (alias sudah jelas)
		$firstRow = $data[0];
		$headers = array_keys((array)$firstRow);

		// Tulis header
		fputcsv($output, $headers, '|');

		// Tulis data
		foreach ($data as $row) {
			$rowArray = (array)$row;
			fputcsv($output, $rowArray, '|');
		}

		fclose($output);
		exit;
	}


	public function download_anomali_gelar()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('user/login', 301);
		}

		// Query detail dengan LEFT JOIN dan filter perbedaan
		$sql = "SELECT 
    p.nip_baru, 
    p.NAMA, 
    sp.NAMA  as status_pegawai,
    s1.NAMA as satker,
    s2.NAMA as satker_induk,
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
    join satker s1 on p.SATKER_ID   = s1.SATKER_ID 
    join satker s2 on s1.SATKER_INDUK_ID  = s2.SATKER_ID 
    join status_pegawai sp on p.STATUS_PEGAWAI  = sp.STATUS_PEGAWAI_ID 
    WHERE p.STATUS_PEGAWAI IN ('1','2','10','18') 
    AND (COALESCE(TRIM(p.GELAR_DEPAN), '') != COALESCE(TRIM(d.gelarDepan), '') 
        OR COALESCE(TRIM(p.GELAR_BELAKANG), '') != COALESCE(TRIM(d.gelarBelakang), ''))
    GROUP BY p.NIP_BARU
    ";

		$data = $this->db->query($sql)->result();

		if (empty($data)) {
			$this->session->set_flashdata('error', 'Tidak ada data anomali gelar.');
			redirect('devmod');
			return;
		}

		$filename = 'detail_anomali_gelar_' . date('Ymd_His') . '.csv';
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$output = fopen('php://output', 'w');
		fputs($output, "\xEF\xBB\xBF");

		fputcsv($output, [
			'nip_baru',
			'nama',
			'status_pegawai',
			'satker',
			'satker_induk',
			'gelar_depan_siap',
			'gelar_depan_siasn',
			'cek_gelar_depan',
			'gelar_belakang_siap',
			'gelar_belakang_siasn',
			'cek_gelar_belakang'
		], '|');

		foreach ($data as $row) {
			fputcsv($output, [
				$row->nip_baru,
				$row->NAMA,
				$row->status_pegawai,
				$row->satker,
				$row->satker_induk,
				$row->gelar_depan_siap,
				$row->gelar_depan_siasn,
				$row->cek_gelar_depan,
				$row->gelar_belakang_siap,
				$row->gelar_belakang_siasn,
				$row->cek_gelar_belakang
			], '|');
		}

		fclose($output);
		exit;
	}

	public function download_anomali_masa_kerja()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('user/login', 301);
		}

		$data = $this->model->getDetailAnomaliMasaKerja();

		if (empty($data)) {
			$this->session->set_flashdata('error', 'Tidak ada data anomali masa kerja untuk didownload.');
			redirect('devmod');
			return;
		}

		$filename = 'detail_anomali_masa_kerja_' . date('Ymd_His') . '.csv';

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$output = fopen('php://output', 'w');
		fputs($output, "\xEF\xBB\xBF"); // BOM UTF-8

		fputcsv($output, [
			'NIP Baru',
			'Nama',
			'Jabatan',
			'Satker',
			'Satker Induk',
			'Pangkat Awal',
			'TMT Awal',
			'MK Awal (Tahun)',
			'MK Awal (Bulan)',
			'Pangkat Akhir',
			'TMT Akhir',
			'MK Akhir (Tahun)',
			'MK Akhir (Bulan)',
			'Hasil Hitung (Tahun)',
			'Hasil Hitung (Bulan)',
			'Keterangan',
			'Selisih'
		], '|');

		foreach ($data as $row) {
			fputcsv($output, [
				$row->NIP_BARU,
				$row->NAMA,
				$row->jabatan,
				$row->satker,
				$row->satker_induk,
				$row->pangkat_awal,
				$row->tmt_awal,
				$row->MK_TAHUN_AWAL,
				$row->MK_BULAN_AWAL,
				$row->pangkat_akhir,
				$row->tmt_akhir,
				$row->MK_TAHUN_AKHIR,
				$row->MK_BULAN_AKHIR,
				$row->HITUNG_TAHUN,
				$row->HITUNG_BULAN,
				$row->HASIL_HITUNG_KETERANGAN,
				$row->SELISIH_HASIL_HITUNG_
			], '|');
		}

		fclose($output);
		exit;
	}
}
