<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kompetensi extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'kompetensi'; //----------ganti
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('kompetensimodel'); //--------tetap
		$this->model = $this->kompetensimodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	"kompetensi",
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
		$thn = $_GET['thn'];

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
		if ($satker != '0')  $filter .= " AND pegawai.SATKER_ID LIKE '$satker%'";
		if ($sttpeg != 'A')  $filter .= " AND STATUS_PEGAWAI IN ($sttpeg)";
		$gid = $this->session->userdata('gid');
		$sat = $this->session->userdata('satker');
		if ($gid != 1) {
			$filter .= " AND SATKER_ID LIKE '$sat%'";
		}

		if ($thn != '') $filter .= " AND TAHUN = '$thn'";


		// $filter .= " AND DATE_FORMAT(TANGGAL_LAHIR,'%m') = DATE_FORMAT(CURDATE(),'%m')";
		// $filter .= " AND TANGGAL_PENSIUN BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 5 YEAR)";
		// $order	.= " TANGGAL_PENSIUN ASC";

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
				} else {
					$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
					$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
				}
			}

			//add html for action
			$btn = '';

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

		$this->data['content'] = $this->load->view('kompetensi/index', $this->data, true); //------------ganti

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
}
