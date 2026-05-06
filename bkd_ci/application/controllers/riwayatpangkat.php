<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayatpangkat extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'riwayatpangkat';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('riwayatpangkatmodel');
		$this->model = $this->riwayatpangkatmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'riwayatpangkat',
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

		// // Query 1: Set svalidasi = '1' ketika yang update adalah user admin
		// $this->db->query('update perubahan_data as p 
		// left join tb_users as t on p.LAST_CREATE_USER = t.username
		// set 
		// p.VALIDASI = 1, 
		// p.VALIDATOR = t.username, 
		// p.TANGGAL = NOW(), 
		// p.LAST_UPDATE_USER = t.username,
		// p.LAST_UPDATE_DATE = NOW() 
		// where  p.VALIDASI = 0 and (t.group_id = 1 or t.group_id = 5)');

		// set data terakhir
		$this->setDataTerakhir($pg);
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

				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('riwayatpangkat/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			$btn .= '</div>';
			if ($dt->FILE_PDF != '') {
				//ada dokumen upload pdf
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('riwayatpangkat/viewfile') . '/FILE_PDF/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
			} else {
				//
				//$hsl = $this->getStatusdfs($pg,$dt->$idku,14);
				//if($hsl === 0){
				//tidak ada dokumen
				$row[] = '<img src="' . base_url('/assets/icon/nodoc.png') . '" style="width:20px">';
				//}else{
				//ada dokumen integrasi
				//	$row[] = '<a href="javascript:SximoModal(\'' . site_url('dfsview/riwayatpangkat') . '/' . $pg . '/' . $dt->$idku . '\',\'Data DFS\',1000)"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"></a>';
				//}
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

	function viewfile($col, $id)
	{
		$th = $this->db->query("SELECT $col FROM pangkat_riwayat WHERE PANGKAT_RIWAYAT_ID = '$id'")->row();
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

	/*
	function viewfile($id)
	{
		$sq = $this->db->query("SELECT FILE_PDF FROM pangkat_riwayat WHERE PANGKAT_RIWAYAT_ID = '$id'")->row();
		
		$urlberkas = "http://103.182.48.107:8888/".$sq->FILE_PDF;
		$timeout = 30;
		
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $urlberkas);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout );

		header('Content-type: application/pdf');
		$result = curl_exec($ch);
		curl_close($ch);
		
		$destination = 'temp.pdf';
		$file = fopen($destination, "w+");
		fputs($file, $result);
		fclose($file);
		$filename = 'tempdata.pdf';
		/*
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/pdf");
		header("Content-Transfer-Encoding: binary");
		readfile($destination);
		
		echo '<iframe src="' . $urlberkas . '" width="100%" height="600px"></iframe>';
	}
	*/

	function index()
	{
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		echo $this->data['content'] = $this->load->view('riwayatpangkat/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('pangkat_riwayat');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('riwayatpangkat/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('pangkat_riwayat');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('riwayatpangkat/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	// custom agar bisa melakukan upload file dfs
	function save()
	{

		// fungsi upload file pdf
		//mengambil temporary file terlebih dahulu
		/*
		$tempfile = $_FILES['FILE_PDF']['tmp_name'];
		//cek apakah file ada isinya?
		if ($tempfile == '') {
			$lokasifile = $_POST['edit_file'];
		} else {
			$formatberkas = "SK_KP";
			$tmt = $this->input->post('TMT_PANGKAT');

			$pegawai_id = $_POST['PEGAWAI_ID']; //gimana caranya ambil nip yang login?
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
		
		unset($_POST['edit_file']);
		*/

		$a = '';
		$pegawai = $_POST['PEGAWAI_ID'];
		$nip = 'kosong';
		$namafile_sk = '';
		$namafile_pertek = '';
		$tempfile_sk = $_FILES['FILE_PDF']['tmp_name'];
		$tempfile_pertek = $_FILES['FILE_PERTEK_KP']['tmp_name'];
		$tmt = $_POST['TMT_PANGKAT'];

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
			$_FILES["FILE_PDF"]["name"] = 'KP_SK_' . $nip . '_' . $tmt . '.pdf';
			if (!$this->upload->do_upload('FILE_PDF')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_sk = 'dokumen/' . $nip . '/KP_SK_' . $nip . '_' . $tmt . '.pdf';
			}
		}


		//PERTEK
		if ($tempfile_pertek == '') {
			$namafile_pertek = $_POST['file_pertek_cek'];
		} else {
			if ($namafile_pertek != '') unlink($_POST['file_pertek_cek']);
			$_FILES["FILE_PERTEK_KP"]["name"] = 'KP_PERTEK_' . $nip . '_' . $tmt . '.pdf';
			if (!$this->upload->do_upload('FILE_PERTEK_KP')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_pertek = 'dokumen/' . $nip . '/KP_PERTEK_' . $nip . '_' . $tmt . '.pdf';
			}
		}


		unset($_POST['file_pdf_cek']);
		unset($_POST['file_pertek_cek']);


		//var_dump($lokasifile);die();

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {

			$data = $this->validatePost();

			// memasukkan lokasi file pdf kedalam riwayat
			// $data['FILE_PDF'] = $lokasifile." ".$formatberkas." ".$tmt." ".$nip_baru." ".$user_update;
			$data['FILE_PDF'] = $namafile_sk;
			$data['FILE_PERTEK_KP'] = $namafile_pertek;
			$data['LAST_UPDATE_USER'] = @$user_update;
			$data['LAST_UPDATE_DATE'] = date("Y-m-d H:i:s");

			$datalama = $this->getdatalama($_POST, 'pangkat_riwayat', 'PANGKAT_RIWAYAT_ID', $data['PANGKAT_RIWAYAT_ID']);
			$ID = $this->model->insertRow($data, $this->input->get_post('PANGKAT_RIWAYAT_ID', true));
			$this->perubahandata($data['PEGAWAI_ID'], 'riwayatpangkat', 'pangkat_riwayat', json_encode($datalama), json_encode($_POST), 'PANGKAT_RIWAYAT_ID', $ID);


			$this->getlastriwayat('pangkat_riwayat', $data['PEGAWAI_ID'], 'TMT_PANGKAT');

			// Input logs
			if ($this->input->get('PANGKAT_RIWAYAT_ID', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull With Data " . json_encode($_POST));
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull With Data " . json_encode($_POST));
			}


			// set data terakhir
			$this->setDataTerakhir($pegawai);

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


		$datalama = $this->getdatalamadelete('pangkat_riwayat', 'PANGKAT_RIWAYAT_ID', $_POST['id']);
		$this->perubahandata($datalama['PEGAWAI_ID'], 'Riwayat Pangkat', 'pangkat_riwayat', json_encode($datalama), 'DELETE', 'PANGKAT_RIWAYAT_ID', $_POST['id']);

		$this->model->destroy($_POST['id']);
		$this->getlastriwayat('pangkat_riwayat', $datalama['PEGAWAI_ID'], 'TMT_PANGKAT');
		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}

	public function setDataTerakhir($pegawai_id)
	{

		// Query 1: Set flag_data_terakhir = 0
		$this->db->query('update pangkat_riwayat as j 
		left join pangkat as p 
		on j.PANGKAT_ID = p.PANGKAT_ID
		set j.FLAG_DATA_TERAKHIR = 0, j.GOLONGAN_NAMA = p.KODE where j.PEGAWAI_ID = ' . $pegawai_id);

		// Query 2: Set flag_data_terakhir = 1
		$this->db->query('UPDATE pangkat_riwayat AS j
		SET j.flag_data_terakhir = 1
		WHERE j.PEGAWAI_ID = ' . $pegawai_id . '
		ORDER BY j.TMT_PANGKAT DESC, j.PANGKAT_ID DESC
		LIMIT 1');

		// Query 3: Update JABATAN_ID_TERAKHIR in table pegawai
		$this->db->query('UPDATE pegawai p
		JOIN (
			SELECT pangkat_riwayat_id, PEGAWAI_ID
			FROM pangkat_riwayat
			WHERE FLAG_DATA_TERAKHIR = 1 AND PEGAWAI_ID = ' . $pegawai_id . '
		) AS j ON p.pegawai_id = j.PEGAWAI_ID
		SET p.PANGKAT_ID_TERAKHIR = j.pangkat_riwayat_id');
	}
}
