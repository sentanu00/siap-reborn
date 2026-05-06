<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Diklatfungsionalmodel extends SB_Model 
{

	public $table = 'diklat_fungsional';
	public $primaryKey = 'DIKLAT_FUNGSIONAL_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT diklat_fungsional.* FROM diklat_fungsional   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE diklat_fungsional.DIKLAT_FUNGSIONAL_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
