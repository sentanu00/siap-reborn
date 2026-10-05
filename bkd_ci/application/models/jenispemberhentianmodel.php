<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jenispemberhentianmodel extends SB_Model 
{

	public $table = 'jenis_pemberhentian';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT jenis_pemberhentian.* FROM jenis_pemberhentian   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE jenis_pemberhentian.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}
