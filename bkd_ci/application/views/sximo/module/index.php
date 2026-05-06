<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>
            Module</h4>
<span>List All Modules</span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Modules</a>

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
                  <h3 class="box-title"><?php echo $pageTitle ;?></h3>
 <div class="box-body">
 	<div class="page-content-wrapper">
	<div class="ribon-sximo">
		<div class="row m-l-none m-r-none m-t  white-bg shortcut " >
			<div class="col-sm-6 col-md-3 b-r  p-sm ">
				<span class="pull-left m-r-sm text-info"><i class="ti-pulse"></i></span> 
				<a href="<?php echo site_url('sximo/module/create');?>" class="clear">
					<span class="h3 block m-t-xs"><strong><?php echo $this->lang->line('core.fr_createmodule'); ?> </strong>
				</a>
			</div>

		</div> 		

		
	
	<ul class="nav nav-tabs md-tabs" role="tablist">
	  <li class="nav-item"><a href="<?php echo site_url('sximo/module');?>"   class="nav-link <?php if($type =='addon') echo 'active'?>"><?php echo $this->lang->line('core.fr_mymodule'); ?>  </a></li>
	  <li class="nav-item"><a href="<?php echo site_url('sximo/module?t=core');?>" class="nav-link <?php if($type =='core') echo 'active';?>"><?php echo $this->lang->line('core.tab_core'); ?> </a></li>
	</ul>
		
	<?php echo $this->session->flashdata('message');?>	
	
	
	<div class="table-responsive ibox-content" style="min-height:400px;">
	<?php if(count($rowData) >=1) :?> 
		<table class="table table-striped ">
			<thead>
			<tr>
				<th><?php echo $this->lang->line('core.btn_action'); ?> </th>					
				<th><input type="checkbox" class="checkall" /></th>
				<th><?php echo $this->lang->line('core.t_module'); ?> </th>
				<th>Controller</th>
				<th>Database</th>
				<th>PRI</th>
				<th>Created</th>
		
			</tr>
			</thead>
        <tbody>
		<?php foreach ($rowData as $row) : ?>
			<tr>		
				<td>
				<div class="btn-group">
						<?php if($type !='core') : ?>
						<a href="<?php echo site_url($row->module_name);?>"><i class="fa fa-cog"></i><?php echo $this->lang->line('core.fr_viewmodule'); ?> </a>&nbsp;&nbsp;
						<?php endif;?>
						<a href="<?php echo site_url('sximo/module/config/'.$row->module_name);?>"><i class="ti-pencil-alt"></i> <?php echo $this->lang->line('core.fr_editmodule'); ?> </a>&nbsp;&nbsp;
						
				</div>					
				</td>
				<td>
				 <?php if($type !='core'):?>
				<input type="checkbox" class="ids" name="id[]" value="<?php echo $row->module_id ;?>" /> <?php endif;?></td>
				<td><?php echo $row->module_title ;?> </td>
				<td><?php echo $row->module_name ;?> </td>
				<td><?php echo $row->module_db ;?> </td>
				<td><?php echo $row->module_db_key ;?> </td>
				<td><?php echo $row->module_created ;?> </td>
			</tr>
		<?php endforeach;?>	
	</tbody>		
	</table>
	
	<?php else:?>
		
		<p class="text-center" style="padding:50px 0;"><?php echo $this->lang->line('core.norecord'); ?> ! 
		<br /><br />
		<a href="<?php echo site_url('sximo/module/create');?>" class="btn btn-default "><i class="ti-plus"></i> <?php echo $this->lang->line('core.fr_newmodule'); ?> </a>
		 </p>	
	<?php endif;?>
	</div>	
	
	</div>	

</div>	  
	   </div>
          </div>
          </div>	  
	   </div>
          </div>
  <script language='javascript' >
  jQuery(document).ready(function($){
    $('.post_url').click(function(e){
      e.preventDefault();
      if( ( $('.ids',$('#SximoTable')).is(':checked') )==false ){
        alert( $(this).attr('data-title') + " not selected");
        return false;
      }
      $('#SximoTable').attr({'action' : $(this).attr('href') }).submit();
    })
  })
  </script>	  
