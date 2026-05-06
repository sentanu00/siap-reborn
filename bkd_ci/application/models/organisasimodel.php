<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Organisasimodel extends SB_Model 
{

	public $table = 'organisasi_riwayat';
	public $primaryKey = 'ORGANISASI_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT organisasi_riwayat.* FROM organisasi_riwayat   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE organisasi_riwayat.ORGANISASI_RIWAYAT_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
