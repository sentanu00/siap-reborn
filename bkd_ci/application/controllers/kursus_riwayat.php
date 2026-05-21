<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kursus_riwayat extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'kursus_riwayat';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('kursus_riwayatmodel');
		$this->model = $this->kursus_riwayatmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'kursus_riwayat',
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
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('kursus_riwayat/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}

			// tombol #tambahan untuk push ke siasn
			if ($dt->pnsOrangId != '') {
				#perlu diedit-----------------------------------------------------------------------------------------------------------
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmKirimSiasn(\'' . site_url('kursus_riwayat/kirimsiasn') . '\',' . $dt->$idku . ')"><i></i> Kirim Data Ke SIASN</a>';
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmKirimFileSiasn(\'' . site_url('kursus_riwayat/kirimfilesiasn') . '\',' . $dt->$idku . ')"><i></i> Kirim File Ke SIASN</a>';
			}
			// tombol #tambahan untuk view pdf
			$btn .= '</div>';
			if ($dt->FILE_PDF != '') {
				#perlu diedit--------------------------------------------------
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('kursus_riwayat/viewfile/FILE_PDF') . '/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
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

		echo $this->data['content'] = $this->load->view('kursus_riwayat/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('kursus_riwayat');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('kursus_riwayat/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('kursus_riwayat');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('kursus_riwayat/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}
	public function autocomplete_jenis_diklat()
	{
		$q = $this->input->get('q', true);

		$data = $this->db
			->select('id as id, jenis_diklat as text')
			->like('jenis_diklat', $q)
			->limit(20)
			->get('jenis_diklat')
			->result_array();

		echo json_encode($data);
	}
	public function autocomplete_jenis_kursus()
	{
		$q = $this->input->get('q', true);

		$data = $this->db
			->select('id_siasn as id, nama as text')
			->like('nama', $q)
			->limit(20)
			->get('jenis_kursus')
			->result_array();

		echo json_encode($data);
	}

	public function autocomplete_rumpun_diklat()
	{
		$q = $this->input->get('q', true);

		$data = $this->db
			->select('rumpun_id_siasn as id, nama as text')
			->like('nama', $q)
			->limit(20)
			->get('rumpun_diklat')
			->result_array();

		echo json_encode($data);
	}
	public function autocomplete_instansi()
	{
		$q = $this->input->get('q', true);

		$data = $this->db
			->select('id_siasn as id, nama as text')
			->like('nama', $q)
			->limit(20)
			->get('instansi_siasn')
			->result_array();

		echo json_encode($data);
	}
	public function autocomplete_lokasi()
	{
		$q = $this->input->get('q', true);

		$data = $this->db
			->select('id_siasn as id, nama as text')
			->like('nama', $q)
			->limit(20)
			->get('lokasi_siasn')
			->result_array();

		echo json_encode($data);
	}

	function save()
	{
		//start #tambahan ---------------------------------------------------------------------------------------
		// ambil data siap yang melakukan update / insert
		$user_update = $this->session->userdata('username');
		$_POST['update_by'] = $user_update;

		// cek apakah insert by ada?
		if (empty($_POST['insert_by'])) {
			$_POST['insert_by'] = $user_update;
			$_POST['insert_date'] = date('Y-m-d H:i:s');
		}

		// Query ke tabel jenis_diklat
		$this->db->where('id', $_POST['jenisDiklatId']);
		$jenis = $this->db->get('jenis_diklat')->row(); //nama tabel
		if ($jenis) {
			// $_POST['jenisDiklatId'] = $jenis->id;
			$_POST['jenisKursusSertipikat'] = $jenis->jenis_kursus_sertipikat;
			$_POST['jenisDiklatNama'] = $jenis->jenis_diklat;
		}

		// Query ke tabel jenis_kursus
		$this->db->where('id_siasn', $_POST['jenisKursus']);
		$jenis = $this->db->get('jenis_kursus')->row(); //nama tabel
		if ($jenis) {
			$_POST['jenisKursusNama'] = $jenis->nama;
		}

		// Query ke tabel rumpun_diklat
		$this->db->where('rumpun_id_siasn', $_POST['rumpunDiklat']);
		$jenis = $this->db->get('rumpun_diklat')->row(); //nama tabel
		if ($jenis) {
			$_POST['rumpunDiklatNama'] = $jenis->nama;
		}


		// Query ke tabel instansi_siasn
		$this->db->where('id_siasn', $_POST['instansiId']);
		$jenis = $this->db->get('instansi_siasn')->row(); //nama tabel
		if ($jenis) {
			$_POST['instansi'] = $jenis->nama;
		}

		// Query ke tabel siasnpegawaiid
		$this->db->where('pegawai_id', $_POST['PEGAWAI_ID']);
		$jenis = $this->db->get('siasnpegawaiid')->row(); //nama tabel
		if ($jenis) {
			$_POST['pnsOrangId'] = $jenis->siasnid;
		}

		// Query ke tabel lokasi_siasn
		$this->db->where('id_siasn', $_POST['lokasiId']);
		$jenis = $this->db->get('lokasi_siasn')->row(); //nama tabel
		if ($jenis) {
			$_POST['lokasi'] = $jenis->nama . " " . $jenis->jenis_kabupaten;
		}


		$a = '';
		$namafile_SK = '';
		$pegawai = $_POST['PEGAWAI_ID'];
		$tempfile_file = $_FILES['FILE_PDF']['tmp_name'];
		// $tmt = $_POST['TMT_JABATAN'];

		if ($_FILES['FILE_PDF']['size'] > 1048576) { // 1 MB
			echo "Ukuran file tidak boleh lebih dari 1 MB";
			exit;
		}
		$tanggal_jam = date('YmdHis');
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

		//FILE_PDF
		if ($tempfile_file == '') {
			$namafile_SK = $_POST['file_pdf_cek'];
		} else {
			if ($namafile_SK != '') unlink($_POST['file_pdf_cek']);
			$_FILES["FILE_PDF"]["name"] = 'DIKLATSEMINAR_' . $nip . '_' . $tanggal_jam . '.pdf';
			if (!$this->upload->do_upload('FILE_PDF')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_SK = 'dokumen/' . $nip . '/DIKLATSEMINAR_' . $nip . '_' . $tanggal_jam . '.pdf';
			}
		}


		unset($_POST['file_pdf_cek']);
		//end #tambahan ----------------------------------------------------------------------------------------------

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();

			//start #tambahan 
			$data['FILE_PDF'] = $namafile_SK;
			//end #tambahan 

			$ID = $this->model->insertRow($data, $this->input->get_post('diklat_riwayat_id', true));
			// Input logs
			if ($this->input->get('diklat_riwayat_id', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));


			//start #tambahan ganti
			if ($a == '') {
				$a = "Berhasil Simpan !!";
				$this->insert_post_data_siap($data['FILE_PDF']);
			} else {
				$this->session->set_flashdata('message', SiteHelpers::alert('error', $a));
			}
			echo $a;

			//end #tambahan ganti
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

		$this->delete_siasn($_POST['id']);
		$this->model->destroy($_POST['id']);
		$this->inputLogs("ID : " . $_POST['id'] . "  , Has Been Removed Successfull");
		echo "ID : " . $_POST['id'] . "  , berhasil dihapus !!";
	}

	// ----------------------------------------   start #tambahan   -----------------------------------

	// fungsi #tambahan untuk view pdf
	function viewfile($col, $id)
	{
		#perlu diedit--------------------------------
		$th = $this->db->query("SELECT $col FROM kursus_riwayat WHERE diklat_riwayat_id = '$id'")->row();
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

	// fungsi untuk kirim data ke siasn
	public function kirimsiasn()
	{
		require_once(APPPATH . 'controllers/webservice_bkn.php');
		$this->load->model('webservice_model');

		if ($this->input->is_ajax_request()) {

			$id = $this->input->post('id');
			$this->kirimsiasnbasic($id);
		} else {
			show_error("Permintaan tidak valid.", 400);
		}
	}

	// fungsi untuk kirim file ke siasn 
	public function kirimfilesiasn()
	{
		require_once(APPPATH . 'controllers/webservice_bkn.php');
		$this->load->model('webservice_model');

		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$this->kirimfilesiasnbasic($id);
		} else {
			show_error("Permintaan tidak valid.", 400);
		}
	}

	// fungsi untuk get token ApiMws 
	public function getApiMwsToken()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id/oauth2/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic TkU5WGROUkJUZ0xSNGU5cmx6SGl3d0FsRkhRYTpLUDB0U3lmWVhzSFJtQlB2RU5nb2pqMUN0S2Nh',
				'Cookie: pdns=1091068938.58148.0000'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// Mengubah respons JSON menjadi array asosiatif
		$data = json_decode($response, true);

		// Simpan token API MWS ke dalam sesi
		// $this->session->set_userdata('token_apimws', $data['access_token']);

		return $data['access_token'];
	}

	public function getSsoToken()
	{
		return 'eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA';
	}

	#perlu diedit cek semua
	public function post_data($sso_token, $api_mws_token, $pnsOrangId, $jenisDiklatId, $jenisKursus, $jenisKursusSertipikat, $namaKursus, $institusiPenyelenggara, $nomorSertipikat, $tanggalKursus, $tanggalSelesaiKursus, $tahunKursus, $jumlahJam, $instansiId, $lokasiId, $rumpunDiklatId)
	{
		// echo "uja";
		// if ($eselonId == '0') {
		// 	$eselonId = '';
		// }


		if ($tanggalKursus == '0') {
			$tanggalKursus = '';
		} else if ($tanggalKursus == '0000-00-00 00:00:00' || $tanggalKursus == '0000-00-00') {
			$tanggalKursus = '';
		} else {
			$tanggalKursus = (new DateTime($tanggalKursus))->format('d-m-Y');
		}

		if ($tanggalSelesaiKursus == '0') {
			$tanggalSelesaiKursus = '';
		} else if ($tanggalSelesaiKursus == '0000-00-00 00:00:00' || $tanggalSelesaiKursus == '0000-00-00') {
			$tanggalSelesaiKursus = '';
		} else {
			$tanggalSelesaiKursus = (new DateTime($tanggalSelesaiKursus))->format('d-m-Y');
		}

		// $jenisDiklatId = '12';
		//baru ni, ambil d sheet jenis_kursus
		// $jenisKursusId = '8B91B70E3B7F12E5E050640A29034DA5';
		// $jenisKursus = 'DIKLAT FUNGSIONAL ADMINISTRATOR DATABASE KEPENDUDUKAN';

		$data = [
			"pnsOrangId" => $pnsOrangId,
			"jenisDiklatId" => $jenisDiklatId,
			"jenisKursus" => $jenisKursus,
			"jenisKursusSertipikat" => $jenisKursusSertipikat,
			"namaKursus" => $namaKursus,
			"institusiPenyelenggara" => $institusiPenyelenggara,
			"nomorSertipikat" => $nomorSertipikat,
			"tanggalKursus" => $tanggalKursus,
			"tanggalSelesaiKursus" => $tanggalSelesaiKursus,
			"tahunKursus" => (int) $tahunKursus,
			"jumlahJam" => (int) $jumlahJam,
			"instansiId" => $instansiId,
			"lokasiId" => $lokasiId
		];




		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/kursus/save',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),

			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: ' . $sso_token,
				'Authorization: ' . $api_mws_token,
				'Content-Type: application/json',
				'Cookie: ff8d625df24f2272ecde05bd53b814bc=fff6ac8c4f312ac61c70a7442621f607; pdns=1091068938.13088.0000'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);
		$jabatanData = json_decode($response, true);


		curl_close($curl);
		// print_r($jabatanData);
		return $jabatanData;
	}

	public function post_file($sso_token, $api_mws_token, $id_riwayat, $id_ref_dokumen, $file)
	{

		// $fields = array(
		// 	'id_riwayat' =>   $id_riwayat,
		// 	'id_ref_dokumen' =>   $id_ref_dokumen,
		// 	'file' => new CURLFILE($file)
		// );

		// echo '<pre>';
		// print_r($fields);
		// echo '</pre>';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/upload-dok-rw',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>  array('id_riwayat' => $id_riwayat, 'id_ref_dokumen' => $id_ref_dokumen, 'file' => new CURLFILE($file)),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: multipart/form-data',
				'Accept: application/json',
				'Auth: ' . $sso_token,
				'Authorization: ' . $api_mws_token,
				'Cookie: BIGipServerpool_apiws_prod_8243=1091068938.13088.0000; ff8d625df24f2272ecde05bd53b814bc=72356b83ca8501c29aa28542a6d89aa6'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));



		$response = curl_exec($curl);

		$messagex = '';

		if (curl_errno($curl)) {
			$error_msg = curl_error($curl);
			$messagex = "cURL Error: " . $error_msg . ' --- file : ' . $file;
		} else {
			$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			// echo "HTTP Status Code: " . $http_code . "\n";
			// echo "Response: " . $response;
			$messagex = $response;
		}


		curl_close($curl);
		// $hasil['data']['sso_token'] = $sso_token;
		// $hasil['data']['api_mws_token'] = $api_mws_token;
		// $hasil['data']['return'] = $response;

		// echo $response;
		return $messagex;
		// return $hasil;
	}

	#perlu diedit cek smua satu persatu
	public function kirimsiasnbasic($id)
	{
		if ($id) {


			$this->db->select('k.pnsOrangId, k.jenisDiklatId, k.jenisKursus, k.jenisKursusSertipikat, k.namaKursus, k.institusiPenyelenggara, k.nomorSertipikat, k.tanggalKursus, k.tanggalSelesaiKursus, k.tahunKursus, k.jumlahJam, k.instansiId, k.lokasiId, k.rumpunDiklat');
			$this->db->from('kursus_riwayat k');
			$this->db->where('k.diklat_riwayat_id', $id);
			$query = $this->db->get();



			// echo "yuhu " . $id;

			if ($query->num_rows() > 0) {
				$result = $query->row(); // Mengambil baris pertama sebagai objek

				// echo "yuhu 2";
				// Menyimpan properti hasil query ke dalam variabel
				$pnsOrangId = $result->pnsOrangId;
				$jenisDiklatId = $result->jenisDiklatId;
				$jenisKursus = $result->jenisKursusNama; //ambil di sheet kursus idnya aja
				$jenisKursusSertipikat = $result->jenisKursusSertipikat;
				$namaKursus = $result->namaKursus;
				$institusiPenyelenggara = $result->institusiPenyelenggara;
				$nomorSertipikat = $result->nomorSertipikat;
				$tanggalKursus = $result->tanggalKursus;
				$tanggalSelesaiKursus = $result->tanggalSelesaiKursus;
				$tahunKursus = $result->tahunKursus;
				$jumlahJam = $result->jumlahJam;
				$instansiId = $result->instansiId;
				$lokasiId = $result->lokasiId;
				$rumpunDiklatId = $result->rumpunDiklat;

				$datacek = [
					"pnsOrangId" => $pnsOrangId,
					"jenisDiklatId" => $jenisDiklatId,
					"jenisKursus" => $jenisKursus,
					"jenisKursusSertipikat" => $jenisKursusSertipikat,
					"namaKursus" => $namaKursus,
					"institusiPenyelenggara" => $institusiPenyelenggara,
					"nomorSertipikat" => $nomorSertipikat,
					"tanggalKursus" => $tanggalKursus,
					"tanggalSelesaiKursus" => $tanggalSelesaiKursus,
					"tahunKursus" => (int) $tahunKursus,
					"jumlahJam" => (int) $jumlahJam,
					"instansiId" => $instansiId,
					"lokasiId" => $lokasiId
				];
				$jsoncek = json_encode($datacek, JSON_PRETTY_PRINT);


				// echo $jenisDiklatId . " - " . $jenisKursus . " - " . $jenisKursusSertipikat;



				$hasil = $this->post_data('bearer ' . $this->getSsoToken(), 'Bearer ' . $this->getApiMwsToken(), $pnsOrangId, $jenisDiklatId, $jenisKursus, $jenisKursusSertipikat, $namaKursus, $institusiPenyelenggara, $nomorSertipikat, $tanggalKursus, $tanggalSelesaiKursus, $tahunKursus, $jumlahJam, $instansiId, $lokasiId, $rumpunDiklatId);

				// echo "<br>success : " . $hasil["success"];
				// echo "<br>rwKursusId : " . $hasil["mapData"];
				if ($hasil["success"] == '1') {
					// echo "<br>message :" . $hasil["message"];

					$this->db->where('diklat_riwayat_id', $id);
					$this->db->update('kursus_riwayat', array(
						'kursus_id_siasn' => $hasil["mapData"]["rwKursusId"],
						'message' => $hasil["message"],
						'sync_date' => date('Y-m-d H:i:s'),
						'keterangansingkron' => 'Singkron Dengan SIASN'
					));

					// Periksa apakah update berhasil
					if ($this->db->affected_rows() > 0) {
						echo $hasil["message"];
						$this->inputLogs("ID : " . $_POST['id'] . "  , sukses kirim kursus ke siasn dengan data " . json_encode($_POST));
					} else {
						echo "Gagal kirim SIASN";
						$this->inputLogs("ID : " . $_POST['id'] . "  , gagal kirim kursus ke siasn");
					}
				} else {

					echo $hasil["message"];
					$this->db->where('diklat_riwayat_id', $id);
					$this->db->update('kursus_riwayat', array(
						'message' => $hasil["message"] . ' - ' . $jsoncek . ' - ssotoken : ' . 'bearer ' . $this->getApiMwsToken() . ' - api_mws_token : ' . 'Bearer ' . $this->getApiMwsToken(),
						'sync_date' => date('Y-m-d H:i:s'),
						'keterangansingkron' => ''
					));

					// Periksa apakah update berhasil
					if ($this->db->affected_rows() > 0) {
						echo $hasil["message"];

						$this->inputLogs("ID : " . $_POST['id'] . "  , sukses kirim ke siasn");
					} else {
						echo "Gagal kirim SIASN";

						$this->inputLogs("ID : " . $_POST['id'] . "  , sukses kirim ke siasn");
					}
				}


				// print_r($hasil);
			} else {
				// echo 'No data found.';
			}
		} else {
			echo json_encode(['error' => 'ID tidak ditemukan.']);
		}
	}

	// // copy file pdf dari yang  di tampilkan aplikasi siap ke folder tmp_dikumen sebelum dikirim ke siasn
	// public function copyToTemp($source_path)
	// {
	// 	// Tentukan lokasi folder temporary
	// 	$temp_path = "siap/bkd_ci/tmp_dokumen/";

	// 	// Cek apakah folder temporary ada, jika tidak maka buat foldernya
	// 	if (!is_dir($temp_path)) {
	// 		mkdir($temp_path, 0777, true);
	// 	}

	// 	// echo "Folder temporary dibuat di: " . realpath($temp_path) . "<br>";

	// 	// URL sumber file
	// 	// $source_url = "http://localhost/siap_reborn_20241002/bkd_ci/" . $source_path;
	// 	$source_url = "https://siap-bkpsdm.probolinggokab.go.id/" . $source_path;
	// 	// echo $source_url;

	// 	// Nama file untuk disimpan di folder temporary
	// 	$file_name = basename($source_url);  // Hanya ambil nama file dari URL
	// 	$destination_path = $temp_path . $file_name;

	// 	// Ambil konten file dari URL
	// 	$file_content = file_get_contents($source_url);

	// 	// Cek apakah pengambilan konten berhasil
	// 	if ($file_content === false) {

	// 		echo "Gagal mendapatkan konten file";
	// 		return false; // Gagal mendapatkan konten file

	// 	}

	// 	// Coba menulis file ke folder temporary
	// 	$result = file_put_contents($destination_path, $file_content);

	// 	if ($result === false) {
	// 		echo "Gagal menulis file ke: $destination_path";
	// 		// Kamu bisa menambahkan informasi tambahan untuk debugging
	// 		error_log("Gagal menulis file ke folder temporary: $destination_path");
	// 		return false;
	// 	} else {
	// 		// echo "File berhasil disalin ke: $destination_path";
	// 		return true;
	// 	}
	// }

	public function copyToTemp($relative_path)
	{
		// File sumber di dalam container
		$source_path = '/' . ltrim($relative_path, '/');

		// Folder temp di dalam project
		$temp_path = FCPATH . 'tmp_dokumen/';

		// Buat folder jika belum ada
		if (!is_dir($temp_path)) {
			mkdir($temp_path, 0777, true);
		}

		if (!file_exists($source_path)) {
			echo "File sumber tidak ditemukan: " . $source_path;
			return false;
		}

		$destination_path = $temp_path . basename($source_path);

		if (copy($source_path, $destination_path)) {
			return true;
		} else {
			echo "Gagal copy ke temp";
			return false;
		}
	}

	// hapus semua yang ada di tmp_dokumen
	public function deleteAllTempFiles()
	{
		$temp_directory = "tmp_dokumen/";

		// Cek apakah folder temporary ada
		if (is_dir($temp_directory)) {
			// Ambil semua file di dalam folder
			$files = scandir($temp_directory);

			foreach ($files as $file) {
				// Lewati direktori '.' dan '..'
				if ($file !== '.' && $file !== '..') {
					$file_path = $temp_directory . $file;

					// Hapus file jika itu adalah file
					if (is_file($file_path)) {
						unlink($file_path);
					}
				}
			}
			return true; // Semua file berhasil dihapus
		} else {
			return false; // Folder tidak ditemukan
		}
	}

	#perlu diedit cek satu per satu
	public function kirimfilesiasnbasic($id)
	{
		if ($id) {




			$this->db->select('k.kursus_id_siasn, k.pnsOrangId, k.jenisDiklatId, k.jenisKursus, k.jenisKursusSertipikat, k.namaKursus, k.institusiPenyelenggara, k.nomorSertipikat, k.tanggalKursus, k.tanggalSelesaiKursus, k.tahunKursus, k.jumlahJam, k.instansiId, k.lokasiId, k.FILE_PDF');
			$this->db->from('kursus_riwayat k');
			$this->db->where('k.diklat_riwayat_id', $id);
			$query = $this->db->get();


			if ($query->num_rows() > 0) {
				$result = $query->row(); // Mengambil baris pertama sebagai objek

				$file2 = '';
				if ($this->copyToTemp($result->FILE_PDF)) {
					// $file2 = $_SERVER['DOCUMENT_ROOT'] . "/siap_reborn_20241002/bkd_ci/tmp_dokumen/" . basename($result->FILE_PDF);
					// $file2 = $_SERVER['DOCUMENT_ROOT'] . "/siap/bkd_ci/tmp_dokumen/" . basename($result->FILE_PDF);
					$file2 = FCPATH . 'tmp_dokumen/' . basename($result->FILE_PDF);
				} else {
					echo "gagal copy";
				}


				// Cek apakah file ada di path tersebut
				if (file_exists($file2)) {
					// echo "File ditemukan di path absolut: " . $absolute_path;

					// sesuaikan ------>
					$id_ref_dokumen = '881';

					// sesuaikan ------------------------------------------------------------------------------------------------->
					$hasil = $this->post_file('bearer ' . $this->getSsoToken(), 'Bearer ' . $this->getApiMwsToken(), $result->kursus_id_siasn, $id_ref_dokumen, $file2);
					// $hasil = $this->post_filecoba('bearer ' . $this->getSsoToken(), 'Bearer ' . $this->getApiMwsToken(), $result->RW_JABATAN_ID_SAPK, $id_ref_dokumen, $file2);

					$responseArray = json_decode($hasil, true);
					echo $responseArray["message"];
					$this->db->where('diklat_riwayat_id', $id);
					$this->db->update('kursus_riwayat', array(
						'messageFile' => $responseArray["message"],
						'filesync_date' => date('Y-m-d H:i:s')
					));
					$this->deleteAllTempFiles();
					// exit();

					// print_r($hasil);

				} else {
					echo " File tidak ditemukan. Path absolut: " . $file2;
					$this->db->where('diklat_riwayat_id', $id);
					$this->db->update('kursus_riwayat', array(
						'messageFile' => " File tidak ditemukan. Path absolut: " . $file2,
						'filesync_date' => date('Y-m-d H:i:s')
					));
					// echo "<br> http://localhost/siap_reborn_20241002/bkd_ci/" . $result->FILE_PDF;
					// exit();
				}

				//------------------------------


			} else {
				// echo 'No data found.';
			}
		} else {
			echo json_encode(['error' => 'ID tidak ditemukan.']);
		}
	}
	// ----------------------------------------   End #tambahan   -----------------------------------


	public function kirimSemuakursusKeSiasn()
	{



		$this->db->select('diklat_riwayat_id');
		$this->db->from('kursus_riwayat');
		$this->db->where('message IS NULL', null, false); // penting: biar tidak auto-escape IS NULL
		$this->db->where("(pnsOrangId IS NOT NULL AND pnsOrangId != '')", null, false);
		$this->db->order_by('sync_date', 'ASC');


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->diklat_riwayat_id;
				echo "<b>Mulai kirim ID:</b> $id<br>";
				$this->kirimsiasnbasic($id);
				echo "<br>--- Selesai kirim ID: $id ---<br><br>";
				ob_flush();
				flush(); // agar tampil realtime kalau via browser
				sleep(1); // opsional: beri delay agar tidak overload
			}
			echo "<br><b>Selesai kirim semua data.</b>";
		} else {
			echo "Tidak ada data yang perlu dikirim.";
		}
	}


	public function kirimSemuafilekursusKeSiasn()
	{



		$this->db->select('diklat_riwayat_id');
		$this->db->from('kursus_riwayat');
		$this->db->where('messageFile IS NULL', null, false); // penting: biar tidak auto-escape IS NULL
		$this->db->where("kursus_id_siasn != ''", null, false);
		$this->db->where("(FILE_PDF IS NOT NULL AND FILE_PDF != '')", null, false);
		$this->db->order_by('sync_date', 'ASC');


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->diklat_riwayat_id;
				echo "<b>Mulai kirim ID:</b> $id<br>";
				$this->kirimfilesiasnbasic($id);
				echo "<br>--- Selesai kirim ID: $id ---<br><br>";
				ob_flush();
				flush(); // agar tampil realtime kalau via browser
				sleep(1); // opsional: beri delay agar tidak overload
			}
			echo "<br><b>Selesai kirim semua data.</b>";
		} else {
			echo "Tidak ada data yang perlu dikirim.";
		}
	}


	//============================= fitur tambahan untuk kirim data siap ke SIASN =============================
	public function insert_post_data_siap($file_pdf)
	{
		// ambil data dari jabatan_riwayat berdasarkan file_pdf
		$this->db->select("s.siasnid as pnsId,
        k.PEGAWAI_ID,
        k.diklat_riwayat_id as id_table,
        k.pnsOrangId, 
        k.jenisDiklatId, 
        k.jenisKursus, 
        k.jenisKursusSertipikat, 
        k.namaKursus, 
        k.institusiPenyelenggara, 
        k.nomorSertipikat, 
        k.tanggalKursus, 
        k.tanggalSelesaiKursus, 
        k.tahunKursus, 
        k.jumlahJam, 
        k.instansiId, 
        k.lokasiId, 
        k.rumpunDiklat");


		$this->db->from('kursus_riwayat k');
		$this->db->join('siasnpegawaiid s', 'k.PEGAWAI_ID = s.pegawai_id', 'left');
		$this->db->where('k.FILE_PDF', $file_pdf);

		$row = $this->db->get()->row();

		if (!$row) {
			return "Data tidak ditemukan untuk file_pdf: " . $file_pdf;
		}

		// mapping ke variabel lama biar gak banyak ubah kode bawah
		$id_table = $row->id_table;
		$PEGAWAI_ID = $row->PEGAWAI_ID;
		$FILE_PDF = $row->FILE_PDF;

		$tanggalKursus = ($row->tanggalKursus && $row->tanggalKursus != '0000-00-00' && $row->tanggalKursus != '0000-00-00 00:00:00')
			? (new DateTime($row->tanggalKursus))->format('d-m-Y') : '';
		$tanggalSelesaiKursus = ($row->tanggalSelesaiKursus && $row->tanggalSelesaiKursus != '0000-00-00' && $row->tanggalSelesaiKursus != '0000-00-00 00:00:00')
			? (new DateTime($row->tanggalSelesaiKursus))->format('d-m-Y') : '';


		$nama = '/kursus/save';
		$table_name = 'kursus_riwayat';
		$url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/kursus/save';

		$bodyjson = json_encode([
			"pnsOrangId" => $row->pnsId,
			"jenisDiklatId" => $row->jenisDiklatId,
			"jenisKursus" => $row->jenisKursus,
			"jenisKursusSertipikat" => $row->jenisKursusSertipikat,
			"namaKursus" => $row->namaKursus,
			"institusiPenyelenggara" => $row->institusiPenyelenggara,
			"nomorSertipikat" => $row->nomorSertipikat,
			"tanggalKursus" => $tanggalKursus,
			"tanggalSelesaiKursus" => $tanggalSelesaiKursus,
			"tahunKursus" => (int) $row->tahunKursus,
			"jumlahJam" => (int) $row->jumlahJam,
			"instansiId" => $row->instansiId,
			"lokasiId" => $row->lokasiId
		]);

		$data = [
			'id_table' => $id_table,
			'PEGAWAI_ID' => $PEGAWAI_ID,
			'nama' => $nama,
			'table_name' => $table_name,
			'url' => $url,
			'bodyjson' => $bodyjson,
			'status' => 'siap kirim data',
			'postget' => 'POST',
			'create_date' => date('Y-m-d H:i:s')
		];

		$this->db->insert('post_data_siap', $data);

		if ($this->db->affected_rows() > 0) {

			// $data2 = [
			// 	'table_name' => $table_name,
			// 	'id_table' => $id_table,
			// 	'nama' => '/pns/data-utama-jabatansync',
			// 	'PEGAWAI_ID' => $PEGAWAI_ID,
			// 	'url' => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama-jabatansync?pns_orang_id=' . $pnsId,
			// 	'status' => 'siap kirim data',
			// 	'postget' => 'GET',
			// 	'create_date' => date('Y-m-d H:i:s')
			// ];

			// $this->db->insert('post_data_siap', $data2);

			$file = FCPATH . "tmp_dokumen/" . basename($FILE_PDF);
			$bodyjson = json_encode([
				"id_riwayat" => '',
				"id_ref_dokumen" => '881', // id ref dapat dari tabel refrensi BKN
				"file" => new CURLFILE($file)
			]);

			$uploadfile = [
				'table_name' => $table_name,
				'id_table' => $id_table,
				'nama' => '/upload-dok',
				'PEGAWAI_ID' => $PEGAWAI_ID,
				'url' => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/upload-dok-rw',
				'bodyjson' => $bodyjson,
				'status' => 'siap kirim file',
				'postget' => 'POST',
				'create_date' => date('Y-m-d H:i:s')
			];

			$this->db->insert('post_data_siap', $uploadfile);




			return "Data berhasil dimasukkan ke tabel post_data_siap.";
		} else {
			return "Gagal insert data.";
		}
	}


	public function delete_siasn($id)
	{

		$this->db->select("
        j.diklat_riwayat_id,
        j.PEGAWAI_ID
    ");


		$this->db->from('kursus_riwayat j');
		$this->db->where('j.diklat_riwayat_id', $id);

		$row = $this->db->get()->row();

		// jika kursus_id_siasn kosong/null
		if (empty($row->kursus_id_siasn)) {

			$this->db->where('table_name', 'kursus_riwayat'); //sesuaikan table_name nya...
			$this->db->where('id_table', $id);
			$this->db->delete('post_data_siap');
		} /*else {

			$data = [
				'table_name' => 'kursus_riwayat',
				'id_table' => $id,
				'nama' => '/jabatan/delete/',
				'PEGAWAI_ID' => $row->PEGAWAI_ID,
				'url' => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/jabatan/delete/' . $row->RW_JABATAN_ID_SAPK,
				'status' => 'siap kirim data',
				'postget' => 'DELETE',
				'create_date' => date('Y-m-d H:i:s')
			];

			$this->db->insert('post_data_siap', $data);
		}*/
	}
}
