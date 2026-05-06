<form class="form-vertical" method="post" id="formDetailValidasi" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
    <div class="row ">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>" />
	<div class="col-md-4">
	<img src="<?php echo base_url('assets/icon/checklist.png')?>" style="width:100%" />
	</div>
    <div class="col-md-4 text-center">
    <center>
        <input type="hidden" name="id_usulan_detail" value="<?php echo $row['id'];?>" />
        <input type="hidden" name="NIP" value="<?php echo $row['NIP_BARU'];?>" />
        <input type="hidden" name="pegawai_id" value="<?php echo $row['pegawai_id'];?>" />
        <br />
		File SK :
		<input type="file" required data-parsley-fileextension='pdf' accept="application/pdf" name="file_sk_upload"  class="form-control input-sm" >
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
            var form_data = new FormData(frm[0]);
            if(confirm("Apakah anda yakin file SK yang anda upload sudah sesuai dengan nama pemohon ?")){
        $.ajax({
                type: frm.attr('method'),
                url: '<?php echo site_url("epusulanpemberhentianvalidasi/uploadSK");?>',
			    data: form_data,
                mimeType: "multipart/form-data",
				cache: false,
				processData: false,
				contentType: false,
            success: function (data) {
                $('#sximo-modal').modal('toggle');
				alert('Upload SK Berhasil');
                location.reload();
            }
        });
    }
    }
    });


});
</script>