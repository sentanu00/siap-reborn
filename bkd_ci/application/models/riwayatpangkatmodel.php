<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayatpangkatmodel extends SB_Model 
{

	public $table = 'pangkat_riwayat';
	public $primaryKey = 'PANGKAT_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pangkat_riwayat.* FROM pangkat_riwayat   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE pangkat_riwayat.PANGKAT_RIWAYAT_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
	public static function getNip($pegawai_id){
		$query = $this->db->query("SELECT p.nip_baru FROM pegawai AS p WHERE p.PEGAWAI_ID = '$pegawai_id'");
		return $query->result(); 
	}
}

?>
