<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4><?php echo $pageTitle ;?></h4>
<span>data tabel <?php echo $pageTitle ;?></span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="#!"><?php echo $pageTitle ;?></a></li>
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


 <form class="form-horizontal" action="<?php echo site_url('hakakses/savePermission/'.$module_name);?>" method="post" parsley-validate novalidate>	

<div class="sbox">
	<div class="sbox-title"><h5>Hak Akses <small> Konfigurasi Hak Akses </small></h5></div>
	<div class="sbox-content">	
		<table class="table table-striped table-bordered" id="table">
		<thead class="no-border">
  <tr>
	<th field="name1" width="20"><?php echo $this->lang->line('core.mod_thnum'); ?> </th>
	<th field="name2"><?php echo $this->lang->line('core.group'); ?> </th>
	<?php foreach($tasks as $item=>$val) {?>	
	<th field="name3" data-hide="phone"><?php echo $val;?> </th>
	<?php }?>

  </tr>
</thead>  
<tbody class="no-border-x no-border-y">	
  <?php $i=0; foreach($access as $gp) {?>	
  	<tr>
		<td  width="20"><?php echo ++$i;?>
		<input type="hidden" name="group_id[]" value="<?php echo $gp['group_id'];?>" /></td>
		<td ><?php echo $gp['group_name'];?> </td>
		<?php foreach($tasks as $item=>$val) {?>	
		<td  class="">
		
		<label >
			<input name="<?php echo $item;?>[<?php echo $gp['group_id'];?>]" class="c<?php echo $gp['group_id'];?>" type="checkbox"  value="1"
			<?php if($gp[$item] ==1) echo ' checked="checked" ';?> />
		</label>	
		</td>

		<?php }?>
	</tr>  
	<?php }?>
  </tbody>
</table>	

<div class="infobox infobox-danger fade in">
  <button type="button" class="close" data-dismiss="alert"> x </button>
  Selalu Centang Global untuk semua Group<br />
  <br />
  <br />
  
</div>	
<button type="submit" class="btn btn-success"><?php echo $this->lang->line('core.sb_savechanges'); ?> </button>	
	
<input name="module_id" type="hidden" id="module_id" value="<?php echo $row->module_id;?>" />
</div>	</div>
</form>
	

</div>	</div>
          </div>
          </div>
<script>
	$(document).ready(function(){
	
		$(".checkAll").click(function() {
			var cblist = $(this).attr('rel');
			var cblist = $(cblist);
			if($(this).is(":checked"))
			{				
				cblist.prop("checked", !cblist.is(":checked"));
			} else {	
				cblist.removeAttr("checked");
			}	
			
		});  	
	});
</script>