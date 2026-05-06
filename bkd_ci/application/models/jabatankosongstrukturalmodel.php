<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jabatankosongstrukturalmodel extends SB_Model 
{

	public $table = 'acl';
	public $primaryKey = '';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT acl.* FROM acl   ";
	}
	public static function queryWhere(  ){
		
		return "    ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
