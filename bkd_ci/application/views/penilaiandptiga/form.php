<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('penilaiandptiga/save/' . $row['PENILAIAN_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PENILAIAN ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENILAIAN_ID']; ?>' name='PENILAIAN_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group col-md-6 ">
						<label for="ipt" class=" control-label "> TAHUN <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TAHUN']; ?>' name='TAHUN' id='TAHUN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KESETIAAN <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KESETIAAN']; ?>' name='KESETIAAN' id='KESETIAAN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PRESTASI <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PRESTASI']; ?>' name='PRESTASI' id='PRESTASI' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGUNG JAWAB <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGUNG_JAWAB']; ?>' name='TANGGUNG_JAWAB' id='TANGGUNG_JAWAB' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PRAKARSA <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PRAKARSA']; ?>' name='PRAKARSA' id='PRAKARSA' required />
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP ID </label>
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KEPEMIMPINAN <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KEPEMIMPINAN']; ?>' name='KEPEMIMPINAN' id='KEPEMIMPINAN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KETAATAN <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETAATAN']; ?>' name='KETAATAN' id='KETAATAN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KEJUJURAN <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KEJUJURAN']; ?>' name='KEJUJURAN' id='KEJUJURAN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KERJASAMA <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KERJASAMA']; ?>' name='KERJASAMA' id='KERJASAMA' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> LAMPIRAN <span class="asterix"> * </span> </label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('penilaiandptiga/viewfile') . '/FILE_PDF/' . $row['PENILAIAN_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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


		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('penilaiandptiga/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
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
    var TAHUN = document.getElementById("TAHUN");
	var KESETIAAN = document.getElementById("KESETIAAN");
	var PRESTASI = document.getElementById("PRESTASI");
	var TANGGUNG_JAWAB = document.getElementById("TANGGUNG_JAWAB");
	var PRAKARSA = document.getElementById("PRAKARSA");
	var KEPEMIMPINAN = document.getElementById("KEPEMIMPINAN");
	var KETAATAN = document.getElementById("KETAATAN");
	var KEJUJURAN = document.getElementById("KEJUJURAN");
	var KERJASAMA = document.getElementById("KERJASAMA");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyTahun = TAHUN && TAHUN.value === "";
	var isEmptyKesetiaan= KESETIAAN && KESETIAAN.value === "";
	var isEmptyPrestasi= PRESTASI && PRESTASI.value === "";
	var isEmptyTGJawab= TANGGUNG_JAWAB && TANGGUNG_JAWAB.value === "";
	var isEmptyPrakarsa= PRAKARSA && PRAKARSA.value === "";
	var isEmptyKepemimpinan= KEPEMIMPINAN && KEPEMIMPINAN.value === "";
	var isEmptyKetaatan= KETAATAN && KETAATAN.value === "";
	var isEmptyKejujuran= KEJUJURAN && KEJUJURAN.value === "";
	var isEmptyKerjasama= KERJASAMA && KERJASAMA.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyTahun && isEmptyKesetiaan && isEmptyPrestasi && isEmptyTGJawab && isEmptyPrakarsa && isEmptyKepemimpinan && isEmptyKetaatan && isEmptyKejujuran && isEmptyKerjasama && isEmptyFile
    ? "Mohon kolom Tahun, Kesetiaan, Prestasi, Tanggung Jawab, Prakarsa, Kepemimpinan, Ketaatan, Kejujuran, Kerjasama, dan Lampiran harap diisi."
        : isEmptyTahun
        ? "Mohon kolom Tahun diisi."
			: isEmptyKesetiaan
			? "Mohon kolom Kesetiaan diisi."
				: isEmptyPrestasi
				? "Mohon kolom Prestasi diisi."
					: isEmptyTGJawab
					? "Mohon kolom Tanggung Jawab diisi."
						: isEmptyPrakarsa
						? "Mohon kolom Prakarsa diisi."
							: isEmptyKepemimpinan
							? "Mohon kolom Kepemimpinan diisi."
								: isEmptyKetaatan
								? "Mohon kolom Ketaatan diisi."
									: isEmptyKejujuran
									? "Mohon kolom Kejujuran diisi."
										: isEmptyKerjasama
										? "Mohon kolom Kerjasama diisi."
											: isEmptyFile
											? "Mohon Lampiran harap diisi"
												: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>