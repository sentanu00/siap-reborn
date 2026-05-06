<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_lamamodel extends SB_Model
{

	public $table = 'dokumen';
	public $primaryKey = 'id_dokumen';
	public $nama_file = 'nama_file';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{


		return "   SELECT dokumen.fid_pegawai as PEGAWAI_ID, dokumen.* FROM dokumen   ";
	}
	public static function queryWhere()
	{

		return "  WHERE dokumen.id_dokumen IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}
}
