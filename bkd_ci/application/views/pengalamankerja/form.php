<div class="row">
	<div class="col-md-12">


		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('pengalamankerja/save/' . $row['PENGALAMAN_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PENGALAMAN ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENGALAMAN_ID']; ?>' name='PENGALAMAN_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JABATAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN']; ?>' name='JABATAN' />
					</div>
				</div>
				<div class="col-md-3">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL KERJA </label>
						<input type='date' class='form-control input-sm ' placeholder='' value='<?php echo $row['TANGGAL_KERJA']; ?>' name='TANGGAL_KERJA' />
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> MASA KERJA THN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA_TAHUN']; ?>' name='MASA_KERJA_TAHUN' />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> MASA KERJA BLN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA_BULAN']; ?>' name='MASA_KERJA_BULAN' />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> UPLOAD FILE </label>
							<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF">
						</div>
					</div>
				</div>




			</div>

			<div style="clear:both">
				<hr />
			</div>

			<div class="toolbar-line text-center">

				<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
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

		var frm = $('form');
		$("#kirimdata").click(function() {

			var form_data = new FormData(frm[0]);
			var files = $('#FILE_PDF')[0].files;
			form_data.append('FILE_PDF', files[0]);

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

	});
</script>