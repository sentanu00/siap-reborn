
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('disiplinhukuman/save/'.$row['HUKUMAN_ID']); ?>" class='form-horizontal' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-12">
									
								  <div class="form-group row  " >
									<label for="NO SK" class=" control-label col-md-4 text-left"> NO SK </label>
									<div class="col-md-8">
									  <textarea name='NO_SK' rows='2' id='NO_SK' class='form-control input-sm '  
				           ><?php echo $row['NO_SK'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TGL SK" class=" control-label col-md-4 text-left"> TGL SK </label>
									<div class="col-md-8">
									  <textarea name='TGL_SK' rows='2' id='TGL_SK' class='form-control input-sm '  
				           ><?php echo $row['TGL_SK'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TMT SK" class=" control-label col-md-4 text-left"> TMT SK </label>
									<div class="col-md-8">
									  <textarea name='TMT_SK' rows='2' id='TMT_SK' class='form-control input-sm '  
				           ><?php echo $row['TMT_SK'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KET" class=" control-label col-md-4 text-left"> KET </label>
									<div class="col-md-8">
									  <textarea name='KET' rows='2' id='KET' class='form-control input-sm '  
				           ><?php echo $row['KET'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BERLAKU" class=" control-label col-md-4 text-left"> BERLAKU </label>
									<div class="col-md-8">
									  <textarea name='BERLAKU' rows='2' id='BERLAKU' class='form-control input-sm '  
				           ><?php echo $row['BERLAKU'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TGL MULAI" class=" control-label col-md-4 text-left"> TGL MULAI </label>
									<div class="col-md-8">
									  <textarea name='TGL_MULAI' rows='2' id='TGL_MULAI' class='form-control input-sm '  
				           ><?php echo $row['TGL_MULAI'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TGL AKHIR" class=" control-label col-md-4 text-left"> TGL AKHIR </label>
									<div class="col-md-8">
									  <textarea name='TGL_AKHIR' rows='2' id='TGL_AKHIR' class='form-control input-sm '  
				           ><?php echo $row['TGL_AKHIR'] ;?></textarea> <br />
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