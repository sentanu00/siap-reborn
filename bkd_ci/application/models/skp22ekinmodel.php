<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skp22ekinmodel extends SB_Model 
{

	public $table = 'skp22ekin';
	public $primaryKey = 'skp22ekin_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT skp22ekin.* FROM skp22ekin   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE skp22ekin.skp22ekin_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
