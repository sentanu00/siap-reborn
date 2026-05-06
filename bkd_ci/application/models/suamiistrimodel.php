<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suamiistrimodel extends SB_Model 
{

	public $table = 'suami_istri';
	public $primaryKey = 'SUAMI_ISTRI_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT suami_istri.* FROM suami_istri   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE suami_istri.SUAMI_ISTRI_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
