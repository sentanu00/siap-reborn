<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('riwayatpangkat/save/' . $row['PANGKAT_RIWAYAT_ID']); ?>" class='form-vertical'  method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PANGKAT RIWAYAT ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PANGKAT_RIWAYAT_ID']; ?>' name='PANGKAT_RIWAYAT_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> STLUD </label>

						<?php $STLUD = explode(',', $row['STLUD']);
						$STLUD_opt = array('' => '',  '1' => 'Tingkat I',  '2' => 'Tingakat II',  '3' => 'Tingkat III',); ?>
						<select name='STLUD' rows='5' class='form-control input-sm ' style='width: 100%;'>
							<?php
							foreach ($STLUD_opt as $key => $val) {
								echo "<option  value ='$key' " . ($row['STLUD'] == $key ? " selected='selected' " : '') . ">$val</option>";
							}
							?></select>
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP </label>
						<span class="asterix">*</span>
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' required style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PANGKAT </label>
						<span class="asterix">*</span>
						<select name='PANGKAT_ID' required rows='5' id='PANGKAT_ID' code='{$PANGKAT_ID}' class='form-control input-sm  ' style='width: 100%;'></select>
					</div>

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TMT PANGKAT </label>
						<span class="asterix">*</span>
						<input type='date' required class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_PANGKAT']; ?>' name='TMT_PANGKAT' id='TMT_PANGKAT' />
					</div>

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> GAJI POKOK </label>
						<span class="asterix">*</span>
						<input type='number' required class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI_POKOK']; ?>' name='GAJI_POKOK' id='GAJI_POKOK' />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO STLUD </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_STLUD']; ?>' name='NO_STLUD' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO NOTA </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_NOTA']; ?>' name='NO_NOTA' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK </label>
						<span class="asterix">*</span>
						<input type='text' required class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' id='NO_SK' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KREDIT </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KREDIT']; ?>' name='KREDIT' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KETERANGAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN']; ?>' name='KETERANGAN' />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL STLUD </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_STLUD']; ?>' name='TANGGAL_STLUD' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL NOTA </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_NOTA']; ?>' name='TANGGAL_NOTA' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL SK </label>
						<span class="asterix">*</span>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' id='TANGGAL_SK' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JENIS KP </label>

						<?php $JENIS_KP = explode(',', $row['JENIS_KP']);
						$JENIS_KP_opt = array('1' => 'Reguler',  '2' => 'Pilihan',  '3' => 'Anumerta',  '4' => 'Pengabdian',  '5' => 'SK Lain-lain',); ?>
						<select name='JENIS_KP' rows='5' class='form-control input-sm ' style='width: 100%;'>
							<?php
							foreach ($JENIS_KP_opt as $key => $val) {
								echo "<option  value ='$key' " . ($row['JENIS_KP'] == $key ? " selected='selected' " : '') . ">$val</option>";
							}
							?></select>
					</div>
					<div class="row">

						<div class="form-group col-md-6">
							<label for="ipt" class=" control-label "> MASA KERJA THN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA_TAHUN']; ?>' name='MASA_KERJA_TAHUN' />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> MASA KERJA BLN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA_BULAN']; ?>' name='MASA_KERJA_BULAN' />
						</div>
					</div>

					<div class="row">
						<div class="form-group   col-md-8">
							<label for="ipt" class=" control-label "> Dokumen SK KP <span class="asterix">*</span> </label>
							<input type='file' class='form-control input-sm' accept="application/pdf" required id="FILE_PDF" name="FILE_PDF">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
						</div>
						<div class="form-group   col-md-4">
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('riwayatpangkat/viewfile') . '/FILE_PDF/' . $row['PANGKAT_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
							}
							?>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group   col-md-8">
							<label for="ipt" class=" control-label "> Dokumen Pertimbangan Teknis KP </label>
							<input type='file' class='form-control input-sm' accept="application/pdf" id="FILE_PERTEK_KP" name="FILE_PERTEK_KP">
							<!-- <input type="hidden" name="file_pertek_cek"  value="<?php echo $row['FILE_PERTEK_KP']; ?>" /> -->
							<input type="hidden" name="FILE_PERTEK_KP"  value="<?php echo $row['FILE_PERTEK_KP']; ?>" />
						</div>
						<div class="form-group   col-md-4">
							<?
							if($row['FILE_PERTEK_KP'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('riwayatpangkat/viewfile') . '/FILE_PERTEK_KP/' . $row['PANGKAT_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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

				<!-- <input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" /> -->
				<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" onclick="return validateForm();" />
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
		$("#kirimdata").click(function(){
				//var data = frm.serialize();
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
		/*
		frm.submit(function(ev) {
			
			
			ev.preventDefault();
		});
		*/

		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('riwayatpangkat/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});

		$("#PANGKAT_ID").jCombo("<?php echo site_url('riwayatpangkat/comboselect?filter=pangkat:PANGKAT_ID:KODE') ?>", {
			selected_value: '<?php echo $row["PANGKAT_ID"] ?>'
		});


		<?
		if ($this->access['is_edit'] != 1 || $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>



	});
	function validateForm() {
    var PEJABAT_PENETAP_ID = document.getElementById("PEJABAT_PENETAP_ID");
    var PANGKAT_ID = document.getElementById("PANGKAT_ID");
	var TMT_PANGKAT = document.getElementById("TMT_PANGKAT");
	var NO_SK = document.getElementById("NO_SK");
	var TANGGAL_SK = document.getElementById("TANGGAL_SK");
	var GAJI_POKOK = document.getElementById("GAJI_POKOK");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyInputPejabat = PEJABAT_PENETAP_ID && PEJABAT_PENETAP_ID.value === "";
    var isEmptyPangkat = PANGKAT_ID && PANGKAT_ID.value === "";
	var isEmptyTMTPangkat = TMT_PANGKAT && TMT_PANGKAT.value === "";
	var isEmptyNoSK = NO_SK && NO_SK.value === "";
	var isEmptyTglSK = TANGGAL_SK && TANGGAL_SK.value === "";
	var isGajiPokok = GAJI_POKOK && GAJI_POKOK.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyInputPejabat && isEmptyPangkat && isEmptyTMTPangkat && isEmptyNoSK && isEmptyTglSK && isGajiPokok && isEmptyFile
    ? "Mohon kolom Pejabat Penetap, Pangkat, TMT Pangkat, No SK, Tanggal SK, Gaji Pokok, dan Dokumen SK KP harap diisi."
        : isEmptyInputPejabat
        ? "Mohon kolom Pejabat Penetap diisi."
            : isEmptyPangkat
            ? "Mohon kolom Pangkat diisi."
				: isEmptyTMTPangkat
				? "Mohon kolom TMT Pangkat diisi"
					: isEmptyNoSK
					? "Mohon kolom No SK diisi"
						: isEmptyTglSK
						? "Mohon kolom Tanggal SK diisi"
							: isGajiPokok
							? "Mohon Gaji Pokok harap diisi"
								: isEmptyFile
								? "Mohon Dokumen SK KP harap diisi"
									: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>