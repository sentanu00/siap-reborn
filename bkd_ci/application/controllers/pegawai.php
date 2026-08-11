<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'pegawai';
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
			'pageTitle'	=> 	$this->info['title'],
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

		$satker = $_GET['satker'];
		$sttpeg = $_GET['sttpeg'];

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
		if ($gid == 2) {
			$filter .= " AND SATKER_ID LIKE '$sat%'";
		} else if ($gid == 4) {
			$filter .= " AND SATKER_ID LIKE '$sat%'";
		} else if ($gid == 3) {
			$filter .= " AND NIP_BARU = '" . $this->session->userdata('username') . "'";
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

		$this->data['content'] = $this->load->view('pegawai/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('pegawai');
		}

		$this->data['id'] = $id;
		$this->data['content'] =  $this->load->view('pegawai/view', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function add($id = null)
	{
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");


		$row = $this->model->getRow($id);


		if ($row) {
			$this->data['row'] =  $row;
			$foto = $this->db->query("select p.FOTO, p.FOTO_SETENGAH from pegawai as p where p.PEGAWAI_ID = '" . $id . "'")->row();

			$this->data['fotoprofile'] =  $this->getfotoprofile($row['NIP_BARU'], $foto->FOTO_SETENGAH);
		} else {
			$this->data['row'] = $this->model->getColumnTable('pegawai');
			$this->data['fotoprofile'] = $this->getfotoprofile('', '');
		}



		$this->data['id'] = $id;
		$this->data['content'] = $this->load->view('pegawai/form', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function profile($id = null)
	{
		$rowx = $this->db->query("SELECT * FROM pegawai where NIP_BARU ='" . $id . "'")->row();
		$row = $this->model->getRow($rowx->PEGAWAI_ID);
		//var_dump($row);die();
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('pegawai');
		}


		$this->data['id'] = $rowx->PEGAWAI_ID;
		$this->data['content'] = $this->load->view('pegawai/profil', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}

	function satkerpilih()
	{
		echo $this->load->view('pegawai/treesatker', $this->data, true);
	}

	function getsatker()
	{
		$id = $_POST['id'];
		$satkernama = "";
		// $c = $this->db->query("SELECT CONCAT((SELECT NAMA FROM satker WHERE satker_id = LEFT('" . $id . "',2)),' - ',NAMA) as NAMA FROM satker WHERE SATKER_ID = '" . $id . "'")->row();
		$c = $this->db->query("select s.hirarki_nama as NAMA from satker s where s.SATKER_ID ='" . $id . "'")->row();
		if ($c) $satkernama = $c->NAMA;
		echo $satkernama;
	}


	function identitas()
	{
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// // header("Pragma: no-cache");
		// header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

		$id = $_REQUEST['id'];
		$row = $this->model->getRow($id);
		$satkernama = '';
		if ($row) {

			$this->createNIPFolder($row['NIP_BARU']);
			$foto = $this->db->query("select p.FOTO, p.FOTO_SETENGAH from pegawai as p where p.PEGAWAI_ID = '" . $id . "'")->row();

			// $c = $this->db->query("SELECT CONCAT((SELECT NAMA FROM satker WHERE satker_id = LEFT('" . $row['SATKER_ID'] . "',2)),' - ',NAMA) as NAMA FROM satker WHERE SATKER_ID = '" . $row['SATKER_ID'] . "'")->row();
			$c = $this->db->query("select s.hirarki_nama as NAMA from satker s where s.SATKER_ID ='" . $row['SATKER_ID'] . "'")->row();
			if ($c) $satkernama = $c->NAMA;

			$this->data['pangkat'] = $this->db->query("SELECT a.*,b.KODE AS KODEPANGKAT,b.NAMA as NAMAPANGKAT FROM pangkat_riwayat a INNER JOIN pangkat b ON a.PANGKAT_ID=b.PANGKAT_ID WHERE PEGAWAI_ID = '$id' ORDER BY TMT_PANGKAT DESC LIMIT 1")->row();

			$this->data['gaji'] = $this->db->query("SELECT * FROM gaji_riwayat WHERE PEGAWAI_ID = '$id' ORDER BY TMT_SK DESC LIMIT 1")->row();
			$this->data['jabatan'] = $this->db->query("SELECT * FROM jabatan_riwayat WHERE PEGAWAI_ID = '$id' ORDER BY TMT_JABATAN DESC LIMIT 1")->row();
			$this->data['pendidikan'] = $this->db->query("SELECT * FROM pendidikan_riwayat WHERE PEGAWAI_ID = '$id' ORDER BY TANGGAL_STTB DESC  LIMIT 1")->row();


			$this->data['FOTO'] =  $this->getfotofull($row['NIP_BARU'], $foto->FOTO);
			$this->data['FOTO_SETENGAH'] = $this->getfotosetengah($row['NIP_BARU'], $foto->FOTO_SETENGAH);

			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('pegawai');
			$this->data['pangkat'] = '';
			$this->data['gaji'] = '';
			$this->data['jabatan'] = '';
			$this->data['pendidikan'] = '';
			$this->data['FOTO'] = base_url('male.png');
			$this->data['FOTO_SETENGAH'] = base_url('male.png');
		}

		$this->data['id'] = $id;
		$this->data['SATKER_NAMA'] = $satkernama;
		$this->load->view('pegawai/formpegawai', $this->data);
	}

	function skcpns()
	{
		$idpeg = $_REQUEST['id'];
		$a = $this->db->query("SELECT * FROM sk_cpns where PEGAWAI_ID = '$idpeg'")->row_array();
		if ($a) {
			$this->data['row'] = $a;
		} else {
			$this->data['row'] = $this->model->getColumnTable('sk_cpns');
		}

		$this->data['PEGAWAI_ID'] = $idpeg;
		$this->load->view('skcpns/form', $this->data);
	}

	function skpppk()
	{
		$idpeg = $_REQUEST['id'];
		$a = $this->db->query("SELECT * FROM sk_cpns where PEGAWAI_ID = '$idpeg'")->row_array();
		if ($a) {
			$this->data['row'] = $a;
		} else {
			$this->data['row'] = $this->model->getColumnTable('sk_cpns');
		}

		$this->data['PEGAWAI_ID'] = $idpeg;
		$this->load->view('skpppk/form', $this->data);
	}

	function skpns()
	{
		$idpeg = $_REQUEST['id'];
		$a = $this->db->query("SELECT * FROM sk_pns where PEGAWAI_ID = '$idpeg'")->row_array();
		if ($a) {
			$this->data['row'] = $a;
		} else {
			$this->data['row'] = $this->model->getColumnTable('sk_pns');
		}

		$this->data['PEGAWAI_ID'] = $idpeg;
		$this->load->view('skpns/form', $this->data);
	}

	function getfotoprofile($nip, $foto)
	{
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// // header("Pragma: no-cache");
		// header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");


		$folder = "foto/" . $nip . "/" .  $foto;
		if (file_exists($folder)) {
			return base_url($folder);
		} else {
			return "http://siap.bkd.probolinggokab.go.id:8082/main/foto/" . $nip . "/" .  $foto;
		}
	}


	function getfotosetengah($nip, $foto)
	{
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");


		$folder = "foto/" . $nip . "/" .  $foto;
		if (file_exists($folder)) {
			return base_url($folder);
		} else {
			return "http://siap.bkd.probolinggokab.go.id:8082/main/foto/" . $nip . "/" .  $foto;
		}
	}

	function getfotofull($nip, $foto)
	{
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");

		$folder = "foto/" . $nip . "/" . $foto;
		if (file_exists($folder)) {
			return base_url($folder);
		} else {
			return "http://siap.bkd.probolinggokab.go.id:8082/main/foto/" . $foto;
		}
	}





	function save()
	{
		//var_dump($_FILES);die();
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");

		unset($_POST['ID_SAPK']);
		$errorfoto = '';
		try {
			$foto_lama = $this->db->query("SELECT FOTO, FOTO_SETENGAH FROM pegawai WHERE PEGAWAI_ID = '" . $_POST['PEGAWAI_ID'] . "'")->row();
			// Lakukan sesuatu dengan $foto_lama jika query berhasil
		} catch (Exception $e) {
			$errorfoto = "Terjadi kesalahan: " . $e->getMessage();
		}

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();
			$data['KABUPATEN_ID'] = $this->getidwil($data['KABUPATEN_ID']);
			$data['KECAMATAN_ID'] = $this->getidwil($data['KECAMATAN_ID']);
			$data['KELURAHAN_ID'] = $this->getidwil($data['KELURAHAN_ID']);

			foreach ($_POST as $key => $value) {
				$fld[] = $key;
			}

			$field = implode(", ", $fld);
			$datalama = $this->db->query("SELECT " . $field . " FROM pegawai WHERE PEGAWAI_ID = '" . $_POST['PEGAWAI_ID'] . "'")->row_array();

			$ID = $this->model->insertRow($data, $this->input->get_post('PEGAWAI_ID', true));
			$_POST['PEGAWAI_ID'] = $ID;
			$_POST['KABUPATEN_ID'] = $this->getidwil($data['KABUPATEN_ID']);
			$_POST['KECAMATAN_ID'] = $this->getidwil($data['KECAMATAN_ID']);
			$_POST['KELURAHAN_ID'] = $this->getidwil($data['KELURAHAN_ID']);

			$databaru = $_POST;
			$this->perubahandata($data['PEGAWAI_ID'], 'identitas', 'pegawai', json_encode($datalama), json_encode($databaru), 'PEGAWAI_ID', $ID);

			$FOTO = $_FILES['FOTO']['name'];
			$FOTO_SETENGAH = $_FILES['FOTO_SETENGAH']['name'];

			$folder = "foto/" . $_POST['NIP_BARU'] . "/";
			if (!is_dir($folder))
				mkdir($folder);
			$notif = '';
			$extFOTO = pathinfo($FOTO, PATHINFO_EXTENSION);
			if (isset($_FILES["FOTO"]["tmp_name"]) && !empty($_FILES["FOTO"]["tmp_name"])) {

				// File berhasil diunggah, lakukan sesuatu
				// $foto_tmp_name = $_FILES["FOTO"]["tmp_name"];
				// Lakukan sesuatu dengan file yang diunggah di sini
				$randomNumber = rand(100, 999); // Menghasilkan angka acak antara 100 dan 999
				$nameFOTO = "foto_full_" . $_POST['NIP_BARU'] . "_" . $randomNumber . "_" . date("YmdHis") . ".jpeg";
				// $nameFOTO = "foto_full_" . $_POST['NIP_BARU'] . ".jpeg";
				move_uploaded_file($_FILES["FOTO"]["tmp_name"], $folder . $nameFOTO);
				// $this->db->query("UPDATE pegawai as p set p.FOTO = '" . $nameFOTO . "' , p.FOTO_SETENGAH = '" . $foto_lama->FOTO_SETENGAH . "' where p.PEGAWAI_ID = '" . $_POST['PEGAWAI_ID'] . "'");

				$notif = 'foto ada ' . $nameFOTO;
			} else {
				// File tidak diunggah atau tidak ada file yang diunggah
				// Lakukan sesuatu jika diperlukan
				$nameFOTO = $foto_lama->FOTO;

				$notif = 'foto tidak ada ' . $nameFOTO;
			}


			$extFOTO_SETENGAH = pathinfo($FOTO_SETENGAH, PATHINFO_EXTENSION);
			if (isset($_FILES["FOTO_SETENGAH"]["tmp_name"]) && !empty($_FILES["FOTO_SETENGAH"]["tmp_name"])) {

				// File berhasil diunggah, lakukan sesuatu
				// $foto_tmp_name = $_FILES["FOTO"]["tmp_name"];
				// Lakukan sesuatu dengan file yang diunggah di sini
				$randomNumber = rand(100, 999); // Menghasilkan angka acak antara 100 dan 999
				$nameFOTO_SETENGAH = "foto_setengah_" . $_POST['NIP_BARU'] . "_" . $randomNumber . "_" . date("YmdHis") . ".jpeg";
				move_uploaded_file($_FILES["FOTO_SETENGAH"]["tmp_name"], $folder . $nameFOTO_SETENGAH);
				// $this->db->query("UPDATE pegawai as p set p.FOTO = '" . $foto_lama->FOTO . "',  p.FOTO_SETENGAH = '" . $nameFOTO_SETENGAH . "' where p.PEGAWAI_ID = '" . $_POST['PEGAWAI_ID'] . "'");

				$notif = $notif . 'foto setengah ada ' . $nameFOTO_SETENGAH;
			} else {
				// File tidak diunggah atau tidak ada file yang diunggah
				// Lakukan sesuatu jika diperlukan
				$nameFOTO_SETENGAH = $foto_lama->FOTO_SETENGAH;

				$notif = $notif . 'foto setengah tidak ada : ' . $foto_lama->FOTO_SETENGAH;
			}

			// $this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull" . $notif);
			// $data =	array(
			// 	'message'	=> 'Ops , The following errors occurred : ' . $notif,
			// 	'errors'	=> validation_errors('<li>', '</li>')
			// );
			// $this->displayError($data);


			$this->db->query("UPDATE pegawai as p set p.FOTO = '" . $nameFOTO . "' , p.FOTO_SETENGAH = '" . $nameFOTO_SETENGAH . "' where p.PEGAWAI_ID = '" . $_POST['PEGAWAI_ID'] . "'");


			// Input logs
			if ($this->input->get('PEGAWAI_ID', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {

				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	

			$this->db->query("update pegawai as p set p.ws_check_push = '0' where p.PEGAWAI_ID = '" . $_POST['PEGAWAI_ID'] . "'");

			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
			redirect('pegawai/add/' . $ID, 301);
		} else {
			$data =	array(
				'message'	=> 'Ops , The following errors occurred',
				'errors'	=> validation_errors('<li>', '</li>')
			);
			$this->displayError($data);
		}
	}


	function getidwil($d)
	{
		$dx = explode('*', $d);
		$l = count($dx);
		return $dx[$l - 1];
	}

	function destroy()
	{
		// if ($this->access['is_remove'] == 0) {
		// 	echo "err : maaf anda tidak memiliki hak untuk menghapus data";
		// }

		// $datalama = $this->db->query("SELECT * FROM pegawai WHERE PEGAWAI_ID = '" . $_POST['id'] . "'")->row_array();
		// $this->perubahandata($_POST['id'], 'identitas', 'pegawai', json_encode($datalama), 'DELETE', 'PEGAWAI_ID', $_POST['id']);

		// $this->model->destroy($_POST['id']);
		// $this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		// echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
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


	function updatelastdatajabatan()
	{
		//$th = $this->db->query("UPDATE `jabatan_riwayat` SET FLAG_DATA_TERAKHIR = 0");
		$rx = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE STATUS_PEGAWAI IN (9,2,1,0,10)")->result();
		foreach ($rx as $k) {
			$ro = $this->db->query("SELECT MAX(DATE(TMT_JABATAN)) as xx FROM jabatan_riwayat WHERE PEGAWAI_ID = '" . $k->PEGAWAI_ID . "'")->row();
			if ($ro) {
				$this->db->query("UPDATE `jabatan_riwayat` SET FLAG_DATA_TERAKHIR = 1 WHERE PEGAWAI_ID = '" . $k->PEGAWAI_ID . "' AND DATE(TMT_JABATAN) ='" . $ro->xx . "'");
			}
		}
	}

	function updatelastdatapangkat()
	{
		//$th = $this->db->query("UPDATE `pangkat_riwayat` SET FLAG_DATA_TERAKHIR = 0");
		$rx = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE STATUS_PEGAWAI IN (9,2,1,0,10)")->result();
		foreach ($rx as $k) {
			$ro = $this->db->query("SELECT MAX(DATE(TMT_PANGKAT)) as xx FROM pangkat_riwayat WHERE PEGAWAI_ID = '" . $k->PEGAWAI_ID . "'")->row();
			if ($ro) {
				$this->db->query("UPDATE `pangkat_riwayat` SET FLAG_DATA_TERAKHIR = 1 WHERE PEGAWAI_ID = '" . $k->PEGAWAI_ID . "' AND DATE(TMT_PANGKAT) ='" . $ro->xx . "'");
				//die();
			}
		}
	}

	function createNIPFolder($nip)
	{
		// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// header("Cache-Control: post-check=0, pre-check=0", false);
		// header("Pragma: no-cache");

		$baseFolder = 'dokumen';
		$nipFolder = $baseFolder . '/' . $nip;

		// Periksa apakah folder dengan nama NIP sudah ada
		if (!file_exists($nipFolder)) {
			// Jika folder belum ada, maka buat folder baru
			if (mkdir($nipFolder, 0777, true)) {
				// echo "Folder $nipFolder berhasil dibuat.";
			} else {
				// echo "Gagal membuat folder $nipFolder.";
			}
		} else {
			// Jika folder sudah ada, lewati saja
			// echo "Folder $nipFolder sudah ada.";
		}

		$folderfoto = 'foto/' . $nip;
		// Periksa apakah folder dengan nama NIP sudah ada
		if (!file_exists($folderfoto)) {
			// Jika folder belum ada, maka buat folder baru
			if (mkdir($folderfoto, 0777, true)) {
				// echo "Folder $folderfoto berhasil dibuat.";
			} else {
				// echo "Gagal membuat folder $nipFolder.";
			}
		} else {
			// Jika folder sudah ada, lewati saja
			// echo "Folder $nipFolder sudah ada.";
		}
	}


	// Contoh pemanggilan fungsi
	// $nip = "123456789"; // Ganti dengan NIP yang diinginkan
	// createNIPFolder($nip);

}
