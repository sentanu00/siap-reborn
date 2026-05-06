<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('riwayatpendidikan/save/' . $row['PENDIDIKAN_RIWAYAT_ID']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row hidethis " style="display:none;">
						<label for="PENDIDIKAN RIWAYAT ID" class=" control-label col-md-4 text-left"> PENDIDIKAN RIWAYAT ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENDIDIKAN_RIWAYAT_ID']; ?>' name='PENDIDIKAN_RIWAYAT_ID' /> <br />
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
						<label for="PENDIDIKAN " class=" control-label col-md-4 text-left"> PENDIDIKAN <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='PENDIDIKAN_ID' rows='5' id='PENDIDIKAN_ID' code='{$PENDIDIKAN_ID}' class='form-control input-sm  ' style='width: 100%;' required></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="JURUSAN PENDIDIKAN " class=" control-label col-md-4 text-left"> JURUSAN PENDIDIKAN </label>
						<div class="col-md-8">
							<input type="hidden" name="JURUSAN" id="JURUSAN">
							<select name='JURUSAN_PENDIDIKAN_ID' rows='5' id='JURUSAN_PENDIDIKAN_ID' code='{$JURUSAN_PENDIDIKAN_ID}' class='form-control input-sm select2 ' style='width: 100%;' onchange="getnamajurusan()"></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NAMA" class=" control-label col-md-4 text-left"> NAMA SEKOLAH <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' id='NAMA' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TEMPAT" class=" control-label col-md-4 text-left"> TEMPAT </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT']; ?>' name='TEMPAT' /> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row  ">
						<label for="KEPALA" class=" control-label col-md-4 text-left"> KEPALA </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KEPALA']; ?>' name='KEPALA' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NO STTB" class=" control-label col-md-4 text-left"> NO STTB / NO IJAZAH <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_STTB']; ?>' name='NO_STTB' id='NO_STTB' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TANGGAL STTB" class=" control-label col-md-4 text-left"> TANGGAL STTB / TANGGAL IJAZAH <span class="asterix"> * </span> </label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['TANGGAL_STTB']; ?>' name='TANGGAL_STTB' id='TANGGAL_STTB' style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group  row  ">
						<label for="ipt" class=" control-label col-md-4 text-left "> DOK IJAZAH <span class="asterix"> * </span> </label>
						<div class="col-md-5">
							<!-- <input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF"> -->
							<!-- <input type="file" class="form-control input-sm" required id="FILE_PDF" name="FILE_PDF" accept=".pdf" onchange="checkFileSize(this)"> -->
							<input type="file" class="form-control input-sm" required id="FILE_PDF" name="FILE_PDF" accept=".pdf" onchange="checkFileSize('FILE_PDF', 'fileSizeErrorFilePdf')">

							<!-- <span id="fileSizeErrorFilePdf" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 2 MB.</span> -->
							<span id="fileSizeErrorFilePdf" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 2 MB.</span>

							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php //echo $row['FILE_PDF']; 
																					?>" /> -->
							<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />
						</div>
						<div class="col-md-2">
							<?
							if ($row['FILE_PDF'] != '') {
								echo '<a href="javascript:SximoModal(\'' . site_url('riwayatpendidikan/viewfile') . '/FILE_PDF/' . $row['PENDIDIKAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
						</div>
					</div>

					<div class="form-group  row  ">
						<label for="ipt" class=" control-label col-md-4 text-left "> DOK TRANSKRIP NILAI <span class="asterix"> * </span> </label>
						<div class="col-md-5">
							<!-- <input type='file' class='form-control input-sm' required id="FILE_TRANSKRIP" name="FILE_TRANSKRIP"> -->
							<input type="file" class="form-control input-sm" required id="FILE_TRANSKRIP" name="FILE_TRANSKRIP" accept=".pdf" onchange="checkFileSize('FILE_TRANSKRIP','fileSizeErrorFileTranskrip')">
							<!-- <input type="file" class="form-control input-sm" required id="FILE_TRANSKRIP" name="FILE_TRANSKRIP" accept=".pdf" onchange="checkFileSize('FILE_PDF', 'fileSizeErrorFilePdf')"> -->

							<span id="fileSizeErrorFileTranskrip" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 2 MB.</span>

							<!-- <input type="hidden" name="file_transkrip_cek" value="<?php echo $row['FILE_TRANSKRIP']; ?>" /> -->
							<input type="hidden" name="FILE_TRANSKRIP" value="<?php echo $row['FILE_TRANSKRIP']; ?>" />
						</div>
						<div class="col-md-2">
							<?
							if ($row['FILE_TRANSKRIP'] != '') {
								echo '<a href="javascript:SximoModal(\'' . site_url('riwayatpendidikan/viewfile') . '/FILE_TRANSKRIP/' . $row['PENDIDIKAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
						</div>
					</div>

					<div class="form-group  row  ">
						<label for="ipt" class=" control-label col-md-4 text-left "> DOK. SK PENCANTUMAN GELAR </label>
						<div class="col-md-5">
							<input type='file' class='form-control input-sm' id="FILE_SK_GELAR" name="FILE_SK_GELAR">
							<!-- <input type="hidden" name="file_skgelar_cek"  value="<?php echo $row['FILE_SK_GELAR']; ?>" /> -->
							<input type="hidden" name="FILE_SK_GELAR" value="<?php echo $row['FILE_SK_GELAR']; ?>" />
						</div>
						<div class="col-md-2">
							<?
							if ($row['FILE_SK_GELAR'] != '') {
								echo '<a href="javascript:SximoModal(\'' . site_url('riwayatpendidikan/viewfile') . '/FILE_SK_GELAR/' . $row['PENDIDIKAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
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

	<?
	if ($row['FILE_TRANSKRIP'] != '') {
	?>
		$('#FILE_TRANSKRIP').prop('required', false);
	<?
	} else {
	?>
		$('#FILE_TRANSKRIP').prop('required', true);
	<?
	}
	?>

	function getnamajurusan() {
		var data = $('#JURUSAN_PENDIDIKAN_ID').select2('data');
		if (data[0].id != '') {
			$('#JURUSAN').val(data[0].text);
		}
	}

	$(document).ready(function() {
		$('.select2').select2();
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


		$("#PENDIDIKAN_ID").jCombo("<?php echo site_url('riwayatpendidikan/comboselect?filter=pendidikan:PENDIDIKAN_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["PENDIDIKAN_ID"] ?>'
		});

		$("#JURUSAN_PENDIDIKAN_ID").jCombo("<?php echo site_url('riwayatpendidikan/comboselect?filter=jurusan_pendidikan:JURUSAN_PENDIDIKAN_ID:NAMA') ?>:PENDIDIKAN_ID:", {
			parent: '#PENDIDIKAN_ID',
			selected_value: '<?php echo $row["JURUSAN_PENDIDIKAN_ID"] ?>'
		});



		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});


	function checkFileSize(inputId, errorSpanId) {
		var input = document.getElementById(inputId);

		if (input.files && input.files[0]) {
			var fileSize = input.files[0].size; // Ukuran file dalam byte
			var maxSize = 2 * 1024 * 1024; // 2 MB dalam byte

			if (fileSize > maxSize) {
				document.getElementById(errorSpanId).style.display = "block";
				input.value = ""; // Mengosongkan input file
			} else {
				document.getElementById(errorSpanId).style.display = "none";
			}
		}
	}

	function validateForm() {
		var PENDIDIKAN_ID = document.getElementById("PENDIDIKAN_ID");
		var NAMA = document.getElementById("NAMA");
		var NO_STTB = document.getElementById("NO_STTB");
		var TANGGAL_STTB = document.getElementById("TANGGAL_STTB");
		var FILE_PDF = document.getElementById("FILE_PDF");
		var FILE_TRANSKRIP = document.getElementById("FILE_TRANSKRIP");

		var isEmptyPendidikan = PENDIDIKAN_ID && PENDIDIKAN_ID.value === "";
		var isEmptyNama = NAMA && NAMA.value === "";
		var isEmptyNoSTTB = NO_STTB && NO_STTB.value === "";
		var isEmptyTglSTTB = TANGGAL_STTB && TANGGAL_STTB.value === "";
		var isEmptyFilePDF = FILE_PDF && FILE_PDF.value === "";
		var isEmptyFileTranskrip = FILE_TRANSKRIP && FILE_TRANSKRIP.value === "";

		var errorMessage = isEmptyPendidikan && isEmptyNama && isEmptyNoSTTB && isEmptyTglSTTB && isEmptyTglSTTB && isEmptyFilePDF && isEmptyFileTranskrip ?
			"Mohon kolom Pendidikan, Nama, No STTB, Tanggal STTB, Dok Ijazah dan Dok Transkrip Nilai harap diisi." :
			isEmptyPendidikan ?
			"Mohon kolom Pendidikan diisi." :
			isEmptyNama ?
			"Mohon kolom Nama diisi." :
			isEmptyNoSTTB ?
			"Mohon kolom No STTB diisi" :
			isEmptyTglSTTB ?
			"Mohon kolom Tanggal STTB diisi" :
			isEmptyFile ?
			"Mohon kolom Dok Ijazah diisi" :
			isEmptyFileTranskrip ?
			"Mohon kolom Dok Transkrip Nilai diisi" :
			"";



		if (errorMessage) {
			alert(errorMessage);
			return false;
		}

		return true;
	}
</script>