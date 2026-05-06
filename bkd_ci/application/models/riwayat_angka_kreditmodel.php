<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_angka_kreditmodel extends SB_Model 
{

	public $table = 'riwayat_angka_kredit';
	public $primaryKey = 'riwayat_angka_kredit_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pegawai.NIP_BARU, pegawai.NAMA, riwayat_angka_kredit .* FROM riwayat_angka_kredit 
 join pegawai on riwayat_angka_kredit .PEGAWAI_ID = pegawai.PEGAWAI_ID  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE riwayat_angka_kredit .riwayat_angka_kredit_id IS NOT NULL and pegawai.STATUS_PEGAWAI in ('1', '2', '10')   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
