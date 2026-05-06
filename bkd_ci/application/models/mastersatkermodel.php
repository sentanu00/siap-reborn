<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mastersatkermodel extends SB_Model 
{

	public $table = 'satker';
	public $primaryKey = 'SATKER_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT satker.* FROM satker   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE SATKER_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
