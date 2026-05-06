<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_perjanjian_kerjamodel extends SB_Model 
{

	public $table = 'riwayat_perjanjian_kerja';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT riwayat_perjanjian_kerja.* FROM riwayat_perjanjian_kerja   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE riwayat_perjanjian_kerja.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
