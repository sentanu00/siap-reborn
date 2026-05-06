<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epmstjenispemberhentianmodel extends SB_Model 
{

	public $table = 'ep_ms_jenis_pemberhentian';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT ep_ms_jenis_pemberhentian.* FROM ep_ms_jenis_pemberhentian   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE ep_ms_jenis_pemberhentian.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
