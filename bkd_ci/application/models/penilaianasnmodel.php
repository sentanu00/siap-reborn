<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penilaianasnmodel extends SB_Model 
{

	public $table = 'penilaian_skp';
	public $primaryKey = 'PENILAIAN_SKP_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT penilaian_skp.* FROM penilaian_skp   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE penilaian_skp.PENILAIAN_SKP_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
