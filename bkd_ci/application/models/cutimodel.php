<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cutimodel extends SB_Model 
{

	public $table = 'cuti';
	public $primaryKey = 'CUTI_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT cuti.* FROM cuti   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE cuti.CUTI_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
