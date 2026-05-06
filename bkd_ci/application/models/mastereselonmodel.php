<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mastereselonmodel extends SB_Model 
{

	public $table = 'eselon';
	public $primaryKey = 'ESELON_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT eselon.* FROM eselon   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
