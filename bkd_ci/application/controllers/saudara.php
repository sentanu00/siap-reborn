<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saudara extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'saudara';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('saudaramodel');
		$this->model = $this->saudaramodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'saudara',
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

	function grids($pg)
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
					$filter .= " AND (" . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
				} else {
					$filter .= " OR " . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
				}
			}
		}

		if ($filter != '') $filter .= ")";
		$filter .= " AND PEGAWAI_ID = '$pg'";

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
				$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
				$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
			}

			//add html for action
			$btn = '';


			$btn .= '<div class="btn-group dropdown-split-danger">';
			$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="sr-only">Toggle primary</span>
					</button>
					<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';

			if ($this->access['is_remove'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('saudara/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			$btn .= '</div>';
			if ($dt->FILE_PDF != '') {
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('saudara/viewfile/FILE_PDF') . '/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
			} else {
				$row[] = '<img src="' . base_url('/assets/icon/nodoc.png') . '" style="width:20px">';
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

	function index()
	{
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		echo $this->data['content'] = $this->load->view('saudara/index', $this->data, true);

		//$this->load->view('layouts/main', $this->data );


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
			$this->data['row'] = $this->model->getColumnTable('saudara');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('saudara/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('saudara');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('saudara/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function viewfile($col, $id)
	{
		$th = $this->db->query("SELECT $col FROM saudara WHERE SAUDARA_ID = '$id'")->row();
		$ext = explode(".", $th->$col);
		$maxext = count($ext);
		$extn = $ext[$maxext - 1];
		if ($extn == 'pdf') {
			$urlberkas = base_url($th->$col);
			echo '<iframe src="' . $urlberkas . '" width="100%" height="600px"></iframe>';
		} else {
			$urlberkas = base_url($th->$col);
			echo '<img src="' . $urlberkas . '" style="max-width:100%">';
		}
	}

	function save()
	{
		// fungsi upload file pdf
		//mengambil temporary file terlebih dahulu
		$tempfile = $_FILES['FILE_PDF']['tmp_name'];
		//cek apakah file ada isinya?
		if ($tempfile == '') {
			$lokasifile = 'tidak ada file';
		} else {
			$formatberkas = "SAUDARA";
			$tmt = $this->input->post('TANGGAL_LAHIR');

			$pegawai_id = $this->input->post('PEGAWAI_ID'); //gimana caranya ambil nip yang login?
			$results = $this->db->query("SELECT p.nip_baru FROM pegawai AS p WHERE p.PEGAWAI_ID = '$pegawai_id'");
			$get_results = $results->result_array();
			$nip_baru = $get_results[0]['nip_baru'];

			$user_update = $this->session->userdata('username'); //gimana caranya ambil username akun yang login?
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => '103.182.48.107:8888/api/upload_dfs/data',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS =>
				array(
					'format_berkas' => $formatberkas,
					'tmt' => $tmt,
					'nip' => $nip_baru,
					'username' => $user_update,
					'file' =>
					new CURLFile($tempfile)
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$json_object = json_decode($response);

			$datafile = $json_object->data;
			$lokasifile = $datafile->file;
		}

		// $rules = $this->validateForm();

		// $this->form_validation->set_rules($rules);
		// if ($this->form_validation->run()) {
		// 	$data = $this->validatePost();


		// 	$data['FILE_PDF'] = $lokasifile;
		// 	$data['LAST_UPDATE_USER'] = @$user_update;
		// 	$data['LAST_UPDATE_DATE'] = date("Y-m-d H:i:s");
		// 	$data['KABUPATEN_ID'] = $this->getidwil($_POST['KABUPATEN_ID']);
		// 	$data['KELURAHAN_ID'] = $this->getidwil($_POST['KELURAHAN_ID']);
		// 	$data['KECAMATAN_ID'] = $this->getidwil($_POST['KECAMATAN_ID']);
		// 	$ID = $this->model->insertRow($data, $this->input->get_post('SAUDARA_ID', true));
		// 	// Input logs
		// 	if ($this->input->get('SAUDARA_ID', true) == '') {
		// 		$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
		// 	} else {
		// 		$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
		// 	}
		// 	// Redirect after save	
		// 	$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
		// 	if ($this->input->post('apply')) {
		// 		redirect('saudara/add/' . $ID, 301);
		// 	} else {
		// 		redirect('saudara', 301);
		// 	}
		// } else {
		// 	$data =	array(
		// 		'message'	=> 'Ops , The following errors occurred',
		// 		'errors'	=> validation_errors('<li>', '</li>')
		// 	);
		// 	$this->displayError($data);
		// }

		$a = '';
		$pegawai = $_POST['PEGAWAI_ID'];
		$nip = 'kosong';
		$namafile_sk = '';
		$tempfile_sk = $_FILES['FILE_PDF']['tmp_name'];
		$tmt = $_POST['TANGGAL_PIAGAM'];

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
			if ($namafile_sk != '') unlink($_POST['file_pdf_cek']);
			$_FILES["FILE_PDF"]["name"] = 'SAUDARA_' . $nip . '_' . $tmt . '.pdf';
			if (!$this->upload->do_upload('FILE_PDF')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_sk = 'dokumen/' . $nip . '/SAUDARA_' . $nip . '_' . $tmt . '.pdf';
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

			$datalama = $this->getdatalama($_POST, 'saudara', 'SAUDARA_ID', $data['SAUDARA_ID']);
			$ID = $this->model->insertRow($data, $this->input->get_post('SAUDARA_ID', true));
			$this->perubahandata($data['PEGAWAI_ID'], 'Saudara', 'saudara', json_encode($datalama), json_encode($_POST), 'SAUDARA_ID', $ID);
			// Input logs
			if ($this->input->get('SAUDARA_ID', true) == '') {
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

		$this->model->destroy($_POST['id']);
		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}

	function getidwil($d)
	{
		$dx = explode('*', $d);
		$l = count($dx);
		return $dx[$l - 1];
	}
}
