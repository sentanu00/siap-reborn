<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masterjabatanfungsionalkhususmodel extends SB_Model 
{

	public $table = 'jabatan_fungsional_khusus';
	public $primaryKey = 'JFK_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT jabatan_fungsional_khusus.* FROM jabatan_fungsional_khusus   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
