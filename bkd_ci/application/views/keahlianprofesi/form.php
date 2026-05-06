<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('keahlianprofesi/save/' . $row['KURSUS_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> KURSUS ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KURSUS_ID']; ?>' name='KURSUS_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA <span class="asterix">*</span></label>
						<textarea name='NAMA' rows='2' id='NAMA' required class='form-control input-sm '><?php echo $row['NAMA']; ?></textarea>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT </label>
						<textarea name='TEMPAT' rows='2' id='TEMPAT' class='form-control input-sm '><?php echo $row['TEMPAT']; ?></textarea>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group ">
						<label for="ipt" class=" control-label "> PENYELENGGARA <span class="asterix">*</span></label>
						<textarea name='PENYELENGGARA' rows='2' id='PENYELENGGARA' required class='form-control input-sm '><?php echo $row['PENYELENGGARA']; ?></textarea>
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TGL MULAI </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_MULAI']; ?>' name='TANGGAL_MULAI' />
						</div>
						<div class="form-group  col-md-6 ">
							<label for="ipt" class=" control-label "> TGL SELESAI </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SELESAI']; ?>' name='TANGGAL_SELESAI' />
						</div>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO PIAGAM <span class="asterix">*</span></label>
						<textarea name='NO_PIAGAM' rows='2' id='NO_PIAGAM' required class='form-control input-sm '><?php echo $row['NO_PIAGAM']; ?></textarea>
					</div>
					<div class="form-group  col-md-9">
						<label for="ipt" class=" control-label "> TGL PIAGAM <span class="asterix">*</span></label>

						<input type='date' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['TANGGAL_PIAGAM']; ?>' name='TANGGAL_PIAGAM' id='TANGGAL_PIAGAM' required style='width:150px !important;' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> UPLOAD FILE <span class="asterix">*</span></label>
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
		if($row['FILE_PDF'] != ''){
				?>
				$('#FILE_PDF').prop('required',false);
				<?
			}else{
			?>
				$('#FILE_PDF').prop('required',true);
			<?
			}
		?>

	$(document).ready(function() {

		var frm = $('form');
		$("#kirimdata").click(function() {

			var form_data = new FormData(frm[0]);
			// var files = $('#FILE_PDF')[0].files;
			// form_data.append('FILE_PDF', files[0]);

			if(!frm.valid()) return false;
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
	var PENYELENGGARA = document.getElementById("PENYELENGGARA");
	var NO_PIAGAM = document.getElementById("NO_PIAGAM");
	var TANGGAL_PIAGAM = document.getElementById("TANGGAL_PIAGAM");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyNama = NAMA && NAMA.value === "";
	var isEmptyPenyelenggara= PENYELENGGARA && PENYELENGGARA.value === "";
	var isEmptyNoPiagam= NO_PIAGAM && NO_PIAGAM.value === "";
	var isEmptyTglPiagam= TANGGAL_PIAGAM && TANGGAL_PIAGAM.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyNama && isEmptyPenyelenggara && isEmptyNoPiagam && isEmptyTglPiagam && isEmptyFile
    ? "Mohon kolom Nama, Penyelenggara, No Piagam, Tanggal Piagam, dan Lampiran File harap diisi."
        : isEmptyNama
        ? "Mohon kolom Nama diisi."
			: isEmptyPenyelenggara
			? "Mohon kolom Penyelenggara diisi."
				: isEmptyNoPiagam
				? "Mohon kolom No Piagam diisi"
					: isEmptyTglPiagam
					? "Mohon kolom Tanggal Piagam diisi"
						: isEmptyFile
						? "Mohon Lampiran File harap diisi"
							: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>