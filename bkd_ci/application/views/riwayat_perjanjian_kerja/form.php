<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('riwayat_perjanjian_kerja/save/' . $row['id']); ?>" class='form-horizontal'
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
					<div class="form-group row  ">
						<label for="No PK" class=" control-label col-md-4 text-left"> No PK <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['no_pk']; ?>' name='no_pk' required /> <br />
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
					<!-- <div class="form-group row  ">
						<label for="Penanda Tangan" class=" control-label col-md-4 text-left"> Penanda Tangan <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['penanda_tangan']; 
																									?>' name='penanda_tangan' required /> <br />
							<i> <small></small></i>
						</div>
					</div> -->
					<div class="form-group row hidethis " style="display:none;">
						<label for="Nama" class=" control-label col-md-4 text-left"> Nama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nama']; ?>' name='nama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<!-- <div class="form-group row  ">
						<label for="Jenis Jabatan" class=" control-label col-md-4 text-left"> Jenis Jabatan <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<?php //$jenis_jabatan = explode(',', $row['jenis_jabatan']);
							//$jenis_jabatan_opt = array('2' => 'Pelaksana',  '4' => 'Fungsional',); 
							?>
							<select name='jenis_jabatan' rows='5' required class='form-control input-sm select2' style='width: 100%;'>
								<?php
								//foreach ($jenis_jabatan_opt as $key => $val) {
								//echo "<option  value ='$key' " . ($row['jenis_jabatan'] == $key ? " selected='selected' " : '') . ">$val</option>";}
								?></select> <br />
							<i> <small></small></i>
						</div>
					</div> -->
					<div class="form-group row  ">
						<label for="Jabatan" class=" control-label col-md-4 text-left"> Jabatan <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jabatan']; ?>' name='jabatan' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Jabatan Id" class=" control-label col-md-4 text-left"> Jabatan Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jabatan_id']; ?>' name='jabatan_id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Satker Id" class=" control-label col-md-4 text-left"> Satker Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['satker_id']; ?>' name='satker_id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Unor Id" class=" control-label col-md-4 text-left"> Unor Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['unor_id']; ?>' name='unor_id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<?php
					$unor_nama = $row['unor_nama'] ?? '';
					?>

					<div class="form-group row">
						<label class="control-label col-md-4 text-left">
							Unor Nama <span class="asterix">*</span>
						</label>

						<div class="col-md-8">
							<select id="unor_nama"
								name="unor_nama"
								class="form-control input-sm select2"
								required
								style="width:100%;">

								<?php if ($unor_nama != ''): ?>
									<option value="<?= htmlspecialchars($unor_nama) ?>" selected>
										<?= htmlspecialchars($unor_nama) ?>
									</option>
								<?php endif; ?>

							</select>
						</div>
					</div>
					<script>
						$('#unor_nama').select2({
							placeholder: 'Cari Unit Organisasi...',
							minimumInputLength: 3,
							ajax: {
								url: '<?= site_url('riwayat_perjanjian_kerja/search_satker') ?>',
								dataType: 'json',
								delay: 250,
								data: function(params) {
									return {
										q: params.term
									};
								},
								processResults: function(data) {
									return {
										results: data
									};
								},
								cache: true
							}
						});
					</script>
					<div class="form-group row">
						<label class="control-label col-md-4 text-left">
							Masa Kerja <span class="asterix">*</span>
						</label>

						<?php
						$masa_kerja_tahun = $row['masa_kerja_tahun'] ?? '';
						$masa_kerja_bulan = $row['masa_kerja_bulan'] ?? '';
						?>

						<div class="col-md-8">
							<div class="row">
								<!-- Tahun -->
								<div class="col-md-6">
									<input
										type="text"
										name="masa_kerja_tahun"
										class="form-control input-sm"
										placeholder="Tahun"
										value="<?= htmlspecialchars($masa_kerja_tahun) ?>"
										required
										maxlength="2"
										pattern="[0-9]{2}"
										inputmode="numeric"
										title="Tahun (2 digit angka)">
								</div>

								<!-- Bulan -->
								<div class="col-md-6">
									<input
										type="text"
										name="masa_kerja_bulan"
										class="form-control input-sm"
										placeholder="Bulan"
										value="<?= htmlspecialchars($masa_kerja_bulan) ?>"
										required
										maxlength="2"
										pattern="[0-9]{2}"
										inputmode="numeric"
										title="Bulan (2 digit angka)">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="File Pk" class=" control-label col-md-4 text-left"> File Pk </label>
						<div class="col-md-8">
							<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['file_pk']; 
																										?>' name='file_pk' /> <br />
							<i> <small></small></i> -->
							<!-- rubah agar bisa terimafile pdf--------------- -->
							<input
								type="file"
								class="form-control input-sm"
								id="file_pk"
								name="file_pk"
								accept="application/pdf">

							<input
								type="hidden"
								id="file_pk_cek"
								name="file_pk_cek"
								value="<?php echo $row['file_pk']; ?>">
							<?
							if ($row['file_pk'] != '') { //--------------------------------rubah di bawah ini---------------------------dan "id" ini juga --------------------------
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('riwayat_perjanjian_kerja/viewfile') . '/file_pk/' . $row['id'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
							<!-- batas rubah-------------------------------- -->
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
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
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group row  ">
						<label for="No Sk" class=" control-label col-md-4 text-left"> No SK <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['no_sk']; ?>' name='no_sk' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Tanggal Awal Kontrak" class=" control-label col-md-4 text-left"> Tanggal SK <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tanggal_sk']; ?>' name='tanggal_sk'
								style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-4 text-left">
							Gaji <span class="asterix">*</span>
						</label>

						<?php
						$gaji = $row['gaji'] ?? '';
						?>

						<div class="col-md-8">
							<div class="row">
								<!-- Tahun -->
								<div class="col-md-6">
									<input
										type="text"
										name="gaji"
										class="form-control input-sm"
										placeholder="Gaji"
										value="<?= htmlspecialchars($gaji) ?>"
										required
										maxlength="7"
										pattern="[0-9]{1,7}"
										inputmode="numeric"
										title="Gaji (7 digit angka)">
								</div>


							</div>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Tanggal Awal Kontrak" class=" control-label col-md-4 text-left"> Terhitung mulai tanggal <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tanggal_awal_kontrak']; ?>' name='tanggal_awal_kontrak'
								style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="Tanggal Akhir Kontrak" class=" control-label col-md-4 text-left"> Sampai dengan tanggal <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tanggal_akhir_kontrak']; ?>' name='tanggal_akhir_kontrak'
								style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="File Sk" class=" control-label col-md-4 text-left"> File Sk </label>
						<div class="col-md-8">
							<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['file_sk']; 
																										?>' name='file_sk' /> <br />
							<i> <small></small></i> -->
							<!-- rubah agar bisa terimafile pdf--------------- -->
							<input
								type="file"
								class="form-control input-sm"
								id="file_sk"
								name="file_sk"
								accept="application/pdf">

							<input
								type="hidden"
								id="file_sk_cek"
								name="file_sk_cek"
								value="<?php echo $row['file_sk']; ?>">
							<?
							if ($row['file_sk'] != '') { //--------------------------------rubah di bawah ini---------------------------dan "id" ini juga --------------------------
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('riwayat_perjanjian_kerja/viewfile') . '/file_sk/' . $row['id'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
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
		const fileBaru = document.getElementById('file_pk').files.length;
		const fileLama = document.getElementById('file_pk_cek').value;
		const fileBaru2 = document.getElementById('file_sk').files.length;
		const fileLama2 = document.getElementById('file_sk_cek').value;

		if (fileBaru === 0 && fileLama === '') {
			alert('Wajib mengisi dokumen perjanjian kerja (PDF)');
			return false;
		}
		if (fileBaru2 === 0 && fileLama2 === '') {
			alert('Wajib mengisi dokumen SK (PDF)');
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
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});
</script>