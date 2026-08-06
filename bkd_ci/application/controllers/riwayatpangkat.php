<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayatpangkat extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'riwayatpangkat';
	public $per_page	= '10';
	public $idx			= '';

	private $api_mws_token;

	function __construct()
	{
		parent::__construct();

		$this->load->model('riwayatpangkatmodel');
		$this->model = $this->riwayatpangkatmodel;
		$idx = $this->model->primaryKey;
		$this->api_mws_token = $this->model->getApiMwsToken();

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

			// Di dalam loop foreach ($rows as $dt) { ... }
			if ($dt->FILE_PDF != '') {
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('riwayatpangkat/viewfile') . '/FILE_PDF/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
			} else {
				if (!empty($dt->DOK_URI)) {
					$row[] = '<a href="javascript:SximoModal(\'' . site_url('riwayatpangkat/viewfile') . '/FILE_PDF/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px" title="Download dari SIASN"></a>';
				} else {
					$row[] = '<img src="' . base_url('/assets/icon/nodoc.png') . '" style="width:20px">';
				}
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

	// function viewfile($col, $id)
	// {
	// 	$th = $this->db->query("SELECT $col FROM pangkat_riwayat WHERE PANGKAT_RIWAYAT_ID = '$id'")->row();
	// 	$ext = explode(".", $th->$col);
	// 	$maxext = count($ext);
	// 	$extn = $ext[$maxext - 1];
	// 	if ($extn == 'pdf') {
	// 		$urlberkas = base_url($th->$col);
	// 		echo '<iframe src="' . $urlberkas . '?time=' . date('ymdhis') . '" width="100%" height="600px"></iframe>';
	// 	} else {
	// 		$urlberkas = base_url($th->$col);
	// 		echo '<img src="' . $urlberkas . '?time=' . date('ymdhis') . '" style="max-width:100%">';
	// 	}
	// }


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


	/**
	 * Download file dari SIASN berdasarkan DOK_URI
	 * @param string $filePath - DOK_URI dari tabel
	 * @param string $api_mws_token - token akses API
	 * @return string|false - konten file atau false jika gagal
	 */
	private function downloadFromSiasn($filePath, $api_mws_token)
	{
		$url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/download-dok?filePath=' . urlencode($filePath);

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 60,               // timeout lebih lama
			CURLOPT_CONNECTTIMEOUT => 30,         // timeout koneksi
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => [
				'Accept: application/json',
				'Authorization: Bearer ' . $api_mws_token,
				'Auth: bearer eTEkA',            // sesuai contoh
			],
			// Opsi SSL
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,  // paksa TLS 1.2
			CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,        // paksa IPv4
			// Tambahan untuk debugging
			CURLOPT_VERBOSE => true,
			// Untuk menampilkan verbose ke file log (opsional)
			// CURLOPT_STDERR => fopen('/tmp/curl_debug.log', 'w+'),
		]);

		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$curlError = curl_error($curl);
		$curlErrno = curl_errno($curl);
		curl_close($curl);

		// Log detail
		error_log("SIASN download: HTTP $httpCode, CURL errno $curlErrno, URL: $url");
		if ($curlError) {
			error_log("SIASN download CURL error: $curlError");
		}

		if ($httpCode == 200 && empty($curlError)) {
			// Cek apakah response JSON (error)
			$json = json_decode($response, true);
			if ($json !== null && isset($json['message'])) {
				error_log("SIASN download error message: " . $json['message']);
				return ['status' => false, 'message' => $json['message']];
			}
			return ['status' => true, 'content' => $response];
		} else {
			$errorMsg = "HTTP $httpCode";
			if ($curlError) {
				$errorMsg .= " - CURL: $curlError (errno $curlErrno)";
			}
			// Jika JSON error
			$json = json_decode($response, true);
			if (isset($json['message'])) {
				$errorMsg .= " - Message: " . $json['message'];
			}
			error_log("SIASN download failed: $errorMsg");
			return ['status' => false, 'message' => $errorMsg];
		}
	}


	function viewfile($col, $id)
	{
		// Ambil data riwayat pangkat
		$row = $this->db->query("
        SELECT FILE_PDF, DOK_URI, PEGAWAI_ID, TMT_PANGKAT 
        FROM pangkat_riwayat 
        WHERE PANGKAT_RIWAYAT_ID = '$id'
    ")->row();

		if (!$row) {
			echo "Data tidak ditemukan.";
			return;
		}

		// Jika FILE_PDF ada, tampilkan langsung
		if (!empty($row->FILE_PDF)) {
			$this->displayFile($row->FILE_PDF);
			return;
		}

		// Jika tidak ada FILE_PDF dan DOK_URI kosong
		if (empty($row->DOK_URI)) {
			echo "Tidak ada file dan tidak ada referensi DOK_URI.";
			return;
		}

		// Ambil NIP untuk penamaan file
		$pegawai = $this->db->query("SELECT NIP_BARU FROM pegawai WHERE PEGAWAI_ID = '$row->PEGAWAI_ID'")->row();
		if (!$pegawai) {
			echo "Data pegawai tidak ditemukan.";
			return;
		}
		$nip = $pegawai->NIP_BARU;
		$tmt = $row->TMT_PANGKAT; // format Y-m-d atau sesuai

		// Download dari SIASN
		$result = $this->get_file_siasn($row->DOK_URI);

		if ($result['status'] === false) {
			// Tampilkan pesan error detail
			echo "Gagal mengunduh file dari SIASN. Error: " . htmlspecialchars($result['message']);

			echo "api_mws_token : " . $this->api_mws_token . "<br>";
			echo "sso_token : " . $this->sso_token . "<br>";

			return;
		}

		$fileContent = $result['content'];

		// Buat nama file dan path lokal
		$newFilename = 'KP_SK_' . $nip . '_' . $tmt . '.pdf';
		$folder = FCPATH . './dokumen/' . $nip . '/';
		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}
		$savePath = $folder . $newFilename;
		$relativePath = 'dokumen/' . $nip . '/' . $newFilename;

		// Simpan file
		if (file_put_contents($savePath, $fileContent) === false) {
			echo "Gagal menyimpan file ke server. Periksa izin folder.";
			return;
		}

		// Update database
		$this->db->where('PANGKAT_RIWAYAT_ID', $id);
		$this->db->update('pangkat_riwayat', ['FILE_PDF' => $relativePath]);

		// Tampilkan file yang sudah diunduh
		$this->displayFile($relativePath);
	}

	/**
	 * Fungsi bantu menampilkan file
	 */
	private function displayFile($file_path)
	{
		$ext = pathinfo($file_path, PATHINFO_EXTENSION);
		$urlberkas = base_url($file_path) . '?time=' . date('ymdhis');
		if (strtolower($ext) == 'pdf') {
			echo '<iframe src="' . $urlberkas . '" width="100%" height="600px"></iframe>';
		} else {
			echo '<img src="' . $urlberkas . '" style="max-width:100%">';
		}
	}

	/**
	 * Download file dari SIASN menggunakan DOK_URI
	 * @param string $dok_uri - path file dari tabel
	 * @return string|false - konten file atau false jika gagal
	 */
	/**
	 * Download file dari SIASN menggunakan DOK_URI
	 * @param string $dok_uri - path file dari tabel
	 * @return array ['status' => bool, 'content' => string|false, 'message' => string]
	 */
	public function get_file_siasn($dok_uri)
	{
		// Ambil token dari session atau dari model
		$api_mws_token = $this->api_mws_token; // sudah di-set di construct
		// $sso_token = $this->session->userdata('token_sso'); // pastikan session ini ada
		$sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";


		// Jika session tidak ada, gunakan hardcoded (contoh dari fungsi lama)
		// TAPI lebih baik token diambil dari session yang valid saat login
		if (empty($sso_token)) {
			// Hardcoded ini mungkin sudah expired, sebaiknya diisi dengan token terbaru
			$sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA"; // panjang
			error_log("WARNING: token_sso tidak ada di session, menggunakan hardcoded (mungkin expired)");
		}

		$api_mws_token = "Bearer " . $api_mws_token;

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/download-dok?filePath=' . $dok_uri,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: ' . $sso_token,
				'Authorization: ' . $api_mws_token,
				'Cookie: ff8d625df24f2272ecde05bd53b814bc=ce158eaac3b25204bfaa39e480fc50f7; pdns=1091068938.13088.0000'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$curlError = curl_error($curl);
		curl_close($curl);

		// Log detail
		error_log("SIASN download: HTTP $httpCode, DOK_URI: $dok_uri, cURL error: $curlError");

		if ($httpCode == 200 && empty($curlError)) {
			// Cek apakah response adalah JSON error (misal {"message":"..."})
			$json = json_decode($response, true);
			if ($json !== null && isset($json['message'])) {
				error_log("SIASN download error message: " . $json['message']);
				return ['status' => false, 'message' => $json['message']];
			}
			// Cek apakah ini PDF (awalan %PDF-)
			if (substr($response, 0, 5) === "%PDF-") {
				return ['status' => true, 'content' => $response];
			} else {
				error_log("SIASN download response bukan PDF valid");
				return ['status' => false, 'message' => 'Respons bukan PDF valid'];
			}
		} else {
			$msg = "HTTP $httpCode";
			if ($curlError) {
				$msg .= " - cURL: $curlError";
			}
			// Coba ambil pesan dari response jika JSON
			$json = json_decode($response, true);
			if (isset($json['message'])) {
				$msg .= " - Message: " . $json['message'];
			} elseif (!empty($response)) {
				$msg .= " - Response: " . substr($response, 0, 200);
			}
			error_log("SIASN download gagal: $msg");
			return ['status' => false, 'message' => $msg];
		}
	}
}
