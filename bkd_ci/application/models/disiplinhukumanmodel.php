<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Disiplinhukumanmodel extends SB_Model 
{

	public $table = 'hukuman';
	public $primaryKey = 'HUKUMAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(){
		
		
		return "  SELECT pegawai.NIP_BARU as NIP,pegawai.nama as NAMA_LENGKAP, satker.NAMA as NAMA_SATKER, jenis_hukuman.NAMA as JENIS_HUKUMAN, pejabat_penetap.JABATAN as PEJABAT_PENETAP, hukuman.NO_SK as NO_SK,
        hukuman.TANGGAL_SK as TGL_SK, hukuman.TMT_SK as TMT_SK, hukuman.KETERANGAN as KET, hukuman.BERLAKU as BERLAKU, hukuman.TANGGAL_MULAI as TGL_MULAI,hukuman.TANGGAL_AKHIR as TGL_AKHIR
        FROM pegawai
        JOIN hukuman on hukuman.pegawai_id = pegawai.pegawai_id
        JOIN jenis_hukuman on jenis_hukuman.jenis_hukuman_id = hukuman.jenis_hukuman_id
        JOIN pejabat_penetap on pejabat_penetap.pejabat_penetap_id = hukuman.pejabat_penetap_id
        JOIN satker on satker.SATKER_ID = pegawai.SATKER_ID  ";
	}

    public static function querySelectall(){

		return "  SELECT pegawai.NIP_BARU as NIP,pegawai.nama as NAMA_LENGKAP, satker.NAMA as NAMA_SATKER, jenis_hukuman.NAMA as JENIS_HUKUMAN, pejabat_penetap.JABATAN as PEJABAT_PENETAP, hukuman.NO_SK as NO_SK,
        hukuman.TANGGAL_SK as TGL_SK, hukuman.TMT_SK as TMT_SK, hukuman.KETERANGAN as KET, hukuman.BERLAKU as BERLAKU, hukuman.TANGGAL_MULAI as TGL_MULAI,hukuman.TANGGAL_AKHIR as TGL_AKHIR
        FROM pegawai
        JOIN hukuman on hukuman.pegawai_id = pegawai.pegawai_id
        JOIN jenis_hukuman on jenis_hukuman.jenis_hukuman_id = hukuman.jenis_hukuman_id
        JOIN pejabat_penetap on pejabat_penetap.pejabat_penetap_id = hukuman.pejabat_penetap_id
        JOIN satker on satker.SATKER_ID = pegawai.SATKER_ID  ";
	}
	public static function queryWhere(){
		
		return " WHERE pegawai.PEGAWAI_ID IS NOT NULL ";
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
		$orderConditional = ($sort != '' && $order != '') ?  " ORDER BY IFNULL(ESELON_ID,999) ASC, SATKER_ID, PANGKAT_ID DESC" : '';

		
		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		if ($key == '') {
			$key = 'nip_baru,nama_lengkap,nama_satker,jenis_hukuman,pejabat_penetap';
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
