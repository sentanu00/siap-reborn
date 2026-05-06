<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayatgajimodel extends SB_Model 
{

	public $table = 'gaji_riwayat';
	public $primaryKey = 'GAJI_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT gaji_riwayat.* FROM gaji_riwayat   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE gaji_riwayat.GAJI_RIWAYAT_ID IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
