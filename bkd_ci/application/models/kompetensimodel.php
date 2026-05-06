<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kompetensimodel extends SB_Model 
{

	public $table = 'kompetensi';
	public $primaryKey = 'KOMPETENSI_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		return "  SELECT TAHUN,NIP, kompetensi.NAMA as NAMA_PEGAWAI,JABATAN_SEKARANG, satker.nama as SATKER,OPD_SEKARANG,ESELON,PENYELENGGARA,NILAI,KATEGORI,INTEGRITAS,KERJASAMA,KOMUNIKASI,ORIENTASI_HASIL,PELAYANAN_PUBLIK,PENGEMBANGAN_DIRI_ORANG_LAIN,MENGELOLA_PERUBAHAN,PENGEMBALIAN_KEPUTUSAN,PEREKAT_BANGSA,CATATAN,KADALUARSA
        FROM kompetensi
        JOIN pegawai on pegawai.NIP_BARU = kompetensi.NIP
        JOIN satker on satker.SATKER_ID = pegawai.SATKER_ID  ";
	}


	public static function querySelectall()
	{
		return "  SELECT TAHUN,NIP, kompetensi.NAMA as NAMA_PEGAWAI,JABATAN_SEKARANG, satker.nama as SATKER,OPD_SEKARANG,ESELON,PENYELENGGARA,NILAI,KATEGORI,INTEGRITAS,KERJASAMA,KOMUNIKASI,ORIENTASI_HASIL,PELAYANAN_PUBLIK,PENGEMBANGAN_DIRI_ORANG_LAIN,MENGELOLA_PERUBAHAN,PENGEMBALIAN_KEPUTUSAN,PEREKAT_BANGSA,CATATAN,KADALUARSA
        FROM kompetensi
        JOIN pegawai on pegawai.NIP_BARU = kompetensi.NIP
        JOIN satker on satker.SATKER_ID = pegawai.SATKER_ID  ";
	}
	public static function queryWhere(  ){
		
		return "   WHERE kompetensi.KOMPETENSI_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
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

		// $orderConditional = ($sort != '' && $order != '') ?  " ORDER BY satker_id DESC" : '';
		$orderConditional = ($sort != '' && $order != '') ?  " ORDER BY IFNULL(ESELON_ID,999) ASC, PEGAWAI.SATKER_ID, PANGKAT_ID DESC" : '';

		
		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		if ($key == '') {
			$key = 'TAHUN,NIP,NAMA';
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
	
}

?>
