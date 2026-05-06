<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masterpangkatmodel extends SB_Model 
{

	public $table = 'pangkat';
	public $primaryKey = 'PANGKAT_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pangkat.* FROM pangkat   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
