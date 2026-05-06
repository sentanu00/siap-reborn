<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Diklatstrukturalmodel extends SB_Model 
{

	public $table = 'diklat_struktural';
	public $primaryKey = 'DIKLAT_STRUKTURAL_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT diklat_struktural.* FROM diklat_struktural   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE diklat_struktural.DIKLAT_STRUKTURAL_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
