<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penghargaanmodel extends SB_Model 
{

	public $table = 'penghargaan';
	public $primaryKey = 'PENGHARGAAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT penghargaan.* FROM penghargaan  ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE penghargaan.PENGHARGAAN_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
