<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Singkron_all extends SB_Controller
{

	// protected $db_orcl;
	// protected $db_mysql;
	// protected $db_psg;


	function __construct()
	{
		parent::__construct();

		$this->load->database('oracle');
		$this->db->initialize();
	}
	public function update_dari_tabel_pegawai_siap_lama($nip_baru)
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');

		$this->load->database('oracle');
		$this->db->initialize();
		// Menggunakan $this->db_oracle untuk operasi pada database Oracle
		$this->db->where('NIP_BARU', $nip_baru);
		$oracleQuery = $this->db->get('pegawai');
		$oracleResult = $oracleQuery->result();

		// Menggunakan $this->db untuk operasi pada database MySQL
		$this->load->database(); // Memuat koneksi default ke database MySQL
		$this->db->where('NIP_BARU', $nip_baru);
		$mysqlQuery = $this->db->get('pegawai');
		$mysqlResult = $mysqlQuery->result();

		// Menggabungkan hasil dari kedua database menjadi satu array
		$result = array(
			'oracle_data' => $oracleResult,
			'mysql_data' => $mysqlResult
		);
		$json = json_encode($result);



		// Mendapatkan tanggal LAST_UPDATE_DATE dari data Oracle
		$oracleLastUpdate = strtotime($result['oracle_data'][0]->LAST_UPDATE_DATE);

		// Mendapatkan tanggal LAST_UPDATE_DATE dari data MySQL
		$mysqlLastUpdate = strtotime($result['mysql_data'][0]->LAST_UPDATE_DATE);

		// Membandingkan tanggal dan menentukan apakah LAST_UPDATE_DATE pada Oracle lebih baru
		if ($oracleLastUpdate > $mysqlLastUpdate) {
			echo "LAST_UPDATE_DATE pada Oracle lebih baru." . $nip_baru . "\n";

			$this->load->database(); // Memuat koneksi default ke database MySQL

			// Persiapkan data untuk diupdate
			$data = array(
				// 'LAST_UPDATE_USER' => $oracleResult->LAST_UPDATE_USER,
				// 'LAST_UPDATE_DATE' => $oracleResult->LAST_UPDATE_DATE,
				// Tambahkan kolom lain yang ingin diupdate

				'PROPINSI_ID' => $oracleResult->PROPINSI_ID,
				'KABUPATEN_ID' => $oracleResult->KABUPATEN_ID,
				'KECAMATAN_ID' => $oracleResult->KECAMATAN_ID,
				'KELURAHAN_ID' => $oracleResult->KELURAHAN_ID,
				'SATKER_ID' => $oracleResult->SATKER_ID,
				'KEDUDUKAN_ID' => $oracleResult->KEDUDUKAN_ID,
				'JENIS_PEGAWAI_ID' => $oracleResult->JENIS_PEGAWAI_ID,
				'BANK_ID' => $oracleResult->BANK_ID,
				'NIP_LAMA' => $oracleResult->NIP_LAMA,
				'NAMA' => $oracleResult->NAMA,
				'GELAR_DEPAN' => $oracleResult->GELAR_DEPAN,
				'GELAR_BELAKANG' => $oracleResult->GELAR_BELAKANG,
				'TEMPAT_LAHIR' => $oracleResult->TEMPAT_LAHIR,
				'TANGGAL_LAHIR' => $oracleResult->TANGGAL_LAHIR,
				'JENIS_KELAMIN' => $oracleResult->JENIS_KELAMIN,
				'STATUS_KAWIN' => $oracleResult->STATUS_KAWIN,
				'SUKU_BANGSA' => $oracleResult->SUKU_BANGSA,
				'GOLONGAN_DARAH' => $oracleResult->GOLONGAN_DARAH,
				'EMAIL' => $oracleResult->EMAIL,
				'ALAMAT' => $oracleResult->ALAMAT,
				'RT' => $oracleResult->RT,
				'RW' => $oracleResult->RW,
				'TELEPON' => $oracleResult->TELEPON,
				'KODEPOS' => $oracleResult->KODEPOS,
				'STATUS_PEGAWAI' => $oracleResult->STATUS_PEGAWAI,
				'KARTU_PEGAWAI' => $oracleResult->KARTU_PEGAWAI,
				'ASKES' => $oracleResult->ASKES,
				'TASPEN' => $oracleResult->TASPEN,
				'NPWP' => $oracleResult->NPWP,
				'NIK' => $oracleResult->NIK,
				'FOTO' => $oracleResult->FOTO,
				'NO_REKENING' => $oracleResult->NO_REKENING,
				'TANGGAL_MATI' => $oracleResult->TANGGAL_MATI,
				'TANGGAL_PENSIUN' => $oracleResult->TANGGAL_PENSIUN,
				'TANGGAL_TERUSAN' => $oracleResult->TANGGAL_TERUSAN,
				'TANGGAL_UPDATE' => $oracleResult->TANGGAL_UPDATE,
				'TIPE_PEGAWAI_ID' => $oracleResult->TIPE_PEGAWAI_ID,
				'AGAMA_ID' => $oracleResult->AGAMA_ID,
				'SATKER_ID_LAMA' => $oracleResult->SATKER_ID_LAMA,
				'FOTO_SETENGAH' => $oracleResult->FOTO_SETENGAH,
				'FOTO_BLOB' => $oracleResult->FOTO_BLOB,
				'FOTO_BLOB_OTHER' => $oracleResult->FOTO_BLOB_OTHER,
				'TEMP_COL' => $oracleResult->TEMP_COL,
				'TEMP_COL2' => $oracleResult->TEMP_COL2,
				'USER_APP_ID' => $oracleResult->USER_APP_ID,
				'DOSIR_KARPEG' => $oracleResult->DOSIR_KARPEG,
				'FORMAT_KARPEG' => $oracleResult->FORMAT_KARPEG,
				'UKURAN_KARPEG' => $oracleResult->UKURAN_KARPEG,
				'DOSIR_ASKES' => $oracleResult->DOSIR_ASKES,
				'FORMAT_ASKES' => $oracleResult->FORMAT_ASKES,
				'UKURAN_ASKES' => $oracleResult->UKURAN_ASKES,
				'DOSIR_TASPEN' => $oracleResult->DOSIR_TASPEN,
				'FORMAT_TASPEN' => $oracleResult->FORMAT_TASPEN,
				'UKURAN_TASPEN' => $oracleResult->UKURAN_TASPEN,
				'DOSIR_NPWP' => $oracleResult->DOSIR_NPWP,
				'FORMAT_NPWP' => $oracleResult->FORMAT_NPWP,
				'UKURAN_NPWP' => $oracleResult->UKURAN_NPWP,
				'LAST_CREATE_USER' => $oracleResult->LAST_CREATE_USER,
				'LAST_CREATE_DATE' => $oracleResult->LAST_CREATE_DATE,
				'LAST_UPDATE_USER' => $oracleResult->LAST_UPDATE_USER,
				'LAST_UPDATE_DATE' => $oracleResult->LAST_UPDATE_DATE,
				'LAST_CREATE_SATKER' => $oracleResult->LAST_CREATE_SATKER,
				'LAST_UPDATE_SATKER' => $oracleResult->LAST_UPDATE_SATKER,
				'NO_HP' => $oracleResult->NO_HP,
				'JENIS_OPERATOR' => $oracleResult->JENIS_OPERATOR,
				'NO_KPE' => $oracleResult->NO_KPE,
				'NO_KTA' => $oracleResult->NO_KTA,
				'JENIS_PROFESI' => $oracleResult->JENIS_PROFESI,
				'BBM' => $oracleResult->BBM,
				'FB' => $oracleResult->FB,
				'TWITTER' => $oracleResult->TWITTER,
				'LINK_FILE_APPS' => $oracleResult->LINK_FILE_APPS,
				'LINK_FILE_APPS_KARPEG' => $oracleResult->LINK_FILE_APPS_KARPEG,
				'LINK_FILE_APPS_ASKES' => $oracleResult->LINK_FILE_APPS_ASKES,
				'LINK_FILE_APPS_TASPEN' => $oracleResult->LINK_FILE_APPS_TASPEN,
				'LINK_FILE_APPS_NPWP' => $oracleResult->LINK_FILE_APPS_NPWP,
				'LINK_FILE_APPS_KPE' => $oracleResult->LINK_FILE_APPS_KPE,
				'FORMAT_KPE' => $oracleResult->FORMAT_KPE,
				'UKURAN_KPE' => $oracleResult->UKURAN_KPE,
				'BARCODE_KARPEG' => $oracleResult->BARCODE_KARPEG,
				'BARCODE_KPE' => $oracleResult->BARCODE_KPE,
				'BARCODE_ASKES' => $oracleResult->BARCODE_ASKES,
				'BARCODE_TASPEN' => $oracleResult->BARCODE_TASPEN,
				'BARCODE_NPWP' => $oracleResult->BARCODE_NPWP,
				'QRCODE' => $oracleResult->QRCODE,
				'PASSWORD' => $oracleResult->PASSWORD,
				'ID_SAPK' => $oracleResult->ID_SAPK,
				'SINGKRON_JABATAN_SIAP' => $oracleResult->SINGKRON_JABATAN_SIAP

			);

			// Lakukan update di MySQL
			$this->db->where('NIP_BARU', $nip_baru);
			$this->db->update('pegawai', $data);
			// exit();
		} elseif ($oracleLastUpdate < $mysqlLastUpdate) {
			echo "LAST_UPDATE_DATE pada MySQL lebih baru." . $nip_baru . "\n";
		} else {
			echo "LAST_UPDATE_DATE pada Oracle dan MySQL sama." . $nip_baru . "\n";
		}
		// echo $json;
	}

	public function index()
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');
	}

	public function set_pangkat_flag0($nip_baru)
	{

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// set semua flag jadi 0
		$this->db->set('FLAG_DATA_TERAKHIR', '0')
			->where('PEGAWAI_ID', $pegawaiId)
			->update('pangkat_riwayat');

		if ($this->db->affected_rows() > 0) {
			// Update berhasil
			echo "Update 0 berhasil " . $nip_baru . " " . $pegawaiId . " ";
		} else {
			// Update tidak berhasil
			echo "Update 0 tidak berhasil " . $nip_baru . " " . $pegawaiId . " ";
		}
	}
	public function set_pangkat_terakhir($nip_baru)
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// echo " 2";

		$query1 = $this->db->query("UPDATE pangkat_riwayat AS pr
		INNER JOIN (
				SELECT pr2.pangkat_riwayat_id
				FROM pangkat_riwayat AS pr2
				LEFT JOIN pegawai p ON pr2.PEGAWAI_ID = p.PEGAWAI_ID
				WHERE p.NIP_BARU = '" . $nip_baru . "'
				AND pr2.TMT_PANGKAT IS NOT NULL
				ORDER BY pr2.tmt_pangkat DESC
				LIMIT 1
		) AS subquery ON pr.PANGKAT_RIWAYAT_ID = subquery.pangkat_riwayat_id
		SET pr.FLAG_DATA_TERAKHIR = '1'");

		// echo "4";
		if ($this->db->affected_rows() > 0) {
			// Query berhasil
			echo "dan Update flag terakhir berhasil " . $nip_baru . "\n";
		} else {
			// Query tidak berhasil
			echo "dan Update flag terakhir tidak berhasil " . $nip_baru . "\n";
		}
	}


	public function updatepangkatterakhir()
	{
		// echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->select('*')
			->from('pegawai_singkronasi')
			->where('tgl_update_pangkat_terakhir IS NULL')
			->or_where('tgl_update_pangkat_terakhir <', '2023-05-29');
		$query = $this->db->get();

		// echo "2";
		$results = $query->result();
		// echo $results;
		// echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			$this->set_pangkat_flag0($row->nip_baru);
			$this->set_pangkat_terakhir($row->nip_baru);
			// echo $row->nip_baru . " ";
			// exit();
			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_pangkat_terakhir' => date('Y-m-d')]);
		}
	}

	public function update_tabel_pegawai_siap_lama()
	{
		// echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->select('*')
			->from('pegawai_singkronasi')
			->where('tgl_update_tabel_pegawai IS NULL')
			->or_where('tgl_update_tabel_pegawai <', '2023-05-29');
		$query = $this->db->get();

		// echo "2";
		$results = $query->result();
		// echo $results;
		// echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			$this->update_dari_tabel_pegawai_siap_lama($row->nip_baru);
			// $this->set_pangkat_terakhir($row->nip_baru);
			// echo $row->nip_baru . " ";
			// exit();
			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_tabel_pegawai' => date('Y-m-d')]);
		}
	}
}
