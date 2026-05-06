
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('epusulanpemberhentianmonitoring/save/'.$row['id']); ?>" class='form-horizontal' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-12">
									
								  <div class="form-group row  " >
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id'];?>' name='id'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Usulan Pemberhentian Id" class=" control-label col-md-4 text-left"> Usulan Pemberhentian Id </label>
									<div class="col-md-8">
									  <select name='usulan_pemberhentian_id' rows='5' id='usulan_pemberhentian_id' code='{$usulan_pemberhentian_id}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Golongan" class=" control-label col-md-4 text-left"> Jenis Golongan </label>
									<div class="col-md-8">
									  <select name='jenis_golongan' rows='5' id='jenis_golongan' code='{$jenis_golongan}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Pemberhentian" class=" control-label col-md-4 text-left"> Jenis Pemberhentian </label>
									<div class="col-md-8">
									  <select name='jenis_pemberhentian' rows='5' id='jenis_pemberhentian' code='{$jenis_pemberhentian}' 
							class='form-control input-sm select2 ' style='width: 100%;'   ></select> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Pegawai Id" class=" control-label col-md-4 text-left"> Pegawai Id </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_id'];?>' name='pegawai_id'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Jenis Jabatan" class=" control-label col-md-4 text-left"> Jenis Jabatan </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jenis_jabatan'];?>' name='jenis_jabatan'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Nama Jabatan" class=" control-label col-md-4 text-left"> Nama Jabatan </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nama_jabatan'];?>' name='nama_jabatan'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Unor" class=" control-label col-md-4 text-left"> Unor </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['unor'];?>' name='unor'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Satuan Kerja" class=" control-label col-md-4 text-left"> Satuan Kerja </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['satuan_kerja'];?>' name='satuan_kerja'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Lokasi Kerja" class=" control-label col-md-4 text-left"> Lokasi Kerja </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['lokasi_kerja'];?>' name='lokasi_kerja'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Tmt Cpns" class=" control-label col-md-4 text-left"> Tmt Cpns </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tmt_cpns'];?>' name='tmt_cpns'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Tmt Pns" class=" control-label col-md-4 text-left"> Tmt Pns </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tmt_pns'];?>' name='tmt_pns'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Masa Kerja Pns Thn" class=" control-label col-md-4 text-left"> Masa Kerja Pns Thn </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['masa_kerja_pns_thn'];?>' name='masa_kerja_pns_thn'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Masa Kerja Pns Bln" class=" control-label col-md-4 text-left"> Masa Kerja Pns Bln </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['masa_kerja_pns_bln'];?>' name='masa_kerja_pns_bln'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Tmt Pensiun" class=" control-label col-md-4 text-left"> Tmt Pensiun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tmt_pensiun'];?>' name='tmt_pensiun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Masa Kerja Pensiun Thn" class=" control-label col-md-4 text-left"> Masa Kerja Pensiun Thn </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['masa_kerja_pensiun_thn'];?>' name='masa_kerja_pensiun_thn'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Masa Kerja Pensiun Bln" class=" control-label col-md-4 text-left"> Masa Kerja Pensiun Bln </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['masa_kerja_pensiun_bln'];?>' name='masa_kerja_pensiun_bln'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Gaji" class=" control-label col-md-4 text-left"> Gaji </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['gaji'];?>' name='gaji'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Tahun Gaji" class=" control-label col-md-4 text-left"> Tahun Gaji </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahun_gaji'];?>' name='tahun_gaji'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Golongan" class=" control-label col-md-4 text-left"> Golongan </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['golongan'];?>' name='golongan'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Pangkat" class=" control-label col-md-4 text-left"> Pangkat </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pangkat'];?>' name='pangkat'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Tmt Golongan" class=" control-label col-md-4 text-left"> Tmt Golongan </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tmt_golongan'];?>' name='tmt_golongan'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Masa Kerja Gol Thn" class=" control-label col-md-4 text-left"> Masa Kerja Gol Thn </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['masa_kerja_gol_thn'];?>' name='masa_kerja_gol_thn'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Masa Kerja Gol Bln" class=" control-label col-md-4 text-left"> Masa Kerja Gol Bln </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['masa_kerja_gol_bln'];?>' name='masa_kerja_gol_bln'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Pendidikan Terakhir" class=" control-label col-md-4 text-left"> Pendidikan Terakhir </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pendidikan_terakhir'];?>' name='pendidikan_terakhir'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Pendidikan Tahun" class=" control-label col-md-4 text-left"> Pendidikan Tahun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pendidikan_tahun'];?>' name='pendidikan_tahun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Kppn" class=" control-label col-md-4 text-left"> Kppn </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kppn'];?>' name='kppn'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Taspen" class=" control-label col-md-4 text-left"> Taspen </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['taspen'];?>' name='taspen'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Alamat Setelah Pensiun" class=" control-label col-md-4 text-left"> Alamat Setelah Pensiun </label>
									<div class="col-md-8">
									  <textarea name='alamat_setelah_pensiun' rows='2' id='alamat_setelah_pensiun' class='form-control input-sm '  
				           ><?php echo $row['alamat_setelah_pensiun'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Provinsi Id Setelah Pensiun" class=" control-label col-md-4 text-left"> Provinsi Id Setelah Pensiun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['provinsi_id_setelah_pensiun'];?>' name='provinsi_id_setelah_pensiun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Kab Id Setelah Pensiun" class=" control-label col-md-4 text-left"> Kab Id Setelah Pensiun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kab_id_setelah_pensiun'];?>' name='kab_id_setelah_pensiun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Kec Id Setelah Pensiun" class=" control-label col-md-4 text-left"> Kec Id Setelah Pensiun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kec_id_setelah_pensiun'];?>' name='kec_id_setelah_pensiun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Kel Id Setelah Pensiun" class=" control-label col-md-4 text-left"> Kel Id Setelah Pensiun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kel_id_setelah_pensiun'];?>' name='kel_id_setelah_pensiun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Kodepos Setelah Pensiun" class=" control-label col-md-4 text-left"> Kodepos Setelah Pensiun </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kodepos_setelah_pensiun'];?>' name='kodepos_setelah_pensiun'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Usulan User Act" class=" control-label col-md-4 text-left"> Usulan User Act </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['usulan_user_act'];?>' name='usulan_user_act'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Usulan Tgl Act" class=" control-label col-md-4 text-left"> Usulan Tgl Act </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['usulan_tgl_act'];?>' name='usulan_tgl_act'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Usulan Status" class=" control-label col-md-4 text-left"> Usulan Status </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['usulan_status'];?>' name='usulan_status'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Validasi User Act" class=" control-label col-md-4 text-left"> Validasi User Act </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['validasi_user_act'];?>' name='validasi_user_act'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Validasi Tgl Act" class=" control-label col-md-4 text-left"> Validasi Tgl Act </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['validasi_tgl_act'];?>' name='validasi_tgl_act'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Validasi Catatan" class=" control-label col-md-4 text-left"> Validasi Catatan </label>
									<div class="col-md-8">
									  <textarea name='validasi_catatan' rows='2' id='validasi_catatan' class='form-control input-sm '  
				           ><?php echo $row['validasi_catatan'] ;?></textarea> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="File Sk Upload" class=" control-label col-md-4 text-left"> File Sk Upload </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['file_sk_upload'];?>' name='file_sk_upload'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="File Sk Tgl Act" class=" control-label col-md-4 text-left"> File Sk Tgl Act </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['file_sk_tgl_act'];?>' name='file_sk_tgl_act'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="File Sk User Act" class=" control-label col-md-4 text-left"> File Sk User Act </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['file_sk_user_act'];?>' name='file_sk_user_act'   /> <br />
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

	var frm = $('form');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                alert('Data Berhasil Disimpan !!');
                 table.ajax.reload();
                  $('#form-ajax').html("");
            }
        });
        ev.preventDefault();
    });
 	

		$("#usulan_pemberhentian_id").jCombo("<?php echo site_url('epusulanpemberhentianmonitoring/comboselect?filter=ep_tx_usulan_pemberhentian:id:id') ?>",
		{  selected_value : '<?php echo $row["usulan_pemberhentian_id"] ?>' });
		
		$("#jenis_golongan").jCombo("<?php echo site_url('epusulanpemberhentianmonitoring/comboselect?filter=ep_ms_jenis_golongan:id:id') ?>",
		{  selected_value : '<?php echo $row["jenis_golongan"] ?>' });
		
		$("#jenis_pemberhentian").jCombo("<?php echo site_url('epusulanpemberhentianmonitoring/comboselect?filter=ep_ms_jenis_pemberhentian:id:id') ?>",
		{  selected_value : '<?php echo $row["jenis_pemberhentian"] ?>' });
		 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});
</script>		 