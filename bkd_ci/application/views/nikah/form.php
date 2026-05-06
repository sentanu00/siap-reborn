<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('nikah/save/' . $row['NIKAH_RIWAYAT_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> NIKAH RIWAYAT ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NIKAH_RIWAYAT_ID']; ?>' name='NIKAH_RIWAYAT_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK PENGADILAN <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK_PENGADILAN']; ?>' name='NO_SK_PENGADILAN' id='NO_SK_PENGADILAN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL SK PENGADILAN <span class="asterix"> * </span> </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK_PENGADILAN']; ?>' name='TANGGAL_SK_PENGADILAN' id='TANGGAL_SK_PENGADILAN' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TMT SK <span class="asterix"> * </span> </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_SK']; ?>' name='TMT_SK' id='TMT_SK' required />
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA SUAMI/ISTRI <span class="asterix"> * </span> </label>
						<select name='SUAMI_ISTRI_ID' rows='5' id='SUAMI_ISTRI_ID' code='{$SUAMI_ISTRI_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> UPLOAD FILE <span class="asterix"> * </span></label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF">
						<input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" />

						<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('nikah/viewfile') . '/FILE_PDF/' . $row['NIKAH_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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
		$("#kirimdata").click(function(){
			
				var form_data = new FormData(frm[0]);
				// var files = $('#FILE_PDF')[0].files;
				// form_data.append('FILE_PDF',files[0]);
			
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


		$("#SUAMI_ISTRI_ID").jCombo("<?php echo site_url('nikah/comboselect?filter=suami_istri:SUAMI_ISTRI_ID:NAMA') ?>:PEGAWAI_ID:<?php echo $PEGAWAI_ID; ?>", {
			selected_value: '<?php echo $row["SUAMI_ISTRI_ID"] ?>'
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
    var NO_SK_PENGADILAN = document.getElementById("NO_SK_PENGADILAN");
	var TANGGAL_SK_PENGADILAN = document.getElementById("TANGGAL_SK_PENGADILAN");
	var TMT_SK = document.getElementById("TMT_SK");
	var SUAMI_ISTRI_ID = document.getElementById("SUAMI_ISTRI_ID");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyNoSK = NO_SK_PENGADILAN && NO_SK_PENGADILAN.value === "";
	var isEmptyTglSK= TANGGAL_SK_PENGADILAN && TANGGAL_SK_PENGADILAN.value === "";
	var isEmptyTMTSK= TMT_SK && TMT_SK.value === "";
	var isEmptyPasangan= SUAMI_ISTRI_ID && SUAMI_ISTRI_ID.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyNoSK && isEmptyTglSK && isEmptyTMTSK && isEmptyPasangan && isEmptyFile
    ? "Mohon semua kolom harap diisi."
        : isEmptyNoSK
        ? "Mohon kolom No SK diisi."
			: isEmptyTglSK
			? "Mohon kolom Tanggal SK diisi."
				: isEmptyTMTSK
				? "Mohon kolom TMT SK diisi."
					: isEmptyPasangan
					? "Mohon kolom Nama Suami/Istri diisi."
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