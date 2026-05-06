<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kinerja extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'kinerja'; //----------ganti
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		// $this->load->model('pegawaimodel'); //--------tetap
		$this->load->model('presensimodel');
		$this->model = $this->presensimodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	"Kinerja",
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

// 	function __construct()
// {
// 	parent::__construct();

// 	$this->load->model('presensimodel'); //--------tetap
// 	// $this->load->model('presensimodel');
// 	$this->model = $this->presensimodel;
// 	$idx = $this->model->primaryKey;

// 	$this->info = $this->model->makeInfo($this->module);
// 	$this->access = $this->model->validAccess($this->info['id']);
// 	$this->data = array_merge($this->data, array(
// 		'pageTitle'	=> 	"Kinerja",
// 		'pageNote'	=>  $this->info['note'],
// 		'pageModule'	=> 'pegawai',
// 	));
// 	$this->col = array(
// 		1 => 'nama_lengkap',
// 		2 => 'nip_baru',
// 		3 => 'satker_id',
// 		4 => 'prosen_kehadiran',
// 		5 => 'hukuman',
// 		6 => 'tidak_masuk_kerja',
// 		7 => 'sanksi_disiplin',
// 		8 => 'persentase_pengurang',
// 		9 => 'bulan',
// 		10 => 'tahun'
// 	);
// 	$this->con = array();
// 	$inf = $this->info['config']['grid'];
// 	$inf = SiteHelpers::array_sort($inf, 'sortlist', SORT_ASC);
// 	$in = 0;
// 	foreach ($inf as $key => $t) {
// 		if ($t['view'] == '1') {

// 			$in++;
// 			$this->col[$in] = $t['field'];
// 			$this->con[$in] = $t['conn'];
// 		}
// 	}

// 	if (!$this->session->userdata('logged_in')) redirect('user/login', 301);
// }


	public function store_data_to_presensi()
{
	ini_set('max_execution_time', 120);

    $apiData = $this->input->post('api_data');

	// Check if $apiData is empty
    // if (empty($apiData)) {
    //     echo json_encode(array('status' => 'error', 'message' => 'API data is empty.'));
    //     return;
    // }

    // Assuming you have a model for the presensi table, replace 'PresensiModel' with your actual model name
    $this->load->model('presensimodel');

    // Define the batch size for insertion
    // $batchSize = 100; // You can adjust this based on your needs

    // Split the API data into chunks of $batchSize elements
    // $chunks = array_chunk($apiData, $batchSize);
		$batchData = array();
		foreach ($apiData as $data) {
			// Assuming the 'presensi' table columns match the API response fields, modify this line accordingly
			$insertData = array(
				'nama_lengkap' => $data['nama_lengkap'],
				'nip_baru' => $data['nip_baru'],
				'satker_id' => $data['satker_id'],
				'prosen_kehadiran' => $data['prosen_kehadiran'],
                'hukuman' => $data['hukuman'],
                'tidak_masuk_kerja' => $data['tidak_masuk_kerja'],
                'sanksi_disiplin' => $data['sanksi_disiplin'],
                'persentase_pengurang' => $data['persentase_pengurang'],
                'bulan' => $data['bulan'],
                'tahun' => $data['tahun'],
				// Add other columns and corresponding API data here
			);
			$batchData[] = $insertData;
			
		}
		// Check if $batchData is empty
		// if (empty($batchData)) {
		// 	echo json_encode(array('status' => 'error', 'message' => 'Batch data is empty.'));
		// 	return;
		// }
		// echo($batchData);
		$this->presensimodel->insert_batch_data($batchData);
    // Loop through each chunk and insert into the 'presensi' table
    // foreach ($chunks as $chunk) {
    //     // Prepare the data for batch insertion
    //     $batchData = array();
    //     foreach ($chunk as $data) {
    //         $insertData = array(
    //             'nama_lengkap' => $data['nama_lengkap'],
    //             'nip_baru' => $data['nip_baru'],
    //             'satker_id' => $data['satker_id'],
    //             'prosen_kehadiran' => $data['prosen_kehadiran'],
    //             'hukuman' => $data['hukuman'],
    //             'tidak_masuk_kerja' => $data['tidak_masuk_kerja'],
    //             'sanksi_disiplin' => $data['sanksi_disiplin'],
    //             'persentase_pengurang' => $data['persentase_pengurang'],
    //             'bulan' => $data['bulan'],
    //             'tahun' => $data['tahun'],
    //         );
    //         // Push the insertData into batchData array
    //         $batchData[] = $insertData;
    //     }

    //     // Insert the current chunk into the 'presensi' table using the model's method
	// 		$this->presensimodel->insert_batch_data($batchData);
    // }
	// if (!empty($batchData)) {
	// 	$this->presensimodel->insert_batch_data($batchData);
	// }

    // Respond with a success message
    echo json_encode(array('status' => 'success'));
	// echo json_encode(array('res' => $apiData));
}

