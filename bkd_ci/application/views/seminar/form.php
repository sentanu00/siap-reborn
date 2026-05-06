<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('seminar/save/' . $row['SEMINAR_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> SEMINAR ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SEMINAR_ID']; ?>' name='SEMINAR_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA  <span class="asterix">*</span> </label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' id='NAMA' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT  <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['TEMPAT']; ?>' name='TEMPAT' id='TEMPAT' />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PENYELENGGARA  <span class="asterix">*</span> </label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['PENYELENGGARA']; ?>' name='PENYELENGGARA' id='PENYELENGGARA' />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TGL MULAI  <span class="asterix">*</span> </label>
							<input type='date' class='form-control input-sm' required placeholder='' value='<?php echo $row['TANGGAL_MULAI']; ?>' name='TANGGAL_MULAI' id='TANGGAL_MULAI'/>
						</div>
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TGL SELESAI  <span class="asterix">*</span></label>
							<input type='date' class='form-control input-sm ' required placeholder='' value='<?php echo $row['TANGGAL_SELESAI']; ?>' name='TANGGAL_SELESAI' id='TANGGAL_SELESAI' />
						</div>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO PIAGAM  <span class="asterix">*</span> </label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['NO_PIAGAM']; ?>' name='NO_PIAGAM' id='NO_PIAGAM'/>
					</div>
					<div class="form-group ">
						<label for="ipt" class=" control-label "> TANGGAL PIAGAM <span class="asterix">*</span> </label>
						<input type='date' class='form-control input-sm' required placeholder='' value='<?php echo $row['TANGGAL_PIAGAM']; ?>' name='TANGGAL_PIAGAM' id='TANGGAL_PIAGAM' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> LAMPIRAN PIAGAM / SERTIFIKAT  <span class="asterix">*</span> </label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('seminar/viewfile') . '/FILE_PDF/' . $row['SEMINAR_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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
		//	var files = $('#FILE_PDF')[0].files;
		//	form_data.append('FILE_PDF', files[0]);
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
	var TEMPAT = document.getElementById("TEMPAT");
	var PENYELENGGARA = document.getElementById("PENYELENGGARA");
	var TANGGAL_MULAI = document.getElementById("TANGGAL_MULAI");
	var TANGGAL_SELESAI = document.getElementById("TANGGAL_SELESAI");
	var NO_PIAGAM = document.getElementById("NO_PIAGAM");
	var TANGGAL_PIAGAM = document.getElementById("TANGGAL_PIAGAM");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyNama = NAMA && NAMA.value === "";
	var isEmptyTempat= TEMPAT && TEMPAT.value === "";
	var isEmptyPenyelenggara= PENYELENGGARA && PENYELENGGARA.value === "";
	var isEmptyTglmulai= TANGGAL_MULAI && TANGGAL_MULAI.value === "";
	var isEmptyTglselesai= TANGGAL_SELESAI && TANGGAL_SELESAI.value === "";
	var isEmptyNoPiagam= NO_PIAGAM && NO_PIAGAM.value === "";
	var isEmptyTglPiagam= TANGGAL_PIAGAM && TANGGAL_PIAGAM.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyNama && isEmptyTempat && isEmptyPenyelenggara && isEmptyTglmulai && isEmptyTglselesai && isEmptyNoPiagam && isEmptyTglPiagam && isEmptyFile
    ? "Mohon kolom Nama, Tempat, Penyelenggara, Tanggal Mulai, Tanggal Selesai, No Piagam, Tanggal Piagam, dan Lampiran Piagam Sertifikat harap diisi."
        : isEmptyNama
        ? "Mohon kolom Nama diisi."
			: isEmptyTempat
			? "Mohon kolom Tempat diisi."
				: isEmptyPenyelenggara
				? "Mohon kolom Penyelenggara diisi."
					: isEmptyTglmulai
					? "Mohon kolom Tanggal Mulai diisi"
						: isEmptyTglselesai
						? "Mohon kolom Tanggal Selesai diisi"
							: isEmptyNoPiagam
							? "Mohon kolom No Piagam diisi"
								: isEmptyTglPiagam
								? "Mohon kolom Tanggal Piagam diisi"
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