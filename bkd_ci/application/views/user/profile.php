<section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
              	<div class="box-header with-border">
                  <h3 class="box-title"><?php echo $pageTitle ;?></h3>
                   <div class="box-body">

	<div class="page-content-wrapper m-t">
    <!-- Page header -->
    
	<div class="page-content-wrapper m-t">
	<ul class="nav nav-tabs nav-underline" >
	  <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab"><?php echo $this->lang->line('core.personalinfo'); ?> </a></li>
	  <li class="nav-item" ><a class="nav-link" href="#pass" data-toggle="tab"><?php echo $this->lang->line('core.password'); ?> </a></li>
	</ul>	
	
	<div class="tab-content">
	  <div class="tab-pane active m-t" id="info">
	  <br />
	  	<?php echo $this->session->flashdata('message');?>
		<?php echo validation_errors(); ?>
	  	<form class="form-horizontal" action="<?php echo site_url('user/saveProfile') ;?>" method="post"  parsley-validate='true' novalidate='true' enctype="multipart/form-data"> 
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Username </label>
			<div class="col-md-8">
			<input name="username" type="text" id="username" disabled="disabled" class="form-control input-sm" required  value="<?php echo $info->username ;?>" />  
			 </div> 
		  </div>  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> Email  </label>
			<div class="col-md-8">
			<input name="email" type="email" id="email"  class="form-control" value="<?php echo $info->email ?>" /> 
			<?php echo form_error('email'); ?>
			 </div> 
		  </div> 	  
	  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.firstname'); ?> </label>
			<div class="col-md-8">
			<input name="first_name" type="text" id="first_name" class="form-control " required value="<?php echo $info->first_name ?>" /> 
			 </div> 
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.lastname'); ?> </label>
			<div class="col-md-8">
			<input name="last_name" type="text" id="last_name" class="form-control " required value="<?php echo $info->last_name ?>" />  
			 </div> 
		  </div>    
	
		  <div class="form-group  " >
			<label for="ipt" class=" control-label col-md-4 text-right"> Avatar </label>
			<div class="col-md-8">
			<input type="file" name="avatar">
			<br />
			 Image Dimension 80 x 80 px <br />
			<?php echo SiteHelpers::showUploadedFile($info->avatar,'/uploads/users/') ?>
			
			 </div> 
		  </div>  
	
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> </label>
			<div class="col-md-8">
				<button class="btn btn-success" type="submit"><?php echo $this->lang->line('core.sb_savechanges'); ?> </button>
			 </div> 
		  </div> 	
		
		</form>
	  </div>
  
	  <div class="tab-pane  m-t" id="pass">
	   <br />
	  <form class="form-horizontal" action="<?php echo site_url('user/savePassword') ;?>" method="post"  parsley-validate='true' novalidate='true'>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.newpassword'); ?> </label>
			<div class="col-md-8">
			<input name="password" type="password" id="password" class="form-control input-sm" value="" /> 
			 </div> 
		  </div>  
		  
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.repassword'); ?> </label>
			<div class="col-md-8">
			<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />  
			 </div> 
		  </div>    
		 
		
		  <div class="form-group">
			<label for="ipt" class=" control-label col-md-4"> </label>
			<div class="col-md-8">
				<button class="btn btn-danger" type="submit"><?php echo $this->lang->line('core.sb_savechanges'); ?> </button>
			 </div> 
		  </div>   
		</form>
	  </div>
  


</div>
</div>
 
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 </section>
 