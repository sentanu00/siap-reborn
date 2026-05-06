
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('masterjurusanpendidikan/save/'.$row['JURUSAN_PENDIDIKAN_ID']); ?>" class='form-vertical' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-6">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> JURUSAN PENDIDIKAN ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JURUSAN_PENDIDIKAN_ID'];?>' name='JURUSAN_PENDIDIKAN_ID'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> NAMA    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA'];?>' name='NAMA'   /> 						
								  </div> 
			</div>
			
			<div class="col-md-6">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> JURUSAN PENDIDIKAN ID PARENT    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JURUSAN_PENDIDIKAN_ID_PARENT'];?>' name='JURUSAN_PENDIDIKAN_ID_PARENT'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> PENDIDIKAN ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENDIDIKAN_ID'];?>' name='PENDIDIKAN_ID'   /> 						
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