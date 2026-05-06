<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('tim_kerja/save/' . $row['id']); ?>" class='form-horizontal'
			parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row hidethis " style="display:none;">
						<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id']; ?>' name='id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Nip" class=" control-label col-md-4 text-left"> Nip </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nip']; ?>' name='nip' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Nama Tim" class=" control-label col-md-4 text-left"> Nama Tim <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nama_tim_kerja']; ?>' name='nama_tim_kerja' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="No SK" class=" control-label col-md-4 text-left"> No SK <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['noSk']; ?>' name='noSk' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Jenis SK" class=" control-label col-md-4 text-left"> Jenis SK <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<?php $lingkup_tim = explode(',', $row['lingkup_tim']);
							$lingkup_tim_opt = array('LINTAS_INSTANSI' => 'LINTAS INSTANSI',  'INTERNAL_INSTANSI' => 'INTERNAL INSTANSI',); ?>
							<select name='lingkup_tim' rows='5' required class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($lingkup_tim_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['lingkup_tim'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Peran dalam Tim" class=" control-label col-md-4 text-left"> Peran dalam Tim <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<?php $kedudukan = explode(',', $row['kedudukan']);
							$kedudukan_opt = array('Pembina / Pengarah / Penanggung Jawab' => 'PEMBINA / PENGARAH / PENANGGUNG JAWAB',  'Ketua / Wakil Ketua' => 'KETUA / WAKIL KETUA',  'Sekretaris / Bendahara / Koordinator' => 'SEKRETARIS / BENDAHARA / KOORDINATOR',  'Anggota' => 'ANGGOTA',); ?>
							<select name='kedudukan' rows='5' required class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($kedudukan_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['kedudukan'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<!-- <div class="form-group row hidethis " style="display:none;">
						<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['created_at']; ?>' name='created_at' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['updated_at']; ?>' name='updated_at' /> <br />
							<i> <small></small></i>
						</div>
					</div> -->
				</div>

				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="Tgl SK" class=" control-label col-md-4 text-left"> Tgl SK <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tglSk']; ?>' name='tglSk'
								style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="FILE PDF" class=" control-label col-md-4 text-left"> Dokumen (PDF) </label>
						<div class="col-md-8">
							<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['FILE_PDF']; 
																										?>' name='FILE_PDF' /> <br />
							<i> <small></small></i> -->

							<!-- rubah agar bisa terimafile pdf--------------- -->
							<input
								type="file"
								class="form-control input-sm"
								id="FILE_PDF"
								name="FILE_PDF"
								accept="application/pdf">

							<input
								type="hidden"
								id="file_pdf_cek"
								name="file_pdf_cek"
								value="<?php echo $row['FILE_PDF']; ?>">
							<?
							if ($row['FILE_PDF'] != '') { //--------------------------------rubah di bawah ini---------------------------dan "id" ini juga --------------------------
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('tim_kerja/viewfile') . '/FILE_PDF/' . $row['id'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
							<!-- batas rubah-------------------------------- -->
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
					<!-- <input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php //echo $this->lang->line('core.sb_submit'); 
																									?>" /> -->


					<!-- rubah agar bisa terima file pdf -->
					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" onclick="return validateForm();" />
					<!-- batas rubah -->
				<?
				}
				?>
				<a href="javascript:cancelform()" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a>
			</div>

		</form>

	</div>
</div>
</section>

<!-- tambahan fungsi pengecekan file ------------------------------- -->
<script>
	function validasiFilePDF() {
		const fileBaru = document.getElementById('FILE_PDF').files.length;
		const fileLama = document.getElementById('file_pdf_cek').value;

		if (fileBaru === 0 && fileLama === '') {
			alert('Wajib mengisi dokumen pendukung (PDF)');
			return false;
		}
		return true;
	}
</script>
<!-- batas tambahan fungsi pengecekan file ---------------------------- -->


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
		// timpa yang lama jadi seperti ini --------------
		$("#kirimdata").click(function() {

			var form_data = new FormData(frm[0]);
			if (!frm.valid()) return false;
			// validasi file DI SINI
			if (!validasiFilePDF()) return false;

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
		// batas timpa yang lama -------------




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?> $('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});
</script>