<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Presensimodel extends SB_Model 
{

	public $table = 'presensi';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public function insert_batch_data($data) {
		// Insert the batch data into the 'presensi' table
		$this->db->insert_batch($this->table, $data);
	}

	public function insert_data($data) {
		// Insert the batch data into the 'presensi' table
		$this->db->insert($this->table, $data);
	}

	public function delete_data_by_month_year($month, $year)
{
    // Delete the data from the 'presensi' table based on the current month and year
    $this->db->where('bulan', $month);
    $this->db->where('tahun', $year);
    $this->db->delete($this->table);

	echo "Data for month: $month, year: $year, deleted successfully.";

}

	public function delete_double(){
		$query = " DELETE p1
				FROM presensi p1
				JOIN (
					SELECT MIN(id) as min_id, nip_baru, bulan, tahun
					FROM presensi
					GROUP BY nip_baru, bulan, tahun
				) p2 ON p1.id <> p2.min_id
				WHERE p1.nip_baru = p2.nip_baru
				AND p1.bulan = p2.bulan
				AND p1.tahun = p2.tahun ";

		$this->db->query($query);
	}

	public static function querySelectall()
	{
		return "   SELECT * FROM presensi";
	}

	public static function querySelect(  ){
		
		
		return "   SELECT presensi.* FROM presensi   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE presensi.nip_baru IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}

	// public function deleteDataByMonthYear()
    // {
	// 	$month = date('m'-1);
    //     $this->db->where('bulan', $month);
    //     $this->db->where('tahun', $year);
    //     $this->db->delete('keppo');
    // }

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

		$orderConditional = ($sort != '' && $order != '') ?  " ORDER BY satker_id DESC" : '';

		
		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		if ($key == '') {
			$key = 'nip_baru,nama_lengkap,satker_id,prosen_kehadiran,hukuman,tidak_masuk_kerja,sanksi_disiplin,persentase_pengurang,bulan,tahun';
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
