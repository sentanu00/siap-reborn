<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Angkakreditmodel extends SB_Model 
{

	public $table = 'riwayat_angka_kredit';
	public $primaryKey = 'riwayat_angka_kredit_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT riwayat_angka_kredit.* FROM riwayat_angka_kredit  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE riwayat_angka_kredit.riwayat_angka_kredit_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
