<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seminarmodel extends SB_Model 
{

	public $table = 'seminar';
	public $primaryKey = 'SEMINAR_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT seminar.* FROM seminar   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE seminar.SEMINAR_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
