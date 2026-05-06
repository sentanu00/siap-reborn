<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'controllers/api.php');

class Riwayat_jabatan3 extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'riwayat_jabatan3';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('riwayat_jabatan3model');
		$this->model = $this->riwayat_jabatan3model;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'riwayat_jabatan3',
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

		// set data terakhir
		$this->setDataTerakhiradd($pg);
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
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('riwayat_jabatan3/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			if ($dt->jenisMutasiId != '') {
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmKirimSiasn(\'' . site_url('riwayat_jabatan3/kirimsiasn') . '\',' . $dt->$idku . ')"><i></i> Kirim Data Ke SIASN</a>';
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmKirimFileSiasn(\'' . site_url('riwayat_jabatan3/kirimfilesiasn') . '\',' . $dt->$idku . ')"><i></i> Kirim File Ke SIASN</a>';
			}
			$btn .= '</div>';
			if ($dt->FILE_PDF != '') {
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('riwayat_jabatan3/viewfile/FILE_PDF') . '/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
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

		echo $this->data['content'] = $this->load->view('riwayat_jabatan3/index', $this->data, true);

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
		echo $this->data['content'] =  $this->load->view('riwayat_jabatan3/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('jabatan_riwayat');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('riwayat_jabatan3/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function viewfile($col, $id)
	{
		$th = $this->db->query("SELECT $col FROM jabatan_riwayat WHERE JABATAN_RIWAYAT_ID = '$id'")->row();
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
		$user_update = $this->session->userdata('username'); //gimana caranya ambil username akun yang login?
		$_POST['LAST_UPDATE_USER'] = $user_update;
		$tempfile_file = $_FILES['FILE_PDF']['tmp_name'];
		// $tmt = $_POST['TMT_JABATAN'];
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
			$_FILES["FILE_PDF"]["name"] = 'JABATAN_SK_' . $nip . '_' . $tanggal_jam . '.pdf';
			if (!$this->upload->do_upload('FILE_PDF')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_SK = 'dokumen/' . $nip . '/JABATAN_SK_' . $nip . '_' . $tanggal_jam . '.pdf';
			}
		}


		unset($_POST['file_pdf_cek']);

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();

			$data['FILE_PDF'] = $namafile_SK;
			// $data['LAST_UPDATE_USER'] = @$user_update;
			$data['LAST_UPDATE_DATE'] = date("Y-m-d H:i:s");


			$datalama = $this->getdatalama($_POST, 'jabatan_riwayat', 'JABATAN_RIWAYAT_ID', $data['JABATAN_RIWAYAT_ID']);
			$ID = $this->model->insertRow($data, $this->input->get_post('JABATAN_RIWAYAT_ID', true));


			// Input logs
			if ($this->input->get('JABATAN_RIWAYAT_ID', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull With Data " . json_encode($_POST));
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull With Data " . json_encode($_POST));
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


	public function setDataTerakhiradd($pegawai_id)
	{

		// Query 1: cek data terakhir
		$query = $this->db->query("SELECT 
    j.JABATAN_RIWAYAT_ID, 
    j.SATKER_ID, 
    j.FLAG_DATA_TERAKHIR, 
    j.KETERANGAN_BUP, 
    j.JENIS_JABATAN_SAPK, 
    j.jenisMutasiId, 
    DATE_FORMAT(DATE_ADD(DATE_ADD(p.TANGGAL_LAHIR, INTERVAL j.KETERANGAN_BUP YEAR), INTERVAL 1 MONTH), '%Y-%m-01') AS TMT_PENSIUN
FROM 
    jabatan_riwayat AS j 
JOIN 
    pegawai AS p ON p.PEGAWAI_ID = j.PEGAWAI_ID
WHERE 
    j.PEGAWAI_ID = '" . $pegawai_id . "'
ORDER BY 
    j.TANGGAL_SK DESC LIMIT 1;");

		// Mengambil hasil query sebagai objek
		$result = $query->row();

		if ($result->FLAG_DATA_TERAKHIR == 0) {
			//set flag data terakhir pada jabatan riwayat = 0
			$this->db->query("update jabatan_riwayat set FLAG_DATA_TERAKHIR = 0 where PEGAWAI_ID = '" . $pegawai_id . "'");
			//set jabatan terakhir
			$this->db->query("update jabatan_riwayat set FLAG_DATA_TERAKHIR = 1 where JABATAN_RIWAYAT_ID = '" . $result->JABATAN_RIWAYAT_ID . "'");
			// set pegawai (tipe pegawai, tanggal pensiun, jabatanterakhir id)
			if ($result->JENIS_JABATAN_SAPK == 1) {
				$tipe_pegawai = 11;
			} elseif ($result->JENIS_JABATAN_SAPK == 2) {
				$tipe_pegawai = 2;
			} elseif ($result->JENIS_JABATAN_SAPK == 4) {
				$tipe_pegawai = 12;
			}

			$this->db->query("update pegawai as p set p.TIPE_PEGAWAI_ID = '" . $tipe_pegawai . "', p.TANGGAL_PENSIUN = '" . $result->TMT_PENSIUN . "', p.JABATAN_ID_TERAKHIR = '" . $result->JABATAN_RIWAYAT_ID . "' where p.PEGAWAI_ID = '" . $pegawai_id . "'");
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

	//id ini adalah jabatan_riwayat_id
	public function kirimsiasnbasic($id)
	{
		if ($id) {


			$this->db->select('s.ESELON_ID, s.INSTANSI_KERJA_ID_SAPK, s.JFT_ID_SAPK, s.JFU_ID_SAPK, s.JENIS_JABATAN_SAPK, s.jenisMutasiId, s.jenisPenugasanId, s.NO_SK, p.ID_SAPK, s.SATUAN_KERJA_ID_SAPK, s.TANGGAL_SK, s.TMT_JABATAN, s.tmtMutasi, s.TANGGAL_PELANTIKAN, s.UNOR_ID_SAPK, s.subJabatanId');
			$this->db->from('jabatan_riwayat s');
			$this->db->join('pegawai p', 's.PEGAWAI_ID = p.PEGAWAI_ID');
			$this->db->where('s.JABATAN_RIWAYAT_ID', $id);
			$query = $this->db->get();



			// echo "yuhu";

			if ($query->num_rows() > 0) {
				$result = $query->row(); // Mengambil baris pertama sebagai objek

				// Menyimpan properti hasil query ke dalam variabel
				$eselonId = $result->ESELON_ID;
				$instansiId = $result->INSTANSI_KERJA_ID_SAPK;
				$jabatanFungsionalId = $result->JFT_ID_SAPK;
				$jabatanFungsionalUmumId = $result->JFU_ID_SAPK;
				$jenisJabatan = $result->JENIS_JABATAN_SAPK;
				$jenisMutasiId = $result->jenisMutasiId;
				$jenisPenugasanId = $result->jenisPenugasanId;
				$nomorSk = $result->NO_SK;
				$pnsId = $result->ID_SAPK;
				$satuanKerjaId = $result->SATUAN_KERJA_ID_SAPK;
				$tanggalSk = $result->TANGGAL_SK;
				$tmtJabatan = $result->TMT_JABATAN;
				$tmtMutasi = $result->tmtMutasi;
				$tmtPelantikan = $result->TANGGAL_PELANTIKAN;
				$unorId = $result->UNOR_ID_SAPK;
				$subJabatanId = $result->subJabatanId;


				$hasil = $this->post_jabatan_baru('bearer ' . $this->getSsoToken(), 'Bearer ' . $this->getApiMwsToken(), $eselonId, $id, $instansiId, $jabatanFungsionalId,	$jabatanFungsionalUmumId,	$jenisJabatan,	$jenisMutasiId,	$jenisPenugasanId,	$nomorSk, $pnsId, $satuanKerjaId, $subJabatanId, $tanggalSk, $tmtJabatan, $tmtMutasi, $tmtPelantikan, $unorId);

				// echo "<br>success : " . $hasil["success"];
				// echo "<br>rwJabatanId : " . $hasil["mapData"]["rwJabatanId"];
				if ($hasil["success"] == '1') {
					// echo "<br>message :" . $hasil["message"];

					$this->db->where('JABATAN_RIWAYAT_ID', $id);
					$this->db->update('jabatan_riwayat', array(
						'RW_JABATAN_ID_SAPK' => $hasil["mapData"]["rwJabatanId"],
						'message' => $hasil["message"],
						'keterangansingkron' => 'Singkron Dengan SIASN'
					));

					// Periksa apakah update berhasil
					if ($this->db->affected_rows() > 0) {
						echo $hasil["message"];
						$this->inputLogs("ID : " . $_POST['id'] . "  , sukses kirim jabatan ke siasn dengan data " . json_encode($_POST));
					} else {
						echo "Gagal kirim SIASN";
						$this->inputLogs("ID : " . $_POST['id'] . "  , gagal kirim jabatan ke siasn");
					}
				} else {

					echo $hasil["message"];
					$this->db->where('JABATAN_RIWAYAT_ID', $id);
					$this->db->update('jabatan_riwayat', array(
						'message' => $hasil["message"],
						'keterangansingkron' => ''
					));

					// Periksa apakah update berhasil
					if ($this->db->affected_rows() > 0) {
						echo $hasil["message"];

						$this->inputLogs("ID : " . $_POST['id'] . "  , sukses kirim jabatan ke siasn");
					} else {
						echo "Gagal kirim SIASN";

						$this->inputLogs("ID : " . $_POST['id'] . "  , sukses kirim jabatan ke siasn");
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

	// copy file pdf dari yang  di tampilkan aplikasi siap ke folder tmp_dikumen sebelum dikirim ke siasn
	public function copyToTemp($source_path)
	{
		// TRACE 1: Cek parameter input
		echo "<pre>";
		echo "=== TRACE COPY TOTEMP ===\n";
		echo "Source path: " . $source_path . "\n";

		// Tentukan lokasi folder temporary
		$temp_path = FCPATH . "tmp_dokumen/";
		echo "Temp path: " . $temp_path . "\n";

		// Cek apakah folder temporary ada, jika tidak maka buat foldernya
		if (!is_dir($temp_path)) {
			echo "Folder temp tidak ditemukan, mencoba membuat...\n";
			$mkdir_result = mkdir($temp_path, 0777, true);
			echo "Hasil membuat folder: " . ($mkdir_result ? "BERHASIL" : "GAGAL") . "\n";
			if (!$mkdir_result) {
				echo "Error creating directory: " . error_get_last()['message'] . "\n";
			}
		} else {
			echo "Folder temp sudah ada\n";
		}

		// Cek apakah folder bisa ditulisi
		if (!is_writable($temp_path)) {
			echo "ERROR: Folder temp tidak bisa ditulisi!\n";
			echo "Permission: " . substr(sprintf('%o', fileperms($temp_path)), -4) . "\n";
		}

		// URL sumber file
		$source_url = "https://siap-bkpsdm.probolinggokab.go.id/" . $source_path;
		echo "Source URL: " . $source_url . "\n";

		// Nama file untuk disimpan di folder temporary
		$file_name = basename($source_url);
		$destination_path = $temp_path . $file_name;
		echo "Destination path: " . $destination_path . "\n";

		// TRACE 2: Cek koneksi ke URL
		echo "\n=== MENCoba KONEKSI KE URL ===\n";

		// Coba dengan cURL (lebih informatif)
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $source_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_NOBODY, true); // Cek header saja dulu
		curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_error = curl_error($ch);
		curl_close($ch);

		echo "HTTP Response Code: " . $http_code . "\n";
		if ($curl_error) {
			echo "CURL Error: " . $curl_error . "\n";
		}

		if ($http_code != 200) {
			echo "ERROR: File tidak bisa diakses! HTTP Code: " . $http_code . "\n";
			echo "Coba akses manual: " . $source_url . "\n";
			echo "</pre>";
			return false;
		}

		// TRACE 3: Ambil konten file
		echo "\n=== MENGAMBIL KONTEN FILE ===\n";

		// Coba dengan file_get_contents
		$file_content = @file_get_contents($source_url);
		if ($file_content === false) {
			echo "file_get_contents gagal, mencoba cURL...\n";

			// Fallback dengan cURL untuk ambil konten
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $source_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$file_content = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curl_error = curl_error($ch);
			curl_close($ch);

			echo "cURL HTTP Code: " . $http_code . "\n";
			if ($curl_error) {
				echo "cURL Error: " . $curl_error . "\n";
			}

			if ($http_code != 200 || $file_content === false) {
				echo "ERROR: Gagal mengambil konten file!\n";
				echo "</pre>";
				return false;
			}

			echo "Berhasil mengambil konten dengan cURL, size: " . strlen($file_content) . " bytes\n";
		} else {
			echo "Berhasil mengambil konten dengan file_get_contents, size: " . strlen($file_content) . " bytes\n";
		}

		// TRACE 4: Tulis file
		echo "\n=== MENULIS FILE ===\n";
		$result = file_put_contents($destination_path, $file_content);

		if ($result === false) {
			echo "ERROR: Gagal menulis file ke: $destination_path\n";
			echo "Error terakhir: " . error_get_last()['message'] . "\n";
			echo "Cek permission folder: " . $temp_path . "\n";
			echo "</pre>";
			error_log("Gagal menulis file ke folder temporary: $destination_path");
			return false;
		} else {
			echo "SUKSES! File berhasil ditulis, size: " . $result . " bytes\n";
			echo "File ada di: " . $destination_path . "\n";
			echo "=== TRACE SELESAI ===\n";
			echo "</pre>";
			return true;
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

	//id ini adalah jabatan_riwayat_id
	public function kirimfilesiasnbasic($id)
	{
		if ($id) {
			$this->db->select('s.RW_JABATAN_ID_SAPK, s.FILE_PDF, s.ESELON_ID, s.INSTANSI_KERJA_ID_SAPK, s.JFT_ID_SAPK, s.JFU_ID_SAPK, s.JENIS_JABATAN_SAPK, s.jenisMutasiId, s.jenisPenugasanId, s.NO_SK, p.ID_SAPK, s.SATUAN_KERJA_ID_SAPK, s.TANGGAL_SK, s.TMT_JABATAN, s.tmtMutasi, s.TANGGAL_PELANTIKAN, s.UNOR_ID_SAPK');
			$this->db->from('jabatan_riwayat s');
			$this->db->join('pegawai p', 's.PEGAWAI_ID = p.PEGAWAI_ID');
			$this->db->where('s.JABATAN_RIWAYAT_ID', $id);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->row();

				// TRACE: Cek nilai FILE_PDF dari database
				echo "<h3>Debug Info:</h3>";
				echo "FILE_PDF dari DB: " . $result->FILE_PDF . "<br>";
				echo "FCPATH: " . FCPATH . "<br>";

				$file2 = '';
				if ($this->copyToTemp($result->FILE_PDF)) {
					// $file2 = "/var/www/html/bkd_ci/tmp_dokumen/" . basename($result->FILE_PDF);
					$file2 = FCPATH . "tmp_dokumen/" . basename($result->FILE_PDF);
					echo "File berhasil di-copy ke: " . $file2 . "<br>";
				} else {
					echo "gagal copy<br>";
					exit();
				}

				// Cek apakah file ada
				if (file_exists($file2)) {
					echo "File ditemukan!<br>";
				} else {
					echo "File TIDAK ditemukan di: " . $file2 . "<br>";
					exit();
				}

				// Lanjutkan proses...
				$id_ref_dokumen = '872';
				$hasil = $this->post_file('bearer ' . $this->getSsoToken(), 'Bearer ' . $this->getApiMwsToken(), $result->RW_JABATAN_ID_SAPK, $id_ref_dokumen, $file2);
				$responseArray = json_decode($hasil, true);
				echo $responseArray["message"];
				$this->deleteAllTempFiles();
				exit();
			}
		}
	}
	public function coba_aja()
	{
		echo "coba_aja";
	}


	public function post_jabatan_baru($sso_token, $api_mws_token, $eselonId, $id, $instansiId, $jabatanFungsionalId,	$jabatanFungsionalUmumId,	$jenisJabatan,	$jenisMutasiId,	$jenisPenugasanId,	$nomorSk, $pnsId, $satuanKerjaId, $subJabatanId, $tanggalSk, $tmtJabatan, $tmtMutasi, $tmtPelantikan, $unorId)
	{
		// echo "uja";
		if ($eselonId == '0') {
			$eselonId = '';
		}
		if ($id == '0') {
			$id = '';
		}

		if ($subJabatanId == '0') {
			$subJabatanId = '';
		}
		if ($instansiId == '0') {
			$instansiId = '';
		}
		if ($jabatanFungsionalId == '0') {
			$jabatanFungsionalId = '';
		}
		if ($jabatanFungsionalUmumId == '0') {
			$jabatanFungsionalUmumId = '';
		}
		if ($jenisJabatan == '0') {
			$jenisJabatan = '';
		}
		if ($jenisMutasiId == '0') {
			$jenisMutasiId = '';
		}
		if ($jenisPenugasanId == '0') {
			$jenisPenugasanId = '';
		}
		if ($nomorSk == '0') {
			$nomorSk = '';
		}
		if ($pnsId == '0') {
			$pnsId = '';
		}
		if ($satuanKerjaId == '0') {
			$satuanKerjaId = '';
		}
		// if ($subJabatanId == '0') {
		// 	$subJabatanId = '';
		// }

		// $subJabatanId = '0';

		if ($tanggalSk == '0') {
			$tanggalSk = '';
		} else if ($tanggalSk == '0000-00-00 00:00:00' || $tanggalSk == '0000-00-00') {
			$tanggalSk = '';
		} else {

			// $tanggalSk = $result->TANGGAL_SK;
			$tanggalSk = (new DateTime($tanggalSk))->format('d-m-Y');
		}
		if ($tmtJabatan == '0') {
			$tmtJabatan = '';
		} else if ($tmtJabatan == '0000-00-00 00:00:00' || $tmtJabatan == '0000-00-00') {
			$tmtJabatan = '';
		} else {
			$tmtJabatan = (new DateTime($tmtJabatan))->format('d-m-Y');
		}
		if ($tmtMutasi == '0') {
			$tmtMutasi = '';
		} else if ($tmtMutasi == '0000-00-00 00:00:00' || $tmtMutasi == '0000-00-00') {
			$tmtMutasi = '';
		} else {

			$tmtMutasi = (new DateTime($tmtMutasi))->format('d-m-Y');
		}
		if ($tmtPelantikan == '0') {
			$tmtPelantikan = '';
		} else if ($tmtPelantikan == '0000-00-00 00:00:00' || $tmtPelantikan == '0000-00-00') {
			$tmtPelantikan = '';
		} else {

			$tmtPelantikan = (new DateTime($tmtPelantikan))->format('d-m-Y');
		}


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/jabatan/unorjabatan/save',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>
			'{
				"eselonId": "' . $eselonId . '",
				"id": "' . $id . '",
				"instansiId": "' . $instansiId . '",
				"InstansiIndukID": "' . $instansiId . '",
				"jabatanFungsionalId": "' . $jabatanFungsionalId . '",
				"jabatanFungsionalUmumId": "' . $jabatanFungsionalUmumId . '",
				"jenisJabatan": "' . $jenisJabatan . '",
				"jenisMutasiId": "' . $jenisMutasiId . '",
				"jenisPenugasanId": "' . $jenisPenugasanId . '",
				"nomorSk": "' . $nomorSk . '",
				"pnsId": "' . $pnsId . '",
				"satuanKerjaId": "' . $satuanKerjaId . '",
				"subJabatanId": "' . $subJabatanId . '",
				"tanggalSk": "' . $tanggalSk . '",
				"tmtJabatan": "' . $tmtJabatan . '",
				"tmtMutasi": "' . $tmtMutasi . '",
				"tmtPelantikan": "' . $tmtPelantikan . '",
				"unorId": "' . $unorId . '"
			  }',
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
		// echo "instansiId : " . $instansiId;
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





	// public function get_jabatan_pns($sso_token, $api_mws_token, $nip_baru)
	public function get_jabatan_pns()
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/rw-jabatan/' . '199306302019031003',
			// CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/rw-jabatan/' . $nip_baru,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: ' . 'bearer ' . $this->getSsoToken(),
				'Authorization: ' . 'Bearer ' . $this->getApiMwsToken(),
				'Cookie: ff8d625df24f2272ecde05bd53b814bc=ce158eaac3b25204bfaa39e480fc50f7; pdns=1091068938.13088.0000'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// $hasil['data']['sso_token'] = $sso_token;
		// $hasil['data']['api_mws_token'] = $api_mws_token;
		// $hasil['data']['return'] = $response;

		return $response;
		// print_r($response);
	}




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


	public function getJftOptions()
	{
		$this->db->like('NAMA', $this->input->get('q'));
		$query = $this->db->get('master_jabatan_fungsional_tertentu');
		$result = $query->result();

		$data = array();
		foreach ($result as $row) {
			$data[] = array(
				'id' => $row->JFT_SIASN_ID,
				'text' => $row->NAMA,
				'bup' => $row->BUP_USIA,
				'kel_jabatan_id' => $row->KEL_JABATAN_ID
			);
		}
		echo json_encode($data);
	}

	public function getJfuOptions()
	{
		$this->db->like('NAMA', $this->input->get('q'));
		$query = $this->db->get('master_jabatan_fungsional_umum');
		$result = $query->result();

		$data = array();
		foreach ($result as $row) {
			$data[] = array(
				'id' => $row->JFU_SIASN_ID,
				'text' => $row->NAMA,
				'bup' => $row->BUP_USIA
			);
		}
		echo json_encode($data);
	}

	public function getSatkerOptions()
	{
		$this->db->select('s.*, e.NAMA as NAMA_ESELON');
		$this->db->from('satker as s');
		$this->db->join('eselon as e', 's.ESELON_ID = e.ESELON_ID', 'left');
		$this->db->where('s.SATKER_ID_PARENT !=', '97');
		$this->db->like('s.hirarki_nama', $this->input->get('q'));
		$query = $this->db->get();
		$result = $query->result();


		$data = array();
		foreach ($result as $row) {
			$data[] = array(
				'id' => $row->SATKER_ID,
				'text' => $row->hirarki_nama,
				'bup' => $row->BUP_USIA,
				'eselon_id' => $row->ESELON_ID,
				'nama_jabatan' => $row->NAMA_JABATAN,
				'satker_id_sapk' => $row->SATKER_ID_SAPK,
				'nama_eselon' => $row->NAMA_ESELON
			);
		}
		echo json_encode($data);
	}


	public function getSubJabatanOptions()
	{

		// $kel_jabatan_id = $this->input->get('KEL_JABATAN_ID');

		$this->db->like('NAMA', $this->input->get('q'));
		$this->db->where('kel_jabatan_id', $this->input->get('kel_jabatan_id'));
		$query = $this->db->get('sub_jabatan');
		$result = $query->result();

		$data = array();
		foreach ($result as $row) {
			$data[] = array(
				'id' => $row->sub_jabatan_siasn_id,
				'text' => $row->nama,
			);
		}
		echo json_encode($data);
	}

	// public function post_filecoba()
	// {

	// 	$id_riwayat = '8d0c03fe-4d6c-11ef-8163-0a580a8204f0';

	// 	$id_ref_dokumen = '872';

	// 	// $file = '/mnt/ext-hdd0/dokumen/199306302019031003/JABATAN_SK_199306302019031003_2023-01-01.pdf';
	// 	$file = 'F:\USERS\Downloads\blank.pdf';

	// 	$curl = curl_init();

	// 	curl_setopt_array($curl, array(
	// 		CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/upload-dok-rw',
	// 		CURLOPT_RETURNTRANSFER => true,
	// 		CURLOPT_ENCODING => '',
	// 		CURLOPT_MAXREDIRS => 10,
	// 		CURLOPT_TIMEOUT => 0,
	// 		CURLOPT_FOLLOWLOCATION => true,
	// 		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	// 		CURLOPT_CUSTOMREQUEST => 'POST',
	// 		CURLOPT_POSTFIELDS =>  array('id_riwayat' => $id_riwayat, 'id_ref_dokumen' => $id_ref_dokumen, 'file' => new CURLFILE($file)),
	// 		CURLOPT_HTTPHEADER => array(
	// 			'Content-Type: multipart/form-data',
	// 			'Accept: application/json',
	// 			'Auth: ' . 'bearer ' . $this->getSsoToken(),
	// 			'Authorization: ' . 'Bearer ' . $this->getApiMwsToken(),
	// 			'Cookie: BIGipServerpool_apiws_prod_8243=1091068938.13088.0000; ff8d625df24f2272ecde05bd53b814bc=72356b83ca8501c29aa28542a6d89aa6'
	// 		),
	// 		CURLOPT_SSL_VERIFYPEER => false,
	// 		CURLOPT_SSL_VERIFYHOST => false,
	// 	));



	// 	$response = curl_exec($curl);


	// 	// if (curl_errno($curl)) {
	// 	// 	$error_msg = curl_error($curl);
	// 	// 	echo "cURL Error: " . $error_msg;
	// 	// } else {
	// 	// 	$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	// 	// 	echo "HTTP Status Code: " . $http_code . "\n";
	// 	// 	echo "Response: " . $response;
	// 	// }


	// 	curl_close($curl);
	// 	// $hasil['data']['sso_token'] = $sso_token;
	// 	// $hasil['data']['api_mws_token'] = $api_mws_token;
	// 	// $hasil['data']['return'] = $response;

	// 	// echo $response . " sss";
	// 	return $response;
	// 	// return $hasil;
	// }


	public function cek_path()
	{
		// URL file
		// $url = 'https://siap-bkpsdm.probolinggokab.go.id/dokumen/196905151990031009/05_riwayat_jabatan_43159.pdf';
		$url = 'http://localhost/0_siap_online_dan_sso_git/bkd_ci/dokumen/199306302019031003/JABATAN_SK_199306302019031003_20240924090243.pdf';
		// $url = 'https://siap-bkpsdm.probolinggokab.go.id/dokumen/199306302019031003/JABATAN_SK_199306302019031003_20240924090243.pdf';

		// Dapatkan document root server
		$document_root = $_SERVER['DOCUMENT_ROOT'];

		// Dapatkan path relatif dari URL
		$parsed_url = parse_url($url); // Mengurai URL
		$relative_path = $parsed_url['path']; // Mengambil bagian path dari URL

		// Menggabungkan document root dengan relative path untuk mendapatkan path absolut
		$absolute_path = $document_root . $relative_path;

		// Cek apakah file ada di path tersebut
		if (file_exists($absolute_path)) {
			echo "File ditemukan di path absolut: " . $absolute_path;
		} else {
			echo "File tidak ditemukan. Path absolut: " . $absolute_path;
		}
	}
}
