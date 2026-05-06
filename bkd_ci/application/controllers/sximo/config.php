<?php

class Config extends SB_Controller  {

	protected $layout = "layouts.main";
	
	public function __construct() {
		
		parent::__construct();
		$this->data = array(
			'pageTitle'	=> 'Site Config',
			'pageNote'	=> 'Manage Setting COnfiguration'
		); 	
		if(!$this->session->userdata('logged_in'))
		{
			redirect('user/login',301);
		}

		if($this->session->userdata('gid') !=1) redirect('dashboard',301);
			
	} 	


	public function index()
	{
		$this->data['themes'] = self::themeOption();
		$this->data['groups'] = $this->db->get('tb_groups');
		$this->data['content'] = $this->load->view('sximo/config/index',$this->data, true );		
    	$this->load->view('layouts/main', $this->data );
	}

	public function settingpengolahan()
	{
		$this->data['content'] = $this->load->view('tanalisarendemen/pengolahansetting',$this->data, true );		
    	$this->load->view('layouts/main', $this->data );
	}

	public function postSavePengolahan()
	{
			$val  =		"<?php \n"; 

			$val .= 	"define('PN_AWAL_GILING','".$this->input->post('pn_awal_giling',true)."');\n";
			$val .= 	"define('PN_FAKTOR_KONVERSI','".$this->input->post('pn_faktor_konversi',true)."');\n";
			$val .= 	"define('PN_FAKTOR_RENDEMEN','".$this->input->post('pn_faktor_rendemen',true)."');\n";
			$val .= 	"define('PN_FAKTOR_PERAH','".$this->input->post('pn_faktor_perah',true)."');\n";
			$val .= 	"define('PN_UBAH_TERAKHIR','".date('Y-m-d H:i:s')."');\n";
			$val .= 	"define('PN_USER_UBAH','".$this->session->userdata('fid')."');\n";
			$val .= 	"?>";
				
		$filename = 'setpengolahan.php';
		file_put_contents( $filename , $val  );

		$tes  =		"\n"; 
			$tes .= 	"FAKTOR_KONVERSI = ".$this->input->post('pn_faktor_konversi',true)."\n";
			$tes .= 	"FAKTOR_RENDEMEN = ".$this->input->post('pn_faktor_rendemen',true)."\n";
			$tes .= 	"FAKTOR_PERAH = ".$this->input->post('pn_faktor_perah',true)."\n";
			
		$user = $this->session->userdata('fid');

		$data = array(
			'module'	=> 'settingpengolahan',
			'task'		=> 'save',
			'user_id'	=> $this->session->userdata('uid'),
			'ipaddress'	=> $this->input->ip_address(),
			'note'		=> 'Rubah Setting Pengolahan dengan data '.$tes.' Oleh : '.$user
		);
		 $this->db->insert( 'tb_logs',$data);

		 $this->db->query("delete from tb_setting");
		 $dtx = array(
		 		'awal_giling' => $this->input->post('pn_awal_giling',true),
		 		'faktor_konv' => $this->input->post('pn_faktor_konversi',true),
		 		'faktor_rend' => $this->input->post('pn_faktor_rendemen',true),
		 		'faktor_perah' => $this->input->post('pn_faktor_perah',true),
		 		'log_simpan' => date('Y-m-d H:i:s'),
		 		'log_user'=>$this->session->userdata('uid')
		 	);
		  $this->db->insert( 'tb_setting',$dtx);


		$this->session->set_flashdata('message',SiteHelpers::alert('success','Site Setting Has Been Updated'));
		redirect( site_url('sximo/config/settingpengolahan'));
	
	}


	
	public function postSave()
	{
			$val  =		"<?php \n"; 
			$val .= 	"define('CNF_APPNAME','". $this->input->post('cnf_appname',true)."');\n";
			$val .= 	"define('CNF_NAMAPERUSAHAAN','". $this->input->post('cnf_namaperusahaan',true)."');\n";
			$val .= 	"define('CNF_PG','". $this->input->post('cnf_pg',true)."');\n";
			$val .= 	"define('CNF_ALAMAT','". $this->input->post('cnf_alamat',true)."');\n";	
			$val .= 	"define('CNF_METAKEY','". $this->input->post('cnf_metakey',true)."');\n";	
			$val .= 	"define('CNF_METADESC','". $this->input->post('cnf_metadesc',true)."');\n";		
			$val .= 	"define('CNF_GROUP','". $this->input->post('cnf_group',true)."');\n";	
			$val .= 	"define('CNF_ACTIVATION','". $this->input->post('cnf_activation',true)."');\n";	
			$val .= 	"define('CNF_REGIST','". $this->input->post('cnf_regist',true)."');\n";	
			$val .= 	"define('CNF_FRONT','".$this->input->post('cnf_front',true)."');\n";		
			$val .= 	"define('CNF_THEME','".$this->input->post('cnf_theme',true)."');\n";
			$val .= 	"define('CNF_MULTILANG','".$this->input->post('cnf_multilang',true)."');\n";
			$val .= 	"define('CNF_RECAPTCHA','".CNF_RECAPTCHA."');\n";
			$val .= 	"define('CNF_RECAPTCHA_PUBLIC','".CNF_RECAPTCHA_PUBLIC."');\n";
			$val .= 	"define('CNF_RECAPTCHA_PRIVATE','".CNF_RECAPTCHA_PRIVATE."');\n";
			$val .= 	"define('CNF_LOGINFB','".CNF_LOGINFB."');\n";
			$val .= 	"define('CNF_LOGINFB_ID','".CNF_LOGINFB_ID."');\n";
			$val .= 	"define('CNF_LOGINFB_SECRET','".CNF_LOGINFB_SECRET."');\n";
			$val .= 	"define('CNF_LOGINGG','".CNF_LOGINGG."');\n";
			$val .= 	"define('CNF_LOGINGG_ID','".CNF_LOGINGG_ID."');\n";
			$val .= 	"define('CNF_LOGINGG_SECRET','".CNF_LOGINGG_SECRET."');\n";
			$val .= 	"define('CNF_LOGINTW','".CNF_LOGINTW."');\n";
			$val .= 	"define('CNF_LOGINTW_ID','".CNF_LOGINTW_ID."');\n";
			$val .= 	"define('CNF_LOGINTW_SECRET','".CNF_LOGINTW_SECRET."');\n";

			$val .= 	"define('CNF_COMPANYCODE','".$this->input->post('cnf_companycode',true)."');\n";
			$val .= 	"define('CNF_PLANCODE','".$this->input->post('cnf_plancode',true)."');\n";
			$val .= 	"define('CNF_TAHUNTANAM','".$this->input->post('cnf_tahuntanam',true)."');\n";
			$val .= 	"define('CNF_TAHUNGILING','".$this->input->post('cnf_tahungiling',true)."');\n";
			$val .= 	"define('CNF_METODE','".$this->input->post('cnf_metode',true)."');\n";
			$val .= 	"define('CNF_RAFAKSI','".$this->input->post('cnf_rafaksi',true)."');\n";
			$val .= 	"define('CNF_KONSEP','".$this->input->post('cnf_konsep',true)."');\n";
			$val .= 	"define('CNF_HAL','".$this->input->post('cnf_hal',true)."');\n";
			$val .= 	"define('CNF_KEYSYNC','".$this->input->post('cnf_keysync',true)."');\n";
			$val .= 	"define('CNF_MUTU_TERBAKAR','".$this->input->post('cnf_mutu_terbakar',true)."');\n";
			$val .= 	"define('CNF_GM','".$this->input->post('cnf_gm',true)."');\n";
			$val .= 	"define('CNF_MANPENGOLAHAN','".$this->input->post('cnf_manpengolahan',true)."');\n";
			$val .= 	"define('CNF_MANTANAMAN','".$this->input->post('cnf_mantanaman',true)."');\n";
			$val .= 	"include 'setpengolahan.php';\n";
			$val .= 	"?>";
				
		$filename = 'setting.php';
		file_put_contents( $filename , $val  );

		$user = $this->session->userdata('fid');
		$data = array(
			'module'	=> 'settingaplikasi',
			'task'		=> 'save',
			'user_id'	=> $this->session->userdata('uid'),
			'ipaddress'	=> $this->input->ip_address(),
			'note'		=> 'Rubah Setting Aplikasi dengan data '.$val.' Oleh : '.$user
		);
		$this->db->insert( 'tb_logs',$data);


		$this->session->set_flashdata('message',SiteHelpers::alert('success','Site Setting Has Been Updated'));
		redirect( site_url('sximo/config'));
	
	}


