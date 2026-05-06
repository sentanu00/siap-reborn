<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawaimodel extends SB_Model
{

	public $table = 'pegawai';
	public $primaryKey = 'PEGAWAI_ID';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{


		return "   SELECT pegawai.* FROM pegawai   ";
	}


	public static function querySelectall()
	{


		return "   SELECT * FROM (SELECT a.*,d.ESELON_ID,e.PANGKAT_ID,e.TMT_PANGKAT FROM pegawai a
LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
LEFT JOIN (SELECT PEGAWAI_ID,PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT FROM `pangkat_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID) AS pegawai  ";
	}

	public static function queryWhere()
	{

		return "  WHERE pegawai.PEGAWAI_ID IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}

	public function getdiklat($pegid)
	{
		$sql = $this->db->query("SELECT ds.TAHUN,md.NAMA FROM `diklat_struktural` ds INNER JOIN diklat AS md ON md.DIKLAT_ID=ds.DIKLAT_ID WHERE PEGAWAI_ID= '$pegid' ORDER BY TAHUN DESC LIMIT 1")->row();
		if ($sql) {
			return $sql->NAMA . '<br />' . $sql->TAHUN;
		} else {
			return '';
		}
	}

	public function getlaporan($satker, $peg)
	{
		// 		$sql = "  SELECT PEGAWAI_ID,NIP_BARU,CONCAT(IF(IFNULL(GELAR_DEPAN,'')!='',CONCAT(GELAR_DEPAN,'. '),''),pegawai.NAMA,
		// IF(IFNULL(GELAR_BELAKANG,'')!='',CONCAT(',',GELAR_BELAKANG),'')) AS NAMA_LENGKAP,
		// TEMPAT_LAHIR,TANGGAL_LAHIR,TMT_PANGKAT,CONCAT(PANGKAT,'<br />',GOL) AS GOL_RUANG,TMT_JABATAN,JABATAN,JURUSAN,TAHUN,PANGKAT,
		// CASE 
		//    WHEN STATUS_KAWIN = 1 THEN 'BELUM KAWIN'
		//    WHEN STATUS_KAWIN = 2 THEN 'KAWIN'
		//    WHEN STATUS_KAWIN = 3 THEN 'JANDA'
		//    WHEN STATUS_KAWIN = 4 THEN 'DUDA'
		//    END AS TXT_KAWIN,
		//    sp.NAMA AS TXT_PEGAWAI,
		//    agm.NAMA AS TXT_AGAMA,
		//    IF(pegawai.`JENIS_KELAMIN`='P','PEREMPUAN','LAKI-LAKI') AS TXT_KELAMIN
		//  FROM (SELECT a.*,d.ESELON_ID,e.PANGKAT_ID,e.TMT_PANGKAT,e.KODE AS GOL,e.NAMA AS PANGKAT,d.NAMA AS JABATAN,TMT_JABATAN,p.JURUSAN,p.TAHUN FROM pegawai a
		// LEFT JOIN (SELECT PEGAWAI_ID,PENDIDIKAN_ID,JURUSAN,YEAR(TANGGAL_STTB) AS TAHUN FROM `pendidikan_riwayat`  WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TANGGAL_STTB DESC) AS p ON a.`PEGAWAI_ID`=p.PEGAWAI_ID
		// LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat`  WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
		// LEFT JOIN (SELECT PEGAWAI_ID,pr.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,NAMA,KODE FROM `pangkat_riwayat` AS pr INNER JOIN pangkat AS mp ON pr.`PANGKAT_ID`=mp.`PANGKAT_ID` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID) AS pegawai
		// INNER JOIN status_pegawai sp ON sp.STATUS_PEGAWAI_ID=pegawai.`STATUS_PEGAWAI`
		// INNER JOIN agama agm ON agm.AGAMA_ID=pegawai.`AGAMA_ID`
		// WHERE 0=0 $satker $peg AND STATUS_PEGAWAI IN (1,2,10)
		// ORDER BY IFNULL(ESELON_ID,999) ASC, PANGKAT_ID DESC,TMT_PANGKAT ASC";

		$sql = "SELECT PEGAWAI_ID, NIP_BARU, CONCAT( IF ( IFNULL( GELAR_DEPAN, '' )!= '', CONCAT( GELAR_DEPAN, '. ' ), '' ), pegawai.NAMA, IF ( IFNULL( GELAR_BELAKANG, '' )!= '', CONCAT( ',', GELAR_BELAKANG ), '' )) AS NAMA_LENGKAP, TEMPAT_LAHIR, TANGGAL_LAHIR, TMT_PANGKAT, CONCAT( PANGKAT, '<br />', GOL ) AS GOL_RUANG, TMT_JABATAN, JABATAN, JURUSAN, TAHUN, PANGKAT, MASA_KERJA_BULAN, MASA_KERJA_TAHUN, CASE WHEN STATUS_KAWIN = 1 THEN 'BELUM KAWIN' WHEN STATUS_KAWIN = 2 THEN 'KAWIN' WHEN STATUS_KAWIN = 3 THEN 'JANDA' WHEN STATUS_KAWIN = 4 THEN 'DUDA' END AS TXT_KAWIN, sp.NAMA AS TXT_PEGAWAI, agm.NAMA AS TXT_AGAMA, IF ( pegawai.`JENIS_KELAMIN` = 'P', 'PEREMPUAN', 'LAKI-LAKI' ) AS TXT_KELAMIN FROM ( SELECT a.*, d.ESELON_ID, e.PANGKAT_ID, e.TMT_PANGKAT, e.KODE AS GOL, e.NAMA AS PANGKAT, d.NAMA AS JABATAN, TMT_JABATAN, p.JURUSAN, p.TAHUN, e.MASA_KERJA_TAHUN, e.MASA_KERJA_BULAN FROM pegawai a LEFT JOIN ( SELECT PEGAWAI_ID, PENDIDIKAN_ID, JURUSAN, YEAR ( TANGGAL_STTB ) AS TAHUN FROM `pendidikan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TANGGAL_STTB DESC ) AS p ON a.`PEGAWAI_ID` = p.PEGAWAI_ID LEFT JOIN ( SELECT PEGAWAI_ID, ESELON_ID, NAMA, TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC ) AS d ON a.`PEGAWAI_ID` = d.PEGAWAI_ID LEFT JOIN ( SELECT PEGAWAI_ID, pr.PANGKAT_ID, TANGGAL_SK, TMT_PANGKAT, NAMA, KODE, MASA_KERJA_TAHUN, MASA_KERJA_BULAN FROM `pangkat_riwayat` AS pr INNER JOIN pangkat AS mp ON pr.`PANGKAT_ID` = mp.`PANGKAT_ID` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC ) AS e ON a.`PEGAWAI_ID` = e.PEGAWAI_ID ) AS pegawai INNER JOIN status_pegawai sp ON sp.STATUS_PEGAWAI_ID = pegawai.`STATUS_PEGAWAI` INNER JOIN agama agm ON agm.AGAMA_ID = pegawai.`AGAMA_ID` WHERE 0=0 $satker $peg AND STATUS_PEGAWAI IN ( 1, 2, 10 ) ORDER BY IFNULL( ESELON_ID, 999 ) ASC, PANGKAT_ID DESC, TMT_PANGKAT ASC";

		$a = $this->db->query($sql);
		return $a;
	}

	public function getlaporanNonASN($satker, $peg)
	{
		// 		$sql = "  SELECT PEGAWAI_ID,NIP_BARU,CONCAT(IF(IFNULL(GELAR_DEPAN,'')!='',CONCAT(GELAR_DEPAN,'. '),''),pegawai.NAMA,
		// IF(IFNULL(GELAR_BELAKANG,'')!='',CONCAT(',',GELAR_BELAKANG),'')) AS NAMA_LENGKAP,
		// TEMPAT_LAHIR,TANGGAL_LAHIR,TMT_PANGKAT,CONCAT(PANGKAT,'<br />',GOL) AS GOL_RUANG,TMT_JABATAN,JABATAN,JURUSAN,TAHUN,PANGKAT,
		// CASE 
		//    WHEN STATUS_KAWIN = 1 THEN 'BELUM KAWIN'
		//    WHEN STATUS_KAWIN = 2 THEN 'KAWIN'
		//    WHEN STATUS_KAWIN = 3 THEN 'JANDA'
		//    WHEN STATUS_KAWIN = 4 THEN 'DUDA'
		//    END AS TXT_KAWIN,
		//    sp.NAMA AS TXT_PEGAWAI,
		//    agm.NAMA AS TXT_AGAMA,
		//    IF(pegawai.`JENIS_KELAMIN`='P','PEREMPUAN','LAKI-LAKI') AS TXT_KELAMIN
		//  FROM (SELECT a.*,d.ESELON_ID,e.PANGKAT_ID,e.TMT_PANGKAT,e.KODE AS GOL,e.NAMA AS PANGKAT,d.NAMA AS JABATAN,TMT_JABATAN,p.JURUSAN,p.TAHUN FROM pegawai a
		// LEFT JOIN (SELECT PEGAWAI_ID,PENDIDIKAN_ID,JURUSAN,YEAR(TANGGAL_STTB) AS TAHUN FROM `pendidikan_riwayat`  WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TANGGAL_STTB DESC) AS p ON a.`PEGAWAI_ID`=p.PEGAWAI_ID
		// LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat`  WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
		// LEFT JOIN (SELECT PEGAWAI_ID,pr.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,NAMA,KODE FROM `pangkat_riwayat` AS pr INNER JOIN pangkat AS mp ON pr.`PANGKAT_ID`=mp.`PANGKAT_ID` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID) AS pegawai
		// INNER JOIN status_pegawai sp ON sp.STATUS_PEGAWAI_ID=pegawai.`STATUS_PEGAWAI`
		// INNER JOIN agama agm ON agm.AGAMA_ID=pegawai.`AGAMA_ID`
		// WHERE 0=0 $satker $peg AND STATUS_PEGAWAI IN (1,2,10)
		// ORDER BY IFNULL(ESELON_ID,999) ASC, PANGKAT_ID DESC,TMT_PANGKAT ASC";

		$sql = "SELECT PEGAWAI_ID, NIK, CONCAT( IF ( IFNULL( GELAR_DEPAN, '' )!= '', CONCAT( GELAR_DEPAN, '. ' ), '' ), pegawai.NAMA, IF ( IFNULL( GELAR_BELAKANG, '' )!= '', CONCAT( ',', GELAR_BELAKANG ), '' )) AS NAMA_LENGKAP, TEMPAT_LAHIR, TANGGAL_LAHIR, TMT_PANGKAT, CONCAT( PANGKAT, '<br />', GOL ) AS GOL_RUANG, TMT_JABATAN, JABATAN, JURUSAN, TAHUN, PANGKAT, MASA_KERJA_BULAN, MASA_KERJA_TAHUN, CASE WHEN STATUS_KAWIN = 1 THEN 'BELUM KAWIN' WHEN STATUS_KAWIN = 2 THEN 'KAWIN' WHEN STATUS_KAWIN = 3 THEN 'JANDA' WHEN STATUS_KAWIN = 4 THEN 'DUDA' END AS TXT_KAWIN, sp.NAMA AS TXT_PEGAWAI, agm.NAMA AS TXT_AGAMA, IF ( pegawai.`JENIS_KELAMIN` = 'P', 'PEREMPUAN', 'LAKI-LAKI' ) AS TXT_KELAMIN FROM ( SELECT a.*, d.ESELON_ID, e.PANGKAT_ID, e.TMT_PANGKAT, e.KODE AS GOL, e.NAMA AS PANGKAT, d.NAMA AS JABATAN, TMT_JABATAN, p.JURUSAN, p.TAHUN, e.MASA_KERJA_TAHUN, e.MASA_KERJA_BULAN FROM pegawai a LEFT JOIN ( SELECT PEGAWAI_ID, PENDIDIKAN_ID, JURUSAN, YEAR ( TANGGAL_STTB ) AS TAHUN FROM `pendidikan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TANGGAL_STTB DESC ) AS p ON a.`PEGAWAI_ID` = p.PEGAWAI_ID LEFT JOIN ( SELECT PEGAWAI_ID, ESELON_ID, NAMA, TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC ) AS d ON a.`PEGAWAI_ID` = d.PEGAWAI_ID LEFT JOIN ( SELECT PEGAWAI_ID, pr.PANGKAT_ID, TANGGAL_SK, TMT_PANGKAT, NAMA, KODE, MASA_KERJA_TAHUN, MASA_KERJA_BULAN FROM `pangkat_riwayat` AS pr INNER JOIN pangkat AS mp ON pr.`PANGKAT_ID` = mp.`PANGKAT_ID` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC ) AS e ON a.`PEGAWAI_ID` = e.PEGAWAI_ID ) AS pegawai INNER JOIN status_pegawai sp ON sp.STATUS_PEGAWAI_ID = pegawai.`STATUS_PEGAWAI` INNER JOIN agama agm ON agm.AGAMA_ID = pegawai.`AGAMA_ID` WHERE 0=0 $satker $peg AND STATUS_PEGAWAI IN ( 11, 12, 13 ) ORDER BY IFNULL( ESELON_ID, 999 ) ASC, PANGKAT_ID DESC, TMT_PANGKAT ASC";

		$a = $this->db->query($sql);
		return $a;
	}


	public function getRowsx($args)
	{
		$table = $this->table;
		$key = $this->primaryKey;

		extract(array_merge(array(
			'page' 		=> '0',
			'limit'  	=> '0',
			'sort' 		=> '',
			'order' 	=> '',
			'params' 	=> '',
			'global'	=> '1'
		), $args));

		//$offset = ($page-1) * $limit ;
		//$offset = $page-1 ;
		$limitConditional =  "LIMIT $limit , $page";

		$orderConditional = ($sort != '' && $order != '') ?  " ORDER BY IFNULL(ESELON_ID,999) asc, SATKER_INDUK_ID, PANGKAT_ID desc, TMT_PANGKAT ASC " : '';

		// Update permission global / own access new ver 1.1
		$table = $this->table;
		if ($global == 0)
			$params .= " AND {$table}.entry_by ='" . $this->session->userdata('uid') . "'";
		// End Update permission global / own access new ver 1.1

		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		if ($key == '') {
			$key = 'NIP_BARU,STATUS_PEGAWAI,NAMA,GELAR_DEPAN,GELAR_BELAKANG,TEMPAT_LAHIR,TANGGAL_LAHIR,JENIS_KELAMIN,SATKER_ID';
		} else {
			$key = $table . "." . $key;
		}
		$counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM ( SELECT ' . $key . ' FROM ', $this->querySelect());
		//echo 	$counter_select; exit;
		$query = $this->db->query($counter_select . $this->queryWhere() . " " . $this->queryGroup() . ') as ' . $table);
		$res = $query->result();
		// var_dump($counter_select . $this->queryWhere()." {$params} ". $this->queryGroup());exit;
		$total = $res[0]->total;

		$query = $this->db->query($counter_select . $this->queryWhere() . " {$params} " . $this->queryGroup() . ') as ' . $table);
		$res = $query->result();
		// var_dump($counter_select . $this->queryWhere()." {$params} ". $this->queryGroup());exit;
		$totalfil = $res[0]->total;
		$query->free_result();

		return $results = array('rows' => $result, 'total' => $total, 'totalfil' => $totalfil);
	}

	public function getRowsxpensiun($args)
	{
		$table = $this->table;
		$key = $this->primaryKey;

		extract(array_merge(array(
			'page' 		=> '0',
			'limit'  	=> '0',
			'sort' 		=> '',
			'order' 	=> '',
			'params' 	=> '',
			'global'	=> '1'
		), $args));

		//$offset = ($page-1) * $limit ;
		//$offset = $page-1 ;
		$limitConditional =  "LIMIT $limit , $page";

		$orderConditional = ($sort != '' && $order != '') ?  " TANGGAL_PENSIUN ASC, SATKER_ID, PANGKAT_ID DESC, TMT_PANGKAT ASC " : '';

		// Update permission global / own access new ver 1.1
		$table = $this->table;
		if ($global == 0)
			$params .= " AND {$table}.entry_by ='" . $this->session->userdata('uid') . "'";
		// End Update permission global / own access new ver 1.1

		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		if ($key == '') {
			$key = 'NIP_BARU,STATUS_PEGAWAI,NAMA,GELAR_DEPAN,GELAR_BELAKANG,TEMPAT_LAHIR,TANGGAL_LAHIR,JENIS_KELAMIN,SATKER_ID';
		} else {
			$key = $table . "." . $key;
		}
		$counter_select = preg_replace('/[\s]*SELECT(.*)FROM/Usi', 'SELECT count(' . $key . ') as total FROM ( SELECT ' . $key . ' FROM ', $this->querySelect());
		//echo 	$counter_select; exit;
		$query = $this->db->query($counter_select . $this->queryWhere() . " " . $this->queryGroup() . ') as ' . $table);
		$res = $query->result();
		// var_dump($counter_select . $this->queryWhere()." {$params} ". $this->queryGroup());exit;
		$total = $res[0]->total;

		$query = $this->db->query($counter_select . $this->queryWhere() . " {$params} " . $this->queryGroup() . ') as ' . $table);
		$res = $query->result();
		// var_dump($counter_select . $this->queryWhere()." {$params} ". $this->queryGroup());exit;
		$totalfil = $res[0]->total;
		$query->free_result();

		return $results = array('rows' => $result, 'total' => $total, 'totalfil' => $totalfil);
	}

	public function insert_or_update_ekin_batch($data)
	{

		$datetime = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		$datetime_sekarang = $datetime->format('Y-m-d H:i:s');
		foreach ($data as $row) {
			$this->db->query(
				"INSERT INTO skp22ekin (jenis, id, nip, nama, periode_awal_skp, periode_akhir_skp, skp_unor_id, skp_unor, skp_unor_induk, skp_jabatan, skp_jenis_jabatan, is_skp_plt_plh_pjb, hasil_kerja, perilaku_kerja, hasil_akhir, pegawai_atasan_id, pegawai_atasan_nip, pegawai_atasan_nama, pegawai_atasan_unor_id, pegawai_atasan_unor, pegawai_atasan_jabatan, pegawai_atasan_golru, waktu_dinilai, pegawai_penilai_id, tahun_skp, skp_id, periode_id, skp_penilaian_id, golru, jenis_pegawai, insert_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                jenis = VALUES(jenis), id = VALUES(id), nama = VALUES(nama), skp_unor_id = VALUES(skp_unor_id), skp_unor = VALUES(skp_unor), skp_jabatan = VALUES(skp_jabatan), hasil_kerja = VALUES(hasil_kerja), perilaku_kerja = VALUES(perilaku_kerja), hasil_akhir = VALUES(hasil_akhir), tahun_skp = VALUES(tahun_skp), golru = VALUES(golru), jenis_pegawai = VALUES(jenis_pegawai)",
				[
					$row['jenis'],
					$row['id'],
					$row['nip'],
					$row['nama'],
					$row['periode_awal_skp'],
					$row['periode_akhir_skp'],
					$row['skp_unor_id'],
					$row['skp_unor'],
					$row['skp_unor_induk'],
					$row['skp_jabatan'],
					$row['skp_jenis_jabatan'],
					$row['is_skp_plt_plh_pjb'],
					$row['hasil_kerja'],
					$row['perilaku_kerja'],
					$row['hasil_akhir'],
					$row['pegawai_atasan_id'],
					$row['pegawai_atasan_nip'],
					$row['pegawai_atasan_nama'],
					$row['pegawai_atasan_unor_id'],
					$row['pegawai_atasan_unor'],
					$row['pegawai_atasan_jabatan'],
					$row['pegawai_atasan_golru'],
					$row['waktu_dinilai'],
					$row['pegawai_penilai_id'],
					$row['tahun_skp'],
					$row['skp_id'],
					$row['periode_id'],
					$row['skp_penilaian_id'],
					$row['golru'],
					$row['jenis_pegawai'],
					$datetime_sekarang
				]
			);
		}
	}
}
