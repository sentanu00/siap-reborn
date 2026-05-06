<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kinerjadisiplinamodel extends SB_Model 
{

	public $table = 'perubahan_data';
	public $primaryKey = 'PERUBAHAN_DATA_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT perubahan_data.* FROM perubahan_data   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE perubahan_data.PERUBAHAN_DATA_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}
