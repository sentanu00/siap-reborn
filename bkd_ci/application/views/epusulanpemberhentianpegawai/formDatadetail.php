<style>
    .input-group{
        margin-bottom: 0px;
    }

    input:read-only {
  background-color: #f1f1f1;
  color:black;
}
</style>
<form class="form-vertical" method="post" id="formDatadetail" parsley-validate="true" novalidate="true" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $row['id'];?>" />
			    <label for="ipt" class=" control-label "> Jenis Jabatan  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['jenis_jabatan'];?>" name="jenis_jabatan" id="jenis_jabatan">
			</div>
            <div class="form-group">
			    <label for="ipt" class=" control-label "> Nama Jabatan  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['nama_jabatan'];?>" name="nama_jabatan" id="nama_jabatan">
			</div>
            <div class="form-group">
			    <label for="ipt" class=" control-label "> Unor  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['unor'];?>" name="unor" id="unor">
			</div>
            <div class="row">
            <div class="form-group col-md-4">
			    <label for="ipt" class=" control-label "> TMT CPNS  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['tmt_cpns'];?>" name="tmt_cpns" id="tmt_cpns">
			</div>
            <div class="form-group col-md-4">
			    <label for="ipt" class=" control-label "> TMT PNS  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['tmt_pns'];?>" name="tmt_pns" id="tmt_pns">
			</div>
            <div class="form-group col-md-4">
			    <label for="ipt" class=" control-label "> TGL Pensiun  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['tmt_pensiun'];?>" name="tmt_pensiun" id="tmt_pensiun">
			</div>
            </div>

            <div class="row">
            <div class="form-group col-md-3">
			    <label for="ipt" class=" control-label "> Golongan  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['golongan'];?>" name="golongan" id="golongan">
                
			</div>
            <div class="form-group col-md-5">
			    <label for="ipt" class=" control-label "> Pangkat  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['pangkat'];?>" name="pangkat" id="pangkat">
                
			</div>
            <div class="form-group col-md-4">
			    <label for="ipt" class=" control-label "> TMT Golongan  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['tmt_golongan'];?>" name="tmt_golongan" id="tmt_golongan">
                
			</div>
            </div>

            <div class="row">
            <div class="form-group col-md-8">
			    <label for="ipt" class=" control-label "> Gaji  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['gaji'];?>" name="gaji" id="gaji">
			</div>
            <div class="form-group col-md-4">
			    <label for="ipt" class=" control-label "> Tahun Gaji  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['tahun_gaji'];?>" name="tahun_gaji" id="tahun_gaji">
			</div>
            </div>
            <small style="color:red">Jika ada data yang tidak sesuai, bisa dilakukan Update data di menu profiling Pegawai</small>
        </div>
        <div class="col-md-6">
        <div class="form-group">
			    <label for="ipt" class=" control-label "> KPPN <span class="asterix"> * </span></label>
				<input type="text" required class="form-control input-sm parsley-validated"  value="<?php echo $row['kppn'];?>" name="kppn" id="kppn">
			</div>
            <div class="form-group">
			    <label for="ipt" class=" control-label "> TASPEN  <span class="asterix"> * </span></label>
				<input type="text" required class="form-control input-sm parsley-validated"  value="<?php echo $row['taspen'];?>" name="taspen" id="taspen">
			</div>
            <div class="form-group">
			    <label for="ipt" class=" control-label "> Satuan Kerja  </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['satuan_kerja'];?>" name="satuan_kerja" id="satuan_kerja">
			</div>
            <div class="row">
            <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> Masa Kerja PNS  </label>

                <div class="input-group input-group-sm ">
    <input id="masa_kerja_pns_thn" type="text" value="<?php echo $row['masa_kerja_pns_thn'];?>" class="form-control input-sm " name="masa_kerja_pns_thn" readonly>
    <span class="input-group-addon" style="background-color: silver;">Thn</span>
    <input id="masa_kerja_pns_bln" type="text" value="<?php echo $row['masa_kerja_pns_bln'];?>"  class="form-control input-sm " name="masa_kerja_pns_bln" readonly>
    <span class="input-group-addon" style="background-color: silver;">Bln</span>
  </div>
			</div>

            <div class="form-group col-md-6">
			    <label for="ipt" class=" control-label "> Masa Kerja Pensiun  </label>

                <div class="input-group input-group-sm ">
    <input id="masa_kerja_pensiun_thn" type="text" class="form-control input-sm " value="<?php echo $row['masa_kerja_pensiun_thn'];?>" name="masa_kerja_pensiun_thn" readonly>
    <span class="input-group-addon" style="background-color: silver;">Thn</span>
    <input id="masa_kerja_pensiun_bln" type="text" class="form-control input-sm " value="<?php echo $row['masa_kerja_pensiun_bln'];?>" name="masa_kerja_pensiun_bln" readonly>
    <span class="input-group-addon" style="background-color: silver;">Bln</span>
  </div>
			</div>
            </div>
            <div class="row" >
            <div class="form-group col-md-6">
            <label for="ipt" class=" control-label "> Masa Kerja Golongan  </label>
                <div class="input-group input-group-sm ">
    <input id="masa_kerja_gol_thn" type="text" class="form-control input-sm " value="<?php echo $row['masa_kerja_gol_thn'];?>"  name="masa_kerja_gol_thn" readonly>
    <span class="input-group-addon" style="background-color: silver;">Thn</span>
    <input id="masa_kerja_gol_bln" type="text" class="form-control input-sm " value="<?php echo $row['masa_kerja_gol_bln'];?>"  name="masa_kerja_gol_bln" readonly>
    <span class="input-group-addon" style="background-color: silver;">Bln</span>
  </div>
			</div>
            </div>
            <div class="row">
            <div class="form-group col-md-8">
			    <label for="ipt" class=" control-label "> Pendidikan </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['pendidikan_terakhir'];?>" name="pendidikan_terakhir" id="pendidikan_terakhir">
			</div>
            <div class="form-group col-md-4">
			    <label for="ipt" class=" control-label "> Thn Lulus </label>
				<input type="text" readonly class="form-control input-sm parsley-validated"  value="<?php echo $row['pendidikan_tahun'];?>" name="pendidikan_tahun" id="pendidikan_tahun">
			</div>

        </div>
        
        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan & Selanjutnya <i class="fa fa-arrow-right"></i></button>
    </div>
    
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
var frm = $('#formDatadetail');
$('#formDatadetail').on('submit',function(e) {
    
    if(!frm.valid()) return false;
  e.preventDefault(); 
  if ( $(this).parsley().isValid() ) {
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo site_url("epusulanpemberhentianpegawai/updateDetail");?>',
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