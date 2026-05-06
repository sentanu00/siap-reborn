<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datapensiunmodel extends SB_Model 
{

	public $table = 'data_pensiun';
	public $primaryKey = 'PENSIUN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT data_pensiun.* FROM data_pensiun   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE data_pensiun.PENSIUN_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
