
<form class="form-vertical" method="post" id="formDatadetailKeterangan" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3">
        <div class="form-group">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>" />
			    <label for="ipt" class=" control-label "> NIK  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['NIK'];?>" >
			</div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
			    <label for="ipt" class=" control-label "> NPWP  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['NPWP'];?>" >
			</div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
			    <label for="ipt" class=" control-label "> No. TLP  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['TELEPON'];?>" >
			</div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
			    <label for="ipt" class=" control-label "> No. HP  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['NO_HP'];?>">
			</div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-6">
        <div class="form-group">
			<label for="ipt" class=" control-label "> Alamat Saat Ini  </label>
			<textarea readonly class="form-control input-sm parsley-validated"><?php echo $row['ALAMAT'];?></textarea>
		</div>
        <div class="row">
        <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> Provinsi  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['PROPINSI'];?>" >
			</div>
            <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> Kota / Kabupaten  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['KABUPATEN'];?>" >
			</div>
            <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> Kecamatan  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['KECAMATAN'];?>" >
			</div>
            <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> Kelurahan  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['KELURAHAN'];?>" >
			</div>

            <div class="form-group col-md-12">
			    <label for="ipt" class=" control-label "> Kode Pos  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['KODEPOS'];?>" >
			</div>
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="form-group">
			<label for="ipt" class=" control-label "> Alamat Pensiun  </label>
			<textarea name="alamat_setelah_pensiun" class="form-control input-sm parsley-validated"><?php echo $row['alamat_setelah_pensiun'];?></textarea>
		</div>
        <div class="row">
        <div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> Provinsi </label>
					<select name="provinsi_id_setelah_pensiun" rows="5" id="provinsi_id_setelah_pensiun" required code="{$provinsi_id_setelah_pensiun}" class="form-control input-sm select2 " style="width: 100%;">
						<option value=""></option>
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> Kabupaten </label>
					<select name="kab_id_setelah_pensiun" rows="5" id="kab_id_setelah_pensiun" required code="{$kab_id_setelah_pensiun}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
                <div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> Kecamatan </label>
					<select name="kec_id_setelah_pensiun" rows="5" id="kec_id_setelah_pensiun" required code="{$kec_id_setelah_pensiun}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> Kelurahan </label>
					<select name="kel_id_setelah_pensiun" rows="5" id="kel_id_setelah_pensiun" required code="{$kel_id_setelah_pensiun}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>

            <div class="form-group col-md-12">
			    <label for="ipt" class=" control-label "> Kode Pos  </label>
				<input type="text" name="kodepos_setelah_pensiun" required class="form-control input-sm parsley-validated"  value="<?php echo $row['kodepos_setelah_pensiun'];?>" >
			</div>
        </div>
        
    </div>
    
    
    
    </div>
    <center>
    <small style="color:red">Jika ada data yang tidak sesuai, bisa dilakukan Update data di menu profiling Pegawai</small>
    </center>
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

			
$(document).ready(function() { 
    $(this).parsley();
var frm = $('#formDatadetailKeterangan');
$('#formDatadetailKeterangan').on('submit',function(e) {
    
    if(!frm.valid()) return false;
  e.preventDefault(); 
  if ( $(this).parsley().isValid() ) {
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo site_url("epusulanpemberhentianpegawai/updateDetailketerangan");?>',
            data: frm.serialize(),
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
<script>
    $(document).ready(function() {
		$('.select2').select2();
		
        $("#provinsi_id_setelah_pensiun").jCombo("<?= site_url(); ?>/epusulanpemberhentianpegawai/comboselect?filter=propinsi:PROPINSI_ID:NAMA", {
			selected_value: '<?php echo $row['provinsi_id_setelah_pensiun']; ?>'
		});

		$("#kab_id_setelah_pensiun").jCombo("<?= site_url(); ?>/epusulanpemberhentianpegawai/comboselect?filter=vw_kabupaten:child_id:NAMA:PROPINSI_ID:", {
			parent: '#provinsi_id_setelah_pensiun',
			selected_value: '<?php echo $row['provinsi_id_setelah_pensiun']; ?>*<?php echo $row['kab_id_setelah_pensiun']; ?>'
		});

		$("#kec_id_setelah_pensiun").jCombo("<?= site_url(); ?>/epusulanpemberhentianpegawai/comboselect?filter=vw_kecamatan:child_id:NAMA:parent_id:", {
			parent: '#kab_id_setelah_pensiun',
			selected_value: '<?php echo $row['provinsi_id_setelah_pensiun']; ?>*<?php echo $row['kab_id_setelah_pensiun']; ?>*<?php echo $row['kec_id_setelah_pensiun']; ?>'
		});


		$("#kel_id_setelah_pensiun").jCombo("<?= site_url(); ?>/epusulanpemberhentianpegawai/comboselect?filter=vw_kelurahan:child_id:NAMA:parent_id:", {
			parent: '#kec_id_setelah_pensiun',
			selected_value: '<?php echo $row['provinsi_id_setelah_pensiun']; ?>*<?php echo $row['kab_id_setelah_pensiun']; ?>*<?php echo $row['kec_id_setelah_pensiun']; ?>*<?php echo $row['kel_id_setelah_pensiun']; ?>'
		});
    });
</script>