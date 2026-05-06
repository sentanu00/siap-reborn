<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penugasanmodel extends SB_Model 
{

	public $table = 'tugas';
	public $primaryKey = 'TUGAS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT tugas.* FROM tugas   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE tugas.TUGAS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
