<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Singkron_orcl extends SB_Controller
{


	public function coba()
	{
		echo "hayo lo orcl";
		return "hayo lo orcl";
	}

	function __construct()
	{
		parent::__construct();


		// Inisialisasi koneksi ke database Oracle
		$this->load->database('oracle');
		$this->db->initialize();
	}

	public function sync_data()
	{
		// Contoh query untuk mengambil data pegawai dari database Oracle
		$this->load->database('jd');
		if ($this->db->conn_id) {
			echo "Koneksi ke database Oracle berhasil.";
		} else {
			echo "Gagal terhubung ke database Oracle.";
		}

		$this->db->where('NIP_BARU', '196609282007011014');
		$query = $this->db->get('pegawai');
		$result = $query->result();
		// echo $result;
		print_r($result);
	}

	public function index()
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');
	}
}
