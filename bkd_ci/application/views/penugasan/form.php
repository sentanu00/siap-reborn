
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('penugasan/save/'.$row['TUGAS_ID']); ?>" class='form-vertical' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-6">
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> TUGAS ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TUGAS_ID'];?>' name='TUGAS_ID'   /> 						
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> PEGAWAI ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID;?>' name='PEGAWAI_ID'   /> 						
								  </div> 		
								  <div class="row">			
								  <div class="form-group  col-md-6" >
									<label for="ipt" class=" control-label "> TAHUN    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TAHUN'];?>' name='TAHUN'   /> 						
								  </div> 					
								  <div class="form-group  col-md-6" >
									<label for="ipt" class=" control-label "> LAMA    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAMA'];?>' name='LAMA'   /> 						
								  </div> 		
								  </div>			
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> JENIS TUGAS    </label>									
									  
					<?php $JENIS_TUGAS = explode(',',$row['JENIS_TUGAS']);
					$JENIS_TUGAS_opt = array( '1' => 'Dalam Negeri' ,  '2' => 'Luar Negeri' , ); ?>
					<select name='JENIS_TUGAS' rows='5'   class='form-control input-sm select2' style='width: 100%;' > 
						<?php 
						foreach($JENIS_TUGAS_opt as $key=>$val)
						{
							echo "<option  value ='$key' ".($row['JENIS_TUGAS'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
						}						
						?></select> 						
								  </div> 
			</div>
			
			<div class="col-md-6">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> TUJUAN    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TUJUAN'];?>' name='TUJUAN'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> KETERANGAN    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN'];?>' name='KETERANGAN'   /> 						
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