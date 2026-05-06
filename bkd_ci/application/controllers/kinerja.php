<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Kinerja extends SB_Controller
{
    protected $layout = "layouts/main";
    public $module = "kinerja";
    public $per_page = "10";
    public $idx = "";

    // public function download_excel()
    // {
    //     $this->load->model("Kinerjamodel");

    //     // Query sesuai yang dipakai di view.php
    //     $sql =
    //         $this->Kinerjamodel->querySelectall() .
    //         $this->Kinerjamodel->queryWhere();
    //     $query = $this->db->query($sql);

    //     // Header untuk Excel
    //     header("Content-Type: application/vnd.ms-excel");
    //     header("Content-Disposition: attachment; filename=data_kinerja.xls");

    //     // Header kolom Excel
    //     echo "NIP\tNama Lengkap\tSatker\tProsen Kehadiran\tHukuman\tTidak Masuk Kerja\tSanksi Disiplin\tPersentase Pengurang\tJumlah Menit\tProsen Keppo\tBulan\tTahun\n";

    //     // Data isi baris
    //     foreach ($query->result() as $row) {
    //         echo $row->NIP_BARU .
    //             "\t" .
    //             $row->nama_lengkap .
    //             "\t" .
    //             $row->NAMA_SATKER .
    //             "\t" .
    //             $row->prosen_kehadiran .
    //             "\t" .
    //             $row->hukuman .
    //             "\t" .
    //             $row->tidak_masuk_kerja .
    //             "\t" .
    //             $row->sanksi_disiplin .
    //             "\t" .
    //             $row->persentase_pengurang .
    //             "\t" .
    //             $row->keppo_jumlah_menit .
    //             "\t" .
    //             $row->keppo_prosen .
    //             "\t" .
    //             $row->bulan .
    //             "\t" .
    //             $row->tahun .
    //             "\n";
    //     }
    // }
    public function download_excel()
    {
        $this->load->model("Kinerjamodel");

        // Ambil parameter filter yang sama dengan grid
        $satker = $this->input->get('satker') ? $this->input->get('satker') : '0';
        // $sttpeg = $this->input->get('sttpeg') ? $this->input->get('sttpeg') : '1,2,10';
        $thn = $this->input->get('thn') ? $this->input->get('thn') : date('Y');
        $bln = $this->input->get('bln') ? $this->input->get('bln') : date('m');

        // // Query sesuai dengan filter
        $sql = $this->Kinerjamodel->querySelectall() .
            $this->Kinerjamodel->queryWhere();
        //  .
        // " AND pegawai.STATUS_PEGAWAI_ID IN ($sttpeg)";

        // Filter satker
        if ($satker != '0') {
            $sql .= " AND pegawai.SATKER_ID IN ($satker)";
        }

        // Filter tahun dan bulan
        $sql .= " AND keppo.month = $bln AND keppo.year = $thn";
        $sql .= " AND presensi.bulan = $bln AND presensi.tahun = $thn";

        // Tambahkan GROUP BY jika diperlukan
        $sql .= " group by presensi.nip_baru";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            die("Tidak ada data yang ditemukan untuk diunduh.");
        }

        // Header untuk Excel
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: attachment; filename=\"data_kinerja_" . date('YmdHis') . ".xls\"");
        header("Cache-Control: max-age=0");
        header("Content-Transfer-Encoding: binary");

        echo "<html>";
        echo "<head>";
        echo "<meta charset=\"UTF-8\">";
        echo "<style>";
        echo "td { mso-number-format:\\@; }"; // Format semua cell sebagai text
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>No</th>";
        echo "<th>NIP</th>";
        echo "<th>Nama Lengkap</th>";
        echo "<th>Satker</th>";
        echo "<th>Prosen Kehadiran</th>";
        echo "<th>Hukuman</th>";
        echo "<th>Tidak Masuk Kerja</th>";
        echo "<th>Sanksi Disiplin</th>";
        echo "<th>Persentase Pengurang</th>";
        echo "<th>Jumlah Menit Keppo</th>";
        echo "<th>Prosen Keppo</th>";
        echo "<th>Bulan</th>";
        echo "<th>Tahun</th>";
        echo "</tr>";

        $no = 1;
        foreach ($query->result() as $row) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $this->cleanExcelData($row->NIP_BARU) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->nama_lengkap) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->NAMA_SATKER) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->prosen_kehadiran) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->hukuman) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->tidak_masuk_kerja) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->sanksi_disiplin) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->persentase_pengurang) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->keppo_total_waktu) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->keppo_persentase) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->month) . "</td>";
            echo "<td>" . $this->cleanExcelData($row->year) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</body>";
        echo "</html>";
        exit;
    }

    // Fungsi untuk membersihkan data Excel
    private function cleanExcelData($data)
    {
        if ($data === null) return '';

        $data = str_replace(array("\r", "\n", "\t"), " ", $data);
        $data = preg_replace("/\s+/", " ", $data);
        $data = trim($data);

        // Jika data diawali dengan formula, tambahkan apostrof
        if (in_array(substr($data, 0, 1), array('=', '+', '-', '@'))) {
            $data = "'" . $data;
        }

        return $data;
    }

    function __construct()
    {
        parent::__construct();

        $this->load->model("kinerjamodel");
        $this->model = $this->kinerjamodel;
        $idx = $this->model->primaryKey;

        $this->info = $this->model->makeInfo($this->module);
        $this->access = $this->model->validAccess($this->info["id"]);
        $this->data = array_merge($this->data, [
            "pageTitle" => $this->info["title"],
            "pageNote" => $this->info["note"],
            "pageModule" => "kinerja",
        ]);
        $this->col = [];
        $this->con = [];
        $inf = $this->info["config"]["grid"];
        $inf = SiteHelpers::array_sort($inf, "sortlist", SORT_ASC);
        $in = 0;
        foreach ($inf as $key => $t) {
            if ($t["view"] == "1") {
                $in++;
                $this->col[$in] = $t["field"];
                $this->con[$in] = $t["conn"];
            }
        }

        if (!$this->session->userdata("logged_in")) {
            redirect("user/login", 301);
        }
    }

    public function delete_data_to_presensi()
    {
        $this->load->model("presensimodel");
        // Delete data for the current month and year first
        $curMonth = date("m") - 1;
        $curYear = date("Y");
        $this->presensimodel->delete_data_by_month_year($curMonth, $curYear);

        echo json_encode(["status" => "delete presensi success"]);
    }

    public function delete_data_to_keppo()
    {
        $this->load->model("keppomodel");
        // Delete data for the current month and year first
        $curMonth = date("m") - 1;
        $curYear = date("Y");
        $this->keppomodel->delete_data_by_month_year($curMonth, $curYear);

        echo json_encode(["status" => "delete keppo success"]);
    }

    public function keppocheck_existing_entries()
    {
        $nipBaruArr = $this->input->post("nip_baru");
        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");

        $this->load->model("keppomodel");

        $existingIds = $this->keppomodel->get_existing_ids(
            $nipBaruArr,
            $bulan,
            $tahun
        );

        if (!empty($existingIds)) {
            echo json_encode(["status" => "found", "ids" => $existingIds]);
        } else {
            echo json_encode(["status" => "not_found"]);
        }
    }

    public function keppodelete_existing_entries()
    {
        $ids = $this->input->post("ids");

        $this->load->model("keppomodel");

        $this->keppomodel->delete_entries_by_ids($ids);

        echo json_encode(["status" => "success"]);
    }

    public function keppodelete_double()
    {
        $this->load->model("keppomodel");

        $this->keppomodel->delete_double();

        echo json_encode(["status" => "delete success"]);
    }

    public function presensidelete_double()
    {
        $this->load->model("presensimodel");

        $this->presensimodel->delete_double();

        echo json_encode(["status" => "delete success"]);
    }

    public function store_data_to_presensi()
    {
        ini_set("max_execution_time", 120);

        $apiData = $this->input->post("api_data");

        // Check if $apiData is empty
        // if (empty($apiData)) {
        //     echo json_encode(array('status' => 'error', 'message' => 'API data is empty.'));
        //     return;
        // }

        // Assuming you have a model for the presensi table, replace 'PresensiModel' with your actual model name
        $this->load->model("presensimodel");

        // Define the batch size for insertion
        // $batchSize = 100; // You can adjust this based on your needs

        // Split the API data into chunks of $batchSize elements
        // $chunks = array_chunk($apiData, $batchSize);
        $batchData = [];
        foreach ($apiData as $data) {
            // Assuming the 'presensi' table columns match the API response fields, modify this line accordingly
            $insertData = [
                "nama_lengkap" => $data["nama_lengkap"],
                "nip_baru" => $data["nip_baru"],
                "satker_id" => $data["satker_id"],
                "prosen_kehadiran" => $data["prosen_kehadiran"],
                "hukuman" => $data["hukuman"],
                "tidak_masuk_kerja" => $data["tidak_masuk_kerja"],
                "sanksi_disiplin" => $data["sanksi_disiplin"],
                "persentase_pengurang" => $data["persentase_pengurang"],
                "bulan" => $data["bulan"],
                "tahun" => $data["tahun"],
                // Add other columns and corresponding API data here
            ];
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
        echo json_encode(["status" => "success"]);
        // echo json_encode(array('res' => $apiData));
    }

    public function store_data_to_keppo()
    {
        ini_set("max_execution_time", 120);

        $apiData = $this->input->post("api_data");

        // Assuming you have a model for the presensi table, replace 'PresensiModel' with your actual model name
        $this->load->model("keppomodel");

        $batchData = [];
        foreach ($apiData as $data) {
            // Assuming the 'presensi' table columns match the API response fields, modify this line accordingly
            $insertData = [
                "nama_lengkap" => $data["nama_lengkap"],
                "nip_baru" => $data["nip"],
                "jumlah_menit" => $data["total_waktu"],
                "prosen" => $data["persentase"],
                "bulan" => $data["month"],
                "tahun" => $data["year"],
                "keterangan" => $data["keterangan"],
                // Add other columns and corresponding API data here
            ];
            $batchData[] = $insertData;
        }

        $this->keppomodel->insert_batch_data($batchData);

        // $this->keppomodel->delete_double();

        // Respond with a success message
        echo json_encode(["status" => "success"]);
        // echo json_encode(array('res' => $apiData));
    }

    function grids()
    {

        // die("DEBUG: masuk ke getRowsx");
        $satker = $_GET['satker'];
        $sttpeg = $_GET['sttpeg'];
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
        if ($satker != '0')  $filter .= " AND pegawai.SATKER_ID LIKE '$satker%' AND STATUS_PEGAWAI IN ($sttpeg)";
        // if ($bln != '') $filter .= "AND STATUS_PEGAWAI IN ($sttpeg) AND keppo.bulan = '$bln'";
        if ($bln != '') $filter .= "AND STATUS_PEGAWAI IN ($sttpeg) AND presensi.tahun = '$thn' AND presensi.bulan = '$bln' AND keppo.year = '$thn' AND keppo.month = '$bln'";
        $gid = $this->session->userdata('gid');
        $sat = $this->session->userdata('satker');
        if ($gid != 1) {
            $filter .= " AND pegawai.SATKER_ID LIKE '$sat%'";
        } else if ($gid == 3) {
            $filter .= " AND pegawai.NIP_BARU = '" . $this->session->userdata('username') . "'";
        }



        // $filter .= " AND DATE_FORMAT(TANGGAL_LAHIR,'%m') = DATE_FORMAT(CURDATE(),'%m')";
        // $filter .= " AND TANGGAL_PENSIUN BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 5 YEAR)";
        // $order	.= " TANGGAL_PENSIUN ASC";

        $params = array(
            'limit'        => $_POST['start'],
            'page'        => $_POST['length'],
            'sort'        => $sort,
            'order'        => $order,
            'params'    => $filter,
            'global'    => (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
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
                } else {
                    $conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
                    $row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
                }
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

    // function grids($pg)
    // {

    // 	$sort = $this->model->primaryKey;
    // 	$order = 'asc';
    // 	$filter = "";
    // 	//$filter = (!is_null($this->input->get('search', true)) ? $this->buildSearch() : '');
    // 	//order
    // 	if (isset($_POST['order'])) {
    // 		if (($_POST['order']['0']['column']) == 0) {
    // 			$sort = $this->col[($_POST['order']['0']['column']) + 1];
    // 			$order = $_POST['order']['0']['dir'];
    // 		} else {
    // 			$sort = $this->col[($_POST['order']['0']['column'])];
    // 			$order = $_POST['order']['0']['dir'];
    // 		}
    // 	}

    // 	for ($i = 0; $i < count($this->col); $i++) {

    // 		if (isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
    // 			if ($i == 0) {
    // 				$filter .= " AND (" . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
    // 			} else {
    // 				$filter .= " OR " . $this->col[$i + 1] . " LIKE '%" . $_POST['search']['value'] . "%'";
    // 			}
    // 		}
    // 	}

    // 	if ($filter != '') $filter .= ")";
    // 	$filter .= " AND PEGAWAI_ID = '$pg'";

    // 	$params = array(
    // 		'limit'		=> $_POST['start'],
    // 		'page'		=> $_POST['length'],
    // 		'sort'		=> $sort,
    // 		'order'		=> $order,
    // 		'params'	=> $filter,
    // 		'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0)
    // 	);
    // 	// Get Query
    // 	$results = $this->model->getRows($params);
    // 	$rows = $results['rows'];
    // 	$total = $results['total'];
    // 	$totalfil = $results['totalfil'];

    // 	//run data to view
    // 	$data = array();
    // 	$no = 0;
    // 	foreach ($rows as $dt) {
    // 		$row = array();
    // 		$idku = $this->model->primaryKey;
    // 		$row['id'] = $dt->$idku;
    // 		$row[] = $no + 1;
    // 		for ($i = 0; $i < count($this->col); $i++) {
    // 			$field = $this->col[$i + 1];
    // 			$conn = (isset($this->con[$i + 1]) ? $this->con[$i + 1] : array());
    // 			$row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
    // 		}

    // 		//add html for action
    // 		$btn = '';

    // 		$row[] = $btn;
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

    function index()
    {
        $this->data["PEGAWAI_ID"] = $_POST["id"];
        $this->data["tableGrid"] = $this->info["config"]["grid"];

        // Group users permission
        $this->data["access"] = $this->access;
        // Render into template

        $this->data["content"] = $this->load->view(
            "kinerja/index",
            $this->data,
            true
        );

        $this->load->view("layouts/main", $this->data);
    }

    function show($id = null)
    {
        if ($this->access["is_detail"] == 0) {
            $this->session->set_flashdata(
                "error",
                SiteHelpers::alert(
                    "error",
                    "Your are not allowed to access the page"
                )
            );
            redirect("dashboard", 301);
        }

        $row = $this->model->getRow($id);
        if ($row) {
            $this->data["row"] = $row;
        } else {
            $this->data["row"] = $this->model->getColumnTable("keppo_presensi");
        }

        $this->data["id"] = $id;
        echo $this->data["content"] = $this->load->view(
            "kinerja/view",
            $this->data,
            true
        );
        //$this->load->view('layouts/main',$this->data);
    }

    function add($id = null)
    {
        $row = $this->model->getRow($id);
        if ($row) {
            $this->data["row"] = $row;
        } else {
            $this->data["row"] = $this->model->getColumnTable("keppo_presensi");
        }

        $this->data["id"] = $id;
        $this->data["PEGAWAI_ID"] = $_POST["id"];
        echo $this->data["content"] = $this->load->view(
            "kinerja/form",
            $this->data,
            true
        );
        //$this->load->view('layouts/main', $this->data );
    }

    function save()
    {
        $rules = $this->validateForm();

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            $data = $this->validatePost();
            $ID = $this->model->insertRow(
                $data,
                $this->input->get_post("KEPPO_PRESENSI_ID", true)
            );
            // Input logs
            if ($this->input->get("KEPPO_PRESENSI_ID", true) == "") {
                $this->inputLogs(
                    "New Entry row with ID : $ID  , Has Been Save Successfull"
                );
            } else {
                $this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
            }
            // Redirect after save
            $this->session->set_flashdata(
                "message",
                SiteHelpers::alert(
                    "success",
                    " Data has been saved succesfuly !"
                )
            );
            if ($this->input->post("apply")) {
                redirect("kinerja/add/" . $ID, 301);
            } else {
                redirect("kinerja", 301);
            }
        } else {
            $data = [
                "message" => "Ops , The following errors occurred",
                "errors" => validation_errors("<li>", "</li>"),
            ];
            $this->displayError($data);
        }
    }

    function destroy()
    {
        if ($this->access["is_remove"] == 0) {
            echo "err : maaf anda tidak memiliki hak untuk menghapus data";
        }

        $this->model->destroy($_POST["id"]);
        $this->inputLogs(
            "ID : " . $_POST["id"] . "  , Has Been Removed Successfull"
        );
        echo "ID : " . $_POST["id"] . "  , berhasil dihapus !!";
    }

    function satker()
    {
        if (isset($_GET["id"]) && $_GET["id"] != "#") {
            $id = $_GET["id"];
            $sql = "SELECT SATKER_ID AS id,SATKER_ID_PARENT,NAMA AS text,IF((SELECT COUNT(SATKER_ID) FROM satker WHERE SATKER_ID_PARENT=a.SATKER_ID) > 0 , false,true) AS children FROM satker a WHERE SATKER_ID_PARENT = '$id' ORDER BY SATKER_ID ASC";
            $sa = $this->db->query($sql)->result();
            $d = [];
            foreach ($sa as $key) {
                $d[] = [
                    "id" => $key->id,
                    "parent" => $key->SATKER_ID_PARENT,
                    "text" => $key->text,
                    "children" => true,
                ];
            }

            echo json_encode($d);
        } else {
            $sql =
                "SELECT SATKER_ID AS id,SATKER_ID_PARENT,NAMA AS text,IF((SELECT COUNT(SATKER_ID) FROM satker WHERE SATKER_ID_PARENT=a.SATKER_ID) > 0 , true,false) AS children FROM satker a WHERE SATKER_ID_PARENT = 0 ORDER BY SATKER_ID ASC";
            $sa = $this->db->query($sql)->result();
            $d = [];
            foreach ($sa as $key) {
                $r = false;
                if ($key->children == "true") {
                    $r = true;
                }
                $d[] = [
                    "id" => $key->id,
                    "text" => $key->text,
                    "children" => true,
                ];
            }

            echo json_encode($d);
        }
    }
}
