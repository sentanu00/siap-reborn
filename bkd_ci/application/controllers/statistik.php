<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistik extends SB_Controller
{
	
	function index(){
		
		
		$this->data['content'] = $this->load->view('statistik/index', $this->data, true);
		$this->load->view('layouts/main', $this->data);
	}
	
}