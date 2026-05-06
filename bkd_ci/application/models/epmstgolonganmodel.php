<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epmstgolonganmodel extends SB_Model 
{

	public $table = 'ep_ms_jenis_golongan';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT ep_ms_jenis_golongan.* FROM ep_ms_jenis_golongan   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE ep_ms_jenis_golongan.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
