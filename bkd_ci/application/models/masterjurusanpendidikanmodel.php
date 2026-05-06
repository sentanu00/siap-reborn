<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Masterjurusanpendidikanmodel extends SB_Model 
{

	public $table = 'jurusan_pendidikan';
	public $primaryKey = 'JURUSAN_PENDIDIKAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT jurusan_pendidikan.* FROM jurusan_pendidikan   ";
	}
	public static function queryWhere(  ){
		
		return " WHERE 0=0   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
