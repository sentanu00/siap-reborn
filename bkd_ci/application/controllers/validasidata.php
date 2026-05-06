<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validasidata extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'validasidata';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('validasidatamodel');
		$this->model = $this->validasidatamodel;
		$idx = $this->model->primaryKey;

		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
		$this->data = array_merge($this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'validasidata',
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

	function cekdata()
	{
		$peg = $_POST['id'];
		$mod = $_POST['page'];

		$sql = $this->db->query("SELECT * FROM perubahan_data WHERE PEGAWAI_ID = '$peg' AND FORM_FIP = '$mod' AND VALIDASI = 0")->result();
		$ax = array();
		if ($sql) {
			$ax = array('msg' => 1, 'data' => $sql);
		} else {
			$ax = array('msg' => 0, 'data' => $sql);
		}

		echo json_encode($ax);
	}

	function grids($stt = 0)
	{


		// $this->updateFilePDF();

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

		//set satker_id sesuai username login
		$satkerid = $this->session->userdata('satker');
		if ($satkerid != null && $satkerid != '') {
			$filter .= " AND SATKER_ID like '" . $satkerid . "%' ";
		}

		// $filter .= " AND SATKER_ID LIKE '$satkerid%'";
		$filter .= " AND VALIDASI = '$stt'";

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
				if ($field == 'VALIDASI') {
					$a = array('0' => 'Belum Validasi', '1' => 'Validasi', '2' => 'Ditolak');
					$row[] = $a[$dt->$field];
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
				$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' . site_url('validasidata/destroy/') . '\',' . $dt->$idku . ')"><i class="ti-trash"></i> Delete</a>';
			}
			$btn .= '</div>';

			//$row[] = $btn;
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
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template

		$this->data['content'] = $this->load->view('validasidata/index', $this->data, true);

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
			$this->data['row'] = $this->model->getColumnTable('perubahan_data');
		}

		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('validasidata/view', $this->data, true);
		//$this->load->view('layouts/main',$this->data);
	}

	function add($id = null)
	{

		$row = $this->model->getRow($id);
		$nmpeg = '';
		if ($row) {
			$this->data['row'] =  $row;
			$peg = $this->db->query("SELECT NAMA FROM pegawai WHERE PEGAWAI_ID = '" . $row['PEGAWAI_ID'] . "'")->row();
			if ($peg) {
				$nmpeg = $peg->NAMA;
			} else {
				$nmpeg = '';
			}
		} else {
			$this->data['row'] = $this->model->getColumnTable('perubahan_data');
		}

		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['PEGAWAI_NAMA'] = $nmpeg;
		echo $this->data['content'] = $this->load->view('validasidata/form', $this->data, true);
		//$this->load->view('layouts/main', $this->data );

	}

	function save()
	{

		$rules = $this->validateForm();

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			$data = $this->validatePost();
			$data['VALIDASI'] = $_POST['VALIDASI'];



			$ax = $this->db->query("SELECT * FROM perubahan_data WHERE PERUBAHAN_DATA_ID = '" . $data['PERUBAHAN_DATA_ID'] . "'")->row();

			$isilama = json_decode($ax->ISI_LAMA, true);
			$isibaru = json_decode($ax->ISI_BARU);
			$dtable = $ax->DB_TABLE;
			$didtable = $ax->DB_KEY_VALUE;
			$dkeytable = $ax->DB_KEY;
			$pegid = $ax->PEGAWAI_ID;
			$databaru = array();
			$datalama = array();
			if ($ax->ISI_BARU != 'DELETE') {
				foreach ($isibaru as $key => $value) {

					$r = '';
					if (isset($isilama[$key])) $r = $isilama[$key];
					if ($value != $r) {
						if (is_array($value)) {
							$databaru[$key] = $value;
							$datalama[$key] = $r;
							//echo "<tr><td>".$key."</td><td>".implode(",",$value)."</td><td>".$r."</td></tr>";
						} else {
							$databaru[$key] = $value;
							$datalama[$key] = $r;
							//echo "<tr><td>".$key."</td><td>".$value."</td><td>".$r."</td></tr>";
						}
					}
				}
			} else {
				foreach ($isilama as $key => $value) {
					$datalama[$key] = $value;
				}
			}


			if ($_POST['VALIDASI'] == 2) {

				if ($ax->ISI_LAMA == '[]') {
					$this->db->where($dkeytable, $didtable);
					$this->db->delete($dtable);
				} else {
					if ($ax->ISI_BARU == 'DELETE') {
						$isilama = json_decode($ax->ISI_LAMA, true);
						$this->db->insert($dtable, $isilama);
					} else {
						$this->db->where($dkeytable, $didtable);
						$this->db->update($dtable, $datalama);
					}
				}
			}


			unset($data['ISI_LAMA']);
			unset($data['ISI_BARU']);
			unset($data['LAST_CREATE_USER']);
			unset($data['LAST_CREATE_DATE']);

			// 'LAST_CREATE_USER' => $this->session->userdata('username'),
			// 'LAST_CREATE_DATE' => date('Y-m-d H:i:s')
			$data['VALIDATOR'] = $this->session->userdata('username');
			$data['TANGGAL'] = date('Y-m-d H:i:s');
			$data['LAST_UPDATE_USER'] = $this->session->userdata('username');
			$data['LAST_UPDATE_DATE'] = date('Y-m-d H:i:s');

			$ID = $this->model->insertRow($data, $this->input->get_post('PERUBAHAN_DATA_ID', true));
			// Input logs
			if ($this->input->get('PERUBAHAN_DATA_ID', true) == '') {
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$this->session->set_flashdata('message', SiteHelpers::alert('success', " Data has been saved succesfuly !"));
			if ($this->input->post('apply')) {
				redirect('validasidata/add/' . $ID, 301);
			} else {
				redirect('validasidata', 301);
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


	function updatelastdata()
	{
		$a = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE PEGAWAI_ID NOT IN (SELECT ID_PEG FROM tbl_cron_bantuan) AND STATUS_PEGAWAI IN (1,2,9,10) limit 500")->result();
		$bx = 0;
		foreach ($a as $b) {
			$bx++;
			$this->getlastriwayat('pangkat_riwayat', $b->PEGAWAI_ID, 'TMT_PANGKAT');
			$this->db->query("INSERT tbl_cron_bantuan (ID_PEG) values ('" . $b->PEGAWAI_ID . "')");
		}
		echo date('Y-m-d h:i:s') . ' PANGKAT ' . $bx;
	}

	function updatelastdatapendidikan()
	{
		$a = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE PEGAWAI_ID NOT IN (SELECT ID_PEG FROM tbl_cron_bantuan_pendidikan) AND STATUS_PEGAWAI IN (1,2,9,10) limit 500")->result();
		$bx = 0;
		foreach ($a as $b) {
			$bx++;
			$this->getlastriwayat('pendidikan_riwayat', $b->PEGAWAI_ID, 'TANGGAL_STTB');
			$this->db->query("INSERT tbl_cron_bantuan_pendidikan (ID_PEG) values ('" . $b->PEGAWAI_ID . "')");
		}
		echo date('Y-m-d h:i:s') . ' PENDIDIKAN ' . $bx;
	}

	function updatelastdatajabatan()
	{
		$a = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE PEGAWAI_ID NOT IN (SELECT ID_PEG FROM tbl_cron_bantuan_jabatan) AND STATUS_PEGAWAI IN (1,2,9,10) limit 500")->result();
		$bx = 0;
		foreach ($a as $b) {
			$bx++;
			$this->getlastriwayat('jabatan_riwayat', $b->PEGAWAI_ID, 'TMT_JABATAN');
			$this->db->query("INSERT tbl_cron_bantuan_jabatan (ID_PEG) values ('" . $b->PEGAWAI_ID . "')");
		}
		echo date('Y-m-d h:i:s') . ' PENDIDIKAN ' . $bx;
	}

	function updatelastdatagaji()
	{
		$a = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE PEGAWAI_ID NOT IN (SELECT ID_PEG FROM tbl_cron_bantuan_gaji) AND STATUS_PEGAWAI IN (1,2,9,10) limit 500")->result();
		$bx = 0;
		foreach ($a as $b) {
			$bx++;
			$this->getlastriwayat('gaji_riwayat', $b->PEGAWAI_ID, 'TMT_SK');
			$this->db->query("INSERT tbl_cron_bantuan_gaji (ID_PEG) values ('" . $b->PEGAWAI_ID . "')");
		}
		echo date('Y-m-d h:i:s') . ' PENDIDIKAN ' . $bx;
	}


	function getPDFData($table, $primaryKey, $primaryKeyValue)
	{
		// $table = 'gaji_riwayat';
		// $primaryKey = 'GAJI_RIWAYAT_ID';
		// $primaryKeyValue = '109215';

		$jabatanriwayat = $this->db->query("SELECT FILE_PDF FROM " . $table . " WHERE " . $primaryKey . " = " . $primaryKeyValue);

		// Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
		$resultArray = $jabatanriwayat->result_array();

		return $resultArray[0]['FILE_PDF'];
	}


	public function updateFilePDF()
	{
		// echo "coba ";
		// Query 1: Set svalidasi = '1' ketika yang update adalah user admin
		$this->db->query('update perubahan_data as p 
		left join tb_users as t on p.LAST_CREATE_USER = t.username
		set 
		p.VALIDASI = 1, 
		p.VALIDATOR = t.username, 
		p.TANGGAL = NOW(), 
		p.LAST_UPDATE_USER = t.username,
		p.LAST_UPDATE_DATE = NOW() 
		where  p.VALIDASI = 0 and (t.group_id = 1 or t.group_id = 5 )');


		$this->db->query("UPDATE perubahan_data as p1
		LEFT JOIN pegawai p2 ON p1.PEGAWAI_ID = p2.PEGAWAI_ID
		SET p1.NIP_BARU = p2.NIP_BARU, p1.NAMA = p2.NAMA, p1.SATKER_ID = p2.SATKER_ID 
		WHERE p1.NIP_BARU IS NULL");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_PDF', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_PDF\"%' 
		AND DB_TABLE IN ('anak','cuti','diklat_fungsional','diklat_struktural','diklat_teknis','gaji_riwayat','kursus','kursus_khusus','organisasi_riwayat','penataran_seminar','penghargaan','penilaian','penilaian_skp','saudara','seminar','sk_pns','jabatan_riwayat','pangkat_riwayat','sk_cpns','sk_pppk','pendidikan_riwayat') AND ISI_BARU != 'DELETE'");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_PELANTIKAN', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_PELANTIKAN\"%' 
		AND DB_TABLE IN ('jabatan_riwayat') AND ISI_BARU != 'DELETE'");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_PERTEK_KP', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_PERTEK_KP\"%' 
		AND DB_TABLE IN ('pangkat_riwayat') AND ISI_BARU != 'DELETE'");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_SPMT', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_SPMT\"%' 
		and DB_TABLE in ('sk_cpns') and ISI_BARU != 'DELETE'");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_SPMT', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_SPMT\"%' 
		and DB_TABLE in ('sk_pppk') and ISI_BARU != 'DELETE'");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_TRANSKRIP', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_TRANSKRIP\"%' 
		and DB_TABLE in ('pendidikan_riwayat') and ISI_BARU != 'DELETE'");

		$this->db->query("UPDATE perubahan_data
		SET ISI_BARU = JSON_SET(ISI_BARU, '$.FILE_SK_GELAR', '')
		WHERE ISI_BARU NOT LIKE '%\"FILE_SK_GELAR\"%' 
		and DB_TABLE in ('pendidikan_riwayat') and ISI_BARU != 'DELETE'");

		// $this->load->model('validasidatamodel');
		// $this->model = $this->validasidatamodel;
		// $idx = $this->model->primaryKey;
		$changes = $this->model->getPendingChanges();

		// print_r($changes);
		// exit();

		foreach ($changes as $change) {
			$table = $change['DB_TABLE'];
			$primaryKey = $change['DB_KEY'];
			$primaryKeyValue = $change['DB_KEY_VALUE'];

			if (!is_null($primaryKey) && $primaryKey !== '') {


				if ($table == 'jabatan_riwayat') {
					echo "1";
					// Query untuk mengambil nilai FILE_PDF dari DB_TABLE
					$query = $this->db->select('FILE_PDF', 'FILE_PELANTIKAN')->from($table)->where($primaryKey, $primaryKeyValue)->get();
					$filePDF = $query->row()->FILE_PDF;
					$FILE_PELANTIKAN = $query->row()->FILE_PELANTIKAN;
					// echo "2";
					// Update nilai FILE_PDF di dalam JSON ISI_BARU FILE_PDF
					$updatedIsiBaru = str_replace('"FILE_PDF":""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PDF": ""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);

					// Update nilai FILE_PELANTIKAN di dalam JSON ISI_BARU FILE_PELANTIKAN
					$updatedIsiBaru = str_replace('"FILE_PELANTIKAN":""', '"FILE_PELANTIKAN":"' . $FILE_PELANTIKAN . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PELANTIKAN": ""', '"FILE_PELANTIKAN":"' . $FILE_PELANTIKAN . '"', $change['ISI_BARU']);
					// echo "3";
					// Update data di perubahan_data dan set UPDATE_JSON = 1
					$this->model->updateFilePDF($change['PERUBAHAN_DATA_ID'], $updatedIsiBaru);
				} elseif ($table == 'pendidikan_riwayat') {
					// Query untuk mengambil nilai FILE_PDF dari DB_TABLE
					$query = $this->db->select('FILE_PDF', 'FILE_TRANSKRIP', 'FILE_SK_GELAR')->from($table)->where($primaryKey, $primaryKeyValue)->get();
					$filePDF = $query->row()->FILE_PDF;
					$FILE_TRANSKRIP = $query->row()->FILE_TRANSKRIP;
					$FILE_SK_GELAR = $query->row()->FILE_SK_GELAR;
					echo "4";
					// Update nilai FILE_PDF di dalam JSON ISI_BARU FILE_PDF
					$updatedIsiBaru = str_replace('"FILE_PDF":""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PDF": ""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					// echo "5";
					// Update nilai FILE_TRANSKRIP di dalam JSON ISI_BARU FILE_TRANSKRIP
					$updatedIsiBaru = str_replace('"FILE_TRANSKRIP":""', '"FILE_TRANSKRIP":"' . $FILE_TRANSKRIP . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_TRANSKRIP": ""', '"FILE_TRANSKRIP":"' . $FILE_TRANSKRIP . '"', $change['ISI_BARU']);
					// echo "6";
					// Update nilai FILE_SK_GELAR di dalam JSON ISI_BARU FILE_SK_GELAR
					$updatedIsiBaru = str_replace('"FILE_SK_GELAR":""', '"FILE_SK_GELAR":"' . $FILE_SK_GELAR . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_SK_GELAR": ""', '"FILE_SK_GELAR":"' . $FILE_SK_GELAR . '"', $change['ISI_BARU']);
					// echo "7";
					// Update data di perubahan_data dan set UPDATE_JSON = 1
					$this->model->updateFilePDF($change['PERUBAHAN_DATA_ID'], $updatedIsiBaru);
				} elseif ($table == 'sk_pppk') {
					// Query untuk mengambil nilai FILE_PDF dari DB_TABLE
					$query = $this->db->select('FILE_PDF', 'FILE_SPMT')->from($table)->where($primaryKey, $primaryKeyValue)->get();
					$filePDF = $query->row()->FILE_PDF;
					$FILE_SPMT = $query->row()->FILE_SPMT;
					echo "8";
					// Update nilai FILE_PDF di dalam JSON ISI_BARU FILE_PDF
					$updatedIsiBaru = str_replace('"FILE_PDF":""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PDF": ""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					// echo "9";
					// Update nilai FILE_SPMT di dalam JSON ISI_BARU FILE_SPMT
					$updatedIsiBaru = str_replace('"FILE_SPMT":""', '"FILE_SPMT":"' . $FILE_SPMT . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_SPMT": ""', '"FILE_SPMT":"' . $FILE_SPMT . '"', $change['ISI_BARU']);
					// echo "10";
					// Update data di perubahan_data dan set UPDATE_JSON = 1
					$this->model->updateFilePDF($change['PERUBAHAN_DATA_ID'], $updatedIsiBaru);
				} elseif ($table == 'sk_cpns') {

					// Query untuk mengambil nilai FILE_PDF dari DB_TABLE
					$query = $this->db->select('FILE_PDF', 'FILE_SPMT')->from($table)->where($primaryKey, $primaryKeyValue)->get();
					$filePDF = $query->row()->FILE_PDF;
					$FILE_SPMT = $query->row()->FILE_SPMT;
					echo "11";
					// Update nilai FILE_PDF di dalam JSON ISI_BARU FILE_PDF
					$updatedIsiBaru = str_replace('"FILE_PDF":""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PDF": ""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					// echo "12";
					// Update nilai FILE_SPMT di dalam JSON ISI_BARU FILE_SPMT
					$updatedIsiBaru = str_replace('"FILE_SPMT":""', '"FILE_SPMT":"' . $FILE_SPMT . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_SPMT": ""', '"FILE_SPMT":"' . $FILE_SPMT . '"', $change['ISI_BARU']);
					// echo "13";
					// Update data di perubahan_data dan set UPDATE_JSON = 1
					$this->model->updateFilePDF($change['PERUBAHAN_DATA_ID'], $updatedIsiBaru);
				} elseif ($table == 'pangkat_riwayat') {

					// Query untuk mengambil nilai FILE_PDF dari DB_TABLE
					$query = $this->db->select('FILE_PDF', 'FILE_PERTEK_KP')->from($table)->where($primaryKey, $primaryKeyValue)->get();
					$filePDF = $query->row()->FILE_PDF;
					$FILE_PERTEK_KP = $query->row()->FILE_PERTEK_KP;
					echo "14";
					// Update nilai FILE_PDF di dalam JSON ISI_BARU FILE_PDF
					$updatedIsiBaru = str_replace('"FILE_PDF":""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PDF": ""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					// echo "15";
					// Update nilai FILE_PERTEK_KP di dalam JSON ISI_BARU FILE_PERTEK_KP
					$updatedIsiBaru = str_replace('"FILE_PERTEK_KP":""', '"FILE_PERTEK_KP":"' . $FILE_PERTEK_KP . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PERTEK_KP": ""', '"FILE_PERTEK_KP":"' . $FILE_PERTEK_KP . '"', $change['ISI_BARU']);
					// echo "16";
					// Update data di perubahan_data dan set UPDATE_JSON = 1
					$this->model->updateFilePDF($change['PERUBAHAN_DATA_ID'], $updatedIsiBaru);
				} else {

					// Query untuk mengambil nilai FILE_PDF dari DB_TABLE
					$query = $this->db->select('FILE_PDF')->from($table)->where($primaryKey, $primaryKeyValue)->get();
					$filePDF = $query->row()->FILE_PDF;
					echo "17";
					// Update nilai FILE_PDF di dalam JSON ISI_BARU FILE_PDF
					$updatedIsiBaru = str_replace('"FILE_PDF":""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					$updatedIsiBaru = str_replace('"FILE_PDF": ""', '"FILE_PDF":"' . $filePDF . '"', $change['ISI_BARU']);
					// echo "18";
					// Update data di perubahan_data dan set UPDATE_JSON = 1
					$this->model->updateFilePDF($change['PERUBAHAN_DATA_ID'], $updatedIsiBaru);
				}
			}
			// Tambahkan pesan atau log untuk pemantauan
			// echo "Updated FILE_PDF for $table with $primaryKey = $primaryKeyValue\n";
		}
	}
}
