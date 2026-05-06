<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kursus_riwayatmodel extends SB_Model
{

	public $table = 'kursus_riwayat';
	public $primaryKey = 'diklat_riwayat_id';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{


		// return "   SELECT kursus_riwayat.diklat_riwayat_id, kursus_riwayat.PEGAWAI_ID, kursus_riwayat.kursus_id_siasn, kursus_riwayat.pnsOrangId, kursus_riwayat.jenisDiklatId, kursus_riwayat.jenisKursus, kursus_riwayat.jenisKursusSertipikat, kursus_riwayat.namaKursus, kursus_riwayat.institusiPenyelenggara, kursus_riwayat.nomorSertipikat, kursus_riwayat.tanggalKursus, kursus_riwayat.tanggalSelesaiKursus, kursus_riwayat.tahunKursus, kursus_riwayat.jumlahJam, kursus_riwayat.rumpunDiklat, kursus_riwayat.instansi, kursus_riwayat.instansiId, kursus_riwayat.lokasi, kursus_riwayat.lokasiId, kursus_riwayat.FILE_PDF, kursus_riwayat.dok_id, kursus_riwayat.dok_uri, kursus_riwayat.dok_nama, kursus_riwayat.object, kursus_riwayat.slug, kursus_riwayat.update_by, kursus_riwayat.insert_by, kursus_riwayat.insert_date FROM kursus_riwayat   ";
		return "   SELECT kursus_riwayat.* FROM kursus_riwayat   ";
	}
	public static function queryWhere()
	{

		return "  WHERE kursus_riwayat.diklat_riwayat_id IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}
}
