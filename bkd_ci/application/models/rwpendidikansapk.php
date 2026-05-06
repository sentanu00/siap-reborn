<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwpendidikansapk extends SB_Controller 
{

	
	function get_rw_pendidikan_sapk() 
	{
		header('Content-type: Application/JSON');

		$this->load->model('Rwpendidikansapkmodel');
		$arya = $this->Rwpendidikansapkmodel->get_nip_pegawai();
		print_r $arya;
		

		// $curl = curl_init();
		// $headers = array(
		// 	'Authorization: Bearer 61e84ef7-a684-4405-86cf-35dedfb5c9f9'
		// );
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($curl, CURLOPT_SSLVERSION, 5);
		// curl_setopt($curl, CURLOPT_URL,"https://wsrv.bkn.go.id/api/pns/rw-pendidikan/199104092019032009");
		// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		// $response = curl_exec ($curl);

		// if(curl_errno($curl)){
		// 	print curl_error($curl);
		// }

		// curl_close ($curl);

		// // if($response == null){
		// // 	echo 'null';
		// // }

		// $data = json_decode($response);
		// foreach($data->data as $datarw)
		// {
		// 	$id = $datarw->id;
		// 	$idPns = $datarw->idPns;
		// 	$nipBaru = $datarw->nipBaru;
		// 	$nipLama = $datarw->nipLama;
		// 	$pendidikanId = $datarw->pendidikanId;
		// 	$pendidikanNama = $datarw->pendidikanNama;
		// 	$tkPendidikanIdid = $datarw->tkPendidikanId;
		// 	$tkPendidikanNama = $datarw->tkPendidikanNama;
		// 	$tahunLulus = $datarw->tahunLulus;
		// 	$tglLulus = $datarw->tglLulus;
		// 	$isPendidikanPertama = $datarw->isPendidikanPertama;
		// 	$nomorIjasah = $datarw->nomorIjasah;
		// 	$namaSekolah = $datarw->namaSekolah;
		// 	$gelarDepan = $datarw->gelarDepan;
		// 	$gelarBelakang = $datarw->gelarBelakang;

		// 	//echo $namaSekolah;

		// }  

		// //print  $response ;
		// //echo  $data ;	
		// //$this->load->view('layouts/main', $this->data );
			
			
	}

}
