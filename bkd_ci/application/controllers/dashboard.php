<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once(FCPATH . 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php');
// require_once(FCPATH . 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php');
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends SB_Controller
{

	protected $layout 	= "layouts/main";
	public $module 		= 'penjualan';
	public $per_page	= '10';

	function __construct()
	{
		parent::__construct();

		$this->load->model('pegawaimodel');
		$this->model = $this->pegawaimodel;
		$idx = $this->model->primaryKey;


		if (!$this->session->userdata('logged_in')) redirect('user/login', 301);
	}

	public function index()
	{

		if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5 || $this->session->userdata('gid') == 2 || $this->session->userdata('gid') == 4 || $this->session->userdata('gid') == 6 || $this->session->userdata('gid') == 20) {

			$this->data['content'] = $this->load->view('dashboard', $this->data, true);
			$this->load->view('layouts/main', $this->data);
		} else {
			redirect('pegawai');
		}
	}

	public function byjeniskelamin($stt)
	{
		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($stt != 2) $wh .= " AND b.`AKTIF_KERJA`=$stt";
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		$sql = "SELECT COUNT(PEGAWAI_ID) as JML,JENIS_KELAMIN FROM pegawai a INNER JOIN status_pegawai b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE 0=0 $wh GROUP BY JENIS_KELAMIN";
		$ax = $this->db->query($sql)->result();
		echo json_encode($ax);
		// $this->byjeniskelaminexcel($ax);
	}
	public function byjeniskelaminexcel($stt)
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($stt != 2) $wh .= " AND b.`AKTIF_KERJA`=$stt";
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		//  $sql = "SELECT COUNT(PEGAWAI_ID) as JML,JENIS_KELAMIN FROM pegawai a INNER JOIN status_pegawai b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE 0=0 $wh GROUP BY JENIS_KELAMIN";

		$sql = "SELECT a.NIP_BARU, a.NAMA, s.NAMA as SATKER, s2.NAMA as SATKER_INDUK ,a.JENIS_KELAMIN FROM pegawai as a 
		 LEFT JOIN satker as s ON a.SATKER_ID = s.SATKER_ID
		 LEFT JOIN satker as s2 ON SUBSTRING(a.SATKER_ID, 1, 2) = s2.SATKER_ID
		 INNER JOIN status_pegawai as b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE 0=0 $wh order by SATKER_INDUK, a.NAMA";

		$ax = $this->db->query($sql)->result();

		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyJenisKelamin_' . $this->session->userdata('satker') . '.xlsx';
		} else {
			$fileName = 'laporanASNbyJenisKelamin_master.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'SATKER');
		$sheet->setCellValue('D1', 'SATKER_INDUK');
		$sheet->setCellValue('E1', 'JENIS_KELAMIN');
		$rows = 2;
		foreach ($employeeData as $val) {
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU); // Use object property access -> instead of array access []
			$sheet->setCellValue('B' . $rows, $val->NAMA); // Use object property access -> instead of array access []
			$sheet->setCellValue('C' . $rows, $val->SATKER); // Use object property access -> instead of array access []
			$sheet->setCellValue('D' . $rows, $val->SATKER_INDUK); // Use object property access -> instead of array access []
			$sheet->setCellValue('E' . $rows, $val->JENIS_KELAMIN); // Use object property access -> instead of array access []
			// $sheet->setCellValue('A' . $rows, $val['JML']);
			// $sheet->setCellValue('B' . $rows, $val['JENIS_KELAMIN']);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		// header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "laporan_excel/" . $fileName);
		// redirect(base_url()."index.php/statistik");   
	}

	public function bystatuspegawai()
	{
		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		$sql = "SELECT b.`NAMA`,COUNT(*) AS total FROM pegawai a 
				INNER JOIN status_pegawai b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE b.`AKTIF_KERJA` = 1 $wh GROUP BY b.`STATUS_PEGAWAI_ID`";
		$ax = $this->db->query($sql)->result();
		echo json_encode($ax);
	}

	public function bystatuspegawaiexcel()
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid != 1) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		// $sql = "SELECT b.`NAMA` as STATUS,COUNT(*) AS JUMLAH FROM pegawai a 
		// 		INNER JOIN status_pegawai b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE b.`AKTIF_KERJA` = 1 $wh GROUP BY b.`STATUS_PEGAWAI_ID`";

		$sql = " SELECT a.NIP_BARU, a.NAMA, s.NAMA as SATKER, s2.NAMA as SATKER_INDUK, sp.NAMA as STATUS_PEGAWAI, pk.keterangan FROM pegawai as a 
		LEFT JOIN satker as s ON a.SATKER_ID = s.SATKER_ID
		LEFT JOIN satker as s2 ON SUBSTRING(a.SATKER_ID, 1, 2) = s2.SATKER_ID
		left join status_pegawai sp on a.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID
		left join pegawai_keterangan as pk on pk.nip_baru = a.NIP_BARU
		INNER JOIN status_pegawai as b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE 0=0 AND b.`AKTIF_KERJA`= 1 $wh
		order by SATKER_INDUK, a.NAMA";


		$ax = $this->db->query($sql)->result();

		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyStatusPegawai_' . $this->session->userdata('satker') . '.xlsx';
		} else {
			$fileName = 'laporanASNbyStatusPegawai_master.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'SATKER');
		$sheet->setCellValue('D1', 'SATKER_INDUK');
		$sheet->setCellValue('E1', 'STATUS_PEGAWAI');
		$sheet->setCellValue('F1', 'KETERANGAN_PEGAWAI');
		$rows = 2;
		foreach ($employeeData as $val) {
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU); // Use object property access -> instead of array access []
			$sheet->setCellValue('B' . $rows, $val->NAMA); // Use object property access -> instead of array access []
			$sheet->setCellValue('C' . $rows, $val->SATKER); // Use object property access -> instead of array access []
			$sheet->setCellValue('D' . $rows, $val->SATKER_INDUK); // Use object property access -> instead of array access []
			$sheet->setCellValue('E' . $rows, $val->STATUS_PEGAWAI);
			$sheet->setCellValue('F' . $rows, $val->keterangan);
			$rows++;
		}
		$sheet->setCellValue('C2', $totalSeluruh); // Set the sum value in field C2
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		redirect(base_url() . "laporan_excel/" . $fileName);
	}


	public function bypendidikan()
	{
		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		/*
	$sql = "SELECT COUNT(pa.PEGAWAI_ID) AS total,da.NAMA FROM pegawai pa INNER JOIN
(SELECT a.`PEGAWAI_ID`,b.`PENDIDIKAN_ID`,b.`NAMA` FROM pendidikan_riwayat a INNER JOIN pendidikan b ON a.`PENDIDIKAN_ID`=b.`PENDIDIKAN_ID` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID)
AS da ON da.PEGAWAI_ID=pa.`PEGAWAI_ID` 
INNER JOIN status_pegawai pb ON pa.`STATUS_PEGAWAI`=pb.`STATUS_PEGAWAI_ID` WHERE pb.`AKTIF_KERJA` = 1 GROUP BY da.NAMA  ORDER BY da.PENDIDIKAN_ID";
	*/
		$sql = "SELECT * FROM (SELECT COUNT(a.PEGAWAI_ID) AS total,d.NAMA FROM pegawai a INNER JOIN
			(SELECT PEGAWAI_ID,bb.PENDIDIKAN_ID,pp.`NAMA` FROM pendidikan pp INNER JOIN pendidikan_riwayat bb ON pp.`PENDIDIKAN_ID`=bb.`PENDIDIKAN_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1 GROUP BY PEGAWAI_ID) AS d
			ON d.PEGAWAI_ID=a.`PEGAWAI_ID`
			INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
			WHERE e.`AKTIF_KERJA`=1 $wh GROUP BY d.PENDIDIKAN_ID ORDER BY d.PENDIDIKAN_ID) AS ccx
			UNION
			SELECT COUNT(*) AS total,'Tidak Ada' FROM pegawai a 
			INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
			WHERE e.`AKTIF_KERJA`=1 $wh AND a.PEGAWAI_ID NOT IN (SELECT PEGAWAI_ID FROM pendidikan pp INNER JOIN pendidikan_riwayat bb ON pp.`PENDIDIKAN_ID`=bb.`PENDIDIKAN_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1 GROUP BY PEGAWAI_ID)";

		$ax = $this->db->query($sql)->result();
		echo json_encode($ax);
	}

	public function bypendidikanexcel()
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		// $sql = "SELECT * FROM (SELECT COUNT(a.PEGAWAI_ID) AS JUMLAH,d.NAMA AS TINGKAT_PENDIDIKAN FROM pegawai a INNER JOIN
		// 	(SELECT PEGAWAI_ID,bb.PENDIDIKAN_ID,pp.`NAMA` FROM pendidikan pp INNER JOIN pendidikan_riwayat bb ON pp.`PENDIDIKAN_ID`=bb.`PENDIDIKAN_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1 GROUP BY PEGAWAI_ID) AS d
		// 	ON d.PEGAWAI_ID=a.`PEGAWAI_ID`
		// 	INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
		// 	WHERE e.`AKTIF_KERJA`=1 $wh GROUP BY d.PENDIDIKAN_ID ORDER BY d.PENDIDIKAN_ID) AS ccx
		// 	UNION
		// 	SELECT COUNT(*) AS JUMLAH,'Tidak Ada' FROM pegawai a 
		// 	INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
		// 	WHERE e.`AKTIF_KERJA`=1 $wh AND a.PEGAWAI_ID NOT IN (SELECT PEGAWAI_ID FROM pendidikan pp INNER JOIN pendidikan_riwayat bb ON pp.`PENDIDIKAN_ID`=bb.`PENDIDIKAN_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1 GROUP BY PEGAWAI_ID)";

		$sql = "SELECT
	a.NIP_BARU,
	a.NAMA,
	s.NAMA AS SATKER,
	s2.NAMA AS SATKER_INDUK,
	pen.NAMA as PENDIDIKAN,
	pnk.JURUSAN,
	pnk.TANGGAL_STTB 
