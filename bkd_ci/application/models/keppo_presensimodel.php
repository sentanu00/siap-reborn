<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Keppo_presensimodel extends SB_Model 
{

	public $table = 'keppo_presensi';
	public $primaryKey = 'KEPPO_PRESENSI_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT keppo_presensi.* FROM keppo_presensi   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE keppo_presensi.KEPPO_PRESENSI_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
