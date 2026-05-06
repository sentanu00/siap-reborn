<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epusulanpemberhentianmonitoring extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'epusulanpemberhentianmonitoring';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('epusulanpemberhentianmonitoringmodel');
		$this->model = $this->epusulanpemberhentianmonitoringmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'epusulanpemberhentianmonitoring',
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

	function grids($stt = 0)
	{
		$fid = $this->session->userdata('fid');
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
		if ($stt == 0) {
			//diproses
			//	$filter .= " AND usulan_status in (0,1,2,3,4)"; 
		} else if ($stt == 5) {
			//sk terbit
			$filter .= " AND usulan_status = '5'";
		} else if ($stt == 6) {
			//ditolak
			$filter .= " AND usulan_status = '6'";
		}

		// $filter .= " AND usulan_user_act = '" . $fid . "'";
		if ($this->session->userdata('gid') != 1) {
			//selain superadmin masuk sini, untuk gid = 1 itu untuk superadmin apps. kalau superadmin bisa lihat semua.
			$satker = $this->session->userdata('satker');
			$filter .= " AND satker_id like '" . $satker . "%'";
		}

		// if ($this->session->usedata('gid') != 1) {
		// 	//selain superadmin masuk sini, untuk gid = 1 itu untuk superadmin apps. kalau superadmin bisa lihat semua.
		// 	$satker = $this->session->userdata('satker');
		// 	$filter .= " AND satker_id like '" . $satker . "%'";
		// 	// $filter .= " AND usulan_user_act = '" . $fid . "'";
		// }


		$params = array(
			'limit'		=> $_POST['start'],
			'page'		=> $_POST['length'],
			'sort'		=> $sort,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
		);
		// Get Query 
		$results = $this->model->getRows($params);
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
				if ($field == 'usulan_tanggal') {
					$row[] = SiteHelpers::datereport($dt->usulan_tanggal) . '<br /><b>' . $dt->usulan_nomor . '</b>' . '<br /><i class="fa fa-arrow-right"></i> <span style="color:white;background:#3c7c11;padding:2px;padding-left:5px;padding-right:5px">' . $dt->golongan_pemberhentian_nama . '</span><br /><i class="fa fa-arrow-right"></i> <span style="color:white;background:#002542;padding:2px;padding-left:5px;padding-right:5px">' . $dt->jenis_pemberhentian_nama . '</span>';
				} else if ($field == 'satuan_kerja') {
					$row[] = '<i class="fa fa-home"></i> ' . $dt->satuan_kerja . '<br /><i class="fa fa-arrow-right"></i> ' . $dt->unor;
				} else if ($field == 'usulan_status') {
					$row[] = SiteHelpers::getStatusUsulanPegawai($dt->$field);
				} else if ($field == 'NAMA_PEGAWAI') {
					$row[] = $dt->NAMA_PEGAWAI . '<br /><small><b>NIP. ' . $dt->NIP_BARU . '</b></small>';
				} else {
					$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
					$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
				}
			}

			//add html for action
			$btn = '';


			$btn .= '<button class="btn btn-sm btn-info" onclick="SximoModal(\'' . site_url('epusulanpemberhentianmonitoring/show/' .		$dt->$idku) . '\',\'Detail Data Pegawai\',\'950\')"><i class="fa fa-list"></i> Detail</button><br />';

			if ($dt->usulan_status == 5) {
				$btn .= '<button class="btn btn-sm btn-danger" onclick="SximoModal(\'' . site_url('epusulanpemberhentianmonitoring/viewfileSK/' .		$dt->$idku) . '\',\'View SK Pemberhentian Pegawai\',\'950\')"><i class="fa fa-eye"></i> View SK</button>';
			}
			if ($dt->usulan_status == 6) {
				$btn .= '<b>Alasan :</b><br />' . $dt->validasi_catatan;
			}

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

	function viewfileSK($id)
	{
		$col = "file_sk_upload";
		$th = $this->db->query("SELECT $col FROM ep_tx_usulan_pemberhentian_detail WHERE id = '$id'")->row();
		$ext = explode(".", $th->$col);
		$maxext = count($ext);
		$extn = $ext[$maxext - 1];
		if ($extn == 'pdf') {
			$urlberkas = base_url($th->$col);
			echo '<iframe src="' . $urlberkas . '?time=' . date('ymdhis') . '#toolbar=0" width="100%" height="600px"></iframe>';
		} else {
			$urlberkas = base_url($th->$col);
			echo '<img src="' . $urlberkas . '?time=' . date('ymdhis') . '" style="max-width:100%">';
		}
	}

	function index()
	{
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		$this->data['content'] = $this->load->view('epusulanpemberhentianmonitoring/index', $this->data, true);

		$this->load->view('layouts/main', $this->data);
	}

	function show($id = null)
	{
		if ($this->access['is_detail'] == 0) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'Your are not allowed to access the page'));
			redirect('dashboard', 301);
		}

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ep_tx_usulan_pemberhentian_detail');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('epusulanpemberhentianmonitoring/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}
}
