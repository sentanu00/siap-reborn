<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Keppomodel extends SB_Model 
{

	public $table = 'keppo';
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
		$this->db->where('month', $month);
		$this->db->where('year', $year);
		$this->db->delete($this->table);
	
		echo "Data for month: $month, year: $year, deleted successfully.";
	
	}

	public function get_existing_ids($nipBaruArr, $month, $year)
	{
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('month', $month);
		$this->db->where('year', $year);
		$this->db->where_in('nip', $nipBaruArr);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}
	}

	public function delete_entries_by_ids($ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->delete($this->table);
	}

	public function delete_double(){
		$query = " DELETE kp1
				FROM keppo kp1
				JOIN (
					SELECT MIN(id) as min_id, nip, month, year, keterangan
					FROM keppo
					GROUP BY nip, month, year
				) kp2 ON kp1.id <> kp2.min_id
				WHERE kp1.nip = kp2.nip
				AND kp1.month = kp2.month
				AND kp1.year = kp2.year ";

		$this->db->query($query);
	}

	public static function querySelectall()
	{
		return "   SELECT * FROM keppo";
	}

	public static function querySelect(  ){
		
		
		return "   SELECT keppo.* FROM keppo   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE keppo.nip IS NOT NULL   ";
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

		$orderConditional = ($sort != '' && $order != '') ?  " ORDER BY satker_id DESC" : '';

		
		$rows = array();
		$query = $this->db->query($this->querySelectall() . $this->queryWhere() . "
			{$params} " . $this->queryGroup() . " {$orderConditional}  {$limitConditional} ");
		$result = $query->result();
		$query->free_result();

		if ($key == '') {
			$key = 'nip,nama_lengkap,total_waktu,persentase,month,year,keterangan';
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
