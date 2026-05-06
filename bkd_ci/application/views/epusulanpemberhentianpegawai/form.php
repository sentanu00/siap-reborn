
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('epusulanpemberhentianpegawai/save/'.$row['id']); ?>" class='form-horizontal' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-12">
									
								  <div class="form-group row hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id'];?>' name='id'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row hidethis " style="display:none;">
									<label for="Usulan Pemberhentian Id" class=" control-label col-md-4 text-left"> Usulan Pemberhentian Id </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['usulan_pemberhentian_id'];?>' name='usulan_pemberhentian_id' id='usulan_pemberhentian_id'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Golongan" class=" control-label col-md-4 text-left"> Jenis Golongan <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <select name='jenis_golongan' rows='5' id='jenis_golongan' code='{$jenis_golongan}' 
							class='form-control input-sm select2 ' style='width: 100%;' required  ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Pemberhentian" class=" control-label col-md-4 text-left"> Jenis Pemberhentian <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <select name='jenis_pemberhentian' rows='5' id='jenis_pemberhentian' code='{$jenis_pemberhentian}' 
							class='form-control input-sm select2 ' style='width: 100%;' required  ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NIP" class=" control-label col-md-4 text-left"> NIP <span class="asterix"> * </span></label>
									<div class="col-md-8">
									<input type='hidden' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_id'];?>'  name='pegawai_id' id='pegawai_id'   required />  
									<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nip_pegawai'];?>'  id="nip_pegawai"  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 
								  <div class="form-group row  " >
									<label for="NIP" class=" control-label col-md-4 text-left"> Nama Pegawai <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nama_pegawai'];?>'  readonly id="nama_pegawai"  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Jabatan" class=" control-label col-md-4 text-left"> Jenis Jabatan <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jenis_jabatan'];?>' readonly name='jenis_jabatan' id='jenis_jabatan'  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Nama Jabatan" class=" control-label col-md-4 text-left"> Nama Jabatan <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nama_jabatan'];?>' readonly name='nama_jabatan' id='nama_jabatan'  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Unor" class=" control-label col-md-4 text-left"> Unor <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['unor'];?>' name='unor' id='unor' readonly required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Satuan Kerja" class=" control-label col-md-4 text-left"> Satuan Kerja <span class="asterix"> * </span></label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['satuan_kerja'];?>' readonly name='satuan_kerja' id='satuan_kerja'  required /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 

				<input type="hidden" name="lokasi_kerja" value="Pemerintah Kabupaten Probolinggo" />
				<input type="hidden" name="tmt_cpns" id="tmt_cpns" />
				<input type="hidden" name="tmt_pns" id="tmt_pns" />
				<input type="hidden" name="masa_kerja_pns_thn" id="masa_kerja_pns_thn" />
				<input type="hidden" name="masa_kerja_pns_bln" id="masa_kerja_pns_bln" />
				<input type="hidden" name="tmt_pensiun" id="tmt_pensiun" />
				<input type="hidden" name="masa_kerja_pensiun_thn" id="masa_kerja_pensiun_thn" />
				<input type="hidden" name="masa_kerja_pensiun_bln" id="masa_kerja_pensiun_bln" />
				<input type="hidden" name="gaji" id="gaji" />
				<input type="hidden" name="tahun_gaji" id="tahun_gaji" />
				<input type="hidden" name="golongan" id="golongan" />
				<input type="hidden" name="pangkat" id="pangkat" />
				<input type="hidden" name="tmt_golongan" id="tmt_golongan" />
				<input type="hidden" name="masa_kerja_gol_thn" id="masa_kerja_gol_thn" />
				<input type="hidden" name="masa_kerja_gol_bln" id="masa_kerja_gol_bln" />
				<input type="hidden" name="pendidikan_terakhir" id="pendidikan_terakhir" />
				<input type="hidden" name="pendidikan_tahun" id="pendidikan_tahun" />

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
	//$('#id_usulan').val();
	$('#usulan_pemberhentian_id').val($('#id_usulan').val());
	var frm = $('form');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
			dataType:'json',
            success: function (data) {
                if(!data.id){
					alert('error Simpan, Silahkan coba lagi err '+data);
				}else{
					$('#sximo-modal').modal('hide');
					//alert('Data Berhasil Disimpan !!');
                 	table.ajax.reload();
					setTimeout(function(){
						SximoModal("<?php echo site_url('epusulanpemberhentianpegawai/show');?>/"+data.id,'Detail Data Pegawai','950')
					}, 500);
				}
            }
        });
        ev.preventDefault();
    });
 	

		$("#jenis_golongan").jCombo("<?php echo site_url('epusulanpemberhentianpegawai/comboselect?filter=ep_ms_jenis_golongan:id:nama') ?>",
		{  selected_value : '<?php echo $row["jenis_golongan"] ?>' });
		
		$("#jenis_pemberhentian").jCombo("<?php echo site_url('epusulanpemberhentianpegawai/comboselect?filter=ep_ms_jenis_pemberhentian:id:nama') ?>",
		{  selected_value : '<?php echo $row["jenis_pemberhentian"] ?>' });
		 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});

