<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayatpendidikanmodel extends SB_Model 
{

	public $table = 'pendidikan_riwayat';
	public $primaryKey = 'PENDIDIKAN_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pendidikan_riwayat.* FROM pendidikan_riwayat   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
