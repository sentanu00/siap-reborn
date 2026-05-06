<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sk_honorermodel extends SB_Model 
{

	public $table = 'skhonorer_riwayat';
	public $primaryKey = 'JABATAN_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT skhonorer_riwayat.* FROM skhonorer_riwayat   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE skhonorer_riwayat.JABATAN_RIWAYAT_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
