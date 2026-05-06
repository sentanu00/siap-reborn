<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epmssyaratmodel extends SB_Model 
{

	public $table = 'ep_ms_persyaratan';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT ep_ms_persyaratan.* FROM ep_ms_persyaratan   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE ep_ms_persyaratan.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
