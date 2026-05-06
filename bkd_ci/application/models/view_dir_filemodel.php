<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class View_dir_filemodel extends SB_Model 
{

	public $table = 'convert_file';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT convert_file.* FROM convert_file   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE convert_file.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
