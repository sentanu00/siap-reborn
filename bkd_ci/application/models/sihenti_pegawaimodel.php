<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sihenti_pegawaimodel extends SB_Model 
{

	public $table = 'pegawai';
	public $primaryKey = 'PEGAWAI_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pegawai.* FROM pegawai   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE pegawai.PEGAWAI_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
