<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apidoc extends CI_Controller {
	function __construct() {
        parent::__construct();
    }
	
	 function index()
    {
     //   $this->load->view('index_ws',$this->data);		
    	$this->load->view('index_ws', null );
    }
}