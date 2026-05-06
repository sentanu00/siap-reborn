<form class="form-vertical" method="post" id="formDataKeluarga" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_usulan_detail" value="<?php echo $row['id'];?>" />
        <input type="hidden" name="pegawai_id" value="<?php echo $row['pegawai_id'];?>" />
    <div class="row">
        <div class="col-md-12">
    <label for="ipt" class=" control-label " style="color:darkcyan"><i class="fa fa-user"></i> SUAMI / ISTRI </label>
        <table class="table table-striped table-bordered nowrap dataTable">
            <thead>
                <th>Hak Pensiun</th>
                <th>Nama</th>
                <th>Status Menikah</th>
                <th>PNS</th>
                <th>Tanggal Lahir</th>
                <th>Tanggal Menikah</th>
                <th>Tanggal Cerai</th>
            </thead>
            <tbody>
                
        <?php 
            foreach($suamiistri as $rwsi){
                ?>
                <tr>
                    <td style="text-align: center;">
                        <input type="hidden" name="pasangan[<?php echo $rwsi->SUAMI_ISTRI_ID;?>]" value="<?php echo $rwsi->SUAMI_ISTRI_ID;?>">
                        <input type="checkbox" name="tunjpasangan[<?php echo $rwsi->SUAMI_ISTRI_ID;?>]" value="1" <?php if($rwsi->hak_pensiun == 1) echo 'checked'; ?> role="switch">
                    </td>
                    <td><?php echo $rwsi->NAMA;?></td>
                    <td><?php if($rwsi->SK_CERAI_TMT == '') { echo 'MENIKAH';}else{ echo 'CERAI';}?></td>
                    <td><?php if($rwsi->STATUS_PNS == 1) {echo '<i class="fa fa-check" style="color:green"></i>';} else { echo '<i class="fa fa-ban" style="color:red"></i>';}?></td>
                    <td><?php echo SiteHelpers::datereport($rwsi->TANGGAL_LAHIR);?></td>
                    <td><?php echo SiteHelpers::datereport($rwsi->TANGGAL_KAWIN);?></td>
                    <td><?php echo SiteHelpers::datereport($rwsi->SK_CERAI_TMT);?></td>
                </tr>
                <?
            }
        ?>
        
        </tbody>
        </table>
        </div>

        <div class="col-md-12">
    <label for="ipt" class=" control-label " style="color:darkcyan"><i class="fa fa-group"></i> ANAK </label>
        <table class="table table-striped table-bordered nowrap dataTable">
            <thead>
                <th>Hak Pensiun</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
            </thead>
            <tbody>
                
        <?php 
            foreach($anak as $rwank){
                ?>
                <tr>
                    <td style="text-align: center;">
                        <input type="hidden" name="anak[<?php echo $rwank->ANAK_ID;?>]" value="<?php echo $rwank->ANAK_ID;?>">
                    <input type="checkbox" value="1" <?php if($rwank->hak_pensiun == 1) echo 'checked'; ?> name="tunjanak[<?php echo $rwank->ANAK_ID;?>]" role="switch">
                    </td>
                    <td><?php echo $rwank->NAMA;?></td>
                    <td><?php echo $rwank->JENIS_KELAMIN;?></td>
                    <td><?php echo $rwank->TEMPAT_LAHIR;?></td>
                    <td><?php echo SiteHelpers::datereport($rwank->TANGGAL_LAHIR);?></td>
                </tr>
                <?
            }
        ?>
        
        </tbody>
        </table>
        </div>
    </div>
    <button type="button" class="btn btn-outline-primary prev-step"><i class="fa fa-arrow-left"></i>Sebelumnya</button>
    <button type="button" class="btn btn-primary next-step float-right" > Selanjutnya <i class="fa fa-arrow-right"></i></button>
</form>

<script>

$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$('input[type="checkbox"]').attr('disabled', 'disabled');

</script>