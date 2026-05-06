<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reportlaporanbulanan extends SB_Controller
{
	function cetak($satker, $idttd)
	{
		// echo '2';
		try {
			$this->load->model('pegawaimodel');
			$this->model = $this->pegawaimodel;

			$filter = " AND SATKER_ID LIKE '$satker%'";

			$row = $this->model->getlaporan($filter, '')->result();
			$satker = $this->db->query("SELECT * FROM satker WHERE SATKER_ID = '$satker'")->row();
			$this->data['row'] = $row;
			$this->data['ttd'] = $this->model->getlaporan('', " AND PEGAWAI_ID = '$idttd'")->row();
			$this->data['satker_nama'] = $satker->NAMA;
			echo $this->load->view('pegawai/laporanBulanan', $this->data, true);
			// echo $this->data;
		} catch (Exception $e) {
			// Tangkap kesalahan
			echo 'Terjadi kesalahan: ' . $e->getMessage();
		}
	}

	function popupdata()
	{
		echo $this->load->view('pegawai/popupcetakbulanan', $this->data, true);
	}



	function cetakNonASN($satker, $idttd)
	{
		// echo '2';
		try {
			$this->load->model('pegawaimodel');
			$this->model = $this->pegawaimodel;

			$filter = " AND SATKER_ID LIKE '$satker%'";

			$row = $this->model->getlaporanNonASN($filter, '')->result();
			$satker = $this->db->query("SELECT * FROM satker WHERE SATKER_ID = '$satker'")->row();
			$this->data['row'] = $row;
			$this->data['ttd'] = $this->model->getlaporan('', " AND PEGAWAI_ID = '$idttd'")->row();
			$this->data['satker_nama'] = $satker->NAMA;
			echo $this->load->view('honorer/laporanBulanan', $this->data, true);
			// echo $this->data;
		} catch (Exception $e) {
			// Tangkap kesalahan
			echo 'Terjadi kesalahan: ' . $e->getMessage();
		}
	}

	function popupdataNonASN()
	{
		echo $this->load->view('honorer/popupcetakbulanan', $this->data, true);
	}


	public function coba()
	{
		echo 'dicoba';
	}
}
