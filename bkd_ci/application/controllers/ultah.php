<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ultah extends SB_Controller
{
    public function index()
    {
        $wh = "";
        $skrng = date('y-m-d');
        $wktuskrng = date('m', strtotime($skrng));

        // Group id
        $gid = $this->session->userdata('gid');
        if ($gid == 2 || $gid == 4) {
            $wh .= " AND SATKER_ID LIKE '" . $this->session->userdata('satker') . "%'";
            $wh2 .= " AND p.SATKER_ID LIKE '" . $this->session->userdata('satker') . "%'";
        }

        // Count total rows
        $sql = "SELECT COUNT(*) AS total
                FROM (
            SELECT 
                p.NIP_BARU, p.GELAR_DEPAN, p.NAMA, p.GELAR_BELAKANG, p.TANGGAL_LAHIR, p.SATKER_ID, s.NAMA as NAMA_SATKER,
                DAYOFMONTH(p.TANGGAL_LAHIR) AS BULAN_TGL_LAHIR,
                DAYOFYEAR(CONCAT(YEAR(CURDATE()), '-', MONTH(p.TANGGAL_LAHIR), '-', DAYOFMONTH(p.TANGGAL_LAHIR))) AS HARI_KEDEPAN
            FROM pegawai as p
            JOIN satker s on s.SATKER_ID = p.SATKER_ID 
            WHERE STATUS_PEGAWAI IN (1,2,10)
        ) AS pegawai_tanggal_lahir
        WHERE HARI_KEDEPAN BETWEEN DAYOFYEAR(CURDATE()) AND DAYOFYEAR(DATE_ADD(CURDATE(), INTERVAL 30 DAY))  $wh ORDER BY HARI_KEDEPAN, BULAN_TGL_LAHIR";
        $ax = $this->db->query($sql)->row()->total;

        // Pagination configuration
        // Get the current page number from the query string
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = base_url('index.php/ultah') . '?';
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $ax;
        $config['per_page'] = 15;
        $config['reuse_query_string'] = true;
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $limit = $config['per_page'];

        // Get the current page number from the query string
        $page = $this->input->get('page');

        // Calculate the offset for the query
        $offset = ($page - 1) * $config['per_page'];

        if ($offset <= 0) {
            $offset = 0;
        }
        // Fetch data for the current page    
        // $pgultah = "SELECT NIP_BARU, GELAR_DEPAN, p.NAMA, GELAR_BELAKANG, TANGGAL_LAHIR, p.SATKER_ID, s.NAMA as NAMA_SATKER
        // FROM pegawai as p
        // JOIN satker s on s.SATKER_ID = p.SATKER_ID 
        // WHERE STATUS_PEGAWAI IN (1,2,10,11,12,13) 
        // AND DATE_FORMAT(TANGGAL_LAHIR, '%m') = '$wktuskrng' $wh2
        // LIMIT $limit OFFSET $offset";

        $pgultah = "SELECT NIP_BARU, GELAR_DEPAN, NAMA, GELAR_BELAKANG, TANGGAL_LAHIR, SATKER_ID, NAMA_SATKER
        FROM (
            SELECT 
                p.NIP_BARU, p.GELAR_DEPAN, p.NAMA, p.GELAR_BELAKANG, p.TANGGAL_LAHIR, p.SATKER_ID, s.NAMA as NAMA_SATKER,
                DAYOFMONTH(p.TANGGAL_LAHIR) AS BULAN_TGL_LAHIR,
                DAYOFYEAR(CONCAT(YEAR(CURDATE()), '-', MONTH(p.TANGGAL_LAHIR), '-', DAYOFMONTH(p.TANGGAL_LAHIR))) AS HARI_KEDEPAN
            FROM pegawai as p
            JOIN satker s on s.SATKER_ID = p.SATKER_ID 
            WHERE STATUS_PEGAWAI IN (1,2,10)
        ) AS pegawai_tanggal_lahir
        WHERE HARI_KEDEPAN BETWEEN DAYOFYEAR(CURDATE()) AND DAYOFYEAR(DATE_ADD(CURDATE(), INTERVAL 30 DAY)) $wh2
        ORDER BY HARI_KEDEPAN, BULAN_TGL_LAHIR   LIMIT $limit OFFSET $offset";
        $pgres = $this->db->query($pgultah)->result();

        // Assign the data to the view
        $this->data['pgres'] = $pgres;
        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['ax'] = $ax;
        $this->data['limit'] = $limit;
        $this->data['page'] = $page;
        $this->data['current_page'] = $page ?: 1;
        $this->data['offset'] = $offset;

        $this->data['content'] = $this->load->view('ultah/index', $this->data, true);
        $this->load->view('layouts/main', $this->data);
    }
}
