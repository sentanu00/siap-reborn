<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masterjabatanfungsionalumummodel extends SB_Model 
{

	public $table = 'jabatan_fungsional';
	public $primaryKey = 'JABATAN_FUNGSIONAL_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT jabatan_fungsional.* FROM jabatan_fungsional   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
