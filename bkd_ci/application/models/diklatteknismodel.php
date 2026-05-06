<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Diklatteknismodel extends SB_Model 
{

	public $table = 'diklat_teknis';
	public $primaryKey = 'DIKLAT_TEKNIS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT diklat_teknis.* FROM diklat_teknis  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE diklat_teknis.DIKLAT_TEKNIS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
