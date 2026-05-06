<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengalamankerjamodel extends SB_Model 
{

	public $table = 'pengalaman';
	public $primaryKey = 'PENGALAMAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pengalaman.* FROM pengalaman   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE pengalaman.PENGALAMAN_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