	public function blast()
	{
		$this->data = array(
			'groups'	=> $this->db->get('tb_groups'),
			'pageTitle'	=> 'Blast Email',
			'pageNote'	=> 'Send email to users'
		);
		$this->data['content'] = $this->load->view('sximo/config/blast',$this->data, true );		
    	$this->load->view('layouts/main', $this->data );				
	}

	function doBlast()
	{
		if(!is_null($this->input->post('groups')))
		{
			$groups = $this->input->post('groups');
			for($i=0; $i<count($groups); $i++)
			{
				if($this->input->post('uStatus') == 'all')
				{
					$users = $this->db->get_where('tb_users',array('group_id'=>$groups[$i]));
				} else {
					$users = $this->db->get_where('tb_users',array('group_id'=>$groups[$i],'active'=>$this->input->post('uStatus')));
				}
				$count = 0;
				foreach($users->result() as $row)
				{

					$to = $row->email;
					$subject = $this->input->post('subject');
					$message = $this->input->post('message');
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.CNF_APPNAME.' <'.CNF_EMAIL.'>' . "\r\n";
						mail($to, $subject, $message, $headers);
					
					$count = ++$count;					
				} 
				
			}
			$this->session->set_flashdata('message',SiteHelpers::alert('success','Total '.$count.' Message has been sent'));
			return redirect('sximo/config/blast',301);

		}
	

	}


