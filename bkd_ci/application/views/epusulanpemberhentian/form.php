
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('epusulanpemberhentian/save/'.$row['id']); ?>" class='form-horizontal' 
		  method="post" enctype="multipart/form-data" > 

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
									<label for="OPD" class=" control-label col-md-4 text-left"> OPD <span class="asterix"> * </span></label>
									<div class="col-md-8">
									<input type='text' class='form-control input-sm' readonly value='<?php echo $satkernama;?>'   required />
									<input type='hidden' id="satker_id" value='<?php echo $row['satker_id'];?>' name='satker_id'  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Usulan Nomor" class=" control-label col-md-4 text-left"> Usulan Nomor <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' readonly class='form-control input-sm' placeholder='' value='<?php echo $row['usulan_nomor'];?>' name='usulan_nomor'  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  					
								  <div class="form-group row  " >
									<label for="Usulan Tanggal" class=" control-label col-md-4 text-left"> Usulan Tanggal <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['usulan_tanggal'];?>' name='usulan_tanggal'  required /> <br />
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
			<a href="javascript:void()" class="btn btn-sm btn-warning" data-dismiss="modal"><?php echo $this->lang->line('core.sb_cancel'); ?> </a>
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
		if($('#satker_id').val() != ''){
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                alert('Data Berhasil Disimpan !!');
                 table.ajax.reload();
				 window.location = data;
            }
        });
	}else{
		alert("Silahkan login sebagai Operator OPD untuk Menambahkan Usulan");
	}
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