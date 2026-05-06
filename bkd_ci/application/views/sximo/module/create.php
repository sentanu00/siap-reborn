<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>
           Create Module</h4>
<span>Form create Module</span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Create Module</a>

</ul>
</div>
</div>
</div>
</div>
	<hr />

  
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
              	<div class="box-header with-border">

	 <div class="page-content-wrapper m-t">  
	<?php echo $this->session->flashdata('message');?>	
	<form  action="<?php echo site_url('sximo/module/saveCreate/');?>" method="post" parsley-validate novalidate>


	<div class="form-group row  has-feedback">
		<label class="col-sm-3 text-right"><?php echo $this->lang->line('core.fr_modtitle'); ?> </label>
		<div class="col-sm-9">	
			<input name="module_title" class="form-control" placeholder="Title Name" required />
		</div>
	</div>		
	
	<div class="form-group row  ">
		<label class="col-sm-3 text-right"><?php echo $this->lang->line('core.fr_modnote'); ?> </label>
		<div class="col-sm-9">	
		<input name="module_note" class="form-control" placeholder="Short description module" required />
		
		</div>
	</div>


	<div class="form-group row  ">
		<label class="col-sm-3 text-right">Class Controller </label>
		<div class="col-sm-9">	
		<input name="module_name" class="form-control" placeholder="Class Controller / Module Name" required />
	  	
		</div>
	</div>	
		
	
	<div class="form-group row ">
		<label class="col-sm-3 text-right"><?php echo $this->lang->line('core.fr_modtable'); ?> </label>
		<div class="col-sm-9">	
			<select name="module_db" class="form-control">
				<?php foreach($tables as $table){?>
					<option value="<?php echo $table;?>"><?php echo $table;?></option>
				<?php } ?>
			</select>	 	
		</div>
	</div>	
		
	<div class="form-group row  " style="display:none;">
		<label class="col-sm-3 text-right">Author </label>
		<div class="col-sm-9">	
	  
		
		</div>
	</div>	
		


	<div class="form-group row  switchSql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">	
			<label class="radio radio-inline">
				<input type="radio" name="creation" value="auto"  checked="checked"  /> 
				Auto Mysql Statment 
			</label>		
			<label class="radio radio-inline">
				<input type="radio" name="creation" value="manual"  />
				Manual Mysql Statment 
			</label>		
		</div>
	</div>	
	
	<div class="form-group row  manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			<textarea class="form-control" name="sql_select" placeholder="SQL Select & Join Statement" rows="3" id="sql_select"></textarea>	  
		</div> 
	</div>	
	
	<div class="form-group row  manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			<textarea class="form-control" name="sql_where" placeholder="SQL Where Statement" rows="2" id="sql_where"></textarea>	 
		</div> 
	</div>		

	<div class="form-group row  manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			<textarea class="form-control" name="sql_group" placeholder="SQL Grouping Statement" rows="2" id="sql_group"></textarea>	
			
		</div> 
	</div>	
	
		
      <div class="form-group row ">
		<label class="col-sm-3 text-right"> </label>
		<div class="col-sm-9">	
	  	<button type="submit" class="btn btn-primary ">  Create New Module </button>
		</div>	  

      </div>
    
 </form>
</div>
          </div>
          </div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.manualsql').hide();
		$('.switchSql input:radio').on('ifClicked', function() {
		  val = $(this).val(); 
			if(val == 'manual')
			{
				$('.manualsql').show();
				$('#sql_select').attr("required","true");
				$('#sql_where').attr("required","true");
				
			} else {
				$('.manualsql').hide();
				$('#sql_select').removeAttr("required");
				$('#sql_where').removeAttr("required");
	
			}		  
		  
		});

	});
	
</script>
