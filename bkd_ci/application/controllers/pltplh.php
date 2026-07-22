<?php if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Pltplh extends SB_Controller
{
    protected $layout = "layouts/main";
    public $module = "pltplh";
    public $per_page = "10";
    public $idx = "";

    function __construct()
    {
        parent::__construct();

        $this->load->model("pltplhmodel");
        $this->model = $this->pltplhmodel;
        $idx = $this->model->primaryKey;

        $this->info = $this->model->makeInfo($this->module);
        $this->access = $this->model->validAccess($this->info["id"]);
        $this->data = array_merge($this->data, [
            "pageTitle" => $this->info["title"],
            "pageNote" => $this->info["note"],
            "pageModule" => "pltplh",
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

    function grids($pg)
    {
        $sort = $this->model->primaryKey;
        $order = "asc";
        $filter = "";
        //$filter = (!is_null($this->input->get('search', true)) ? $this->buildSearch() : '');
        //order
        if (isset($_POST["order"])) {
            if ($_POST["order"]["0"]["column"] == 0) {
                $sort = $this->col[$_POST["order"]["0"]["column"] + 1];
                $order = $_POST["order"]["0"]["dir"];
            } else {
                $sort = $this->col[$_POST["order"]["0"]["column"]];
                $order = $_POST["order"]["0"]["dir"];
            }
        }

        for ($i = 0; $i < count($this->col); $i++) {
            if (
                isset($_POST["search"]["value"]) &&
                $_POST["search"]["value"] != ""
            ) {
                if ($i == 0) {
                    $filter .=
                        " AND (" .
                        $this->col[$i + 1] .
                        " LIKE '%" .
                        $_POST["search"]["value"] .
                        "%'";
                } else {
                    $filter .=
                        " OR " .
                        $this->col[$i + 1] .
                        " LIKE '%" .
                        $_POST["search"]["value"] .
                        "%'";
                }
            }
        }

        if ($filter != "") {
            $filter .= ")";
        }
        $filter .= " AND PEGAWAI_ID = '$pg'";

        $params = [
            "limit" => $_POST["start"],
            "page" => $_POST["length"],
            "sort" => $sort,
            "order" => $order,
            "params" => $filter,
            "global" => isset($this->access["is_global"])
                ? $this->access["is_global"]
                : 0,
        ];
        // Get Query
        $results = $this->model->getRows($params);
        $rows = $results["rows"];
        $total = $results["total"];
        $totalfil = $results["totalfil"];

        //run data to view
        $data = [];
        $no = 0;
        foreach ($rows as $dt) {
            $row = [];
            $idku = $this->model->primaryKey;
            $row["id"] = $dt->$idku;
            $row[] = $no + 1;
            for ($i = 0; $i < count($this->col); $i++) {
                $field = $this->col[$i + 1];
                $conn = isset($this->con[$i + 1]) ? $this->con[$i + 1] : [];
                $row[] = SiteHelpers::gridDisplay($dt->$field, $field, $conn);
            }

            //add html for action
            $btn = "";

            $btn .= '<div class="btn-group dropdown-split-danger">';
            $btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="sr-only">Toggle primary</span>
</button>
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';

            if ($this->access["is_remove"] == 1) {
                $btn .=
                    '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\'' .
                    site_url("pltplh/destroy/") .
                    '\',' .
                    $dt->$idku .
                    ')"><i class="ti-trash"></i> Delete</a>';
            }
            $btn .= "</div>";
            if ($dt->FILE_PDF != "") {
                $row[] =
                    '<a href="javascript:SximoModal(\'' .
                    site_url("pltplh/viewfile/FILE_PDF") .
                    "/" .
                    $dt->$idku .
                    '\',\'View File\',1000)"><img src="' .
                    base_url("/assets/icon/adadoc.png") .
                    '" style="width:20px"></a>';
            } else {
                $row[] =
                    '<img src="' .
                    base_url("/assets/icon/nodoc.png") .
                    '" style="width:20px">';
            }
            $row[] = $btn;
            $data[] = $row;
            $no++;
        }
        $output = [
            "draw" => $_POST["draw"],
            "recordsTotal" => $total,
            "recordsFiltered" => $totalfil,
            "data" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }

    function index()
    {
        $this->data["PEGAWAI_ID"] = $_POST["id"];
        $this->data["tableGrid"] = $this->info["config"]["grid"];

        // Group users permission
        $this->data["access"] = $this->access;
        // Render into template

        echo $this->data["content"] = $this->load->view(
            "pltplh/index",
            $this->data,
            true
        );

        //$this->load->view('layouts/main', $this->data );
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
            $this->data["row"] = $this->model->getColumnTable("plt_plh");
        }

        $this->data["id"] = $id;
        echo $this->data["content"] = $this->load->view(
            "pltplh/view",
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
            $this->data["row"] = $this->model->getColumnTable("plt_plh");
        }

        $this->data["id"] = $id;
        $this->data["PEGAWAI_ID"] = $_POST["id"];
        echo $this->data["content"] = $this->load->view(
            "pltplh/form",
            $this->data,
            true
        );
        //$this->load->view('layouts/main', $this->data );
    }

    public function autocomplete_jenis_jabatan()
    {
        $q = $this->input->get("q", true);

        $this->db->select("ID as id, NAMA as text");
        $this->db->from("jenis_jabatan");

        if ($q) {
            $this->db->like("NAMA", $q);
        }

        $data = $this->db
            ->order_by("NAMA", "ASC")
            ->limit(5)
            ->get()
            ->result_array();

        echo json_encode($data);
    }

    public function autocomplete_satker()
    {
        $q = $this->input->get("q", true);

        $this->db->select(
            "SATKER_ID as id, NAMA, NAMA_JABATAN, BUP_USIA, id_jabatan_tpp, kelas_jabatan, hirarki_nama as text, hirarki_nama, ESELON_ID, SATKER_ID_SAPK"
        );
        $this->db->from("satker");

        // // filter hanya data aktif
        // $this->db->where('AKTIF', 1);
        $this->db->where("SATKER_ID_PARENT !=", "97");

        if ($q) {
            $this->db->like("hirarki_nama", $q);
        }

        $data = $this->db->order_by("text", "ASC")->get()->result_array();

        echo json_encode($data);
    }

    function viewfile($col, $id)
    {
        $th = $this->db
            ->query("SELECT $col FROM plt_plh WHERE JABATAN_RIWAYAT_ID = '$id'")
            ->row();
        $ext = explode(".", $th->$col);
        $maxext = count($ext);
        $extn = $ext[$maxext - 1];
        if ($extn == "pdf") {
            $urlberkas = base_url($th->$col);
            echo '<iframe src="' .
                $urlberkas .
                "?time=" .
                date("ymdhis") .
                '" width="100%" height="600px"></iframe>';
        } else {
            $urlberkas = base_url($th->$col);
            echo '<img src="' .
                $urlberkas .
                "?time=" .
                date("ymdhis") .
                '" style="max-width:100%">';
        }
    }

    function save()
    {
        //tambahan biar bisa upload file----------------------

        $a = "";
        $pegawai = $_POST["PEGAWAI_ID"];
        $nip = "kosong";
        $namafile_sk = "";
        $tempfile_sk = $_FILES["FILE_PDF"]["tmp_name"];
        $tmt = str_replace(" ", "_", $_POST["tmtJabatan"]);

        //cari nip
        $sql = $this->db
            ->query(
                "SELECT NIP_BARU FROM pegawai WHERE PEGAWAI_ID = '$pegawai'"
            )
            ->row();
        if ($sql) {
            $nip = $sql->NIP_BARU;
        }

        $config["upload_path"] = "./dokumen/" . $nip . "/";
        $config["allowed_types"] = "pdf";
        $config["max_size"] = "1000";
        $config["overwrite"] = true;

        $this->load->library("upload", $config);
        $this->upload->initialize($config);

        if ($tempfile_sk == "") {
            $namafile_sk = $_POST["file_pdf_cek"];
        } else {
            if ($namafile_sk != "") {
                unlink($_POST["file_pdf_cek"]);
            }
            $_FILES["FILE_PDF"]["name"] =
                "plt_plh_" . $nip . "_" . $tmt ."_".date('YmdHis'). ".pdf";
            if (!$this->upload->do_upload("FILE_PDF")) {
                $e = $this->upload->display_errors();
                $a = $e;
            } else {
                $namafile_sk =
                    "dokumen/" .
                    $nip .
                    "/plt_plh_" .
                    $nip .
                    "_" .
                    $tmt .
                    "_".
                    date('YmdHis') .
                    ".pdf";
            }
        }

        unset($_POST["file_pdf_cek"]);

        //batas tambahan------------------------------------------

        $rules = $this->validateForm();

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            $data = $this->validatePost();

            //tambahkanini untukinput lokasi file yang sudah d upload-------------------

            $data["FILE_PDF"] = $namafile_sk;

            //batas tambahan-----------------------------------------------------------

            $ID = $this->model->insertRow(
                $data,
                $this->input->get_post("JABATAN_RIWAYAT_ID", true)
            );
            // Input logs
            if ($this->input->get("JABATAN_RIWAYAT_ID", true) == "") {
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

            //ubah redirect jadi seperti dibawah---------------------
            if ($a == "") {
                $a = "Berhasil Simpan !!";
                $this->insert_post_data_siap($data['FILE_PDF']);

                $a = $a . " - " . $data['FILE_PDF'];
            } else {
                $this->session->set_flashdata(
                    "message",
                    SiteHelpers::alert("error", $a)
                );
            }
            echo $a;
            //batas ubah------------------------------------
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

        $this->delete_siasn($_POST["id"]);
        $this->model->destroy($_POST["id"]);
        $this->inputLogs(
            "ID : " . $_POST["id"] . "  , Has Been Removed Successfull"
        );
        echo "ID : " . $_POST["id"] . "  , berhasil dihapus !!";
    }

    public function insert_post_data_siap($file_pdf)
    {
        // ambil data dari plt_plh berdasarkan file_pdf
        $this->db->select("
        j.JABATAN_RIWAYAT_ID AS id_table,
        j.PEGAWAI_ID,
        j.eselonId,
        j.nomorSk,
        j.tanggalSk,
        j.tmtJabatan,
        j.tmtPelantikan,
        j.id,
        j.jenisJabatan,
        j.instansiKerjaId,
        j.satuanKerjaId,
        j.unorId,
        j.jabatanFungsionalId,
        j.jabatanFungsionalUmumId,
        s.siasnid AS idPns,
        j.jenisMutasiId,
        j.jenisPenugasanId,
        j.tmtMutasi,
        j.FILE_PDF,
        j.subJabatanId
    ");


        $this->db->from('plt_plh j');
        $this->db->join('siasnpegawaiid s', 'j.PEGAWAI_ID = s.pegawai_id', 'left');
        $this->db->where('j.FILE_PDF', $file_pdf);

        $row = $this->db->get()->row();

        if (!$row) {
            return "Data tidak ditemukan untuk file_pdf: " . $file_pdf;
        }

        // mapping ke variabel lama biar gak banyak ubah kode bawah
        $id_table = $row->id_table;
        $PEGAWAI_ID = $row->PEGAWAI_ID;
        $eselonId = $row->eselonId;
        $id = $row->id;
        $instansiId = $row->instansiId;
        $jabatanFungsionalId = $row->jabatanFungsionalId;
        $jabatanFungsionalUmumId = $row->jabatanFungsionalUmumId;
        $jenisJabatan = $row->jenisJabatan;
        $jenisMutasiId = $row->jenisMutasiId;
        $jenisPenugasanId = $row->jenisPenugasanId;
        $nomorSk = $row->nomorSk;
        $pnsId = $row->idPns;
        $satuanKerjaId = $row->satuanKerjaId;
        $subJabatanId = $row->subJabatanId;
        $tanggalSk = $row->tanggalSk;
        $tmtJabatan = $row->tmtJabatan;
        $tmtMutasi = $row->tmtMutasi;
        $tmtPelantikan = $row->tmtPelantikan;
        $unorId = $row->unorId;
        $FILE_PDF = $row->FILE_PDF;

        // =========================
        // LANJUT PAKAI LOGIC LAMA
        // =========================

        if ($eselonId == '0') $eselonId = '';
        if ($id == '0' || $id == null) $id = '';
        if ($subJabatanId == '0') $subJabatanId = '';
        if ($instansiId == '0') $instansiId = '';
        if ($jabatanFungsionalId == '0') $jabatanFungsionalId = '';
        if ($jabatanFungsionalUmumId == '0') $jabatanFungsionalUmumId = '';
        if ($jenisJabatan == '0') $jenisJabatan = '';
        if ($jenisMutasiId == '0') $jenisMutasiId = '';
        if ($jenisPenugasanId == '0') $jenisPenugasanId = '';
        if ($nomorSk == '0') $nomorSk = '';
        if ($pnsId == '0') $pnsId = '';
        if ($satuanKerjaId == '0') $satuanKerjaId = '';

        // format tanggal
        $tanggalSk = ($tanggalSk && $tanggalSk != '0000-00-00' && $tanggalSk != '0000-00-00 00:00:00')
            ? (new DateTime($tanggalSk))->format('d-m-Y') : '';

        $tmtJabatan = ($tmtJabatan && $tmtJabatan != '0000-00-00' && $tmtJabatan != '0000-00-00 00:00:00')
            ? (new DateTime($tmtJabatan))->format('d-m-Y') : '';

        $tmtMutasi = ($tmtMutasi && $tmtMutasi != '0000-00-00' && $tmtMutasi != '0000-00-00 00:00:00')
            ? (new DateTime($tmtMutasi))->format('d-m-Y') : '';

        $tmtPelantikan = ($tmtPelantikan && $tmtPelantikan != '0000-00-00' && $tmtPelantikan != '0000-00-00 00:00:00')
            ? (new DateTime($tmtPelantikan))->format('d-m-Y') : '';

        $nama = '/jabatan/save';
        $table_name = 'plt_plh';
        $url = 'https://apimws.bkn.go.id:8243/apisiasn/1.0/jabatan/unorjabatan/save';

        $bodyjson = json_encode([
            "eselonId" => $eselonId,
            "id" => $id,
            "instansiId" => 'A5EB03E23B3BF6A0E040640A040252AD',
            "InstansiIndukID" => 'A5EB03E23B3BF6A0E040640A040252AD',
            "jabatanFungsionalId" => $jabatanFungsionalId,
            "jabatanFungsionalUmumId" => $jabatanFungsionalUmumId,
            "jenisJabatan" => $jenisJabatan,
            "jenisMutasiId" => 'MJ',
            "jenisPenugasanId" => "PLT",
            "nomorSk" => $nomorSk,
            "pnsId" => $pnsId,
            "satuanKerjaId" => 'A5EB03E24222F6A0E040640A040252AD',
            "subJabatanId" => $subJabatanId,
            "tanggalSk" => $tanggalSk,
            "tmtJabatan" => $tmtJabatan,
            "tmtMutasi" => $tmtJabatan,
            "tmtPelantikan" => $tmtPelantikan,
            "unorId" => $unorId
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

            $data2 = [
                'table_name' => $table_name,
                'id_table' => $id_table,
                'nama' => '/pns/data-utama-jabatansync',
                'PEGAWAI_ID' => $PEGAWAI_ID,
                'url' => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama-jabatansync?pns_orang_id=' . $pnsId,
                'status' => 'siap kirim data',
                'postget' => 'GET',
                'create_date' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('post_data_siap', $data2);

            $file = FCPATH . "tmp_dokumen/" . basename($FILE_PDF);
            $bodyjson = json_encode([
                "id_riwayat" => '',
                "id_ref_dokumen" => '872', // id ref dapat dari tabel refrensi BKN
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
        j.RW_JABATAN_ID_SAPK,
        j.PEGAWAI_ID
    ");


        $this->db->from('plt_plh j');
        $this->db->where('j.JABATAN_RIWAYAT_ID', $id);

        $row = $this->db->get()->row();

        $data = [
            'table_name' => 'plt_plh',
            'id_table' => $id,
            'nama' => '/jabatan/delete/',
            'PEGAWAI_ID' => $row->PEGAWAI_ID,
            'url' => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/jabatan/delete/' . $row->RW_JABATAN_ID_SAPK,
            'status' => 'siap kirim data',
            'postget' => 'DELETE',
            'create_date' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('post_data_siap', $data);
    }
}
