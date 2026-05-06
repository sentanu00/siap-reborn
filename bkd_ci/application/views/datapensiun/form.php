<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('datapensiun/save/' . $row['PENSIUN_ID']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-12">

					<div class="form-group row  ">
						<label for="NO SK" class=" control-label col-md-4 text-left"> NO SK </label>
						<div class="col-md-8">
							<textarea name='NO_SK' rows='2' id='NO_SK' class='form-control input-sm '><?php echo $row['NO_SK']; ?></textarea> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TMT PENSIUN" class=" control-label col-md-4 text-left"> TMT PENSIUN </label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_PENSIUN']; ?>' name='TMT_PENSIUN' style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="BERHENTI AKHIR BULAN" class=" control-label col-md-4 text-left"> BERHENTI AKHIR BULAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BERHENTI_AKHIR_BULAN']; ?>' name='BERHENTI_AKHIR_BULAN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="BERHENTI AKHIR TAHUN" class=" control-label col-md-4 text-left"> BERHENTI AKHIR TAHUN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BERHENTI_AKHIR_TAHUN']; ?>' name='BERHENTI_AKHIR_TAHUN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="MK GOLONGAN BULAN" class=" control-label col-md-4 text-left"> MK GOLONGAN BULAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MK_GOLONGAN_BULAN']; ?>' name='MK_GOLONGAN_BULAN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="MK GOLONGAN TAHUN" class=" control-label col-md-4 text-left"> MK GOLONGAN TAHUN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MK_GOLONGAN_TAHUN']; ?>' name='MK_GOLONGAN_TAHUN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="JABATAN AKHIR NAMA" class=" control-label col-md-4 text-left"> JABATAN AKHIR NAMA </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_AKHIR_NAMA']; ?>' name='JABATAN_AKHIR_NAMA' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="GAJI POKOK LAMA" class=" control-label col-md-4 text-left"> GAJI POKOK LAMA </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI_POKOK_LAMA']; ?>' name='GAJI_POKOK_LAMA' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="GAJI POKOK BARU" class=" control-label col-md-4 text-left"> GAJI POKOK BARU </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI_POKOK_BARU']; ?>' name='GAJI_POKOK_BARU' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="SATKER ID" class=" control-label col-md-4 text-left"> SATKER ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SATKER_ID']; ?>' name='SATKER_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="SATKER NAMA" class=" control-label col-md-4 text-left"> SATKER NAMA </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SATKER_NAMA']; ?>' name='SATKER_NAMA' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PANGKAT LAMA ID" class=" control-label col-md-4 text-left"> PANGKAT LAMA ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PANGKAT_LAMA_ID']; ?>' name='PANGKAT_LAMA_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PANGKAT BARU ID" class=" control-label col-md-4 text-left"> PANGKAT BARU ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PANGKAT_BARU_ID']; ?>' name='PANGKAT_BARU_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="MK PENSIUN BULAN" class=" control-label col-md-4 text-left"> MK PENSIUN BULAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MK_PENSIUN_BULAN']; ?>' name='MK_PENSIUN_BULAN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="MK PENSIUN TAHUN" class=" control-label col-md-4 text-left"> MK PENSIUN TAHUN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MK_PENSIUN_TAHUN']; ?>' name='MK_PENSIUN_TAHUN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PENSIUN POKOK" class=" control-label col-md-4 text-left"> PENSIUN POKOK </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENSIUN_POKOK']; ?>' name='PENSIUN_POKOK' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="DATE CREATE" class=" control-label col-md-4 text-left"> DATE CREATE </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DATE_CREATE']; ?>' name='DATE_CREATE' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="DATE UPDATE" class=" control-label col-md-4 text-left"> DATE UPDATE </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DATE_UPDATE']; ?>' name='DATE_UPDATE' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="FILE PDF" class=" control-label col-md-4 text-left"> FILE PDF </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FILE_PDF']; ?>' name='FILE_PDF' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PENANDA TANGAN" class=" control-label col-md-4 text-left"> PENANDA TANGAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENANDA_TANGAN']; ?>' name='PENANDA_TANGAN' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PENANDATANGAN ID" class=" control-label col-md-4 text-left"> PENANDATANGAN ID </label>
						<div class="col-md-8">
							<textarea name='PENANDATANGAN_ID' rows='2' id='PENANDATANGAN_ID' class='form-control input-sm '><?php echo $row['PENANDATANGAN_ID']; ?></textarea> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>


			</div>

			<div style="clear:both">
				<hr />
			</div>

			<div class="toolbar-line text-center">
				<?
				if ($this->access['is_edit'] == 1 || $this->access['is_add'] == 1) {
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
	$(document).on("keypress", 'form', function(e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	$('input').on('keyup', function(event) {
		if (event.keyCode == 13) { // 13 is the keycode for enter button
			$(this).next('input').focus();
		}
	});

	$(document).ready(function() {

		var frm = $('form');
		frm.submit(function(ev) {
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function(data) {
					alert('Data Berhasil Disimpan !!');
					table.ajax.reload();
					$('#form-ajax').html("");
				}
			});
			ev.preventDefault();
		});




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});
</script>