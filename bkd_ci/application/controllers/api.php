<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends SB_Controller
{

    private $api_mws_token;
    private $sso_token;


    function __construct()
    {
        parent::__construct();
        // Mengatur tipe konten header sebagai application/json
        header('Content-Type: application/json');

        $this->load->model('apimodel');

        $this->api_mws_token = $this->apimodel->getApiMwsToken();

        $this->sso_token = $this->apimodel->getSsoToken();
    }

    public function coba2()
    {
        echo "1";
    }

    public function get_master_jabatan_fungsional_tertentu()
    {
        // $result = $this->model->get_master_jabatan_fungsional_tertentu($nama);
        // Lakukan sesuatu dengan $result, misalnya tampilkan data ke view
        // $this->load->view('nama_view', ['data' => $result]);

        $this->load->model('mutasimodel');
        $this->model = $this->mutasimodel;

        $nama = $this->input->get('nama');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!empty($nama)) {
            $result = $this->model->get_master_jabatan_fungsional_tertentu($nama, $limit, $offset);

            // Set response format to JSON
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        } else {
            // Jika parameter nama tidak diberikan
            // $this->output->set_status_header(400); // Bad Request
            // $this->output->set_output('Parameter nama harus diisi.');

            $result = $this->model->get_master_jabatan_fungsional_tertentu('', $limit, $offset);

            // Set response format to JSON
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        }
    }


    public function get_master_jabatan_fungsional_umum()
    {
        // $result = $this->model->get_master_jabatan_fungsional_tertentu($nama);
        // Lakukan sesuatu dengan $result, misalnya tampilkan data ke view
        // $this->load->view('nama_view', ['data' => $result]);

        $this->load->model('mutasimodel');
        $this->model = $this->mutasimodel;

        $nama = $this->input->get('nama');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!empty($nama)) {
            $result = $this->model->get_master_jabatan_fungsional_umum($nama, $limit, $offset);

            // Set response format to JSON
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        } else {
            // Jika parameter nama tidak diberikan
            // $this->output->set_status_header(400); // Bad Request
            // $this->output->set_output('Parameter nama harus diisi.');

            $result = $this->model->get_master_jabatan_fungsional_umum('', $limit, $offset);

            // Set response format to JSON
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        }
    }

    public function get_master_satker()
    {
        // $result = $this->model->get_master_jabatan_fungsional_tertentu($nama);
        // Lakukan sesuatu dengan $result, misalnya tampilkan data ke view
        // $this->load->view('nama_view', ['data' => $result]);

        $this->load->model('mutasimodel');
        $this->model = $this->mutasimodel;
        $id = $this->input->get('id');

        if (!empty($id)) {
            $result = $this->model->get_master_satker($id);

            // Set response format to JSON
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        } else {
            // Jika parameter nama tidak diberikan
            $this->output->set_status_header(400); // Bad Request
            $this->output->set_output('Parameter nama harus diisi.');
        }
    }

    public function cetak_profil()
    {

        // Query 1: Set satker_induk_id dari tabel satker ke satker_induk_id dari tabel pegawai
        // $this->db->query('update pegawai as p
        // left join satker as s
        // on p.SATKER_ID = s.SATKER_ID
        // set p.SATKER_INDUK_ID = s.SATKER_INDUK_ID
        // where p.PEGAWAI_ID =  ' . $pegawai_id);

        // Ambil parameter NIP baru dari request
        $nip_baru = $this->input->get('nip_baru');

        // Query ke database untuk mendapatkan data pegawai berdasarkan NIP baru
        $query = $this->db->query("SELECT 
           PEGAWAI_ID,
           GELAR_DEPAN,
           GELAR_BELAKANG,
           NAMA,
           NIP_BARU,
           TEMPAT_LAHIR,
           DATE_FORMAT(TANGGAL_LAHIR, '%d-%m-%Y') as TANGGAL_LAHIR,
           JENIS_KELAMIN,
           AGAMA_ID,
           STATUS_KAWIN,
           NO_HP,
           TIPE_PEGAWAI_ID,
           SATKER_ID,
           TIPE_PEGAWAI_ID,
           FOTO_SETENGAH,
           STATUS_PEGAWAI
       FROM pegawai 
       WHERE NIP_BARU = ?", array($nip_baru));

        // Jika data ditemukan, proses data
        if ($query->num_rows() > 0) {
            $pegawai = $query->row_array();

            // Proses data lainnya sesuai kebutuhan
            // Misalnya, mengubah status kawin menjadi "Kawin" atau "Belum Kawin"
            $pegawai["STATUS PERNIKAHAN"] = ($pegawai["STATUS_KAWIN"] == "1") ? "Kawin" : "Belum Kawin";

            // Ambil data agama berdasarkan AGAMA_ID
            $agama_id = $pegawai["AGAMA_ID"];
            $agama_query = $this->db->query("SELECT NAMA FROM agama WHERE AGAMA_ID = ?", array($agama_id));
            if ($agama_query->num_rows() > 0) {
                $agama_data = $agama_query->row_array();
                $pegawai["AGAMA"] = $agama_data["NAMA"];
            }

            // Ambil data satker berdasarkan SATKER_ID
            $satker_id = $pegawai["SATKER_ID"];
            $satker_query = $this->db->query("SELECT hirarki_nama as NAMA FROM satker WHERE SATKER_ID = ?", array($satker_id));
            if ($satker_query->num_rows() > 0) {
                $satker_data = $satker_query->row_array();
                $pegawai["SATUAN KERJA"] = $satker_data["NAMA"];
            } else {
                $pegawai["SATUAN KERJA"] = null;
            }

            // Ambil data tipe pegawai berdasarkan TIPE_PEGAWAI_ID
            $tipe_pegawai_id = $pegawai["TIPE_PEGAWAI_ID"];
            $tipe_pegawai_query = $this->db->get_where('tipe_pegawai', array('TIPE_PEGAWAI_ID' => $tipe_pegawai_id));
            if ($tipe_pegawai_query->num_rows() > 0) {
                $tipe_pegawai_data = $tipe_pegawai_query->row_array();
                $pegawai["TIPE PEGAWAI"] = $tipe_pegawai_data["NAMA"];
            }

            // Ambil data TMT CPNS
            $sk_cpns_query = $this->db->get_where('sk_cpns', array('PEGAWAI_ID' => $pegawai["PEGAWAI_ID"]));
            if ($sk_cpns_query->num_rows() > 0) {
                $sk_cpns_data = $sk_cpns_query->row_array();
                $pegawai["TMT CPNS"] = date("d-M-y", strtotime($sk_cpns_data["TMT_CPNS"]));
            } else {
                $pegawai["TMT CPNS"] = null;
            }

            // Ambil data TMT PNS
            $sk_pns_query = $this->db->get_where('sk_pns', array('PEGAWAI_ID' => $pegawai["PEGAWAI_ID"]));
            if ($sk_pns_query->num_rows() > 0) {
                $sk_pns_data = $sk_pns_query->row_array();
                $pegawai["TMT PNS"] = date("d-M-y", strtotime($sk_pns_data["TMT_PNS"]));
            } else {
                $pegawai["TMT PNS"] = null;
            }

            // Ambil data pangkat terakhir (GOL_RUANG)
            $this->db->select('a.PEGAWAI_ID, a.PANGKAT_ID, a.TMT_PANGKAT, a.MASA_KERJA_TAHUN, a.MASA_KERJA_BULAN, b.KODE');
            $this->db->from('pangkat_riwayat a');
            $this->db->join('pangkat b', 'a.PANGKAT_ID = b.PANGKAT_ID');
            $this->db->where('a.PEGAWAI_ID', $pegawai["PEGAWAI_ID"]);
            $this->db->order_by('a.TMT_PANGKAT', 'DESC');
            $this->db->limit(1);
            $gol_ruang_query = $this->db->get();
            if ($gol_ruang_query->num_rows() > 0) {
                $gol_ruang_data = $gol_ruang_query->row_array();
                $pegawai["GOL RUANG"] = $gol_ruang_data["KODE"];
                $pegawai["TMT GOL RUANG"] = date("d-M-y", strtotime($gol_ruang_data["TMT_PANGKAT"]));
                $mk_gol_th = empty($gol_ruang_data["MASA_KERJA_TAHUN"]) ? "0" : $gol_ruang_data["MASA_KERJA_TAHUN"];
                $mk_gol_bl = empty($gol_ruang_data["MASA_KERJA_BULAN"]) ? "0" : $gol_ruang_data["MASA_KERJA_BULAN"];
                $pegawai["MK GOL"] = $mk_gol_th . 'Thn - ' . $mk_gol_bl . "Bln";
            } else {
                $pegawai["GOL RUANG"] = null;
                $pegawai["TMT GOL RUANG"] = null;
                $pegawai["MK GOL"] = null;
            }

            // Ambil data jabatan terakhir berdasarkan TMT_JABATAN
            $this->db->select('NAMA, TMT_JABATAN, ESELON_ID');
            $this->db->from('jabatan_riwayat');
            $this->db->where('PEGAWAI_ID', $pegawai["PEGAWAI_ID"]);
            $this->db->order_by('TMT_JABATAN', 'DESC');
            $jabatan_query = $this->db->get();
            if ($jabatan_query->num_rows() > 0) {
                $d_JABATAN = $jabatan_query->row_array();
                if (empty($d_JABATAN['ESELON_ID'])) {
                    $pegawai["JABATAN"] = $d_JABATAN["NAMA"];
                    $pegawai["TMT JABATAN"] = $d_JABATAN["TMT_JABATAN"];
                    $pegawai["ESELON"] = "-";
                } else {
                    $this->db->select('a.PEGAWAI_ID, a.JABATAN_RIWAYAT_ID, a.TMT_JABATAN, a.NAMA, b.NAMA ESELON');
                    $this->db->from('jabatan_riwayat a');
                    $this->db->join('eselon b', 'a.ESELON_ID = b.ESELON_ID');
                    $this->db->where('a.PEGAWAI_ID', $pegawai["PEGAWAI_ID"]);
                    $this->db->order_by('a.TMT_JABATAN', 'DESC');
                    $this->db->limit(1);
                    $jabatan_query_1 = $this->db->get();
                    if ($jabatan_query_1->num_rows() > 0) {
                        $d_JABATAN = $jabatan_query_1->row_array();
                        $pegawai["JABATAN"] = $d_JABATAN["NAMA"];
                        $pegawai["TMT JABATAN"] = date("d-M-y", strtotime($d_JABATAN["TMT_JABATAN"]));
                        $pegawai["ESELON"] = $d_JABATAN["ESELON"];
                    } else {
                        $pegawai["JABATAN"] = null;
                        $pegawai["TMT JABATAN"] = null;
                        $pegawai["ESELON"] = null;
                    }
                }
            }

            // Ambil data KGB terakhir berdasarkan TMT_SK
            $this->db->select('TMT_SK, GAJI_POKOK, MASA_KERJA_TAHUN, MASA_KERJA_BULAN');
            $this->db->from('gaji_riwayat');
            $this->db->where('PEGAWAI_ID', $pegawai["PEGAWAI_ID"]);
            $this->db->order_by('TMT_SK', 'DESC');
            $this->db->limit(1);
            $kgb_query = $this->db->get();
            if ($kgb_query->num_rows() > 0) {
                $d_KGB = $kgb_query->row_array();
                $pegawai["TMT KGB"] = date("d-M-y", strtotime($d_KGB["TMT_SK"]));
                $pegawai["GAJI BARU"] = $d_KGB["GAJI_POKOK"];
                $mk_thn = empty($d_KGB["MASA_KERJA_TAHUN"]) ? "0" : $d_KGB["MASA_KERJA_TAHUN"];
                $mk_bln = empty($d_KGB["MASA_KERJA_BULAN"]) ? "0" : $d_KGB["MASA_KERJA_BULAN"];
                $pegawai["MASA KERJA"] = $mk_thn . 'Thn - ' . $mk_bln . 'Bln';
            } else {
                $pegawai["TMT KGB"] = null;
                $pegawai["GAJI BARU"] = null;
                $pegawai["MASA KERJA"] = null;
            }

            // Ambil data pendidikan terakhir berdasarkan PENDIDIKAN_ID
            $this->db->select('A.JURUSAN, A.TANGGAL_STTB, B.NAMA JENJANG');
            $this->db->from('pendidikan_riwayat A');
            $this->db->join('pendidikan B', 'A.PENDIDIKAN_ID = B.PENDIDIKAN_ID');
            $this->db->where('PEGAWAI_ID', $pegawai["PEGAWAI_ID"]);
            $this->db->order_by('B.PENDIDIKAN_ID', 'DESC');
            $this->db->limit(1);
            $pendidikan_query = $this->db->get();
            if ($pendidikan_query->num_rows() > 0) {
                $d_PENDIDIKAN = $pendidikan_query->row_array();
                $pegawai["JENJANG"] = $d_PENDIDIKAN["JENJANG"];
                $pegawai["JURUSAN"] = $d_PENDIDIKAN["JURUSAN"];
                $pegawai["TANGGAL STTB"] = date("d-M-y", strtotime($d_PENDIDIKAN["TANGGAL_STTB"]));
            } else {
                $pegawai["JENJANG"] = null;
                $pegawai["JURUSAN"] =  null;
                $pegawai["TANGGAL STTB"] =  null;
            }

            // Ambil data diklat terakhir berdasarkan TANGGAL_STTPP
            $this->db->select('a.NAMA, b.PEGAWAI_ID, b.DIKLAT_ID, b.TANGGAL_STTPP');
            $this->db->from('diklat a');
            $this->db->join('diklat_struktural b', 'b.DIKLAT_ID = a.DIKLAT_ID');
            $this->db->where('pegawai_id', $pegawai["PEGAWAI_ID"]);
            $this->db->order_by('TANGGAL_STTPP', 'DESC');
            $this->db->limit(1);
            $diklat_query = $this->db->get();
            if ($diklat_query->num_rows() > 0) {
                $d_DIKLAT = $diklat_query->row_array();
                $pegawai["DIKLAT"] = $d_DIKLAT["NAMA"];
                $pegawai["TANGGAL STTPP"] = $d_DIKLAT["TANGGAL_STTPP"];
            } else {
                $pegawai["DIKLAT"] = null;
                $pegawai["TANGGAL STTPP"] = null;
            }

            // Ambil data status pegawai berdasarkan STATUS_PEGAWAI_ID
            $status_pegawai_id = $pegawai["STATUS_PEGAWAI"];
            $status_pegawai_query = $this->db->get_where('status_pegawai', array('STATUS_PEGAWAI_ID' => $status_pegawai_id));
            if ($status_pegawai_query->num_rows() > 0) {
                $d_STATUS_PEGAWAI = $status_pegawai_query->row_array();
                $pegawai["STATUS PEGAWAI"] = $d_STATUS_PEGAWAI["NAMA"];
            }

            //$hasil[1] = $pegawai;

            $hasil[1]['PEGAWAI_ID'] = $pegawai['PEGAWAI_ID'];
            $hasil[1]['GELAR_DEPAN'] = $pegawai['GELAR_DEPAN'];
            $hasil[1]['GELAR_BELAKANG'] = $pegawai['GELAR_BELAKANG'];
            $hasil[1]['NAMA'] = $pegawai['NAMA'];
            $hasil[1]['NIP_BARU'] = $pegawai['NIP_BARU'];
            $hasil[1]['TEMPAT_LAHIR'] = $pegawai['TEMPAT_LAHIR'];
            $hasil[1]['TANGGAL_LAHIR'] = $pegawai['TANGGAL_LAHIR'];
            $hasil[1]['JENIS_KELAMIN'] = $pegawai['JENIS_KELAMIN'];
            $hasil[1]['AGAMA_ID'] = $pegawai['AGAMA_ID'];
            $hasil[1]['STATUS_KAWIN'] = $pegawai['STATUS_KAWIN'];
            $hasil[1]['NO_HP'] = $pegawai['NO_HP'];
            $hasil[1]['TIPE_PEGAWAI_ID'] = $pegawai['TIPE_PEGAWAI_ID'];
            $hasil[1]['SATKER_ID'] = $pegawai['SATKER_ID'];
            $hasil[1]['STATUS_PEGAWAI'] = $pegawai['STATUS_PEGAWAI'];
            $hasil[1]['FOTO_SETENGAH'] = 'https://siap-bkpsdm.probolinggokab.go.id/foto/' . $pegawai['NIP_BARU'] . '/' . $pegawai['FOTO_SETENGAH'];




            // $hasil['i'] = $pegawai;

            $hasil['i']['AGAMA'] = $pegawai['AGAMA'];
            $hasil['i']['STATUS PERNIKAHAN'] = $pegawai['STATUS PERNIKAHAN'];
            $hasil['i']['SATUAN KERJA'] = $pegawai['SATUAN KERJA'];
            $hasil['i']['TIPE PEGAWAI'] = $pegawai['TIPE PEGAWAI'];
            $hasil['i']['TMT CPNS'] = $pegawai['TMT CPNS'];
            $hasil['i']['TMT PNS'] = $pegawai['TMT PNS'];
            $hasil['i']['GOL RUANG'] = $pegawai['GOL RUANG'];
            $hasil['i']['TMT GOL RUANG'] = $pegawai['TMT GOL RUANG'];
            $hasil['i']['MK GOL'] = $pegawai['MK GOL'];
            $hasil['i']['JABATAN'] = $pegawai['JABATAN'];
            $hasil['i']['TMT JABATAN'] = $pegawai['TMT JABATAN'];
            $hasil['i']['ESELON'] = $pegawai['ESELON'];
            $hasil['i']['TMT KGB'] = $pegawai['TMT KGB'];
            $hasil['i']['GAJI BARU'] = $pegawai['GAJI BARU'];
            $hasil['i']['MASA KERJA'] = $pegawai['MASA KERJA'];
            $hasil['i']['JENJANG'] = $pegawai['JENJANG'];
            $hasil['i']['JURUSAN'] = $pegawai['JURUSAN'];
            $hasil['i']['TANGGAL STTB'] = $pegawai['TANGGAL STTB'];
            $hasil['i']['DIKLAT'] = $pegawai['DIKLAT'];
            $hasil['i']['TANGGAL STTPP'] = $pegawai['TANGGAL STTPP'];
            $hasil['i']['STATUS PEGAWAI'] = $pegawai['STATUS PEGAWAI'];



            // Tampilkan data dalam format JSON
            // echo json_encode($pegawai);
            echo json_encode($hasil);
        } else {
            // Jika data tidak ditemukan, kirimkan pesan atau respons sesuai kebutuhan
            echo "Data pegawai dengan NIP baru $nip_baru tidak ditemukan.";
        }
    }

    public function cetak_profil_nonasn()
    {

        // Query 1: Set satker_induk_id dari tabel satker ke satker_induk_id dari tabel pegawai
        // $this->db->query('update pegawai as p
        // left join satker as s
        // on p.SATKER_ID = s.SATKER_ID
        // set p.SATKER_INDUK_ID = s.SATKER_INDUK_ID
        // where p.PEGAWAI_ID =  ' . $pegawai_id);

        // Ambil parameter NIP baru dari request
        $nik = $this->input->get('nik');

        // Query ke database untuk mendapatkan data pegawai berdasarkan NIP baru
        $query = $this->db->query("SELECT 
           PEGAWAI_ID,
           GELAR_DEPAN,
           GELAR_BELAKANG,
           NAMA,
           NIK,
           NIP_BARU,
           TEMPAT_LAHIR,
           DATE_FORMAT(TANGGAL_LAHIR, '%d-%m-%Y') as TANGGAL_LAHIR,
           JENIS_KELAMIN,
           AGAMA_ID,
           STATUS_KAWIN,
           NO_HP,
           TIPE_PEGAWAI_ID,
           SATKER_ID,
           TIPE_PEGAWAI_ID,
           FOTO_SETENGAH,
           NO_KTA AS PENDIDIKAN_SK,
           NO_KPE AS JABATAN_SK,
           STATUS_PEGAWAI
       FROM pegawai 
       WHERE STATUS_PEGAWAI in ('11', '12', '13', '15', '16')
       AND NIK = ?", array($nik));

        // Jika data ditemukan, proses data
        if ($query->num_rows() > 0) {
            $pegawai = $query->row_array();

            // Proses data lainnya sesuai kebutuhan
            // Misalnya, mengubah status kawin menjadi "Kawin" atau "Belum Kawin"
            $pegawai["STATUS PERNIKAHAN"] = ($pegawai["STATUS_KAWIN"] == "1") ? "Kawin" : "Belum Kawin";

            // Ambil data agama berdasarkan AGAMA_ID
            $agama_id = $pegawai["AGAMA_ID"];
            $agama_query = $this->db->query("SELECT NAMA FROM agama WHERE AGAMA_ID = ?", array($agama_id));
            if ($agama_query->num_rows() > 0) {
                $agama_data = $agama_query->row_array();
                $pegawai["AGAMA"] = $agama_data["NAMA"];
            }

            // Ambil data satker berdasarkan SATKER_ID
            $satker_id = $pegawai["SATKER_ID"];
            $satker_query = $this->db->query("SELECT hirarki_nama as NAMA FROM satker WHERE SATKER_ID = ?", array($satker_id));
            if ($satker_query->num_rows() > 0) {
                $satker_data = $satker_query->row_array();
                $pegawai["SATUAN KERJA"] = $satker_data["NAMA"];
            } else {
                $pegawai["SATUAN KERJA"] = null;
            }

            // Ambil data tipe pegawai berdasarkan TIPE_PEGAWAI_ID
            $tipe_pegawai_id = $pegawai["TIPE_PEGAWAI_ID"];
            $tipe_pegawai_query = $this->db->get_where('tipe_pegawai', array('TIPE_PEGAWAI_ID' => $tipe_pegawai_id));
            if ($tipe_pegawai_query->num_rows() > 0) {
                $tipe_pegawai_data = $tipe_pegawai_query->row_array();
                $pegawai["TIPE PEGAWAI"] = $tipe_pegawai_data["NAMA"];
            }

            // Ambil data pendidikan terakhir berdasarkan PENDIDIKAN_ID
            $this->db->select('A.JURUSAN, A.TANGGAL_STTB, B.NAMA JENJANG');
            $this->db->from('pendidikan_riwayat A');
            $this->db->join('pendidikan B', 'A.PENDIDIKAN_ID = B.PENDIDIKAN_ID');
            $this->db->where('PEGAWAI_ID', $pegawai["PEGAWAI_ID"]);
            $this->db->order_by('B.PENDIDIKAN_ID', 'DESC');
            $this->db->limit(1);
            $pendidikan_query = $this->db->get();
            if ($pendidikan_query->num_rows() > 0) {
                $d_PENDIDIKAN = $pendidikan_query->row_array();
                $pegawai["JENJANG"] = $d_PENDIDIKAN["JENJANG"];
                $pegawai["JURUSAN"] = $d_PENDIDIKAN["JURUSAN"];
                $pegawai["TANGGAL STTB"] = date("d-M-y", strtotime($d_PENDIDIKAN["TANGGAL_STTB"]));
            } else {
                $pegawai["JENJANG"] = null;
                $pegawai["JURUSAN"] =  null;
                $pegawai["TANGGAL STTB"] =  null;
            }


            // Ambil data status pegawai berdasarkan STATUS_PEGAWAI_ID
            $status_pegawai_id = $pegawai["STATUS_PEGAWAI"];
            $status_pegawai_query = $this->db->get_where('status_pegawai', array('STATUS_PEGAWAI_ID' => $status_pegawai_id));
            if ($status_pegawai_query->num_rows() > 0) {
                $d_STATUS_PEGAWAI = $status_pegawai_query->row_array();
                $pegawai["STATUS PEGAWAI"] = $d_STATUS_PEGAWAI["NAMA"];
            }

            //$hasil[1] = $pegawai;
            $hasil[1]['message'] = 'data ditemukan';
            $hasil[1]['PEGAWAI_ID'] = $pegawai['PEGAWAI_ID'];
            $hasil[1]['GELAR_DEPAN'] = $pegawai['GELAR_DEPAN'];
            $hasil[1]['GELAR_BELAKANG'] = $pegawai['GELAR_BELAKANG'];
            $hasil[1]['NAMA'] = $pegawai['NAMA'];
            $hasil[1]['NIK'] = $pegawai['NIK'];
            $hasil[1]['NIP_BARU'] = $pegawai['NIP_BARU'];
            $hasil[1]['TEMPAT_LAHIR'] = $pegawai['TEMPAT_LAHIR'];
            $hasil[1]['TANGGAL_LAHIR'] = $pegawai['TANGGAL_LAHIR'];
            $hasil[1]['JENIS_KELAMIN'] = $pegawai['JENIS_KELAMIN'];
            $hasil[1]['AGAMA_ID'] = $pegawai['AGAMA_ID'];
            $hasil[1]['STATUS_KAWIN'] = $pegawai['STATUS_KAWIN'];
            $hasil[1]['NO_HP'] = $pegawai['NO_HP'];
            $hasil[1]['TIPE_PEGAWAI_ID'] = $pegawai['TIPE_PEGAWAI_ID'];
            $hasil[1]['SATKER_ID'] = $pegawai['SATKER_ID'];
            $hasil[1]['STATUS_PEGAWAI'] = $pegawai['STATUS_PEGAWAI'];
            $hasil[1]['FOTO_SETENGAH'] = 'https://siap-bkpsdm.probolinggokab.go.id/foto/' . $pegawai['NIP_BARU'] . '/' . $pegawai['FOTO_SETENGAH'];




            // $hasil['i'] = $pegawai;

            $hasil['i']['AGAMA'] = $pegawai['AGAMA'];
            $hasil['i']['SATUAN KERJA'] = $pegawai['SATUAN KERJA'];
            $hasil['i']['TIPE PEGAWAI'] = $pegawai['TIPE PEGAWAI'];
            $hasil['i']['JABATAN'] = $pegawai['JABATAN_SK'];
            $hasil['i']['PENDIDIKAN PADA SK'] = $pegawai['PENDIDIKAN_SK'];
            $hasil['i']['JENJANG TERAKHIR'] = $pegawai['JENJANG'];
            $hasil['i']['JURUSAN TERAKHIR'] = $pegawai['JURUSAN'];
            $hasil['i']['TANGGAL STTB'] = $pegawai['TANGGAL STTB'];
            $hasil['i']['STATUS PEGAWAI'] = $pegawai['STATUS PEGAWAI'];



            // Tampilkan data dalam format JSON
            // echo json_encode($pegawai);
            echo json_encode($hasil);
        } else {
            // Jika data tidak ditemukan, kirimkan pesan atau respons sesuai kebutuhan
            // echo "Data pegawai dengan NIP baru $nik tidak ditemukan.";

            $hasil[1]['message'] = 'data tidak ditemukan';
            echo json_encode($hasil);
        }
    }


    public function v_sumary_pegawai()
    {

        set_time_limit(1800);

        // $nip_baru = $this->input->get('nip_baru');
        $nip = $this->input->post('nip');
        // $nip = $this->input->post('nip');

        // echo "yuhu";
        // exit();

        $where_nip = "";

        if ($nip != "" && $nip != null) {
            $nip = str_replace(' ', '', $nip);
            $where_nip = "where p.NIP_BARU = '" . $nip . "'";
        }

        $sql = "select 
        p.PEGAWAI_ID, 
        p.NIP_LAMA, 
        p.NIP_BARU, 
        p.NAMA, 
        p.SATKER_ID, 
        p.SATKER_INDUK_ID as SATKER_ID_PARENT, 
        p.GELAR_DEPAN, 
        p.GELAR_BELAKANG, 
        p.STATUS_KAWIN, 
        p.TEMPAT_LAHIR, 
        p.TANGGAL_LAHIR, 
        p.JENIS_KELAMIN, 
        p.no_hp, 
        p.ALAMAT, 
        p.RT, 
        p.RW, 
        p.KELURAHAN_ID, 
        p.KECAMATAN_ID, 
        p.KABUPATEN_ID, 
        p.PROPINSI_ID, 
        p.TANGGAL_PENSIUN as tmt_pensiun, 
        p.ID_SAPK as STATUS_SAPK,
        a.NAMA as agama,
        sp.NAMA as status_pns,
        s1.NAMA as Satker,
        s1.KODE_WILAYAH as KODE_WILAYAH,
        s2.NAMA as SatkerParent,
        
        j.TMT_ESELON,
        j.nama as jabatan,
        j.KELAS_JABATAN,
        j.NAMA_KELAS_JABATAN,
        j.NILAI_KELAS_JABATAN,
        j.KELAS_JABATAN_ID,
        j.TMT_JABATAN,
        j.JABATAN_RIWAYAT_ID,
        j.NO_SK as NO_SK_JABATAN,
        j.SATKER_ID as JABATAN_RIWAYAT_SATKER_ID,
        e.NAMA as eselon,
        jj.NAMA as jenis_jabatan,
        pr.TMT_PANGKAT as tmt_pangkat,
        pkt.KODE as gol_ruang,
        pdr.NAMA as nama_sekolah,
        pdr.TEMPAT as TEMPAT_SEKOLAH,
        pdr.TANGGAL_STTB,
        jpdk.NAMA as jurusan,
        pddk.NAMA as pendidikan,
        ds.ketdik as DIKLAT_ID,
        ds.NO_STTPP as DIKLAT_KETERANGAN,
        ds.TANGGAL_STTPP,
        (CASE WHEN phgn.nama = '3' THEN 'Satya Lencana Karya Satya XXX (Emas)' ELSE 
        (CASE WHEN phgn.nama = '2' THEN 'Satya Lencana Karya Satya XX (Perak)' ELSE 
        (CASE WHEN phgn.nama = '1' THEN 'Satya Lencana Karya Satya X (Perunggu)' ELSE phgn.nama END)
        END)
        END) as PENGHARGAAN,
        phgn.NO_SK as NO_SK_PENGHARGAAN,
        phgn.TANGGAL_SK as TANGGAL_SK_PENGHARGAAN
        
        
        
        from pegawai as p
        left join agama as a on p.AGAMA_ID = a.AGAMA_ID
        left join status_pegawai as sp on p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID
        left join satker as s1 on p.SATKER_ID = s1.SATKER_ID
        left join satker as s2 on s2.SATKER_ID = s1.SATKER_INDUK_ID
        left join jabatan_riwayat as j on p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID
        left join eselon as e on j.ESELON_ID = e.ESELON_ID
        left join jenis_jabatan as jj on j.JENIS_JABATAN_SAPK = jj.ID
        left join pangkat_riwayat as pr on p.PANGKAT_ID_TERAKHIR = pr.PANGKAT_RIWAYAT_ID
        left join pangkat as pkt on pr.PANGKAT_ID = pkt.PANGKAT_ID
        left join pendidikan_riwayat as pdr on p.PENDIDIKAN_ID_TERAKHIR = pdr.PENDIDIKAN_RIWAYAT_ID
        left join jurusan_pendidikan as jpdk on pdr.JURUSAN_PENDIDIKAN_ID = jpdk.JURUSAN_PENDIDIKAN_ID
        left join pendidikan as pddk on pddk.PENDIDIKAN_ID = pdr.PENDIDIKAN_ID
        
        
        LEFT JOIN (select ds.*, d.NAMA, d.KETERANGAN as ketdik, min(d.TINGKATAN) from diklat_struktural as ds 
        left join diklat as d on ds.DIKLAT_ID = d.DIKLAT_ID
        group by ds.PEGAWAI_ID ORDER BY D.TINGKATAN) AS ds on p.PEGAWAI_ID = ds.PEGAWAI_ID
        
        left join (select *, max(peng.tahun) from penghargaan as peng
        where peng.NAMA in ('1','2','3') 
        group by peng.PEGAWAI_ID) as phgn on p.PEGAWAI_ID = phgn.PEGAWAI_ID " . $where_nip . " limit 10";

        // $query = $this->db->query($sql);

        $query = $this->db->query($sql);


        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $query->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }

    public function cron_per_pegawai() {}

    public function setDataTerakhirdesc()
    {

        echo "1";
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


        echo "2";

        $query = $this->db->query("select p.* from pegawai as p 
        where p.STATUS_PEGAWAI  in (1,2,10)
        and p.PEGAWAI_ID not in (SELECT pegwai_id
        FROM riwayat_cronjob
        WHERE nama_cronjob = 'set data terakhir pangkat, jabatan, pendidikan'
        AND tanggal_eksekusi > NOW() - INTERVAL 3 DAY
        GROUP BY pegwai_id)
                order by p.NIP_BARU desc");

        echo "3";

        // Cek apakah query berhasil dieksekusi
        if ($query) {
            // Ambil hasil query dalam bentuk array dari objek
            $result = $query->result();

            // Looping untuk menampilkan pegawai_id dari setiap hasil data
            foreach ($result as $row) {
                $pegawai_id = $row->PEGAWAI_ID;
                $nip_baru = $row->NIP_BARU;
                echo "4";

                $this->get_data_utama($pegawai_id, $nip_baru);
                // kedepannya bakal diisi ini seperti dibawah ini : 
                //post data jabatan ke siasn dan set 1 bila jabatan tersebut sudah di update di siasn
                //get data pangkat terakhir dan ambil filenya juga
                //get data jabatan terakhir dan ambil filenya juga
                //get data pendidikan terakhir dan ambil filenya juga

                $this->setDataTerakhirPendidikan($pegawai_id);

                echo "5";
                $this->setDataTerakhirJabatan($pegawai_id);

                echo "6";
                $this->setDataTerakhirPangkat($pegawai_id);

                // kedepannya bakal diisi ini seperti dibawah ini : 
                //get data diklat semua
                //get data seminar dan masukkan atau update ke simpeg
                //get skp dan masukkan atau update

                echo "7";
                $data = array(
                    'pegwai_id' => $pegawai_id,
                    'nama_cronjob' => 'set data terakhir pangkat, jabatan, pendidikan',
                    'hasil_cronjob' => 'selesai dieksekusi',
                    'tanggal_eksekusi' => date('Y-m-d')
                );


                echo "8";
                $this->db->insert('riwayat_cronjob', $data);

                echo $row->NIP_BARU . " selesai <br>";

                // exit();
            }
        } else {
            echo 'Query tidak berhasil dieksekusi.';
        }


        echo "9";
        // $pegawai_id = $_GET['pegawai_id'];

    }



    public function setDataTerakhir()
    {

        // echo "1";
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


        echo "2";

        $query = $this->db->query("select p.* from pegawai as p 
        where p.STATUS_PEGAWAI  in (1,2,10)
        and p.PEGAWAI_ID not in (SELECT pegwai_id
        FROM riwayat_cronjob
        WHERE nama_cronjob = 'set data terakhir pangkat, jabatan, pendidikan'
        AND tanggal_eksekusi > NOW() - INTERVAL 3 DAY
        GROUP BY pegwai_id)
                order by p.NIP_BARU");

        echo "3";

        // Cek apakah query berhasil dieksekusi
        if ($query) {
            // Ambil hasil query dalam bentuk array dari objek
            $result = $query->result();

            // Looping untuk menampilkan pegawai_id dari setiap hasil data
            foreach ($result as $row) {
                $pegawai_id = $row->PEGAWAI_ID;
                $nip_baru = $row->NIP_BARU;
                echo "4";

                $this->get_data_utama($pegawai_id, $nip_baru);
                // kedepannya bakal diisi ini seperti dibawah ini : 
                //post data jabatan ke siasn dan set 1 bila jabatan tersebut sudah di update di siasn
                //get data pangkat terakhir dan ambil filenya juga
                //get data jabatan terakhir dan ambil filenya juga
                //get data pendidikan terakhir dan ambil filenya juga

                $this->setDataTerakhirPendidikan($pegawai_id);

                echo "5";
                $this->setDataTerakhirJabatan($pegawai_id);

                echo "6";
                $this->setDataTerakhirPangkat($pegawai_id);

                // kedepannya bakal diisi ini seperti dibawah ini : 
                //get data diklat semua
                //get data seminar dan masukkan atau update ke simpeg
                //get skp dan masukkan atau update

                echo "7";
                $data = array(
                    'pegwai_id' => $pegawai_id,
                    'nama_cronjob' => 'set data terakhir pangkat, jabatan, pendidikan',
                    'hasil_cronjob' => 'selesai dieksekusi',
                    'tanggal_eksekusi' => date('Y-m-d')
                );


                echo "8";
                $this->db->insert('riwayat_cronjob', $data);

                echo $row->NIP_BARU . " selesai <br>";

                // exit();
            }
        } else {
            echo 'Query tidak berhasil dieksekusi.';
        }


        echo "9";
        // $pegawai_id = $_GET['pegawai_id'];

    }

    public function setDataTerakhirPendidikan($pegawai_id)
    {
        // $pegawai_id = $_GET['pegawai_id'];

        // Query 1: Set flag_data_terakhir = 0
        $this->db->query("update pendidikan_riwayat as p set p.FLAG_DATA_TERAKHIR = 0 where p.PEGAWAI_ID = '  $pegawai_id'");

        // Query 2: Set flag_data_terakhir = 1
        $this->db->query("UPDATE pendidikan_riwayat AS p
        SET p.FLAG_DATA_TERAKHIR = 1
        WHERE p.PEGAWAI_ID = '$pegawai_id'
        ORDER BY p.TANGGAL_STTB DESC
        LIMIT 1");



        // Query 3: Update JABATAN_ID_TERAKHIR in table pegawai
        $this->db->query("UPDATE pegawai p
        JOIN (
            SELECT PENDIDIKAN_RIWAYAT_ID, PEGAWAI_ID
            FROM pendidikan_riwayat
            WHERE FLAG_DATA_TERAKHIR = 1 AND PEGAWAI_ID = '$pegawai_id'
        ) AS j ON p.pegawai_id = j.PEGAWAI_ID
        SET p.PENDIDIKAN_ID_TERAKHIR = j.PENDIDIKAN_RIWAYAT_ID");
    }

    public function setDataTerakhirJabatan($pegawai_id)
    {


        // $pegawai_id = $_GET['pegawai_id'];
        // Query 1: Set flag_data_terakhir = 0
        $this->db->query("update jabatan_riwayat as j set j.FLAG_DATA_TERAKHIR = 0 where j.PEGAWAI_ID = '$pegawai_id'");

        // Query 2: Set flag_data_terakhir = 1
        $this->db->query("UPDATE jabatan_riwayat AS j
        SET j.flag_data_terakhir = 1,
            j.eselon_id = IF(j.jenis_jabatan_sapk in (2,4), NULL, j.eselon_id),
            j.jabatan_fungsional_id = IF(j.jenis_jabatan_sapk in (2,4), NULL, j.jabatan_fungsional_id),
            j.jfu_id_sapk = IF(j.jenis_jabatan_sapk = 2, NULL, j.jfu_id_sapk),
            j.jfu_nama_sapk = IF(j.jenis_jabatan_sapk = 2, NULL, j.jfu_nama_sapk),
            j.jft_id_sapk = IF(j.jenis_jabatan_sapk = 4, NULL, j.jft_id_sapk),
            j.jft_nama_sapk = IF(j.jenis_jabatan_sapk = 4, NULL, j.jft_nama_sapk)
        WHERE j.PEGAWAI_ID = '$pegawai_id'
        ORDER BY j.TMT_JABATAN DESC, j.TANGGAL_SK DESC
        LIMIT 1");

        // Query 1: Set idPns dan idPns dari tabel pegawai ke jabatan riwayat
        $this->db->query("update pegawai as p
        left join jabatan_riwayat as j 
        on p.PEGAWAI_ID = j.PEGAWAI_ID
        set j.idPns = p.ID_SAPK, j.nipBaru = p.NIP_BARU
        where p.PEGAWAI_ID = '$pegawai_id'");


        // Query 3: Update JABATAN_ID_TERAKHIR in table pegawai
        $this->db->query("UPDATE pegawai p
        JOIN (
            SELECT jabatan_riwayat_id, PEGAWAI_ID, SATKER_ID
            FROM jabatan_riwayat
            WHERE FLAG_DATA_TERAKHIR = 1 AND PEGAWAI_ID = '$pegawai_id'
        ) AS j ON p.pegawai_id = j.PEGAWAI_ID 
        SET p.JABATAN_ID_TERAKHIR = j.jabatan_riwayat_id, p.satker_id = j.satker_id
        where j.satker_id is not null or j.satker_id not like ''  ");

        // Query 1: Set satker_induk_id dari tabel satker ke satker_induk_id dari tabel pegawai
        $this->db->query("update pegawai as p
        left join satker as s
        on p.SATKER_ID = s.SATKER_ID
        set p.SATKER_INDUK_ID = s.SATKER_INDUK_ID
        where p.PEGAWAI_ID =  '$pegawai_id'");

        // Query 1: Set svalidasi = '1' ketika yang update adalah user admin
        $this->db->query("update perubahan_data as p 
        left join tb_users as t on p.LAST_CREATE_USER = t.username
        set 
        p.VALIDASI = 1, 
        p.VALIDATOR = t.username, 
        p.TANGGAL = NOW(), 
        p.LAST_UPDATE_USER = t.username,
        p.LAST_UPDATE_DATE = NOW() 
        where t.group_id = 1 and p.VALIDASI = 0");

        // Query : Set svalidasi tanggal pensiun
        $this->db->query("update pegawai as p 
        left join jabatan_riwayat as j 
        on p.pegawai_id = j.pegawai_id
        set p.TANGGAL_PENSIUN = DATE_FORMAT(DATE_ADD(DATE_ADD(p.TANGGAL_LAHIR, INTERVAL j.KETERANGAN_BUP YEAR),INTERVAL 1 MONTH), '%Y-%m-01')
        where j.FLAG_DATA_TERAKHIR = 1 and j.KETERANGAN_BUP is not null and p.TANGGAL_LAHIR is not null
        and p.PEGAWAI_ID = '  $pegawai_id'");

        $this->db->query("update jabatan_riwayat as j 
        set j.ESELON_ID = NULL
        where j.ESELON_ID = 0");
    }

    public function setDataTerakhirPangkat($pegawai_id)
    {

        // $pegawai_id = $_GET['pegawai_id'];
        // Query 1: Set flag_data_terakhir = 0
        $this->db->query("update pangkat_riwayat as j 
        left join pangkat as p 
        on j.PANGKAT_ID = p.PANGKAT_ID
        set j.FLAG_DATA_TERAKHIR = 0, j.GOLONGAN_NAMA = p.KODE where j.PEGAWAI_ID = '$pegawai_id'");

        // Query 2: Set flag_data_terakhir = 1
        $this->db->query("UPDATE pangkat_riwayat AS j
        SET j.flag_data_terakhir = 1
        WHERE j.PEGAWAI_ID = '$pegawai_id'
        ORDER BY j.TMT_PANGKAT DESC, j.PANGKAT_ID DESC
        LIMIT 1");

        // Query 3: Update JABATAN_ID_TERAKHIR in table pegawai
        $this->db->query("UPDATE pegawai p
        JOIN (
            SELECT pangkat_riwayat_id, PEGAWAI_ID
            FROM pangkat_riwayat
            WHERE FLAG_DATA_TERAKHIR = 1 AND PEGAWAI_ID = '$pegawai_id'
        ) AS j ON p.pegawai_id = j.PEGAWAI_ID
        SET p.PANGKAT_ID_TERAKHIR = j.pangkat_riwayat_id");
    }

    public function get_data_utama($pegawai_id, $nip_baru)
    {
        // Remove redundant API token fetching since we already have them from constructor
        $data_utama = $this->apimodel->get_data_utama($this->sso_token, $this->api_mws_token, $nip_baru);

        // print_r($data_utama);

        $data = json_decode($data_utama, true);
        $sapk_id = $data['data']['id'];


        $this->db
            ->where('pegawai_id', $pegawai_id)
            ->update(
                'PEGAWAI',
                array(
                    'ID_SAPK' => $sapk_id
                )
            );

        //cek folder pada dokumen, apakah ada folder dengan nama nip mereka, bila belum ada maka buat dan bila sudah ada biarkan saja.

        //get data pendidikan -> ambil yang terakhir saja, bila belum ada maka isi, bila sudah ada maka update
        // $pendidikan = $this->apimodel->get_rw_wsbkn($sso_token, $api_mws_token, $nip_baru, 'pendidikan');
        // print_r($pendidikan);

        //get data jabatan -> ambil yang terakhir saja, bila belum ada maka isi, bila sudah ada maka update

        //get data pangkat -> ambil yang terakhir saja, bila belum ada maka isi, bila sudah ada maka update

    }

    public function get_riwayat_jabatan()
    {

        // $nip_baru = $_GET['PEGAWAI_ID'];

        // Mendapatkan nilai dari variabel $_GET['pegawai_id']
        $pegawai_id = isset($_GET['PEGAWAI_ID']) ? $_GET['PEGAWAI_ID'] : null;

        $twhere = '';
        // Gunakan kondisi untuk mengatur variabel menjadi NULL jika tidak diisi
        if (empty($pegawai_id)) {
            $pegawai_id = null;
        } else {
            $twhere = "WHERE j.PEGAWAI_ID = '" . $pegawai_id . "' ";
        }


        // Query untuk mendapatkan data jabatan riwayat
        $jabatanriwayat = $this->db->query("SELECT * FROM jabatan_riwayat AS j 
        " . $twhere . "
        ORDER BY j.TMT_JABATAN DESC");

        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $jabatanriwayat->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }

    // riwayat_diklat_struktural
    public function riwayat_diklat_struktural()
    {

        // $nip_baru = $_GET['PEGAWAI_ID'];

        // Mendapatkan nilai dari variabel $_GET['pegawai_id']
        $pegawai_id = isset($_GET['PEGAWAI_ID']) ? $_GET['PEGAWAI_ID'] : null;

        $twhere = '';
        // Gunakan kondisi untuk mengatur variabel menjadi NULL jika tidak diisi
        if (empty($pegawai_id)) {
            $pegawai_id = null;
        } else {
            $twhere = "WHERE d.PEGAWAI_ID = '" . $pegawai_id . "' ";
        }


        // Query untuk mendapatkan data jabatan riwayat
        $riwayat = $this->db->query("select dd.NAMA as nama_diklat, d.* from diklat_struktural as d join diklat dd on d.DIKLAT_ID = dd.DIKLAT_ID
        " . $twhere);

        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $riwayat->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }

    // v_riwayat_diklat_teknis
    public function riwayat_diklat_teknis()
    {

        // $nip_baru = $_GET['PEGAWAI_ID'];

        // Mendapatkan nilai dari variabel $_GET['pegawai_id']
        $pegawai_id = isset($_GET['PEGAWAI_ID']) ? $_GET['PEGAWAI_ID'] : null;

        $twhere = '';
        // Gunakan kondisi untuk mengatur variabel menjadi NULL jika tidak diisi
        if (empty($pegawai_id)) {
            $pegawai_id = null;
        } else {
            $twhere = "WHERE PEGAWAI_ID = '" . $pegawai_id . "' ";
        }


        // Query untuk mendapatkan data jabatan riwayat
        $riwayat = $this->db->query("select * from diklat_teknis 
        " . $twhere);

        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $riwayat->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }

    // riwayat_diklat_fungsional
    public function riwayat_diklat_fungsional()
    {

        // $nip_baru = $_GET['PEGAWAI_ID'];

        // Mendapatkan nilai dari variabel $_GET['pegawai_id']
        $pegawai_id = isset($_GET['PEGAWAI_ID']) ? $_GET['PEGAWAI_ID'] : null;

        $twhere = '';
        // Gunakan kondisi untuk mengatur variabel menjadi NULL jika tidak diisi
        if (empty($pegawai_id)) {
            $pegawai_id = null;
        } else {
            $twhere = "WHERE PEGAWAI_ID = '" . $pegawai_id . "' ";
        }


        // Query untuk mendapatkan data jabatan riwayat
        $riwayat = $this->db->query("select * from diklat_fungsional 
        " . $twhere);

        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $riwayat->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }

    // riwayat_hukuman_disiplin
    public function riwayat_hukuman_disiplin()
    {

        // $nip_baru = $_GET['PEGAWAI_ID'];

        // Mendapatkan nilai dari variabel $_GET['pegawai_id']
        $pegawai_id = isset($_GET['PEGAWAI_ID']) ? $_GET['PEGAWAI_ID'] : null;

        $twhere = '';
        // Gunakan kondisi untuk mengatur variabel menjadi NULL jika tidak diisi
        if (empty($pegawai_id)) {
            $pegawai_id = null;
        } else {
            $twhere = "WHERE PEGAWAI_ID = '" . $pegawai_id . "' ";
        }


        // Query untuk mendapatkan data jabatan riwayat
        $riwayat = $this->db->query("select * from hukuman 
        " . $twhere);

        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $riwayat->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }
    public function get_satker()
    {



        // Query untuk mendapatkan data jabatan riwayat
        $satker = $this->db->query("SELECT * FROM satker");

        // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
        $resultArray = $satker->result_array();

        // Mengubah hasil query menjadi format JSON
        $jsonResult = json_encode($resultArray);

        // Mengatur header untuk memberitahu browser bahwa respons adalah JSON
        header('Content-Type: application/json');

        // Menampilkan JSON
        echo $jsonResult;
    }

    public function get_api_ws()
    // public function get_data_utama()
    {
        // $pegawai_id = '2357599046760';
        // $nip_baru = '198204222023212001';


        $nip_baru = $_GET['nip_baru'];

        $path = $_GET['path'];


        // echo $this->$sso_token;


        $this->load->model('apimodel');

        $api_mws_token = $this->apimodel->getApiMwsToken();

        $sso_token = $this->apimodel->getSsoToken();

        $data_utama = $this->apimodel->get_api_ws($sso_token, $api_mws_token, $nip_baru, $path);


        print_r($data_utama);
    }



    // public function get_api_ws()
    // {

    //     $this->db->query("update jabatan_riwayat as j 
    //  set j.ESELON_ID = NULL
    //  where j.ESELON_ID = 0");


    // }
    public function gg()
    {
        // echo "1";
        $act = $this->input->get("act");

        if ($act == "penandatangan") {
            // Kode untuk aksi 'penandatangan'
            // echo "2";
        } elseif ($act == "satker") {
            // echo "3";
            // $query = $this->db->get("SATKER")->order_by("SATKER_ID", "ASC");
            // $result = $query->result_array();


            // Query untuk mendapatkan data jabatan riwayat
            $query = $this->db->query("select * from satker order by SATKER_ID asc");

            // Mengambil data dari objek CI_DB_mysqli_result dan mengubahnya menjadi array
            $result = $query->result_array();



            // echo "4";
            $hasil = array();
            foreach ($result as $data) {
                $data["NAMA"] = str_replace('`', "", $data["NAMA"]);
                $data["NAMA"] = str_replace('"', "", $data["NAMA"]);
                $data["NAMA"] = str_replace("'", "", $data["NAMA"]);
                $data["NAMA"] = str_replace("-", "", $data["NAMA"]);
                // echo "5";
                $hasil[] = array(
                    "SATKER_ID" => $data["SATKER_ID"],
                    "NAMA" => $data["NAMA"]
                );
                // echo "6";
            }
            // echo "7";

            echo json_encode($hasil);
        }
    }

    public function satker_ekgb()
    {
        //Aktifkan CORS di Server Penerima: Pastikan server yang menerima permintaan memiliki header CORS yang tepat. Header CORS yang umum adalah Access-Control-Allow-Origin.
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: text/plain; charset=UTF-8');

        $query = $this->db->select('*')
            ->from('SATKER')
            ->where("SATKER_ID <> '97' AND SATKER_ID <> '98' AND SATKER_ID <> '99'")
            ->order_by('SATKER_ID', 'ASC')
            ->get();

        $result = array();
        $parent1 = "";
        $parent2 = "";
        $parent3 = "";
        $parent4 = "";
        $key1 = 0;
        $key2 = 0;
        $key3 = 0;
        $key4 = 0;
        $key1Temp = "";
        $key2Temp = "";
        $key3Temp = "";
        $key4Temp = "";

        $result[0]['title'] = "PEMERINTAH KAB. PROBOLINGGO";

        foreach ($query->result_array() as $row1) {
            $parent1 = substr($row1['SATKER_ID'], 0, 2);

            if ($key1Temp != $parent1) {
                $key1Temp = $parent1;
                $key1++;
                $key2 = 0;
                $key3 = 0;
                $key4 = 0;
            }

            if (strlen($row1['SATKER_ID']) == 4) {
                $parent2 = substr($row1['SATKER_ID'], 0, 4);

                if ($key2Temp != $parent2) {
                    $key2Temp = $parent2;
                    $key2++;
                    $key3 = 0;
                    $key4 = 0;
                }
            }

            if (strlen($row1['SATKER_ID']) == 6) {
                $parent3 = substr($row1['SATKER_ID'], 0, 6);

                if ($key3Temp != $parent3) {
                    $key3Temp = $parent3;
                    $key3++;
                    $key4 = 0;
                }
            }

            if (strlen($row1['SATKER_ID']) == 8) {
                $parent4 = substr($row1['SATKER_ID'], 0, 8);

                if ($key4Temp != $parent4) {
                    $key4Temp = $parent4;
                    $key4++;
                }
            }

            if (strlen($row1['SATKER_ID']) == 2) {
                $result[$key1]['key'] = $row1['SATKER_ID'];
                $result[$key1]['title'] = $row1['NAMA'];
            }

            if (strlen($row1['SATKER_ID']) == 4) {
                $result[$key1]['folder'] = true;
                $result[$key1]['children'][($key2 - 1)]['key'] = $row1['SATKER_ID'];
                $result[$key1]['children'][($key2 - 1)]['title'] = $row1['NAMA'];
            }

            if (strlen($row1['SATKER_ID']) == 6) {
                $result[$key1]['children'][($key2 - 1)]['folder'] = true;
                $result[$key1]['children'][($key2 - 1)]['children'][($key3 - 1)]['key'] = $row1['SATKER_ID'];
                $result[$key1]['children'][($key2 - 1)]['children'][($key3 - 1)]['title'] = $row1['NAMA'];
            }

            if (strlen($row1['SATKER_ID']) == 8) {
                $result[$key1]['children'][($key2 - 1)]['children'][($key3 - 1)]['folder'] = true;
                $result[$key1]['children'][($key2 - 1)]['children'][($key3 - 1)]['children'][($key4 - 1)]['key'] = $row1['SATKER_ID'];
                $result[$key1]['children'][($key2 - 1)]['children'][($key3 - 1)]['children'][($key4 - 1)]['title'] = $row1['NAMA'];
            }
        }

        echo json_encode($result);
    }

    public function pegawai_ekgb()
    {
        //Aktifkan CORS di Server Penerima: Pastikan server yang menerima permintaan memiliki header CORS yang tepat. Header CORS yang umum adalah Access-Control-Allow-Origin.
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: text/plain; charset=UTF-8');
        $perpage = 10;
        $page = 1;
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $awal = ($page - 1) * $perpage;
        $akhir = $page * $perpage;

        $satker = $this->input->get('satker') ? $this->input->get('satker') : '';
        if ($satker == "*") {
            $satker = '';
        }

        $filter = $this->input->get('filter') ? $this->input->get('filter') : 'NIP_BARU';
        $keyword = $this->input->get('keyword') ? $this->input->get('keyword') : '';

        $this->db->like('SATKER_ID', $satker)
            ->like($filter, $keyword)
            ->where('PEGAWAI_ID IS NOT NULL')
            ->order_by('PEGAWAI_ID', 'ASC')
            ->limit($perpage, $awal);

        // $query = $this->db->get('PEGAWAI');
        // $result = $query->result_array();

        $sql = "SELECT * FROM (SELECT *, ROW_NUMBER() OVER() AS RNUM FROM (SELECT * FROM PEGAWAI WHERE SATKER_ID LIKE '%$satker%' AND $filter LIKE '%$keyword%' AND PEGAWAI_ID IS NOT NULL ORDER BY PEGAWAI_ID ASC) a) b WHERE RNUM BETWEEN $awal AND $akhir";
        $query = $this->db->query($sql);

        $result = $query->result_array();

        foreach ($result as &$row) {
            $id = $row['PEGAWAI_ID'];

            $query2 = $this->db->query("SELECT j.TMT_PANGKAT, p.KODE
            FROM pangkat_riwayat AS j
            JOIN (
                SELECT PEGAWAI_ID, MAX(TMT_PANGKAT) AS latest_tmt_pangkat
                FROM pangkat_riwayat
                GROUP BY PEGAWAI_ID
            ) AS latest ON j.PEGAWAI_ID = latest.PEGAWAI_ID AND j.TMT_PANGKAT = latest.latest_tmt_pangkat
            LEFT JOIN pangkat AS p on j.PANGKAT_ID = p.PANGKAT_ID
            where j.PEGAWAI_ID = '" . $id . "'
            ORDER BY j.TMT_PANGKAT DESC limit 1");

            $row2 = $query2->row_array();
            $golongan = $row2['KODE'];
            $tmt_pangkat = $row2['TMT_PANGKAT'];
            $row['PANGKAT'] = $golongan;
            $row['TMT_PANGKAT'] = $tmt_pangkat;


            $query3 = $this->db->query("SELECT j.NAMA, e.NAMA as eselon
            FROM jabatan_riwayat AS j
            JOIN (
                SELECT PEGAWAI_ID, MAX(TMT_JABATAN) AS latest_tmt_jabatan
                FROM jabatan_riwayat
                GROUP BY PEGAWAI_ID
            ) AS latest ON j.PEGAWAI_ID = latest.PEGAWAI_ID AND j.TMT_JABATAN = latest.latest_tmt_jabatan
                        left join eselon as e on j.ESELON_ID = e.ESELON_ID
            where j.PEGAWAI_ID = '" . $id . "'
            ORDER BY j.TMT_JABATAN DESC limit 1");

            $row3 = $query3->row_array();
            if (empty($row3['NAMA'])) {
                $jabatan = " - ";
            } else {
                $jabatan = $row3['NAMA'];
            }
            $row['NAMA_JABATAN'] = $jabatan;

            if (empty($row3['ESELON'])) {
                $eselon = " - ";
            } else {
                $eselon = $row3['ESELON'];
            }
            $row['ESELON'] = $eselon;

            $query5 = $this->db->QUERY("SELECT j.TMT_SK, J.NO_SK, J.TANGGAL_SK, J.MASA_KERJA_TAHUN, J.MASA_KERJA_BULAN, J.PEJABAT_PENETAP, J.GAJI_POKOK
            FROM gaji_riwayat AS j
            JOIN (
                SELECT PEGAWAI_ID, MAX(TMT_SK) AS latest_tmt_gaji
                FROM gaji_riwayat
                GROUP BY PEGAWAI_ID
            ) AS latest ON j.PEGAWAI_ID = latest.PEGAWAI_ID AND j.TMT_SK = latest.latest_tmt_gaji
            where j.PEGAWAI_ID = '" . $id . "'
            ORDER BY j.TMT_Sk DESC limit 1");
            $row5 = $query5->row_array();
            $tmt_sk = $row5['TMT_SK'];
            $sk_gaji = $row5['NO_SK'];
            $tgl_sk = $row5['TANGGAL_SK'];
            $masa_kerja_th = $row5['MASA_KERJA_TAHUN'];
            $masa_kerja_bl = $row5['MASA_KERJA_BULAN'];
            if (empty($row5['PEJABAT_PENETAP'])) {
                $penetap = "-";
            } else {
                $penetap = $row5['PEJABAT_PENETAP'];
            }
            if (empty($row5['GAJI_POKOK'])) {
                $gaji_pokok = "-";
            } else {
                $gaji_pokok = $row5['GAJI_POKOK'];
            }
            $row['GAJI'] = $gaji_pokok;
            $row['PEJABAT_PENETAP'] = $penetap;
            $row['TMT_GAJI'] = $tmt_sk;
            $row['SK_GAJI'] = $sk_gaji;
            $row['TGL_SK_GAJI'] = $tgl_sk;
            $row['MASA_KERJA'] = $masa_kerja_th . "-" . $masa_kerja_bl;

            $row['FOTO_BLOB'] = ['descriptor' => null];
            $row['FOTO_BLOB_OTHER'] = ['descriptor' => null];
            $row['DOSIR_KARPEG'] = ['descriptor' => null];
            $row['DOSIR_ASKES'] = ['descriptor' => null];
            $row['DOSIR_TASPEN'] = ['descriptor' => null];
            $row['DOSIR_NPWP'] = ['descriptor' => null];
        }

        $total_query = $this->db->select('COUNT(*) as total')
            ->from('PEGAWAI')
            ->like('SATKER_ID', $satker)
            ->like($filter, $keyword)
            ->where('PEGAWAI_ID IS NOT NULL')
            ->get();
        $rowz = $total_query->row_array();
        $total = $rowz['total'];

        $json['data'] = $result;
        $json['pagetotal'] = ceil($total / $perpage);
        $json['pageposition'] = $page;
        echo json_encode($json);
    }

    public function get_pendidikan_riwayat()
    {

        header("Content-type: application/json");

        $pegawai_id = $this->input->get('PEGAWAI_ID');

        $where_pegawai_id = "";

        if (!empty($pegawai_id)) {
            $pegawai_id = str_replace(' ', '', $pegawai_id);
            $where_pegawai_id = " where p.PEGAWAI_ID = '" . $pegawai_id . "'";
        }

        $sql = "SELECT 
            p.PENDIDIKAN_RIWAYAT_ID, 
            p.PEGAWAI_ID, 
            p.PENDIDIKAN_ID, 
            p1.NAMA as PENDIDIKAN, 
            p.JURUSAN_PENDIDIKAN_ID, 
            p.JURUSAN,
            p.NAMA, 
            p.TEMPAT, 
            p.KEPALA, 
            p.NO_STTB, 
            DATE_FORMAT(p.TANGGAL_STTB, '%Y-%m-%d') as TANGGAL_STTB,
            p.FLAG_DATA_TERAKHIR,
            p.RW_PENDIDIKAN_SAPK,
            p.RW_JURUSAN_SAPK
        FROM PENDIDIKAN_RIWAYAT p
        LEFT JOIN PENDIDIKAN p1 ON p.PENDIDIKAN_ID = p1.PENDIDIKAN_ID
        " . $where_pegawai_id . "
        ORDER BY p.PEGAWAI_ID, p.TANGGAL_STTB DESC, p.PENDIDIKAN_ID DESC";

        $query = $this->db->query($sql);
        $results = $query->result_array();

        echo json_encode($results);
    }

    public function v_sk_cpns_pns()
    {

        header("Content-type: application/json");

        $sql = "SELECT 
        p.PEGAWAI_ID, 
        p.NIP_BARU, 
        p.NAMA, 
        
        sc.NO_SK as NO_SK_CPNS, 
        DATE_FORMAT(sc.TMT_CPNS, '%Y-%m-%d') as TMT_CPNS,
        
        sp.NO_SK as NO_SK_PNS, 
        DATE_FORMAT(sp.TMT_PNS, '%Y-%m-%d') as TMT_PNS
        
    FROM PEGAWAI p
    LEFT JOIN SK_CPNS sc ON p.PEGAWAI_ID = sc.PEGAWAI_ID
    LEFT JOIN SK_PNS sp ON p.PEGAWAI_ID = sp.PEGAWAI_ID
    WHERE p.STATUS_PEGAWAI = '1' OR p.STATUS_PEGAWAI = '2'";

        $query = $this->db->query($sql);
        $results = $query->result_array();

        echo json_encode($results);
    }


    public function getRiwayatJFT_angkaKredit()
    {

        header("Content-type: application/json");

        $pegawai_id = $this->input->get('PEGAWAI_ID');

        $sql = "select 

        j.JABATAN_RIWAYAT_ID as RwJabatanId,
        j.idPns as PnsId,
        j.NAMA as NamaJabatan,
        j.TMT_JABATAN,
        j.PEGAWAI_ID
        
        from jabatan_riwayat as j 
        where j.PEGAWAI_ID = '" . $pegawai_id . "' 
        and j.JENIS_JABATAN_SAPK = '2'
        order by j.TMT_JABATAN desc;";

        $query = $this->db->query($sql);
        $results = $query->result_array();

        echo json_encode($results);
    }

    public function post_tpp()
    {
        $data = [
            'pegawai_id'            => '2357599042386',
            'nip_baru'              => '200111242023022001',
            'nama'                  => 'VANESSA MARA NATALIA SITORUS, A.Md.Pnl.',
            'status_pegawai'        => "CPNS",
            'struktural_fungsional' => 'FUNGSIONAL UMUM',
            'kd_opd'                => '426.203',
            'kd_opd_induk'          => '426.203',
            'kd_jabatan'            => '1892'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://tpp.probolinggokab.go.id/api/pegawai-perubahan");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'Accept: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZjc2ODgwODE2OTJiNmQ5NWM4NjliN2Y0YzkyMmQxNTMxNWIyNDBkZjc5Yjc4YTA4ZjE4OGNkYzY0OTkwYTBjODcyODY2MDA4YmI3NzcyNTIiLCJpYXQiOjE2ODY3MjgzODYuMTU1MDM4MTE4MzYyNDI2NzU3ODEyNSwibmJmIjoxNjg2NzI4Mzg2LjE1NTA0MDk3OTM4NTM3NTk3NjU2MjUsImV4cCI6MzI2NDY1MTU4Ni4wOTY3NzA3NjMzOTcyMTY3OTY4NzUsInN1YiI6IjE4Iiwic2NvcGVzIjpbXX0.V1kf-KM8XTOAlRujkCAN72FB3aFpeuNk3-ca6Kzv_y-1TN31_zMX6BzjwYOSF91y0Xj22pCIbCHU5sMCOpi-CQGbSshrMWqQI7vs99J2_UM_-m-WpU05dES28vZVNYXmhSAd85L5PyEnOccKi1nbsV8PkVJNnnUm5P3tWzTVza8rnTcZypslYV2l4hnJSV2BJOumYFkg4Mnu1i3iZYxuyRI1eyqSIgkVoGiw2piY3_RsrH0aV0ao1ffZKE8W6WFKtxQGiyHaCC_g4sN3GseXyqTnosa0r5JCFwgiO_083sH3UyG-NaPkLdfLAB4WSetR66rRMxrYaHq4SWAEer5_uh81kWiRqmkndb_UF9MQJgJa2YxXeJQ5FhbX0KqwkF7qCcqWiGBaL0dNcrjzD-xVA3IIOw642SbhT2tYLn3wenQcxAZ6EEaqCEs1zbkZELaenKrflXqOksIOG4E8PkcULTmegWyYPZ2mwbUsek4PF4Gr3E0N5WKDuSC-Z7BGH9SpnJB1meCb4r8vjyl7NzNfyKwRy2SRSvXCRQFPcfBJBNTTAKS6O5udqZcxsvEizJ6KBtGNFv7sklw0_pVCPMaUdps6S1vv9Lz6mbTnkES4ibzv89rKAv41lvrvB2vPHfp3eu9B8fgOEc9BVrs6aG044CE3Ue6_-JN1Icf3U14xCV0',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            die('Couldn\'t send request: ' . curl_error($ch));
        } else {
            $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($resultStatus == 200) {
                $data = json_decode($result);
            } else {
                die('Request failed: HTTP status code: ' . $resultStatus);
            }
        }
        curl_close($ch);
        // return response()->json($data);
    }



    public function sinkron_kgb_siaplama()
    {

        header("Content-type: application/json");

        $pegawai_id = $this->input->get('id_terakhir');

        $sql = "select * from gaji_riwayat as g where g.GAJI_RIWAYAT_ID > " . $pegawai_id;

        $query = $this->db->query($sql);
        $results = $query->result_array();

        echo json_encode($results);
    }

    public function update_data_terakhir2()
    {

        $this->db->query('update perubahan_data as p set p.VALIDASI = "1" , p.VALIDATOR = "Super Admin" where p.VALIDASI != "1"');

        $tanggal_sekarang = date("Y-m-d H:i:s");
        echo $tanggal_sekarang . "   \n";
        $this->db->query('update pegawai as p
        left join satker as s
        on p.SATKER_ID = s.SATKER_ID
        set p.SATKER_INDUK_ID = s.SATKER_INDUK_ID
        where p.SATKER_INDUK_ID = 0 and p.STATUS_PEGAWAI in (1,2,10,11,12,13)');


        //====================================================
        // jabatan
        //===================================================
        $query = $this->db->query('SELECT PEGAWAI_ID, STATUS_PEGAWAI FROM pegawai WHERE JABATAN_ID_TERAKHIR = 0 and STATUS_PEGAWAI in (1,2,10)');

        $result = $query->result(); // atau $query->result_array() untuk mendapatkan hasil sebagai array

        foreach ($result as $row) {
            $pegawai_id = $row->PEGAWAI_ID; // Jika menggunakan result()

            echo "jabatan : " . $pegawai_id . " - " . $row->STATUS_PEGAWAI . "\n";
            // atau
            // $pegawai_id = $row['PEGAWAI_ID']; // Jika menggunakan result_array()

            // Query 3: Update JABATAN_ID_TERAKHIR in table pegawai
            $this->db->query('update jabatan_riwayat as j set j.FLAG_DATA_TERAKHIR = 0 where j.PEGAWAI_ID = ' . $pegawai_id . '');

            $this->db->query('UPDATE jabatan_riwayat AS j
        	SET j.flag_data_terakhir = 1,
        		j.eselon_id = IF(j.jenis_jabatan_sapk in (2,4), NULL, j.eselon_id),
        		j.jabatan_fungsional_id = IF(j.jenis_jabatan_sapk in (2,4), NULL, j.jabatan_fungsional_id),
        		j.jfu_id_sapk = IF(j.jenis_jabatan_sapk = 2, NULL, j.jfu_id_sapk),
        		j.jfu_nama_sapk = IF(j.jenis_jabatan_sapk = 2, NULL, j.jfu_nama_sapk),
        		j.jft_id_sapk = IF(j.jenis_jabatan_sapk = 4, NULL, j.jft_id_sapk),
        		j.jft_nama_sapk = IF(j.jenis_jabatan_sapk = 4, NULL, j.jft_nama_sapk)
        	WHERE j.PEGAWAI_ID = ' . $pegawai_id . '
        	ORDER BY j.TMT_JABATAN DESC, j.TANGGAL_SK DESC
        	LIMIT 1');

            $this->db->query('update pegawai as p
        	left join jabatan_riwayat as j 
        	on p.PEGAWAI_ID = j.PEGAWAI_ID
        	set j.idPns = p.ID_SAPK, j.nipBaru = p.NIP_BARU
        	where p.PEGAWAI_ID = ' . $pegawai_id . '');

            $this->db->query("update pegawai as p left join jabatan_riwayat as j on p.PEGAWAI_ID = j.PEGAWAI_ID
            set p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID where j.FLAG_DATA_TERAKHIR = '1' and p.PEGAWAI_ID = '" . $pegawai_id . "'");
        }


        //====================================================
        // pangkat
        //===================================================
        $query = $this->db->query('SELECT PEGAWAI_ID, STATUS_PEGAWAI  FROM pegawai WHERE STATUS_PEGAWAI in (1,2,10) and (PANGKAT_ID_TERAKHIR is null or  PANGKAT_ID_TERAKHIR = 0)');

        $result = $query->result(); // atau $query->result_array() untuk mendapatkan hasil sebagai array

        foreach ($result as $row) {
            $pegawai_id = $row->PEGAWAI_ID; // Jika menggunakan result()

            echo "pangkat : " . $pegawai_id . " - " . $row->STATUS_PEGAWAI . "\n";
            // atau
            // $pegawai_id = $row['PEGAWAI_ID']; // Jika menggunakan result_array()
            $this->setDataTerakhirpangkat($pegawai_id);

            $this->db->query('UPDATE pegawai p
            JOIN (
                SELECT pangkat_riwayat_id, PEGAWAI_ID
                FROM pangkat_riwayat
                WHERE FLAG_DATA_TERAKHIR = 1 AND PEGAWAI_ID = ' . $pegawai_id . '
            ) AS j ON p.pegawai_id = j.PEGAWAI_ID
            SET p.PANGKAT_ID_TERAKHIR = j.pangkat_riwayat_id');
        }

        //====================================================
        // pendidikan
        //===================================================
        // $query = $this->db->query('SELECT PEGAWAI_ID FROM pegawai WHERE PENDIDIKAN_ID_TERAKHIR = 0 and STATUS_PEGAWAI in (1,2,10,11,12,13)');
        $query = $this->db->query('SELECT PEGAWAI_ID , STATUS_PEGAWAI FROM pegawai WHERE STATUS_PEGAWAI in (1,2,10) and (PENDIDIKAN_ID_TERAKHIR is null or  PENDIDIKAN_ID_TERAKHIR = 0) order by RAND()');

        $result = $query->result(); // atau $query->result_array() untuk mendapatkan hasil sebagai array

        foreach ($result as $row) {
            $pegawai_id = $row->PEGAWAI_ID; // Jika menggunakan result()

            echo "pendidikan : " . $pegawai_id . " - " . $row->STATUS_PEGAWAI . "\n";
            $this->setDataTerakhirPendidikan($pegawai_id);
            // atau
            // $pegawai_id = $row['PEGAWAI_ID']; // Jika menggunakan result_array()
            $this->db->query('UPDATE pegawai p
            JOIN (
                SELECT PENDIDIKAN_RIWAYAT_ID, PEGAWAI_ID
                FROM pendidikan_riwayat
                WHERE FLAG_DATA_TERAKHIR = 1 AND PEGAWAI_ID = ' . $pegawai_id . '
            ) AS j ON p.pegawai_id = j.PEGAWAI_ID
            SET p.PENDIDIKAN_ID_TERAKHIR = j.PENDIDIKAN_RIWAYAT_ID');
        }
        $this->db->query('update jabatan_riwayat as j set j.ESELON_ID = null where j.JENIS_JABATAN_SAPK != "1" and j.ESELON_ID = "0"');
    }


    function createFolders()
    {
        // $baseFolder = "base_folder/"; // Ganti dengan lokasi base folder Anda

        $baseFolder = 'dokumen';
        // $nipFolder = $baseFolder . '/' . $nip;

        // Loop dari 1 sampai 3312
        for ($i = 1; $i <= 3312; $i++) {
            // Format nomor folder dengan leading zeros
            $folderNumber = str_pad($i, 4, "0", STR_PAD_LEFT);
            $folderName = $baseFolder . '/' . $folderNumber;

            // Cek apakah folder sudah ada
            if (!file_exists($folderName)) {
                // Jika folder belum ada, maka buat folder baru
                if (mkdir($folderName, 0777, true)) {
                    echo "Folder $folderName berhasil dibuat.<br>";
                } else {
                    echo "Gagal membuat folder $folderName.<br>";
                }
            } else {
                // Jika folder sudah ada, lewati saja
                echo "Folder $folderName sudah ada. Lewati.<br>";
            }
        }
    }
    function auto_validasi()
    {
        // update perubahan_data as p set p.VALIDASI = '1' , p.VALIDATOR = 'Super Admin' where p.VALIDASI != '1';
        $this->db->query('update perubahan_data as p set p.VALIDASI = "1" , p.VALIDATOR = "Super Admin" where p.VALIDASI != "1"');
    }



    //jadi disini saya ingin melakukan u[date data pegawai per nip
    public function update_jabatan_ke_siasn()
    {

        // $ArrayNip = isset($_GET['ArrayNip']) ? $_GET['ArrayNip'] : null;
        $ArrayNip = isset($_POST['ArrayNip']) ? $_POST['ArrayNip'] : null;
        //select p.JABATAN_ID_TERAKHIR from pegawai as p where p.NIP_BARU in ('199306302019031003');

        echo $ArrayNip;
        $query = $this->db->query("select p.JABATAN_ID_TERAKHIR from pegawai as p where p.NIP_BARU in (" . $ArrayNip . ")");
        $result = $query->result();
        $jabatanArray = array();
        foreach ($result as $row) {
            $jabatanArray[] = $row->JABATAN_ID_TERAKHIR;
            echo $row->JABATAN_ID_TERAKHIR . "  " . "\n";
            $this->post_jabatan_Siasn($row->JABATAN_ID_TERAKHIR);
        }
        return $jabatanArray;
    }


    public function post_jabatan_Siasn($jabatanRiwayatId)
    {
        // // Query 1: Set flag_data_terakhir = 0
        // $this->db->query("update jabatan_riwayat as j 
        // left join satker as s
        // on j.SATKER_ID = s.SATKER_ID
        // set j.UNOR_ID_SAPK = s.SATKER_ID_SAPK
        // where j.JABATAN_RIWAYAT_ID = " . $jabatanRiwayatId);

        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');
        // $this->api_mws_token = $this->webservice_model->getApiMwsToken();
        // $this->sso_token = $this->webservice_model->getSsoToken();

        $query = $this->db->query("select j.ESELON_ID, j.NO_SK, DATE_FORMAT(j.TANGGAL_SK, '%d-%m-%Y') AS TANGGAL_SK, DATE_FORMAT(j.TMT_JABATAN, '%d-%m-%Y') AS TMT_JABATAN, DATE_FORMAT(j.TANGGAL_PELANTIKAN, '%d-%m-%Y') AS TANGGAL_PELANTIKAN, j.JENIS_JABATAN_SAPK, j.INSTANSI_KERJA_ID_SAPK, j.SATUAN_KERJA_ID_SAPK, j.UNOR_ID_SAPK, j.JFT_ID_SAPK, j.JFU_ID_SAPK, j.idPns from jabatan_riwayat as j where j.JABATAN_RIWAYAT_ID = " . $jabatanRiwayatId);
        $row = $query->row();

        if ($row) {
            $eselonId = $row->ESELON_ID;
            if ($row->ESELON_ID == "0") {
                $eselonId = '';
                $this->db->query("update jabatan_riwayat as j 
		set j.ESELON_ID = NULL
		where j.JABATAN_RIWAYAT_ID = " . $jabatanRiwayatId);
            } else {
                $eselonId = $row->ESELON_ID;
            }

            $nomorSk = $row->NO_SK;
            if ($row->TANGGAL_SK == "00-00-0000") {
                $tanggalSk = '';
            } else {
                $tanggalSk = $row->TANGGAL_SK;
            }

            if ($row->TMT_JABATAN == "00-00-0000") {
                $tmtJabatan = '';
            } else {
                $tmtJabatan = $row->TMT_JABATAN;
            }

            if ($row->TANGGAL_PELANTIKAN == "00-00-0000") {
                $tmtPelantikan = '';
            } else {
                $tmtPelantikan = $row->TANGGAL_PELANTIKAN;
            }
            $jenisJabatan = $row->JENIS_JABATAN_SAPK;
            $instansiId = $row->INSTANSI_KERJA_ID_SAPK;
            $satuanKerjaId = $row->SATUAN_KERJA_ID_SAPK;
            $unorId = $row->UNOR_ID_SAPK;
            $jabatanFungsionalId = $row->JFT_ID_SAPK;
            $jabatanFungsionalUmumId = $row->JFU_ID_SAPK;
            $pnsId = $row->idPns;

            // Lakukan operasi dengan variabel-variabel ini sesuai kebutuhan Anda
        } else {
            // Handle ketika data tidak ditemukan
        }
        // echo($this->sso_token);
        // echo($this->api_mws_token);
        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";

        $webservice_bkn = new Webservice_bkn();
        $webservice_bkn->post_jabatan_2('bearer ' . $sso_token, 'Bearer ' . $this->api_mws_token, $eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, "", "");
        // print_r($webservice_bkn);
        // echo $webservice_bkn['message'];
        // echo("Done");
        // $this->db->query("update jabatan_riwayat as j 
        // set j.keterangansingkron = '" . $webservice_bkn->message . "'
        // where j.JABATAN_RIWAYAT_ID = " . $jabatanRiwayatId);
    }


    public function update_pangkat_ke_siasn()
    {

        // $ArrayNip = isset($_GET['ArrayNip']) ? $_GET['ArrayNip'] : null;
        // $ArrayNip = isset($_POST['ArrayNip']) ? $_POST['ArrayNip'] : null;
        //select p.JABATAN_ID_TERAKHIR from pegawai as p where p.NIP_BARU in ('199306302019031003');

        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');
        // echo $ArrayNip;

        // $query = $this->db->query("SELECT pegawai.PEGAWAI_ID, pegawai.NIP_BARU
        // FROM pegawai
        // JOIN pegawai_singkronasi ON pegawai.pegawai_id = pegawai_singkronasi.pegawai_id
        // WHERE pegawai.STATUS_PEGAWAI in ('1', '2') and (pegawai_singkronasi.tgl_update_golongan IS NULL OR DATE_FORMAT(pegawai_singkronasi.tgl_update_golongan, '%Y-%m-%d') = CURDATE())");

        $ArrayNip = "'198409102009031002','198406112019032008','199603182019032006','197011032002122005','197805072002122002','198412272019032004','198602012020122006','196708072007012018','198701142010011005','197505032008011018','197510042008012015','196705112002121004','198011152008012012','198606052019032005','199408172020122025','198608032011011009','196802152006041008','197310132008011005','196808082002121008','197711122006042025','196906282010012001','196711282012122001','198703012019032001','196712152008012008','197908242006041015','196810052003121004','197506092008011011','197207022003121005','197205052010011001','197912052002122007','197101252007012012','198505102020122005','199303062020122014','196807262007011012','197503042008011009','198206192009031003','197904142007011014','196806122007011059','197107092007012011','197902272008011009','196512232002122002','198110112010011002','197003251999111001','197712092006042012','199305302019032009','197408042009031001','197104042010011001','197710142010011001','198306242010011003','199303082019031003','198205192002122002','198404072010012002','198702132019031002','197706092010012008','196803152007011041','198811032020122008','198510052020121005','197904252009031001','197811142006042027','199301022020122016','197709122002122008','197112152008011010','198506282010011002','196811282003121004','198507172010012027','197408012006042021','197103212008012009','198809212011011004','196509282006042002','197204202010011003','197909032011012005','198710202019032003','198908202020122012','197203152010011006','198505072019032003','196510082007012021','196510272006042004','198602282009031001','197506212006041013','197904212002121008','197804102000101001','197802022007012014','198602232008011001','196902012007011050','197605252003121006','197007022007011014','197408052008012012','198207122000101001','198509092020122006','196711242002122001','197111212000072001','198304102009031002','197101312000121003','197308012003121007','196608212006042007','196608252000111001','197911172009031001','199502122019031002','199212122020121012','197402171997031001','197801202008012017','198310252011012008','196803072006041008','196907212006041008','196905262008011004','197107232003121004','197211262009031001','197507172007012017','196711142007011020','197505152003121009','198003242010011002','196707032010011001','197801272010011003','196806252007011016','196708172007011042','197203142007011013','199401092020122015','196812232003121002','196802012007012034','196705112007011020','196706292006041008','198707042020121010','196803102009031001','196706122007012034','197108112007011018','198112222008012012','197207012000112001','197211052007011011','197210032000071001','196705132007011017','196708272007011011','198408212003122001','197806022009031001','196801112007011017','197409172003122006','197607172010011002','197603232010011012','198309212011012012','197702122008012020','197401022007011006','196705132007011016','196809072003121002','196710172009031001','196803042010011001','197503152009031001','198111072010011007','196907062008011022','197705132008012008','198507252010011002','197510282007011010','198412232020122004','196808182003121003','197004022016011001','196912292009032001','199710062020121006','198202202016012001','196708052000101002','197705262008011011','197907012006041018','197106142000101001','197510052009031001','198310252010012010','199303242020121011','196809082008012017','197507312009032001','196903012006042008','198706132010011004','197704082010011002','198303242009032001','197101032008012012','197502022008011010','198710172020121005','197001012007012051','198604072011011009','199212112019031001','198509202010012027','197607042010012001','198712262020121007','198310272019032003','196703072006041005','198403032019032006','196811182007011015','198612112020121002','198508092009031001','199312152019031002','197011222000112001','196901222007011015','197205122002121010','197209241996051001','198911062019031004','199507142019031007','198601302019031001','198611062019032002','197811122010011002','198303042003121004','198805102020122014','198706022020122007','199210142020122013','196907112008012018','198809072020121005','197001112007012012','197508032002121002','198307302006042011','196910212000121002','197010072007012019','198804142019032002','199503312020122018','198202242006041007','196604092008012009','198411192009042001','198309232019032001','196908141994031012','198403292019032003','197802022003122006','198808142020122009','196907282003121004','199102012019032007','198609252019032002','199408082020121011','198603122020122010','198607292010011005','198606122019031004','198704052019031002','199011212020122008','197103272007011014','198107022009031001','197802142002121004','196702112006041004','196809102006041009','198608292019031003','196609041991042002','198411072009031002','197011071993081002','197109271998021002','197009291999111001','197002271993041001','197102241998022004','196806161993082002','197801062003121005','197809281999111001','197904042010011009','197911072003122006','197607241999112002','196804251998022005','197910172000121001','197608022011012004','197512022008012013','197208241993081001','196509072000072001','197303302002121009','197103171994101002','197206281996051001','196612311986021011','196602121991041003','198503192011011013','197005262000032001','196602261990032004','197204231993082001','197103301994031003','197010071997032011','196710201992021001','196607211999111001','197810051999111001','197311302000032004','196611051993072002','198204252009031003','196808161994032012','198207032009031002','197503082010011008','198006082009032003','196805011994031006','197707162008012017','196806302000031005','197611282006042015','197202071994032003','197303271999031005','197104191998022001','196810111993041001','196707011991031006','196802161998021003','196911161991042001','196601111999031002','197106051993042001','196511131998021003','196603011989032007','196906101997032005','197106071997022002','197111041997032005','197302151993022002','196706241999032004','197612202000122002','196602271999031002','196912311994032019','196812231998022001','197103261997022001','196602191987031006','196707201995122001','197007141998022003','196601101996011001','196806031995012001','197308041996052001','196605311987031002','197001261998021002','196701251993082001','196606091987031008','196801141997032005','196509101987032009','197003231993021002','196702051993082002','196810041994022002','196708031998021003','197109011993042001','197202171993042001','196703051987022002','197006281997021002','196708231991042001','196608071987032018','196807041996021002','197212051997022005'";
        $query = $this->db->query("select p.PEGAWAI_ID, p.NIP_BARU from pegawai as p where p.NIP_BARU in (" . $ArrayNip . ")");

        $result = $query->result();
        $jabatanArray = array();
        foreach ($result as $row) {
            $jabatanArray[] = $row->PEGAWAI_ID;
            echo $row->PEGAWAI_ID . " - " . $row->NIP_BARU . " -> ";
            // exit();
            // echo "coba1";
            // try {
            // echo "coba2";

            $webservice_bkn = new Webservice_bkn();
            $webservice_bkn->SingkronGolonganBknBasic($row->PEGAWAI_ID);
            echo "Success! \n";
            // $this->db->query("UPDATE pegawai_singkronasi
            // SET tgl_update_golongan = CURDATE()
            // WHERE pegawai_id = '" . $row->PEGAWAI_ID . "'");
            $this->setDataTerakhirpangkat($row->PEGAWAI_ID);
            // } catch (Exception $e) {
            //     echo "Failed: " . $e->getMessage();
            // }
        }
        // return $jabatanArray;
    }




    public function push_skp22()
    {

        // Fungsi untuk memvalidasi dan memformat tanggal
        function validateAndFormatDate($date_input)
        {
            try {
                // Coba membuat objek DateTime dari input pengguna
                $date = new DateTime($date_input);
                // Kembalikan tanggal dalam format MySQL
                return $date->format('Y-m-d H:i:s');
            } catch (Exception $e) {
                // Jika terjadi kesalahan, kembalikan nilai null atau pesan error
                return null; // Atau bisa mengganti dengan handling error lainnya
            }
        }

        $pegawai_id = function ($nip_baru) {
            try {
                $where_nip = $this->input->post('nip_baru');
                $query = $this->db->query("SELECT PEGAWAI_ID FROM pegawai WHERE nip_baru = ?", array($where_nip));
                if ($query->num_rows() > 0) {
                    return $query->row()->PEGAWAI_ID;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }
        };

        $pnsDinilaiId = function ($nip_baru) {
            try {
                $where_nip = $this->input->post('nip_baru');
                $query = $this->db->query("SELECT ID_SAPK FROM pegawai WHERE nip_baru = ?", array($where_nip));
                if ($query->num_rows() > 0) {
                    return $query->row()->ID_SAPK;
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }
        };

        $nip_baru = $this->input->post('nip_baru');
        $pegawai_id = $pegawai_id($nip_baru);
        $pnsDinilaiId = $pnsDinilaiId($nip_baru);

        $data = array(
            'pegawai_id' => $pegawai_id,
            'hasilKinerja' => $this->input->post('hasilKinerja'),
            'hasilKinerjaNilai' => $this->input->post('hasilKinerjaNilai'),
            'kuadranKinerja' => $this->input->post('kuadranKinerja'),
            'KuadranKinerjaNilai' => $this->input->post('KuadranKinerjaNilai'),
            'namaPenilai' => $this->input->post('namaPenilai'),
            'nipNrpPenilai' => $this->input->post('nipNrpPenilai'),
            'penilaiGolonganId' => $this->input->post('penilaiGolonganId'),
            'penilaiJabatanNm' => $this->input->post('penilaiJabatanNm'),
            'penilaiUnorNm' => $this->input->post('penilaiUnorNm'),
            'perilakuKerja' => $this->input->post('perilakuKerja'),
            'PerilakuKerjaNilai' => $this->input->post('PerilakuKerjaNilai'),
            // 'pnsDinilaiId' => $this->input->post('pnsDinilaiId'),
            'pnsDinilaiId' => $pnsDinilaiId,
            'nip_baru' => $nip_baru,
            'statusPenilai' => $this->input->post('statusPenilai'),
            'tahun' => $this->input->post('tahun'),
            'bulan' => $this->input->post('bulan'),
            'tipe' => $this->input->post('tipe'),
            'update_date' => validateAndFormatDate($this->input->post('update_date')),
            'insert_date' => date('Y-m-d H:i:s'),
            'FILE_PDF' => $this->input->post('FILE_PDF'),
            // 'LAST_UPDATE_USER' => $this->input->post('LAST_UPDATE_USER'),
            'LAST_UPDATE_USER' => "Inserted By Estamina",
            'LAST_UPDATE_DATE' => validateAndFormatDate($this->input->post('LAST_UPDATE_DATE'))
        );

        $this->db->insert('skp22', $data);

        if ($this->db->affected_rows() > 0) {
            echo "Insert data sukses.";
        } else {
            echo "Insert data gagal.";
        }
    }

    public function show_skp22()
    {
        // Get filter inputs
        $nip = $this->input->get('nip');
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $tipe = $this->input->get('tipe');

        // Initialize query
        $this->db->select('*');
        $this->db->from('skp22');

        // Add filters to query if they are provided
        if (!empty($nip)) {
            $this->db->where('nip_baru', $nip);
        }
        if (!empty($tahun)) {
            $this->db->where('tahun', $tahun);
        }
        if (!empty($bulan)) {
            $this->db->where('bulan', $bulan);
        }
        if (!empty($tipe)) {
            $this->db->where('tipe', $tipe);
        }

        // Execute query
        $query = $this->db->get();

        // Check if any results were found
        if ($query->num_rows() > 0) {
            // Return results as an array
            $data = $query->result_array();
            echo json_encode($data); // Output as JSON
        } else {
            // No results found
            echo json_encode([]);
        }
    }

    public function delete_skp22()
    {
        // Get filter inputs
        $nip = $this->input->post('nip');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $tipe = $this->input->post('tipe');

        // Initialize delete query
        $this->db->where('nip_baru', $nip);
        $this->db->where('tahun', $tahun);
        $this->db->where('bulan', $bulan);
        $this->db->where('tipe', $tipe);

        // Execute delete query
        $this->db->delete('skp22');

        // Check if any rows were affected (deleted)
        if ($this->db->affected_rows() > 0) {
            // Deletion was successful
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully.']);
        } else {
            // No rows were deleted (possibly because no matching records were found)
            echo json_encode(['status' => 'error', 'message' => 'No matching data found or deletion failed.']);
        }
    }

    public function post_skp_to_Siasn()
    {
        // $skpid = '13991';
        // $skpid = isset($_POST['skpid']) ? $_POST['skpid'] : null;

        // lengkapi data pnsDinilaiId
        $this->db->query("update skp22 as s 
        join pegawai as p 
        on s.pegawai_id = p.pegawai_id
        set s.pnsDinilaiId = p.ID_SAPK
        where s.pnsDinilaiId is null or s.pnsDinilaiId =''");

        // lengkapi data penilaiGolonganId
        $this->db->query("update skp22 as s
        join pegawai as p on s.nipNrpPenilai = p.NIP_BARU
        join pangkat_riwayat as pr on p.PANGKAT_ID_TERAKHIR = pr.PANGKAT_RIWAYAT_ID
        set s.penilaiGolonganId = pr.PANGKAT_ID
        where s.penilaiGolonganId is null or s.penilaiGolonganId =''");

        // $query = $this->db->query("select hasilKinerjaNilai, KuadranKinerjaNilai, namaPenilai, nipNrpPenilai, penilaiGolonganId, penilaiJabatanNm, penilaiUnorNm, PerilakuKerjaNilai, pnsDinilaiId, statusPenilai, tahun from skp22 where skp22_id = " . $skpid);
        $query = $this->db->query("select s.skp22_id, s.pegawai_id, s.hasilKinerjaNilai, s.KuadranKinerjaNilai, s.namaPenilai, s.nipNrpPenilai, s.penilaiGolonganId, s.penilaiJabatanNm, s.penilaiUnorNm, s.PerilakuKerjaNilai, s.pnsDinilaiId, s.statusPenilai, s.tahun from skp22 as s 
        join pegawai as p on s.pegawai_id = p.PEGAWAI_ID
        where p.STATUS_PEGAWAI in ('1', '2', '10') 
        and (s.message is null or s.message = 'Proses Singkron Dengan SIASN') order by s.message desc, s.skp22_id, s.tahun desc");

        // $row = $query->row();
        $rows = $query->result();

        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');

        foreach ($rows as $row) {

            $sql = "UPDATE skp22 SET message = 'Proses Singkron Dengan SIASN' WHERE skp22_id = ?";
            $this->db->query($sql, array($row->skp22_id));
            // echo "Hasil Kinerja Nilai: " . $row->hasilKinerjaNilai . "<br>";
            // echo "Kuadran Kinerja Nilai: " . $row->KuadranKinerjaNilai . "<br>";
            // echo "Nama Penilai: " . $row->namaPenilai . "<br>";
            // echo "NIP/NRP Penilai: " . $row->nipNrpPenilai . "<br>";
            // echo "Golongan Penilai: " . $row->penilaiGolonganId . "<br>";
            // echo "Jabatan Penilai: " . $row->penilaiJabatanNm . "<br>";
            // echo "Unor Penilai: " . $row->penilaiUnorNm . "<br>";
            // echo "Perilaku Kerja Nilai: " . $row->PerilakuKerjaNilai . "<br>";
            // echo "PNS Dinilai ID: " . $row->pnsDinilaiId . "<br>";
            // echo "Status Penilai: " . $row->statusPenilai . "<br>";
            // echo "Tahun: " . $row->tahun . "<br>";
            // echo "<hr>";

            $id = $row->id;
            $hasilKinerjaNilai = $row->hasilKinerjaNilai;
            $kuadranKinerjaNilai = $row->KuadranKinerjaNilai;
            $penilaiNama = $row->namaPenilai;
            $penilaiNipNrp = $row->nipNrpPenilai;
            $penilaiGolongan = $row->penilaiGolonganId;
            $penilaiJabatan = $row->penilaiJabatanNm;
            $penilaiUnorNama = $row->penilaiUnorNm;
            $perilakuKerjaNilai = $row->PerilakuKerjaNilai; //ini yang dirubah untuk menentukan diatas, sesuai dan dibawah ekspetasi
            $pnsDinilaiOrang = $row->pnsDinilaiId;
            $statusPenilai = $row->statusPenilai;
            $tahun = $row->tahun;

            $webservice_bkn = new Webservice_bkn();
            $response = $webservice_bkn->post_skp22('bearer ' . $this->sso_token, 'Bearer ' . $this->api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, "", "");

            $responseArray = json_decode($response, true);

            // Periksa apakah decoding berhasil dan "message" ada dalam array
            if (isset($responseArray['message'])) {
                $success = $responseArray['success'];
                $mapData = $responseArray['mapData'];
                $message = $responseArray['message'];

                // Menghapus karakter tab dan karakter yang mungkin menyebabkan masalah
                $message_clean = str_replace(array("\t", "\n", "\r"), '', $message);
                $message_clean = addslashes($message_clean);

                echo "pegawai_id : " . $row->pegawai_id . "<br>skp22_id :" . $row->skp22_id . "<br>Message: " . $message_clean . "<br> time : " . date("Y-m-d H:i:s");

                if ($message_clean == "success") {
                    $sql = "UPDATE skp22 SET id = ?, keterangan = 'Singkron Dengan SIASN', message = ? WHERE skp22_id = ?";
                    $this->db->query($sql, array($mapData, $message_clean, $row->skp22_id));
                } else {
                    $sql = "UPDATE skp22 SET id = ?, message = ? WHERE skp22_id = ?";
                    $this->db->query($sql, array($mapData, $message_clean, $row->skp22_id));
                }

                echo "<hr>";
            } else {
                echo "Message not found in response.";
                echo "<hr>";
            }
            // exit();
        }
    }


    public function post_arrayskp_to_Siasn()
    {
        $arrayskpid = isset($_POST['arrayskpid']) ? $_POST['arrayskpid'] : null;



        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');

        if (is_array($arrayskpid) && !empty($arrayskpid)) {
            // Loop melalui setiap elemen dalam arrayskpid
            foreach ($arrayskpid as $skpid) {
                // Lakukan sesuatu dengan setiap $id
                echo "SKP ID: " . htmlspecialchars($id) . "<br>";
                exit();

                $query = $this->db->query("select hasilKinerjaNilai, KuadranKinerjaNilai, namaPenilai, nipNrpPenilai, penilaiGolonganId, penilaiJabatanNm, penilaiUnorNm, PerilakuKerjaNilai, pnsDinilaiId, statusPenilai, tahun from skp22 where skp22_id = " . $skpid);
                $row = $query->row();


                // $id = $row->id;

                $id = "";
                $hasilKinerjaNilai = $row->hasilKinerjaNilai;
                $kuadranKinerjaNilai = $row->KuadranKinerjaNilai;
                $penilaiNama = $row->namaPenilai;
                $penilaiNipNrp = $row->nipNrpPenilai;
                $penilaiGolongan = $row->penilaiGolonganId;
                $penilaiJabatan = $row->penilaiJabatanNm;
                $penilaiUnorNama = $row->penilaiUnorNm;
                $perilakuKerjaNilai = $row->PerilakuKerjaNilai; //ini yang dirubah untuk menentukan diatas, sesuai dan dibawah ekspetasi
                $pnsDinilaiOrang = $row->pnsDinilaiId;
                $statusPenilai = $row->statusPenilai;
                $tahun = $row->tahun;

                $webservice_bkn = new Webservice_bkn();
                $response = $webservice_bkn->post_skp22('bearer ' . $this->sso_token, 'Bearer ' . $this->api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, "", "");

                $responseArray = json_decode($response, true);

                // Periksa apakah decoding berhasil dan "message" ada dalam array
                if (isset($responseArray['message'])) {
                    $success = $responseArray['success'];
                    $mapData = $responseArray['mapData'];
                    $message = $responseArray['message'];
                    echo "Message: " . $message;
                    $this->db->query("update skp22 as s set s.id = '" . $mapData . "', s.keterangan = 'Singkron Dengan SIASN' where s.skp22_id = '" . $skpid . "'");
                } else {
                    echo "Message not found in response.";
                }
                // exit();
            }
        } else {
            echo "No SKP IDs received or arrayskpid is not an array.";
        }
    }


    public function post_kursus_to_Siasn()
    {
        // $skpid = '13991';
        // $skpid = isset($_POST['skpid']) ? $_POST['skpid'] : null;

        // lengkapi data pnsDinilaiId
        // $this->db->query("update skp22 as s 
        // join pegawai as p 
        // on s.pegawai_id = p.pegawai_id
        // set s.pnsDinilaiId = p.ID_SAPK
        // where s.pnsDinilaiId is null or s.pnsDinilaiId =''");

        // // lengkapi data penilaiGolonganId
        // $this->db->query("update skp22 as s
        // join pegawai as p on s.nipNrpPenilai = p.NIP_BARU
        // join pangkat_riwayat as pr on p.PANGKAT_ID_TERAKHIR = pr.PANGKAT_RIWAYAT_ID
        // set s.penilaiGolonganId = pr.PANGKAT_ID
        // where s.penilaiGolonganId is null or s.penilaiGolonganId =''");

        // $query = $this->db->query("select hasilKinerjaNilai, KuadranKinerjaNilai, namaPenilai, nipNrpPenilai, penilaiGolonganId, penilaiJabatanNm, penilaiUnorNm, PerilakuKerjaNilai, pnsDinilaiId, statusPenilai, tahun from skp22 where skp22_id = " . $skpid);
        $query = $this->db->query("select * from kursus as k where 
		k.id_siasn is null 
		and PEGAWAI_ID is not null 
		and k.TEMPAT is not null 
		and k.PENYELENGGARA is not null 
		and k.TANGGAL_SELESAI is not null 
		and k.TANGGAL_MULAI is not null 
		and k.NO_PIAGAM is not null 
		and k.TANGGAL_PIAGAM is not null 
		and k.NAMA is not null 
		and k.jumlahJam is not null 
		and k.jenisDiklatId is not null 
		and k.jenisKursus is not null 
		and k.jenisKursusSertipikat is not null 
		and k.tahunKursus is not null 
		and k.instansiId is not null 
		and k.lokasiId is not null 
		and k.pnsOrangId is not null 
		order by k.KURSUS_ID desc");

        // $row = $query->row();
        $rows = $query->result();

        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');

        foreach ($rows as $row) {

            $sql = "UPDATE kursus SET message = 'Proses Singkron Dengan SIASN' WHERE kursus_id = ?";
            $this->db->query($sql, array($row->KURSUS_ID));
            // echo "Hasil Kinerja Nilai: " . $row->hasilKinerjaNilai . "<br>";
            // echo "Kuadran Kinerja Nilai: " . $row->KuadranKinerjaNilai . "<br>";
            // echo "Nama Penilai: " . $row->namaPenilai . "<br>";
            // echo "NIP/NRP Penilai: " . $row->nipNrpPenilai . "<br>";
            // echo "Golongan Penilai: " . $row->penilaiGolonganId . "<br>";
            // echo "Jabatan Penilai: " . $row->penilaiJabatanNm . "<br>";
            // echo "Unor Penilai: " . $row->penilaiUnorNm . "<br>";
            // echo "Perilaku Kerja Nilai: " . $row->PerilakuKerjaNilai . "<br>";
            // echo "PNS Dinilai ID: " . $row->pnsDinilaiId . "<br>";
            // echo "Status Penilai: " . $row->statusPenilai . "<br>";
            // echo "Tahun: " . $row->tahun . "<br>";
            // echo "<hr>";

            if ($row->id_siasn == null) {
                $id = 'null';
            } else {
                $id = '"' . $row->id_siasn . '"';
            }

            $kursus_id = $row->KURSUS_ID;
            $pegawai_id = $row->PEGAWAI_ID;
            // exit();
            $instansiId = $row->instansiId;
            $institusiPenyelenggara = $row->PENYELENGGARA;
            $jenisDiklatId = $row->jenisDiklatId;
            $jenisKursus = $row->jenisKursus;
            $jenisKursusSertipikat = $row->jenisKursusSertipikat;
            $jumlahJam = $row->jumlahJam;
            $lokasiId = $row->lokasiId;
            $namaKursus = $row->NAMA;
            $nomorSertipikat = $row->NO_PIAGAM;
            $pnsOrangId = $row->pnsOrangId;
            $tahunKursus = $row->tahunKursus;
            $tanggalKursus = $row->TANGGAL_MULAI;
            $tanggalSelesaiKursus = $row->TANGGAL_SELESAI;


            $webservice_bkn = new Webservice_bkn();
            // $response = $webservice_bkn->post_skp22('bearer ' . $this->sso_token, 'Bearer ' . $this->api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, "", "");

            $response = $webservice_bkn->post_kursus_basic('bearer ' . $this->sso_token, 'Bearer ' . $this->api_mws_token, $id, $instansiId, $institusiPenyelenggara, $jenisDiklatId, $jenisKursus, $jenisKursusSertipikat, $jumlahJam, $lokasiId, $namaKursus, $nomorSertipikat, $pnsOrangId, $tahunKursus, $tanggalKursus, $tanggalSelesaiKursus);

            $responseArray = json_decode($response, true);

            // Periksa apakah decoding berhasil dan "message" ada dalam array
            if (isset($responseArray['message'])) {
                $success = $responseArray['success'];
                $mapData = $responseArray['mapData']['rwKursusId'];
                $message = $responseArray['message'];

                // Menghapus karakter tab dan karakter yang mungkin menyebabkan masalah
                $message_clean = str_replace(array("\t", "\n", "\r"), '', $message);
                $message_clean = addslashes($message_clean);

                echo "pegawai_id : " . $pegawai_id . "<br>kursus_id :" . $kursus_id . "<br>Message: " . $message_clean . "<br> time : " . date("Y-m-d H:i:s");

                if ($message_clean == "success") {

                    $sql = "UPDATE kursus SET id_siasn = ?, keterangan = 'Singkron Dengan SIASN', message = ? WHERE kursus_id = ?";
                    $this->db->query($sql, array($mapData, $message_clean, $kursus_id));
                } else {
                    $sql = "UPDATE kursus SET id_siasn = ?, message = ? WHERE kursus_id = ?";
                    $this->db->query($sql, array($mapData, $message_clean, $kursus_id));
                }

                echo "<hr>";
            } else {
                echo "Message not found in response.";
                echo "<hr>";
            }
            // exit();
        }
    }


    public function post_penghargaan_to_Siasn()
    {


        $this->db->query("UPDATE penghargaan AS p1 
        join pegawai as p2 on p1.pegawai_id = p2.pegawai_id
        set p1.PNSORANGID = p2.ID_SAPK
        where p1.PNSORANGID is null and p2.ID_SAPK is not null");


        $query = $this->db->query("select * from penghargaan as p 
        where p.hargaid is not null 
        and (p.message is null or p.message = 'Proses Singkron Dengan SIASN')
        order by p.penghargaan_id desc");

        // $row = $query->row();
        $rows = $query->result();

        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');

        foreach ($rows as $row) {

            $sql = "UPDATE penghargaan SET message = 'Proses Singkron Dengan SIASN' WHERE penghargaan_id = ?";
            $this->db->query($sql, array($row->PENGHARGAAN_ID));


            $dateawal = $row->TANGGAL_SK;

            // Membuat objek DateTime dari tanggal asli
            $date = new DateTime($dateawal);

            // Mengubah format tanggal menjadi dd-mm-yyyy
            $skDate = $date->format('d-m-Y');


            echo "hargaId : " . $row->HARGAID . "<br>";
            echo "pegawai_id : " . $row->PEGAWAI_ID . "<br>";
            // echo "id : " . $row->id . "<br>";
            echo "nama penghargaan : " . $row->NAMA . "<br>";
            echo "pnsOrangId : " . $row->PNSORANGID . "<br>";
            echo "skDate : " . $skDate . "<br>";
            echo "skNomor : " . $row->NO_SK . "<br>";
            echo "tahun : " . $row->TAHUN . "<br>";
            // exit();

            // echo "<hr>";

            if ($row->id_siasn == null) {
                $id = 'null';
            } else {
                $id = '"' . $row->id_siasn . '"';
            }

            $penghargaan_id = $row->PENGHARGAAN_ID;
            $pegawai_id = $row->PEGAWAI_ID;


            $hargaId = $row->HARGAID;
            // $id = $row->id;
            $pnsOrangId = $row->PNSORANGID;
            $skNomor = $row->NO_SK;
            $tahun = $row->TAHUN;



            $webservice_bkn = new Webservice_bkn();
            // $response = $webservice_bkn->post_skp22('bearer ' . $this->sso_token, 'Bearer ' . $this->api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, "", "");

            $response = $webservice_bkn->post_penghargaan('bearer ' . $this->sso_token, 'Bearer ' . $this->api_mws_token, $hargaId, $id, $pnsOrangId, $skDate, $skNomor, $tahun);

            $responseArray = json_decode($response, true);

            // Periksa apakah decoding berhasil dan "message" ada dalam array
            if (isset($responseArray['message'])) {
                $success = $responseArray['success'];
                $mapData = $responseArray['mapData']['rwPenghargaanId'];
                $message = $responseArray['message'];

                // print_r($responseArray);

                // echo  $mapData;
                // exit();

                // Menghapus karakter tab dan karakter yang mungkin menyebabkan masalah
                $message_clean = str_replace(array("\t", "\n", "\r"), '', $message);
                $message_clean = addslashes($message_clean);

                echo "pegawai_id : " . $pegawai_id . "<br>penghargaan_id :" . $penghargaan_id . "<br>Message: " . $message_clean . "<br> time : " . date("Y-m-d H:i:s");

                if ($message_clean == "success") {

                    $sql = "UPDATE penghargaan SET id_siasn = ?, keterangan = 'Singkron Dengan SIASN', message = ? WHERE penghargaan_id = ?";
                    $this->db->query($sql, array($mapData, $message_clean, $penghargaan_id));
                } else {
                    $sql = "UPDATE penghargaan SET id_siasn = ?, message = ? WHERE penghargaan_id = ?";
                    $this->db->query($sql, array($mapData, $message_clean, $penghargaan_id));
                }

                echo "<hr>";
            } else {
                echo "Message not found in response.";
                echo "<hr>";
            }
            // exit();
        }
    }


    public function get_token()
    {

        require_once(APPPATH . 'controllers/webservice_bkn.php');
        $this->load->model('webservice_model');

        echo "api_mws_token : " . $this->webservice_model->getApiMwsToken();
        echo "\n\nsso_token : " . $this->webservice_model->getSsoToken();
    }


    // Fungsi untuk validasi API Key
    private function validateToken()
    {
        // Ambil API Key dari header
        // $api_key = $this->input->get_request_header('API-Key', TRUE);
        $api_key = isset($_SERVER['HTTP_API_KEY']) ? $_SERVER['HTTP_API_KEY'] : null;


        // Kunci rahasia (API Key) yang sah
        // $valid_key = 'your_secret_api_key'; // Ganti dengan API key rahasia
        $valid_key = 'D1nEd@17'; // Ganti dengan API key rahasia

        // Cek apakah API Key valid
        if ($api_key !== $valid_key) {
            // Jika API key tidak valid, return respons "Forbidden"
            $this->output
                ->set_status_header(403)
                ->set_output(json_encode(['status' => 'error', 'message' => 'Forbidden: Invalid API Key ']));
            return false; // Hentikan eksekusi jika token tidak valid
        }

        return true; // Token valid
    }

    // Contoh method lain yang menggunakan validasi token
    public function getDataToken()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Hentikan jika token tidak valid
        }

        // Lanjutkan jika token valid
        echo json_encode(['status' => 'success', 'data' => 'Data berhasil diambil']);
    }
    // Contoh method yang memanggil validasi token
    public function getcoba()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Jika token tidak valid, hentikan eksekusi
        }

        // Jika token valid, lanjutkan eksekusi method
        echo "coba";
    }

    public function getPegawaiDinasPendidikan()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Jika token tidak valid, hentikan eksekusi
        }
        // Ambil inputan NIP_BARU dari query string
        $nipBaru = $this->input->get('NIP_BARU');

        // Query untuk mengambil data pegawai
        $this->db->select('p.PEGAWAI_ID, p.NIP_BARU, p.NAMA, p.SATKER_ID, p.SATKER_INDUK_ID, 
                           s1.NAMA as SATKER, s2.NAMA as SATKER_INDUK, 
                           p.JABATAN_ID_TERAKHIR, j.NAMA as jabatan, 
                           p.PANGKAT_ID_TERAKHIR, pkt.KODE, 
                           PENDIDIKAN_ID_TERAKHIR');
        $this->db->from('pegawai as p');
        $this->db->join('jabatan_riwayat as j', 'p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID', 'left');
        $this->db->join('pangkat_riwayat as pa', 'pa.PANGKAT_RIWAYAT_ID = p.PANGKAT_ID_TERAKHIR', 'left');
        $this->db->join('pangkat as pkt', 'pa.PANGKAT_ID = pkt.PANGKAT_ID', 'left');
        $this->db->join('satker as s1', 'p.SATKER_ID = s1.SATKER_ID');
        $this->db->join('satker as s2', 'p.SATKER_INDUK_ID = s2.SATKER_ID');
        $this->db->where('p.SATKER_INDUK_ID', '03');
        $this->db->where_in('p.STATUS_PEGAWAI', ['1', '2', '10']);

        // Tambahkan kondisi untuk NIP_BARU jika ada inputan
        if (!empty($nipBaru)) {
            $this->db->where('p.NIP_BARU', $nipBaru);
        }

        $this->db->group_by('p.PEGAWAI_ID');

        $query = $this->db->get(); // Eksekusi query

        // Mengambil hasil sebagai array
        $result = $query->result_array();

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function getRiwayatPendidikanDinasPendidikan()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Jika token tidak valid, hentikan eksekusi
        }
        // Ambil inputan PEGAWAI_ID dari query string
        $pegawaiId = $this->input->get('PEGAWAI_ID');

        $sql = "select p.PENDIDIKAN_RIWAYAT_ID, p.PEGAWAI_ID, p.PENDIDIKAN_ID, pen.NAMA as JENJANG, p.JURUSAN_PENDIDIKAN_ID, p.TANGGAL_STTB, p.JURUSAN, CONCAT('https://siap-bkpsdm.probolinggokab.go.id/', p.FILE_PDF ) AS full_url from pendidikan_riwayat as p
join pendidikan as pen on p.PENDIDIKAN_ID = pen.PENDIDIKAN_ID
join pegawai as x on x.PEGAWAI_ID = p.PEGAWAI_ID
where x.SATKER_INDUK_ID = '03' and x.STATUS_PEGAWAI in (1, 2, 10)";

        // Tambahkan kondisi untuk NIP_BARU jika ada inputan
        if (!empty($pegawaiId)) {
            $sql = $sql . " and p.PEGAWAI_ID = '" . $pegawaiId . "' ";
        }
        $sql = $sql . " GROUP BY p.PENDIDIKAN_RIWAYAT_ID order by p.TANGGAL_STTB desc;";
        // $sql = "select p.PENDIDIKAN_RIWAYAT_ID, p.PEGAWAI_ID, p.PENDIDIKAN_ID, pen.NAMA as JENJANG, p.JURUSAN_PENDIDIKAN_ID, p.TANGGAL_STTB, p.JURUSAN, CONCAT('https://siap-bkpsdm.probolinggokab.go.id/', p.FILE_PDF ) AS full_url from pendidikan_riwayat as p join pendidikan as pen on p.PENDIDIKAN_ID = pen.PENDIDIKAN_ID where p.PEGAWAI_ID = '" . $pegawaiId . "' GROUP BY p.PENDIDIKAN_RIWAYAT_ID order by p.TANGGAL_STTB desc;";

        // Eksekusi query dengan parameter
        $query = $this->db->query($sql, array($pegawaiId));

        // Mengambil hasil sebagai array
        $result = $query->result_array();

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'data' => $result
        ]);
    }

    public function getRiwayatPangkatDinasPendidikan()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Jika token tidak valid, hentikan eksekusi
        }
        // Ambil inputan PEGAWAI_ID dari query string
        $pegawaiId = $this->input->get('PEGAWAI_ID');

        // Validasi input PEGAWAI_ID
        // if (empty($pegawaiId)) {
        //     // Mengembalikan respons error jika PEGAWAI_ID tidak diisi
        //     return $this->response([
        //         'status' => false,
        //         'message' => 'PEGAWAI_ID is required'
        //     ], 400); // Bad Request
        // }

        // Query untuk mengambil data riwayat pendidikan
        $sql = "select 
p.PANGKAT_RIWAYAT_ID, 
p.PEGAWAI_ID, 
p.PANGKAT_ID, 
pan.KODE as PANGKAT, 
p.TMT_PANGKAT,
p.NO_SK,
CONCAT('https://siap-bkpsdm.probolinggokab.go.id/', p.FILE_PDF ) AS full_url 
from pangkat_riwayat as p
join pangkat as pan on p.PANGKAT_ID = pan.PANGKAT_ID
join pegawai as x on x.PEGAWAI_ID = p.PEGAWAI_ID
where x.SATKER_INDUK_ID = '03' and x.STATUS_PEGAWAI in (1, 2, 10)";


        // Tambahkan kondisi untuk NIP_BARU jika ada inputan
        if (!empty($pegawaiId)) {
            $sql = $sql . " and p.PEGAWAI_ID = '" . $pegawaiId . "' ";
        }
        $sql = $sql . " GROUP BY p.PANGKAT_RIWAYAT_ID order by p.TMT_PANGKAT desc;";

        // Eksekusi query dengan parameter
        $query = $this->db->query($sql, array($pegawaiId));

        // Mengambil hasil sebagai array
        $result = $query->result_array();

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'data' => $result
        ]);
    }

    public function getRiwayatJabatanDinasPendidikan()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Jika token tidak valid, hentikan eksekusi
        }
        // Ambil inputan PEGAWAI_ID dari query string
        $pegawaiId = $this->input->get('PEGAWAI_ID');

        // Validasi input PEGAWAI_ID
        // if (empty($pegawaiId)) {
        //     // Mengembalikan respons error jika PEGAWAI_ID tidak diisi
        //     return $this->response([
        //         'status' => false,
        //         'message' => 'PEGAWAI_ID is required'
        //     ], 400); // Bad Request
        // }

        // Query untuk mengambil data riwayat pendidikan
        $sql = "select 
p.JABATAN_RIWAYAT_ID, 
p.PEGAWAI_ID, 
p.NAMA as JABATAN,  
p.TMT_JABATAN, 
p.NO_SK,
e.NAMA as ESELON,
p.jenisMutasiId,
p.namaUnor,
CONCAT('https://siap-bkpsdm.probolinggokab.go.id/', p.FILE_PDF ) AS full_url 
from jabatan_riwayat as p
left join eselon as e on p.ESELON_ID = e.ESELON_ID
join pegawai as x on x.PEGAWAI_ID = p.PEGAWAI_ID
where x.SATKER_INDUK_ID = '03' and x.STATUS_PEGAWAI in (1, 2, 10)";


        // Tambahkan kondisi untuk NIP_BARU jika ada inputan
        if (!empty($pegawaiId)) {
            $sql = $sql . " and p.PEGAWAI_ID = '" . $pegawaiId . "' ";
        }
        $sql = $sql . " GROUP BY p.JABATAN_RIWAYAT_ID order by p.TANGGAL_SK desc;";

        // Eksekusi query dengan parameter
        $query = $this->db->query($sql, array($pegawaiId));

        // Mengambil hasil sebagai array
        $result = $query->result_array();

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'data' => $result
        ]);
    }

    public function getRiwayatGajiDinasPendidikan()
    {
        // Panggil validasi token
        if (!$this->validateToken()) {
            return; // Jika token tidak valid, hentikan eksekusi
        }
        // Ambil inputan PEGAWAI_ID dari query string
        $pegawaiId = $this->input->get('PEGAWAI_ID');

        // Validasi input PEGAWAI_ID
        // if (empty($pegawaiId)) {
        //     // Mengembalikan respons error jika PEGAWAI_ID tidak diisi
        //     return $this->response([
        //         'status' => false,
        //         'message' => 'PEGAWAI_ID is required'
        //     ], 400); // Bad Request
        // }

        // Query untuk mengambil data riwayat pendidikan
        $sql = "select 
        p.GAJI_RIWAYAT_ID, 
        p.PEGAWAI_ID, 
        p.TANGGAL_SK, 
        p.NO_SK,
        p.TMT_SK, 
        p.MASA_KERJA_TAHUN, 
        p.MASA_KERJA_BULAN, 
        p.GAJI_POKOK,
        CONCAT('https://siap-bkpsdm.probolinggokab.go.id/', p.FILE_PDF ) AS full_url 
        from gaji_riwayat as p
        join pegawai as x on x.PEGAWAI_ID = p.PEGAWAI_ID
        where x.SATKER_INDUK_ID = '03' and x.STATUS_PEGAWAI in (1, 2, 10)";



        // Tambahkan kondisi untuk NIP_BARU jika ada inputan
        if (!empty($pegawaiId)) {
            $sql = $sql . " and p.PEGAWAI_ID = '" . $pegawaiId . "' ";
        }
        $sql = $sql . " GROUP BY p.GAJI_RIWAYAT_ID order by p.TMT_SK desc;";

        // Eksekusi query dengan parameter
        $query = $this->db->query($sql, array($pegawaiId));

        // Mengambil hasil sebagai array
        $result = $query->result_array();

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'data' => $result
        ]);
    }

    public function getPegawaiaktif()
    {
        // Panggil validasi token
        // if (!$this->validateToken()) {
        //     return; // Jika token tidak valid, hentikan eksekusi
        // }
        // Ambil inputan NIP_BARU dari query string
        $nipBaru = $this->input->get('NIP_BARU');

        // Query untuk mengambil data pegawai
        $this->db->select("
            p.PEGAWAI_ID, 
            p.NIP_BARU, 
            p.NAMA, 
            p.SATKER_ID, 
            p.SATKER_INDUK_ID,
            p.EMAIL,
            p.NO_HP,
            sp.NAMA as STATUS_PEGAWAI, 
            s1.NAMA AS SATKER, 
            s2.NAMA AS SATKER_INDUK, 
            j.NAMA as JABATAN, 
            j.JENIS_JABATAN_SAPK, 
            CASE 
                WHEN j.JENIS_JABATAN_SAPK = 2 THEN 'Jabatan Fungsional'
                WHEN j.JENIS_JABATAN_SAPK = 4 THEN 'Jabatan Pelaksana'
                WHEN j.JENIS_JABATAN_SAPK = 1 THEN 'Jabatan Struktural (Pejabat Eselon)'
                ELSE 'Lainnya'
            END AS JENIS_JABATAN,
            ps.KELAS_JABATAN, 
            pkt.KODE
        ", false); // Menandai SQL ini sebagai raw (tidak dimodifikasi oleh CodeIgniter)

        $this->db->from('pegawai AS p');
        $this->db->join('siasnpegawaiid AS ps', 'p.NIP_BARU = ps.nip', 'left');
        $this->db->join('jabatan_riwayat AS j', 'p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID', 'left');
        $this->db->join('status_pegawai AS sp', 'p.status_pegawai = sp.STATUS_PEGAWAI_ID', 'left');
        $this->db->join('pangkat_riwayat AS pa', 'pa.PANGKAT_RIWAYAT_ID = p.PANGKAT_ID_TERAKHIR', 'left');
        $this->db->join('pangkat AS pkt', 'pa.PANGKAT_ID = pkt.PANGKAT_ID', 'left');
        $this->db->join('satker AS s1', 'p.SATKER_ID = s1.SATKER_ID', 'inner');
        $this->db->join('satker AS s2', 'p.SATKER_INDUK_ID = s2.SATKER_ID', 'inner');
        $this->db->where_in('p.STATUS_PEGAWAI', ['2', '1']);



        // Tambahkan kondisi untuk NIP_BARU jika ada inputan
        if (!empty($nipBaru)) {
            $this->db->where('p.NIP_BARU', $nipBaru);
        }

        $this->db->group_by('p.PEGAWAI_ID');

        $query = $this->db->get(); // Eksekusi query

        // Mengambil hasil sebagai array
        $result = $query->result_array();
        $result = $this->utf8ize($result);

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');


        // echo json_encode($result);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        // $json = json_encode($result);



        // if ($json === false) {
        //     echo json_last_error_msg();
        //     exit;
        // }
        // echo $json;
    }

    private function utf8ize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->utf8ize($value);
            }
        } elseif (is_string($data)) {
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8, ISO-8859-1');
        }
        return $data;
    }


    public function get_cuti()
    {
        $query = $this->db->query("
        SELECT
            c.CUTI_ID,
            c.PEGAWAI_ID,
            p.NIP_BARU,
            p.NAMA,
            p.SATKER_ID,
            s.KODE_WILAYAH AS KD_OPD,
            s.NAMA AS SATUAN_KERJA,
            s.hirarki_nama AS SATUAN_KERJA_HIRARKI,
            c.JENIS_CUTI AS JENIS_CUTI_ID,
            CASE
                WHEN jenis_cuti = '1' THEN 'Cuti Tahunan' 
                WHEN jenis_cuti = '2' THEN 'Cuti Besar (Umroh / Haji)'
                WHEN jenis_cuti = '3' THEN 'Cuti Sakit' 
                WHEN jenis_cuti = '4' THEN 'Cuti Bersalin' 
                WHEN jenis_cuti = '5' THEN 'CLTN' 
                WHEN jenis_cuti = '6' THEN 'Perpanjang CLTN' 
                WHEN jenis_cuti = '7' THEN 'Cuti Menikah' 
                WHEN jenis_cuti = '8' THEN 'Cuti Alasan Penting' 
                ELSE 'Jenis Cuti Tidak Diketahui' 
            END AS nama_jenis_cuti,
            c.LAMA AS LAMA_CUTI,
            c.TANGGAL_MULAI AS TGL_MULAI,
            c.TANGGAL_SELESAI AS TGL_SELESAI,
            CASE
                WHEN CURDATE() BETWEEN c.TANGGAL_MULAI AND c.TANGGAL_SELESAI THEN 'Berjalan' 
                WHEN CURDATE() > c.TANGGAL_SELESAI THEN 'Sudah' 
                ELSE 'Belum Dimulai' 
            END AS STATUS_CUTI 
        FROM
            cuti AS c
        JOIN pegawai AS p ON c.PEGAWAI_ID = p.PEGAWAI_ID
        JOIN satker AS s ON p.SATKER_ID = s.SATKER_ID
    ");

        // Output JSON
        echo json_encode($query->result_array());
    }

    public function get_data_utama2()
    {
        // Tambahkan header untuk mengizinkan CORS
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        //        $pegawai_id = '2357599046760';

        // echo "0";
        // $nip_baru = $this->input->get('nip_baru'); // saya ingin ini otomatis spasi hilang
        // $email = $this->input->get('email'); // berikan pengecekan bahwa  wajib ada karakter @
        // $noHp = $this->input->get('noHp'); // berikan pengencekan kalau harus full angka lalau hilangkan spasinya

        // Ambil input dari GET dan bersihkan
        $nip_baru = str_replace(' ', '', $this->input->get('nip_baru', true)); // Hapus spasi
        $email = trim($this->input->get('email', true)); // Trim spasi depan & belakang
        $noHp = preg_replace('/\D/', '', $this->input->get('noHp', true)); // Hanya angka

        // Validasi email harus mengandung '@'
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 400,
                    'message' => 'Email tidak valid, harus mengandung karakter @'
                ]));
            return;
        }

        // Validasi nomor HP harus angka
        if (!ctype_digit($noHp)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 400,
                    'message' => 'Nomor HP harus hanya berisi angka'
                ]));
            return;
        }



        // $nip_baru = '199306302019031003';
        // $email = 'sentanu00@gmail.com';
        // $noHp = '085334104691';

        // echo $this->$sso_token;

        // echo "1";

        $this->load->model('apimodel');

        $api_mws_token = $this->apimodel->getApiMwsToken();
        // echo "api_mws_token : " . $api_mws_token; //tetap generate seperti biasa

        $sso_token = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA"; //ini tetap
        // echo "sso_token : " . $sso_token;

        $data_utama = $this->apimodel->get_data_utama($sso_token, $api_mws_token, $nip_baru);

        // print_r($data_utama);

        if ($data_utama === false || empty($data_utama)) {

            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 500,
                    'message' => 'Error API BKN 1'
                ]));
            return;
        }

        $data = json_decode($data_utama, true);
        // print_r($data);

        //echo $data;
        //        $sapk_id = $data['data']['id'];

        // echo "2 code : " . $data['code'] . " ";
        if ($data['code'] != 1) {
            // $this->output
            //     ->set_status_header(400)
            //     ->set_content_type('application/json')
            //     ->set_output(json_encode([
            //         'status' => 400,
            //         'message' => 'NIP tidak ditemukan'
            //     ]));
            // print_r($data);
            return; // Hentikan eksekusi
        }
        $id = $data['data']['id'];
        $agamaId = $data['data']['agamaId'];
        $alamat = $data['data']['alamat'];
        $emailGov = $data['data']['emailGov'];
        $karis_karsu = $data['data']['karis_karsu'];
        $kelas_jabatan = $data['data']['kelas_jabatan'];
        $lokasiKerjaId = $data['data']['lokasiKerjaId'];
        $bpjs = $data['data']['bpjs'];
        $noTelp = $data['data']['noTelp'];
        $noNpwp = $data['data']['noNpwp'];
        $tglNpwp = $data['data']['tglNpwp'];
        $noTaspen = $data['data']['noTaspen'];
        $tanggal_taspen = $data['data']['tanggal_taspen'];
        if ($data['data']['email'] == $email) {

            // echo "7";
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'code' => '1',
                    'message' => 'email sama, NIP : ' . $nip_baru . ' email : ' . $email
                ]));
            return; // Hentikan eksekusi
        }

        // echo "3";

        $data_utama_update = $this->apimodel->data_utama_update($sso_token, $api_mws_token, $email, $noHp, $id, $agamaId, $alamat, $emailGov, $karis_karsu, $kelas_jabatan, $lokasiKerjaId, $bpjs, $noHp, $noNpwp, $tglNpwp, $noTaspen, $tanggal_taspen);
        // print_r($data_utama_update);

        if ($data_utama_update === false || empty($data_utama_update)) {

            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 500,
                    'message' => 'Error API BKN 2'
                ]));
            return;
        }

        $hasil_update = json_decode($data_utama_update, true);
        // $success_update = $hasil_update['message'];

        $data_utama_cek_email_masuk = $this->apimodel->get_data_utama($sso_token, $api_mws_token, $nip_baru);

        $data_utama_cek_email_masuk = json_decode($data_utama_cek_email_masuk, true);

        if ($data_utama_cek_email_masuk === false || empty($data_utama_cek_email_masuk)) {

            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 500,
                    'message' => 'Error API BKN 3'
                ]));
            return;
        }


        // echo "4";
        if ($hasil_update['message'] != "Data Utama berhasil di update") {

            // echo "5";
            // print_r($data);
            // exit();
            if ($data_utama_cek_email_masuk['data']['email'] == $email) {
                $code = '1';
                $message = 'gagal update, NIP : ' . $nip_baru . ' namun email yg diajukan sama dengan yang d BKN : ' . $data_utama_cek_email_masuk['data']['email'];
            } else {
                $code = '0';
                $message = 'gagal update, NIP : ' . $nip_baru . ' dan email yang terdaftar di BKN : ' . $data_utama_cek_email_masuk['data']['email'];
            }
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'code' => $code,
                    'message' => $message
                ]));
            return;
        } else {

            // echo "6";

            if ($data_utama_cek_email_masuk['data']['email'] == $email) {

                // echo "7";
                $this->db->query("update pegawai as p set p.EMAIL = '" . $email . "', p.NO_HP = '" . $noHp . "' where p.NIP_BARU = '" . $nip_baru . "'");
                $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'code' => '1',
                        'message' => 'data terupdate NIP : ' . $nip_baru . ' , email baru : ' . $email . '. Lakukan lupa passord 3-4 jam dari sekarang.'
                    ]));
                return; // Hentikan eksekusi
            }
        }
    }


    public function set_data_terakhri_tabel_pegawai()
    {

        // Query SELECT
        $query1 = $this->db->query("
        UPDATE pegawai AS p
        LEFT JOIN pendidikan_riwayat AS pen ON p.PEGAWAI_ID = pen.PEGAWAI_ID AND pen.FLAG_DATA_TERAKHIR = '1'
        LEFT JOIN jabatan_riwayat AS jab ON p.PEGAWAI_ID = jab.PEGAWAI_ID AND jab.FLAG_DATA_TERAKHIR = '1'
        LEFT JOIN pangkat_riwayat AS pang ON p.PEGAWAI_ID = pang.PEGAWAI_ID AND pang.FLAG_DATA_TERAKHIR = '1'
        LEFT JOIN satker AS s ON p.SATKER_ID = s.SATKER_ID
        INNER JOIN (
            SELECT PEGAWAI_ID
            FROM (
                SELECT p1.PEGAWAI_ID
                FROM pegawai AS p1
                WHERE p1.STATUS_PEGAWAI IN ('1', '2', '10')
                AND (
                    p1.PANGKAT_ID_TERAKHIR IS NULL OR p1.PANGKAT_ID_TERAKHIR = '' OR
                    p1.JABATAN_ID_TERAKHIR IS NULL OR p1.JABATAN_ID_TERAKHIR = '' OR
                    p1.PENDIDIKAN_ID_TERAKHIR IS NULL OR p1.PENDIDIKAN_ID_TERAKHIR = '' OR
                    p1.SATKER_INDUK_ID IS NULL OR p1.SATKER_INDUK_ID = ''
                )
            ) AS filtered_ids
        ) AS valid ON p.PEGAWAI_ID = valid.PEGAWAI_ID
        SET 
        p.JABATAN_ID_TERAKHIR = jab.JABATAN_RIWAYAT_ID,
        p.PENDIDIKAN_ID_TERAKHIR = pen.PENDIDIKAN_RIWAYAT_ID,
        p.PANGKAT_ID_TERAKHIR = pang.PANGKAT_RIWAYAT_ID,
        p.SATKER_INDUK_ID = s.SATKER_INDUK_ID
    ");

        // Query UPDATE
        $query2 = $this->db->query("
        UPDATE jabatan_riwayat AS p 
        SET p.ESELON_ID = NULL 
        WHERE p.ESELON_ID = '0'
    ");

        // Jalankan query UPDATE
        $query2 = $this->db->query("
    UPDATE perubahan_data AS p
    SET p.VALIDASI = '1',
        LAST_UPDATE_USER = 'Admin',
        LAST_UPDATE_DATE = NOW()
    WHERE p.VALIDASI = '0'
");

        if ($query2) {
            // Query sukses dijalankan, cek berapa baris yang berubah
            $affected_rows = $this->db->affected_rows();

            if ($affected_rows > 0) {
                echo "Update validasi berhasil, $affected_rows data diperbarui.";
            } else {
                echo "Query validasi berhasil, tapi tidak ada data yang berubah.";
            }
        } else {
            echo "Gagal menjalankan query validasi.";
        }

        echo date('Y-m-d H:i:s');
        // Cek hasil query1
        if (!$query1) {
            return [
                'status' => false,
                'message' => 'Query1 gagal dijalankan.',
                'error' => $this->db->error()
            ];
        }

        // Ambil hasil PEGAWAI_ID (jika ada)
        $result1 = $query1->result();
        if (empty($result1)) {
            return [
                'status' => true,
                'message' => 'Query berhasil dijalankan, tapi tidak ada data yang cocok.',
                'data' => []
            ];
        }

        // Jika semua berhasil dan ada hasil
        if ($query2) {
            return [
                'status' => true,
                'message' => 'Query berhasil. Data ditemukan dan update dilakukan.',
                'data' => $result1
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Query1 berhasil, tapi update (query2) gagal.',
                'error' => $this->db->error()
            ];
        }
    }


    public function test_koneksi_db()
    {
        // Ambil parameter dari URL GET
        $ip       = $this->input->get('ip', TRUE);        // contoh: 10.108.0.242
        $port     = $this->input->get('port', TRUE);      // contoh: 3306
        $user     = $this->input->get('user', TRUE);      // contoh: admindb
        $pass     = $this->input->get('pass', TRUE);      // contoh: admin_db123@123
        $dbname   = $this->input->get('db', TRUE);        // contoh: testdb (boleh kosong)

        // Isi default jika tidak ada input
        $ip     = empty($ip)     ? '127.0.0.1'     : $ip;
        $port   = empty($port)   ? '3306'          : $port;
        $user   = empty($user)   ? 'root'          : $user;
        $pass   = empty($pass)   ? ''              : $pass;
        $dbname = empty($dbname) ? ''              : $dbname;

        // Konfigurasi koneksi
        $config['hostname'] = $ip;
        $config['username'] = $user;
        $config['password'] = $pass;
        $config['database'] = $dbname;
        $config['port']     = $port;
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = FALSE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';
        $config['swap_pre'] = '';
        $config['encrypt']  = FALSE;
        $config['compress'] = FALSE;
        $config['stricton'] = FALSE;
        $config['failover'] = array();
        $config['save_queries'] = TRUE;

        try {
            $db = $this->load->database($config, TRUE);

            if ($db->initialize()) {
                echo "✅ Koneksi berhasil ke $ip:$port sebagai user '$user'" . ($dbname ? " ke database '$dbname'" : '') . ".";
            } else {
                echo "❌ Gagal koneksi ke $ip:$port.";
            }
        } catch (Exception $e) {
            echo "❌ Exception: " . $e->getMessage();
        }
    }
}
