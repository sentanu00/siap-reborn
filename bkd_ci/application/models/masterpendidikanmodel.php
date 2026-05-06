<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masterpendidikanmodel extends SB_Model 
{

	public $table = 'pendidikan';
	public $primaryKey = 'PENDIDIKAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT pendidikan.* FROM pendidikan   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE pendidikan.PENDIDIKAN_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
