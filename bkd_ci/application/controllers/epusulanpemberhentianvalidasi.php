<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epusulanpemberhentianvalidasi extends SB_Controller 
{

	protected $layout 	= "layouts/main";
	public $module 		= 'epusulanpemberhentianvalidasi';
	public $per_page	= '10';
	public $idx			= '';

	function __construct() {
		parent::__construct();
		
		$this->load->model('epusulanpemberhentianvalidasimodel');
		$this->model = $this->epusulanpemberhentianvalidasimodel;
		$idx = $this->model->primaryKey;
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);	
		$this->data = array_merge( $this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'epusulanpemberhentianvalidasi',
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
		
	}

	function grids($stt = 2){
		
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

		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
        $filter .= " AND usulan_status = '$stt' AND usulan_tanggal BETWEEN '$tgl1' AND '$tgl2'"; 

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
				if($field == 'usulan_tanggal'){
					$row[] = SiteHelpers::datereport($dt->usulan_tanggal).'<br /><b>'.$dt->usulan_nomor.'</b>'.'<br /><i class="fa fa-arrow-right"></i> <span style="color:white;background:#3c7c11;padding:2px;padding-left:5px;padding-right:5px">'.$dt->golongan_pemberhentian_nama.'</span><br /><i class="fa fa-arrow-right"></i> <span style="color:white;background:#002542;padding:2px;padding-left:5px;padding-right:5px">'.$dt->jenis_pemberhentian_nama.'</span>';
				}else if($field == 'satuan_kerja'){
					$row[] = '<i class="fa fa-home"></i> '.$dt->satuan_kerja.'<br /><i class="fa fa-arrow-right"></i> '.$dt->unor;
				}else if($field == 'usulan_status'){
					$row[] = SiteHelpers::getStatusUsulanPegawai($dt->$field);
				}else if($field == 'NAMA_PEGAWAI'){
					$row[] = $dt->NAMA_PEGAWAI.'<br /><small><b>NIP. '.$dt->NIP_BARU.'</b></small>';
				}else{
					$conn = (isset($this->con[$i+1]) ? $this->con[$i+1] : array() ) ;
					$row[] = SiteHelpers::gridDisplay($dt->$field , $field , $conn );
				}
				
		}
 
            //add html for action
            $btn ='';
            
			if($dt->usulan_status == 2){
            	$btn .= '<button class="btn btn-sm btn-danger" onclick="SximoModal(\''.site_url('epusulanpemberhentianvalidasi/show/'.		$dt->$idku).'\',\'Detail Data Pegawai\',\'950\')"><i class="fa fa-gears"></i> Proses</button>';
			}
			if($dt->usulan_status == 3){
				$btn .= '<button class="btn btn-sm btn-warning" onclick="downloadAllSyarat(\''.md5($dt->$idku).'\')"><i class="fa fa-download"></i> Download File ZIP</button>';
            	$btn .= '<button class="btn btn-sm btn-danger" onclick="SximoModal(\''.site_url('epusulanpemberhentianvalidasi/show/'.		$dt->$idku).'\',\'Detail Data Pegawai\',\'950\')"><i class="fa fa-upload"></i> Upload SK</button>';
			}

			if($dt->usulan_status == 5){
            	$btn .= '<button class="btn btn-sm btn-danger" onclick="SximoModal(\''.site_url('epusulanpemberhentianvalidasi/viewfileSK/'.		$dt->$idku).'\',\'View SK Pemberhentian Pegawai\',\'950\')"><i class="fa fa-eye"></i> View SK</button>';
			}
			if($dt->usulan_status == 6){
				$btn .= '<b>Alasan :</b><br />'.$dt->validasi_catatan;
			}
           
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

	function prosesDownloadZIP($id){
		$row = $this->db->query("SELECT * FROM vw_usulan_detail_pegawai WHERE md5(id) = '$id'")->row();
		$sql = $this->db->query("SELECT * FROM ep_tx_usulan_pemberhentian_syarat WHERE md5(id_usulan_detail)='$id'")->result();
		$zipEP = new ZipArchive();
		$tmp_file = tempnam('./dokumen/'.$row->NIP_BARU,'');
    	$zipEP->open($tmp_file, ZipArchive::CREATE);
		foreach($sql as $ff){
			$download_file = file_get_contents($ff->file_syarat);
			$zipEP->addFromString(basename($ff->file_syarat),$download_file);
		}
		$zipEP->close();
		$nama = $row->NAMA_PEGAWAI;
		$sukukata = explode(' ',$nama);
		$filename = 'EPEMBERHENTIAN_PERSYARATAN_'.$sukukata[0];
		header('Content-disposition: attachment; filename='.$filename.'.zip');
    	header('Content-type: application/zip');
    	readfile($tmp_file);
	}

	function viewfileSK($id)
	{
		$col = "file_sk_upload";
		$th = $this->db->query("SELECT $col FROM ep_tx_usulan_pemberhentian_detail WHERE id = '$id'")->row();
		$ext = explode(".", $th->$col);
		$maxext = count($ext);
		$extn = $ext[$maxext - 1];
		if ($extn == 'pdf') {
			$urlberkas = base_url($th->$col);
			echo '<iframe src="' . $urlberkas . '?time=' . date('ymdhis') . '#toolbar=0" width="100%" height="600px"></iframe>';
		} else {
			$urlberkas = base_url($th->$col);
			echo '<img src="' . $urlberkas . '?time=' . date('ymdhis') . '" style="max-width:100%">';
		}
	}

	function keluarga(){
		$this->load->model('epusulanpemberhentianpegawaimodel');
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		$suamiistri = $this->db->query($this->epusulanpemberhentianpegawaimodel->querySuamiistri($row['pegawai_id']))->result();
		$anak = $this->db->query($this->epusulanpemberhentianpegawaimodel->queryAnak($row['pegawai_id']))->result();
		$this->data['suamiistri'] = $suamiistri;
		$this->data['anak'] = $anak;
			echo $this->load->view('epusulanpemberhentianvalidasi/viewKeluarga', $this->data ,true);
	}

	function validasiForm(){
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		echo $this->load->view('epusulanpemberhentianvalidasi/form', $this->data ,true);
	}

	function uploadskForm(){
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		echo $this->load->view('epusulanpemberhentianvalidasi/formSK', $this->data ,true);
	}

	function uploadSK(){
		$nip = $_POST['NIP'];
		$id_usulan_detail = $_POST['id_usulan_detail'];
		$pegawai_id = $_POST['pegawai_id'];
		$config['upload_path'] = './dokumen/' . $nip . '/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']     = '2000';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		$_FILES['file_sk_upload']['name']= 'EP_SK_TERBIT_' . $nip . '_' .$id_usulan_detail . '.pdf';
		if (!$this->upload->do_upload('file_sk_upload')) {
			$e = $this->upload->display_errors();
			$a = $e;
		} else {
			$namafile = 'dokumen/' . $nip . '/EP_SK_TERBIT_' . $nip . '_' . $id_usulan_detail. '.pdf';
			$data = array(
				'file_sk_upload'		=> $namafile,
				'usulan_status'			=> 5,
				'file_sk_user_act'			=> $this->session->userdata('fid'),
				'file_sk_tgl_act'			=> date('Y-m-d H:i:s')
			);
			$this->db->where('id',$id_usulan_detail);
			$this->db->update('ep_tx_usulan_pemberhentian_detail',$data);

		}
	}


	function simpanValidasi(){
		$id = $_POST['id'];
		$data = array(
			'validasi_user_act' => $this->session->userdata('fid'),
			'validasi_tgl_act'  => date('Y-m-d H:i:s'),
			'validasi_catatan'	=> $_POST['validasi_catatan'],
			'usulan_status'	  => $_POST['usulan_status']
		);
		$this->db->where('id',$id);
		$this->db->update('ep_tx_usulan_pemberhentian_detail',$data);

	}
	
	function index() 
	{
		$this->data['tableGrid'] 	= $this->info['config']['grid'];

		// Group users permission
		$this->data['access']		= $this->access;
		// Render into template
		
		$this->data['content'] = $this->load->view('epusulanpemberhentianvalidasi/index',$this->data, true );
		
    	$this->load->view('layouts/main', $this->data );
    
	  
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
			$this->data['row'] = $this->model->getColumnTable('ep_tx_usulan_pemberhentian_detail'); 
		}
		$this->data['id'] = $id;
		
		echo $this->data['content'] =  $this->load->view('epusulanpemberhentianvalidasi/view', $this->data ,true);  
		
	}

	function reporting($stt){
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
		$sql = "SELECT * FROM vw_usulan_detail_pegawai WHERE usulan_status = $stt AND usulan_tanggal BETWEEN '$tgl1' AND '$tgl2' ORDER BY usulan_tanggal,usulan_nomor ASC";
		$rw = $this->db->query($sql)->result();
		$this->data['rw'] = $rw;
		$this->data['title'] = SiteHelpers::datereport($tgl1).' s/d '.SiteHelpers::datereport($tgl2);
		$contentdata = $this->load->view('epusulanpemberhentianvalidasi/laporan',$this->data, true );
		if($_GET['excel']==0){
			$contentdata .= '<script>window.print();setTimeout(function(){ window.close();},500);</script>';
		}
		if($_GET['excel']==1){
			$file = "Laporan Usulan ".$this->data['title'].".xls";
				header("Content-type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=$file");
		}
		
		echo $contentdata;
	}
  
	


}
