<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saudaramodel extends SB_Model 
{

	public $table = 'saudara';
	public $primaryKey = 'SAUDARA_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT saudara.* FROM saudara   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE saudara.SAUDARA_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
