<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epusulanpemberhentianpegawai extends SB_Controller 
{

	protected $layout 	= "layouts/main";
	public $module 		= 'epusulanpemberhentianpegawai';
	public $per_page	= '10';
	public $idx			= '';

	function __construct() {
		parent::__construct();
		
		$this->load->model('epusulanpemberhentianpegawaimodel');
		$this->model = $this->epusulanpemberhentianpegawaimodel;
		$idx = $this->model->primaryKey;
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);	
		$this->data = array_merge( $this->data, array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'epusulanpemberhentianpegawai',
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

	function grids($usulanid){
		
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
        $filter .= " AND usulan_pemberhentian_id = '$usulanid'"; 

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
					if($field == 'golongan_pemberhentian_nama'){
						$row[] = '<i class="fa fa-arrow-right"></i> <span style="color:white;background:#3c7c11;padding:2px;padding-left:5px;padding-right:5px">'.$dt->$field.'</span><br /><i class="fa fa-arrow-right"></i> <span style="color:white;background:#002542;padding:2px;padding-left:5px;padding-right:5px">'.$dt->jenis_pemberhentian_nama.'</span>';
					}else if($field == 'usulan_status'){
						$row[] = SiteHelpers::getStatusUsulanPegawai($dt->$field);
					}else{
						$conn = (isset($this->con[$i+1]) ? $this->con[$i+1] : array() ) ;
						$row[] = SiteHelpers::gridDisplay($dt->$field , $field , $conn );
					}
            		
            }
 
            //add html for action
            $btn ='';
            

            $btn .= '<div class="btn-group dropdown-split-danger">';
            	$btn .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="sr-only">Toggle primary</span>
</button>
<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(86px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">';
if($this->access['is_edit'] ==1){
	$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="SximoModal(\''.site_url('epusulanpemberhentianpegawai/show/'.$dt->$idku).'\',\'Detail Data Pegawai\',\'950\')"><i class="ti-list"></i> Detail Usulan</a>';
	}
	if($this->access['is_edit'] ==1 && $dt->usulan_status < 2){
		$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="SximoModal(\''.site_url('epusulanpemberhentianpegawai/add/'.$dt->$idku).'\',\'Edit Usulan Data Pegawai\',\'\')"><i class="ti-pencil"></i> Edit</a>';
		}
if($this->access['is_remove'] ==1 && $dt->usulan_status < 2){
$btn .= '<a class="dropdown-item waves-effect waves-light" href="#" onclick="ConfirmDelete(\''.site_url('epusulanpemberhentianpegawai/destroy/').'\','.$dt->$idku.')"><i class="ti-trash"></i> Delete</a>';
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
		if($row['usulan_status'] < 2){
			echo $this->data['content'] =  $this->load->view('epusulanpemberhentianpegawai/view', $this->data ,true);
		}else{
			echo $this->data['content'] =  $this->load->view('epusulanpemberhentianpegawai/viewOnly', $this->data ,true);

		}	  
		
	}

	function detaildata(){
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		if($row['usulan_status'] == 0){
			$squp = $this->model->queryBiodatapegawaiNIP($row['NIP_BARU']);
			$sq = $this->db->query($squp)->row();
			$data = array();
			if($sq){
				$row['jenis_jabatan'] = $sq->TIPE_PEGAWAI;
				$row['nama_jabatan'] = $sq->JABATAN;
				$row['unor'] = $sq->NAMA_UNOR;
				$row['satuan_kerja'] = $sq->NAMA_SATKER;
				$row['tmt_cpns'] = $sq->TMT_CPNS;
				$row['tmt_pns'] = $sq->TMT_PNS;
				$row['masa_kerja_pns_thn'] = $sq->MS_PNS_THN;
				$row['masa_kerja_pns_bln'] = $sq->MS_PNS_BLN;
				$row['tmt_pensiun'] = $sq->TANGGAL_PENSIUN;
				$row['masa_kerja_pensiun_thn'] = $sq->MS_PENSIUN_THN;
				$row['masa_kerja_pensiun_bln'] = $sq->MS_PENSIUN_BLN;
				$row['gaji'] = $sq->GAJI_POKOK;
				$row['tahun_gaji'] = $sq->GAJI_THN;
				$row['golongan'] = $sq->GOLONGAN_PANGKAT;
				$row['pangkat'] = $sq->PANGKAT;
				$row['tmt_golongan'] = $sq->TMT_PANGKAT;
				$row['masa_kerja_gol_thn'] = $sq->MS_PANGKAT_THN;
				$row['masa_kerja_gol_bln'] = $sq->MS_PANGKAT_BLN;
				$row['pendidikan_terakhir'] = $sq->SEKOLAH;
				$row['pendidikan_tahun'] = $sq->THN_LULUS;
			}
		}
		
		$this->data['row'] =  $row;
		
		if($row['usulan_status'] < 2){
			echo $this->load->view('epusulanpemberhentianpegawai/formDatadetail', $this->data ,true);
		}else{
			echo $this->load->view('epusulanpemberhentianpegawai/viewOnlyDatadetail', $this->data ,true);
		}
	}

	function keterangan(){
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		if($row['usulan_status'] < 2){
			echo $this->load->view('epusulanpemberhentianpegawai/formKeterangan', $this->data ,true);
		}else{
			echo $this->load->view('epusulanpemberhentianpegawai/viewOnlyKeterangan', $this->data ,true);
		}
	}

	function dokumen(){
		$id = $_POST['id'];
		$syarat = $this->db->query($this->model->querySyarat())->result();
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		$this->data['syarat'] = $syarat;
		if($row['usulan_status'] < 2){
			echo $this->load->view('epusulanpemberhentianpegawai/formSyarat', $this->data ,true);
		}else{
			echo $this->load->view('epusulanpemberhentianpegawai/viewOnlySyarat', $this->data ,true);
		}
	}

	function keluarga(){
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		$suamiistri = $this->db->query($this->model->querySuamiistri($row['pegawai_id']))->result();
		$anak = $this->db->query($this->model->queryAnak($row['pegawai_id']))->result();
		$this->data['suamiistri'] = $suamiistri;
		$this->data['anak'] = $anak;
		if($row['usulan_status'] < 2){
			echo $this->load->view('epusulanpemberhentianpegawai/formKeluarga', $this->data ,true);
		}else{
			echo $this->load->view('epusulanpemberhentianpegawai/viewOnlyKeluarga', $this->data ,true);
		}
	}

	function konfirmasi(){
		$id = $_POST['id'];
		$row = $this->model->getRow($id);
		$this->data['row'] =  $row;
		echo $this->load->view('epusulanpemberhentianpegawai/formKonfirmasi', $this->data ,true);
	}

	function viewfile($idusulan,$idsyarat){
		$path = $_GET['path'];
		$col = "file_syarat";
		$th = $this->db->query("SELECT $col FROM ep_tx_usulan_pemberhentian_syarat WHERE id_usulan_detail = '$idusulan' and id_syarat='$idsyarat'")->row();
		if($th){
			$ext = explode(".", $th->$col);
			$maxext = count($ext);
			$extn = $ext[$maxext - 1];
			$urlberkas = base_url($th->$col);
		}else{
			$ext = explode(".", $path);
			$maxext = count($ext);
			$extn = $ext[$maxext - 1];
			$urlberkas = base_url($path);
		}
		if ($extn == 'pdf') {
			
			echo '<iframe src="' . $urlberkas . '?time=' . date('ymdhis') . '#toolbar=0" width="100%" height="600px"></iframe>';
		} else {
			
			echo '<img src="' . $urlberkas . '?time=' . date('ymdhis') . '" style="max-width:100%">';
		}
	}

	function simpanKonfirmasi(){
		$id = $_POST['id'];
		$data = array(
			'usulan_user_act' => $this->session->userdata('fid'),
			'usulan_tgl_act'  => date('Y-m-d H:i:s'),
			'usulan_status'	  => 1
		);
		$this->db->where('id',$id);
		$this->db->update('ep_tx_usulan_pemberhentian_detail',$data);

	}

	function simpanKeluarga(){
		$id_usulan_detail = $_POST['id_usulan_detail'];
		$pegawai_id = $_POST['pegawai_id'];
		//pasangan
		foreach($_POST['pasangan'] as $in=>$val){
			$data = array(
				'id_usulan_detail'=>$id_usulan_detail,
				'pegawai_id'=>$pegawai_id,
				'suami_istri_id'=>$in,
				'anak_id'=>0,
				'jenis_data'=>1,
				'hak_pensiun'=>0,
				'user_act'=>$this->session->userdata('fid'),
				'tgl_act'=>date('Y-m-d H:i:s')
			);
			if(isset($_POST['tunjpasangan'])){
				$data['hak_pensiun'] = 1;
			}
			$this->db->where('id_usulan_detail',$id_usulan_detail);
			$this->db->where('pegawai_id',$pegawai_id);
			$this->db->where('suami_istri_id',$in);
			$this->db->update('ep_tx_usulan_pemberhentain_detail_keluarga',$data);
				$affectdata = $this->db->affected_rows();
				if($affectdata == 0){
					$this->db->insert('ep_tx_usulan_pemberhentain_detail_keluarga',$data);
				}
		}
		//anak
		foreach($_POST['anak'] as $in=>$val){
			$data = array(
				'id_usulan_detail'=>$id_usulan_detail,
				'pegawai_id'=>$pegawai_id,
				'suami_istri_id'=>0,
				'anak_id'=>$in,
				'jenis_data'=>2,
				'hak_pensiun'=>0,
				'user_act'=>$this->session->userdata('fid'),
				'tgl_act'=>date('Y-m-d H:i:s')
			);
			if(isset($_POST['tunjanak'][$in])){
				$data['hak_pensiun'] = 1;
			}
			$this->db->where('id_usulan_detail',$id_usulan_detail);
			$this->db->where('pegawai_id',$pegawai_id);
			$this->db->where('anak_id',$in);
			$this->db->update('ep_tx_usulan_pemberhentain_detail_keluarga',$data);
				$affectdata = $this->db->affected_rows();
				if($affectdata == 0){
					$this->db->insert('ep_tx_usulan_pemberhentain_detail_keluarga',$data);
				}
		}
	}

	function uploadDocument(){
		$nip = $_POST['NIP'];
		$id_usulan_detail = $_POST['id_usulan_detail'];
		$pegawai_id = $_POST['pegawai_id'];
		$config['upload_path'] = './dokumen/' . $nip . '/';
		$config['allowed_types'] = 'pdf';
		$config['max_size']     = '2000';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$files = $_FILES;
		foreach($_FILES['dokumen']['name'] as $ind => $val){
			$tempfile = $files['dokumen']['tmp_name'][$ind];
			if($tempfile != ''){
			
				$_FILES['dokumen']['name']= 'EP_SYARAT_' . $nip . '_' .$id_usulan_detail.'-'.$ind . '.pdf';
				$_FILES['dokumen']['type']= $files['dokumen']['type'][$ind];
				$_FILES['dokumen']['tmp_name']= $files['dokumen']['tmp_name'][$ind];
				$_FILES['dokumen']['error']= $files['dokumen']['error'][$ind];
				$_FILES['dokumen']['size']= $files['dokumen']['size'][$ind];
				if (!$this->upload->do_upload('dokumen')) {
					$e = $this->upload->display_errors();
					$a = $e;
				} else {
					$namafile = 'dokumen/' . $nip . '/EP_SYARAT_' . $nip . '_' . $id_usulan_detail.'-'.$ind. '.pdf';
					$data = array(
						'pegawai_id' 		=> $pegawai_id,
						'id_usulan_detail'	=> $id_usulan_detail,
						'id_syarat'			=> $ind,
						'file_syarat'		=> $namafile,
						'user_act'			=> $this->session->userdata('fid'),
						'tgl_act'			=> date('Y-m-d H:i:s')
					);
					$this->db->insert('ep_tx_usulan_pemberhentian_syarat',$data);

				}
			}
			if(isset($_POST['pathtemp'][$ind])){
				$data = array(
					'pegawai_id' 		=> $pegawai_id,
					'id_usulan_detail'	=> $id_usulan_detail,
					'id_syarat'			=> $ind,
					'file_syarat'		=> $_POST['pathtemp'][$ind],
					'user_act'			=> $this->session->userdata('fid'),
					'tgl_act'			=> date('Y-m-d H:i:s')
				);
				$this->db->where('id_usulan_detail',$id_usulan_detail);
				$this->db->where('id_syarat',$ind);
				$this->db->update('ep_tx_usulan_pemberhentian_syarat',$data);
				$affectdata = $this->db->affected_rows();
				if($affectdata == 0){
					$this->db->insert('ep_tx_usulan_pemberhentian_syarat',$data);
				}
				
			}
		}
	}

	function getpegawaiData(){
		$nip = $_POST['nip'];
		$squp = $this->model->queryBiodatapegawaiNIP($nip);
		$sq = $this->db->query($squp)->row();
		$data = array();
		if($sq){
			$data = array(
				'result'=>1,
				'data'=>$sq
			);
		}else{
			$data = array(
				'result'=>0,
				'msg'=>'Data Tidak Ditemukan'
			);
		}

		echo json_encode($data);
	}

	function updateDetail(){
		$id = $_POST['id'];
		$data = $_POST;
		$this->db->where('id',$id);
		$this->db->update('ep_tx_usulan_pemberhentian_detail',$data);
		$affectedRows=$this->db->affected_rows();
		$data = array(
			'id'=>md5($id),
			'row_affected'=>$affectedRows,
			'msg'=>$affectedRows.' Data Updated'
		); 
		echo json_encode($data);

	}

	function updateDetailketerangan(){
		$id = $_POST['id'];
		$data = $_POST;
		$data['kab_id_setelah_pensiun'] = $this->getidwil($data['kab_id_setelah_pensiun']);
		$data['kec_id_setelah_pensiun'] = $this->getidwil($data['kec_id_setelah_pensiun']);
		$data['kel_id_setelah_pensiun'] = $this->getidwil($data['kel_id_setelah_pensiun']);
		$this->db->where('id',$id);
		$this->db->update('ep_tx_usulan_pemberhentian_detail',$data);
		$affectedRows=$this->db->affected_rows();
		$data = array(
			'id'=>md5($id),
			'row_affected'=>$affectedRows,
			'msg'=>$affectedRows.' Data Updated'
		); 
		echo json_encode($data);

	}

	function add( $id = null ) 
	{
		
		$row = $this->model->getRow( $id );
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['row']['nip_pegawai'] = $row['NIP_BARU'];
			$this->data['row']['nama_pegawai'] = $row['NAMA_PEGAWAI'];
		} else {
			$this->data['row'] = $this->model->getColumnTable('ep_tx_usulan_pemberhentian_detail'); 
			$this->data['row']['nip_pegawai'] = '';
			$this->data['row']['nama_pegawai'] = '';
		}
	
		$this->data['id'] = $id;

		echo $this->data['content'] = $this->load->view('epusulanpemberhentianpegawai/form',$this->data, true );		
	  	//$this->load->view('layouts/main', $this->data );
	
	}
	
	function save() {
		
		$rules = $this->validateForm();

		$this->form_validation->set_rules( $rules );
		if( $this->form_validation->run() )
		{
			$data = $this->validatePost();
			
			$data['usulan_user_act'] = $this->session->userdata('fid');
			$data['usulan_tgl_act'] = date("Y-m-d H:i:s");
			$ID = $this->model->insertRow($data , $this->input->get_post( 'id' , true ));
			// Input logs
			if( $this->input->get( 'id' , true ) =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$outputSimpan = array( 'id'=>$ID);
			echo json_encode($outputSimpan);		
			
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

	function getidwil($d)
	{
		$dx = explode('*', $d);
		$l = count($dx);
		return $dx[$l - 1];
	}


}
