<div class="row">
	<div class="col-md-12">

		<?php echo $this->session->flashdata("message"); ?>

		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata("errors"); ?>
		</ul>

		<form
			action="<?php echo site_url(
						"penghargaan/save/" . $row["PENGHARGAAN_ID"]
					); ?>"
			class="form-vertical"
			parsley-validate="true"
			novalidate="true"
			method="post"
			enctype="multipart/form-data">

			<div class="row">

				<!-- ================= KIRI ================= -->
				<div class="col-md-6">

					<!-- SKALA PENGHARGAAN -->
					<div class="form-group">
						<label class="control-label">
							SKALA PENGHARGAAN <span class="asterix">*</span>
						</label>

						<?php $SKALA_PENGHARGAAN_opt = [
							"1" => "Unit Kerja",
							"2" => "Instansi",
							"3" => "Kabupaten/Kota",
							"4" => "Provinsi",
							"5" => "Nasional",
							"6" => "Internasional",
						]; ?>

						<select
							name="SKALA_PENGHARGAAN"
							id="SKALA_PENGHARGAAN"
							class="form-control input-sm select2"
							style="width:100%;"
							required>
							<?php foreach (
								$SKALA_PENGHARGAAN_opt
								as $key => $val
							): ?>
								<option
									value="<?php echo $key; ?>"
									<?php echo $row["SKALA_PENGHARGAAN"] == $key
										? "selected"
										: ""; ?>>
									<?php echo $val; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<!-- KELOMPOK PENGHARGAAN -->
					<div class="form-group">
						<label class="control-label">
							KELOMPOK PENGHARGAAN
						</label>

						<?php $KELOMPOK_PENGHARGAAN_opt = [
							"100" =>
							"TANDA KEHORMATAN BINTANG REPUBLIK INDONESIA",
							"200" => "TANDA KEHORMATAN SATYALANCANA",
							"201" =>
							"TANDA KEHORMATAN SATYALANCANA KARYA SATYA X TAHUN",
							"202" =>
							"TANDA KEHORMATAN SATYALANCANA KARYA SATYA XX TAHUN",
							"203" =>
							"TANDA KEHORMATAN SATYALANCANA KARYA SATYA XXX TAHUN",
							"700" => "ANUGERAH ASN",
							"400" => "PENGHARGAAN LAINNYA",
						]; ?>

						<select
							name="KELOMPOK_PENGHARGAAN"
							id="KELOMPOK_PENGHARGAAN"
							class="form-control input-sm select2"
							style="width:100%;">
							<?php foreach (
								$KELOMPOK_PENGHARGAAN_opt
								as $key => $val
							): ?>
								<option
									value="<?php echo $key; ?>"
									<?php echo $row["KELOMPOK_PENGHARGAAN"] ==
										$key
										? "selected"
										: ""; ?>>
									<?php echo $val; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<!-- JENIS PENGHARGAAN -->
					<div class="form-group">
						<label class="control-label">
							JENIS PENGHARGAAN <span class="asterix">*</span>
						</label>

						<select
							name="HARGAID"
							id="HARGAID"
							code="<?php echo $row["HARGAID"]; ?>"
							class="form-control input-sm select2"
							style="width:100%;"
							required></select>

					</div>
					<input type="hidden" name="NAMA" id="NAMA" value="<?php echo $row["NAMA"]; ?>">


					<!-- NO SK -->
					<div class="form-group">
						<label class="control-label">
							NOMOR SURAT KEPUTUSAN <span class="asterix">*</span>
						</label>

						<input
							type="text"
							class="form-control input-sm"
							name="NO_SK"
							value="<?php echo $row["NO_SK"]; ?>"
							required />
					</div>

					<!-- TAHUN -->
					<div class="form-group">
						<label class="control-label">
							TAHUN PEROLEHAN <span class="asterix">*</span>
						</label>

						<input
							type="text"
							class="form-control input-sm"
							name="TAHUN"
							value="<?php echo $row["TAHUN"]; ?>"
							required
							maxlength="4"
							oninput="this.value = this.value.replace(/\s/g,'').replace(/[^0-9]/g,'')" />
					</div>

					<!-- HIDDEN FIELD -->
					<input type="hidden" name="PENGHARGAAN_ID" value="<?php echo $row["PENGHARGAAN_ID"]; ?>">
					<input type="hidden" name="PEGAWAI_ID" value="<?php echo $PEGAWAI_ID; ?>">
					<!-- <input type="hidden" name="NAMA" value="<?php echo $row["NAMA"]; ?>"> -->

				</div>

				<!-- ================= KANAN ================= -->
				<div class="col-md-6">


					<!-- TANGGAL SK -->
					<div class="form-group">
						<label class="control-label col-md-8">
							TANGGAL SURAT KEPUTUSAN
						</label>
						<div class="col-md-8">
							<input
								type="date"
								class="form-control input-sm"
								name="TANGGAL_SK"
								value="<?php echo $row["TANGGAL_SK"]; ?>"
								style="width:150px;" />
						</div>
					</div>

					<!-- FILE PDF -->
					<div class="form-group">
						<label for="File Sk" class=" control-label col-md-4 text-left"> DOKUMEN </label>
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
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('penghargaan/viewfile') . '/FILE_PDF/' . $row['PENGHARGAAN_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
							<!-- batas rubah-------------------------------- -->
						</div>

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<hr />
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div style="display:flex; justify-content:center; gap:10px;">
						<input type="button"
							id="kirimdata"
							class="btn btn-primary btn-sm"
							value="<?php echo $this->lang->line('core.sb_submit'); ?>" />

						<a href="javascript:cancelform()" class="btn btn-warning btn-sm">
							<?php echo $this->lang->line("core.sb_cancel"); ?>
						</a>
					</div>
				</div>
			</div>

		</form>
	</div>
</div>

<!-- tambahan fungsi pengecekan file ------------------------------- -->
<script>
	function validasiFilePDF() {
		const fileBaru = document.getElementById('FILE_PDF').files.length;
		const fileLama = document.getElementById('file_pdf_cek').value;

		if (fileBaru === 0 && fileLama === '') {
			alert('Wajib mengisi dokumen penghargaan (PDF)');
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

	// MASTER SKALA PENGHARGAAN
	var kelompokAll = {
		"100": "TANDA KEHORMATAN BINTANG REPUBLIK INDONESIA",
		"200": "TANDA KEHORMATAN SATYALANCANA",
		"201": "TANDA KEHORMATAN SATYALANCANA KARYA SATYA X TAHUN",
		"202": "TANDA KEHORMATAN SATYALANCANA KARYA SATYA XX TAHUN",
		"203": "TANDA KEHORMATAN SATYALANCANA KARYA SATYA XXX TAHUN",
		"700": "ANUGERAH ASN",
		"400": "PENGHARGAAN LAINNYA"
	};

	function loadKelompok(options) {
		var $kelompok = $("#KELOMPOK_PENGHARGAAN");

		$kelompok.empty();
		$kelompok.append('<option value="">-- Pilih Kelompok --</option>');

		$.each(options, function(key, val) {
			$kelompok.append('<option value="' + key + '">' + val + '</option>');
		});

		// refresh select2
		$kelompok.trigger('change.select2');
	}

	$("#SKALA_PENGHARGAAN").on("change", function() {

		var skala = $(this).val();

		// default: semua kelompok
		var filtered = kelompokAll;

		// NASIONAL
		if (skala == "5") {
			filtered = {
				"100": "TANDA KEHORMATAN BINTANG REPUBLIK INDONESIA",
				"200": "TANDA KEHORMATAN SATYALANCANA",
				"201": "TANDA KEHORMATAN SATYALANCANA KARYA SATYA X TAHUN",
				"202": "TANDA KEHORMATAN SATYALANCANA KARYA SATYA XX TAHUN",
				"203": "TANDA KEHORMATAN SATYALANCANA KARYA SATYA XXX TAHUN",
				"700": "ANUGERAH ASN",
				"400": "PENGHARGAAN LAINNYA"
			};
		}

		// SELAIN NASIONAL
		else if (skala == "1", "2", "3", "4", "6") {
			filtered = {
				"400": "PENGHARGAAN LAINNYA"
			};
		}

		loadKelompok(filtered);

	});

	$("#KELOMPOK_PENGHARGAAN").on("change", function() {

		var kelompok = $(this).val();

		if (kelompok == "") {
			$("#HARGAID").html('<option value="">-- Pilih Jenis Penghargaan --</option>');
			return;
		}

		$("#HARGAID").jCombo(
			"<?php echo site_url("penghargaan/comboselect"); ?>" +
			"?filter=jenis_penghargaan:hargaId:nama" +
			"&where=kelompok_id:" + kelompok, {
				selected_value: ""
			}
		);

	});

	$("#HARGAID").on("change", function() {
		var nama = $("#HARGAID option:selected").text();

		// kalau masih option placeholder
		if (nama === "-- Pilih Jenis Penghargaan --") {
			$("#NAMA").val("");
		} else {
			$("#NAMA").val(nama);
		}
	});



	$('input').on('keyup', function(event) {
		if (event.keyCode == 13) {
			$(this).next('input').focus();
		}
	});

	$(document).ready(function() {

		$("#HARGAID").jCombo(
			"<?php echo site_url(
					"penghargaan/comboselect?filter=jenis_penghargaan:hargaId:nama"
				); ?>", {
				selected_value: "<?php echo $row["HARGAID"]; ?>"
			}
		);

		// ketika kelompok penghargaan berubah
		$("#KELOMPOK_PENGHARGAAN").change(function() {

			var kelompok = $(this).val();

			// kosongkan dulu jenis penghargaan
			$("#HARGAID").html("");

			// reload combo jenis penghargaan berdasarkan kelompok
			$("#HARGAID").jCombo(
				"<?php echo site_url(
						"penghargaan/comboselect?filter=jenis_penghargaan:hargaId:nama:kelompok_id:"
					); ?>" + kelompok, {
					selected_value: ""
				}
			);

		});


		var frm = $('form');
		// timpa yang lama jadi seperti ini --------------
		$("#kirimdata").click(function() {

			var form_data = new FormData(frm[0]);
			// if (!frm.valid()) return false; ------------------matikan ini
			if (!frm.parsley().validate()) return false; //------ganti jadi ini 

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


		<?php if (
			$this->access["is_edit"] != 1 &&
			$this->access["is_add"] != 1
		) { ?>
			$('form input').attr('readonly', 'readonly');
		<?php } ?>

		// trigger pertama kali saat halaman load
		$("#SKALA_PENGHARGAAN").trigger("change");

		// kembalikan nilai lama kalau edit
		var selectedKelompok = "<?php echo $row["KELOMPOK_PENGHARGAAN"]; ?>";
		if (selectedKelompok) {
			$("#KELOMPOK_PENGHARGAAN").val(selectedKelompok).trigger('change');
		}

		var selectedKelompok = "<?php echo $row["KELOMPOK_PENGHARGAAN"]; ?>";
		var selectedJenis = "<?php echo $row["HARGAID"]; ?>";

		if (selectedKelompok) {

			$("#KELOMPOK_PENGHARGAAN").val(selectedKelompok).trigger("change");

			setTimeout(function() {
				$("#HARGAID").val(selectedJenis).trigger("change");
			}, 500);

		}

		// auto load jenis saat edit (kalau sudah ada kelompok lama)
		var kelompok_lama = $("#KELOMPOK_PENGHARGAAN").val();
		var jenis_lama = $("#HARGAID").attr("code");

		if (kelompok_lama != "") {
			$("#HARGAID").jCombo(
				"<?php echo site_url(
						"penghargaan/comboselect?filter=jenis_penghargaan:hargaId:nama:kelompok_id:"
					); ?>" + kelompok_lama, {
					selected_value: jenis_lama
				}
			);
		}


	});
</script>