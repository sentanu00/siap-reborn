<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import_file_pdf extends SB_Controller
{
	public function move_files()
	{
		$fileList = scandir(FCPATH . 'file_upload');

		// Loop melalui setiap file
		foreach ($fileList as $file) {
			// Cek apakah file valid
			if (is_file(FCPATH . 'file_upload/' . $file)) {
				// Dapatkan nip_pegawai dari nama file
				$nip_baru = str_replace(".pdf", "", $this->getNipPegawaiFromFileName($file, 3));
				// $nipPegawai = $this->getNipPegawaiFromFileName($file, 3);
				echo $nip_baru . " ";
				// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
				$pegawaiData = $this->db->get_where('pegawai', array('nip_baru' => $nip_baru))->row();

				if ($pegawaiData) {
					$pegawai_id = $pegawaiData->PEGAWAI_ID;
					// echo $pegawaiData->PEGAWAI_ID . " ";
				}
				$golongan_id = $this->getNipPegawaiFromFileName($file, 2);
				// echo $this->getNipPegawaiFromFileName($file, 2) . " ";
				$jenissk = $this->getNipPegawaiFromFileName($file, 1);
				// echo $this->getNipPegawaiFromFileName($file, 1) . " ";
				$tipefile = $this->getNipPegawaiFromFileName($file, 0);
				// echo $this->getNipPegawaiFromFileName($file, 0) . " <br><br>";

				// Dapatkan URL tujuan baru sesuai dengan format yang diinginkan
				$newUrl = FCPATH . 'dokumen/' . $nip_baru . '/' . $file;
				// Pindahkan file ke folder tujuan
				$sourcePath = FCPATH . 'file_upload/' . $file;
				$destinationPath = FCPATH . 'dokumen/' . $nip_baru . '/' . $file;
				if (rename($sourcePath, $destinationPath)) {
					// Ubah URL sesuai dengan format baru
					$this->updateUrlInDatabase($nip_baru, $pegawai_id, $file, $jenissk, $golongan_id);
				} else {
					echo 'Gagal memindahkan file: ' . $file . '<br>';
				}
			}
		}
	}

	private function getNipPegawaiFromFileName($fileName, $x)
	{
		// Parsing nip_pegawai dari nama file
		$parts = explode('_', $fileName);
		return $parts[$x];
	}

	private function updateUrlInDatabase($nip_baru, $pegawai_id, $file, $jenissk, $golongan_id)
	{
		// dokumen/199306302019031003/KP_SK_199306302019031003_2019-03-01.pdf
		if ($jenissk = "kp") {
			$this->db->where('PANGKAT_ID', $golongan_id)
				->where('PEGAWAI_ID', $pegawai_id)
				->update('pangkat_riwayat', array(
					'FILE_PDF' => "dokumen/" . $nip_baru . "/" . $file

				));
		}


		// Lakukan update URL di database sesuai dengan kebutuhan Anda
		// Contoh:
		// $this->db->where('nip_pegawai', $nipPegawai);
		// $this->db->update('pegawai', array('url_dokumen' => $newUrl));

		// $this->db->where('PANGKAT_ID', $golonganId)
		// 	->where('PEGAWAI_ID', $pegawaiData->PEGAWAI_ID)
		// 	->update('pangkat_riwayat', array(
		// 		'PANGKAT_ID' => $golongan['golonganId'],
		// 		'NO_NOTA' => $golongan['noPertekBkn'],
		// 		'TANGGAL_NOTA' => date('Y-m-d', strtotime($golongan['tglPertekBkn'])),
		// 		// 'TANGGAL_NOTA' => $golongan['tglPertekBkn'],
		// 		'NO_SK' => $golongan['skNomor'],
		// 		'TANGGAL_SK' => date('Y-m-d', strtotime($golongan['skTanggal'])),
		// 		// 'TANGGAL_SK' => $golongan['skTanggal'],
		// 		'TMT_PANGKAT' => date('Y-m-d', strtotime($golongan['tmtGolongan'])),
		// 		// 'TMT_PANGKAT' => $golongan['tmtGolongan'],
		// 		'KETERANGAN' => "UPDATE BY WS SIASN",
		// 		'MASA_KERJA_TAHUN' => $golongan['masaKerjaGolonganTahun'],
		// 		'MASA_KERJA_BULAN' => $golongan['masaKerjaGolonganBulan'],
		// 		'SIASN_PANGKTAT_ID' => $golongan['id'],
		// 		'SIASN_IDPNS' => $golongan['idPns'],
		// 		'NIPBARU' => $golongan['nipBaru'],
		// 		'JUMLAHKREDITUTAMA' => $golongan['jumlahKreditUtama'],
		// 		'JUMLAHKREDITTAMBAHAN' => $golongan['jumlahKreditTambahan'],
		// 		'JENISKPID' => $golongan['jenisKPId'],

		// 		'TANGGAL_UPDATE' => date('Y-m-d'),
		// 		'LAST_UPDATE_DATE' => date('Y-m-d'),

		// 		'JENISKPNAMA' => $golongan['jenisKPNama']

		// 	));
	}
}
