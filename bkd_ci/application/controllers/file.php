<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File extends SB_Controller
{


	function get_file()
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://siap.bkd.probolinggokab.go.id:8082/dfs/dokumen/get_file.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$files = json_decode($response, true);

		foreach ($files as $file) {
			$nama_file = $file;
			echo $nama_file . "<br>";
			$query = $this->db->query("INSERT INTO file (nama_file) VALUES ('$nama_file')");
			// Lakukan operasi lain di sini jika diperlukan
		}
	}
}
