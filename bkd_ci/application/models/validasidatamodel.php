<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validasidatamodel extends SB_Model
{

	public $table = 'perubahan_data';
	public $primaryKey = 'PERUBAHAN_DATA_ID';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{


		return "   SELECT perubahan_data.* FROM perubahan_data   ";
	}
	public static function queryWhere()
	{

		return "  WHERE perubahan_data.PERUBAHAN_DATA_ID IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}

	public function getPendingChanges()
	{
		$tables = array(
			'anak', 'cuti', 'diklat_fungsional', 'diklat_struktural', 'diklat_teknis',
			'gaji_riwayat', 'kursus', 'kursus_khusus', 'organisasi_riwayat',
			'penataran_seminar', 'penghargaan', 'penilaian', 'penilaian_skp',
			'saudara', 'seminar', 'sk_pns', 'jabatan_riwayat', 'pangkat_riwayat',
			'sk_cpns', 'pendidikan_riwayat'
		);
		$this->db->where('UPDATE_JSON', 0);
		$this->db->where('VALIDASI', 0);
		$this->db->where('ISI_BARU !=', 'DELETE');
		$this->db->where_in('DB_TABLE', $tables);
		return $this->db->get('perubahan_data')->result_array();
	}

	public function updateFilePDF($primaryKeyValue, $filePDF)
	{
		$this->db->where('PERUBAHAN_DATA_ID', $primaryKeyValue);
		$this->db->update(
			'perubahan_data',
			[
				'ISI_BARU' => $filePDF,
				'UPDATE_JSON' => 1,
			]
		);
	}

	public function markUpdated($id)
	{
		$this->db->where('PERUBAHAN_DATA_ID', $id);
		$this->db->update('perubahan_data', ['UPDATE_JSON' => 1]);
	}
}
