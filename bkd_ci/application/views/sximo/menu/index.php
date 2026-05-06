<script type="text/javascript" src="<?php echo base_url().'sximo/js/plugins/jquery.nestable.js';?>"></script>

<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Menu Management</h4>
<span>Setting Menu akses</span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!">Menu Akses</a>

</ul>
</div>
</div>
</div>
</div>

	<div class="row">  
		<div class="col-sm-12"> 
	<ul class="nav nav-tabs md-tabs" role="tablist">

<li class="nav-item">
<a class="nav-link <?php if($active == 'sidebar') echo 'active';?>"  href="<?php echo  site_url('sximo/menu/index?pos=sidebar');?>" role="tab"><?php echo $this->lang->line('core.tab_sidemenu'); ?></a>
<div class="slide"></div>
</li>
</ul>	

	<?php echo $this->session->flashdata('message');?>	
	<hr />
	<div class="row">
		<div class="col-sm-6">
			<div class="box box-danger">
              	<div class="box-header with-border">

            <div id="list2" class="dd" style="min-height:350px;">
              <ol class="dd-list">
			<?php foreach ($menus as $menu) : ?>
				  <li data-id="<?php echo $menu['menu_id'];?>" class="dd-item dd3-item">
					<div class="dd-handle dd3-handle"></div><div class="dd3-content"><?php echo  $menu['menu_name'];?>
						<span class="pull-right">
						<a href="<?php echo site_url('sximo/menu/index/'.$menu['menu_id'].'?pos='.$active);?>"><i class="ti-pencil-alt" style="float:right!important"></i></a></span>
					</div>
					<?php if(count($menu['childs']) > 0) : ?>
						<ol class="dd-list" style="">
							<?php foreach ($menu['childs'] as $menu2) : ?>
							 <li data-id="<?php echo $menu2['menu_id'];?>" class="dd-item dd3-item">
								<div class="dd-handle dd3-handle"></div><div class="dd3-content"><?php echo $menu2['menu_name'];?>
									<span class="pull-right">
									<a href="<?php echo  site_url('sximo/menu/index/'.$menu2['menu_id'].'?pos='.$active);?>"><i class="ti-pencil-alt" style="float:right!important"></i></a></span>
								</div>
								<?php if(count($menu2['childs']) > 0) : ?>
								<ol class="dd-list" style="">
									<?php foreach($menu2['childs'] as $menu3) : ?>
									 	<li data-id="<?php echo $menu3['menu_id'];?>" class="dd-item dd3-item">
											<div class="dd-handle dd3-handle"></div><div class="dd3-content"><?php echo  $menu3['menu_name'] ;?>
												<span class="pull-right">
												<a href="<?php echo  site_url('sximo/menu/index/'.$menu3['menu_id'].'?pos='.$active);?>"><i class="ti-pencil-alt" style="float:right!important"></i></a>
												</span>
											</div>
										</li>	
									<?php endforeach ;?>
								</ol>
								<?php endif;?>
							</li>							
							<?php endforeach;?>
						</ol>
					<?php endif;?>
				</li>
			<?php endforeach; ?>			  
              </ol>
            </div>
			<form class="form-horizontal" action="<?php echo site_url('sximo/menu/saveOrder')?>" method="post">
			<input type="hidden" name="reorder" id="reorder" value="" />
			 <div class="infobox infobox-danger fade in">
			 <p><?php echo $this->lang->line('core.t_tipsnote'); ?>	</p>
			</div>			
		
			<button type="submit" class="btn btn-primary "><?php echo $this->lang->line('core.sb_reorder'); ?> </button>	
			</form>
		 </div>
		</div>
		</div>

		<div class="col-sm-6">
		<form class="form-horizontal" action="<?php echo site_url('sximo/menu/save')?>" method="post" >
			<div class="box box-danger">
              	<div class="box-header with-border">
				
				<input type="hidden" name="menu_id" id="menu_id" value="<?php echo  $row['menu_id'] ;?>" />																					
				  <div class="form-group  " style="display:none;">
					<label for="ipt" class=" control-label col-md-4"> Parent Id </label>
					<div class="col-md-8">
						<input type="text" name="parent_id" id="reorder" value="<?php  echo $row['parent_id'];?>" class="form-control" />
					  
					 </div> 

				  </div> 
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_mtitle'); ?> </label>
					<div class="col-md-8">
						<input type="text" name="menu_name" id="menu_name" value="<?php  echo $row['menu_name'];?>" class="form-control"  />	
					  <?php if(CNF_MULTILANG ==1) { 
					    $lang = SiteHelpers::langOption();
						foreach($lang as $l) { 
							if($l['folder'] !='en') {
							?>
								<div class="input-group input-group-sm" style="margin:1px 0 !important;">
								 <input name="language_title[<?php echo $l['folder'];?>]" type="text"   class="form-control" placeholder="Title for <?php echo $l['name'];?>"
								 value="<?php echo (isset($menu_lang['title'][$l['folder']]) ? $menu_lang['title'][$l['folder']] : '');?>" />
								<span class="input-group-addon xlick bg-default btn-sm " ><?php echo strtoupper($l['folder']);?></span>
							   </div> 								
							<?php
							}
						
						}
					   
					 } ?>

					  		  
					  
					 </div> 
				  </div> 
				  <div class="form-group   " >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_mtype'); ?> </label> 
					<div class="col-md-8 menutype">
					<label class="radio-inline  ">
						
					<input type="radio" name="menu_type" value="internal" class=""  
					<?php if($row['menu_type']=='internal' || $row['menu_type']=='') echo 'checked="checked"'?> />
					
					Internal
					</label>
					<label class="radio-inline">
					<input type="radio" name="menu_type" value="external"  class="" 
					<?php if($row['menu_type']=='external' ) echo 'checked="checked"';?>  /> External 
					</label>	  
					 </div> 
				  </div> 	
				  			  					
				  <div class="form-group  ext-link" >
					<label for="ipt" class=" control-label col-md-4"> Url  </label>
					<div class="col-md-8">
					    <input type="text" name="url" id="url" value="<?php echo $row['url'];?>" class="form-control" />
					 </div> 
				  </div> 	
								  					
				  <div class="form-group  int-link" >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.t_module'); ?> </label>
					<div class="col-md-8">
					 <input type="text" name="module" id="module" value="<?php echo $row['module'];?>" class="form-control"  />
					  		
					 </div> 
				  </div> 										
					

				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_mposition'); ?> </label>
					<div class="col-md-8">
						<input type="radio" name="position"  value="top" required 
						<?php if($row['position']=='top' ) echo 'checked="checked"';?> /> Top Menu 
						<input type="radio" name="position"  value="sidebar"  required
						<?php if($row['position']=='sidebar' ) echo 'checked="checked"';?>  /> Side Menu 
					 </div> 
				  </div> 	 				
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_miconclass'); ?> </label>
					<div class="col-md-8">
						 <input type="text" name="menu_icons" id="menu_icons" value="<?php echo $row['menu_icons'];?>" class="form-control" />
					 
					  <p> Example : <span class="label label-info"> fa fa-desktop </span>  , <span class="label label-info"> fa fa-cloud-upload </span> </p>
					  <p>Usage : 
					  <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"> Font Awesome </a> class name</p>
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_mactive'); ?> </label>
					<div class="col-md-8">
					<input type="radio" name="active"  value="1" 
					<?php if($row['active']=='1' ) echo 'checked="checked"';?> /> Active 
					<input type="radio" name="active" value="0" 
					<?php if($row['active']=='0' ) echo 'checked="checked"';?> /> Inactive 
										
					 
					 </div> 
				  </div> 

			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4"> Access   <code>*</code></label>
				<div class="col-md-8">
						<?php 
					$pers = json_decode($row['access_data'],true);
					foreach($groups->result() as $group) {
						$checked = '';
						if(isset($pers[$group->group_id]) && $pers[$group->group_id]=='1')
						{
							$checked= ' checked="checked"';
						}						
							?>		
				  <label class="checkbox">
				  <input type="checkbox" name="groups[<?php echo $group->group_id;?>]" value="<?php echo $group->group_id;?>" <?php echo $checked;?>  />   
				  <?php echo $group->name;?>  
				  </label>
			
				  <?php } ?>
						 </div> 
			  </div> 

				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_mpublic'); ?> </label>
					<div class="col-md-8">
					<label class="checkbox"><input  type='checkbox' name='allow_guest' 
 						<?php if($row['allow_guest'] ==1 ) echo 'checked'; ?>	
					   value="1"	/> Yes  </lable>
					</label>   
				  </div>
				</div>
				  
			  <div class="form-group">
				<label class="col-sm-4"> </label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary "><?php echo $this->lang->line('core.submit'); ?> </button>
				<?php if($row['menu_id'] !='') :?>
					<button type="button"onclick="SximoConfirmDelete('<?php echo  site_url('sximo/menu/destroy/'.$row['menu_id']);?>')" class="btn btn-danger ">  Delete </button>
				<?php endif ;?>	
				</div>	  
		
			  </div> 
			
		</div>	  
		 
		</form>
		
		</div>

		</div>

	</div>
		</div>
		<div style="clear:both;"></div>
		
	</div>
</div></div>

</div>
      
	
	
<script>
$(document).ready(function(){
	$('.dd').nestable();
    update_out('#list2',"#reorder");
    
    $('#list2').on('change', function() {
		var out = $('#list2').nestable('serialize');
		$('#reorder').val(JSON.stringify(out));	  

		console.log(JSON.stringify(out));  
    });
		$('.ext-link').hide(); 

	$('.menutype input:radio').on('ifClicked', function() {
	 	 val = $(this).val();
  			mType(val);
	  
	});
	
	mType('<?php echo $row['menu_type'];?>'); 
	
			
});	

function mType( val )
{
		if(val == 'external') {
			$('.ext-link').show(); 
			$('.int-link').hide();
		} else {
			$('.ext-link').hide(); 
			$('.int-link').show();
		}
}		

	
function update_out(selector, sel2){
	
	var out = $(selector).nestable('serialize');
	$(sel2).val(JSON.stringify(out));


}
</script>		 
		 	  