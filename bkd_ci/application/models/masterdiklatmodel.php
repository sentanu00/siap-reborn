<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masterdiklatmodel extends SB_Model 
{

	public $table = 'diklat';
	public $primaryKey = 'DIKLAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT diklat.* FROM diklat   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE diklat.DIKLAT_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
