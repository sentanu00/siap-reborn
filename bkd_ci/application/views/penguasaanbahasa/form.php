
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('penguasaanbahasa/save/'.$row['BAHASA_ID']); ?>" class='form-vertical' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-4">
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> BAHASA ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BAHASA_ID'];?>' name='BAHASA_ID'   /> 						
								  </div> 					
								  <div class="form-group hidethis " style="display:none;">
									<label for="ipt" class=" control-label "> PEGAWAI ID    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID;?>' name='PEGAWAI_ID'   /> 						
								  </div> 					
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> JENIS  <span class="asterix"> * </span>  </label>									
									  
					<?php $JENIS = explode(',',$row['JENIS']);
					$JENIS_opt = array( '1' => 'Asing' ,  '2' => 'Daerah' , ); ?>
					<select name='JENIS' rows='5' required  class='form-control input-sm select2' style='width: 100%;' > 
						<?php 
						foreach($JENIS_opt as $key=>$val)
						{
							echo "<option  value ='$key' ".($row['JENIS'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
						}						
						?></select> 						
								  </div> 
			</div>
			
			<div class="col-md-4">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> NAMA  <span class="asterix"> * </span>  </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA'];?>' name='NAMA'  required /> 						
								  </div> 
			</div>
			
			<div class="col-md-4">
									
								  <div class="form-group  " >
									<label for="ipt" class=" control-label "> KEMAMPUAN  <span class="asterix"> * </span>  </label>									
									  
					<?php $KEMAMPUAN = explode(',',$row['KEMAMPUAN']);
					$KEMAMPUAN_opt = array( '1' => 'Aktif' ,  '2' => 'Pasif' , ); ?>
					<select name='KEMAMPUAN' rows='5' required  class='form-control input-sm select2' style='width: 100%;' > 
						<?php 
						foreach($KEMAMPUAN_opt as $key=>$val)
						{
							echo "<option  value ='$key' ".($row['KEMAMPUAN'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
						}						
						?></select> 						
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