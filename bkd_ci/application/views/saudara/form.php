<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('saudara/save/' . $row['SAUDARA_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> SAUDARA ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SAUDARA_ID']; ?>' name='SAUDARA_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' id='NAMA' required />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TEMPAT LAHIR <span class="asterix">*</span></label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT_LAHIR']; ?>' name='TEMPAT_LAHIR' id='TEMPAT_LAHIR' required />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TANGGAL LAHIR <span class="asterix">*</span></label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_LAHIR']; ?>' name='TANGGAL_LAHIR' id='TANGGAL_LAHIR' required />
						</div>
					</div>
					<div class="row">
						<div class="form-group  col-md-4">
							<label for="ipt" class=" control-label "> JENIS KELAMIN </label>

							<?php $JENIS_KELAMIN = explode(',', $row['JENIS_KELAMIN']);
							$JENIS_KELAMIN_opt = array('L' => 'L',  'P' => 'P',); ?>
							<select name='JENIS_KELAMIN' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($JENIS_KELAMIN_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['JENIS_KELAMIN'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select>
						</div>
						<div class="form-group  col-md-8">
							<label for="ipt" class=" control-label "> PEKERJAAN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEKERJAAN']; ?>' name='PEKERJAAN' />
						</div>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> ALAMAT </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ALAMAT']; ?>' name='ALAMAT' />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> KODEPOS </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KODEPOS']; ?>' name='KODEPOS' />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TELEPON </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TELEPON']; ?>' name='TELEPON' />
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PROPINSI </label>
						<select name='PROPINSI_ID' rows='5' id='PROPINSI_ID' code='{$PROPINSI_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KABUPATEN </label>
						<select name='KABUPATEN_ID' rows='5' id='KABUPATEN_ID' code='{$KABUPATEN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KECAMATAN </label>
						<select name='KECAMATAN_ID' rows='5' id='KECAMATAN_ID' code='{$KECAMATAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KELURAHAN </label>
						<select name='KELURAHAN_ID' rows='5' id='KELURAHAN_ID' code='{$KELURAHAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> UPLOAD AKTE <span class="asterix">*</span></label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF">
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
					<!-- <input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" /> -->

					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" onclick="return validateForm();" />
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

	<?
	if ($row['FILE_PDF'] != '') {
	?>
		$('#FILE_PDF').prop('required', false);
	<?
	} else {
	?>
		$('#FILE_PDF').prop('required', true);
	<?
	}
	?>

	$(document).ready(function() {

		var frm = $('form');
		$("#kirimdata").click(function() {
			var form_data = new FormData(frm[0]);
			// var files = $('#FILE_PDF')[0].files;
			// form_data.append('FILE_PDF', files[0]);

			if (!frm.valid()) return false;
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: form_data,
				cache: false,
				processData: false,
				contentType: false,
				success: function(data) {
					alert('Data Berhasil Disimpan !!');
					table.ajax.reload();
					$('#form-ajax').html("");
				}
			});
		});


		$("#PROPINSI_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=propinsi:PROPINSI_ID:NAMA", {
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>'
		});

		$("#KABUPATEN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kabupaten:child_id:NAMA:PROPINSI_ID:", {
			parent: '#PROPINSI_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>'
		});

		$("#KECAMATAN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kecamatan:child_id:NAMA:parent_id:", {
			parent: '#KABUPATEN_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>*<?php echo $row['KECAMATAN_ID']; ?>'
		});


		$("#KELURAHAN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kelurahan:child_id:NAMA:parent_id:", {
			parent: '#KECAMATAN_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>*<?php echo $row['KECAMATAN_ID']; ?>*<?php echo $row['KELURAHAN_ID']; ?>'
		});



		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});

	function validateForm() {
		var NAMA = document.getElementById("NAMA");
		var TEMPAT_LAHIR = document.getElementById("TEMPAT_LAHIR");
		var TANGGAL_LAHIR = document.getElementById("TANGGAL_LAHIR");
		var FILE_PDF = document.getElementById("FILE_PDF");

		var isEmptyNama = NAMA && NAMA.value === "";
		var isEmptyTL = TEMPAT_LAHIR && TEMPAT_LAHIR.value === "";
		var isEmptyTglLahir = TANGGAL_LAHIR && TANGGAL_LAHIR.value === "";
		var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

		var errorMessage = isEmptyNama && isEmptyTL && isEmptyTglLahir && isEmptyFile ?
			"Mohon kolom Nama, Tempat Lahir, Tanggal Lahir, dan Lampiran File harap diisi." :
			isEmptyNama ?
			"Mohon kolom Nama diisi." :
			isEmptyTL ?
			"Mohon kolom Tempat Lahir diisi." :
			isEmptyTglLahir ?
			"Mohon kolom Tanggal Lahir diisi." :
			isEmptyFile ?
			"Mohon Lampiran File harap diisi" :
			"";

		if (errorMessage) {
			alert(errorMessage);
			return false;
		}

		return true;
	}
</script>
</script>