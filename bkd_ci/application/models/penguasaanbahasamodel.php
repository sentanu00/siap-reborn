<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penguasaanbahasamodel extends SB_Model 
{

	public $table = 'bahasa';
	public $primaryKey = 'BAHASA_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT bahasa.* FROM bahasa   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE bahasa.BAHASA_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
