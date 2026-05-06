<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mertuamodel extends SB_Model 
{

	public $table = 'mertua';
	public $primaryKey = 'MERTUA_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT mertua.* FROM mertua   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE mertua.MERTUA_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