	public function email()
	{
		
		$regEmail 	= "application/views/emails/registration.php";
		$resetEmail = "application/views/emails/reminder.php";
		$this->data = array(
			'pageTitle'	=> 'Blast Email',
			'pageNote'	=> 'Send email to users',
			'regEmail' 	=> file_get_contents($regEmail),
			'resetEmail'	=> 	file_get_contents($resetEmail)
		);	
		
		$this->data['content'] = $this->load->view('sximo/config/email',$this->data, true );		
    	$this->load->view('layouts/main', $this->data );	
	
	}
	
	function postEmail()
	{
		$regEmailFile = "application/views/emails/registration.php";
		$resetEmailFile = "application/views/emails/reminder.php";
		
		$fp= fopen($regEmailFile,"w+"); 				
		fwrite($fp,$_POST['regEmail']); 
		fclose($fp);	
		
		$fp= fopen($resetEmailFile,"w+"); 				
		fwrite($fp,$_POST['resetEmail']); 
		fclose($fp);

		$this->session->set_flashdata('message',SiteHelpers::alert('success','Email Has Been Updated'));
		redirect('sximo/config/email',301);	
	
	}

	
	public function themeOption()
	{
    	$theme_path = "application/views/layouts/";
		$themes = scandir( $theme_path );
		$t = array();
		foreach($themes as $value) {
			if($value === '.' || $value === '..') continue;
			if(is_dir( "./application/views/layouts/" . $value) && file_exists("./application/views/layouts/" .$value.'/info.json' ) )
			{
				$fp = file_get_contents( $theme_path .$value.'/info.json');
				$fp = json_decode($fp,true);
				$t[] =  $fp ;
				
			} 
			
		}	
		return $t;
	}		
	
	function security() {
	  
		$this->data['themes'] = self::themeOption();
		$this->data['groups'] = $this->db->get('tb_groups');
		$this->data['content'] = $this->load->view('sximo/config/security',$this->data, true );		
    	$this->load->view('layouts/main', $this->data );
	  
	  
	}
	
	function postSecurity() {
	  
			$val  =		"<?php \n"; 
			$val .= 	"define('CNF_APPNAME','". CNF_APPNAME ."');\n";
			$val .= 	"define('CNF_APPDESC','". CNF_APPDESC ."');\n";
			$val .= 	"define('CNF_COMNAME','". CNF_COMNAME ."');\n";
			$val .= 	"define('CNF_EMAIL','". CNF_EMAIL ."',true);\n";	
			$val .= 	"define('CNF_METAKEY','". CNF_METAKEY ."');\n";	
			$val .= 	"define('CNF_METADESC','". CNF_METADESC ."');\n";		
			$val .= 	"define('CNF_GROUP','". CNF_GROUP ."');\n";	
			$val .= 	"define('CNF_ACTIVATION','". CNF_ACTIVATION ."');\n";	
			$val .= 	"define('CNF_REGIST','". CNF_REGIST ."');\n";	
			$val .= 	"define('CNF_FRONT','".CNF_FRONT ."');\n";		
			$val .= 	"define('CNF_THEME','".CNF_THEME ."');\n";
			$val .= 	"define('CNF_MULTILANG','".CNF_MULTILANG."');\n";
			
			$val .= 	"define('CNF_RECAPTCHA','".$this->input->post('cnf_recaptcha',true)."');\n";
			$val .= 	"define('CNF_RECAPTCHA_PUBLIC','".$this->input->post('cnf_recaptcha_public',true)."');\n";
			$val .= 	"define('CNF_RECAPTCHA_PRIVATE','".$this->input->post('cnf_recaptcha_private',true)."');\n";
			$val .= 	"define('CNF_LOGINFB','".$this->input->post('cnf_loginfb',true)."');\n";
			$val .= 	"define('CNF_LOGINFB_ID','".$this->input->post('cnf_loginfb_id',true)."');\n";
			$val .= 	"define('CNF_LOGINFB_SECRET','".$this->input->post('cnf_loginfb_secret',true)."');\n";
			$val .= 	"define('CNF_LOGINGG','".$this->input->post('cnf_logingg',true)."');\n";
			$val .= 	"define('CNF_LOGINGG_ID','".$this->input->post('cnf_logingg_id',true)."');\n";
			$val .= 	"define('CNF_LOGINGG_SECRET','".$this->input->post('cnf_logingg_secret',true)."');\n";
			$val .= 	"define('CNF_LOGINTW','".$this->input->post('cnf_logintw',true)."');\n";
			$val .= 	"define('CNF_LOGINTW_ID','".$this->input->post('cnf_logintw_id',true)."');\n";
			$val .= 	"define('CNF_LOGINTW_SECRET','".$this->input->post('cnf_logintw_secret',true)."');\n";
			$val .= 	"?>";
	
		$filename = 'setting.php';
		file_put_contents( $filename , $val );
		
		$this->session->set_flashdata('message',SiteHelpers::alert('success','Security Setting Has Been Updated'));
		redirect('sximo/config/security',301);	
	  
	  
	}
	

	
}