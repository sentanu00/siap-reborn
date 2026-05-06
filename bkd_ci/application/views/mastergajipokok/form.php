
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('mastergajipokok/save/'.$row['GAJI_POKOK_ID']); ?>" class='form-vertical' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-6">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> GAJI POKOK ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI_POKOK_ID'];?>' name='GAJI_POKOK_ID'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> MASA KERJA    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA'];?>' name='MASA_KERJA'   /> 						
								  </div> 
			</div>
			
			<div class="col-md-6">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> GAJI    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI'];?>' name='GAJI'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> PANGKAT    </label>									
									  <select name='PANGKAT_ID' rows='5' id='PANGKAT_ID' code='{$PANGKAT_ID}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> 						
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
 	

		$("#PANGKAT_ID").jCombo("<?php echo site_url('mastergajipokok/comboselect?filter=pangkat::PANGKAT_ID|NAMA') ?>",
		{  selected_value : '<?php echo $row["PANGKAT_ID"] ?>' });
		 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});
</script>		 