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

		$anomali = [
			// 'pangkat' => $this->model->getAnomaliPangkatFormatted(),
			'gelar'   => $this->model->getAnomaliGelarFormatted(),
			// nanti tambahkan 'jabatan' => ...
		];
		$anomalipangkat = [
			'pangkat' => $this->model->getAnomaliPangkatFormatted(),
			// 'gelar'   => $this->model->getAnomaliGelarFormatted(),
			// nanti tambahkan 'jabatan' => ...
		];

		// Hanya masukkan kategori yang tidak kosong

		$anomali = array_filter($anomali, function ($items) {
			return !empty($items);
		});
		$anomalipangkat = array_filter($anomalipangkat, function ($items) {
			return !empty($items);
		});

		if (!empty($monitoring[0])) {
			$monitoring[0]['anomali'] = $anomali;
		}

		if (!empty($monitoringRwGolongan[0])) {
			$monitoringRwGolongan[0]['anomali'] = $anomalipangkat;
		}

		$this->data['monitoring'] = $monitoring;
		$this->data['monitoringRwGolongan'] = $monitoringRwGolongan;
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

	public function download_anomali_gelar()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('user/login', 301);
		}

		// Query detail dengan LEFT JOIN dan filter perbedaan
		$sql = "SELECT 
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
				$row->STATUS_PEGAWAI,
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
}
