<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tim_kerjamodel extends SB_Model 
{

	public $table = 'tim_kerja';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT tim_kerja.* FROM tim_kerja   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE tim_kerja.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
