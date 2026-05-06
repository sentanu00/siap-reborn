<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orangtuamodel extends SB_Model 
{

	public $table = 'orang_tua';
	public $primaryKey = 'ORANG_TUA_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT orang_tua.* FROM orang_tua   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE orang_tua.ORANG_TUA_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