FROM
	pegawai AS a
	LEFT JOIN satker AS s ON a.SATKER_ID = s.SATKER_ID
	LEFT JOIN satker AS s2 ON SUBSTRING( a.SATKER_ID, 1, 2 ) = s2.SATKER_ID
	LEFT JOIN pendidikan_riwayat AS pnk ON a.PENDIDIKAN_ID_TERAKHIR = pnk.PENDIDIKAN_RIWAYAT_ID
	left join pendidikan as pen on pnk.PENDIDIKAN_ID = pen.PENDIDIKAN_ID
	INNER JOIN status_pegawai AS b ON a.`STATUS_PEGAWAI` = b.`STATUS_PEGAWAI_ID`
	WHERE 0=0 AND b.`AKTIF_KERJA`= 1 
		order by SATKER_INDUK, a.NAMA";


		$ax = $this->db->query($sql)->result();

		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyPendidikan_' . $this->session->userdata('satker') . '.xlsx';
		} else {
			$fileName = 'laporanASNbyPendidikan_master.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'SATKER');
		$sheet->setCellValue('D1', 'SATKER_INDUK');
		$sheet->setCellValue('E1', 'PENDIDIKAN');
		$sheet->setCellValue('F1', 'JURUSAN');
		$sheet->setCellValue('G1', 'TANGGAL_STTB');
		$rows = 2;
		foreach ($employeeData as $val) {
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU); // Use object property access -> instead of array access []
			$sheet->setCellValue('B' . $rows, $val->NAMA); // Use object property access -> instead of array access []
			$sheet->setCellValue('C' . $rows, $val->SATKER); // Use object property access -> instead of array access []
			$sheet->setCellValue('D' . $rows, $val->SATKER_INDUK); // Use object property access -> instead of array access []
			$sheet->setCellValue('E' . $rows, $val->PENDIDIKAN);
			$sheet->setCellValue('F' . $rows, $val->JURUSAN);
			$sheet->setCellValue('G' . $rows, $val->TANGGAL_STTB);
			$rows++;
		}
		$sheet->setCellValue('C2', $totalSeluruh); // Set the sum value in field C2
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		redirect(base_url() . "laporan_excel/" . $fileName);
	}

	public function pangkatstat()
	{
		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		/*$sql = "SELECT COUNT(a.PANGKAT_ID) AS visits,KODE as golongan FROM pangkat a
INNER JOIN (SELECT PEGAWAI_ID,MAX(pangkat_id) PANGKAT_ID FROM pangkat_riwayat WHERE pegawai_id != '' GROUP BY pegawai_id) AS d ON d.PANGKAT_ID=a.`PANGKAT_ID` 
INNER JOIN PEGAWAI c ON c.`PEGAWAI_ID`=d.PEGAWAI_ID
INNER JOIN status_pegawai d ON d.STATUS_PEGAWAI_ID=c.`STATUS_PEGAWAI` WHERE 0=0 AND d.`AKTIF_KERJA`=1 $wh GROUP BY a.pangkat_id";*/
		$sql = "SELECT * FROM (SELECT COUNT(a.PEGAWAI_ID) AS visits,d.NAMA as golongan  FROM pegawai a INNER JOIN
			(SELECT PEGAWAI_ID,bb.PANGKAT_ID,KODE AS NAMA FROM pangkat pp INNER JOIN pangkat_riwayat bb ON pp.`PANGKAT_ID`=bb.`PANGKAT_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1 GROUP BY PEGAWAI_ID) AS d
			ON d.PEGAWAI_ID=a.`PEGAWAI_ID`
			INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
			WHERE e.`AKTIF_KERJA`=1 $wh GROUP BY d.PANGKAT_ID ORDER BY d.PANGKAT_ID) AS ccx
			UNION
			SELECT COUNT(*) AS total,'Perlu di cek kembali' FROM pegawai a 
			INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
			WHERE e.`AKTIF_KERJA`=1 $wh AND a.PEGAWAI_ID NOT IN (SELECT PEGAWAI_ID FROM pangkat pp INNER JOIN pangkat_riwayat bb ON pp.`PANGKAT_ID`=bb.`PANGKAT_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1)
			";

		$ax = $this->db->query($sql)->result();
		echo json_encode($ax);
	}

	public function bypangkatexcel()
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND a.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		// $sql = "SELECT * FROM (SELECT COUNT(a.PEGAWAI_ID) AS jumlah,d.NAMA as golongan  FROM pegawai a INNER JOIN
		// 	(SELECT PEGAWAI_ID,bb.PANGKAT_ID,KODE AS NAMA FROM pangkat pp INNER JOIN pangkat_riwayat bb ON pp.`PANGKAT_ID`=bb.`PANGKAT_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1 GROUP BY PEGAWAI_ID) AS d
		// 	ON d.PEGAWAI_ID=a.`PEGAWAI_ID`
		// 	INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
		// 	WHERE e.`AKTIF_KERJA`=1 $wh GROUP BY d.PANGKAT_ID ORDER BY d.PANGKAT_ID) AS ccx
		// 	UNION
		// 	SELECT COUNT(*) AS total,'Perlu di cek kembali' FROM pegawai a 
		// 	INNER JOIN status_pegawai e ON e.`STATUS_PEGAWAI_ID`=a.`STATUS_PEGAWAI`
		// 	WHERE e.`AKTIF_KERJA`=1 $wh AND a.PEGAWAI_ID NOT IN (SELECT PEGAWAI_ID FROM pangkat pp INNER JOIN pangkat_riwayat bb ON pp.`PANGKAT_ID`=bb.`PANGKAT_ID` WHERE bb.`FLAG_DATA_TERAKHIR`=1)
		// 	";
		$sql = "SELECT a.NIP_BARU, a.NAMA, s.NAMA as SATKER, s2.NAMA as SATKER_INDUK ,pnk.GOLONGAN_NAMA, pnk.TMT_PANGKAT FROM pegawai as a 
			LEFT JOIN satker as s ON a.SATKER_ID = s.SATKER_ID
			LEFT JOIN satker as s2 ON SUBSTRING(a.SATKER_ID, 1, 2) = s2.SATKER_ID
			LEFT JOIN pangkat_riwayat as pnk ON a.PANGKAT_ID_TERAKHIR = pnk.PANGKAT_RIWAYAT_ID
			INNER JOIN status_pegawai as b ON a.`STATUS_PEGAWAI`=b.`STATUS_PEGAWAI_ID` WHERE 0=0 AND b.`AKTIF_KERJA`= 1 
			order by SATKER_INDUK, a.NAMA";

		$ax = $this->db->query($sql)->result();


		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyPangkat_' . $this->session->userdata('satker') . '.xlsx';
		} else {
			$fileName = 'laporanASNbyPangkat_master.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'SATKER');
		$sheet->setCellValue('D1', 'SATKER_INDUK');
		$sheet->setCellValue('E1', 'GOLONGAN_NAMA');
		$sheet->setCellValue('F1', 'TMT_PANGKAT');
		$rows = 2;
		foreach ($employeeData as $val) {
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU); // Use object property access -> instead of array access []
			$sheet->setCellValue('B' . $rows, $val->NAMA); // Use object property access -> instead of array access []
			$sheet->setCellValue('C' . $rows, $val->SATKER); // Use object property access -> instead of array access []
			$sheet->setCellValue('D' . $rows, $val->SATKER_INDUK); // Use object property access -> instead of array access []
			$sheet->setCellValue('E' . $rows, $val->GOLONGAN_NAMA);
			$sheet->setCellValue('F' . $rows, $val->TMT_PANGKAT);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		// header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "laporan_excel/" . $fileName);
		// redirect(base_url()."index.php/statistik");   

	}

	public function bydiklatteknisexcel()
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		$sql = "select p.NIP_BARU, p.NAMA, d.NAMA as NAMA_DIKLAT, d.TEMPAT,  d.PENYELENGGARA, d.ANGKATAN, d.TAHUN, d.TANGGAL_MULAI, d.TANGGAL_SELESAI, d.NO_STTPP, d.TANGGAL_STTPP, d.JUMLAH_JAM, s1.NAMA as SATKER, s2.NAMA as SATKER_INDUK ,d.FILE_PDF
		from pegawai AS p 
	   left join diklat_teknis AS d on p.PEGAWAI_ID = d.PEGAWAI_ID
		left join satker as s1 on p.SATKER_ID = s1.SATKER_ID
		left join satker as s2 on s1.SATKER_INDUK_ID = s2.SATKER_ID
	   where p.STATUS_PEGAWAI in ('1','2','10') and d.NAMA is not null " . $wh . " order by p.NAMA, d.TANGGAL_SELESAI";

		$ax = $this->db->query($sql)->result();

		$tgl_download = date('YmdHis');
		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyDiklatTeknis_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		} else {
			$fileName = 'laporanASNbyDiklatTeknis_master_' . $tgl_download . '.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'NAMA_DIKLAT');
		$sheet->setCellValue('D1', 'TEMPAT ');
		$sheet->setCellValue('E1', 'PENYELENGGARA');
		$sheet->setCellValue('F1', 'ANGKATAN');
		$sheet->setCellValue('G1', 'TAHUN');
		$sheet->setCellValue('H1', 'TANGGAL_MULAI');
		$sheet->setCellValue('I1', 'TANGGAL_SELESAI');
		$sheet->setCellValue('J1', 'NO_STTPP');
		$sheet->setCellValue('K1', 'TANGGAL_STTPP');
		$sheet->setCellValue('L1', 'JUMLAH_JAM');
		$sheet->setCellValue('M1', 'SATKER');
		$sheet->setCellValue('N1', 'SATKER_INDUK');
		$sheet->setCellValue('O1', 'FILE_PDF');

		$rows = 2;
		foreach ($employeeData as $val) {
			// $sheet->setCellValue('A' . $rows, $val->jumlah); // Use object property access -> instead of array access []
			// $sheet->setCellValue('B' . $rows, $val->golongan); // Use object property access -> instead of array access []
			// $sheet->setCellValue('A' . $rows, $val['JML']);
			// $sheet->setCellValue('B' . $rows, $val['JENIS_KELAMIN']);
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU);
			$sheet->setCellValue('B' . $rows, $val->NAMA);
			$sheet->setCellValue('C' . $rows, $val->NAMA_DIKLAT);
			$sheet->setCellValue('D' . $rows, $val->TEMPAT);
			$sheet->setCellValue('E' . $rows, $val->PENYELENGGARA);
			$sheet->setCellValue('F' . $rows, $val->ANGKATAN);
			$sheet->setCellValue('G' . $rows, $val->TAHUN);
			$sheet->setCellValue('H' . $rows, $val->TANGGAL_MULAI);
			$sheet->setCellValue('I' . $rows, $val->TANGGAL_SELESAI);
			$sheet->setCellValue('J' . $rows, $val->NO_STTPP);
			$sheet->setCellValue('K' . $rows, $val->TANGGAL_STTPP);
			$sheet->setCellValue('L' . $rows, $val->JUMLAH_JAM);
			$sheet->setCellValue('M' . $rows, $val->SATKER);
			$sheet->setCellValue('N' . $rows, $val->SATKER_INDUK);
			if (!empty($val->FILE_PDF)) {
				$sheet->setCellValue('O' . $rows, 'https://siap-bkpsdm.probolinggokab.go.id/' . $val->FILE_PDF);
			} else {
				$sheet->setCellValue('O' . $rows, '');
			}


			$rows++;
		}
		$tgl_download = date('YmdHis');
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		// header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "laporan_excel/" . $fileName);
		// redirect(base_url()."index.php/statistik");   
	}


	public function bydiklatfungsionalexcel()
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		$sql = "select p.NIP_BARU, p.NAMA, d.NAMA as NAMA_DIKLAT, d.TEMPAT,  d.PENYELENGGARA, d.ANGKATAN, d.TAHUN, d.TANGGAL_MULAI, d.TANGGAL_SELESAI, d.NO_STTPP, d.TANGGAL_STTPP, d.JUMLAH_JAM, s1.NAMA as SATKER, s2.NAMA as SATKER_INDUK ,d.FILE_PDF
		from pegawai as p 
	   left join diklat_fungsional as d on p.PEGAWAI_ID = d.PEGAWAI_ID
		left join satker as s1 on p.SATKER_ID = s1.SATKER_ID
		left join satker as s2 on s1.SATKER_INDUK_ID = s2.SATKER_ID
	   where p.STATUS_PEGAWAI in ('1','2','10') and d.NAMA is not null " . $wh . " order by p.NAMA, d.TANGGAL_SELESAI";

		$ax = $this->db->query($sql)->result();

		$tgl_download = date('YmdHis');
		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyDiklatFungsional_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		} else {
			$fileName = 'laporanASNbyDiklatFungsional_master_' . $tgl_download . '.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'NAMA_DIKLAT');
		$sheet->setCellValue('D1', 'TEMPAT ');
		$sheet->setCellValue('E1', 'PENYELENGGARA');
		$sheet->setCellValue('F1', 'ANGKATAN');
		$sheet->setCellValue('G1', 'TAHUN');
		$sheet->setCellValue('H1', 'TANGGAL_MULAI');
		$sheet->setCellValue('I1', 'TANGGAL_SELESAI');
		$sheet->setCellValue('J1', 'NO_STTPP');
		$sheet->setCellValue('K1', 'TANGGAL_STTPP');
		$sheet->setCellValue('L1', 'JUMLAH_JAM');
		$sheet->setCellValue('M1', 'SATKER');
		$sheet->setCellValue('N1', 'SATKER_INDUK');
		$sheet->setCellValue('O1', 'FILE_PDF');

		$rows = 2;
		foreach ($employeeData as $val) {
			// $sheet->setCellValue('A' . $rows, $val->jumlah); // Use object property access -> instead of array access []
			// $sheet->setCellValue('B' . $rows, $val->golongan); // Use object property access -> instead of array access []
			// $sheet->setCellValue('A' . $rows, $val['JML']);
			// $sheet->setCellValue('B' . $rows, $val['JENIS_KELAMIN']);
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU);
			$sheet->setCellValue('B' . $rows, $val->NAMA);
			$sheet->setCellValue('C' . $rows, $val->NAMA_DIKLAT);
			$sheet->setCellValue('D' . $rows, $val->TEMPAT);
			$sheet->setCellValue('E' . $rows, $val->PENYELENGGARA);
			$sheet->setCellValue('F' . $rows, $val->ANGKATAN);
			$sheet->setCellValue('G' . $rows, $val->TAHUN);
			$sheet->setCellValue('H' . $rows, $val->TANGGAL_MULAI);
			$sheet->setCellValue('I' . $rows, $val->TANGGAL_SELESAI);
			$sheet->setCellValue('J' . $rows, $val->NO_STTPP);
			$sheet->setCellValue('K' . $rows, $val->TANGGAL_STTPP);
			$sheet->setCellValue('L' . $rows, $val->JUMLAH_JAM);
			$sheet->setCellValue('M' . $rows, $val->SATKER);
			$sheet->setCellValue('N' . $rows, $val->SATKER_INDUK);
			if (!empty($val->FILE_PDF)) {
				$sheet->setCellValue('O' . $rows, 'https://siap-bkpsdm.probolinggokab.go.id/' . $val->FILE_PDF);
			} else {
				$sheet->setCellValue('O' . $rows, '');
			}

			$rows++;
		}
		$tgl_download = date('YmdHis');
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		// header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "laporan_excel/" . $fileName);
		// redirect(base_url()."index.php/statistik");   
	}


	public function bydiklatstrukturalexcel()
	{

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		$sql = "select p.NIP_BARU, p.NAMA, da.KETERANGAN as NAMA_DIKLAT, d.TEMPAT, d.PENYELENGGARA, d.ANGKATAN, d.TAHUN, d.TANGGAL_MULAI, d.TANGGAL_SELESAI, d.NO_STTPP, d.TANGGAL_STTPP, d.JUMLAH_JAM , s1.NAMA as SATKER, s2.NAMA as SATKER_INDUK ,d.FILE_PDF
		from pegawai as p 
		left join diklat_struktural as d on p.PEGAWAI_ID = d.PEGAWAI_ID 
		LEFT JOIN diklat da on d.DIKLAT_ID = da.diklat_id 
		left join satker as s1 on p.SATKER_ID = s1.SATKER_ID
		left join satker as s2 on s1.SATKER_INDUK_ID = s2.SATKER_ID
		where p.STATUS_PEGAWAI in ('1','2','10') and d.PENYELENGGARA is not null " . $wh . " order by p.NAMA, d.TANGGAL_SELESAI";

		$ax = $this->db->query($sql)->result();

		$tgl_download = date('YmdHis');
		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNbyDiklatStruktural_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		} else {
			$fileName = 'laporanASNbyDiklatStruktural_master_' . $tgl_download . '.xlsx';
		}

		$employeeData = $ax;
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA');
		$sheet->setCellValue('C1', 'NAMA_DIKLAT');
		$sheet->setCellValue('D1', 'TEMPAT ');
		$sheet->setCellValue('E1', 'PENYELENGGARA');
		$sheet->setCellValue('F1', 'ANGKATAN');
		$sheet->setCellValue('G1', 'TAHUN');
		$sheet->setCellValue('H1', 'TANGGAL_MULAI');
		$sheet->setCellValue('I1', 'TANGGAL_SELESAI');
		$sheet->setCellValue('J1', 'NO_STTPP');
		$sheet->setCellValue('K1', 'TANGGAL_STTPP');
		$sheet->setCellValue('L1', 'JUMLAH_JAM');
		$sheet->setCellValue('M1', 'SATKER');
		$sheet->setCellValue('N1', 'SATKER_INDUK');
		$sheet->setCellValue('O1', 'FILE_PDF');


		$rows = 2;
		foreach ($employeeData as $val) {
			// $sheet->setCellValue('A' . $rows, $val->jumlah); // Use object property access -> instead of array access []
			// $sheet->setCellValue('B' . $rows, $val->golongan); // Use object property access -> instead of array access []
			// $sheet->setCellValue('A' . $rows, $val['JML']);
			// $sheet->setCellValue('B' . $rows, $val['JENIS_KELAMIN']);
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU);
			$sheet->setCellValue('B' . $rows, $val->NAMA);
			$sheet->setCellValue('C' . $rows, $val->NAMA_DIKLAT);
			$sheet->setCellValue('D' . $rows, $val->TEMPAT);
			$sheet->setCellValue('E' . $rows, $val->PENYELENGGARA);
			$sheet->setCellValue('F' . $rows, $val->ANGKATAN);
			$sheet->setCellValue('G' . $rows, $val->TAHUN);
			$sheet->setCellValue('H' . $rows, $val->TANGGAL_MULAI);
			$sheet->setCellValue('I' . $rows, $val->TANGGAL_SELESAI);
			$sheet->setCellValue('J' . $rows, $val->NO_STTPP);
			$sheet->setCellValue('K' . $rows, $val->TANGGAL_STTPP);
			$sheet->setCellValue('L' . $rows, $val->JUMLAH_JAM);
			$sheet->setCellValue('M' . $rows, $val->SATKER);
			$sheet->setCellValue('N' . $rows, $val->SATKER_INDUK);
			if (!empty($val->FILE_PDF)) {
				$sheet->setCellValue('O' . $rows, 'https://siap-bkpsdm.probolinggokab.go.id/' . $val->FILE_PDF);
			} else {
				$sheet->setCellValue('O' . $rows, '');
			}


			$rows++;
		}
		$tgl_download = date('YmdHis');
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		$writer->save(FCPATH . "laporan_excel/" . $fileName);
		// header("Content-Type: application/vnd.ms-excel");
		redirect(base_url() . "laporan_excel/" . $fileName);
		// redirect(base_url()."index.php/statistik");   
	}

	//bysummarypegawaiexcel

	public function bysummarypegawaiexcel()
	{
		ini_set('memory_limit', '512M');

		$wh = "";
		//group id
		$gid = $this->session->userdata('gid');
		if ($gid == 2) $wh .= " AND p.SATKER_ID like '" . $this->session->userdata('satker') . "%'";
		if ($gid == 4) $wh .= " AND p.SATKER_ID like '" . $this->session->userdata('satker') . "%'";

		$sqlc = "SELECT
		p.NIP_BARU, 
		p.GELAR_DEPAN,
		p.NAMA, 
		p.GELAR_BELAKANG, 
		p.TEMPAT_LAHIR, 
		p.TANGGAL_LAHIR,
		p.EMAIL,
		p.TELEPON,
		p.NIK,
		p.ALAMAT,
		p.TANGGAL_PENSIUN as PREDIKSI_PENSIUN,
		sp.NAMA AS STATUS_PEGAWAI,
		tpg.NAMA as TIPE_PEGAWAI,
		jrx.NAMA AS JABATAN,
		jrx.ESELON, 
		jrx.KELAS_JABATAN, 
		jrx.TMT_JABATAN, 
		prx.KODE AS PANGKAT,
		prx.TMT_PANGKAT, 
		pr2x.NAMA AS PENDIDIKAN,
		pr2x.JURUSAN,
		pr2x.TANGGAL_STTB,
		s.SATKER,
		s.SATKER_INDUK
	FROM pegawai AS p
	LEFT JOIN (
		SELECT s.SATKER_ID, s.SATKER_ID_PARENT, s.NAMA AS SATKER, sp.NAMA AS SATKER_INDUK
		FROM satker AS s
		LEFT JOIN satker AS sp ON LEFT(s.SATKER_ID, 2) = sp.SATKER_ID 
	) AS s ON p.SATKER_ID = s.SATKER_ID
	LEFT JOIN status_pegawai AS sp ON p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID
	LEFT JOIN (
		SELECT jr.PEGAWAI_ID, jr.TMT_JABATAN, jr.NAMA, e.NAMA AS ESELON, jr.KELAS_JABATAN
		FROM jabatan_riwayat AS jr
		LEFT JOIN eselon AS e ON jr.ESELON_ID = e.ESELON_ID
		WHERE jr.FLAG_DATA_TERAKHIR = '1' 
	) AS jrx ON p.PEGAWAI_ID = jrx.PEGAWAI_ID
	LEFT JOIN (
		SELECT pr.PEGAWAI_ID, pr.TMT_PANGKAT, po.KODE
		FROM pangkat_riwayat AS pr
		LEFT JOIN pangkat as po ON pr.PANGKAT_ID = po.PANGKAT_ID 
		WHERE pr.FLAG_DATA_TERAKHIR = '1' 
	) AS prx ON p.PEGAWAI_ID = prx.PEGAWAI_ID
	LEFT JOIN (
		SELECT pr2.PEGAWAI_ID, pr2.TANGGAL_STTB, pr2.JURUSAN, pr1.NAMA
		FROM pendidikan_riwayat AS pr2
		LEFT JOIN pendidikan AS pr1 ON pr2.PENDIDIKAN_ID = pr1.PENDIDIKAN_ID
		WHERE pr2.FLAG_DATA_TERAKHIR = '1'
	) AS pr2x ON p.PEGAWAI_ID = pr2x.PEGAWAI_ID
	LEFT JOIN (
		SELECT gr.PEGAWAI_ID, gr.TMT_SK
		FROM gaji_riwayat AS gr
		WHERE gr.FLAG_DATA_TERAKHIR = '1' 
	) AS grx ON p.PEGAWAI_ID = grx.PEGAWAI_ID
	LEFT JOIN tipe_pegawai AS tpg on p.TIPE_PEGAWAI_ID = tpg.TIPE_PEGAWAI_ID
	WHERE p.STATUS_PEGAWAI IN ('1', '2', '10', '18')  " . $wh . "
	group by p.PEGAWAI_ID 
	ORDER BY s.SATKER_INDUK, prx.KODE DESC";

		// $ax = $this->db->query($sql)->result();

		// print_r($ax);
		// echo $ax;
		// exit();
		// $tgl_download = date('YmdHis');
		// if ($this->session->userdata('satker')) {
		// 	$fileName = 'laporanASNsummary_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		// } else {
		// 	$fileName = 'laporanASNsummary_master_' . $tgl_download . '.xlsx';
		// }



		$ax = $this->db->query($sqlc)->result();


		$tgl_download = date('YmdHis');
		if ($this->session->userdata('satker')) {
			$fileName = 'laporanASNsummary_' . $this->session->userdata('satker') . '_' . $tgl_download . '.xlsx';
		} else {
			$fileName = 'laporanASNsummary_master_' . $tgl_download . '.xlsx';
		}

		$employeeData = $ax;
		// var_dump($employeeData);
		// die();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'NIP_BARU');
		$sheet->setCellValue('B1', 'NAMA_LENGKAP');
		$sheet->setCellValue('C1', 'TEMPAT_LAHIR');
		$sheet->setCellValue('D1', 'TANGGAL_LAHIR');
		$sheet->setCellValue('E1', 'EMAIL');
		$sheet->setCellValue('F1', 'TELEPON');
		$sheet->setCellValue('G1', 'STATUS_PEGAWAI');
		$sheet->setCellValue('H1', 'JABATAN');
		$sheet->setCellValue('I1', 'ESELON');
		$sheet->setCellValue('J1', 'KELAS_JABATAN');
		$sheet->setCellValue('K1', 'TMT_JABATAN');
		$sheet->setCellValue('L1', 'PANGKAT');
		$sheet->setCellValue('M1', 'TMT_PANGKAT');
		$sheet->setCellValue('N1', 'PENDIDIKAN');
		$sheet->setCellValue('O1', 'JURUSAN');
		$sheet->setCellValue('P1', 'TANGGAL_STTB');
		$sheet->setCellValue('Q1', 'SATKER');
		$sheet->setCellValue('R1', 'SATKER_INDUK');
		$sheet->setCellValue('S1', 'NIK');
		$sheet->setCellValue('T1', 'ALAMAT');
		$sheet->setCellValue('U1', 'PREDIKSI_PENSIUN');
		$sheet->setCellValue('V1', 'TIPE_PEGAWAI');
		$rows = 2;
		foreach ($employeeData as $val) {
			$sheet->setCellValue('A' . $rows, "'" . $val->NIP_BARU);
			$sheet->setCellValue('B' . $rows, $val->GELAR_DEPAN . " " . $val->NAMA . ", " . $val->GELAR_BELAKANG);
			$sheet->setCellValue('C' . $rows, $val->TEMPAT_LAHIR);
			$sheet->setCellValue('D' . $rows, $val->TANGGAL_LAHIR);
			$sheet->setCellValue('E' . $rows, $val->EMAIL);
			$sheet->setCellValue('F' . $rows, $val->TELEPON);
			$sheet->setCellValue('G' . $rows, $val->STATUS_PEGAWAI);
			$sheet->setCellValue('H' . $rows, $val->JABATAN);
			$sheet->setCellValue('I' . $rows, $val->ESELON);
			$sheet->setCellValue('J' . $rows, $val->KELAS_JABATAN);
			$sheet->setCellValue('K' . $rows, $val->TMT_JABATAN);
			$sheet->setCellValue('L' . $rows, $val->PANGKAT);
			$sheet->setCellValue('M' . $rows, $val->TMT_PANGKAT);
			$sheet->setCellValue('N' . $rows, $val->PENDIDIKAN);
			$sheet->setCellValue('O' . $rows, $val->JURUSAN);
			$sheet->setCellValue('P' . $rows, $val->TANGGAL_STTB);
			$sheet->setCellValue('Q' . $rows, $val->SATKER);
			$sheet->setCellValue('R' . $rows, $val->SATKER_INDUK);
			$sheet->setCellValue('S' . $rows, "'" . $val->NIK);
			$sheet->setCellValue('T' . $rows, $val->ALAMAT);
			$sheet->setCellValue('U' . $rows, $val->PREDIKSI_PENSIUN);
			$sheet->setCellValue('V' . $rows, $val->TIPE_PEGAWAI);
			$rows++;
		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName . '"');
		header('Cache-Control: max-age=0');
		try {
			$writer->save(FCPATH . "laporan_excel/" . $fileName);
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url() . "laporan_excel/" . $fileName);
			// redirect(base_url()."index.php/statistik");    
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}

	// dashboard/uploadSpmt

	public function uploadSpmt()
	{
		// echo "hayo";

		if (isset($_FILES['files'])) {
			$fileCount = count($_FILES['files']['name']);
			for ($i = 0; $i < $fileCount; $i++) {
				$fileName = $_FILES['files']['name'][$i];
				$fileTmpName = $_FILES['files']['tmp_name'][$i];
				$fileSize = $_FILES['files']['size'][$i];
				$fileError = $_FILES['files']['error'][$i];
				$fileType = $_FILES['files']['type'][$i];

				// echo $fileName;
				// exit();
				// Pisahkan berdasarkan underscore (_)
				$parts = explode('_', $fileName);

				// Ambil bagian setelah underscore
				$mainPart = $parts[1];
				// echo $mainPart;
				// exit();

				// Pisahkan bagian tersebut berdasarkan titik (.)
				$mainParts = explode('.', $mainPart);

				// Ambil bagian sebelum titik
				$nip_baru = $mainParts[0];

				// Tampilkan hasil
				// echo $result;
				// exit();

				$fileExt = explode('.', $fileName);
				$fileActualExt = strtolower(end($fileExt));

				$allowed = array('pdf');

				if (in_array($fileActualExt, $allowed)) {
					if ($fileError === 0) {
						if ($fileSize < 5000000) { // limit size to 5MB
							// $fileNameNew = uniqid('', true) . "." . $fileActualExt;
							$fileNameNew = "SPMT_" . $nip_baru . "." . $fileActualExt;


							// $config['upload_path'] = './dokumen/' . $nip . '/';
							// $config['allowed_types'] = 'pdf';
							// $config['max_size']     = '2000';
							// $config['overwrite'] = TRUE;

							$fileDestination = './dokumen/' . $nip_baru . '/' . $fileNameNew;

							if (!is_dir('./dokumen/' . $nip_baru)) {
								mkdir('./dokumen/' . $nip_baru);
							}

							move_uploaded_file($fileTmpName, $fileDestination);
							//FILE_SPMT :  dokumen/198307052022211011/CPNS_SPMT_198307052022211011.pdf
							$this->db->query("update sk_cpns as s
							join pegawai as p on s.PEGAWAI_ID = p.PEGAWAI_ID 
							set s.FILE_SPMT = '" . $fileDestination . "' where p.NIP_BARU = '" . $nip_baru . "'");

							echo "File $fileName uploaded successfully!<br>";
						} else {
							echo "File $fileName is too big!<br>";
						}
					} else {
						echo "There was an error uploading $fileName!<br>";
					}
				} else {
					echo "File $fileName type is not allowed!<br>";
				}
			}
		} else {
			echo "No files uploaded!";
		}
	}


	public function ImportEkin()
	{

		if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
			$file = $_FILES['csv_file']['tmp_name'];
			$batchSize = 500;
			$handle = fopen($file, "r");

			if ($handle !== FALSE) {
				fgetcsv($handle); // Skip header
				$dataBatch = [];
				$progress = $this->session->userdata('import_progress') ?: 0;

				while (($row = fgetcsv($handle, 10000, ";")) !== FALSE) {
					if ($progress > 0) {
						$progress--;
						continue;
					}

					$dataBatch[] = [
						'jenis' => $row[0],
						'id' => $row[1],
						'nip' => $row[2],
						'nama' => $row[3],
						'periode_awal_skp' => $row[4],
						'periode_akhir_skp' => $row[5],
						'skp_unor_id' => $row[6],
						'skp_unor' => $row[7],
						'skp_unor_induk' => $row[8],
						'skp_jabatan' => $row[9],
						'skp_jenis_jabatan' => $row[10],
						'is_skp_plt_plh_pjb' => $row[11],
						'hasil_kerja' => $row[12],
						'perilaku_kerja' => $row[13],
						'hasil_akhir' => $row[14],
						'pegawai_atasan_id' => $row[15],
						'pegawai_atasan_nip' => $row[16],
						'pegawai_atasan_nama' => $row[17],
						'pegawai_atasan_unor_id' => $row[18],
						'pegawai_atasan_unor' => $row[19],
						'pegawai_atasan_jabatan' => $row[20],
						'pegawai_atasan_golru' => $row[21],
						'waktu_dinilai' => $row[22],
						'pegawai_penilai_id' => $row[23],
						'tahun_skp' => $row[24],
						'skp_id' => $row[25],
						'periode_id' => $row[26],
						'skp_penilaian_id' => $row[27],
						'golru' => $row[28],
						'jenis_pegawai' => $row[29],
						'bulan_skp' => $row[30]

					];

					// $jenis = $row[0];
					// $id = $row[1];
					// $nip = $row[2];
					// $nama = $row[3];
					// $periode_awal_skp = $row[4];
					// $periode_akhir_skp = $row[5];
					// $skp_unor_id = $row[6];
					// $skp_unor = $row[7];
					// $skp_unor_induk = $row[8];
					// $skp_jabatan = $row[9];
					// $skp_jenis_jabatan = $row[10];
					// $is_skp_plt_plh_pjb = $row[11];
					// $hasil_kerja = $row[12];
					// $perilaku_kerja = $row[13];
					// $hasil_akhir = $row[14];
					// $pegawai_atasan_id = $row[15];
					// $pegawai_atasan_nip = $row[16];
					// $pegawai_atasan_nama = $row[17];
					// $pegawai_atasan_unor_id = $row[18];
					// $pegawai_atasan_unor = $row[19];
					// $pegawai_atasan_jabatan = $row[20];
					// $pegawai_atasan_golru = $row[21];
					// $waktu_dinilai = $row[22];
					// $pegawai_penilai_id = $row[23];
					// $tahun_skp = $row[24];
					// $skp_id = $row[25];
					// $periode_id = $row[26];
					// $skp_penilaian_id = $row[27];
					// $golru = $row[28];
					// $jenis_pegawai = $row[29];



					if (count($dataBatch) >= $batchSize) {
						$this->pegawaimodel->insert_or_update_ekin_batch($dataBatch);
						$dataBatch = [];
						$this->session->set_userdata('import_progress', ftell($handle));
					}
				}

				if (!empty($dataBatch)) {
					$this->pegawaimodel->insert_or_update_ekin_batch($dataBatch);
				}

				$this->session->unset_userdata('import_progress');
				fclose($handle);
				echo "Import selesai.";
			}
		} else {
			echo "Gagal mengupload file. Error: " . $_FILES['csv_file']['error'] . "\n";
			if (isset($_FILES['csv_file']['tmp_name'])) {
				echo "Isi file:\n";
				echo nl2br(file_get_contents($_FILES['csv_file']['tmp_name']));
			}
		}
	}
}
