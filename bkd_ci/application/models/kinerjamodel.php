<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kinerjamodel extends SB_Model
{

	public $table = 'presensi';
	public $primaryKey = 'id';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{
		return "  SELECT pegawai.NIP_BARU,keppo.nama_lengkap,pegawai.SATKER_ID,satker.NAMA as NAMA_SATKER,presensi.prosen_kehadiran,presensi.hukuman,presensi.tidak_masuk_kerja,presensi.sanksi_disiplin,presensi.persentase_pengurang,keppo.total_waktu as keppo_total_waktu, keppo.persentase as keppo_persentase, keppo.month, keppo.year
		FROM presensi
		LEFT JOIN pegawai on pegawai.nip_baru = presensi.nip_baru
		LEFT JOIN keppo on keppo.nip = presensi.nip_baru
		JOIN satker on satker.SATKER_ID = pegawai.SATKER_ID  ";
	}

	public static function querySelectall()
	{
		return "  SELECT pegawai.NIP_BARU,keppo.nama_lengkap,pegawai.SATKER_ID,satker.NAMA as NAMA_SATKER,presensi.prosen_kehadiran,presensi.hukuman,presensi.tidak_masuk_kerja,presensi.sanksi_disiplin,presensi.persentase_pengurang,keppo.total_waktu as keppo_total_waktu, keppo.persentase as keppo_persentase, keppo.month, keppo.year
		FROM presensi
		LEFT JOIN pegawai on pegawai.nip_baru = presensi.nip_baru
		LEFT JOIN keppo on keppo.nip = presensi.nip_baru
		JOIN satker on satker.SATKER_ID = pegawai.SATKER_ID  ";
	}


	public static function queryWhere()
	{

		return " WHERE presensi.nip_baru IS NOT NULL and keppo.nip IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}


	public function getRowsx($args)
	{
		// die("DEBUG: masuk ke getRowsx");

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
		// $limitConditional = ($limit != '' && $page != '')
		// 	? "LIMIT $limit, $page"
		// 	: '';
		// $offset = intval($page);   // sebenarnya ini length
		// $rowsPerPage = intval($limit); // ini start
		// $limitConditional = "LIMIT $offset, $rowsPerPage";



		// $orderConditional = ($sort != '' && $order != '') ?  " ORDER BY satker_id DESC" : '';
		$orderConditional = ($sort != '' && $order != '') ?  " ORDER BY IFNULL(ESELON_ID,999) ASC, SATKER_ID, PANGKAT_ID DESC" : '';


		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		// if ($key == '') {
		// 	$key = 'nip_baru,nama_lengkap,satker_id,prosen_kehadiran,hukuman,tidak_masuk_kerja,sanksi_disiplin,persentase_pengurang,bulan,tahun';
		// } else {
		// 	$key = $table . "." . $key;
		// }
		$key = "presensi.id";
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
