<div class="sbox">
	<div class="sbox-title">
			
				<h3 ><?php echo CNF_APPNAME ;?></h3>
				
	</div>
	<div class="sbox-content" style="padding:10px">
	<div class="text-center">
		<img src="<?php echo base_url().'sximo/themes/mango/img/logo.png';?>" width="90" height="90" />
	</div>	
	<?php echo $this->session->flashdata('message');?>	
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors');?>
		</ul>
	<form class="form-signup" action="<?php echo site_url('user/create');?>" method="post">
	
	<div class="form-group has-feedback">
		<label> Nama Perusahaan	<span class="asterix">*</span> </label>
		<?php echo form_input(array('name'=>'firstname','placeholder'=>'First Name','required'=>'true','class'=>'form-control'));?>
		<i class="icon-users form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label> Nama User	 <span class="asterix">*</span></label><br />
		<?php echo form_input(array('name'=>'lastname','placeholder'=>'Last Name','required'=>'true','class'=>'form-control'));?>
		<i class="icon-users form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label> Email Login	 <span class="asterix">*</span></label>
		<?php echo form_input(array('name'=>'email','placeholder'=>'Email Address','required'=>'true','class'=>'form-control'));?>
		<i class="icon-envelop form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label> Password <span class="asterix">*</span></label>
		<?php echo form_password(array('name'=>'password','placeholder'=>'Password','required'=>'true','class'=>'form-control'));?>
		<i class="icon-lock form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label>Confirm Password <span class="asterix">*</span></label>
		<?php echo form_password(array('name'=>'password_confirmation','placeholder'=>'Confirm Password','required'=>'true','class'=>'form-control'));?>
		<i class="icon-lock form-control-feedback"></i>
	</div>
	<div class="form-group has-feedback">
		<label> Alamat	 <span class="asterix">*</span></label><br />
		<?php echo form_input(array('name'=>'alamat','placeholder'=>'alamat perusahaan','required'=>'true','class'=>'form-control'));?>
		<i class="icon-users form-control-feedback"></i>
	</div>
	<div class="form-group has-feedback">
		<label> No Telepon	 <span class="asterix">*</span></label><br />
		<?php echo form_input(array('name'=>'lastname','placeholder'=>'notlp','required'=>'true','class'=>'form-control'));?>
		<i class="icon-users form-control-feedback"></i>
	</div>
	<div class="form-group has-feedback">
		<label> Website	 <span class="asterix">*</span></label><br />
		<?php echo form_input(array('name'=>'website','placeholder'=>'Website Perusahaan','class'=>'form-control'));?>
		<i class="icon-users form-control-feedback"></i>
	</div>

      <div class="row form-actions">
        <div class="col-sm-12">
          <button type="submit" style="width:100%;" class="btn btn-primary pull-right"><i class="icon-user-plus"></i> Sign Up</button>
       </div>
      </div>
	  <p style="padding:10px 0" class="text-center">
	  <a href="<?php echo site_url('user/login');?>"> Kembali ke halaman Login </a> | <a href="<?php echo site_url();?>"> Kembali Ke Halaman Depan </a> 
   		</p>
 </form>
 </div>
</div> 
