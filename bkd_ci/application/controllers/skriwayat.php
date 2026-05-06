<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skriwayat extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'mutasi';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('mutasimodel');
		$this->model = $this->mutasimodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'mutasi',
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
				if ($field == 'SATKER_ID') {
					$row[] = $this->getsatker($dt->SATKER_ID);
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

			if ($this->access['is_remove'] == 1) {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('mutasi/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			$btn .= '</div>';
			// tambahan	
			/*if ($dt->FILE_PDF != '') {
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('mutasi/viewfile') . '/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
			} else {
				$row[] = '<img src="' . base_url('/assets/icon/nodoc.png') . '" style="width:20px">';
			}*/
			//-
		//	$row[] = '<a href="javascript:SximoModal(\'' . site_url('dfsview/riwayatmutasi') . '/' . $pg . '/' . $dt->$idku . '\',\'Data DFS\',1000)">View File</a>';
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

		echo $this->data['content'] = $this->load->view('skriwayat/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('jabatan_riwayat');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('skriwayat/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
			$this->data['SATKER_NAMA'] = $this->getsatker($row['SATKER_ID']);
		} else {
			$this->data['row'] = $this->model->getColumnTable('jabatan_riwayat');
			$this->data['SATKER_NAMA'] = '';
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('skriwayat/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function addfrontend($id = null)
	{

		$row = $this->model->getRow("");
		if ($row) {
			$this->data['row'] =  $row;
			$this->data['SATKER_NAMA'] = $this->getsatker($row['SATKER_ID']);
		} else {
			$this->data['row'] = $this->model->getColumnTable('jabatan_riwayat');
			$this->data['SATKER_NAMA'] = '';
		}

		$this->data['id'] = "";
		$this->data['PEGAWAI_ID'] = $id;
		echo $this->data['content'] = $this->load->view('skriwayat/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function getsatker($id)
	{
		$satkernama = "";
		$c = $this->db->query("SELECT CONCAT((SELECT NAMA FROM satker WHERE satker_id = LEFT('" . $id . "',2)),' - ',NAMA) as NAMA FROM satker WHERE SATKER_ID = '" . $id . "'")->row();
		if ($c) $satkernama = $c->NAMA;
		return $satkernama;
	}

	function viewfile($col,$id){
		$th = $this->db->query("SELECT $col FROM jabatan_riwayat WHERE JABATAN_RIWAYAT_ID = '$id'")->row();
		$ext = explode(".",$th->$col);
		$maxext = count($ext);
		$extn = $ext[$maxext-1];
		if($extn == 'pdf'){
			$urlberkas = base_url($th->$col);
			echo '<iframe src="' . $urlberkas . '?time='.date('ymdhis').'" width="100%" height="600px"></iframe>';
		}else{
			$urlberkas = base_url($th->$col);
			echo '<img src="'.$urlberkas.'?time='.date('ymdhis').'" style="max-width:100%">';
		}
	}
	
	function save()
	{
		/*
		// fungsi upload file pdf
		//mengambil temporary file terlebih dahulu
		$tempfile = $_FILES['FILE_PDF']['tmp_name'];
		//cek apakah file ada isinya?
		if ($tempfile == '') {
			$lokasifile = 'tidak ada file';
		} else {
			$formatberkas = "SK_JABATAN";
			$tmt = $this->input->post('TMT_JABATAN');

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
		*/
		$a = '';
		$pegawai = $_POST['PEGAWAI_ID'];
		$nip = 'kosong';
		$namafile_sk = '';
		$namafile_pertek = '';
		$tempfile_sk = $_FILES['FILE_PDF']['tmp_name'];
		$tempfile_pertek = $_FILES['FILE_PELANTIKAN']['tmp_name'];
		$tmt = $_POST['TMT_JABATAN'];
		
		//cari nip
			$sql = $this->db->query("SELECT NIP_BARU FROM pegawai WHERE PEGAWAI_ID = '$pegawai'")->row(); 
			if($sql){
				$nip = $sql->NIP_BARU;
			}
		
		$config['upload_path'] = './dokumen/'.$nip.'/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']     = '2000';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//var_dump($_FILES);
		
		//SK
		if ($tempfile_sk == '') {
			$namafile_sk = $_POST['file_pdf_cek'];
			
		}else{
			if($namafile_sk != '') unlink($_POST['file_pdf_cek']);
		$_FILES["FILE_PDF"]["name"] = 'JABATAN_SK_'.$nip.'_'.$tmt.'.pdf';
		if(!$this->upload->do_upload('FILE_PDF'))
		{
				$e = $this->upload->display_errors();
				$a = $e;
		}else{
			$namafile_sk = 'dokumen/'.$nip.'/JABATAN_SK_'.$nip.'_'.$tmt.'.pdf';
		}
		}
		
		
		//PERTEK
		if ($tempfile_pertek == '') {
			$namafile_pertek = $_POST['file_pelantikan_cek'];
			
		}else{
			if($namafile_pertek != '') unlink($_POST['file_pelantikan_cek']);
		$_FILES["FILE_PELANTIKAN"]["name"] = 'JABATAN_LANTIK_'.$nip.'_'.$tmt.'.pdf';
		if(!$this->upload->do_upload('FILE_PELANTIKAN'))
		{
				$e = $this->upload->display_errors();
				$a = $e;
		}else{
			$namafile_pertek = 'dokumen/'.$nip.'/JABATAN_LANTIK_'.$nip.'_'.$tmt.'.pdf';
		}
		}
		
		
		unset($_POST['file_pdf_cek']);
		unset($_POST['file_pelantikan_cek']);
		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {

			$data = $this->validatePost();
			$data['FILE_PDF'] = $namafile_sk;
			$data['FILE_PELANTIKAN'] = $namafile_pertek;
			$data['LAST_UPDATE_USER'] = @$user_update;
			$data['LAST_UPDATE_DATE'] = date("Y-m-d H:i:s");

			$datalama = $this->getdatalama($_POST, 'jabatan_riwayat', 'JABATAN_RIWAYAT_ID', $data['JABATAN_RIWAYAT_ID']);

			$ID = $this->model->insertRow($data, $this->input->get_post('JABATAN_RIWAYAT_ID', true));

			//disini dilakukan pengimputan log ke tabel "perubahan_data" tentang siap yang melakukan perubahan data beserta apa perubahannya
			$this->perubahandata($data['PEGAWAI_ID'], 'mutasi', 'jabatan_riwayat', json_encode($datalama), json_encode($_POST), 'JABATAN_RIWAYAT_ID', $ID);
			
			$this->getlastriwayat('jabatan_riwayat',$data['PEGAWAI_ID'],'TMT_JABATAN');
			// Input logs / dilakukan pengimputan log pata tabel tb_logs juga
			if ($this->input->get('JABATAN_RIWAYAT_ID', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}

			// Redirect after save	
			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
			
			if($a == ''){
				$a = "Berhasil Simpan !!";
			}else{
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

		$datalama = $this->getdatalamadelete('jabatan_riwayat', 'JABATAN_RIWAYAT_ID', $_POST['id']);
		$this->perubahandata($datalama['PEGAWAI_ID'], 'Riwayat Mutasi', 'jabatan_riwayat', json_encode($datalama), 'DELETE', 'JABATAN_RIWAYAT_ID', $_POST['id']);

		$this->model->destroy($_POST['id']);
			$this->getlastriwayat('jabatan_riwayat',$data['PEGAWAI_ID'],'TMT_JABATAN');
		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}

	function getkelas($idx)
	{
		$a = $this->db->query("SELECT kls_jabatan,nilai_jabatan FROM master_jabatan WHERE id = '$idx'")->row();
		if ($a) {
			echo $a->kls_jabatan;
		} else {
			echo '';
		}
	}
}
