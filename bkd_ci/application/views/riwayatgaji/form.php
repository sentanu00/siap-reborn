<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('riwayatgaji/save/' . $row['GAJI_RIWAYAT_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> GAJI RIWAYAT ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI_RIWAYAT_ID']; ?>' name='GAJI_RIWAYAT_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP <span class="asterix"> * </span> </label>
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JENIS KENAIKAN <span class="asterix"> * </span> </label>

						<?php $JENIS_KENAIKAN = explode(',', $row['JENIS_KENAIKAN']);
						$JENIS_KENAIKAN_opt = array('1' => 'Kenaikan Pangkat',  '2' => 'Gaji Berkala',  '3' => 'Penyesuaian Gaji Pokok',  '4' => 'SK Lain-lain',); ?>
						<select name='JENIS_KENAIKAN' id='JENIS_KENAIKAN' rows='5' required class='form-control input-sm ' style='width: 100%;'>
							<?php
							foreach ($JENIS_KENAIKAN_opt as $key => $val) {
								echo "<option  value ='$key' " . ($row['JENIS_KENAIKAN'] == $key ? " selected='selected' " : '') . ">$val</option>";
							}
							?></select>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK <span class="asterix"> * </span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['NO_SK']; ?>' name='NO_SK' id='NO_SK' />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TANGGAL SK <span class="asterix"> * </span></label>

							<input type='date' class='form-control input-sm datetime' required placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' id='TANGGAL_SK' />
						</div>
						<div class="form-group   col-md-6">
							<label for="ipt" class=" control-label "> TMT SK <span class="asterix"> * </span></label>

							<input type='date' class='form-control input-sm datetime' required placeholder='' value='<?php echo $row['TMT_SK']; ?>' name='TMT_SK' id='TMT_SK' />
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="row">
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> PANGKAT <span class="asterix"> * </span></label>
							<select name='PANGKAT_ID' rows='5' id='PANGKAT_ID' required code='{$PANGKAT_ID}' class='form-control input-sm  ' style='width: 100%;'></select>
						</div>
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> GAJI POKOK <span class="asterix"> * </span> </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI_POKOK']; ?>' name='GAJI_POKOK' id='GAJI_POKOK' required />
						</div>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> MASA KERJA </label>
						<div class="row">
							<div class="col-md-3">
								<input type='text' class='form-control input-sm ' placeholder='' value='<?php echo $row['MASA_KERJA_TAHUN']; ?>' name='MASA_KERJA_TAHUN' />
							</div><span class="col-md-3">Thn</span>
							<div class="col-md-3">
								<input type='text' class='form-control input-sm ' placeholder='' value='<?php echo $row['MASA_KERJA_BULAN']; ?>' name='MASA_KERJA_BULAN' />
							</div><span class="col-md-3">Bln</span>
						</div>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> UPLOAD SK <span class="asterix"> * </span></label>
						<input type='file' class='form-control input-sm' accept="application/pdf" required id="FILE_PDF" name="FILE_PDF">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
						
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('riwayatgaji/viewfile') . '/FILE_PDF/' . $row['GAJI_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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

	$(document).ready(function() {
		$('.select2').select2();
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
					alert('Data Berhasil Disimpan !!');
					table.ajax.reload();
					$('#form-ajax').html("");
				}
			});
		});


		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('riwayatgaji/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});

		$("#PANGKAT_ID").jCombo("<?php echo site_url('riwayatgaji/comboselect?filter=pangkat:PANGKAT_ID:KODE') ?>", {
			selected_value: '<?php echo $row["PANGKAT_ID"] ?>'
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
    var PEJABAT_PENETAP_ID = document.getElementById("PEJABAT_PENETAP_ID");
    var JENIS_KENAIKAN = document.getElementById("JENIS_KENAIKAN");
	var NO_SK = document.getElementById("NO_SK");
	var TANGGAL_SK = document.getElementById("TANGGAL_SK");
	var TMT_SK = document.getElementById("TMT_SK");
	var PANGKAT_ID = document.getElementById("PANGKAT_ID");
	var GAJI_POKOK = document.getElementById("GAJI_POKOK");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyInputPejabat = PEJABAT_PENETAP_ID && PEJABAT_PENETAP_ID.value === "";
    var isEmptyJenisKenaikan = JENIS_KENAIKAN && JENIS_KENAIKAN.value === "";
	var isEmptyNoSK = NO_SK && NO_SK.value === "";
	var isEmptyTglSK = TANGGAL_SK && TANGGAL_SK.value === "";
	var isEmptyTMTSK = TMT_SK && TMT_SK.value === "";
	var isEmptyPangkat = PANGKAT_ID && PANGKAT_ID.value === "";
	var isEmptyGaji= GAJI_POKOK && GAJI_POKOK.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyInputPejabat && isEmptyJenisKenaikan && isEmptyNoSK && isEmptyTglSK && isEmptyTMTSK && isEmptyPangkat && isEmptyGaji && isEmptyFile
    ? "Mohon kolom Pejabat Penetap, Jenis Kenaikan, No SK, Tanggal SK, TMT SK, Pangkat, Gaji Pokok dan Dokumen SK harap diisi."
        : isEmptyInputPejabat
        ? "Mohon kolom Pejabat Penetap diisi."
            : isEmptyJenisKenaikan
            ? "Mohon kolom Jenis Kenaikan diisi."
				: isEmptyNoSK
				? "Mohon kolom No SK diisi"
					: isEmptyTglSK
					? "Mohon kolom Tanggal SK diisi"
						: isEmptyTMTSK
						? "Mohon kolom TMT SK diisi"
							: isEmptyPangkat
							? "Mohon kolom Pangkat diisi"
								: isEmptyGaji
								? "Mohon kolom Gaji diisi"
									: isEmptyFile
									? "Mohon Dokumen SK harap diisi"
										: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>