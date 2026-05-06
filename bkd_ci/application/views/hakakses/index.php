
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
				
			</div>

		</div> 		

		
	
	<ul class="nav nav-tabs" style="margin-bottom:10px;">
	  <li <?php if($type =='addon') echo 'class="active"'?>><a href="<?php echo site_url('sximo/module');?>"><?php echo $this->lang->line('core.fr_mymodule'); ?>  </a></li>
	 
	</ul>
		
	<?php echo $this->session->flashdata('message');?>	
	
	
	<div class="table-responsive ibox-content" style="min-height:400px;">
	<?php if(count($rowData) >=1) :?> 
		<table class="table table-striped ">
			<thead>
			<tr>
				<th><?php echo $this->lang->line('core.btn_action'); ?> </th>	
				<th><?php echo $this->lang->line('core.t_module'); ?> </th>
				<!--th>Controller</th>
				<th>Database</th>
				<th>PRI</th-->
				<th>Created</th>
		
			</tr>
			</thead>
        <tbody>
		<?php foreach ($rowData as $row) : ?>
			<tr>		
				<td>
				<div class="btn-group">
						<a href="<?php echo site_url('hakakses/permission/'.$row->module_name);?>"><i class="fa fa-edit"></i> Edit Permission </a>&nbsp;&nbsp;
						
				</div>					
				</td>
				<td><?php echo $row->module_title ;?> </td>
				<!--td><?php echo $row->module_name ;?> </td>
				<td><?php echo $row->module_db ;?> </td>
				<td><?php echo $row->module_db_key ;?> </td-->
				<td><?php echo $row->module_created ;?> </td>
			</tr>
		<?php endforeach;?>	
	</tbody>		
	</table>
	
	<?php else:?>
		
		<p class="text-center" style="padding:50px 0;"><?php echo $this->lang->line('core.norecord'); ?> ! 
		<br /><br />
		<a href="<?php echo site_url('sximo/module/create');?>" class="btn btn-default "><i class="icon-plus-circle2"></i><?php echo $this->lang->line('core.fr_newmodule'); ?> </a>
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
