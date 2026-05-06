<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_angka_kredit extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'riwayat_angka_kredit';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('riwayat_angka_kreditmodel');
		$this->model = $this->riwayat_angka_kreditmodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			// 'pageTitle'	=> 	$this->info['title'],
			'pageTitle'	=> 	"Download Riwayat Angka Kredit",
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'riwayat_angka_kredit',
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

	// function grids($pg)
	function grids()
	{
		$sort = $this->model->primaryKey;
		$order = 'asc';
		$filter = "";

		// ambil tanggal dari POST
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		// tambahkan filter tanggal jika diisi
		if (!empty($start_date) && !empty($end_date)) {
			$filter .= " AND DATE(SkDate) BETWEEN '{$start_date}' AND '{$end_date}' ";
		} elseif (!empty($start_date)) {
			$filter .= " AND DATE(SkDate) >= '{$start_date}' ";
		} elseif (!empty($end_date)) {
			$filter .= " AND DATE(SkDate) <= '{$end_date}' ";
		}

		// sisanya biarkan sama...
		if (isset($_POST['order'])) {
			if (($_POST['order']['0']['column']) == 0) {
				$sort = $this->col[($_POST['order']['0']['column']) + 1];
				$order = $_POST['order']['0']['dir'];
			} else {
				$sort = $this->col[($_POST['order']['0']['column'])];
				$order = $_POST['order']['0']['dir'];
			}
		}

		if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
			$search = $_POST['search']['value'];
			$filter .= " AND ( ";
			foreach ($this->col as $i => $field) {
				$filter .= "$field LIKE '%$search%' OR ";
			}
			$filter = rtrim($filter, 'OR ');
			$filter .= ")";
		}

		$params = array(
			'limit'     => $_POST['start'],
			'page'      => $_POST['length'],
			'sort'      => $sort,
			'order'     => $order,
			'params'    => $filter,
			'global'    => (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
		);

		$results = $this->model->getRowsCustom($params);
		$rows = $results['rows'];
		$total = $results['total'];
		$totalfil = $results['totalfil'];

		$data = array();
		$no = 0;
		foreach ($rows as $dt) {
			$row = array();
			$idku = $this->model->primaryKey;
			$row['id'] = $dt->$idku;
			$row[] = $no + 1;
			foreach ($this->col as $i => $field) {
				$conn = isset($this->con[$i]) ? $this->con[$i] : array();
				$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
			}

			$btn = '<div class="btn-group dropdown-split-danger">';
			$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                    <span class="sr-only">Toggle primary</span>
                 </button>
                 <div class="dropdown-menu">';
			if ($this->access['is_remove'] == 1) {
				$btn .= '<a class="dropdown-item" href="#" onclick="ConfirmDelete(\'' . site_url('riwayat_angka_kredit/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			$btn .= '</div>';
			if ($dt->FILE_PDF != '') {
				$row[] = '<a href="javascript:SximoModal(\'' . site_url('riwayat_angka_kredit/viewfile/FILE_PDF') . '/' . $dt->$idku . '\',\'View File\',1000)"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"></a>';
			} else {
				$row[] = '<img src="' . base_url('/assets/icon/nodoc.png') . '" style="width:20px">';
			}
			$btn .= '</div></div>';
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

		echo json_encode($output);
	}


	function index()
	{
		// $this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		//echo 
		$this->data['content'] = $this->load->view('riwayat_angka_kredit/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('riwayat_angka_kredit');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('riwayat_angka_kredit/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		if ($row) {
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('riwayat_angka_kredit');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('riwayat_angka_kredit/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function viewfile($col, $id)
	{ //----------------------------------------GANTI NAMA TABEL DAN ID DI BAWAH INI ---------------------------------------
		$th = $this->db->query("SELECT $col FROM riwayat_angka_kredit WHERE riwayat_angka_kredit_id = '$id'")->row();
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
	{ //tambahan biar bisa upload file----------------------

		$a = '';
		$pegawai = $_POST['PEGAWAI_ID'];
		$nip = 'kosong';
		$namafile_sk = '';
		$tempfile_sk = $_FILES['FILE_PDF']['tmp_name'];
		$tmt = str_replace(' ', '_', $_POST['SkDate']);

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

		if ($tempfile_sk == '') {
			$namafile_sk = $_POST['file_pdf_cek'];
		} else {
			if ($namafile_sk != '') unlink($_POST['file_pdf_cek']);
			$_FILES["FILE_PDF"]["name"] = 'PAK_' . $nip . '_' . $tmt . '.pdf';
			if (!$this->upload->do_upload('FILE_PDF')) {
				$e = $this->upload->display_errors();
				$a = $e;
			} else {
				$namafile_sk = 'dokumen/' . $nip . '/PAK_' . $nip . '_' . $tmt . '.pdf';
			}
		}

		unset($_POST['file_pdf_cek']);

		//batas tambahan------------------------------------------

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();

			//tambahkanini untukinput lokasi fileyang sudah d upload-------------------

			$data['FILE_PDF'] = $namafile_sk;

			//batas tambahan----------------------------------------------------------

			$ID = $this->model->insertRow($data, $this->input->get_post('riwayat_angka_kredit_id', true));
			// Input logs
			if ($this->input->get('riwayat_angka_kredit_id', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
			// if ($this->input->post('apply')) {
			// 	redirect('tim_kerja/add/' . $ID, 301);
			// } else {
			// 	redirect('tim_kerja', 301);
			// }

			//ubah redirect jadi seperti dibawah---------------------
			if ($a == '') {
				$a = "Berhasil Simpan !!";
			} else {
				$this->session->set_flashdata('message', SiteHelpers::alert('error', $a));
			}
			echo $a;
			//batas ubah------------------------------------
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

	public function download()
	{
		$start_date = $this->input->get('start_date');
		$end_date   = $this->input->get('end_date');

		// --- Bangun filter tanggal ---
		$filter = "";
		if (!empty($start_date) && !empty($end_date)) {
			$filter .= " AND DATE(skDate) BETWEEN '{$start_date}' AND '{$end_date}' ";
		} elseif (!empty($start_date)) {
			$filter .= " AND DATE(skDate) >= '{$start_date}' ";
		} elseif (!empty($end_date)) {
			$filter .= " AND DATE(skDate) <= '{$end_date}' ";
		}

		// --- Kirim parameter ke model tanpa limit/page ---
		$params = [
			'params' => $filter,
			'limit'  => 0,
			'page'   => 0,
			'sort'   => $this->model->primaryKey,
			'order'  => 'asc',
			'global' => isset($this->access['is_global']) ? $this->access['is_global'] : 0
		];

		// --- Ambil data ---
		$results = $this->model->getRowsCustom($params);
		$rows = isset($results['rows']) ? $results['rows'] : [];

		// --- Jika tidak ada data ---
		if (empty($rows)) {
			header('Content-Type: text/plain; charset=utf-8');
			echo "⚠️ Tidak ada data ditemukan untuk filter berikut:\n";
			echo "Filter SQL: {$filter}\n";
			echo "Tanggal awal: {$start_date}\n";
			echo "Tanggal akhir: {$end_date}\n";
			exit;
		}

		// --- Set header agar Excel paham ---
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=riwayat_angka_kredit_" . date('Ymd_His') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		// --- Output data dalam format HTML table ---
		echo "<table border='1'>";
		echo "<tr style='background-color:#f2f2f2; font-weight:bold'>
        <th>No</th>
        <th>NIP BARU</th>
        <th>NAMA</th>
        <th>ID PAK SIASN</th>
        <th>NOMOR SK</th>
        <th>TANGGAL SK</th>
        <th>TAHUN MULAI PENILAIAN</th>
        <th>BULAN MULAI PENILAIAN</th>
        <th>TAHUN SELESAI PENILAIAN</th>
        <th>BULAN SELESAI PENILAIAN</th>
        <th>APAKAH INTEGRASI?</th>
        <th>APAKAH KONVERSI?</th>
        <th>Angka Kredit Utama</th>
        <th>Angka Kredit Penunjang</th>
        <th>Total Kredit</th>
    </tr>";

		$no = 1;
		foreach ($rows as $r) {
			echo "<tr>
            <td>{$no}</td>
            <td style='mso-number-format:\"\\@\";'>'{$r->NIP_BARU}</td>
            <td>{$r->NAMA}</td>
            <td>{$r->id}</td>
            <td>{$r->skNomor}</td>
            <td>{$r->skDate}</td>
            <td>{$r->tahunMulaiPenilaian}</td>
            <td>{$r->bulanMulaiPenilaian}</td>
            <td>{$r->tahunSelesaiPenilaian}</td>
            <td>{$r->bulanSelesaiPenilaian}</td>
            <td>{$r->isIntegrasi}</td>
            <td>{$r->isKonversi}</td>
            <td>{$r->angkaKreditUtama}</td>
            <td>{$r->angkaKreditPenunjang}</td>
            <td>{$r->totalAngkaKredit}</td>
        </tr>";
			$no++;
		}

		echo "</table>";
	}
}
