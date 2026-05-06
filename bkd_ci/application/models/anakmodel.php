<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Anakmodel extends SB_Model 
{

	public $table = 'anak';
	public $primaryKey = 'ANAK_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT anak.* FROM anak   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE anak.ANAK_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
