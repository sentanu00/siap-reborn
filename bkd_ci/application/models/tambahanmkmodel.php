<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tambahanmkmodel extends SB_Model 
{

	public $table = 'tambahan_masa_kerja';
	public $primaryKey = 'TAMBAHAN_MASA_KERJA_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT tambahan_masa_kerja.* FROM tambahan_masa_kerja   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE tambahan_masa_kerja.TAMBAHAN_MASA_KERJA_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
