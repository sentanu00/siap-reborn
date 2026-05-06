<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epusulanpemberhentianpegawaimodel extends SB_Model 
{

	public $table = 'ep_tx_usulan_pemberhentian_detail';
	public $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "   SELECT ep_tx_usulan_pemberhentian_detail.* FROM  vw_usulan_detail_pegawai as ep_tx_usulan_pemberhentian_detail   ";
	}
	public static function queryWhere(  ){
		
		return "  WHERE ep_tx_usulan_pemberhentian_detail.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "   ";
	}

	public static function querySyarat(){
		return "SELECT * FROM ep_ms_persyaratan ORDER BY urutan ASC";
	}

	public static function querySuamiistri($pegawai_id){
		return "SELECT a.*,ifnull(b.hak_pensiun,0) as hak_pensiun FROM suami_istri as a LEFT JOIN (SELECT * FROM ep_tx_usulan_pemberhentain_detail_keluarga WHERE jenis_data = 1) as b ON a.SUAMI_ISTRI_ID=b.suami_istri_id  WHERE a.PEGAWAI_ID = '$pegawai_id'";
	}

	public static function queryAnak($pegawai_id){
		return "SELECT a.*,ifnull(b.hak_pensiun,0) as hak_pensiun FROM anak as a LEFT JOIN (SELECT * FROM ep_tx_usulan_pemberhentain_detail_keluarga WHERE jenis_data = 2) as b ON a.ANAK_ID=b.anak_id WHERE a.PEGAWAI_ID = '$pegawai_id' ORDER BY TANGGAL_LAHIR ASC";
	}

	public static function queryBiodatapegawaiNIP($nip)
	{
		return "SELECT * FROM (SELECT a.`PEGAWAI_ID`,a.NIP_BARU,
		IFNULL(a.GELAR_DEPAN,'') AS GELAR_DEPAN,a.NAMA,IFNULL(a.GELAR_BELAKANG,'') AS GELAR_BELAKANG,
		d.NAMA AS JABATAN,
		e.PANGKAT,
		e.GOLONGAN_PANGKAT,
		e.TMT_PANGKAT,
		FLOOR(TIMESTAMPDIFF(MONTH,e.`TMT_PANGKAT`,NOW())/12) AS MS_PANGKAT_THN,MOD(TIMESTAMPDIFF(MONTH,e.`TMT_PANGKAT`,NOW()),12) AS MS_PANGKAT_BLN,
		sa.NAMA AS NAMA_SATKER ,
		unor.NAMA AS NAMA_UNOR,
		cpns.`TMT_CPNS`,
		pns.`TMT_PNS`,
		FLOOR(TIMESTAMPDIFF(MONTH,pns.`TMT_PNS`,NOW())/12) AS MS_PNS_THN,MOD(TIMESTAMPDIFF(MONTH,pns.`TMT_PNS`,NOW()),12) AS MS_PNS_BLN,
		a.`TANGGAL_PENSIUN`,
		FLOOR(TIMESTAMPDIFF(MONTH,pns.`TMT_PNS`,a.`TANGGAL_PENSIUN`)/12) AS MS_PENSIUN_THN,MOD(TIMESTAMPDIFF(MONTH,pns.`TMT_PNS`,a.`TANGGAL_PENSIUN`),12) AS MS_PENSIUN_BLN,
		tp.`NAMA` AS TIPE_PEGAWAI,
		gj.GAJI_POKOK,
		gj.THN_GAJI AS GAJI_THN,
		pr.SEKOLAH,pr.THN_LULUS
		FROM pegawai a
		LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
		LEFT JOIN (SELECT PEGAWAI_ID,pa.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,pb.NAMA AS PANGKAT,pb.KODE AS GOLONGAN_PANGKAT FROM `pangkat_riwayat` pa INNER JOIN pangkat pb ON pb.PANGKAT_ID=pa.PANGKAT_ID WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID
		LEFT JOIN (SELECT PEGAWAI_ID,YEAR(TMT_SK) AS THN_GAJI,GAJI_POKOK FROM gaji_riwayat WHERE FLAG_DATA_TERAKHIR=1 ORDER BY TMT_SK DESC) gj ON gj.PEGAWAI_ID=a.`PEGAWAI_ID`
		LEFT JOIN (SELECT PEGAWAI_ID,NAMA AS SEKOLAH,YEAR(TANGGAL_STTB) AS THN_LULUS FROM pendidikan_riwayat WHERE FLAG_DATA_TERAKHIR = 1 ORDER BY TANGGAL_STTB DESC) pr ON pr.PEGAWAI_ID=a.`PEGAWAI_ID`
		LEFT JOIN sk_cpns AS cpns ON cpns.`PEGAWAI_ID`=a.`PEGAWAI_ID`
		LEFT JOIN sk_pns AS pns ON pns.`PEGAWAI_ID`=a.`PEGAWAI_ID`
		INNER JOIN satker sa ON sa.`SATKER_ID`=a.`SATKER_INDUK_ID`
		INNER JOIN satker unor ON unor.`SATKER_ID`=a.`SATKER_ID`
		INNER JOIN tipe_pegawai tp ON tp.`TIPE_PEGAWAI_ID`=a.`TIPE_PEGAWAI_ID`
		WHERE a.NIP_BARU ='$nip') AS pegawai";
	}
	
}

?>
