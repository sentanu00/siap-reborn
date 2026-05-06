<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('cuti/save/' . $row['CUTI_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> CUTI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['CUTI_ID']; ?>' name='CUTI_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> JENIS CUTI <span class="asterix"> * </span> </label>

							<?php $JENIS_CUTI = explode(',', $row['JENIS_CUTI']);
							$JENIS_CUTI_opt = array('1' => 'Cuti Tahunan',  '2' => 'Cuti Besar (Umroh / Haji)',  '3' => 'Cuti Sakit',  '4' => 'Cuti Bersalin',  '5' => 'CLTN',  '6' => 'Perpanjang CLTN',  '7' => 'Cuti Menikah', '8' => 'Cuti Alasan Penting',); ?>
							<select name='JENIS_CUTI' rows='5' id='JENIS_CUTI' required class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($JENIS_CUTI_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['JENIS_CUTI'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select>
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TANGGAL PERMOHONAN </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_PERMOHONAN']; ?>' name='TANGGAL_PERMOHONAN' />
						</div>
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> NO SURAT <span class="asterix"> * </span> </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SURAT']; ?>' name='NO_SURAT' id='NO_SURAT' required />
						</div>
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TANGGAL SURAT </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SURAT']; ?>' name='TANGGAL_SURAT' />
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="row">
						<div class="form-group  col-md-5">
							<label for="ipt" class=" control-label "> TANGGAL MULAI <span class="asterix"> * </span></label>
							<input type='date' class='form-control input-sm' required placeholder='' value='<?php echo $row['TANGGAL_MULAI']; ?>' name='TANGGAL_MULAI' id='TANGGAL_MULAI' />
						</div>
						<div class="form-group  col-md-5">
							<label for="ipt" class=" control-label "> TANGGAL SELESAI <span class="asterix"> * </span></label>
							<input type='date' class='form-control input-sm' required placeholder='' value='<?php echo $row['TANGGAL_SELESAI']; ?>' name='TANGGAL_SELESAI' id='TANGGAL_SELESAI' />
						</div>
						<div class="form-group col-md-2 ">
							<label for="ipt" class=" control-label "> LAMA <span class="asterix"> * </span></label>
							<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['LAMA']; ?>' name='LAMA' id='LAMA' />
						</div>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KETERANGAN <span class="asterix"> * </span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['KETERANGAN']; ?>' name='KETERANGAN' id='KETERANGAN' />

					</div>

					<div class="form-group">
						<label for="ipt" class=" control-label "> LAMPIRAN <span class="asterix"> * </span></label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
						<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
						<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />

						<?
						if ($row['FILE_PDF'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('cuti/viewfile') . '/FILE_PDF/' . $row['CUTI_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
						}
						?>

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




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});

	function validateForm() {
		var JENIS_CUTI = document.getElementById("JENIS_CUTI");
		var NO_SURAT = document.getElementById("NO_SURAT");
		var TANGGAL_MULAI = document.getElementById("TANGGAL_MULAI");
		var TANGGAL_SELESAI = document.getElementById("TANGGAL_SELESAI");
		var LAMA = document.getElementById("LAMA");
		var KETERANGAN = document.getElementById("KETERANGAN");
		var FILE_PDF = document.getElementById("FILE_PDF");

		var isEmptyJenis = JENIS_CUTI && JENIS_CUTI.value === "";
		var isEmptyNoSurat = NO_SURAT && NO_SURAT.value === "";
		var isEmptyTglMulai = TANGGAL_MULAI && TANGGAL_MULAI.value === "";
		var isEmptyTglSelesai = TANGGAL_SELESAI && TANGGAL_SELESAI.value === "";
		var isEmptyLama = LAMA && LAMA.value === "";
		var isEmptyKeterangan = KETERANGAN && KETERANGAN.value === "";
		var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

		var errorMessage = isEmptyJenis && isEmptyNoSurat && isEmptyTglMulai && isEmptyTglSelesai && isEmptyLama && isEmptyKeterangan && isEmptyFile ?
			"Mohon kolom Jenis Cuti, No Surat, Tanggal Mulai, Tanggal Selesai, Lama, Keterangan dan Lampiran harap diisi." :
			isEmptyJenis ?
			"Mohon kolom Jenis diisi." :
			isEmptyNoSurat ?
			"Mohon kolom No Surat diisi." :
			isEmptyTglMulai ?
			"Mohon kolom Tanggal Mulai diisi." :
			isEmptyTglSelesai ?
			"Mohon kolom Tanggal Selesai diisi." :
			isEmptyLama ?
			"Mohon kolom Lama diisi." :
			isEmptyKeterangan ?
			"Mohon kolom Keterangan diisi." :
			isEmptyFile ?
			"Mohon Lampiran harap diisi" :
			"";

		if (errorMessage) {
			alert(errorMessage);
			return false;
		}

		return true;
	}
</script>