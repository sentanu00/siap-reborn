<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pltplhmodel extends SB_Model 
{

	public $table = 'plt_plh';
	public $primaryKey = 'JABATAN_RIWAYAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT plt_plh.* FROM plt_plh   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE plt_plh.JABATAN_RIWAYAT_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
