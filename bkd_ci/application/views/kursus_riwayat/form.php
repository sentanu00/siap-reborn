<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('kursus_riwayat/save/' . $row['diklat_riwayat_id']); ?>" class='form-horizontal'
			parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row hidethis " style="display:none;">
						<label for="Diklat Riwayat Id" class=" control-label col-md-4 text-left"> Diklat Riwayat Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['diklat_riwayat_id']; ?>' name='diklat_riwayat_id' /> <br />
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
						<label for="Kursus Id Siasn" class=" control-label col-md-4 text-left"> Kursus Id Siasn </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kursus_id_siasn']; ?>' name='kursus_id_siasn' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PnsOrangId" class=" control-label col-md-4 text-left"> PnsOrangId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pnsOrangId']; ?>' name='pnsOrangId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Jenis Diklat" class=" control-label col-md-4 text-left"> Jenis Diklat <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='jenisDiklatId' rows='5' id='jenisDiklatId' code='{$jenisDiklatId}'
								class='form-control input-sm select2 ' style='width: 100%;' required>

								<?php if (!empty($row['jenisDiklatNama'])): ?>
									<option value="<?= $row['jenisDiklatId'] ?>" selected>
										<?= $row['jenisDiklatNama'] ?>
									</option>

								<?php endif; ?>

							</select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Jenis Kursus" class=" control-label col-md-4 text-left"> Jenis Kursus <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='jenisKursus' rows='5' id='jenisKursus' code='{$jenisKursus}'
								class='form-control input-sm select2 ' style='width: 100%;' required>

								<?php if (!empty($row['jenisKursus'])): ?>
									<option value="<?= $row['jenisKursus'] ?>" selected>
										<?= $row['jenisKursusNama'] ?>
									</option>
								<?php endif; ?>

							</select> <br />


							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JenisKursusSertipikat" class=" control-label col-md-4 text-left"> JenisKursusSertipikat </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jenisKursusSertipikat']; ?>' name='jenisKursusSertipikat' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TahunKursus" class=" control-label col-md-4 text-left"> Tahun Kursus <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='number' class='form-control input-sm' placeholder='' value='<?php echo $row['tahunKursus']; ?>' name='tahunKursus' required parsley-type='number' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TanggalKursus" class=" control-label col-md-4 text-left"> Tanggal Mulai Kursus <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tanggalKursus']; ?>' name='tanggalKursus'
								style='width:150px !important;' required parsley-type='date' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TanggalSelesaiKursus" class=" control-label col-md-4 text-left"> Tanggal Selesai Kursus <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tanggalSelesaiKursus']; ?>' name='tanggalSelesaiKursus'
								style='width:150px !important;' required parsley-type='date' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="JumlahJam" class=" control-label col-md-4 text-left"> Jumlah Jam <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='number' class='form-control input-sm' placeholder='' value='<?php echo $row['jumlahJam']; ?>' name='jumlahJam' required parsley-type='number' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="RumpunDiklat" class=" control-label col-md-4 text-left"> RumpunDiklat <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='rumpunDiklat' rows='5' id='rumpunDiklat' code='{$rumpunDiklat}'
								class='form-control input-sm select2 ' style='width: 100%;' required>

								<?php if (!empty($row['rumpunDiklatNama'])): ?>
									<option value="<?= $row['rumpunDiklat'] ?>" selected>
										<?= $row['rumpunDiklatNama'] ?>
									</option>

								<?php endif; ?>

							</select> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="NamaKursus" class=" control-label col-md-4 text-left"> Nama Kursus <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<textarea name='namaKursus' rows='2' id='namaKursus' class='form-control input-sm '
								required><?php echo $row['namaKursus']; ?></textarea> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="InstitusiPenyelenggara" class=" control-label col-md-4 text-left"> Institusi Penyelenggara <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['institusiPenyelenggara']; ?>' name='institusiPenyelenggara' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NomorSertipikat" class=" control-label col-md-4 text-left"> Nomor Sertifikat </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nomorSertipikat']; ?>' name='nomorSertipikat' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Instansi" class=" control-label col-md-4 text-left"> Instansi </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['instansi']; ?>' name='instansi' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="InstansiId" class=" control-label col-md-4 text-left"> Instansi <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='instansiId' rows='5' id='instansiId' code='{$instansiId}'
								class='form-control input-sm select2 ' style='width: 100%;' required>

								<?php if (!empty($row['instansi'])): ?>
									<option value="<?= $row['instansi'] ?>" selected>
										<?= $row['instansi'] ?>
									</option>

								<?php endif; ?>

							</select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="LokasiId" class=" control-label col-md-4 text-left"> Lokasi </label>
						<div class="col-md-8">
							<select name='lokasiId' rows='5' id='lokasiId' code='{$lokasiId}'
								class='form-control input-sm select2 ' style='width: 100%;'>

								<?php if (!empty($row['lokasi'])): ?>
									<option value="<?= $row['lokasi'] ?>" selected>
										<?= $row['lokasi'] ?>
									</option>

								<?php endif; ?>
							</select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Lokasi" class=" control-label col-md-4 text-left"> Lokasi </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['lokasi']; ?>' name='lokasi' /> <br />
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
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('kursus_riwayat/viewfile') . '/FILE_PDF/' . $row['diklat_riwayat_id'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
							<!-- batas rubah-------------------------------- -->
							<input type="hidden" name="insert_by" value="<?php echo $row['insert_by']; ?>" />
							<input type="hidden" name="insert_date" value="<?php echo $row['insert_date']; ?>" />


						</div>
						<!-- end file pdf  -->
					</div>
				</div>


			</div>

			<div style="clear:both">
				<hr />
			</div>

			<div class="toolbar-line text-center">
				<?php if ($this->access['is_edit'] == 1 || $this->access['is_add'] == 1) { ?>
					<!-- <input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php //echo $this->lang->line('core.sb_submit'); 
																									?>" /> -->
					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" onclick="return validateForm();" />
				<?php } ?>
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
			alert('Wajib mengisi dokumen (PDF)');
			return false;
		}
		return true;
	}

	function validasiUkuranFilePDF() {
		const input = document.getElementById('FILE_PDF');

		if (input.files.length > 0) {
			const fileSize = input.files[0].size; // dalam byte
			const maxSize = 1 * 1024 * 1024; // 1 MB

			if (fileSize > maxSize) {
				alert('Ukuran file tidak boleh lebih dari 1 MB');
				input.value = ''; // reset file
				return false;
			}
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

	function checkFileSize(inputId, errorSpanId) {
		var input = document.getElementById(inputId);

		if (input.files && input.files[0]) {
			var fileSize = input.files[0].size; // Ukuran file dalam byte
			var maxSize = 2 * 1024 * 1024; // 2 MB dalam byte

			if (fileSize > maxSize) {
				document.getElementById(errorSpanId).style.display = "block";
				input.value = ""; // Mengosongkan input file
			} else {
				document.getElementById(errorSpanId).style.display = "none";
			}
		}
	}
	$(document).ready(function() {
		var frm = $('form');
		// timpa yang lama jadi seperti ini --------------
		$("#kirimdata").click(function() {

			var form_data = new FormData(frm[0]);
			if (!frm.valid()) return false;
			// validasi file DI SINI
			if (!validasiFilePDF()) return false;
			// validasi ukuran file
			if (!validasiUkuranFilePDF()) return false;

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

		$('#jenisDiklatId').select2({
			placeholder: 'Cari Jenis Diklat...',
			minimumInputLength: 2,
			ajax: {
				url: '<?= site_url("kursus_riwayat/autocomplete_jenis_diklat"); ?>',
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


		// $("#jenisKursus").jCombo("<?php //echo site_url('kursus_riwayat/comboselect?filter=jenis_kursus:id_siasn:nama') 
										?>", {
		// 	selected_value: '<?php //echo $row["jenisKursus"] 
								?>'
		// });
		$('#jenisKursus').select2({
			placeholder: 'Cari Jenis Kursus...',
			minimumInputLength: 2,
			ajax: {
				url: '<?= site_url("kursus_riwayat/autocomplete_jenis_kursus"); ?>',
				dataType: 'json',
				delay: 250,
				data: params => ({
					q: params.term
				}),
				processResults: data => ({
					results: data
				})
			}
		});

		// $("#rumpunDiklat").jCombo("<?php //echo site_url('kursus_riwayat/comboselect?filter=rumpun_diklat:rumpun_id_siasn:nama') 
										?>", {
		// 	selected_value: '<?php //echo $row["rumpunDiklat"] 
								?>'
		// });
		$('#rumpunDiklat').select2({
			placeholder: 'Cari Rumpun Diklat...',
			minimumInputLength: 2,
			ajax: {
				url: '<?= site_url("kursus_riwayat/autocomplete_rumpun_diklat"); ?>',
				dataType: 'json',
				delay: 250,
				data: params => ({
					q: params.term
				}),
				processResults: data => ({
					results: data
				})
			}
		});

		// $("#instansiId").jCombo("<?php //echo site_url('kursus_riwayat/comboselect?filter=instansi_siasn:id_siasn:nama') 
									?>", {
		// 	selected_value: '<?php //echo $row["instansiId"] 
								?>'
		// 	// disini instansi di set juga
		// });
		$('#instansiId').select2({
			placeholder: 'Cari Instansi...',
			minimumInputLength: 3,
			ajax: {
				url: '<?= site_url("kursus_riwayat/autocomplete_instansi"); ?>',
				dataType: 'json',
				delay: 250,
				data: params => ({
					q: params.term
				}),
				processResults: data => ({
					results: data
				})
			}
		});

		// $("#lokasiId").jCombo("<?php //echo site_url('kursus_riwayat/comboselect?filter=lokasi_siasn:id_siasn:nama|jenis_kabupaten') 
									?>", {
		// 	selected_value: '<?php //echo $row["lokasiId"] 
								?>'
		// 	// disini lokasi di set juga
		// });
		$('#lokasiId').select2({
			placeholder: 'Cari Lokasi...',
			minimumInputLength: 3,
			ajax: {
				url: '<?= site_url("kursus_riwayat/autocomplete_lokasi"); ?>',
				dataType: 'json',
				delay: 250,
				data: params => ({
					q: params.term
				}),
				processResults: data => ({
					results: data
				})
			}
		});



		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});
</script>