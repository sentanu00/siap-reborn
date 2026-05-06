<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reportbiodata extends SB_Controller
{
	function cetakfip01($id)
	{
		$this->load->model('biodatamodel');
		$this->model = $this->biodatamodel;
		include APPPATH . "/third_party/PHPExcel/IOFactory.php";
		$objPHPexcel = PHPExcel_IOFactory::load('templateXLS/fip01.xlsx');
		$objPHPexcel->getProperties()->setCreator("SIAP BKPD KAB. PROBOLINGGO " . date('Y'));
		$styleArrayFontBold = array(
			'font' => array(
				'bold' => TRUE
			),
		);
		$start = 9;
		$col = 'H';

		$pegawai = $this->model->datapegawai($id);
		$cpns = $this->model->dataskcpns($id);
		$pns = $this->model->dataskpns($id);
		$pangkat = $this->model->pangkatterakhir($id);
		$gaji = $this->model->gajiterakhir($id);
		$jabatan = $this->model->jabatanterakhir($id);
		$pendidikan = $this->model->pendidikanterakhir($id);

		//var_dump($pegawai);

		$objWorksheet = $objPHPexcel->getActiveSheet();
		$field = array(
			'PROPINSI_SATKER', 'KABUPATEN_SATKER', 'KECAMATAN_SATKER', 'KELURAHAN_SATKER',
			'ALAMAT_SATKER', 'TELEPON_SATKER', 'KODEPOS_SATKER', 'NAMA_SATKER', 'SATKER_INDUK',
			'NIP_LAMA', 'NIP_BARU', 'NAMA', 'GELAR_DEPAN', 'GELAR_BELAKANG', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR',
			'JENIS_KELAMIN', 'AGAMA', 'STATUS_PEGAWAI', 'JENIS_PEGAWAI', 'KEDUDUKAN', 'STATUS_KAWIN', 'SUKU_BANGSA',
			'GOLONGAN_DARAH', 'ALAMAT', 'RTRW', 'KELURAHAN', 'KECAMATAN', 'KABUPATEN', 'PROPINSI', 'KODEPOS',
			'KARTU_PEGAWAI', 'ASKES', 'TASPEN', 'SUAMIISTRI', 'NPWP', 'NIK', 'NAMA_INSTANSI', 'JABATAN_INSTANSI',
			'MASA_KERJA_INSTANSI', 'TANGGAL_KERJA', 'NOTA_CPNS', 'TANGGAL_NOTA_CPNS', 'PEJABAT_PENETAP_CPNS', 'NO_SK_CPNS',
			'TANGGAL_SK_CPNS', 'TMT_CPNS', 'GOL_RUANG_CPNS', 'TANGGAL_TUGAS_CPNS', 'NO_STTPP', 'TANGGAL_STTPP_CPNS',
			'PEJABAT_PENETAP_PNS', 'NO_SK_PNS', 'TANGGAL_SK_PNS', 'TMT_PNS', 'GOL_RUANG_PNS', 'TANGGAL_SUMPAH', 'STLUD',
			'NO_STLUD', 'TANGGAL_STLUD', 'NO_NOTA', 'TANGGAL_NOTA', 'KREDIT', 'JABATANPENETAP', 'SK_PANGKAT',
			'TANGGAL_SK_PANGKAT', 'TMT_PANGKAT', 'GOL_RUANG_PANGKAT', 'JENIS_KP', 'MASA_KERJA_PANGKAT', 'NO_SK_KGB', 'TANGGAL_SK_KGB',
			'TMT_SK_KGB', 'GOL_RUANG_KGB', 'GAJI_POKOK', 'WILAYAH', 'KTUA', 'PENDIDIKAN', 'JURUSAN', 'NAMA_SEKOLAH',
			'TEMPAT', 'NAMA_DIK_STRUK', 'NAMA_DIK_FUNGS', 'NAMA_DIK_TEKNIS', 'PENATARAN', 'SEMINAR', 'PENETAP_JABATAN',
			'NO_SK_JABATAN', 'TANGGAL_SK_JABATAN', 'JABATAN', 'ESELON', 'TMT_ESELON', 'NO_PELANTIKAN', 'TANGGAL_PELANTIKAN'
		);

		for ($i = 0; $i < count($field); $i++) {
			$val = '';
			$coltab = $field[$i];
			if (isset($pegawai->$coltab)) $val = $pegawai->$coltab;
			if (isset($cpns->$coltab)) $val = $cpns->$coltab;
			if (isset($pns->$coltab)) $val = $pns->$coltab;
			if (isset($pangkat->$coltab)) $val = $pangkat->$coltab;
			if (isset($gaji->$coltab)) $val = $gaji->$coltab;
			if (isset($jabatan->$coltab)) $val = $jabatan->$coltab;
			if (isset($pendidikan->$coltab)) $val = $pendidikan->$coltab;

			$objWorksheet->setCellValue($col . $start, $val);
			if ($start == 23) $objWorksheet->getStyle($col . $start)->getNumberFormat()->setFormatCode('00');

			elseif ($start == 49) $objWorksheet->setCellValue($col . $start, " " . $val);
			elseif ($start == 48) $objWorksheet->setCellValue($col . $start, " " . $val);

			if ($start == 16)
				$start += 5;
			elseif ($start == 49)
				$start += 5;
			elseif ($start == 57)
				$start += 6;
			elseif ($start == 72)
				$start += 5;
			elseif ($start == 82)
				$start += 5;
			elseif ($start == 99)
				$start += 6;
			elseif ($start == 111)
				$start += 5;
			elseif ($start == 124)
				$start += 5;
			elseif ($start == 133)
				$start += 2;
			elseif ($start == 135)
				$start += 2;
			else
				$start += 1;
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$filename = "FIP01-" . $pegawai->NAMA . ".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		//$objWriter->save($this->session->userdata('uid').'-FIP01.xlsx');
		$objWriter->save('php://output');
	}

	function cetakbiodata_bak($id)
	{
		$this->load->model('biodatamodel');
		$this->model = $this->biodatamodel;
		include APPPATH . "/third_party/PHPExcel/IOFactory.php";

		// tempat template biodata
		$objPHPexcel = PHPExcel_IOFactory::load('templateXLS/BiodataLengkap.xlsx');
		$objPHPexcel->getProperties()->setCreator("SIAP BKPD KAB. PROBOLINGGO " . date('Y'));
		$styleArrayFontBold = array(
			'font' => array(
				'bold' => TRUE
			),
		);
		// $start = 9;
		// $col = 'H';

		// $pegawai = $this->model->datapegawai($id);
		// $cpns = $this->model->dataskcpns($id);
		// $pns = $this->model->dataskpns($id);
		// $pangkat = $this->model->pangkatterakhir($id);
		// $gaji = $this->model->gajiterakhir($id);
		// $jabatan = $this->model->jabatanterakhir($id);
		// $pendidikan = $this->model->pendidikanterakhir($id);

		//var_dump($pegawai);

		$objWorksheet = $objPHPexcel->getActiveSheet();
		$objWorksheet->freezePane('A7');
		$field = array('NIP_LAMA', 'NIP_BARU', 'NAMA', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR', 'AGAMA', 'GOL_RUANG', 'TMT_PANGKAT', '', 'PENDIDIKAN', 'JURUSAN', 'NAMA_SEKOLAH', 'TAHUN', 'JABATAN', 'ALAMAT');

		for ($i = 0; $i < count($field); $i++) {
			$val = '';
			$coltab = $field[$i];
			if (isset($pegawai->$coltab)) $val = $pegawai->$coltab;
			if (isset($cpns->$coltab)) $val = $cpns->$coltab;
			if (isset($pns->$coltab)) $val = $pns->$coltab;
			if (isset($pangkat->$coltab)) $val = $pangkat->$coltab;
			if (isset($gaji->$coltab)) $val = $gaji->$coltab;
			if (isset($jabatan->$coltab)) $val = $jabatan->$coltab;
			if (isset($pendidikan->$coltab)) $val = $pendidikan->$coltab;

			$objWorksheet->setCellValue($col . $start, $val);
			if ($start == 23) $objWorksheet->getStyle($col . $start)->getNumberFormat()->setFormatCode('00');

			elseif ($start == 49) $objWorksheet->setCellValue($col . $start, " " . $val);
			elseif ($start == 48) $objWorksheet->setCellValue($col . $start, " " . $val);

			if ($start == 16)
				$start += 5;
			elseif ($start == 49)
				$start += 5;
			elseif ($start == 57)
				$start += 6;
			elseif ($start == 72)
				$start += 5;
			elseif ($start == 82)
				$start += 5;
			elseif ($start == 99)
				$start += 6;
			elseif ($start == 111)
				$start += 5;
			elseif ($start == 124)
				$start += 5;
			elseif ($start == 133)
				$start += 2;
			elseif ($start == 135)
				$start += 2;
			else
				$start += 1;
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$filename = "Biodata-" . $pegawai->NIP_BARU . "-" . $pegawai->NAMA . date('Ymd') . ".xlsx";
		header('Content-Type: application/vnd.ms-excel'); // convert file ke excel
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //baris untuk memberi nama file
		header('Cache-Control: max-age=0');
		//$objWriter->save($this->session->userdata('uid').'-FIP01.xlsx');
		$objWriter->save('php://output');
	}

	function cetakbiodata($id)
	{
		// $this->load->model('pegawaimodel');
		// $this->model = $this->pegawaimodel;

		// $filter = " AND SATKER_ID LIKE '$satker%'";

		// $row = $this->model->getlaporan($filter, '')->result();
		// $satker = $this->db->query("SELECT * FROM satker WHERE SATKER_ID = '$satker'")->row();
		// $this->data['row'] = $row;
		// $this->data['ttd'] = $this->model->getlaporan('', " AND PEGAWAI_ID = '$idttd'")->row();
		// $this->data['satker_nama'] = $satker->NAMA;
		$pegawai = $this->db->query("select 
		p.NIP_BARU, 
		p.NAMA, 
		p.GELAR_DEPAN,
		p.GELAR_BELAKANG,
		p.TEMPAT_LAHIR, 
		DATE_FORMAT(p.TANGGAL_LAHIR, '%d-%m-%Y') AS TANGGAL_LAHIR, 
		a.NAMA as AGAMA, 
		p.ALAMAT, 
		p.PROPINSI_ID,
		p.KABUPATEN_ID,
		p.KECAMATAN_ID,
		p.KELURAHAN_ID,
		pa.KODE as Pangkat_Terakhir,
		DATE_FORMAT(pr.TMT_PANGKAT, '%d-%m-%Y') AS	 TMT_Pangkat_Terakhir,
		pdd.NAMA as Tingkat_Pendidikan,
		pd.JURUSAN,
		pd.TEMPAT as Sekolah,
		YEAR(pd.TANGGAL_STTB)	 as Tahun_Lulus,
		jr.NAMA as Jabatan_Terakhir,
		DATE_FORMAT(p.TANGGAL_PENSIUN, '%d-%m-%Y') as TMT_PENSIUN
		
		
		from pegawai as p
		join agama as a on p.AGAMA_ID = a.AGAMA_ID
		join pangkat_riwayat as pr on p.PANGKAT_ID_TERAKHIR = pr.PANGKAT_RIWAYAT_ID
		join pangkat as pa on pr.PANGKAT_ID = pa.PANGKAT_ID
		join jabatan_riwayat as jr on p.JABATAN_ID_TERAKHIR = jr.JABATAN_RIWAYAT_ID
		join pendidikan_riwayat as pd on p.PENDIDIKAN_ID_TERAKHIR = pd.PENDIDIKAN_RIWAYAT_ID
		join pendidikan as pdd on pd.PENDIDIKAN_ID = pdd.PENDIDIKAN_ID
		where p.PEGAWAI_ID =  '$id'")->row();

		$r_pangkat = $this->db->query("select 
		pa.KODE as gol_ruang,
		DATE_FORMAT(p.TMT_PANGKAT, '%d-%m-%Y') as TMT_PANGKAT,
		p.NO_SK,
		DATE_FORMAT(p.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK,
		p.PEJABAT_PENETAP
		from pangkat_riwayat as p 
		join pangkat as pa on p.PANGKAT_ID = pa.PANGKAT_ID 
		where p.PEGAWAI_ID = '$id'
		order by p.TMT_PANGKAT");
		$rp_results = $r_pangkat->result_array();


		$r_jabatan = $this->db->query("select 
		j.NAMA, 
		DATE_FORMAT(j.TMT_JABATAN, '%d-%m-%Y') as TMT_JABATAN,
		j.NO_SK,
		DATE_FORMAT(j.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK,
		j.PEJABAT_PENETAP
		from jabatan_riwayat as j 
		where j.PEGAWAI_ID = '$id' 
		order by j.TMT_JABATAN");
		$rj_results = $r_jabatan->result_array();

		$r_pendidikan = $this->db->query("SELECT 
		p.jurusan, 
		p.TEMPAT, 
		p.KEPALA, 
		p.NO_STTB, 
		DATE_FORMAT(p.TANGGAL_STTB, '%d-%m-%Y') as TANGGAL_STTB
		From pendidikan_riwayat as p 
		where p.PEGAWAI_ID = '$id' 
		order by p.TANGGAL_STTB");
		$rpen_results = $r_pendidikan->result_array();

		$r_dikstruk = $this->db->query("select 
		dx.KETERANGAN as NAMA_DIKLAT,
		concat(d.PENYELENGGARA, ' ',d.TEMPAT) as TEMPAT,
		d.ANGKATAN,
		d.NO_STTPP,
		DATE_FORMAT(d.TANGGAL_STTPP, '%d-%m-%Y') as TANGGAL_STTPP
		from diklat_struktural as d 
		join diklat as dx on d.DIKLAT_ID = dx.DIKLAT_ID
		where d.PEGAWAI_ID = '$id' 
		order by d.TANGGAL_STTPP");
		$rdikstruk_results = $r_dikstruk->result_array();


		$r_dikfugn = $this->db->query("select 
		d.NAMA,
		concat(d.PENYELENGGARA, ' ', d.TEMPAT) as TEMPAT,
		d.ANGKATAN,
		d.NO_STTPP, 
		DATE_FORMAT(d.TANGGAL_STTPP, '%d-%m-%Y') as TANGGAL_STTPP
		from diklat_fungsional as d
		where d.PEGAWAI_ID = '$id'
		order by d.TANGGAL_STTPP");
		$rdikfung_results = $r_dikfugn->result_array();

		$r_diktek = $this->db->query("select 
		d.NAMA,
		concat(d.PENYELENGGARA, ' ', d.TEMPAT) as TEMPAT,
		d.ANGKATAN,
		d.NO_STTPP, 
		DATE_FORMAT(d.TANGGAL_STTPP, '%d-%m-%Y') as TANGGAL_STTPP
		from diklat_teknis as d
		where d.PEGAWAI_ID = '$id'
		order by d.TANGGAL_STTPP");
		$rdiktek_results = $r_diktek->result_array();


		$r_penataran = $this->db->query("select 
		d.NAMA,
		concat(d.PENYELENGGARA, ' ', d.TEMPAT) as TEMPAT,
		d.TANGGAL_SELESAI,
		d.NO_PIAGAM, 
		DATE_FORMAT(d.TANGGAL_PIAGAM, '%d-%m-%Y') as TANGGAL_PIAGAM
		from penataran as d
		where d.PEGAWAI_ID = '$id'
		order by d.TANGGAL_PIAGAM");
		$rpenataran_results = $r_penataran->result_array();

		$r_seminar = $this->db->query("select 
		d.NAMA,
		concat(d.PENYELENGGARA, ' ', d.TEMPAT) as TEMPAT,
		d.TANGGAL_SELESAI,
		d.NO_PIAGAM, 
		DATE_FORMAT(d.TANGGAL_PIAGAM, '%d-%m-%Y') as TANGGAL_PIAGAM
		from penataran_seminar as d
		where d.PEGAWAI_ID = '$id'
		order by d.TANGGAL_PIAGAM");
		$rseminar_results = $r_seminar->result_array();

		$r_orangtua = $this->db->query("select 
		o.JENIS_KELAMIN,
		o.NAMA, 
		o.TEMPAT_LAHIR,
		o.PEKERJAAN, 
		o.ALAMAT, 
		o.TELEPON,
		prop.NAMA as PROVINSI,
		kab.NAMA AS KABUPATEN, 
		kec.NAMA AS KECAMATAN, 
		kel.NAMA AS KELURAHAN,
		o.KODEPOS
		from orang_tua as o 
		join propinsi as prop on o.PROPINSI_ID = prop.PROPINSI_ID
		join kabupaten as kab on o.KABUPATEN_ID = kab.KABUPATEN_ID and o.PROPINSI_ID = kab.PROPINSI_ID
		JOIN kecamatan as kec on o.KECAMATAN_ID = kec.KECAMATAN_ID and o.KABUPATEN_ID = kec.KABUPATEN_ID and o.PROPINSI_ID = kec.PROPINSI_ID
		join kelurahan as kel on o.KELURAHAN_ID = kel.KELURAHAN_ID and o.KECAMATAN_ID = kel.KECAMATAN_ID and o.KABUPATEN_ID = kel.KABUPATEN_ID and o.PROPINSI_ID = kel.PROPINSI_ID
		where o.PEGAWAI_ID = '$id'
		group by o.JENIS_KELAMIN 
		order by o.JENIS_KELAMIN");
		$r_orangtua = $r_orangtua->result_array();

		$r_mertua = $this->db->query("select 
		o.JENIS_KELAMIN,
		o.NAMA, 
		o.TEMPAT_LAHIR,
		o.PEKERJAAN, 
		o.ALAMAT, 
		o.TELEPON,
		prop.NAMA as PROVINSI,
		kab.NAMA AS KABUPATEN, 
		kec.NAMA AS KECAMATAN, 
		kel.NAMA AS KELURAHAN,
		o.KODEPOS
		from mertua3 as o 
		join propinsi as prop on o.PROPINSI_ID = prop.PROPINSI_ID
		join kabupaten as kab on o.KABUPATEN_ID = kab.KABUPATEN_ID and o.PROPINSI_ID = kab.PROPINSI_ID
		JOIN kecamatan as kec on o.KECAMATAN_ID = kec.KECAMATAN_ID and o.KABUPATEN_ID = kec.KABUPATEN_ID and o.PROPINSI_ID = kec.PROPINSI_ID
		join kelurahan as kel on o.KELURAHAN_ID = kel.KELURAHAN_ID and o.KECAMATAN_ID = kel.KECAMATAN_ID and o.KABUPATEN_ID = kel.KABUPATEN_ID and o.PROPINSI_ID = kel.PROPINSI_ID
		where o.PEGAWAI_ID = '$id'
		group by o.JENIS_KELAMIN 
		order by o.JENIS_KELAMIN");
		$r_mertua = $r_mertua->result_array();


		$r_pasangan = $this->db->query("select 
		s.NAMA,
		concat(s.TEMPAT_LAHIR,', ',s.TANGGAL_LAHIR) as TTL,
		p.NAMA as PENDIDIKAN,
		s.TANGGAL_KAWIN,
		s.STATUS_TUNJANGAN,
		s.PEKERJAAN
		from suami_istri as s 
		join pendidikan as p on s.PENDIDIKAN_ID = p.PENDIDIKAN_ID
		where s.PEGAWAI_ID = '$id'");
		$r_pasangan = $r_pasangan->result_array();



		$r_anak = $this->db->query("
		SELECT
			s.NAMA,
			CONCAT(s.TEMPAT_LAHIR, ', ', s.TANGGAL_LAHIR) AS TTL,
			s.JENIS_KELAMIN,
			CASE s.STATUS_KELUARGA
				WHEN '1' THEN 'kandung'
				WHEN '2' THEN 'tiri'
				WHEN '3' THEN 'angkat'
				ELSE 'lainnya'
			END AS STATUS_KELUARGA,
			s.STATUS_TUNJANGAN,
			p.NAMA AS PENDIDIKAN
		FROM
			anak AS s
		JOIN
			pendidikan AS p ON s.PENDIDIKAN_ID = p.PENDIDIKAN_ID
		WHERE
			s.PEGAWAI_ID = '$id'");
		$r_anak = $r_anak->result_array();

		// baru
		$r_organisasi = $this->db->query("select
		p.NAMA,
		p.JABATAN,
		CONCAT(
			FLOOR(TIMESTAMPDIFF(MONTH, p.TANGGAL_AKHIR, p.TANGGAL_AWAL) / 12), ' tahun ',
			TIMESTAMPDIFF(MONTH, p.TANGGAL_AKHIR, p.TANGGAL_AWAL) % 12, ' bulan'
		  ) AS selisih_tanggal,
		p.PIMPINAN,
		p.TEMPAT
		from organisasi_riwayat as p where p.PEGAWAI_ID = '$id'");
		$organisasi_results = $r_organisasi->result_array();

		$r_penghargaan = $this->db->query("select 
		p.NAMA,
		p.NO_SK,
		DATE_FORMAT(p.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK,
		p.PEJABAT_PENETAP as PIMPINAN,
		p.TAHUN
		from penghargaan as p where p.PEGAWAI_ID = '$id'");
		$penghargaan_results = $r_penghargaan->result_array();

		$r_skplama = $this->db->query("SELECT
		p.TAHUN, 
		p.KESETIAAN AS N1,
		p.PRESTASI AS N2,
		p.TANGGUNG_JAWAB AS N3,
		p.KETAATAN AS N4,
		p.KEJUJURAN AS N5,
		p.KERJASAMA AS N6,
		p.PRAKARSA AS N7,
		p.KEPEMIMPINAN AS N8,
		  (IFNULL(p.KESETIAAN, 0) + IFNULL(p.TANGGUNG_JAWAB, 0) + IFNULL(p.KETAATAN, 0) + IFNULL(p.KEJUJURAN, 0) + IFNULL(p.KERJASAMA, 0) + IFNULL(p.PRAKARSA, 0) + IFNULL(p.KEPEMIMPINAN, 0)) AS JUMLAH,
		  round(((IFNULL(p.KESETIAAN, 0) + IFNULL(p.TANGGUNG_JAWAB, 0) + IFNULL(p.KETAATAN, 0) + IFNULL(p.KEJUJURAN, 0) + IFNULL(p.KERJASAMA, 0) + IFNULL(p.PRAKARSA, 0) + IFNULL(p.KEPEMIMPINAN, 0))/7),2) AS RATARATA
	  FROM
		penilaian AS p
	  WHERE
		p.PEGAWAI_ID =  '$id'");
		$skplama_results = $r_skplama->result_array();

		$r_hukdis = $this->db->query("select
		j.NAMA as JENIS_PELANGGARAN,
		h.KETERANGAN as DETAIL_PELANGGARAN,
		h.NO_SK,
		DATE_FORMAT(h.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK,
		h.PEJABAT_PENETAP
		from hukuman as h
		join jenis_hukuman as j on h.JENIS_HUKUMAN_ID = j.JENIS_HUKUMAN_ID
		where h.PEGAWAI_ID = '$id'");
		$hukdis_results = $r_hukdis->result_array();

		$r_cuti = $this->db->query("SELECT
		DATE_FORMAT(c.TANGGAL_SURAT, '%Y') as TAHUN,
		CASE
		  WHEN c.JENIS_CUTI = 1 THEN 'Cuti Tahunan'
		  WHEN c.JENIS_CUTI = 2 THEN 'Cuti Besar'
		  WHEN c.JENIS_CUTI = 3 THEN 'Cuti Sakit'
		  WHEN c.JENIS_CUTI = 4 THEN 'Cuti Bersalin'
		  WHEN c.JENIS_CUTI = 5 THEN 'CLTN'
		  WHEN c.JENIS_CUTI = 6 THEN 'Perpanjang CLTN'
		  WHEN c.JENIS_CUTI = 7 THEN 'Cuti Menikah'
		  ELSE 'Unknown' 
		END as JENIS_CUTI,
		c.NO_SURAT,
		  
		DATE_FORMAT(c.TANGGAL_SURAT, '%d-%m-%Y') as TANGGAL_SURAT,
		DATE_FORMAT(c.TANGGAL_MULAI, '%d-%m-%Y') as AWAL_CUTI,
		DATE_FORMAT(c.TANGGAL_SELESAI, '%d-%m-%Y') as AKHIR_CUTI,
		c.KETERANGAN
	  FROM
		cuti AS c
	  WHERE
		c.PEGAWAI_ID = '$id'");
		$cuti_results = $r_cuti->result_array();



		$this->data['NIP_BARU'] = $pegawai->NIP_BARU;
		$this->data['Nama'] = $pegawai->NAMA;
		$this->data['GELAR_DEPAN'] = $pegawai->GELAR_DEPAN;
		$this->data['GELAR_BELAKANG'] = $pegawai->GELAR_BELAKANG;
		$this->data['Tempat_Lahir'] = $pegawai->TEMPAT_LAHIR;
		$this->data['Tanggal_Lahir'] = $pegawai->TANGGAL_LAHIR;
		$this->data['Agama'] = $pegawai->AGAMA;
		$this->data['Alamat'] = $pegawai->ALAMAT;
		$this->data['Pangkat_Terakhir'] = $pegawai->Pangkat_Terakhir;
		$this->data['TMT_Pangkat_Terakhir'] = $pegawai->TMT_Pangkat_Terakhir;
		$this->data['Tingkat_Pendidikan'] = $pegawai->Tingkat_Pendidikan;
		$this->data['Jurusan'] = $pegawai->JURUSAN;
		$this->data['Sekolah'] = $pegawai->Sekolah;
		$this->data['Tahun_Lulus'] = $pegawai->Tahun_Lulus;
		$this->data['Jabatan_Terakhir'] = $pegawai->Jabatan_Terakhir;
		$this->data['tmt_pensiun'] = $pegawai->TMT_PENSIUN;
		$this->data['ID'] = $id;

		$this->data['RPangkat'] = $rp_results;
		$this->data['RJabatan'] = $rj_results;
		$this->data['RPendidikan'] = $rpen_results;
		$this->data['Rdikstruk'] = $rdikstruk_results;
		$this->data['Rdikfung'] = $rdikfung_results;
		$this->data['Rdiktek'] = $rdiktek_results;
		$this->data['Rpenataran'] = $rpenataran_results;
		$this->data['Rseminar'] = $rseminar_results;
		$this->data['Rorangtua'] = $r_orangtua;
		$this->data['Rmertua'] = $r_mertua;
		$this->data['Rpasangan'] = $r_pasangan;
		$this->data['Ranak'] = $r_anak;


		$this->data['Rorganisasi'] = $organisasi_results;
		$this->data['Rpenghargaan'] = $penghargaan_results;
		$this->data['Rskplama'] = $skplama_results;
		$this->data['Rhukdis'] = $hukdis_results;
		$this->data['Rcuti'] = $cuti_results;

		echo $this->load->view('pegawai/biodata', $this->data, true);
	}


	function cetakbiodatasingkat($id)
	{
		// $this->load->model('pegawaimodel');
		// $this->model = $this->pegawaimodel;

		// $filter = " AND SATKER_ID LIKE '$satker%'";

		// $row = $this->model->getlaporan($filter, '')->result();
		// $satker = $this->db->query("SELECT * FROM satker WHERE SATKER_ID = '$satker'")->row();
		// $this->data['row'] = $row;
		// $this->data['ttd'] = $this->model->getlaporan('', " AND PEGAWAI_ID = '$idttd'")->row();
		// $this->data['satker_nama'] = $satker->NAMA;
		$pegawai = $this->db->query("select 
		p.NIP_BARU, 
		p.NAMA, 
		p.GELAR_DEPAN,
		p.GELAR_BELAKANG,
		p.TEMPAT_LAHIR, 
		DATE_FORMAT(p.TANGGAL_LAHIR, '%d-%m-%Y') AS TANGGAL_LAHIR, 
		a.NAMA as AGAMA, 
		p.ALAMAT, 
		p.PROPINSI_ID,
		p.KABUPATEN_ID,
		p.KECAMATAN_ID,
		p.KELURAHAN_ID,
		pa.KODE as Pangkat_Terakhir,
		DATE_FORMAT(pr.TMT_PANGKAT, '%d-%m-%Y') AS	 TMT_Pangkat_Terakhir,
		pdd.NAMA as Tingkat_Pendidikan,
		pd.JURUSAN,
		pd.TEMPAT as Sekolah,
		YEAR(pd.TANGGAL_STTB)	 as Tahun_Lulus,
		jr.NAMA as Jabatan_Terakhir,
		DATE_FORMAT(p.TANGGAL_PENSIUN, '%d-%m-%Y') as TMT_PENSIUN
		
		
		from pegawai as p
		join agama as a on p.AGAMA_ID = a.AGAMA_ID
		join pangkat_riwayat as pr on p.PANGKAT_ID_TERAKHIR = pr.PANGKAT_RIWAYAT_ID
		join pangkat as pa on pr.PANGKAT_ID = pa.PANGKAT_ID
		join jabatan_riwayat as jr on p.JABATAN_ID_TERAKHIR = jr.JABATAN_RIWAYAT_ID
		join pendidikan_riwayat as pd on p.PENDIDIKAN_ID_TERAKHIR = pd.PENDIDIKAN_RIWAYAT_ID
		join pendidikan as pdd on pd.PENDIDIKAN_ID = pdd.PENDIDIKAN_ID
		where p.PEGAWAI_ID =  '$id'")->row();

		$r_pangkat = $this->db->query("select 
		pa.KODE as gol_ruang,
		DATE_FORMAT(p.TMT_PANGKAT, '%d-%m-%Y') as TMT_PANGKAT,
		p.NO_SK,
		DATE_FORMAT(p.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK,
		p.PEJABAT_PENETAP
		from pangkat_riwayat as p 
		join pangkat as pa on p.PANGKAT_ID = pa.PANGKAT_ID 
		where p.PEGAWAI_ID = '$id'
		order by p.TMT_PANGKAT");
		$rp_results = $r_pangkat->result_array();


		$r_jabatan = $this->db->query("select 
		j.NAMA, 
		DATE_FORMAT(j.TMT_JABATAN, '%d-%m-%Y') as TMT_JABATAN,
		j.NO_SK,
		DATE_FORMAT(j.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK,
		j.PEJABAT_PENETAP
		from jabatan_riwayat as j 
		where j.PEGAWAI_ID = '$id' 
		order by j.TMT_JABATAN");
		$rj_results = $r_jabatan->result_array();

		$r_pendidikan = $this->db->query("SELECT 
		p.jurusan, 
		p.TEMPAT, 
		p.KEPALA, 
		p.NO_STTB, 
		DATE_FORMAT(p.TANGGAL_STTB, '%d-%m-%Y') as TANGGAL_STTB
		From pendidikan_riwayat as p 
		where p.PEGAWAI_ID = '$id' 
		order by p.TANGGAL_STTB");
		$rpen_results = $r_pendidikan->result_array();


		$r_orangtua = $this->db->query("select 
		o.JENIS_KELAMIN,
		o.NAMA, 
		o.TEMPAT_LAHIR,
		o.PEKERJAAN, 
		o.ALAMAT, 
		o.TELEPON,
		prop.NAMA as PROVINSI,
		kab.NAMA AS KABUPATEN, 
		kec.NAMA AS KECAMATAN, 
		kel.NAMA AS KELURAHAN,
		o.KODEPOS
		from orang_tua as o 
		join propinsi as prop on o.PROPINSI_ID = prop.PROPINSI_ID
		join kabupaten as kab on o.KABUPATEN_ID = kab.KABUPATEN_ID and o.PROPINSI_ID = kab.PROPINSI_ID
		JOIN kecamatan as kec on o.KECAMATAN_ID = kec.KECAMATAN_ID and o.KABUPATEN_ID = kec.KABUPATEN_ID and o.PROPINSI_ID = kec.PROPINSI_ID
		join kelurahan as kel on o.KELURAHAN_ID = kel.KELURAHAN_ID and o.KECAMATAN_ID = kel.KECAMATAN_ID and o.KABUPATEN_ID = kel.KABUPATEN_ID and o.PROPINSI_ID = kel.PROPINSI_ID
		where o.PEGAWAI_ID = '$id'
		group by o.JENIS_KELAMIN 
		order by o.JENIS_KELAMIN");
		$r_orangtua = $r_orangtua->result_array();


		$r_pasangan = $this->db->query("select 
		s.NAMA,
		concat(s.TEMPAT_LAHIR,', ',s.TANGGAL_LAHIR) as TTL,
		p.NAMA as PENDIDIKAN,
		s.TANGGAL_KAWIN,
		s.STATUS_TUNJANGAN,
		s.PEKERJAAN
		from suami_istri as s 
		join pendidikan as p on s.PENDIDIKAN_ID = p.PENDIDIKAN_ID
		where s.PEGAWAI_ID = '$id'");
		$r_pasangan = $r_pasangan->result_array();



		$r_anak = $this->db->query("
		SELECT
			s.NAMA,
			CONCAT(s.TEMPAT_LAHIR, ', ', s.TANGGAL_LAHIR) AS TTL,
			s.JENIS_KELAMIN,
			CASE s.STATUS_KELUARGA
				WHEN '1' THEN 'kandung'
				WHEN '2' THEN 'tiri'
				WHEN '3' THEN 'angkat'
				ELSE 'lainnya'
			END AS STATUS_KELUARGA,
			s.STATUS_TUNJANGAN,
			p.NAMA AS PENDIDIKAN
		FROM
			anak AS s
		JOIN
			pendidikan AS p ON s.PENDIDIKAN_ID = p.PENDIDIKAN_ID
		WHERE
			s.PEGAWAI_ID = '$id'");
		$r_anak = $r_anak->result_array();



		$this->data['NIP_BARU'] = $pegawai->NIP_BARU;
		$this->data['Nama'] = $pegawai->NAMA;
		$this->data['GELAR_DEPAN'] = $pegawai->GELAR_DEPAN;
		$this->data['GELAR_BELAKANG'] = $pegawai->GELAR_BELAKANG;
		$this->data['Tempat_Lahir'] = $pegawai->TEMPAT_LAHIR;
		$this->data['Tanggal_Lahir'] = $pegawai->TANGGAL_LAHIR;
		$this->data['Agama'] = $pegawai->AGAMA;
		$this->data['Alamat'] = $pegawai->ALAMAT;
		$this->data['Pangkat_Terakhir'] = $pegawai->Pangkat_Terakhir;
		$this->data['TMT_Pangkat_Terakhir'] = $pegawai->TMT_Pangkat_Terakhir;
		$this->data['Tingkat_Pendidikan'] = $pegawai->Tingkat_Pendidikan;
		$this->data['Jurusan'] = $pegawai->JURUSAN;
		$this->data['Sekolah'] = $pegawai->Sekolah;
		$this->data['Tahun_Lulus'] = $pegawai->Tahun_Lulus;
		$this->data['Jabatan_Terakhir'] = $pegawai->Jabatan_Terakhir;
		$this->data['tmt_pensiun'] = $pegawai->TMT_PENSIUN;
		$this->data['ID'] = $id;

		$this->data['RPangkat'] = $rp_results;
		$this->data['RJabatan'] = $rj_results;
		$this->data['RPendidikan'] = $rpen_results;
		$this->data['Rorangtua'] = $r_orangtua;
		$this->data['Rpasangan'] = $r_pasangan;
		$this->data['Ranak'] = $r_anak;


		echo $this->load->view('pegawai/biodatasingkat', $this->data, true);
	}

	// function popupdata()
	// {
	// 	echo $this->load->view('pegawai/biodata', $this->data, true);
	// }
}
