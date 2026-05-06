<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Convertfile extends SB_Controller
{

	function get_token()
	{
	}


	function update_jabatan()
	{
	}


	function get_rw_jabatan_sapk()
	{
	}

	function coba_upload()
	{
	}

	function cek()
	{
		$imageUrl = 'http://siap.bkd.probolinggokab.go.id:8082/dokumen/199306302019031003/01_askes_1.jpg';

		try {
			// Buat objek Imagick
			$image = new Imagick();
			$image->readImage($imageUrl);

			// Buat objek Imagick untuk PDF
			$pdf = new Imagick();
			$pdf->setCompressionQuality(80);

			// Tambahkan gambar ke objek PDF
			$pdf->addImage($image);

			// Set format PDF
			$pdf->setImageFormat('pdf');

			// Simpan PDF ke file
			$pdfPath = 'dokumen/199306302019031003/file.pdf';
			$pdf->writeImages($pdfPath, true);

			echo 'Gambar berhasil dikonversi menjadi PDF.';
		} catch (ImagickException $e) {
			echo 'Terjadi kesalahan Imagick: ' . $e->getMessage();
		} catch (Exception $e) {
			echo 'Terjadi kesalahan: ' . $e->getMessage();
		} finally {
			// Hapus objek Imagick
			if ($image) {
				$image->clear();
				$image->destroy();
			}

			if ($pdf) {
				$pdf->clear();
				$pdf->destroy();
			}
		}
	}

	// memanggil dattabase dengan db-query
	function getEksekusi1()
	{

		$results = $this->db->query("SELECT * FROM convert_file AS c WHERE c.eksekusi = '1' LIMIT 70")->result();

		foreach ($results as $row) {
			$id_a = $row->id;
			echo "ID: " . $row->id . "<br>";
			echo "Nama File: " . $row->nama_file . "<br>";
			echo "Lokasi yang Dituju: " . $row->lokasi_yang_dituju . "<br>";
			echo "Eksekusi: " . $row->eksekusi . "<br>";

			// $hasil['data']['id'] = $row->id;
			// $hasil['data']['nama_file'] = $row->nama_file;
			// $hasil['data']['lokasi_yang_dituju'] = $row->lokasi_yang_dituju;
			// $hasil['data']['eksekusi'] = $row->eksekusi;

			$namaFile = $row->nama_file;
			$lokasiDituju = $row->lokasi_yang_dituju;

			$files = scandir($lokasiDituju);

			$pdf = new Imagick();

			foreach ($files as $file) {
				$pattern = str_replace($lokasiDituju . "/", "", $namaFile);

				if (preg_match("/^{$pattern}.*\.jpg$/i", $file)) {
					echo "File yang cocok ditemukan: " . $lokasiDituju . "/" . $file . "<br>";

					try {
						$fileUrl = base_url($lokasiDituju . "/" . $file);
						// $fileUrl = str_replace("dokumen", "dok", $fileUrl);
						echo "arya - " . $fileUrl . "<br><br>";


						$imageBlob = file_get_contents($fileUrl);
						$image = new Imagick();
						$image->readImageBlob($imageBlob);
						$pdf->addImage($image);
					} catch (ImagickException $e) {
						// echo 'Terjadi kesalahan Imagick: ' . $e->getMessage() . '<br><br>' . "http://siap.bkd.probolinggokab.go.id:8082/" . $lokasiDituju . "/" . $file;
						echo 'Terjadi kesalahan Imagick: ' . $e->getMessage() . '<br><br>' . $fileUrl;

						// Mengupdate kolom eksekusi menjadi '2' pada data yang dipilih
						// $this->db->query("UPDATE convert_file SET eksekusi = '3' WHERE id = '" . $id_a . "'");
						$ket = addslashes(@$e->getMessage());
						$this->db->query("UPDATE convert_file SET eksekusi = '3', keterangan = '" . $ket . "' WHERE id = '" . $id_a . "'");

						// Lanjutkan atau berikan penanganan khusus sesuai kebutuhan
					}
				}
			}

			try {


				$pdf->setImageFormat('pdf');
				$pdf->setCompressionQuality(80);
				$namaFile = str_replace("dokumen", "", $namaFile);
				$pdf->writeImages("www/bkd_ci/dokumen/" . $namaFile . ".pdf", true);
				$pdf->destroy();
				echo 'File PDF berhasil dibuat.';
				// Mengupdate kolom eksekusi menjadi '2' pada data yang dipilih
				$this->db->query("UPDATE convert_file SET eksekusi = '2' WHERE id = '" . $id_a . "'");

				echo "<br>";
			} catch (ImagickException $e) {
				echo 'Terjadi kesalahan Imagick saat membuat file PDF: ' . $e->getMessage() . '<br><br>' . "http://siap.bkd.probolinggokab.go.id:8082/" . $namaFile;
				// Lanjutkan atau berikan penanganan khusus sesuai kebutuhan

				// Mengupdate kolom eksekusi menjadi '2' pada data yang dipilih
				$ket = addslashes(@$e->getMessage());
				$this->db->query("UPDATE convert_file SET eksekusi = '4', keterangan = '" . $ket . "' WHERE id = '" . $id_a . "'");
			}
		}
		// return $hasil;
	}
}
