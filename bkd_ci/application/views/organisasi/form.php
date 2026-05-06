<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('organisasi/save/' . $row['ORGANISASI_RIWAYAT_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> ORGANISASI RIWAYAT ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ORGANISASI_RIWAYAT_ID']; ?>' name='ORGANISASI_RIWAYAT_ID' />
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
						<label for="ipt" class=" control-label "> JABATAN  <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['JABATAN']; ?>' name='JABATAN' id='JABATAN' />
					</div>
					<div class="row">
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TANGGAL AWAL  <span class="asterix">*</span></label>
							<input type='date' class='form-control input-sm' required placeholder='' value='<?php echo $row['TANGGAL_AWAL']; ?>' name='TANGGAL_AWAL' id='TANGGAL_AWAL' />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TANGGAL AKHIR </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_AKHIR']; ?>' name='TANGGAL_AKHIR' />
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PIMPINAN <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['PIMPINAN']; ?>' name='PIMPINAN' id='PIMPINAN'/>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT']; ?>' name='TEMPAT' />
					</div>

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> DOK. SK ORGANISASI <span class="asterix">*</span></label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF"  accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('organisasi/viewfile') . '/FILE_PDF/' . $row['ORGANISASI_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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
	var JABATAN = document.getElementById("JABATAN");
	var TANGGAL_AWAL = document.getElementById("TANGGAL_AWAL");
	var PIMPINAN = document.getElementById("PIMPINAN");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyNama = NAMA && NAMA.value === "";
	var isEmptyJabatan= JABATAN && JABATAN.value === "";
	var isEmptyTglAwal= TANGGAL_AWAL && TANGGAL_AWAL.value === "";
	var isEmptyPimpinan= PIMPINAN && PIMPINAN.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyNama && isEmptyJabatan && isEmptyTglAwal && isEmptyPimpinan && isEmptyFile
    ? "Mohon kolom Nama, Jabatan, Tanggal Awal, Pimpinan, dan Dok SK Organisasi harap diisi."
        : isEmptyNama
        ? "Mohon kolom Nama diisi."
			: isEmptyJabatan
			? "Mohon kolom Jabatan diisi."
				: isEmptyTglAwal
				? "Mohon kolom Tanggal Awal diisi."
					: isEmptyPimpinan
					? "Mohon kolom Pimpinan diisi."
						: isEmptyFile
						? "Mohon Dok SK Organisasi harap diisi"
							: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>