
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('tambahanmk/save/'.$row['TAMBAHAN_MASA_KERJA_ID']); ?>" class='form-vertical' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-6">
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> TAMBAHAN MASA KERJA ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TAMBAHAN_MASA_KERJA_ID'];?>' name='TAMBAHAN_MASA_KERJA_ID'   /> 						
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> PEGAWAI ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID;?>' name='PEGAWAI_ID'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> NO SK    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK'];?>' name='NO_SK'   /> 						
								  </div> 		
								  <div class="row">			
								  <div class="form-group  col-md-6" >
									<label for="ipt" class=" control-label "> TANGGAL SK    </label>									
									  <input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK'];?>' name='TANGGAL_SK'   /> 						
								  </div> 					
								  <div class="form-group  col-md-6" >
									<label for="ipt" class=" control-label "> TMT SK    </label>									
									  <input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_SK'];?>' name='TMT_SK'   /> 						
								  </div> 
								</div>
			</div>
			
			<div class="col-md-6">
									<div class="row">
								  <div class="form-group  col-md-6" >
									<label for="ipt" class=" control-label "> THN TAMBAHAN    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TAHUN_TAMBAHAN'];?>' name='TAHUN_TAMBAHAN'   /> 						
								  </div> 					
								  <div class="form-group col-md-6 " >
									<label for="ipt" class=" control-label "> BLN TAMBAHAN    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BULAN_TAMBAHAN'];?>' name='BULAN_TAMBAHAN'   /> 						
								  </div> 
								  </div>				
								  <div class="row">	
								  <div class="form-group col-md-6" >
									<label for="ipt" class=" control-label "> THN BARU    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TAHUN_BARU'];?>' name='TAHUN_BARU'   /> 						
								  </div> 					
								  <div class="form-group col-md-6 " >
									<label for="ipt" class=" control-label "> BLN BARU    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BULAN_BARU'];?>' name='BULAN_BARU'   /> 						
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