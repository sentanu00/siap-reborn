<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penataranmodel extends SB_Model 
{

	public $table = 'penataran_seminar';
	public $primaryKey = 'PENATARAN_SEMINAR_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT penataran_seminar.* FROM penataran_seminar   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE penataran_seminar.PENATARAN_SEMINAR_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
