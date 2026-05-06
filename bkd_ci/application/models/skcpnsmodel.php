<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skcpnsmodel extends SB_Model 
{

	public $table = 'sk_cpns';
	public $primaryKey = 'SK_CPNS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT sk_cpns.* FROM sk_cpns   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE sk_cpns.SK_CPNS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