$('#nip_pegawai').on("keypress", function(e){
        if(e.which == 13){
            var nip = $(this).val();
			if(nip != ''){
				$.ajax({
				url: "<?php echo site_url('epusulanpemberhentianpegawai/getpegawaiData') ?>",
				data:{nip:nip},
				type: "POST",
				dataType:"json",
				success: function(data) {
					if(data.result == 1){
						var rs = data.data;
						$('#pegawai_id').val(rs.PEGAWAI_ID);
						$('#nama_pegawai').val(rs.GELAR_DEPAN+''+rs.NAMA+rs.GELAR_BELAKANG);
						$('#jenis_jabatan').val(rs.TIPE_PEGAWAI);
						$('#nama_jabatan').val(rs.JABATAN);
						$('#unor').val(rs.NAMA_UNOR);
						$('#satuan_kerja').val(rs.NAMA_SATKER);
						$('#tmt_cpns').val(rs.TMT_CPNS);
						$('#tmt_pns').val(rs.TMT_PNS);
						$('#masa_kerja_pns_thn').val(rs.MS_PNS_THN);
						$('#masa_kerja_pns_bln').val(rs.MS_PNS_BLN);
						$('#tmt_pensiun').val(rs.TANGGAL_PENSIUN);
						$('#masa_kerja_pensiun_thn').val(rs.MS_PENSIUN_THN);
						$('#masa_kerja_pensiun_bln').val(rs.MS_PENSIUN_BLN);
						$('#gaji').val(rs.GAJI_POKOK);
						$('#tahun_gaji').val(rs.GAJI_THN);
						$('#golongan').val(rs.GOLONGAN_PANGKAT);
						$('#pangkat').val(rs.PANGKAT);
						$('#tmt_golongan').val(rs.TMT_PANGKAT);
						$('#masa_kerja_gol_thn').val(rs.MS_PANGKAT_THN);
						$('#masa_kerja_gol_bln').val(rs.MS_PANGKAT_BLN);
						$('#pendidikan_terakhir').val(rs.SEKOLAH);
						$('#pendidikan_tahun').val(rs.THN_LULUS);

					}else{
						$('#pegawai_id').val('');
						$('#nama_pegawai').val('');
						$('#jenis_jabatan').val('');
						$('#nama_jabatan').val('');
						$('#unor').val('');
						$('#satuan_kerja').val('');
						$('#tmt_cpns').val('');
						$('#tmt_pns').val('');
						$('#masa_kerja_pns_thn').val('');
						$('#masa_kerja_pns_bln').val('');
						$('#tmt_pensiun').val('');
						$('#masa_kerja_pensiun_thn').val('');
						$('#masa_kerja_pensiun_bln').val('');
						$('#gaji').val('');
						$('#tahun_gaji').val('');
						$('#golongan').val('');
						$('#pangkat').val('');
						$('#tmt_golongan').val('');
						$('#masa_kerja_gol_thn').val('');
						$('#masa_kerja_gol_bln').val('');
						$('#pendidikan_terakhir').val('');
						$('#pendidikan_tahun').val('');
						alert("NIP "+nip+" data tidak ditemukan!");
					}
				}
				});
			}
        }
    });
</script>		 