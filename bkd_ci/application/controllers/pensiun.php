<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pensiun extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'pensiun';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('pegawaimodel');
		$this->model = $this->pegawaimodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	"Pegawai Pensiun 5 Tahun Kedepan",
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'pegawai',
		));
		$this->col = array();
		$this->con = array();
		$inf = $this->info['config']['grid'];
		$inf = SiteHelpers::array_sort($inf, 'sortlist', SORT_ASC);
		$in = 0;
		foreach ($inf as $key => $t) {
			if ($t['view'] == '1') {

				$in++;
				$this->col[$in] = $t['field'];
				$this->con[$in] = $t['conn'];
			}
		}

		if (!$this->session->userdata('logged_in')) redirect('user/login', 301);
	}

	function grids()
	{

		$satker = $_GET['satker'];
		$sttpeg = $_GET['sttpeg'];
		$thnpen = $_GET['thnpen'];

		$this->session->set_userdata('thnpen', $thnpen);

		$sort = $this->model->primaryKey;
		$order = 'asc';
		$filter = "";
		//$filter = (!is_null($this->input->get('search', true)) ? $this->buildSearch() : '');
		//order 
		if (isset($_POST['order'])) {
			if (($_POST['order']['0']['column']) == 0) {
				$sort = $this->col[($_POST['order']['0']['column']) + 1];
				$order = $_POST['order']['0']['dir'];
			} else {
				$sort = $this->col[($_POST['order']['0']['column'])];
				$order = $_POST['order']['0']['dir'];
			}
		}

		for ($i = 0; $i < count($this->col); $i++) {

			if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
				if ($i == 0) {
					$filter .= " AND (" . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
				} else {
					$filter .= " OR " . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
				}
			}
		}
		if ($filter != '') $filter .= ")";
		if ($satker != '0')  $filter .= " AND SATKER_ID LIKE '$satker%'";
		if ($sttpeg != 'A')  $filter .= " AND STATUS_PEGAWAI IN ($sttpeg)";
		$gid = $this->session->userdata('gid');
		$sat = $this->session->userdata('satker');
		if ($gid != 1) {
			$filter .= " AND SATKER_ID LIKE '$sat%'";
		}

		if ($thnpen != '') $filter .= " AND YEAR(TANGGAL_PENSIUN) = '$thnpen'";


		// $filter .= " AND DATE_FORMAT(TANGGAL_LAHIR,'%m') = DATE_FORMAT(CURDATE(),'%m')";
		$filter .= " AND TANGGAL_PENSIUN BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 5 YEAR)";
		$order	.= " TANGGAL_PENSIUN ASC";

		$params = array(
			'limit'		=> $_POST['start'],
			'page'		=> $_POST['length'],
			'sort'		=> $sort,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
		);
		// Get Query 
		$results = $this->model->getRowsx($params);
		$rows = $results['rows'];
		$total = $results['total'];
		$totalfil = $results['totalfil'];

		//run data to view
		$data = array();
		$no = 0;
		foreach ($rows as $dt) {
			$row = array();
			$idku = $this->model->primaryKey;
			$row['id'] = $dt->$idku;
			$row[] = $no + 1;
			for ($i = 0; $i < count($this->col); $i++) {
				$field = $this->col[$i + 1];
				if ($field == 'NAMA') {
					if ($dt->GELAR_BELAKANG != '') $dt->GELAR_BELAKANG = ', ' . $dt->GELAR_BELAKANG;
					if ($dt->GELAR_DEPAN != '') $dt->GELAR_DEPAN = $dt->GELAR_DEPAN . '.';
					$row[] = $dt->GELAR_DEPAN . ' ' . $dt->NAMA . '' . $dt->GELAR_BELAKANG;
				} else if ($field == 'TEMPAT_LAHIR') {
					$row[] = $dt->TEMPAT_LAHIR . ', ' . SiteHelpers::daterpt($dt->TANGGAL_LAHIR);
				} else {
					$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
					$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
				}
			}

			//add html for action
			$btn = '';


			$btn .= '<div class="btn-group dropdown-split-danger">';

			$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="sr-only">Toggle primary</span>
</button>
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';
			if ($this->access['is_edit'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href=' . site_url('pegawai/add/' . $dt->$idku) . '><i class="ti-pencil-alt"></i> Edit</a>';
			}
			if ($this->access['is_remove'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('pegawai/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			$btn .= '</div>';

			$row[] = $btn;
			$data[] = $row;
			$no++;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $total,
			"recordsFiltered" => $totalfil,
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function index()
	{
		if ($this->access['is_view'] == 0) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'Your are not allowed to access the page'));
			redirect('dashboard', 301);
		}

		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		$this->data['content'] = $this->load->view('pensiun/index', $this->data, true);

		$this->load->view('layouts/main', $this->data);
	}

	function satker()
	{
		if (isset($_GET['id']) && $_GET['id'] != '#') {

			$id = $_GET['id'];
			$sql = "SELECT SATKER_ID AS id,SATKER_ID_PARENT,NAMA AS text,IF((SELECT COUNT(SATKER_ID) FROM satker WHERE SATKER_ID_PARENT=a.SATKER_ID) > 0 , false,true) AS children FROM satker a WHERE SATKER_ID_PARENT = '$id' ORDER BY SATKER_ID ASC";
			$sa = $this->db->query($sql)->result();
			$d = array();
			foreach ($sa as $key) {
				$d[] = array('id' => $key->id, 'parent' => $key->SATKER_ID_PARENT, 'text' => $key->text, 'children' => true);
			}

			echo json_encode($d);
		} else {
			$sql = "SELECT SATKER_ID AS id,SATKER_ID_PARENT,NAMA AS text,IF((SELECT COUNT(SATKER_ID) FROM satker WHERE SATKER_ID_PARENT=a.SATKER_ID) > 0 , true,false) AS children FROM satker a WHERE SATKER_ID_PARENT = 0 ORDER BY SATKER_ID ASC";
			$sa = $this->db->query($sql)->result();
			$d = array();
			foreach ($sa as $key) {
				$r = false;
				if ($key->children == 'true') $r = true;
				$d[] = array('id' => $key->id, 'text' => $key->text, 'children' => true);
			}

			echo json_encode($d);
		}
	}

	public function pensiunexcel()
	{
		// $thnpen = $_GET['thnpen'];
		$thnpen = $this->session->userdata('thnpen');
		ini_set('memory_limit', '256M');

		$wh = "";

		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND p.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND p.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		$sqlc = "select p.NIP_BARU, p.NAMA, p.TEMPAT_LAHIR, p.TANGGAL_LAHIR, p.JENIS_KELAMIN, p.TANGGAL_PENSIUN, j.NAMA as jabatan, pz.KODE as pangkat from pegawai as p 
		left join jabatan_riwayat as j on j.JABATAN_RIWAYAT_ID = p.JABATAN_ID_TERAKHIR
		left join pangkat_riwayat as px on px.PANGKAT_RIWAYAT_ID = p.PANGKAT_ID_TERAKHIR
		left join pangkat as pz on px.PANGKAT_ID = pz.PANGKAT_ID
	    where YEAR(p.TANGGAL_PENSIUN) = " . $thnpen . "  and p.STATUS_PEGAWAI in ('1', '2','10') " . $wh . "
		group by p.PEGAWAI_ID  order by p.TANGGAL_PENSIUN";


		// $ax = $this->db->query($sql)->result();

		// print_r($ax);
		// echo $ax;
		// exit();
		// $tgl_download = date('YmdHis');
		// if ($this->session->userdata('satker')) {
		// 	$fileName = 'laporanASNsummary_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		// } else {
		// 	$fileName = 'laporanASNsummary_master_' . $tgl_download . '.xlsx';
		// }



		$ax = $this->db->query($sqlc)->result();


		$tgl_download = date('YmdHis');
		if ($this->session->userdata('satker')) {
			$fileName = 'PensiunASN_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		} else {
			$fileName = 'PensiunASN_master_' . $tgl_download . '.xlsx';
		}

		$employeeData = $ax;
		// var_dump($employeeData);
		// die();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'TEMPAT_LAHIR');
		$sheet->setCellValue('D1', 'TANGGAL_LAHIR');
		$sheet->setCellValue('E1', 'JENIS_KELAMIN');
		$sheet->setCellValue('F1', 'TANGGAL_PENSIUN');
		$sheet->setCellValue('G1', 'JABATAN');
		$sheet->setCellValue('H1', 'PANGKAT');

		$rows = 2;
		foreach ($employeeData as $val) {
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU);
			$sheet->setCellValue('B' . $rows, $val->GELAR_DEPAN . " " . $val->NAMA . ", " . $val->GELAR_BELAKANG);
			$sheet->setCellValue('C' . $rows, $val->TEMPAT_LAHIR);
			$sheet->setCellValue('D' . $rows, $val->TANGGAL_LAHIR);
			$sheet->setCellValue('E' . $rows, $val->JENIS_KELAMIN);
			$sheet->setCellValue('F' . $rows, $val->TANGGAL_PENSIUN);
			$sheet->setCellValue('G' . $rows, $val->jabatan);
			$sheet->setCellValue('H' . $rows, $val->pangkat);
			$rows++;
		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		try {
			$writer->save(FCPATH . "laporan_excel/" . $fileName);
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url() . "laporan_excel/" . $fileName);
			// redirect(base_url()."index.php/statistik");    
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}
}
