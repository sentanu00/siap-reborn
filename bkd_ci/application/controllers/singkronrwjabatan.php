<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Singkronrwjabatan extends SB_Controller
{

	function get_token()
	{
		header('Content-type: Application/JSON');

		echo '1 ';

		$curl = curl_init();

		echo '2 ';
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://wsrv-auth.bkn.go.id/oauth/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'client_id=kabprobolinggows&grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic a2FicHJvYm9saW5nZ293czpkRzlpWVhOaGI='
			),
		));

		echo '3 ';

		$response = curl_exec($curl);

		echo '4 ';
		curl_close($curl);

		echo '5 ';
		echo $response;
	}


	function update_jabatan()
	{
		header('Content-type: Application/JSON');

		$x_pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
		// echo '1 ';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://siap.bkd.probolinggokab.go.id:8082/api/lama_baru/get_jabatan.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('pegawai_id' => '' . $x_pegawai_id . ''),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		//  echo $response;

		$data_riwayat = null;
		$siap_baru = null;
		$data = json_decode($response);
		foreach ($data as $datarw) {

			$data_riwayat['JABATAN_RIWAYAT_ID'] = @$datarw->JABATAN_RIWAYAT_ID;
			$data_riwayat['PEGAWAI_ID'] = @$datarw->PEGAWAI_ID;
			$data_riwayat['PEJABAT_PENETAP_ID'] = @$datarw->PEJABAT_PENETAP_ID;
			$data_riwayat['ESELON_ID'] = @$datarw->ESELON_ID;
			$data_riwayat['JABATAN_FUNGSIONAL_ID'] = @$datarw->JABATAN_FUNGSIONAL_ID;
			$data_riwayat['NO_SK'] = @$datarw->NO_SK;
			$data_riwayat['TANGGAL_SK'] = date_format(date_create(@$datarw->TANGGAL_SK), "Y-m-d H:i");
			// $data_riwayat['TANGGAL_SK'] = date("Y-m-d", @$datarw->TANGGAL_SK);
			$data_riwayat['TMT_JABATAN'] = date_format(date_create(@$datarw->TMT_JABATAN), "Y-m-d H:i");
			// $data_riwayat['TMT_JABATAN'] = date("Y-m-d", @$datarw->TMT_JABATAN);
			$data_riwayat['TMT_ESELON'] = date_format(date_create(@$datarw->TMT_ESELON), "Y-m-d H:i");
			// $data_riwayat['TMT_ESELON'] = @$datarw->TMT_ESELON;
			$data_riwayat['NAMA'] = @$datarw->NAMA;
			$data_riwayat['NO_PELANTIKAN'] = @$datarw->NO_PELANTIKAN;

			$data_riwayat['TANGGAL_PELANTIKAN'] = date_format(date_create(@$datarw->TANGGAL_PELANTIKAN), "Y-m-d H:i");
			// $data_riwayat['TANGGAL_PELANTIKAN'] = @date("Y-m-d", @$datarw->TANGGAL_PELANTIKAN);
			$data_riwayat['TUNJANGAN'] = @$datarw->TUNJANGAN;
			$data_riwayat['KREDIT'] = @$datarw->KREDIT;
			$data_riwayat['BULAN_DIBAYAR'] = @$datarw->BULAN_DIBAYAR;
			$data_riwayat['SUDAH_DIBAYAR'] = @$datarw->SUDAH_DIBAYAR;
			$data_riwayat['TANGGAL_UPDATE'] = date_format(date_create(@$datarw->TANGGAL_UPDATE), "Y-m-d H:i");
			// $data_riwayat['TANGGAL_UPDATE'] = @date("Y-m-d", @$datarw->TANGGAL_UPDATE);
			$data_riwayat['FLAG_DATA_TERAKHIR'] = @$datarw->FLAG_DATA_TERAKHIR;
			$data_riwayat['SATKER_ID'] = @$datarw->SATKER_ID;
			$data_riwayat['PEJABAT_PENETAP'] = @$datarw->PEJABAT_PENETAP;
			$data_riwayat['FOTO_BLOB'] = @$datarw->FOTO_BLOB;
			$data_riwayat['TMT_JABATAN_FUNGSIONAL'] = date_format(date_create(@$datarw->TMT_JABATAN_FUNGSIONAL), "Y-m-d H:i");
			// $data_riwayat['TMT_JABATAN_FUNGSIONAL'] = @date("Y-m-d", @$datarw->TMT_JABATAN_FUNGSIONAL);
			$data_riwayat['TMT_TUGAS_TAMBAHAN'] = date_format(date_create(@$datarw->TMT_TUGAS_TAMBAHAN), "Y-m-d H:i");
			// $data_riwayat['TMT_TUGAS_TAMBAHAN'] = @date("Y-m-d", @$datarw->TMT_TUGAS_TAMBAHAN);
			$data_riwayat['FORMAT'] = @$datarw->FORMAT;
			$data_riwayat['UKURAN'] = @$datarw->UKURAN;
			$data_riwayat['USER_APP_ID'] = @$datarw->USER_APP_ID;
			$data_riwayat['LAST_CREATE_USER'] = @$datarw->LAST_CREATE_USER;
			$data_riwayat['LAST_CREATE_DATE'] = date_format(date_create(@$datarw->LAST_CREATE_DATE), "Y-m-d H:i");
			// $data_riwayat['LAST_CREATE_DATE'] = @date("Y-m-d", @$datarw->LAST_CREATE_DATE);
			$data_riwayat['LAST_UPDATE_USER'] = @$datarw->LAST_UPDATE_USER;
			$data_riwayat['LAST_UPDATE_DATE'] = date_format(date_create(@$datarw->LAST_UPDATE_DATE), "Y-m-d H:i");
			// $data_riwayat['LAST_UPDATE_DATE'] = @date("Y-m-d", @$datarw->LAST_UPDATE_DATE);
			$data_riwayat['LAST_CREATE_SATKER'] = @$datarw->LAST_CREATE_SATKER;
			$data_riwayat['LAST_UPDATE_SATKER'] = @$datarw->LAST_UPDATE_SATKER;
			$data_riwayat['KETERANGAN_BUP'] = @$datarw->KETERANGAN_BUP;
			$data_riwayat['SATUAN_KERJA_HISTORI_ID'] = @$datarw->SATUAN_KERJA_HISTORI_ID;
			$data_riwayat['TINGKAT_JABATAN_ID'] = @$datarw->TINGKAT_JABATAN_ID;
			$data_riwayat['TINGKAT_JABATAN'] = @$datarw->TINGKAT_JABATAN;
			$data_riwayat['LINK_FILE_APPS'] = @$datarw->LINK_FILE_APPS;
			$data_riwayat['KEPALA_SEKOLAH'] = @$datarw->KEPALA_SEKOLAH;
			$data_riwayat['BARCODE'] = @$datarw->BARCODE;
			$data_riwayat['IS_JABATAN'] = @$datarw->IS_JABATAN;
			$data_riwayat['KELAS_JABATAN'] = @$datarw->KELAS_JABATAN;
			$data_riwayat['NAMA_KELAS_JABATAN'] = @$datarw->NAMA_KELAS_JABATAN;
			$data_riwayat['NILAI_KELAS_JABATAN'] = @$datarw->NILAI_KELAS_JABATAN;
			$data_riwayat['KELAS_JABATAN_ID'] = @$datarw->KELAS_JABATAN_ID;
			$data_riwayat['RW_JABATAN_ID_SAPK'] = @$datarw->RW_JABATAN_ID_SAPK;
			$data_riwayat['JENIS_JABATAN_SAPK'] = @$datarw->JENIS_JABATAN_SAPK;
			$data_riwayat['INSTANSI_KERJA_ID_SAPK'] = @$datarw->INSTANSI_KERJA_ID_SAPK;
			$data_riwayat['INSTANSI_KERJA_NAMA_SAPK'] = @$datarw->INSTANSI_KERJA_NAMA_SAPK;
			$data_riwayat['SATUAN_KERJA_ID_SAPK'] = @$datarw->SATUAN_KERJA_ID_SAPK;
			$data_riwayat['SATUAN_KERJA_NAMA_SAPK'] = @$datarw->SATUAN_KERJA_NAMA_SAPK;
			$data_riwayat['UNOR_ID_SAPK'] = @$datarw->UNOR_ID_SAPK;
			$data_riwayat['UNOR_NAMA_SAPK'] = @$datarw->UNOR_NAMA_SAPK;
			$data_riwayat['JFT_ID_SAPK'] = @$datarw->JFT_ID_SAPK;
			$data_riwayat['JFT_NAMA_SAPK'] = @$datarw->JFT_NAMA_SAPK;
			$data_riwayat['JFU_ID_SAPK'] = @$datarw->JFU_ID_SAPK;
			$data_riwayat['JFU_NAMA_SAPK'] = @$datarw->JFU_NAMA_SAPK;


			//cek apakah data ini sudah ada di nip ini dan di siap yang baru?	27713
			$this->load->model('singkronrwjabatanmodel');
			$stuff = $this->singkronrwjabatanmodel->get_jabatan_pegawai($data_riwayat['JABATAN_RIWAYAT_ID']);



			echo ' lama-' . $data_riwayat['TMT_JABATAN'];



			foreach ($stuff as $data) {
				echo ' baru-' . $data->TMT_JABATAN;
				// echo ' baru-' . $data->NAMA;

				// echo ' baru-' . $data->JABATAN_RIWAYAT_ID_LAMA;


				if ($data->TMT_JABATAN != null) {
					// echo 'cek update apa enggak';

					$siap_baru['JABATAN_RIWAYAT_ID'] = @$data->JABATAN_RIWAYAT_ID;
					$siap_baru['PEGAWAI_ID'] = @$data->PEGAWAI_ID;
					$siap_baru['PEJABAT_PENETAP_ID'] = @$data->PEJABAT_PENETAP_ID;
					$siap_baru['ESELON_ID'] = @$data->ESELON_ID;
					$siap_baru['JABATAN_FUNGSIONAL_ID'] = @$data->JABATAN_FUNGSIONAL_ID;
					$siap_baru['NO_SK'] = @$data->NO_SK; //date("Y-m-d", );
					$siap_baru['TANGGAL_SK'] = date_format(date_create(@$data->TANGGAL_SK), "Y-m-d H:i");
					// $siap_baru['TANGGAL_SK'] = @date("Y-m-d", @$data->TANGGAL_SK);
					$siap_baru['TMT_JABATAN'] = date_format(date_create(@$data->TMT_JABATAN), "Y-m-d H:i");
					// $siap_baru['TMT_JABATAN'] = @date("Y-m-d", @$data->TMT_JABATAN);
					$siap_baru['TMT_ESELON'] = date_format(date_create(@$data->TMT_ESELON), "Y-m-d H:i");
					// $siap_baru['TMT_ESELON'] = @date("Y-m-d", @$data->TMT_ESELON);
					$siap_baru['NAMA'] = @$data->NAMA;
					$siap_baru['NO_PELANTIKAN'] = @$data->NO_PELANTIKAN;
					$siap_baru['TANGGAL_PELANTIKAN'] = date_format(date_create(@$data->TANGGAL_PELANTIKAN), "Y-m-d H:i");
					// $siap_baru['TANGGAL_PELANTIKAN'] = @date("Y-m-d", @$data->TANGGAL_PELANTIKAN);
					$siap_baru['TUNJANGAN'] = @$data->TUNJANGAN;
					$siap_baru['KREDIT'] = @$data->KREDIT;
					$siap_baru['BULAN_DIBAYAR'] = @$data->BULAN_DIBAYAR;
					$siap_baru['SUDAH_DIBAYAR'] = @$data->SUDAH_DIBAYAR;
					$siap_baru['TANGGAL_UPDATE'] = date_format(date_create(@$data->TANGGAL_UPDATE), "Y-m-d H:i");
					// $siap_baru['TANGGAL_UPDATE'] = @date("Y-m-d", @$data->TANGGAL_UPDATE);
					$siap_baru['FLAG_DATA_TERAKHIR'] = @$data->FLAG_DATA_TERAKHIR;
					$siap_baru['SATKER_ID'] = @$data->SATKER_ID;
					$siap_baru['PEJABAT_PENETAP'] = @$data->PEJABAT_PENETAP;
					$siap_baru['FOTO_BLOB'] = @$data->FOTO_BLOB;
					$siap_baru['TMT_JABATAN_FUNGSIONAL'] = date_format(date_create(@$data->TMT_JABATAN_FUNGSIONAL), "Y-m-d H:i");
					// $siap_baru['TMT_JABATAN_FUNGSIONAL'] = @date("Y-m-d", @$data->TMT_JABATAN_FUNGSIONAL);
					$siap_baru['TMT_TUGAS_TAMBAHAN'] = date_format(date_create(@$data->TMT_TUGAS_TAMBAHAN), "Y-m-d H:i");
					// $siap_baru['TMT_TUGAS_TAMBAHAN'] = @date("Y-m-d", @$data->TMT_TUGAS_TAMBAHAN);
					$siap_baru['FORMAT'] = @$data->FORMAT;
					$siap_baru['UKURAN'] = @$data->UKURAN;
					$siap_baru['USER_APP_ID'] = @$data->USER_APP_ID;
					$siap_baru['LAST_CREATE_USER'] = @$data->LAST_CREATE_USER;
					$siap_baru['LAST_CREATE_DATE'] = date_format(date_create(@$data->LAST_CREATE_DATE), "Y-m-d H:i");
					// $siap_baru['LAST_CREATE_DATE'] = @date("Y-m-d", @$data->LAST_CREATE_DATE);
					$siap_baru['LAST_UPDATE_USER'] = @$data->LAST_UPDATE_USER;
					$siap_baru['LAST_UPDATE_DATE'] = date_format(date_create(@$data->LAST_UPDATE_DATE), "Y-m-d H:i");
					// $siap_baru['LAST_UPDATE_DATE'] = @date("Y-m-d", @$data->LAST_UPDATE_DATE);
					$siap_baru['LAST_CREATE_SATKER'] = @$data->LAST_CREATE_SATKER;
					$siap_baru['LAST_UPDATE_SATKER'] = @$data->LAST_UPDATE_SATKER;
					$siap_baru['KETERANGAN_BUP'] = @$data->KETERANGAN_BUP;
					$siap_baru['SATUAN_KERJA_HISTORI_ID'] = @$data->SATUAN_KERJA_HISTORI_ID;
					$siap_baru['TINGKAT_JABATAN_ID'] = @$data->TINGKAT_JABATAN_ID;
					$siap_baru['TINGKAT_JABATAN'] = @$data->TINGKAT_JABATAN;
					$siap_baru['LINK_FILE_APPS'] = @$data->LINK_FILE_APPS;
					$siap_baru['KEPALA_SEKOLAH'] = @$data->KEPALA_SEKOLAH;
					$siap_baru['BARCODE'] = @$data->BARCODE;
					$siap_baru['IS_JABATAN'] = @$data->IS_JABATAN;
					$siap_baru['KELAS_JABATAN'] = @$data->KELAS_JABATAN;
					$siap_baru['NAMA_KELAS_JABATAN'] = @$data->NAMA_KELAS_JABATAN;
					$siap_baru['NILAI_KELAS_JABATAN'] = @$data->NILAI_KELAS_JABATAN;
					$siap_baru['KELAS_JABATAN_ID'] = @$data->KELAS_JABATAN_ID;
					$siap_baru['RW_JABATAN_ID_SAPK'] = @$data->RW_JABATAN_ID_SAPK;
					$siap_baru['JENIS_JABATAN_SAPK'] = @$data->JENIS_JABATAN_SAPK;
					$siap_baru['INSTANSI_KERJA_ID_SAPK'] = @$data->INSTANSI_KERJA_ID_SAPK;
					$siap_baru['INSTANSI_KERJA_NAMA_SAPK'] = @$data->INSTANSI_KERJA_NAMA_SAPK;
					$siap_baru['SATUAN_KERJA_ID_SAPK'] = @$data->SATUAN_KERJA_ID_SAPK;
					$siap_baru['SATUAN_KERJA_NAMA_SAPK'] = @$data->SATUAN_KERJA_NAMA_SAPK;
					$siap_baru['UNOR_ID_SAPK'] = @$data->UNOR_ID_SAPK;
					$siap_baru['UNOR_NAMA_SAPK'] = @$data->UNOR_NAMA_SAPK;
					$siap_baru['JFT_ID_SAPK'] = @$data->JFT_ID_SAPK;
					$siap_baru['JFT_NAMA_SAPK'] = @$data->JFT_NAMA_SAPK;
					$siap_baru['JFU_ID_SAPK'] = @$data->JFU_ID_SAPK;
					$siap_baru['JFU_NAMA_SAPK'] = @$data->JFU_NAMA_SAPK;
					$siap_baru['JABATAN_RIWAYAT_ID_LAMA'] = @$data->JABATAN_RIWAYAT_ID_LAMA;
				}
			}

			// cek apakah ini perlu insert, edit atau dibiarkan aja?
			//if id g ada di siap baru maka di insert
			if ($data_riwayat['JABATAN_RIWAYAT_ID'] != $siap_baru['JABATAN_RIWAYAT_ID_LAMA']) {
				echo 'insert';
				$this->singkronrwjabatanmodel->insert_jabatan_siaplama_ke_siapbaru($datarw);
			}

			//if id di siap baru ada tapi nama jabatan/ tmt jabatan / dll beda maka edit
			if (
				$data_riwayat['JABATAN_RIWAYAT_ID'] == $siap_baru['JABATAN_RIWAYAT_ID_LAMA']
				&& ($data_riwayat['ESELON_ID'] != $siap_baru['ESELON_ID']
					|| $data_riwayat['NAMA'] != $siap_baru['NAMA']
					|| $data_riwayat['TMT_JABATAN'] != $siap_baru['TMT_JABATAN']
					|| $data_riwayat['TANGGAL_SK'] != $siap_baru['TANGGAL_SK']
					|| $data_riwayat['NO_SK'] != $siap_baru['NO_SK']
					|| $data_riwayat['TUNJANGAN'] != $siap_baru['TUNJANGAN']
					|| $data_riwayat['SATUAN_KERJA_HISTORI_ID'] != $siap_baru['SATUAN_KERJA_HISTORI_ID']
				)
			) {
				echo 'edit';
			}

			//if id di siap baru ada tapi di siap lama g ada maka hapus 

			echo '<br>';
		}
	}


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
