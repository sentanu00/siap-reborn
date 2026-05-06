<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('hukuman/save/' . $row['HUKUMAN_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> HUKUMAN ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['HUKUMAN_ID']; ?>' name='HUKUMAN_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TINGKAT HUKUMAN </label>

							<?php $TINGKAT_HUKUMAN_ID = explode(',', $row['TINGKAT_HUKUMAN_ID']);
							$TINGKAT_HUKUMAN_ID_opt = array('' => '-- PILIH --', '1' => 'Ringan',  '2' => 'Sedang',  '3' => 'Berat',  '4' => 'Bukan Sanksi',); ?>
							<select name='TINGKAT_HUKUMAN_ID' id='TINGKAT_HUKUMAN_ID' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($TINGKAT_HUKUMAN_ID_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['TINGKAT_HUKUMAN_ID'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select>
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> BERLAKU </label>
							<?php $BERLAKU = explode(",", $row['BERLAKU']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='BERLAKU[]' value='1' class='' <?php if (in_array('1', $BERLAKU)) echo 'checked'; ?> /> Masih Berlaku </label>
						</div>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JENIS HUKUMAN <span class="asterix"> * </span> </label>
						<select name='JENIS_HUKUMAN_ID' rows='5' id='JENIS_HUKUMAN_ID' code='{$JENIS_HUKUMAN_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KETERANGAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN']; ?>' name='KETERANGAN' />
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP <span class="asterix"> * </span> </label>
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK <span class="asterix"> * </span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' id='NO_SK' />
					</div>
					<div class="row">
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TANGGAL SK <span class="asterix"> * </span></label>

							<input type='date' class='form-control input-sm date' required placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' id='TANGGAL_SK' style='width:150px !important;' />
						</div>
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> TMT SK <span class="asterix"> * </span></label>

							<input type='date' class='form-control input-sm date' required placeholder='' value='<?php echo $row['TMT_SK']; ?>' name='TMT_SK' id='TMT_SK' style='width:150px !important;' />
						</div>
						<div class="form-group  col-md-6 ">
							<label for="ipt" class=" control-label "> LAMPIRAN SK <span class="asterix"> * </span></label>
							<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('hukuman/viewfile') . '/FILE_PDF/' . $row['HUKUMAN_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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
		$('.select2').select2();
		
		
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


		$("#JENIS_HUKUMAN_ID").jCombo("<?php echo site_url('hukuman/comboselect?filter=jenis_hukuman:JENIS_HUKUMAN_ID:NAMA') ?>:TINGKAT_HUKUMAN_ID:", {
			parent: '#TINGKAT_HUKUMAN_ID',
			selected_value: '<?php echo $row["JENIS_HUKUMAN_ID"] ?>'
		});

		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('hukuman/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});



		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>
		
		$('#TINGKAT_HUKUMAN_ID').val("<?=$row['TINGKAT_HUKUMAN_ID'];?>").trigger('change');

	});

	function validateForm() {
    var JENIS_HUKUMAN_ID = document.getElementById("JENIS_HUKUMAN_ID");
	var PEJABAT_PENETAP_ID = document.getElementById("PEJABAT_PENETAP_ID");
	var NO_SK = document.getElementById("NO_SK");
	var TANGGAL_SK = document.getElementById("TANGGAL_SK");
	var TMT_SK = document.getElementById("TMT_SK");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyJenisHukdis = JENIS_HUKUMAN_ID && JENIS_HUKUMAN_ID.value === "";
	var isEmptyPejabat= PEJABAT_PENETAP_ID && PEJABAT_PENETAP_ID.value === "";
	var isEmptyNoSK= NO_SK && NO_SK.value === "";
	var isEmptyTglSK= TANGGAL_SK && TANGGAL_SK.value === "";
	var isEmptyTMTSK= TMT_SK && TMT_SK.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyJenisHukdis && isEmptyPejabat && isEmptyNoSK && isEmptyTglSK && isEmptyTMTSK && isEmptyFile
    ? "Mohon kolom Jenis Hukuman, Pejabat Penetap, No SK, Tanggal SK, TMT SK, dan Akta Lampiran SK harap diisi."
        : isEmptyJenisHukdis
        ? "Mohon kolom Jenis Hukuman diisi."
			: isEmptyPejabat
			? "Mohon kolom Pejabat diisi."
				: isEmptyNoSK
				? "Mohon kolom No SK diisi."
					: isEmptyTglSK
					? "Mohon kolom Tanggal SK diisi."
						: isEmptyTMTSK
						? "Mohon kolom TMT SK diisi."
							: isEmptyFile
							? "Mohon Akta Lampiran SK harap diisi"
								: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>