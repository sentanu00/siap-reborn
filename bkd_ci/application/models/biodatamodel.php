<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Biodatamodel extends SB_Model 
{
	public  function datapegawai($idpeg){
		$pegawai = $this->db->query("SELECT a.`PEGAWAI_ID`,
		NIP_LAMA, NIP_BARU, a.NAMA, GELAR_DEPAN, GELAR_BELAKANG, TEMPAT_LAHIR, TANGGAL_LAHIR,JENIS_KELAMIN,
		GOLONGAN_DARAH,ALAMAT, CONCAT(RT,'/',RW) AS RTRW,KARTU_PEGAWAI,ASKES,TASPEN,NPWP,NIK,
		IF(a.`STATUS_KAWIN`=1,'BELUM KAWIN',IF(a.`STATUS_KAWIN`=2,'KAWIN',IF(a.`STATUS_KAWIN`=3,'JANDA','DUDA'))) AS STATUS_KAWIN,  
		fn_master(3,a.`AGAMA_ID`) AS AGAMA,
		fn_wilayah(1,a.`PROPINSI_ID`,0,0,0)  AS PROPINSI,
		fn_wilayah(2,a.`PROPINSI_ID`,a.KABUPATEN_ID,0,0)  AS KABUPATEN,
		fn_wilayah(3,a.`PROPINSI_ID`,a.KABUPATEN_ID,a.`KECAMATAN_ID`,0) AS KECAMATAN,
		fn_wilayah(3,a.`PROPINSI_ID`,a.KABUPATEN_ID,a.`KECAMATAN_ID`,a.`KELURAHAN_ID`) AS KELURAHAN,
		fn_master(1,a.`JENIS_PEGAWAI_ID`) AS JENIS_PEGAWAI,
		fn_master(4,a.`KEDUDUKAN_ID`) AS KEDUDUKAN,
		fn_master(2,a.`STATUS_PEGAWAI`) AS STATUS_PEGAWAI,
		fn_master(5,a.`SATKER_ID`) AS NAMA_SATKER,
		fn_master(5,LEFT(a.`SATKER_ID`,2)) AS SATKER_INDUK,
		'JAWA TIMUR' AS PROPINSI_SATKER,
		'PROBOLINGGO' AS KABUPATEN_SATKER,
		(SELECT NAMA FROM diklat_fungsional WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TANGGAL_MULAI DESC LIMIT 1) AS NAMA_DIK_FUNGS,
(SELECT PENYELENGGARA AS NAMA FROM diklat_struktural WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TANGGAL_MULAI DESC LIMIT 1) AS NAMA_DIK_STRUK,
(SELECT NAMA FROM diklat_teknis WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TANGGAL_MULAI DESC LIMIT 1) AS NAMA_DIK_TEKNIS,
(SELECT NAMA FROM penataran WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TANGGAL_MULAI DESC LIMIT 1) AS PENATARAN,
(SELECT NAMA FROM seminar WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TANGGAL_MULAI DESC LIMIT 1) AS SEMINAR
		FROM pegawai a WHERE a.PEGAWAI_ID='".$idpeg."'")->row();
		return $pegawai;
	}
	
	public  function dataskcpns($idpeg){
		$cpns = $this->db->query("SELECT NO_NOTA AS NOTA_CPNS,TANGGAL_NOTA AS TANGGAL_NOTA_CPNS,
				PEJABAT_PENETAP AS PEJABAT_PENETAP_CPNS,NO_SK AS NO_SK_CPNS, TANGGAL_SK AS TANGGAL_SK_CPNS,TMT_CPNS,fn_master(6,PANGKAT_ID) AS GOL_RUANG_CPNS,
				TANGGAL_TUGAS AS TANGGAL_TUGAS_CPNS,NO_STTPP,TANGGAL_STTPP AS TANGGAL_STTPP_CPNS FROM `sk_cpns` WHERE PEGAWAI_ID = '".$idpeg."'")->row();
		return $cpns;
	}
	
	public  function dataskpns($idpeg){
		$cpns = $this->db->query("SELECT PEJABAT_PENETAP AS PEJABAT_PENETAP_PNS, NO_SK AS NO_SK_PNS, TANGGAL_SK AS TANGGAL_SK_PNS, TMT_PNS,fn_master(6,PANGKAT_ID) AS GOL_RUANG_PNS, TANGGAL_SUMPAH FROM sk_pns WHERE PEGAWAI_ID = '".$idpeg."'")->row();
		return $cpns;
	}
	
	
	public  function pangkatterakhir($idpeg){
		$cpns = $this->db->query("SELECT NO_STLUD, TANGGAL_STLUD, NO_NOTA, TANGGAL_NOTA, KREDIT, PEJABAT_PENETAP AS JABATANPENETAP, NO_SK AS SK_PANGKAT, 
			   TANGGAL_SK AS TANGGAL_SK_PANGKAT, TMT_PANGKAT,fn_master(6,PANGKAT_ID) AS GOL_RUANG_PANGKAT, JENIS_KP,CONCAT(MASA_KERJA_TAHUN,' Thn ',MASA_KERJA_BULAN,' Bln') AS MASA_KERJA_PANGKAT FROM pangkat_riwayat WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TMT_PANGKAT DESC LIMIT 1")->row();
		return $cpns;
	}
	
	public  function gajiterakhir($idpeg){
		$cpns = $this->db->query("SELECT NO_SK asNO_SK_KGB, TANGGAL_SK AS TANGGAL_SK_KGB, 
			   TMT_SK AS TMT_SK_KGB, fn_master(6,PANGKAT_ID) AS GOL_RUANG_KGB, GAJI_POKOK, WILAYAH, KTUA FROM gaji_riwayat WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TMT_SK DESC LIMIT 1")->row();
		return $cpns;
	}
	
	public  function jabatanterakhir($idpeg){
		$cpns = $this->db->query("SELECT PEJABAT_PENETAP AS PENETAP_JABATAN, NO_SK AS NO_SK_JABATAN, TANGGAL_SK AS TANGGAL_SK_JABATAN, NAMA AS 								JABATAN,fn_master(7,ESELON_ID) AS  ESELON, TMT_ESELON, NO_PELANTIKAN, TANGGAL_PELANTIKAN
			FROM `jabatan_riwayat` WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TMT_JABATAN DESC LIMIT 1")->row();
		return $cpns;
	}
	
	public  function pendidikanterakhir($idpeg){
		$cpns = $this->db->query("SELECT fn_master(8,PENDIDIKAN_ID) AS PENDIDIKAN, fn_master(9,JURUSAN_PENDIDIKAN_ID) AS JURUSAN, NAMA AS NAMA_SEKOLAH, 
			   TEMPAT FROM `pendidikan_riwayat` WHERE PEGAWAI_ID = '".$idpeg."' ORDER BY TANGGAL_STTB DESC LIMIT 1")->row();
		return $cpns;
	}
	
	
	
}