<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_jabatan4model extends SB_Model
{

	public $table = 'jabatan_riwayat';
	public $primaryKey = 'JABATAN_RIWAYAT_ID';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{


		return "   SELECT jabatan_riwayat.* FROM jabatan_riwayat   ";
	}
	public static function queryWhere()
	{

		return "  WHERE jabatan_riwayat.flag_tayang = '1' and jabatan_riwayat.JABATAN_RIWAYAT_ID IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}
}
