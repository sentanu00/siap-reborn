
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('datadfs/save/'.$row['DFS_ID']); ?>" class='form-vertical' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-6">
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> DFS ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DFS_ID'];?>' name='DFS_ID'   /> 						
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> PEGAWAI ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID;?>' name='PEGAWAI_ID'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> JENIS DOC    </label>									
									  <select name='JENIS_DOC' rows='5' id='JENIS_DOC' code='{$JENIS_DOC}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> NAMA DOC    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA_DOC'];?>' name='NAMA_DOC'   /> 						
								  </div> 
			</div>
			
			<div class="col-md-6">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> PATH DOC    </label>									
									  <input  type='file' name='PATH_DOC' id='PATH_DOC' <?php if($row['PATH_DOC'] =='') echo 'class="required"' ;?> style='width:150px !important;'  />
					<?php echo SiteHelpers::showUploadedFile($row['PATH_DOC'],'/uploads/') ;?>
				 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> KETERANGAN    </label>									
									  <textarea name='KETERANGAN' rows='2' id='KETERANGAN' class='form-control input-sm '  
				           ><?php echo $row['KETERANGAN'] ;?></textarea> 						
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
 	

		$("#JENIS_DOC").jCombo("<?php echo site_url('datadfs/comboselect?filter=digital_file_jenis:JENIS_DOC:NAMA') ?>",
		{  selected_value : '<?php echo $row["JENIS_DOC"] ?>' });
		 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});
</script>		 