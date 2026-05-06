
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('epmssyarat/save/'.$row['id']); ?>" class='form-horizontal' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-12">
									
								  <div class="form-group row hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id'];?>' name='id'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Pemberhentian" class=" control-label col-md-4 text-left"> Jenis Pemberhentian <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <select name='ep_ms_jenis_pemberhentian_id' rows='5' id='ep_ms_jenis_pemberhentian_id' code='{$ep_ms_jenis_pemberhentian_id}' 
							class='form-control input-sm select2 ' style='width: 100%;' required  ></select> 
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Persyaratan Nama" class=" control-label col-md-4 text-left"> Persyaratan Nama <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['persyaratan_nama'];?>' name='persyaratan_nama'  required /> 
									  <i> <small></small></i>
									 </div> 
								  </div> 	
								  <div class="form-group row  " >
									<label for="Persyaratan Nama" class=" control-label col-md-4 text-left"> Urutan File <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='number' class='form-control input-sm' placeholder='' value='<?php echo $row['urutan'];?>' name='urutan'  required />
									  <i> <small></small></i>
									 </div> 
								  </div> 				
								  <div class="form-group row  " >
									<label for="Table File" class=" control-label col-md-4 text-left"> Table File </label>
									<div class="col-md-8">
									  <select name='table_file' rows='5' id='table_file' code='{$table_file}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Column Table File" class=" control-label col-md-4 text-left"> Column Table File </label>
									<div class="col-md-8">
									  <select name='column_table_file' rows='5' id='column_table_file' code='{$column_table_file}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Id Jenis Dokumen" class=" control-label col-md-4 text-left"> ID Jenis Dokumen </label>
									<div class="col-md-8">
									  <select name='id_jenis_dokumen' rows='5' id='id_jenis_dokumen' code='{$id_jenis_dokumen}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 
								  <div class="form-group row  " >
									<label for="Persyaratan Nama" class=" control-label col-md-4 text-left"> Is Required <span class="asterix"> * </span></label>
									<div class="col-md-8">
									<select name='kons' rows='5' id='is_required' code='{$kons}' 
							class='form-control input-sm  ' required style='width: 100%;'   >
								
									<option value="0" <?php if($row['is_required'] == 0) echo "selected";?>>TIDAK</option>
									<option value="1" <?php if($row['is_required'] == 1) echo "selected";?>>YA</option>
							</select> 
									  <i> <small></small></i>
									 </div> 
								  </div>
								  <div class="form-group row  " >
									<label for="Persyaratan Nama" class=" control-label col-md-4 text-left"> Tipe Pengambilan Data <span class="asterix"> * </span></label>
									<div class="col-md-8">
									<select name='kons' rows='5' id='single_file' code='{$kons}' 
							class='form-control input-sm  ' required style='width: 100%;'   >
								
									<option value="0" <?php if($row['single_file'] == 1) echo "selected";?>>Single Data on Single Table</option>
									<option value="1" <?php if($row['single_file'] == 2) echo "selected";?>>Single Data on History Data</option>
									<option value="1" <?php if($row['single_file'] == 0) echo "selected";?>>All Data</option>
							</select> 
									  <i> <small></small></i>
									 </div> 
								  </div>
			</div>
			
			
</div>
		
			<div style="clear:both"><hr /></div>	
				
 		<div class="toolbar-line text-center">		
			<?
			if($this->access['is_edit'] ==1 || $this->access['is_add'] ==1){
			?>
			<input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
			<?
			}
			?>
			<a href="javascript:cancelform()" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a>
 		</div>
			  		
		</form>

	</div>
	</div>
      </section>
			 
<script type="text/javascript">
	$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

			$('input').on('keyup', function(event){
  if(event.keyCode == 13){ // 13 is the keycode for enter button
    $(this).next('input').focus();
  }
});
			
$(document).ready(function() { 

	var frm = $('form');
	$('.select2').select2();
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                alert('Data Berhasil Disimpan !!');
                 table.ajax.reload();
                  $('#form-ajax').html("");
            }
        });
        ev.preventDefault();
    });
 	

		$("#ep_ms_jenis_pemberhentian_id").jCombo("<?php echo site_url('epmssyarat/comboselect?filter=ep_ms_jenis_pemberhentian:id:nama') ?>",
		{  selected_value : '<?php echo $row["ep_ms_jenis_pemberhentian_id"] ?>' });
		
		$("#table_file").jCombo("<?php echo site_url('epmssyarat/getTable') ?>",
		{  selected_value : '<?php echo $row["table_file"] ?>' });
		
		$("#column_table_file").jCombo("<?php echo site_url('epmssyarat/getColTable') ?>/",
		{  parent: '#table_file', selected_value : '<?php echo $row["column_table_file"] ?>' });
		
		$("#id_jenis_dokumen").jCombo("<?php echo site_url('epmssyarat/comboselect?filter=jenis_dokumen:id_jenis_dokumen:jenis_dokumen') ?>",
		{  selected_value : '<?php echo $row["id_jenis_dokumen"] ?>' });
		 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});
</script>		 