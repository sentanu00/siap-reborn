<form class="form-vertical" method="post" id="formDetailValidasi" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
    <div class="row ">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>" />
	<div class="col-md-4">
	<img src="<?php echo base_url('assets/icon/checklist.png')?>" style="width:100%" />
	</div>
    <div class="col-md-4 text-center">
    <center>
        
        <br />
		Status Validasi :<br />
		<select name="usulan_status" class="form-control" required>
			<option value="3">Validasi</option>
			<option value="6">Ditolak</option>
		</select><br />
		Validasi Catatan :<br />
        <textarea name="validasi_catatan" required class="form-control"></textarea>
		
    </center>
	<br />
    </div>
	
    </div>
    <button type="button" class="btn btn-outline-primary prev-step"><i class="fa fa-arrow-left"></i>Sebelumnya</button>
    <button type="SUBMIT" class="btn btn-danger float-right"><i class="fa fa-check"></i> Simpan & Selesai </button>
</form>
<script>
    $(document).ready(function() { 
    $(this).parsley();
var frm = $('#formDetailValidasi');
$('#formDetailValidasi').on('submit',function(e) {
    
    if(!frm.valid()) return false;
  e.preventDefault(); 
  if ( $(this).parsley().isValid() ) {
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo site_url("epusulanpemberhentianvalidasi/simpanValidasi");?>',
            data: frm.serialize(),
            success: function (data) {
                $('#sximo-modal').modal('toggle');
				alert('Validasi Data Berhasil');
                location.reload();
            }
        });
    }
    });


});
</script>