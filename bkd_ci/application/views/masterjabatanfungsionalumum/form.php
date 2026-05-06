
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('masterjabatanfungsionalumum/save/'.$row['JABATAN_FUNGSIONAL_ID']); ?>" class='form-horizontal' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-12">
									
								  <div class="form-group row  " >
									<label for="JABATAN FUNGSIONAL ID" class=" control-label col-md-4 text-left"> JABATAN FUNGSIONAL ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_FUNGSIONAL_ID'];?>' name='JABATAN_FUNGSIONAL_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="JABATAN FUNGSIONAL ID PARENT" class=" control-label col-md-4 text-left"> JABATAN FUNGSIONAL ID PARENT </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_FUNGSIONAL_ID_PARENT'];?>' name='JABATAN_FUNGSIONAL_ID_PARENT'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NAMA" class=" control-label col-md-4 text-left"> NAMA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA'];?>' name='NAMA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KETERANGAN" class=" control-label col-md-4 text-left"> KETERANGAN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN'];?>' name='KETERANGAN'   /> <br />
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
 	
 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});
</script>		 