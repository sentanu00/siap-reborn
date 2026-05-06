<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Workshopmodel extends SB_Model 
{

	public $table = 'kursus_khusus';
	public $primaryKey = 'KURSUS_KHUSUS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT kursus_khusus.* FROM kursus_khusus   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE kursus_khusus.KURSUS_KHUSUS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
