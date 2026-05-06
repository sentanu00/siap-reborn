<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Singkronrwjabatanmodel extends SB_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_jabatan_pegawai($jabatan_id_lama)
	{
		$this->db->select('*');
		$this->db->where('JABATAN_RIWAYAT_ID_LAMA', $jabatan_id_lama);
		$query = $this->db->get('jabatan_riwayat');
		return $query->result();
	}

	public function insert_jabatan_siaplama_ke_siapbaru($data)
	{

		$PEGAWAI_ID=$data->PEGAWAI_ID;
		// $timetmtJabatan = strtotime('' . $data->tmtJabatan);
		// $timetanggalSk = strtotime('' . $data->tanggalSk);
		$data = array(
			'PEGAWAI_ID' => $data->PEGAWAI_ID,
			'PEJABAT_PENETAP_ID' => $data->PEJABAT_PENETAP_ID,
			'ESELON_ID' => $data->ESELON_ID,
			'JABATAN_FUNGSIONAL_ID' => $data->JABATAN_FUNGSIONAL_ID,
			'NO_SK' => $data->NO_SK,
			'TANGGAL_SK' => date_format(date_create($data->TANGGAL_SK), "Y-m-d H:i"),
			'TMT_JABATAN' => date_format(date_create($data->TMT_JABATAN), "Y-m-d H:i"),
			'TMT_ESELON' => date_format(date_create($data->TMT_ESELON), "Y-m-d H:i"),
			'NAMA' => $data->NAMA,
			'NO_PELANTIKAN' => $data->NO_PELANTIKAN,
			'TANGGAL_PELANTIKAN' => date_format(date_create($data->TANGGAL_PELANTIKAN), "Y-m-d H:i"),
			'TUNJANGAN' => $data->TUNJANGAN,
			'KREDIT' => $data->KREDIT,
			'BULAN_DIBAYAR' => $data->BULAN_DIBAYAR,
			'SUDAH_DIBAYAR' => $data->SUDAH_DIBAYAR,
			'TANGGAL_UPDATE' => date_format(date_create($data->TANGGAL_UPDATE), "Y-m-d H:i"),
			'FLAG_DATA_TERAKHIR' => $data->FLAG_DATA_TERAKHIR,
			'SATKER_ID' => $data->SATKER_ID,
			'PEJABAT_PENETAP' => $data->PEJABAT_PENETAP,
			'FOTO_BLOB' => $data->FOTO_BLOB,
			'TMT_JABATAN_FUNGSIONAL' => date_format(date_create($data->TMT_JABATAN_FUNGSIONAL), "Y-m-d H:i"),
			'TMT_TUGAS_TAMBAHAN' => date_format(date_create($data->TMT_TUGAS_TAMBAHAN), "Y-m-d H:i"),
			'FORMAT' => $data->FORMAT,
			'UKURAN' => $data->UKURAN,
			'USER_APP_ID' => $data->USER_APP_ID,
			'LAST_CREATE_USER' => $data->LAST_CREATE_USER,
			'LAST_CREATE_DATE' => date_format(date_create($data->LAST_CREATE_DATE), "Y-m-d H:i"),
			'LAST_UPDATE_USER' => $data->LAST_UPDATE_USER,
			'LAST_UPDATE_DATE' => date_format(date_create($data->LAST_UPDATE_DATE), "Y-m-d H:i"),
			'LAST_CREATE_SATKER' => $data->LAST_CREATE_SATKER,
			'LAST_UPDATE_SATKER' => $data->LAST_UPDATE_SATKER,
			'KETERANGAN_BUP' => $data->KETERANGAN_BUP,
			'SATUAN_KERJA_HISTORI_ID' => $data->SATUAN_KERJA_HISTORI_ID,
			'TINGKAT_JABATAN_ID' => $data->TINGKAT_JABATAN_ID,
			'TINGKAT_JABATAN' => $data->TINGKAT_JABATAN,
			'LINK_FILE_APPS' => $data->LINK_FILE_APPS,
			'KEPALA_SEKOLAH' => $data->KEPALA_SEKOLAH,
			'BARCODE' => $data->BARCODE,
			'IS_JABATAN' => $data->IS_JABATAN,
			'KELAS_JABATAN' => $data->KELAS_JABATAN,
			'NAMA_KELAS_JABATAN' => $data->NAMA_KELAS_JABATAN,
			'NILAI_KELAS_JABATAN' => $data->NILAI_KELAS_JABATAN,
			'KELAS_JABATAN_ID' => $data->KELAS_JABATAN_ID,
			'RW_JABATAN_ID_SAPK' => $data->RW_JABATAN_ID_SAPK,
			'JENIS_JABATAN_SAPK' => $data->JENIS_JABATAN_SAPK,
			'INSTANSI_KERJA_ID_SAPK' => $data->INSTANSI_KERJA_ID_SAPK,
			'INSTANSI_KERJA_NAMA_SAPK' => $data->INSTANSI_KERJA_NAMA_SAPK,
			'SATUAN_KERJA_ID_SAPK' => $data->SATUAN_KERJA_ID_SAPK,
			'SATUAN_KERJA_NAMA_SAPK' => $data->SATUAN_KERJA_NAMA_SAPK,
			'UNOR_ID_SAPK' => $data->UNOR_ID_SAPK,
			'UNOR_NAMA_SAPK' => $data->UNOR_NAMA_SAPK,
			'JFT_ID_SAPK' => $data->JFT_ID_SAPK,
			'JFT_NAMA_SAPK' => $data->JFT_NAMA_SAPK,
			'JFU_ID_SAPK' => $data->JFU_ID_SAPK,
			'JFU_NAMA_SAPK' => $data->JFU_NAMA_SAPK,
			'JABATAN_RIWAYAT_ID_LAMA' => $data->JABATAN_RIWAYAT_ID,
			'KETERANGAN_DATA' => 'Di update menggunakan API dari siap lama ke siap baru',
			'KETERANGAN_WAKTU_DATA' => date("Y-m-d H:i")

			// // 'tmtJabatan'=>$data->tmtJabatan,
			// 'tmtJabatan' => date("Y-m-d H:i:s", $timetmtJabatan),
			// 'nomorSk' => $data->nomorSk,
			// // 'tanggalSk'=>$data->tanggalSk
			// 'tanggalSk' => date("Y-m-d H:i:s", $timetanggalSk)

		);
		// return $this->db->insert('jabatan_riwayat', $data);

		$this->db->insert('jabatan_riwayat', $data);
		if ($this->db->affected_rows() > 0) {
			$this->update_flag_jabatan_pegawai($PEGAWAI_ID);
			return 'sukses';
		}else{
			return 'gagal';
		}
	}
	public function update_flag_jabatan_pegawai($PEGAWAI_ID)
	{
		$data = array(
			'SINGKRON_JABATAN_SIAP' => date("Y-m-d H:i")
		);

		$this->db->where('PEGAWAI_ID', $PEGAWAI_ID);
		$this->db->update('pegawai', $data);
	}



	public function get_nip_pegawai()
	{

		// $sql ="  SELECT * FROM pegawai AS p WHERE p.NIP_BARU LIKE '199306302019031003'   ";
		// // $query =  json_encode($this->db->query($sql));
		// $query = $this->db->query($sql);
		// return $query->result_array();

		$this->db->from('pegawai');
		$this->db->limit('2');
		$query = $this->db->get();
		return $query;
		// ->result_array();

	}

	public function insert_rs_jabatan_sapk($data)
	{

		$timetmtJabatan = strtotime('' . $data->tmtJabatan);
		$timetanggalSk = strtotime('' . $data->tanggalSk);


		$data = array(
			'id' => $data->id,
			'idPns' => $data->idPns,
			'nipBaru' => $data->nipBaru,
			'nipLama' => $data->nipLama,
			'jenisJabatan' => $data->jenisJabatan,
			'instansiKerjaId' => $data->instansiKerjaId,
			'instansiKerjaNama' => $data->instansiKerjaNama,
			'satuanKerjaId' => $data->satuanKerjaId,
			'satuanKerjaNama' => $data->satuanKerjaNama,
			'unorId' => $data->unorId,
			'unorNama' => $data->unorNama,
			'unorIndukId' => $data->unorIndukId,
			'unorIndukNama' => $data->unorIndukNama,
			'eselon' => $data->eselon,
			'eselonId' => $data->eselonId,
			'jabatanFungsionalId' => $data->jabatanFungsionalId,
			'jabatanFungsionalNama' => $data->jabatanFungsionalNama,
			'jabatanFungsionalUmumId' => $data->jabatanFungsionalUmumId,
			'jabatanFungsionalUmumNama' => $data->jabatanFungsionalUmumNama,


			// 'tmtJabatan'=>$data->tmtJabatan,
			'tmtJabatan' => date("Y-m-d H:i:s", $timetmtJabatan),
			'nomorSk' => $data->nomorSk,
			// 'tanggalSk'=>$data->tanggalSk
			'tanggalSk' => date("Y-m-d H:i:s", $timetanggalSk)

		);
		return $this->db->insert('rw_jabatan_sapk', $data);
	}
}
