<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dfsview extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'dfsview';
	public $per_page	= '10';
	public $idx			= '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('datadfsmodel');
		$this->model = $this->datadfsmodel;
		$idx = $this->model->primaryKey;


		if (!$this->session->userdata('logged_in')) redirect('user/login', 301);
	}

	function formupload($jenis = 0, $pegawai = 0, $id = 0)
	{
		$this->data['jenis'] = $jenis;
		$this->data['pegawai'] = $pegawai;
		$this->data['id'] = $id;
		echo $this->load->view('dfsview/formupload', $this->data, true);
	}

	function formuploadhonorer($jenis = 0, $pegawai = 0, $id = 0)
	{
		$this->data['jenis'] = $jenis;
		$this->data['pegawai'] = $pegawai;
		$this->data['id'] = $id;
		echo $this->load->view('dfsview/formuploadhonorer', $this->data, true);
	}

	function uploaddata()
	{
		//var_dump($_FILES);die();
		$pegawai = $_POST['fid_pegawai'];
		$id = $_POST['id'];
		$fid_jenis_dokumen = $_POST['fid_jenis_dokumen'];
		$halaman = 1;
		$keterangan = '';
		$nip = 'kosong';
		$namafile = 'kosong';
		//cari nip
		$sql = $this->db->query("SELECT NIP_BARU FROM pegawai WHERE PEGAWAI_ID = '$pegawai'")->row();
		if ($sql) {
			$nip = $sql->NIP_BARU;
		}
		//jenis dokumen
		$sql = $this->db->query("SELECT nama_file FROM jenis_dokumen WHERE id_jenis_dokumen = '$fid_jenis_dokumen'")->row();
		if ($sql) {
			$namafile = $sql->nama_file;
		}

		$config['upload_path'] = './dokumen/' . $nip . '/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']     = '2000';
		$config['overwrite'] = TRUE;
		$tanggal_jam = date('YmdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//var_dump($config);
		$a = '';
		for ($count = 0; $count < count($_FILES["datafile"]["name"]); $count++) {
			if ($id == '0') {
				$_FILES["file"]["name"] = $namafile . '_' . ($count + 1) . '_' . $pegawai . '_' . $tanggal_jam . '_siap.pdf';
			} else {
				$_FILES["file"]["name"] = $namafile . '_' . $id . '_' . ($count + 1) . '_' . $pegawai . '_'  . $tanggal_jam . '_siap.pdf';
			}

			$_FILES["file"]["type"] = $_FILES["datafile"]["type"][$count];
			$_FILES["file"]["tmp_name"] = $_FILES["datafile"]["tmp_name"][$count];
			$_FILES["file"]["error"] = $_FILES["datafile"]["error"][$count];
			$_FILES["file"]["size"] = $_FILES["datafile"]["size"][$count];
			//	var_dump($_FILES);
			if ($this->upload->do_upload('file')) {
				$ax = array(
					'fid_jenis_dokumen'	=> $fid_jenis_dokumen,
					'fid_pegawai'		=> $pegawai,
					'nama_file'			=> 'dokumen/' . $nip . '/' . $_FILES["file"]["name"],
					'halaman'			=> $halaman,
					'actual_size'		=> $_FILES["file"]["size"],
					'keterangan'		=> $keterangan,
					'update_at'			=> date('Y-m-d H:i:s')
				);
				$a = ($count + 1) . ' File Berhasil Upload';
				//var_dump($ax);
				$axx = $this->db->query("SELECT tipe FROM jenis_dokumen WHERE id_jenis_dokumen = $fid_jenis_dokumen")->row();
				if ($axx->tipe == 1) {
					$this->db->query("DELETE FROM dokumen WHERE fid_jenis_dokumen = '$fid_jenis_dokumen' AND fid_pegawai = '$pegawai'");
				}
				$this->db->insert("dokumen", $ax);
			} else {
				$e = $this->upload->display_errors();
				$a = $e;
			}
		}
		echo $a;
	}

	function generateimage($id)
	{
		$sql = $this->db->query("SELECT nama_file FROM dokumen WHERE id_dokumen = '$id'")->row();
		$namafile = $sql->nama_file;
		$ext = explode(".", $namafile);
		$maxext = count($ext);
		$extn = $ext[$maxext - 1];
		if ($extn == 'pdf') {
			$urlberkas = base_url($sql->nama_file);
			return '<iframe src="' . $urlberkas . '?time=' . date('ymdhis') . '" width="100%" height="600px"></iframe>';
		} else {
			$urlberkas = base_url($sql->nama_file);
			return '<img src="' . $urlberkas . '?time=' . date('ymdhis') . '" style="max-width:100%">';
		}
		//var_dump($extn);die();
		/*
		$stamp = imagecreatefrompng('stamp.png');
		imagealphablending($stamp, false);
		imagesavealpha($stamp, true);
		$pngTransparency = imagecolorallocatealpha($stamp , 0, 0, 0, 127);
		imagefill($stamp , 0, 0, $pngTransparency);
		//echo $sql->nama_file;
		//$stamp = imagerotate($stamp, 10, $pngTransparency);
		$exif = exif_read_data($sql->nama_file);
		//var_dump($exif);
		$im = imagecreatefromjpeg($sql->nama_file);$orientation =0;
		if(isset($exif['Orientation'])){
		$orientation = $exif['Orientation'];
		}
		switch ($orientation) {
			case 2:
				imageflip($im, IMG_FLIP_HORIZONTAL);
				break;
			case 3:
				$im = imagerotate($im, 180, 0);
				break;
			case 4:
				imageflip($im, IMG_FLIP_VERTICAL);
				break;
			case 5:
				$im = imagerotate($im, -90, 0);
				imageflip($im, IMG_FLIP_HORIZONTAL);
				break;
			case 6:
				$im = imagerotate($im, -90, 0);
				break;
			case 7:
				$im = imagerotate($im, 90, 0);
				imageflip($im, IMG_FLIP_HORIZONTAL);
				break;
			case 8:
				$im = imagerotate($im, 90, 0); 
				break;
		}
		
		// $im = imagecreatefrompng($path);
		// Set the margins for the stamp and get the height/width of the stamp image
		
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		
		$marge_right = imagesx($im)-$sx;
		$marge_bottom = imagesy($im)-$sy;

		// Copy the stamp image onto our photo using the margin offsets and the photo 
		// width to calculate positioning of the stamp. 
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
		
		//$thumb = imagecreatetruecolor(imagesx($im), imagesy($im));
		//imagecopyresized($thumb, $im, 0, 0, 0, 0, imagesx($im), imagesy($im),imagesx($im) ,imagesy($im));
		// Output and free memory
		
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
		*/
	}

	function kartupegawai()
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 3")->result();
		echo $this->load->view('dfsview/kartupegawai', $this->data, true);
	}

	function askes()
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 5")->result();
		echo $this->load->view('dfsview/askes', $this->data, true);
	}

	function taspen()
	{

		$this->data['id'] = $id = $_POST['id'];
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 4")->result();
		// $this->data['id'] = $id = $_POST['id'];
		echo $this->load->view('dfsview/taspen', $this->data, true);
	}

	function npwp()
	{
		$this->data['id'] = $id = $_POST['id'];

		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 2")->result();
		echo $this->load->view('dfsview/npwp', $this->data, true);
	}
	function npwphonorer()
	{
		$this->data['id'] = $id = $_POST['id'];

		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 2")->result();
		echo $this->load->view('dfsview/npwphonorer', $this->data, true);
	}

	function ktp()
	{
		$this->data['id'] = $id = $_POST['id'];

		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 1")->result();
		echo $this->load->view('dfsview/ktp', $this->data, true);
	}
	function ktphonorer()
	{
		$this->data['id'] = $id = $_POST['id'];

		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = 1")->result();
		echo $this->load->view('dfsview/ktphonorer', $this->data, true);
	}

	function cpns($jenis)
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['jns'] = $jenis;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = '" . $jenis . "'")->result();
		echo $this->load->view('dfsview/cpns', $this->data, true);
	}


	function suamiistri($jenis)
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['jns'] = $jenis;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = '" . $jenis . "'")->result();
		echo $this->load->view('dfsview/suamiistri', $this->data, true);
	}

	function orangtua($jenis)
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['jns'] = $jenis;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = '" . $jenis . "'")->result();
		echo $this->load->view('dfsview/orangtua', $this->data, true);
	}

	function mertua($jenis)
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['jns'] = $jenis;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = '" . $jenis . "'")->result();
		echo $this->load->view('dfsview/mertua', $this->data, true);
	}

	function pns($jenis)
	{
		$this->data['id'] = $id = $_POST['id'];
		$this->data['jns'] = $jenis;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND b.`id_jenis_dokumen` = '" . $jenis . "'")->result();
		echo $this->load->view('dfsview/pns', $this->data, true);
	}

	function riwayatpangkat($id, $idriwayat)
	{
		$this->data['jns'] = 14;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '14'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}


	function riwayatmutasi($id, $idriwayat)
	{
		$this->data['jns'] = 15;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '15'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}


	function riwayatgaji($id, $idriwayat)
	{
		$this->data['jns'] = 16;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '16'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}


	function riwayatpendidikan($id, $idriwayat)
	{
		$this->data['jns'] = 17;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '17'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}

	function diklatstruktural($id, $idriwayat)
	{
		$this->data['jns'] = 18;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '18'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}

	function diklatfungsional($id, $idriwayat)
	{
		$this->data['jns'] = 19;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '19'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}

	function diklatteknis($id, $idriwayat)
	{
		$this->data['jns'] = 20;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '20'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}

	function penilaianskp($id, $idriwayat)
	{
		$this->data['jns'] = 27;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '27'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}


	function anak($id, $idriwayat)
	{
		$this->data['jns'] = 25;
		$this->data['id'] = $id;
		$this->data['dfs'] = $this->db->query("SELECT a.`fid_pegawai`,b.`id_jenis_dokumen`,a.`nama_dokumen`,a.`nama_file`,a.`halaman`,a.`id_dokumen`,b.`jenis_dokumen` FROM `dokumen` a INNER JOIN `jenis_dokumen` b ON a.`fid_jenis_dokumen`=b.`id_jenis_dokumen` WHERE a.`fid_pegawai` = '" . $id . "' AND a.id='" . $idriwayat . "' AND b.`id_jenis_dokumen` = '25'")->result();
		echo $this->load->view('dfsview/riwayat', $this->data, true);
	}
}
