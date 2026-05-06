<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('diklatstruktural/save/' . $row['DIKLAT_STRUKTURAL_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> DIKLAT STRUKTURAL ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DIKLAT_STRUKTURAL_ID']; ?>' name='DIKLAT_STRUKTURAL_ID'/>
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> DIKLAT <span class="asterix"> * </span> </label>
						<select name='DIKLAT_ID' rows='5' id='DIKLAT_ID' code='{$DIKLAT_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT']; ?>' name='TEMPAT' id='TEMPAT' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO STTPP <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['NO_STTPP']; ?>' name='NO_STTPP' id='NO_STTPP' />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PENYELENGGARA <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENYELENGGARA']; ?>' name='PENYELENGGARA' id='PENYELENGGARA' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> ANGKATAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ANGKATAN']; ?>' name='ANGKATAN' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL STTPP <span class="asterix">*</span></label>

						<input type='date' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['TANGGAL_STTPP']; ?>' name='TANGGAL_STTPP' id='TANGGAL_STTP' style='width:150px !important;' required />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL MULAI <span class="asterix">*</span></label>

						<input type='date' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['TANGGAL_MULAI']; ?>' name='TANGGAL_MULAI' id='TANGGAL_MULAI' required style='width:150px !important;' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL SELESAI <span class="asterix">*</span></label>

						<input type='date' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['TANGGAL_SELESAI']; ?>' name='TANGGAL_SELESAI' id='TANGGAL_SELESAI' required style='width:150px !important;' />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TAHUN <span class="asterix">*</span></label>
							<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['TAHUN']; ?>' name='TAHUN' id='TAHUN' />
						</div>
						<div class="form-group  col-md-6 ">
							<label for="ipt" class=" control-label "> JUMLAH JAM </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JUMLAH_JAM']; ?>' name='JUMLAH_JAM' />
						</div>
						<div class="form-group  col-md-12 ">
							<label for="ipt" class=" control-label "> DOK SERTIFIKAT DIKLAT <span class="asterix">*</span></label>
							<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF"  accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('diklatstruktural/viewfile') . '/FILE_PDF/' . $row['DIKLAT_STRUKTURAL_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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


		$("#DIKLAT_ID").jCombo("<?php echo site_url('diklatstruktural/comboselect?filter=diklat:DIKLAT_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["DIKLAT_ID"] ?>'
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
    var DIKLAT_ID = document.getElementById("DIKLAT_ID");
    var TEMPAT = document.getElementById("TEMPAT");
	var NO_STTPP = document.getElementById("NO_STTPP");
	var PENYELENGGARA = document.getElementById("PENYELENGGARA");
	var TANGGAL_STTP = document.getElementById("TANGGAL_STTP");
	var TANGGAL_MULAI = document.getElementById("TANGGAL_MULAI");
	var TANGGAL_SELESAI = document.getElementById("TANGGAL_SELESAI");
	var TAHUN = document.getElementById("TAHUN");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyDiklat = DIKLAT_ID && DIKLAT_ID.value === "";
    var isEmptyTempat = TEMPAT && TEMPAT.value === "";
	var isEmptyNoSTTP = NO_STTPP && NO_STTPP.value === "";
	var isEmptyPenyelenggara = PENYELENGGARA && PENYELENGGARA.value === "";
	var isEmptyTglSTTP = TANGGAL_STTP && TANGGAL_STTP.value === "";
	var isEmptyTglmulai= TANGGAL_MULAI && TANGGAL_MULAI.value === "";
	var isEmptyTglselesai= TANGGAL_SELESAI && TANGGAL_SELESAI.value === "";
	var isEmptyTahun = TAHUN && TAHUN.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyDiklat && isEmptyTempat && isEmptyNoSTTP && isEmptyPenyelenggara && isEmptyTglSTTP && isEmptyTglmulai && isEmptyTglselesai && isEmptyTahun && isEmptyFile
    ? "Mohon kolom Diklat, Tempat, No STTP, Penyelenggara, Tanggal STTP, Tanggal Mulai, Tanggal Selesai, Tahun dan Dokumen SK Sertifikat Diklat harap diisi."
        : isEmptyDiklat
        ? "Mohon kolom Diklat diisi."
            : isEmptyTempat
            ? "Mohon kolom Tempat diisi."
				: isEmptyNoSTTP
				? "Mohon kolom No STTP diisi"
					: isEmptyPenyelenggara
					? "Mohon kolom Penyelenggara diisi"
						: isEmptyTglSTTP
						? "Mohon kolom Tanggal STTP diisi"
							: isEmptyTglmulai
							? "Mohon kolom Tanggal Mulai diisi"
								: isEmptyTglselesai
								? "Mohon kolom Tanggal Selesai diisi"
									: isEmptyTahun
									? "Mohon kolom Tahun diisi"
										: isEmptyFile
										? "Mohon Dokumen Sertifikat Diklat harap diisi"
											: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>