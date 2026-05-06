<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwkursussapk extends SB_Controller
{


	function push_kursus_to_sapk()
	{
		header('Content-type: Application/JSON');

		$query = $this->db->query("SELECT id, jenisKursusId, instansiId, pnsOrangId, namaKursus, jumlahJam, DATE_FORMAT( tanggalKursus, '%d-%m-%Y') AS tanggalKursus, tahun, institusiPenyelenggara, jenisKursusSertipikat, nomorSertipikat, DATE_FORMAT(tanggalSelesaiKursus, '%d-%m-%Y') AS tanggalSelesaiKursus, lokasiId, pnsUserId, flag_satus, update_date
		FROM sapk_kursus AS s WHERE s.pnsOrangId = 'A5EB049A896DF6A0E040640A040252AD' ");

		foreach ($query->result() as $row) {


			$jenisKursusId = $row->jenisKursusId;
			$instansiId = $row->instansiId;
			$pnsOrangId = $row->pnsOrangId;
			$namaKursus = $row->namaKursus;
			$jumlahJam = $row->jumlahJam;
			$tanggalKursus = $row->tanggalKursus;
			$tahun = $row->tahun;
			$institusiPenyelenggara = $row->institusiPenyelenggara;
			$jenisKursusSertipikat = $row->jenisKursusSertipikat;
			$nomorSertipikat = $row->nomorSertipikat;
			$tanggalSelesaiKursus = $row->tanggalSelesaiKursus;
			$lokasiId = $row->lokasiId;
			$pnsUserId = $row->pnsUserId;

			$postfields = '{"id":null,"jenisKursusId":"' . $jenisKursusId . '","instansiId":"' . $instansiId . '","pnsOrangId":"' . $pnsOrangId . '","namaKursus":"' . $namaKursus . '","jumlahJam":"' . $jumlahJam . '","tanggalKursus":"' . $tanggalKursus . '","tahun":"' . $tahun . '","institusiPenyelenggara":"' . $institusiPenyelenggara . '","jenisKursusSertipikat":"' . $jenisKursusSertipikat . '","nomorSertipikat":"' . $nomorSertipikat . '","tanggalSelesaiKursus":"' . $tanggalSelesaiKursus . '","lokasiId":"' . $lokasiId . '","pnsUserId":"' . $pnsUserId . '"}';
			// echo $postfields;

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://wsrv-duplex.bkn.go.id/api/kursus/save',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '{
					"id":null,
					"jenisKursusId":"A5EB03E203F7F6A0E040640A040252AD",
					"instansiId":"A5EB03E23B3BF6A0E040640A040252AD",
					"pnsOrangId":"A5EB04656BD4F6A0E040640A040252AD",
					"namaKursus":"c Bimbingan Teknis Sistem Informasi Pemerintahan Daerah Tahun 2022",
					"jumlahJam":"12",
					"tanggalKursus":"20-01-2022",
					"tahun":"2022",
					"institusiPenyelenggara":"Badan Keuangan Daerah Kabupaten Probolinggo",
					"jenisKursusSertipikat":"P",
					"nomorSertipikat":"800/1-95/426.202/2022",
					"tanggalSelesaiKursus":"20-01-2022",
					"lokasiId":"",
					"pnsUserId":"A5EB04978D5DF6A0E040640A040252AD"
					}
					',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Origin: http://localhost:20000',
					'Authorization: Bearer a7db162a-87b1-4b3c-8ca0-5df29feed171',
					'Cookie: BIGipServerpool_wsduplex=2013684746.47873.0000'
				),
			));

			$response = curl_exec($curl);

			echo $response;

			curl_close($curl);

			$data_update = array(
				'flag_satus' => '1',
			);

			// $this->db->update('sapk_kursus', $data_update, "id =" . $row->id);

			// echo $row->id ." respon : ". $response. " DONE namaKursus : ".$namaKursus ;
		}
	}

	function cobapush()
	{

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://wsrv-duplex.bkn.go.id/api/kursus/save',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
"id":null,
"jenisKursusId":"A5EB03E203F7F6A0E040640A040252AD",
"instansiId":"A5EB03E23B3BF6A0E040640A040252AD",
"pnsOrangId":"A5EB04656BD4F6A0E040640A040252AD",
"namaKursus":"c Bimbingan Teknis Sistem Informasi Pemerintahan Daerah Tahun 2022",
"jumlahJam":"12",
"tanggalKursus":"20-01-2022",
"tahun":"2022",
"institusiPenyelenggara":"Badan Keuangan Daerah Kabupaten Probolinggo",
"jenisKursusSertipikat":"P",
"nomorSertipikat":"800/1-95/426.202/2022",
"tanggalSelesaiKursus":"20-01-2022",
"lokasiId":"",
"pnsUserId":"A5EB04978D5DF6A0E040640A040252AD"
}
',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Origin: http://localhost:20000',
				'Authorization: Bearer a7db162a-87b1-4b3c-8ca0-5df29feed171',
				'Cookie: BIGipServerpool_wsduplex=2013684746.47873.0000'
			),
		));

		$response = curl_exec($curl);

		$curl_error = curl_error($curl);
		if (curl_error($curl)) {
			echo curl_error($curl);
		} else {
			echo 'no error';
		}

		curl_close($curl);
		echo $response;
		// echo $curl_error;
		// echo "<script>console.log($curl_error);</script>";

	}
}
