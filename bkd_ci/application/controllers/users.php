<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'users';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('usersmodel');
		$this->model = $this->usersmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'users',
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
					$filter .= " AND " .  "tb_users." . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
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
				$btn .= '<a class="btn btn-danger" href=' . site_url('users/show/' . $dt->$idku) . ' ><i class="ti-eye"></i> View</a>';
			}
			$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="sr-only">Toggle primary</span>
</button>
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';
			if ($this->access['is_edit'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href=' . site_url('users/add/' . $dt->$idku) . '><i class="ti-pencil-alt"></i> Edit</a>';
			}
			if ($this->access['is_remove'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('users/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			// === TAMBAHKAN DUA ITEM INI ===
			// Reset Token (hanya tampil jika user punya metode token atau tidak peduli)
			$btn .= '<a class="dropdown-item waves-effect waves-light" href="' . site_url('users/reset_token/' . $dt->$idku) . '" onclick="return confirm(\'Reset token untuk user ini? Token baru akan dikirim ke email.\')"><i class="ti-key"></i> Reset Akun dan Token</a>';



			// Reset MFA (hanya tampil jika user punya MFA aktif atau tidak peduli)
			// $btn .= '<a class="dropdown-item waves-effect waves-light" href="' . site_url('users/reset_mfa_admin/' . $dt->$idku) . '" onclick="return confirm(\'Reset MFA (Google Authenticator) untuk user ini? User harus setup ulang.\')"><i class="ti-shield"></i> Reset Akun dan MFA</a>';


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

		$this->data['content'] = $this->load->view('users/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('tb_users');
		}

		$this->data['id'] = $id;
		$this->data['content'] =  $this->load->view('users/view', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function add($id = null)
	{
		if ($id == '')
			if ($this->access['is_add'] == 0) redirect('dashboard', 301);

		if ($id != '')
			if ($this->access['is_edit'] == 0) redirect('dashboard', 301);

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users');
		}

		$this->data['id'] = $id;
		$this->data['content'] = $this->load->view('users/form', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function save()
	{

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();
			$data['password'] = md5('123456');
			$ID = $this->model->insertRow($data, $this->input->get_post('id', true));
			// Input logs
			if ($this->input->get('id', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
			if ($this->input->post('apply')) {
				redirect('users/add/' . $ID, 301);
			} else {
				redirect('users', 301);
			}
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

		$this->model->destroy($_POST['id']);
		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}


	// Reset Token (paksa user ganti password dan akan mendapat token baru)
	public function reset_token($id)
	{
		if ($this->access['is_edit'] == 0) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'Anda tidak memiliki izin untuk melakukan ini.'));
			redirect('users');
		}

		$user = $this->db->get_where('tb_users', array('id' => $id))->row();
		if (!$user) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'User tidak ditemukan.'));
			redirect('users');
		}

		// Update database: set force_password_change = 1, metode = token, hapus data MFA & token lama
		$this->db->where('id', $id);
		$this->db->update('tb_users', array(
			'force_password_change' => 1,
			'two_factor_method' => 'token',
			'auth_token_hash' => NULL,
			'mfa_enabled' => 0,
			'ga_secret' => NULL
		));

		$this->session->set_flashdata('message', SiteHelpers::alert('success', 'User ' . $user->username . ' telah di-reset (Token). Saat login, user akan diwajibkan mengganti password dan mendapatkan token baru.'));
		redirect('users');
	}

	// Reset MFA (paksa user ganti password dan akan setup MFA ulang)
	public function reset_mfa($id)
	{
		if ($this->access['is_edit'] == 0) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'Anda tidak memiliki izin untuk melakukan ini.'));
			redirect('users');
		}

		$user = $this->db->get_where('tb_users', array('id' => $id))->row();
		if (!$user) {
			$this->session->set_flashdata('error', SiteHelpers::alert('error', 'User tidak ditemukan.'));
			redirect('users');
		}

		// Update database: set force_password_change = 1, metode = totp, hapus data token & MFA lama
		$this->db->where('id', $id);
		$this->db->update('tb_users', array(
			'force_password_change' => 1,
			'two_factor_method' => 'totp',
			'auth_token_hash' => NULL,
			'mfa_enabled' => 0,
			'ga_secret' => NULL
		));

		$this->session->set_flashdata('message', SiteHelpers::alert('success', 'User ' . $user->username . ' telah di-reset (MFA). Saat login, user akan diwajibkan mengganti password dan setup ulang MFA.'));
		redirect('users');
	}
}
