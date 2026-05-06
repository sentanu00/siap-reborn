<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');
class Apiexternal extends REST_Controller {
	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
		$this->load->model('apimodel');
		$this->model = $this->apimodel;
    }
	
	 function index_get()
    {
        $this->load->view('index_ws',null);
    }
	
	function biodata_get()
	{
		$nip = $this->get('nip');
		
		if($nip == ''){
			 $this->response(array('status'=>'error','msg'=>'NIP tidak boleh kosong'), 200);
		}else{
			$squp = $this->model->getpegawaibiodata($nip);
			$sq = $this->db->query($squp)->result();
			if($sq){
				$this->response(array('status'=>'success','msg'=>'Data ditemukan.','data'=>$sq), 200);
			}else{
				$this->response(array('status'=>'error','msg'=>'Maaf data tidak ada dengan NIP. '.$nip), 200);
			}
		}
	}
	
	function pegawailist_get()
	{
		
		$nama = '';
		if($this->get('nama') !== '') $nama = $this->get('nama');
		
		$squp = $this->model->getlistpegawai($nama);
		if($nama == ''){
			$this->response(array('status'=>'error','msg'=>'maaf keyword anda kosong. masukan minimal 3 huruf'), 200);
		}elseif(strlen($nama) < 4){
			$this->response(array('status'=>'error','msg'=>'maaf masukan minimal 3 huruf'), 200);
		}else{
			$this->response(array('status'=>'success','msg'=>'Pencarian berhasil','result'=>$squp), 200);
		
		}
			
		
	}
}