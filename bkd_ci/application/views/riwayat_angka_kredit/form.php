<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('riwayat_angka_kredit/save/' . $row['riwayat_angka_kredit_id']); ?>" class='form-horizontal'
			parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="NamaJabatan" class=" control-label col-md-4 text-left"> NamaJabatan </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['namaJabatan']; ?>' name='namaJabatan' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="SkDate" class=" control-label col-md-4 text-left"> SkDate </label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['skDate']; ?>' name='skDate'
								style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="AngkaKreditUtama" class=" control-label col-md-4 text-left"> AngkaKreditUtama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['angkaKreditUtama']; ?>' name='angkaKreditUtama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="AngkaKreditPenunjang" class=" control-label col-md-4 text-left"> AngkaKreditPenunjang </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['angkaKreditPenunjang']; ?>' name='angkaKreditPenunjang' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TotalAngkaKredit" class=" control-label col-md-4 text-left"> TotalAngkaKredit <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['totalAngkaKredit']; ?>' name='totalAngkaKredit' required parsley-type='number' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="SkNomor" class=" control-label col-md-4 text-left"> SkNomor <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skNomor']; ?>' name='skNomor' /> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="IsIntegrasi" class=" control-label col-md-4 text-left"> IsIntegrasi </label>
						<div class="col-md-8">
							<?php $isIntegrasi = explode(",", $row['isIntegrasi']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='isIntegrasi[]' value='1' class=''
									<?php if (in_array('1', $isIntegrasi)) echo 'checked'; ?> /> </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="IsKonversi" class=" control-label col-md-4 text-left"> IsKonversi </label>
						<div class="col-md-8">
							<?php $isKonversi = explode(",", $row['isKonversi']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='isKonversi[]' value='1' class=''
									<?php if (in_array('1', $isKonversi)) echo 'checked'; ?> /> </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="BulanMulaiPenilaian" class=" control-label col-md-4 text-left"> BulanMulaiPenilaian <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['bulanMulaiPenilaian']; ?>' name='bulanMulaiPenilaian' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TahunMulaiPenilaian" class=" control-label col-md-4 text-left"> TahunMulaiPenilaian <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahunMulaiPenilaian']; ?>' name='tahunMulaiPenilaian' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="BulanSelesaiPenilaian" class=" control-label col-md-4 text-left"> BulanSelesaiPenilaian <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['bulanSelesaiPenilaian']; ?>' name='bulanSelesaiPenilaian' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TahunSelesaiPenilaian" class=" control-label col-md-4 text-left"> TahunSelesaiPenilaian <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahunSelesaiPenilaian']; ?>' name='tahunSelesaiPenilaian' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Tahun" class=" control-label col-md-4 text-left"> Tahun <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahun']; ?>' name='tahun' required parsley-type='number' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="IsAngkaKreditPertama" class=" control-label col-md-4 text-left"> IsAngkaKreditPertama </label>
						<div class="col-md-8">
							<?php $isAngkaKreditPertama = explode(",", $row['isAngkaKreditPertama']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='isAngkaKreditPertama[]' value='1' class=''
									<?php if (in_array('1', $isAngkaKreditPertama)) echo 'checked'; ?> /> </label> <br />
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