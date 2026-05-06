<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
define('ENCRYPTION_KEY', '__^%&Q@$&*!@#$%^&*^__');


class Epusulanpemberhentian extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'epusulanpemberhentian';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('epusulanpemberhentianmodel');
		$this->model = $this->epusulanpemberhentianmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'epusulanpemberhentian',
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
		if ($this->session->userdata('gid') != 1) {
			$satker = $this->session->userdata('satker');
			$filter .= " AND satker_id LIKE '$satker%'";
		}


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
				if ($field == 'usulan_status') {

					$row[] = SiteHelpers::getStatusUsulan($dt->usulan_status);
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

			$btn .= '<a class="dropdown-item waves-effect waves-light" href="' . site_url('epusulanpemberhentian/detailUsulan') . '/' . md5($dt->$idku) . '" ><i class="ti-eye"></i> Detail Usulan</a>';

			if ($this->access['is_edit'] == 1  && $dt->usulan_status == 0) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="javascript::void()" onclick="SximoModal(\'' . site_url('epusulanpemberhentian/add/' . $dt->$idku) . '\',\'Edit Usulan\')"><i class="ti-pencil"></i> Edit</a>';
			}
			if ($this->access['is_remove'] == 1 && $dt->usulan_status == 0) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('epusulanpemberhentian/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
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
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		$this->data['content'] = $this->load->view('epusulanpemberhentian/index', $this->data, true);

		$this->load->view('layouts/main', $this->data);
	}

	function detailUsulan($idUsulan)
	{

		if ($this->access['is_detail'] == 0) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'Your are not allowed to access the page'));
			redirect('dashboard', 301);
		}
		$row = $this->model->getDetailUsulan($idUsulan);
		$this->data['row'] =  $row;

		$this->info2 = $this->model->makeInfo('epusulanpemberhentianpegawai');
		$this->data['tableGrid'] 	= $this->info2['config']['grid'];
		$this->access2 = $this->model->validAccess($this->info2['id']);
		$this->data['access']		= $this->access2;
		$this->data['id_usulan'] = $row['id'];

		$this->data['content'] =  $this->load->view('epusulanpemberhentian/view', $this->data, true);
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
			$this->data['row'] = $this->model->getColumnTable('ep_tx_usulan_pemberhentian');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('epusulanpemberhentian/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
			$satker = $this->db->query("SELECT NAMA from vw_satker_select WHERE SATKER_ID = '" . $row['satker_id'] . "'")->row();
			$this->data['satkernama'] = $satker->NAMA;
		} else {
			$this->data['row'] = $this->model->getColumnTable('ep_tx_usulan_pemberhentian');
			$maxno = $this->db->query('SELECT LPAD(IFNULL(MAX(LEFT(usulan_nomor,4)),0)+1,4,"0") as nomax FROM ep_tx_usulan_pemberhentian WHERE YEAR(usulan_tanggal)=YEAR(NOW())')->row();
			$satkersession = $this->session->userdata('satker');
			$satker = $this->db->query("SELECT NAMA from vw_satker_select WHERE SATKER_ID = '" . $satkersession . "'")->row();
			$this->data['satkernama'] = $satker->NAMA;
			$this->data['row']['satker_id'] = $satkersession;
			$this->data['row']['usulan_tanggal'] = date('Y-m-d');
			$this->data['row']['usulan_nomor'] = $maxno->nomax . '/' . $satkersession . '/' . date('m') . '/' . date('Y');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] = $this->load->view('epusulanpemberhentian/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function kirimdataBKSDM()
	{
		$id = $_POST['id'];

		$sql = $this->db->query("SELECT COUNT(id) AS total,SUM(IF(usulan_status=0,1,0)) AS draft FROM `ep_tx_usulan_pemberhentian_detail` WHERE md5(usulan_pemberhentian_id) = '$id'")->row();
		if ($sql) {
			if ($sql->draft > 0) {
				$err = 'Masih ada Data Pegawai dengan status Input Berkas ' . $sql->draft . ' dari ' . $sql->total . ' Data Pegawai';
				echo json_encode(array('msg' => $err));
			} else if ($sql->total > 0) {
				$this->db->where('md5(id)', $id);
				$this->db->update('ep_tx_usulan_pemberhentian', array('usulan_status' => 1));


				$this->db->where('md5(usulan_pemberhentian_id)', $id);
				$this->db->update('ep_tx_usulan_pemberhentian_detail', array('usulan_status' => 2));

				echo json_encode(array('msg' => $sql->total . ' Data Usulan Pegawai berhasil dikirim'));
			} else {
				$err = 'Masih ada Data Pegawai dengan status Input Berkas ' . $sql->draft . ' dari ' . $sql->total . ' Data Pegawai';
				echo json_encode(array('msg' => $err));
			}
		}
	}

	function save()
	{

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();
			if ($this->input->get_post('id', true) == '') {
				$data['user_act'] = $this->session->userdata('fid');
				$data['tgl_act'] = date("Y-m-d H:i:s");
			} else {
				$data['user_update_act'] = $this->session->userdata('fid');
				$data['tgl_update_act'] = date("Y-m-d H:i:s");
			}

			$ID = $this->model->insertRow($data, $this->input->get_post('id', true));
			// Input logs
			if ($this->input->get('id', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}


			echo 'epusulanpemberhentian/detailUsulan/' . md5($ID);
		} else {
			$data =	array(
				'message'	=> 'Ops , The following errors occurred',
				'errors'	=> validation_errors('<li>', '</li>')
			);
			$this->displayError($data);
		}
	}

	function destroy()
	{
		if ($this->access['is_remove'] == 0) {
			echo "err : maaf anda tidak memiliki hak untuk menghapus data";
		}

		// $this->model->destroy($_POST['id']);

		$data = array(
			'is_deleted' => 1
		);

		$this->db->where('id', $_POST['id']);
		$this->db->update('ep_tx_usulan_pemberhentian', $data);


		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}
}
