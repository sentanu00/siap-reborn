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
            <div class="input-group input-group-sm ">
				
                <?php
                if($pathfile != ''){
                    ?>
                    <span class="form-control"><?php echo $sy->persyaratan_nama;?> </span>
                    <button type="button" onclick="previewFileSyarat('<?php echo $row['id'];?>','<?php echo $sy->id;?>')" class="input-group-addon float-right"  style="background-color: green;"><i class="fa fa-eye"></i></button>
                    <?php
                }else{
                    ?>
                    <span class="form-control"><?php echo $sy->persyaratan_nama;?> </span>
                    <button type="button" onclick="noAct()" disabled class="input-group-addon"  style="background-color: silver;"><i class="fa fa-ban"></i></button>
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
    <button type="button" class="btn btn-primary next-step float-right" >Selanjutnya <i class="fa fa-arrow-right"></i></button>
</form>

<script>

$('input[type="file"]').attr('disabled', 'disabled');
$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

    function previewFileSyarat(usulanid,syaratid){
        SximoModalPreviewFile('<?php echo site_url("epusulanpemberhentianpegawai/viewfile")?>/'+usulanid+'/'+syaratid,'Preview','650');
    }


    function noAct(){

    }
    
</script>