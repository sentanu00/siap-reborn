<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hukumanmodel extends SB_Model 
{

	public $table = 'hukuman';
	public $primaryKey = 'HUKUMAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT hukuman.* FROM hukuman   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE hukuman.HUKUMAN_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
