<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nikahmodel extends SB_Model 
{

	public $table = 'nikah_riwayat';
	public $primaryKey = 'NIKAH_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT nikah_riwayat.* FROM nikah_riwayat   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE nikah_riwayat.NIKAH_RIWAYAT_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
