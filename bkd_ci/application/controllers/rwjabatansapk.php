<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwjabatansapk extends SB_Controller
{


	function get_rw_jabatan_sapk()
	{
		header('Content-type: Application/JSON');

		$nip_array = array('199110092022212019', '199110192022212030', '199111132022212019', '199111152022211011', '199111152022212028', '199112052022212006', '199112052022212018', '199112292022212006', '199201082022212019', '199201192022212017', '199202252022212016', '199202262022211005', '199203022022211009', '199203022022212017', '199203112022212009', '199203162022212021', '199203272022212028', '199203292022211018', '199204062022212025', '199204202022211015', '199204242022212026', '199204252022212017', '199205152022212023', '199205252022212026', '199206252022212029', '199207062022211012', '199207072022212025', '199207182022212019', '199207222022211012', '199207252022211021', '199208122022212025', '199208152022211006', '199208172022211012', '199208262022212011', '199208302022211012', '199209042022212009', '199209052022212025', '199210022022212025', '199211222022211016', '199212052022211011', '199212152022212015', '199212282022212020', '199302112022211011', '199303192022212021', '199304032022211007', '199304202022212030', '199305032022212020', '199305052022212030', '199305102022212028', '199305302022212022', '199306052022211008', '199306082022211010', '199306242022212017', '199306252022211007', '199306262022211012', '199307182022211004', '199307252022212020', '199308082022212014', '199308142022212025', '199308172022212029', '199308172022212030', '199308312022212012', '199309052022211009', '199309272022211004', '199310162022212012', '199310202022212024', '199312022022212014', '199312232022211004', '199401072022212017', '199401092022211010', '199402152022211002', '199402212022212009', '199404012022212027', '199404212022212012', '199405282022212013', '199406112022212009', '199406212022211007', '199406222022212009', '199407172022211013', '199407222022211009', '199408052022212013', '199408252022212011', '199410242022211007', '199412042022212022', '199412152022211011', '199412182022212014', '199502212022212016', '199503242022212015', '199506202022211007', '199506262022212012', '199508072022211009', '199508132022212020', '199508272022212012', '199510042022212009', '199510052022212012', '199510232022212024', '199601062022212018', '199602142022212005', '199603022022212012', '199603202022212010', '199603302022212012', '199605272022212019', '199606062022212023', '199606092022212014', '199607062022212010', '199607302022212011', '199608032022211002', '199609012022212021', '199611282022211005', '199612252022212011', '199702012022211005', '199702022022212024', '199707152022212007', '199712202022212006', '199805022022212003');

		foreach ($nip_array as $value) {
			// echo "$value <br>";
			$nip_baru = $value;


			$curl = curl_init();
			$headers = array(
				'Authorization: Bearer 9cd10ee6-bf2d-4c64-bb78-70009aaa305c'
			);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSLVERSION, 5);
			curl_setopt($curl, CURLOPT_URL, "https://wsrv.bkn.go.id/api/pns/rw-jabatan/" . $nip_baru);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($curl);

			if (curl_errno($curl)) {
				print curl_error($curl);
			}

			curl_close($curl);

			$x = 0;
			$data = json_decode($response);
			foreach ($data->data as $datarw) {

				$this->load->model('rwjabatansapkmodel');
				$datax['rw'] = $this->rwjabatansapkmodel->insert_rs_jabatan_sapk($datarw);
			}
			$datax['nip_baru'] = $nip_baru;

			$this->load->view('rwjabatansapk', $datax);
		}

		// print  $response ;


	}

	function coba_upload()
	{
		// $curl = curl_init();

		// curl_setopt_array($curl, array(
		// 	CURLOPT_URL => '103.182.48.107:8888/api/upload_dfs/data',
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_ENCODING => '',
		// 	CURLOPT_MAXREDIRS => 10,
		// 	CURLOPT_TIMEOUT => 0,
		// 	CURLOPT_FOLLOWLOCATION => true,
		// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// 	CURLOPT_CUSTOMREQUEST => 'POST',
		// 	CURLOPT_POSTFIELDS => array('format_berkas' => 'SKJABATAN', 'tmt' => '2022-09-17', 'nip' => '199306302019031003', 'username' => 'arya', 'file' => new CURLFILE('/C:/Users/USER/Downloads/pangkat 2021.pdf')),
		// ));

		// $response = curl_exec($curl);

		// curl_close($curl);
		// echo $response;
		// $json = json_encode($response);
		// $datax['hupload'] = $json;


		$this->load->view('rwjabatansapk');
	}

	function cek()
	{
		// echo 'gajah';
		echo $_FILES['FILE_PDF']['tmp_name'];
		echo $_FILES['FILE_PDF']['name'];
		echo $_FILES['FILE_PDF']['type'];
		echo $_FILES['FILE_PDF']['size'];
		// $datax['hupload'] = $_FILES['FILE_PDF']['file_name'];
		$this->load->view('rwjabatansapk');

		if ($filepdf = '') {
		} else {

			// return $foto;
			// $config['upload_path'] 		= '.assets/pdf';
			// $config['allowed_types'] 	= 'jpg|pnd|gif';
			// $this->load->library('upload', $config);
			// if (!$this->upload->do_upload('FILE_PDF')) {
			// 	echo "upload gagal";
			// 	die();
			// } else {
			// 	$foto = $this->upload->data('file_name');
			// }
		}

	}
}