public function store_data_to_keppo()
{
	ini_set('max_execution_time', 120);

    $apiData = $this->input->post('api_data');


    // Assuming you have a model for the presensi table, replace 'PresensiModel' with your actual model name
    $this->load->model('keppomodel');

    
		$batchData = array();
		foreach ($apiData as $data) {
			// Assuming the 'presensi' table columns match the API response fields, modify this line accordingly
			$insertData = array(
				'nama_lengkap' => $data['nama_lengkap'],
				'nip_baru' => $data['nip_baru'],
				'jumlah_menit' => $data['jumlah_menit'],
                'prosen' => $data['prosen'],
                'bulan' => $data['bulan'],
                'tahun' => $data['tahun'],
				// Add other columns and corresponding API data here
			);
			$batchData[] = $insertData;
			
		}
		
		$this->keppomodel->insert_batch_data($batchData);
    

    // Respond with a success message
    echo json_encode(array('status' => 'success'));
	// echo json_encode(array('res' => $apiData));
}

	// function grids()
	// {

	// 	$satker = $_GET['satker'];
	// 	$sttpeg = $_GET['sttpeg'];
	// 	$thnpen = $_GET['thnpen'];

	// 	// Get start and length from DataTables request
	// 	$start = $_POST['start'];
	// 	$length = $_POST['length'];

	// 	// Build the API URL
	// 	$apiUrl = "https://sipp2.bkd.probolinggokab.go.id/api/pelaporan_real/search/06/2023";

	// 	// Fetch data from the API
	// 	$apiData = file_get_contents($apiUrl);

	// 	// Convert the JSON data to an array
	// 	$response = json_decode($apiData, true);
	// 	$rows = $response['data'];
	// 	$total = $response['recordsTotal'];
	// 	$totalfil = $response['recordsFiltered'];


	// 	//run data to view
	// 	$data = array();
	// 	$no = 0;
	// 	foreach ($rows as $dt) {
	// 		$row = array();
	// 		$row['id'] = $no + 1;
	// 		$row[] = $no + 1;
	// 		$row[] = $dt['nama_lengkap'];
	// 		$row[] = $dt['nip_baru'];
	// 		$row[] = $dt['satker_id'];
	// 		$row[] = $dt['prosen_kehadiran'];
	// 		$row[] = $dt['hukuman'];
	// 		$row[] = $dt['tidak_masuk_kerja'];
	// 		$row[] = $dt['sanksi_disiplin'];
	// 		$row[] = $dt['persentase_pengurang'];
	// 		$row[] = $dt['bulan'];
	// 		$row[] = $dt['tahun'];
	// 		$data[] = $row;
	// 		$no++;
	// 	}

	// 	$output = array(
	// 		"draw" => $_POST['draw'],
	// 		"recordsTotal" => $total,
	// 		"recordsFiltered" => $totalfil,
	// 		"data" => $data,
	// 	);
	// 	//output to json format
	// 	echo json_encode($output);
	// }

	function grids()
	{

		$satker = $_GET['satker'];
		$thn = $_GET['thn'];
		$bln = $_GET['bln'];

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
		if ($bln != '') $filter .= " AND bulan = '$bln'";
		if ($thn != '') $filter .= " AND tahun = '$thn'";
		$gid = $this->session->userdata('gid');
		$sat = $this->session->userdata('satker');
		if ($gid != 1) {
			$filter .= " AND SATKER_ID LIKE '$sat%'";
		}else if ($gid == 3) {
			$filter .= " AND NIP_BARU = '" . $this->session->userdata('username') . "'";
		}
		


		// $filter .= " AND DATE_FORMAT(TANGGAL_LAHIR,'%m') = DATE_FORMAT(CURDATE(),'%m')";
		// $filter .= " AND TANGGAL_PENSIUN BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 5 YEAR)";
		// $order	.= " TANGGAL_PENSIUN ASC";

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
				$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
				$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
				
			}

			//add html for action
			$btn = '';

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

// 	function grids()
// 	{

// 		$satker = $_GET['satker'];
// 		$sttpeg = $_GET['sttpeg'];
// 		$thnpen = $_GET['thnpen'];

