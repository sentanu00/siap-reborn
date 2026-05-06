<form class="form-vertical" method="post" id="formDataSyarat" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
    <div class="row">
        <input type="hidden" name="id_usulan_detail" value="<?php echo $row['id'];?>" />
        <input type="hidden" name="NIP" value="<?php echo $row['NIP_BARU'];?>" />
        <input type="hidden" name="pegawai_id" value="<?php echo $row['pegawai_id'];?>" />
        <?php 
            foreach($syarat as $sy){
                $pathfile = SiteHelpers::getdokumensyarat($row['pegawai_id'],$row['id'],$sy->id,$sy->table_file,$sy->column_table_file,$sy->id_jenis_dokumen,$sy->single_file);
        ?>
    <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> <?php echo $sy->persyaratan_nama;?>  
            <?php if($sy->is_required == 1) {
                ?>
                <span class="asterix"> * </span>
                <?php
            }
            ?>
            </label>
            <div class="input-group input-group-sm ">
				
                <?php
                if($pathfile != ''){
                    ?>
                    <input type="hidden" name="pathtemp[<?php echo $sy->id;?>]" value="<?php echo $pathfile;?>" />
                    <input type="file" data-parsley-fileextension='pdf' accept="application/pdf" name="dokumen[<?php echo $sy->id;?>]"  class="form-control input-sm" >
                    <button type="button" onclick="previewFileSyarat('<?php echo $row['id'];?>','<?php echo $sy->id;?>','<?php echo $pathfile;?>')" class="input-group-addon"  style="background-color: green;"><i class="fa fa-eye"></i></button>
                    <?php
                }else{
                    ?>
                    <input type="file" data-parsley-fileextension='pdf' accept="application/pdf" name="dokumen[<?php echo $sy->id;?>]" <?php if($sy->is_required == 1) echo 'required="" data-parsley-required="true"';?> class="form-control input-sm parsley-validated" >
                    <button type="button" onclick="asd()" disabled class="input-group-addon"  style="background-color: silver;"><i class="fa fa-ban"></i></button>
                    <?php
                }
                ?>
                
            </div>
	</div>
        <?php
            }
        ?>
    </div>
    <button type="button" class="btn btn-outline-primary prev-step"><i class="fa fa-arrow-left"></i>Sebelumnya</button>
    <button type="SUBMIT" class="btn btn-primary float-right"><i class="fa fa-save"></i> Selanjutnya <i class="fa fa-arrow-right"></i></button>
</form>

<script>

$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

function previewFileSyarat(usulanid,syaratid,path){
        SximoModalPreviewFile('<?php echo site_url("epusulanpemberhentianpegawai/viewfile")?>/'+usulanid+'/'+syaratid+"?path="+path,'Preview','650');
    }

    $(document).ready(function() { 
        $(this).parsley();
var frm = $('#formDataSyarat');
$('#formDataSyarat').on('submit',function(e) {
    
   if(!frm.valid()) return false;
  e.preventDefault(); 
  if ( $(this).parsley().isValid() ) {
  var form_data = new FormData(frm[0]);
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo site_url("epusulanpemberhentianpegawai/uploadDocument");?>',
				data: form_data,
                mimeType: "multipart/form-data",
				cache: false,
				processData: false,
				contentType: false,
            success: function (data) {
                       var $active = $('.nav-tabs li>.active');
						$active.parent().next().find('.nav-link').removeClass('disabled');
						nextTab($active);
            }
        });
    }
    });


});
</script>