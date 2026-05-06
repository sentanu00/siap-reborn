<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penilaiandptigamodel extends SB_Model 
{

	public $table = 'penilaian';
	public $primaryKey = 'PENILAIAN_ID';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT penilaian.*,(
IFNULL(KESETIAAN,0)+
IFNULL(PRESTASI,0)+
IFNULL(TANGGUNG_JAWAB,0)+
IFNULL(KETAATAN,0)+
IFNULL(KEJUJURAN,0)+
IFNULL(KERJASAMA,0)+
IFNULL(PRAKARSA,0)+
IFNULL(KEPEMIMPINAN,0))/8 as RATARATA FROM penilaian   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE penilaian.PENILAIAN_ID IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}
	
}

?>
