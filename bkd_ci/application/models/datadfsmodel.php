<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datadfsmodel extends SB_Model 
{

	public $table = 'digital_file_system';
	public $primaryKey = 'DFS_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT digital_file_system.* FROM digital_file_system   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE digital_file_system.DFS_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
