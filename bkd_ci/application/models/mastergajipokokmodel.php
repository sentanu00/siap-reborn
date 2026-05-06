<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mastergajipokokmodel extends SB_Model 
{

	public $table = 'gaji_pokok';
	public $primaryKey = 'GAJI_POKOK_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT gaji_pokok.* FROM gaji_pokok   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
