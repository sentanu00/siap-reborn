<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('penataran/save/' . $row['PENATARAN_SEMINAR_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PENATARAN ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENATARAN_SEMINAR_ID']; ?>' name='PENATARAN_SEMINAR_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' id='NAMA' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT']; ?>' name='TEMPAT' />
					</div>

				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PENYELENGGARA </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENYELENGGARA']; ?>' name='PENYELENGGARA' />
					</div>
					<div class="row">
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TGL MULAI <span class="asterix"> * </span> </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_MULAI']; ?>' name='TANGGAL_MULAI' id='TANGGAL_MULAI' required />
						</div>
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TGL SELESAI <span class="asterix"> * </span> </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SELESAI']; ?>' name='TANGGAL_SELESAI' id='TANGGAL_SELESAI' required />
						</div>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO PIAGAM </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_PIAGAM']; ?>' name='NO_PIAGAM' />
					</div>
					<div class="form-group ">
						<label for="ipt" class=" control-label "> TGL PIAGAM </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_PIAGAM']; ?>' name='TANGGAL_PIAGAM' />
					</div>

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> FILE PIAGAM / SERTIFIKAT <span class="asterix"> * </span></label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('penataran/viewfile') . '/FILE_PDF/' . $row['PENATARAN_SEMINAR_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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
			//var files = $('#FILE_PDF')[0].files;
			//form_data.append('FILE_PDF', files[0]);
			if(!frm.valid()) return false;
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
    var NAMA = document.getElementById("NAMA");
	var TANGGAL_MULAI = document.getElementById("TANGGAL_MULAI");
	var TANGGAL_SELESAI = document.getElementById("TANGGAL_SELESAI");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyNama = NAMA && NAMA.value === "";
	var isEmptyTglmulai= TANGGAL_MULAI && TANGGAL_MULAI.value === "";
	var isEmptyTglselesai= TANGGAL_SELESAI && TANGGAL_SELESAI.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyNama && isEmptyTglmulai && isEmptyTglselesai && isEmptyFile
    ? "Mohon kolom Nama, Tanggal Mulai, Tanggal Selesai, dan File Piagam Sertifikat harap diisi."
        : isEmptyNama
        ? "Mohon kolom Nama diisi."
			: isEmptyTglmulai
			? "Mohon kolom Tanggal Mulai diisi"
				: isEmptyTglselesai
				? "Mohon kolom Tanggal Selesai diisi"
					: isEmptyFile
					? "Mohon File Piagam Sertifikat harap diisi"
						: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>