<form class="form-vertical" method="post" id="formDetailKonfirm" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
    <div class="row ">
    <input type="hidden" name="id" value="<?php echo $row['id'];?>" />
    <div class="col-md-12 text-center">
    <center>
        <img src="<?php echo base_url('assets/icon/checklist.png')?>" style="width:200px" />
        <br />
        <span style="font-size: 14px;color:red">Dengan ini saya yakin data yang saya lampirkan dan kirimkan sudah benar ?</span>
    </center>
    </div>
    </div>
    <button type="button" class="btn btn-outline-primary prev-step"><i class="fa fa-arrow-left"></i>Sebelumnya</button>
    <button type="SUBMIT" class="btn btn-danger float-right"><i class="fa fa-check"></i> Simpan & Selesai </button>
</form>
<script>
    $(document).ready(function() { 
    $(this).parsley();
var frm = $('#formDetailKonfirm');
$('#formDetailKonfirm').on('submit',function(e) {
    
    if(!frm.valid()) return false;
  e.preventDefault(); 
  if ( $(this).parsley().isValid() ) {
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo site_url("epusulanpemberhentianpegawai/simpanKonfirmasi");?>',
            data: frm.serialize(),
            success: function (data) {
                $('#sximo-modal').modal('toggle');
                location.reload();
            }
        });
    }
    });


});
</script>