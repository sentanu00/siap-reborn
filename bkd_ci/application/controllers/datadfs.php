<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datadfs extends SB_Controller 
{

	protected $layout 	= "layouts/main";
	public $module 		= 'datadfs';
	public $per_page	= '10';
	public $idx			= '';

	function __construct() {
		parent::__construct();
		
		$this->load->model('datadfsmodel');
		$this->model = $this->datadfsmodel;
		$idx = $this->model->primaryKey;
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);	
		$this->data = array_merge( $this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'datadfs',
		));
		$this->col = array();
		$this->con = array();
		$inf = $this->info['config']['grid'];
		$inf = SiteHelpers::array_sort($inf, 'sortlist', SORT_ASC);
		$in=0;
		foreach ($inf as $key => $t) {
			if($t['view'] =='1'){
				
				$in++;
				$this->col[$in] = $t['field'];
				$this->con[$in] = $t['conn'];
				
			}
			
		}
		
		if(!$this->session->userdata('logged_in')) redirect('user/login',301);


		$this->getdatapaperless();
		
	}

	function grids($pg){
		
		$sort = $this->model->primaryKey; 
		$order = 'asc';
		$filter = "";
		//$filter = (!is_null($this->input->get('search', true)) ? $this->buildSearch() : '');
		//order 
		if(isset($_POST['order']))
        {
            if(($_POST['order']['0']['column'])==0){
        		$sort = $this->col[($_POST['order']['0']['column'])+1];
            	$order = $_POST['order']['0']['dir'];
        	}else{
            	$sort = $this->col[($_POST['order']['0']['column'])];
            	$order = $_POST['order']['0']['dir'];
        	}

        }

        for ($i=0; $i < count($this->col) ; $i++) { 
        	
            if(isset($_POST['search']['value']) && $_POST['search']['value'] != ''){
            	if($i==0){
            		$filter .= " AND (".$this->col[$i+1]." LIKE '%".$_POST['search']['value']."%'";
            	}else{
            		$filter .= " OR ".$this->col[$i+1]." LIKE '%".$_POST['search']['value']."%'";
            	}
            }
        }

        if($filter != '') $filter .= ")";
        $filter .= " AND PEGAWAI_ID = '$pg'"; 

		$params = array(
			'limit'		=> $_POST['start'],
			'page'		=> $_POST['length'],
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );
		$rows = $results['rows'];
		$total = $results['total'];
		$totalfil = $results['totalfil'];
		
		//run data to view
		$data = array();$no=0;
		foreach ($rows as $dt) {
            $row = array();
			$idku = $this->model->primaryKey;
			$row['id'] = $dt->$idku; 
            $row[] = $no+1;
            for ($i=0; $i < count($this->col) ; $i++) { 
            		$field = $this->col[$i+1];
            		$conn = (isset($this->con[$i+1]) ? $this->con[$i+1] : array() ) ;
					$row[] = SiteHelpers::gridDisplay($dt->$field , $field , $conn );
            }
 
            //add html for action
            $btn ='';
            

            $btn .= '<div class="btn-group dropdown-split-danger">';
            	$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="sr-only">Toggle primary</span>
</button>
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';

if($this->access['is_remove'] ==1){
$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\''.site_url('datadfs/destroy/').'\','.$dt->$idku.')"><i class="ti-trash"></i> Delete</a>';
}
$btn .= '</div>';
           
 			$row[] = $btn;
            $data[] = $row;
            $no++;
        }
         $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $total,
                        "recordsFiltered" => $totalfil,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);

	}
	
	function index() 
	{
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];



		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template
		
		echo $this->data['content'] = $this->load->view('datadfs/indexintegrasi',$this->data, true );
		
    	//$this->load->view('layouts/main', $this->data );
    
	  
	}

	function indexchecklist() 
	{
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];


		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template
		
		echo $this->data['content'] = $this->load->view('datadfs/indexchecklist',$this->data, true );
		
    	//$this->load->view('layouts/main', $this->data );
    
	  
	}

	function indexpaperless() 
	{
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['selectGrid'] 	= $this->db->query("SELECT id_jenis_pengajuan,jenis_pengajuan FROM `dfs_papperless` GROUP BY id_jenis_pengajuan")->result();


		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template
		
		echo $this->data['content'] = $this->load->view('datadfs/indexpaperless',$this->data, true );
		
    	//$this->load->view('layouts/main', $this->data );
    
	  
	}

	function getpaperlessdata($id,$pegawai,$nip)
	{
		 $url = "http://siap.bkd.probolinggokab.go.id/dfs/paperless_bkn_integrasi.php?pegawaiID=".$pegawai."&jenis_pengajuan=".$id."&nip=".$nip;
			// persiapkan curl
		    $ch = curl_init(); 

		    // set url 
		    curl_setopt($ch, CURLOPT_URL, $url);
		    // set user agent    
		    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		    // return the transfer as a string 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    // $output contains the output string 
		    $outputx = curl_exec($ch); 
		    // tutup curl 
		    curl_close($ch);      
		    // mengembalikan hasil curl
		    $a = json_decode($outputx, TRUE);
		    foreach ($a as $dt) {
		    		$row = array();
			$row['id'] = $dt['no']; 
			$row[] = "<b>".$dt['no']."</b>"; 
			$row[] = $dt['nm'];
			$row[] = $dt['nm_file'];
			//$row[] = $dt['act'];
			if($dt['act'] == 'robust-assets/images/tidak_ada.png'){
		            	$row[] = '<img src="'.base_url('assets/icon/nodoc.png').'" style="width:20px" />'; 
		            }else{
		            	$row[] = '<img src="'.base_url('assets/icon/adadoc.png').'" style="width:20px" />'; 
		            }

			$data[] = $row;
		    }

		
		$output = array(
                        "draw" => 1,
                        "recordsTotal" => 100,
                        "recordsFiltered" => 100,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}

	function downloadgambar($jns,$id){
		/*$url = "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/downloaddoc?id=".$jns."&pegid=".$id;
			// persiapkan curl
		    $ch = curl_init(); 

		    // set url 
		    curl_setopt($ch, CURLOPT_URL, $url);
		    // set user agent    
		    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		    // return the transfer as a string 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    // $output contains the output string 
		    $outputx = curl_exec($ch); 
		    // tutup curl 
		    curl_close($ch);*/
			
			$url = 'http://siap.bkd.probolinggokab.go.id/dfs/view_doc_integrasi.php';

		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS,
            "riwayat_dokumen_pdf=".$jns."&id_pegawai=".$id);
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 $response = curl_exec ($ch);
		 $err = curl_error($ch);  //if you need
		 curl_close ($ch);
		 $rr = str_replace("http://192.168.137.7","http://siap.bkd.probolinggokab.go.id",$response);
		 echo $rr;

		 //   echo $outputx;

	}

	function getdatapaperless()
	{
		$rx = $this->db->query("SELECT count(id) as rowx from dfs_papperless")->row();
		if($rx->rowx <= 0){
			$url = "http://siap.bkd.probolinggokab.go.id/api/dfs/paperless_bkn.php";
			// persiapkan curl
		    $ch = curl_init(); 

		    // set url 
		    curl_setopt($ch, CURLOPT_URL, $url);
		    // set user agent    
		    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		    // return the transfer as a string 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    // $output contains the output string 
		    $outputx = curl_exec($ch); 
		    // tutup curl 
		    curl_close($ch);      
		    // mengembalikan hasil curl
		    $a = json_decode($outputx, TRUE);
		    foreach ($a as $dt) {
		    	//dfs_papperless
		    	$row = array();
				$row['id'] = $dt['id'];
				$row['nama_dokumen'] = $dt['nama_dokumen'];
				$row['format_nama_file'] = $dt['format_nama_file'];
				$row['status'] = $dt['status'];
				$row['id_jenis_pengajuan'] = $dt['id_jenis_pengajuan'];
				$row['jenis_pengajuan'] = $dt['jenis_pengajuan'];

				$this->db->insert('dfs_papperless',$row);
		    }
		}
	}
	
	//data DFS local
	
	
	
	//data DFS integrasi

	function getdataintegrasi($id)
	{

		

		    $url = "http://siap.bkd.probolinggokab.go.id/dfs/checklist_dokumen_integrasi.php?pegawaiID=".$id;
			// persiapkan curl
		    $ch = curl_init(); 

		    // set url 
		    curl_setopt($ch, CURLOPT_URL, $url);
		    // set user agent    
		    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		    // return the transfer as a string 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    // $output contains the output string 
		    $outputx = curl_exec($ch); 
		    // tutup curl 
		    curl_close($ch);      
		    // mengembalikan hasil curl
		    $a = json_decode($outputx, TRUE);


		    foreach ($a as $dt) {
		    	//var_dump($dt);
		    	$row = array();
				$row['id'] = $dt['no']; 
				if($dt['hal'] == "0"){
					$row[] = "<b>".strtoupper($dt['no'])."</b>"; 
		            $row[] = "<b>".strtoupper($dt['nm'])."</b>"; 
		            $row[] = "<button class='btn btn-danger' onclick='getgambar(".$id.",".$dt['no'].")'><i class='fa fa-eye'></i> View Dokumen</button>"; 
				}else{
					$row[] = $dt['no']; 
		            $row[] = $dt['nm']; 
		            if($dt['hal'] == 'Tidak Ada Dokumen'){
		            	$row[] = '<img src="'.base_url('assets/icon/nodoc.png').'" style="width:20px" />'; 
		            }else{
		            	$row[] = '<img src="'.base_url('assets/icon/adadoc.png').'" style="width:20px" /> &nbsp;'.$dt['hal']; 
		            }
		            
				}
	            
			    $btn ='';
	            $data[] = $row;
	            
	        }
        
         $output = array(
                        "draw" => 1,
                        "recordsTotal" => 100,
                        "recordsFiltered" => 100,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}


	function getdatachecklist($id)
	{

		

		    $url = "http://siap.bkd.probolinggokab.go.id/dfs/checklist_dokumen_integrasi.php?pegawaiID=".$id;
			// persiapkan curl
		    $ch = curl_init(); 

		    // set url 
		    curl_setopt($ch, CURLOPT_URL, $url);
		    // set user agent    
		    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		    // return the transfer as a string 
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    // $output contains the output string 
		    $outputx = curl_exec($ch); 
		    // tutup curl 
		    curl_close($ch);      
		    // mengembalikan hasil curl
		    $a = json_decode($outputx, TRUE);
		//	var_dump($a);die();

		    foreach ($a as $dt) {
		    	//var_dump($dt);
		    	$row = array();
				$row['id'] = $dt['no']; 
				if($dt['hal'] == "0"){
					$row[] = "<b>".strtoupper($dt['no'])."</b>"; 
					$row[] = "";
		            $row[] = "<b>".strtoupper($dt['nm'])."</b>"; 
		            $row[] = "<button class='btn btn-info' onclick='getgambar(".$id.",".$dt['no'].")'><i class='fa fa-eye'></i> View</button>"; 
				}else{
					$row[] = $dt['no'];  
					if($dt['hal'] == 'Tidak Ada Dokumen'){
					$row[] = "";
					}else{
		            $row[] = "<input type='checkbox' name='data_dokumen[]' value='".$dt['id']."' >"; 
		        }
		            $row[] = $dt['nm']; 
		            if($dt['hal'] == 'Tidak Ada Dokumen'){
		            	$row[] = '<img src="'.base_url('assets/icon/nodoc.png').'" style="width:20px" />'; 
		            }else{
		            	$row[] = '<img src="'.base_url('assets/icon/adadoc.png').'" style="width:20px" /> &nbsp;'.$dt['hal']; 
		            }
		            
				}
	            
			    $btn ='';
	            $data[] = $row;
	            
	        }
        
         $output = array(
                        "draw" => 1,
                        "recordsTotal" => 100,
                        "recordsFiltered" => 100,
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
	}
	
	function show( $id = null) 
	{
		if($this->access['is_detail'] ==0)
		{ 
			$this->session->set_flashdata('error',SiteHelpers::alert('error','Your are not allowed to access the page'));
			redirect('dashboard',301);
	  	}		

		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('digital_file_system'); 
		}
		
		$this->data['id'] = $id;
		echo $this->data['content'] =  $this->load->view('datadfs/view', $this->data ,true);	  
		//$this->load->view('layouts/main',$this->data);
	}
  
	function add( $id = null ) 
	{

		$row = $this->model->getRow( $id );
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('digital_file_system'); 
		}
	
		$this->data['id'] = $id;
		$this->data['PEGAWAI_ID'] = $_POST['id'];
		echo $this->data['content'] = $this->load->view('datadfs/form',$this->data, true );		
	  	//$this->load->view('layouts/main', $this->data );
	
	}
	
	function save() {
		
		$rules = $this->validateForm();

		$this->form_validation->set_rules( $rules );
		if( $this->form_validation->run() )
		{
			$data = $this->validatePost();
			$ID = $this->model->insertRow($data , $this->input->get_post( 'DFS_ID' , true ));
			// Input logs
			if( $this->input->get( 'DFS_ID' , true ) =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$this->session->set_flashdata('message',SiteHelpers::alert('success'," Data has been saved succesfuly !"));
			if($this->input->post('apply'))
			{
				redirect( 'datadfs/add/'.$ID,301);
			} else {
				redirect( 'datadfs',301);
			}			
			
			
		} else {
			$data =	array(
					'message'	=> 'Ops , The following errors occurred',
					'errors'	=> validation_errors('<li>', '</li>')
					);			
			$this->displayError($data);
		}
	}

	function destroy()
	{
		if($this->access['is_remove'] ==0)
		{ 
			echo "err : maaf anda tidak memiliki hak untuk menghapus data";
	  	}
			
		$this->model->destroy($_POST['id']);
		$this->inputLogs("ID : ".$_POST['id']."  , Has Been Removed Successfull");
		echo "ID : ".$_POST['id']."  , berhasil dihapus !!";
		
	}


	public function downloadallpdf($nip,$id)
	{

		$url = 'http://siap.bkd.probolinggokab.go.id/dfs/download-dokumen.php';

		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS,
            "nip=".$nip."&id_pegawai=".$id."&all_dokumen_pdf=submit");
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 header('Content-type: application/pdf');
		 $response = curl_exec ($ch);
		 $err = curl_error($ch);  //if you need
		 curl_close ($ch);

		echo $response;
	}


	public function downloadallzip($nip,$id)
	{

		$url = 'http://siap.bkd.probolinggokab.go.id/dfs/download-dokumen.php';

		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS,
            "nip=".$nip."&id_pegawai=".$id."&all_dokumen_zip=submit");
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 header('Content-type: application/zip');
		 $response = curl_exec ($ch);
		 $err = curl_error($ch);  //if you need
		 curl_close ($ch);

		echo $response;
	}

	public function downloadcheckPDF($nip,$id)
	{
		//var_dump($_REQUEST);die();
		$url = 'http://siap.bkd.probolinggokab.go.id/dfs/download-dokumen.php';
		$fields = array(
            'nip' 		   => $nip,
            'id_pegawai'   => $id,
            'checklist_dokumen_pdf'   => 'submit',
            'data_dokumen' => json_decode($_REQUEST['jns'])
        );

        $fields_string = http_build_query($fields);
		//var_dump($fields_string);die();
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 header('Content-type: application/pdf');
		 $response = curl_exec ($ch);
		 $err = curl_error($ch);  //if you need
		 curl_close ($ch);

		echo $response;
	}

	public function downloadcheckZIP($nip,$id)
	{
		//var_dump($_REQUEST);die();
		$url = 'http://siap.bkd.probolinggokab.go.id/dfs/download-dokumen.php';
		$fields = array(
            'nip' 		   => $nip,
            'id_pegawai'   => $id,
            'checklist_dokumen_zip'   => 'submit',
            'data_dokumen' => json_decode($_REQUEST['jns'])
        );

        $fields_string = http_build_query($fields);
		//var_dump($fields_string);die();
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 header('Content-type: application/zip');
		 $response = curl_exec ($ch);
		 $err = curl_error($ch);  //if you need
		 curl_close ($ch);

		echo $response;
	}


}
