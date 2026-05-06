<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skpnsmodel extends SB_Model 
{

	public $table = 'sk_pns';
	public $primaryKey = 'SK_PNS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT sk_pns.* FROM sk_pns   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE sk_pns.SK_PNS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