// 		$sort = $this->model->primaryKey;
// 		$order = 'asc';
// 		$filter = "";
// 		//$filter = (!is_null($this->input->get('search', true)) ? $this->buildSearch() : '');
// 		//order 
// 		if (isset($_POST['order'])) {
// 			if (($_POST['order']['0']['column']) == 0) {
// 				$sort = $this->col[($_POST['order']['0']['column']) + 1];
// 				$order = $_POST['order']['0']['dir'];
// 			} else {
// 				$sort = $this->col[($_POST['order']['0']['column'])];
// 				$order = $_POST['order']['0']['dir'];
// 			}
// 		}

// 		for ($i = 0; $i < count($this->col); $i++) {

// 			if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
// 				if ($i == 0) {
// 					$filter .= " AND (" . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
// 				} else {
// 					$filter .= " OR " . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
// 				}
// 			}
// 		}
// 		if ($filter != '') $filter .= ")";
// 		if ($satker != '0')  $filter .= " AND SATKER_ID LIKE '$satker%'";
// 		if ($sttpeg != 'A')  $filter .= " AND STATUS_PEGAWAI IN ($sttpeg)";
// 		$gid = $this->session->userdata('gid');
// 		$sat = $this->session->userdata('satker');
// 		if ($gid != 1) {
// 			$filter .= " AND SATKER_ID LIKE '$sat%'";
// 		}

// 		if ($thnpen != '') $filter .= " AND YEAR(TANGGAL_PENSIUN) = '$thnpen'";


// 		// $filter .= " AND DATE_FORMAT(TANGGAL_LAHIR,'%m') = DATE_FORMAT(CURDATE(),'%m')";
// 		$filter .= " AND TANGGAL_PENSIUN BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 5 YEAR)";
// 		$order	.= " TANGGAL_PENSIUN ASC";

// 		$params = array(
// 			'limit'		=> $_POST['start'],
// 			'page'		=> $_POST['length'],
// 			'sort'		=> $sort,
// 			'order'		=> $order,
// 			'params'	=> $filter,
// 			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
// 		);
// 		// Get Query 
// 		$results = $this->model->getRowsx($params);
// 		$rows = $results['rows'];
// 		$total = $results['total'];
// 		$totalfil = $results['totalfil'];

// 		//run data to view
// 		$data = array();
// 		$no = 0;
// 		foreach ($rows as $dt) {
// 			$row = array();
// 			$idku = $this->model->primaryKey;
// 			$row['id'] = $dt->$idku;
// 			$row[] = $no + 1;
// 			for ($i = 0; $i < count($this->col); $i++) {
// 				$field = $this->col[$i + 1];
// 				if ($field == 'NAMA') {
// 					if ($dt->GELAR_BELAKANG != '') $dt->GELAR_BELAKANG = ', ' . $dt->GELAR_BELAKANG;
// 					if ($dt->GELAR_DEPAN != '') $dt->GELAR_DEPAN = $dt->GELAR_DEPAN . '.';
// 					$row[] = $dt->GELAR_DEPAN . ' ' . $dt->NAMA . '' . $dt->GELAR_BELAKANG;
// 				} else if ($field == 'TEMPAT_LAHIR') {
// 					$row[] = $dt->TEMPAT_LAHIR . ', ' . SiteHelpers::daterpt($dt->TANGGAL_LAHIR);
// 				} else {
// 					$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
// 					$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
// 				}
// 			}

// 			//add html for action
// 			$btn = '';


// 			$btn .= '<div class="btn-group dropdown-split-danger">';

// 			$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
// <span class="sr-only">Toggle primary</span>
// </button>
// <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';
// 			if ($this->access['is_edit'] == 1) {
// 				$btn .= '<a class="dropdown-item waves-effect waves-light" href=' . site_url('pegawai/add/' . $dt->$idku) . '><i class="ti-pencil-alt"></i> Edit</a>';
// 			}
// 			if ($this->access['is_remove'] == 1) {
// 				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('pegawai/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
// 			}
// 			$btn .= '</div>';

// 			$row[] = $btn;
// 			$data[] = $row;
// 			$no++;
// 		}
// 		$output = array(
// 			"draw" => $_POST['draw'],
// 			"recordsTotal" => $total,
// 			"recordsFiltered" => $totalfil,
// 			"data" => $data,
// 		);
// 		//output to json format
// 		echo json_encode($output);
// 	}

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

		$this->data['content'] = $this->load->view('kinerja/index', $this->data, true); //------------ganti

		$this->load->view('layouts/main', $this->data);
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
}
