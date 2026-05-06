<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epusulanpemberhentianmonitoringmodel extends SB_Model 
{

	public $table = 'ep_tx_usulan_pemberhentian_detail';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT ep_tx_usulan_pemberhentian_detail.* FROM vw_usulan_detail_pegawai as ep_tx_usulan_pemberhentian_detail   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE ep_tx_usulan_pemberhentian_detail.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
