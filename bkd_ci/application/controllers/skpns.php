<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skpns extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'skpns';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('skpnsmodel');
		$this->model = $this->skpnsmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'skpns',
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
		// Query 1: Set svalidasi = '1' ketika yang update adalah user admin
		$this->db->query('update perubahan_data as p 
	left join tb_users as t on p.LAST_CREATE_USER = t.username
	set 
	p.VALIDASI = 1, 
	p.VALIDATOR = t.username, 
	p.TANGGAL = NOW(), 
	p.LAST_UPDATE_USER = t.username,
	p.LAST_UPDATE_DATE = NOW() 
	where t.group_id = 1 and p.VALIDASI = 0');

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
					$filter .= " AND " . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
				} else {
					$filter .= " OR " . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
				}
			}
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
			$row[] = $no + 1;
			for ($i = 0; $i < count($this->col); $i++) {
				$field = $this->col[$i + 1];
				$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
				$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
			}

			//add html for action
			$btn = '';
			$idku = $this->model->primaryKey;


			$btn .= '<div class="btn-group dropdown-split-danger">';
			if ($this->access['is_detail'] == 1) {
				$btn .= '<a class="btn btn-danger" href=' . site_url('skpns/show/' . $dt->$idku) . ' ><i class="ti-eye"></i> View</a>';
			}
			$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="sr-only">Toggle primary</span>
</button>
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';
			if ($this->access['is_edit'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href=' . site_url('skpns/add/' . $dt->$idku) . '><i class="ti-pencil-alt"></i> Edit</a>';
			}
			if ($this->access['is_remove'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('skpns/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
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

		$this->data['content'] = $this->load->view('skpns/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('sk_pns');
		}

		$this->data['id'] = $id;
		$this->data['content'] =  $this->load->view('skpns/view', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function add($id = null)
	{
		$row = $this->db->query("SELECT * FROM sk_pns where PEGAWAI_ID = '" . $_POST['id'] . "'")->row_array();

		//$row = $this->model->getRow( $id );
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('sk_pns');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['content'] = $this->load->view('skpns/form', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function viewfile($col, $id)
	{
		$th = $this->db->query("SELECT $col FROM sk_pns WHERE SK_PNS_ID = '$id'")->row();
		$ext = explode(".", $th->$col);
		$maxext = count($ext);
		$extn = $ext[$maxext - 1];
		if ($extn == 'pdf') {
			$urlberkas = base_url($th->$col);
			echo '<iframe src="' . $urlberkas . '?time=' . date('ymdhis') . '" width="100%" height="600px"></iframe>';
		} else {
			$urlberkas = base_url($th->$col);
			echo '<img src="' . $urlberkas . '?time=' . date('ymdhis') . '" style="max-width:100%">';
		}
	}

	function save()
	{
		$a = '';
		$pegawai = $_POST['PEGAWAI_ID'];
		$nip = 'kosong';
		$namafile_sk = '';
		$tempfile_sk = $_FILES['FILE_PDF']['tmp_name'];

		//cari nip
		$sql = $this->db->query("SELECT NIP_BARU FROM pegawai WHERE PEGAWAI_ID = '$pegawai'")->row();
		if ($sql) {
			$nip = $sql->NIP_BARU;
		}

		$config['upload_path'] = './dokumen/' . $nip . '/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']     = '2000';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//var_dump($_FILES);

		//SK
		if ($tempfile_sk == '') {
			$namafile_sk = $_POST['file_pdf_cek'];
		} else {
			$_FILES["FILE_PDF"]["name"] = 'PNS_SK_' . $nip . '.pdf';
			if (!$this->upload->do_upload('FILE_PDF')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_sk = 'dokumen/' . $nip . '/PNS_SK_' . $nip . '.pdf';
			}
		}



		unset($_POST['file_pdf_cek']);

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();

			$data['FILE_PDF'] = $namafile_sk;
			$data['LAST_UPDATE_USER'] = @$user_update;
			$data['LAST_UPDATE_DATE'] = date("Y-m-d H:i:s");

			$datalama = $this->getdatalama($_POST, 'sk_pns', 'SK_PNS_ID', $data['SK_PNS_ID']);
			$ID = $this->model->insertRow($data, $this->input->get_post('SK_PNS_ID', true));
			$this->perubahandata($data['PEGAWAI_ID'], 'skpns', 'sk_pns', json_encode($datalama), json_encode($_POST), 'SK_PNS_ID', $ID);
			// Input logs
			if ($this->input->get('SK_PNS_ID', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
			if ($a == '') {
				$a = "Berhasil Simpan !!";
			} else {
				$this->session->set_flashdata('message', SiteHelpers::alert('error', $a));
			}
			echo $a;
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

		$datalama = $this->getdatalamadelete('sk_pns', 'SK_PNS_ID', $_POST['id']);
		$this->perubahandata($datalama['PEGAWAI_ID'], 'skpns', 'sk_pns', json_encode($datalama), 'DELETE', 'SK_PNS_ID', $_POST['id']);
		$this->model->destroy($_POST['id']);
		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}
}
