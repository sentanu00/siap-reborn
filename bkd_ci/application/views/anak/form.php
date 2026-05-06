<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('anak/save/' . $row['ANAK_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> ANAK ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ANAK_ID']; ?>' name='ANAK_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' id='NAMA' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT LAHIR <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['TEMPAT_LAHIR']; ?>' name='TEMPAT_LAHIR' id='TEMPAT_LAHIR' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL LAHIR <span class="asterix">*</span> </label>

						<input type='date' class='form-control input-sm ' placeholder='' value='<?php echo $row['TANGGAL_LAHIR']; ?>' name='TANGGAL_LAHIR' id='TANGGAL_LAHIR' required style='width:150px !important;' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> STATUS KELUARGA </label>

						<?php $STATUS_KELUARGA = explode(',', $row['STATUS_KELUARGA']);
						$STATUS_KELUARGA_opt = array('1' => 'Kandung',  '2' => 'Tiri',  '3' => 'Angkat',); ?>
						<select name='STATUS_KELUARGA' rows='5' class='form-control input-sm select2' style='width: 100%;'>
							<?php
							foreach ($STATUS_KELUARGA_opt as $key => $val) {
								echo "<option  value ='$key' " . ($row['STATUS_KELUARGA'] == $key ? " selected='selected' " : '') . ">$val</option>";
							}
							?></select>
					</div>
					<div class="form-group  ">
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
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PENDIDIKAN ID </label>
						<select name='PENDIDIKAN_ID' rows='5' id='PENDIDIKAN_ID' code='{$PENDIDIKAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEKERJAAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEKERJAAN']; ?>' name='PEKERJAAN' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> STATUS TUNJANGAN </label>

						<?php $STATUS_TUNJANGAN = explode(',', $row['STATUS_TUNJANGAN']);
						$STATUS_TUNJANGAN_opt = array('1' => 'Dapat',  '0' => 'Tidak',); ?>
						<select name='STATUS_TUNJANGAN' rows='5' class='form-control input-sm select2' style='width: 100%;'>
							<?php
							foreach ($STATUS_TUNJANGAN_opt as $key => $val) {
								echo "<option  value ='$key' " . ($row['STATUS_TUNJANGAN'] == $key ? " selected='selected' " : '') . ">$val</option>";
							}
							?></select>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SUAMI ISTRI </label>
						<select name='SUAMI_ISTRI_ID' rows='5' id='SUAMI_ISTRI_ID' code='{$SUAMI_ISTRI_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> AKHIR BAYAR </label>

						<input type='date' class='form-control input-sm ' placeholder='' value='<?php echo $row['AKHIR_BAYAR']; ?>' name='AKHIR_BAYAR' style='width:150px !important;' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> AWAL BAYAR </label>

						<input type='date' class='form-control input-sm ' placeholder='' value='<?php echo $row['AWAL_BAYAR']; ?>' name='AWAL_BAYAR' style='width:150px !important;' />
					</div>
					<div class="row">
						<div class="form-group   col-md-12">
							<label for="ipt" class=" control-label "> AKTA KELAHIRAN ANAK <span class="asterix">*</span></label>
							<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
							<input type="hidden" name="file_pdf_cek" value="<?php echo $row['FILE_PDF']; ?>" />

							<?
							if ($row['FILE_PDF'] != '') {
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('anak/viewfile') . '/FILE_PDF/' . $row['ANAK_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
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
			//var files = $('#FILE_PDF')[0].files;
			//form_data.append('FILE_PDF', files[0]);
			if (!frm.valid()) return false;

			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: form_data,
				cache: false,
				processData: false,
				contentType: false,
				success: function(data) {
					alert(data);
					table.ajax.reload();
					$('#form-ajax').html("");
				}
			});

		});


		$("#PENDIDIKAN_ID").jCombo("<?php echo site_url('anak/comboselect?filter=pendidikan:PENDIDIKAN_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["PENDIDIKAN_ID"] ?>'
		});

		$("#SUAMI_ISTRI_ID").jCombo("<?php echo site_url('anak/comboselect?filter=suami_istri:SUAMI_ISTRI_ID:NAMA:PEGAWAI_ID:') ?><?php echo $PEGAWAI_ID; ?>", {
			selected_value: '<?php echo $row["SUAMI_ISTRI_ID"] ?>'
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
			"Mohon kolom Nama, Tempat Lahir, Tanggal Lahir, dan Akta Lahir Anak harap diisi." :
			isEmptyNama ?
			"Mohon kolom Nama diisi." :
			isEmptyTL ?
			"Mohon kolom Tempat Lahir diisi." :
			isEmptyTglLahir ?
			"Mohon kolom Tanggal Lahir diisi." :
			isEmptyFile ?
			"Mohon Akta Lahir Anak harap diisi" :
			"";

		if (errorMessage) {
			alert(errorMessage);
			return false;
		}

		return true;
	}
</script>