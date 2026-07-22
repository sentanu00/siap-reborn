<div class="row">
	<div class="col-md-12">

		<?php echo $this->session->flashdata("message"); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata("errors"); ?>
		</ul>
		<form action="<?php echo site_url(
							"pltplh/save/" . $row["JABATAN_RIWAYAT_ID"]
						); ?>" class='form-horizontal'
			parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="Jenis Jabatan" class=" control-label col-md-4 text-left"> Jenis Jabatan <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='jenisJabatan' rows='5' id='jenisJabatan' code='{$jenisJabatan}'
								class='form-control input-sm select2 ' style='width: 100%;' required>
								<?php
								$jenisJabatanLabel = [
									"1" => "Jabatan Struktural",
									"2" => "Jabatan Fungsional",
									"4" => "Jabatan Pelaksana",
								];

								if (!empty($row["jenisJabatan"])): ?>
									<option value="<?= $row["jenisJabatan"] ?>" selected>
										<?= $jenisJabatanLabel[$row["jenisJabatan"]] ?? "-" ?>
									</option>

								<?php endif;
								?>
							</select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TMT Jabatan" class=" control-label col-md-4 text-left"> TMT Jabatan <span class="asterix"> *</label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row["tmtJabatan"]; ?>' name='tmtJabatan'
								style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Instansi Induk" class=" control-label col-md-4 text-left"> Instansi Induk </label>
						<div class="col-md-8">

							<?php
							$instansiKerjaId = explode(",", $row["instansiKerjaId"]);
							$instansiKerjaId_opt = ["1" => "Pemerintah Kab. Probolinggo"];
							?>
							<select name='instansiKerjaId' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php foreach ($instansiKerjaId_opt as $key => $val) {
									echo "<option  value ='$key' " .
										($row["instansiKerjaId"] == $key ? " selected='selected' " : "") .
										">$val</option>";
								} ?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="namaUnor" class=" control-label col-md-4 text-left"> Unit Organisasi <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='namaUnor' rows='5' id='SATKER_ID' code='{$SATKER_ID}'
								class='form-control input-sm select2 ' style='width: 100%;' required>

								<?php if (!empty($row["SATKER_ID"])): ?>
									<option value="<?= $row["SATKER_ID"] ?>" selected>
										<?= $row["namaUnor"] ?>
									</option>

								<?php endif; ?>

							</select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TMT Pelantikan" class=" control-label col-md-4 text-left"> TMT Pelantikan </label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row["tmtPelantikan"]; ?>' name='tmtPelantikan'
								style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Satuan Kerja Induk" class=" control-label col-md-4 text-left"> Satuan Kerja Induk </label>
						<div class="col-md-8">

							<?php
							$unorIndukNama = explode(",", $row["unorIndukNama"]);
							$unorIndukNama_opt = ["1" => "Pemerintah Kab. Probolinggo"];
							?>
							<select name='unorIndukNama' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php foreach ($unorIndukNama_opt as $key => $val) {
									echo "<option  value ='$key' " .
										($row["unorIndukNama"] == $key ? " selected='selected' " : "") .
										">$val</option>";
								} ?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Nomor SK Jabatan" class=" control-label col-md-4 text-left"> Nomor SK Jabatan <span class="asterix"> *</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["nomorSk"]; ?>' name='nomorSk' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="namaJabatan" class=" control-label col-md-4 text-left"> Nama Jabatan<br> (terisi otomatis) </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["namaJabatan"]; ?>' name='namaJabatan' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="eselon" class=" control-label col-md-4 text-left"> Eselon<br>(terisi otomatis)</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php if (
																										!empty($row["eselon"])
																									):
																										echo $row["eselon"];
																									else:
																										$mapEselon = [
																											11 => "I.a",
																											12 => "I.b",
																											21 => "II.a",
																											22 => "II.b",
																											31 => "III.a",
																											32 => "III.b",
																											41 => "IV.a",
																											42 => "IV.b",
																										];

																										echo $mapEselon[$row["eselonId"]] ?? "-";
																									endif;
																									//echo $row['ESELON'];
																									?>' name='eselon' required /> <br />
							<i> <small></small></i>

						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="EselonId" class=" control-label col-md-4 text-left"> EselonId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["eselonId"]; ?>' name='eselonId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JABATAN RIWAYAT ID" class=" control-label col-md-4 text-left"> JABATAN RIWAYAT ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["JABATAN_RIWAYAT_ID"]; ?>' name='JABATAN_RIWAYAT_ID' /> <br />
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
						<label for="Siasnid" class=" control-label col-md-4 text-left"> Siasnid </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["siasnid"]; ?>' name='siasnid' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="IdPns" class=" control-label col-md-4 text-left"> IdPns </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["idPns"]; ?>' name='idPns' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JabatanFungsionalId" class=" control-label col-md-4 text-left"> JabatanFungsionalId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["jabatanFungsionalId"]; ?>' name='jabatanFungsionalId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JabatanFungsionalNama" class=" control-label col-md-4 text-left"> JabatanFungsionalNama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["jabatanFungsionalNama"]; ?>' name='jabatanFungsionalNama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JabatanFungsionalUmumId" class=" control-label col-md-4 text-left"> JabatanFungsionalUmumId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["jabatanFungsionalUmumId"]; ?>' name='jabatanFungsionalUmumId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JabatanFungsionalUmumNama" class=" control-label col-md-4 text-left"> JabatanFungsionalUmumNama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["jabatanFungsionalUmumNama"]; ?>' name='jabatanFungsionalUmumNama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JenisMutasiId" class=" control-label col-md-4 text-left"> JenisMutasiId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["jenisMutasiId"]; ?>' name='jenisMutasiId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="NipBaru" class=" control-label col-md-4 text-left"> NipBaru </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["nipBaru"]; ?>' name='nipBaru' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="NipLama" class=" control-label col-md-4 text-left"> NipLama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["nipLama"]; ?>' name='nipLama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="SubJabatanId" class=" control-label col-md-4 text-left"> SubJabatanId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["subJabatanId"]; ?>' name='subJabatanId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="TmtMutasi" class=" control-label col-md-4 text-left"> TmtMutasi </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["tmtMutasi"]; ?>' name='tmtMutasi' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="UnorIndukId" class=" control-label col-md-4 text-left"> UnorIndukId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["unorIndukId"]; ?>' name='unorIndukId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<!-- <div class="form-group row hidethis " style="display:none;">
									<label for="UnorNama" class=" control-label col-md-4 text-left"> UnorNama </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["unorNama"]; ?>' name='unorNama'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div>  -->
				</div>

				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="Jenis Penugasan" class=" control-label col-md-4 text-left"> Jenis Penugasan </label>
						<div class="col-md-8">

							<?php
							$jenisPenugasanId = explode(",", $row["jenisPenugasanId"]);
							$jenisPenugasanId_opt = [
								"1" => "Pejabat Non Definitif (PJ)",
								"2" => "Pelaksana Harian (PLH)",
								"3" => "Pelaksana Tugas (PLT)",
							];
							?>
							<select name='jenisPenugasanId' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php foreach ($jenisPenugasanId_opt as $key => $val) {
									echo "<option  value ='$key' " .
										($row["jenisPenugasanId"] == $key
											? " selected='selected' "
											: "") .
										">$val</option>";
								} ?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Jenis Riwayat" class=" control-label col-md-4 text-left"> Jenis Riwayat <span class="asterix"> *</label>
						<div class="col-md-8">

							<label class='radio radio-inline'>
								<input type='radio' name='jenisRiwayat' value='1' <?php if (
																						$row["jenisRiwayat"] == "1"
																					) {
																						echo 'checked="checked"';
																					} ?>> Riwayat Aktif </label>
							<label class='radio radio-inline'>
								<input type='radio' name='jenisRiwayat' value='2' <?php if (
																						$row["jenisRiwayat"] == "2"
																					) {
																						echo 'checked="checked"';
																					} ?>> Riwayat Lama </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Instansi Kerja" class=" control-label col-md-4 text-left"> Instansi Kerja </label>
						<div class="col-md-8">

							<?php
							$satuanKerjaId = explode(",", $row["satuanKerjaId"]);
							$satuanKerjaId_opt = ["A5EB03E24222F6A0E040640A040252AD" => "Pemerintah Kab. Probolinggo"];
							?>
							<select name='satuanKerjaId' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php foreach ($satuanKerjaId_opt as $key => $val) {
									echo "<option  value ='$key' " .
										($row["satuanKerjaId"] == $key ? " selected='selected' " : "") .
										">$val</option>";
								} ?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="disable;">
						<label for="Unor ID" class=" control-label col-md-4 text-left"> Unor ID </label>
						<div class="col-md-8">
							<input readonly type='text' class='form-control input-sm' placeholder='' value='<?php echo $row["unorId"]; ?>' name='unorId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Satuan Kerja Kerja" class=" control-label col-md-4 text-left"> Satuan Kerja Kerja </label>
						<div class="col-md-8">

							<?php
							$satuanKerjaNama = explode(",", $row["satuanKerjaNama"]);
							$satuanKerjaNama_opt = ["A5EB03E24222F6A0E040640A040252AD" => "Pemerintah Kab. Probolinggo"];
							?>
							<select name='satuanKerjaNama' rows='5' class='form-control input-sm select2' style='width: 100%;'>
								<?php foreach ($satuanKerjaNama_opt as $key => $val) {
									echo "<option  value ='$key' " .
										($row["satuanKerjaNama"] == $key ? " selected='selected' " : "") .
										">$val</option>";
								} ?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Tanggal SK Jabatan" class=" control-label col-md-4 text-left"> Tanggal SK Jabatan <span class="asterix"> *</label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row["tanggalSk"]; ?>' name='tanggalSk'
								style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="FILE PDF 1 MB" class=" control-label col-md-4 text-left"> Dokumen PDF 1 MB <span class="asterix"> *</label>
						<div class="col-md-8">
							<input type='file' class="form-control input-sm" name='FILE_PDF' id='FILE_PDF' accept="application/pdf">
							<input type="hidden" id="file_pdf_cek" name="file_pdf_cek" value="<?php echo $row["FILE_PDF"]; ?>"><?
																																if ($row["FILE_PDF"] != '') {
																																	echo '<br /><a href="javascript:SximoModal(\'' . site_url('pltplh/viewfile') . '/FILE_PDF/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000) "class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '"style="width:20px"> Preview File</a>';
																																} ?>
						</div>
					</div>
				</div>


			</div>

			<div style="clear:both">
				<hr />
			</div>

			<div class="toolbar-line text-center">
				<?php if ($this->access["is_edit"] == 1 || $this->access["is_add"] == 1) { ?>
					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line(
																									"core.sb_submit"
																								); ?>" />
				<?php } ?>
				<a href="javascript:cancelform()" class="btn btn-sm btn-warning"><?php echo $this->lang->line(
																						"core.sb_cancel"
																					); ?> </a>
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

	$(document).ready(function() {

		var frm = $('form');
		$("#kirimdata").click(function() {
			var form_data = new FormData(frm[0]);
			if (!frm.parsley().validate()) return false;
			if (!validasiFilePDF()) return false;
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

		function hideAndDisable(wrapper, resetValue = true) {
			wrapper.hide();
			wrapper.find('input, select').each(function() {
				$(this).prop('required', false);

				if (resetValue) {
					$(this).val(null).trigger('change');
				}
			});
		}

		function showAndRequire(wrapper) {
			wrapper.show();
			wrapper.find('input, select').each(function() {
				$(this).prop('required', true);
			});
		}

		function toggleJabatan(resetValue = true) {
			let jenis = $('#jenisJabatan').val();

			let jft = $('.jft-wrapper');
			let jfu = $('.jfu-wrapper');
			let jst = $('.jst-wrapper');

			hideAndDisable(jft, resetValue);
			hideAndDisable(jfu, resetValue);
			hideAndDisable(jst, resetValue);

			if (jenis === '2') {
				showAndRequire(jft);
			} else if (jenis === '4') {
				showAndRequire(jfu);
			} else if (jenis === '1') {
				showAndRequire(jst);
			}
		}

		// pertama kali load (edit mode)
		toggleJabatan(false);

		$('#jenisJabatan').select2({
			placeholder: 'Pilih jenis jabatan',
			allowClear: true,
			minimumInputLength: 0, // 🔥 ini kuncinya
			ajax: {
				url: '<?= site_url("pltplh/autocomplete_jenis_jabatan") ?>',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term // bisa undefined / kosong
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


		$('#SATKER_ID').select2({
			placeholder: 'Pilih unit organisasi',
			allowClear: true,
			minimumInputLength: 0, // 🔥 ini kuncinya
			ajax: {
				url: '<?= site_url("pltplh/autocomplete_satker") ?>',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term // bisa undefined / kosong
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
		$('#SATKER_ID').on('select2:select', function(e) {
			let data = e.params.data;
			let jenis = $('#jenisJabatan').val();


			// HANYA untuk Struktural
			if (jenis === '1') {
				const mapEselon = {
					11: 'I.a',
					12: 'I.b',
					21: 'II.a',
					22: 'II.b',
					31: 'III.a',
					32: 'III.b',
					41: 'IV.a',
					42: 'IV.b'
				};

				$('input[name="namaJabatan"]').val(data.NAMA_JABATAN);
				$('input[name="eselonId"]').val(data.ESELON_ID);
				$('input[name="eselon"]').val(mapEselon[data.ESELON_ID] ?? '-');
				$('input[name="NAMA_KELAS_JABATAN"]').val(data.NAMA_JABATAN);
				$('input[name="KELAS_JABATAN_ID"]').val(data.id_jabatan_tpp);
				$('input[name="KELAS_JABATAN"]').val(data.kelas_jabatan);
				$('input[name="KETERANGAN_BUP"]').val(data.BUP_USIA);
			}
			$('input[name="unorId"]').val(data.SATKER_ID_SAPK);
			$('input[name="namaUnor"]').val(data.hirarki_nama);
		});
		$('#SATKER_ID').on('select2:clear', function() {
			// HANYA untuk Struktural
			if (jenis === '1') {
				$('input[name="namaJabatan"]').val('');
				$('input[name="NAMA_KELAS_JABATAN"]').val('');
				$('input[name="KELAS_JABATAN_ID"]').val('');
				$('input[name="KELAS_JABATAN"]').val('');
				$('input[name="KETERANGAN_BUP"]').val('');
				$('input[name="eselonId"]').val('');
				$('input[name="eselon"]').val('');
			}
			$('input[name="unorId"]').val('');
			$('input[name="namaUnor"]').val('');
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