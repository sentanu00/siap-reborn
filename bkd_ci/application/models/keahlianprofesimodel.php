<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Keahlianprofesimodel extends SB_Model 
{

	public $table = 'kursus';
	public $primaryKey = 'KURSUS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT kursus.* FROM kursus   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE kursus.KURSUS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
