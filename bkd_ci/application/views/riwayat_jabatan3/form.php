<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('riwayat_jabatan3/save/' . $row['JABATAN_RIWAYAT_ID']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group row hidethis " style="display:none;">
						<label for="JABATAN RIWAYAT ID" class=" control-label col-md-4 text-left"> JABATAN RIWAYAT ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_RIWAYAT_ID']; ?>' name='JABATAN_RIWAYAT_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' required /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row">
						<label for="JENIS JABATAN" class="control-label col-md-4 text-left"> JENIS JABATAN <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='JENIS_JABATAN_SAPK' rows='5' id='JENIS_JABATAN_SAPK' code='{$JENIS_JABATAN_SAPK}' class='form-control input-sm select2' style='width: 100%;' required></select>
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="JENIS PENUGASAN" class="control-label col-md-4 text-left"> JENIS PENUGASAN </label>
						<div class="col-md-8">
							<select name='jenisPenugasanId' rows='5' id='jenisPenugasanId' code='{$jenisPenugasanId}' class='form-control input-sm select2' style='width: 100%;'></select>
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="JENIS MUTASI" class="control-label col-md-4 text-left"> JENIS MUTASI </label>
						<div class="col-md-8">
							<select name='jenisMutasiId' rows='5' id='jenisMutasiId' code='{$jenisMutasiId}' class='form-control input-sm select2' style='width: 100%;'></select>
							<br />
							<i><small></small></i>
						</div>
					</div>

					<div class="form-group row">
						<label for="CARI SATKER ID" class="control-label col-md-4 text-left"> CARI SATKER </label>
						<div class="col-md-8">
							<input type="hidden" id="SATKER_ID" name="SATKER_ID" value="<?php echo $row['SATKER_ID']; ?>" />

							<select name='CARI_SATKER_ID' id='CARI_SATKER_ID' class='form-control input-sm select2' style='width: 100%;'>
							</select>

							<!-- <select id='JFT_ID_SAPK' class='form-control input-sm select2' style='width: 100%;'>
							</select> -->
							<br />

							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="SATKER" class="control-label col-md-4 text-left"> SATKER <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['namaUnor']; ?>' name='namaUnor' required />
							<br />
							<i><small></small></i>
						</div>
					</div>


					<div class="form-group row">
						<label for="JFT ID SAPK" class="control-label col-md-4 text-left"> CARI JABATAN FUNGSIONAL </label>
						<div class="col-md-8">
							<select name='JFT_ID_SAPK' id='JFT_ID_SAPK' class='form-control input-sm select2' style='width: 100%;'>
							</select>
							<br />
							<i><small></small></i>
						</div>
					</div>

					<div class="form-group row">
						<label for="JFU ID SAPK" class="control-label col-md-4 text-left"> CARI JABATAN PELAKSANA </label>
						<div class="col-md-8">
							<select name='JFU_ID_SAPK' id='JFU_ID_SAPK' class='form-control input-sm select2' style='width: 100%;'>
							</select>
							<br />
							<i><small></small></i>
						</div>
					</div>


					<!-- <input type="hidden" placeholder="" value="Pemerintah Kab. Probolinggo" name="SATUAN_KERJA_NAMA_SAPK" id="SATUAN_KERJA_NAMA_SAPK"> -->


					<div class="form-group row">
						<label for="NAMA" class="control-label col-md-4 text-left"> JABATAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' />

							<br />
							<i><small></small></i>
						</div>
					</div>



					<div class="form-group row">
						<label for="SUB JABATAN ID SAPK" class="control-label col-md-4 text-left"> CARI SUB JABATAN </label>
						<div class="col-md-8">
							<select name='subJabatanId' id='subJabatanId' class='form-control input-sm select2' style='width: 100%;'>
							</select>
							<br />
							<i><small></small></i>
						</div>
					</div>


					<div class="form-group row">
						<label for="subJabatanNama" class="control-label col-md-4 text-left">SUB JABATAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['subJabatanNama']; ?>' name='subJabatanNama' />

							<br />
							<i><small></small></i>
						</div>
					</div>

					<div class="form-group row">
						<label for="ESELON_ID" class="control-label col-md-4 text-left"> ESELON</label>
						<div class="col-md-8">
							<input type="hidden" class='form-control input-sm' placeholder='' value='<?php echo $row['ESELON_ID']; ?>' name='ESELON_ID' />
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['eselonNama']; ?>' name='eselonNama' />

							<br />
							<i><small></small></i>
						</div>
					</div>

					<div class="form-group row">
						<label for="KETERANGAN_BUP" class="control-label col-md-4 text-left"> BUP </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN_BUP']; ?>' name='KETERANGAN_BUP' />

							<br />
							<i><small></small></i>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group row">
						<label for="TMT MUTASI" class="control-label col-md-4 text-left"> TMT MUTASI </label>
						<div class="col-md-8">
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['tmtMutasi']; ?>' name='tmtMutasi' style='width:150px !important;' />
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="TMT JABATAN" class="control-label col-md-4 text-left"> TMT JABATAN </label>
						<div class="col-md-8">
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_JABATAN']; ?>' name='TMT_JABATAN' style='width:150px !important;' />
							<br />
							<i><small></small></i>
						</div>
					</div>
					<input type="hidden" placeholder="" value="<?php echo $row['TMT_JABATAN']; ?>" name="TMT_ESELON" id="TMT_ESELON">
					<input type="hidden" placeholder="" value="<?php echo date('Y-m-d H:i:s'); ?>" name="LAST_UPDATE_DATE" id="LAST_UPDATE_DATE">

					<div class="form-group row">
						<label for="NO SK" class="control-label col-md-4 text-left"> NO SK </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' />
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="TANGGAL SK" class="control-label col-md-4 text-left"> TANGGAL SK </label>
						<div class="col-md-8">
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' style='width:150px !important;' />
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="TANGGAL PELANTIKAN" class="control-label col-md-4 text-left"> TANGGAL PELANTIKAN </label>
						<div class="col-md-8">
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_PELANTIKAN']; ?>' name='TANGGAL_PELANTIKAN' style='width:150px !important;' />
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<!-- <label for="FILE PDF" class="control-label col-md-4 text-left"> FILE PDF </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FILE_PDF']; ?>' name='FILE_PDF' />
							<br />
							<i><small></small></i>
						</div> -->

						<!-- start file pdf  -->

						<label for="ipt" class=" control-label col-md-4 text-left "> FILE SK (PDF) <span class="asterix"> * </span> </label>
						<div class="col-md-5">
							<input type="file" class="form-control input-sm" id="FILE_PDF" name="FILE_PDF" accept=".pdf" onchange="checkFileSize('FILE_PDF', 'fileSizeErrorFilePdf')">
							<span id="fileSizeErrorFilePdf" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 2 MB.</span>

							<input type="hidden" name="file_pdf_cek" value="<?php echo $row['FILE_PDF']; ?>" />
							<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />


						</div>
						<div class="col-md-2">
							<?
							if ($row['FILE_PDF'] != '') {
								echo '<a href="javascript:SximoModal(\'' . site_url('riwayat_jabatan3/viewfile') . '/FILE_PDF/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
						</div>

						<!-- end file pdf  -->

						<input type="hidden" placeholder="" value="A5EB03E24222F6A0E040640A040252AD" name="INSTANSI_KERJA_ID_SAPK" id="INSTANSI_KERJA_ID_SAPK">
						<input type="hidden" placeholder="" value="Pemerintah Kab. Probolinggo" name="INSTANSI_KERJA_NAMA_SAPK" id="INSTANSI_KERJA_NAMA_SAPK">
						<input type="hidden" placeholder="" value="A5EB03E24222F6A0E040640A040252AD" name="SATUAN_KERJA_ID_SAPK" id="SATUAN_KERJA_ID_SAPK">
						<input type="hidden" placeholder="" value="Pemerintah Kab. Probolinggo" name="SATUAN_KERJA_NAMA_SAPK" id="SATUAN_KERJA_NAMA_SAPK">
						<input type="hidden" placeholder="" value="<?php echo $row['UNOR_ID_SAPK']; ?>" name="UNOR_ID_SAPK" id="UNOR_ID_SAPK">
						<input type="hidden" placeholder="" value="<?php echo $row['UNOR_NAMA_SAPK']; ?>" name="UNOR_NAMA_SAPK" id="UNOR_NAMA_SAPK">

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

<script type="text/javascript">
	$(document).on("keypress", 'form', function(e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	$('input').on('keyup', function(event) {
		if (event.keyCode == 13) {
			$(this).next('input').focus();
		}
	});

	$(document).ready(function() {
		var frm = $('form');
		$("#kirimdata").click(function() {
			var form_data = new FormData(frm[0]);
			//var files = $('#FILE_PDF')[0].files;
			//form_data.append('FILE_PDF', files[0]);
			// Cek jika SATKER_ID ada dan kosong
			if (form_data.get('SATKER_ID') === '' && form_data.has('CARI_SATKER_ID')) {
				// Atur SATKER_ID dengan nilai dari satker_id_cek
				form_data.set('SATKER_ID', form_data.get('CARI_SATKER_ID'));

				// Hapus satker_id_cek
				form_data.delete('CARI_SATKER_ID');
			}
			if (!frm.valid()) return false;

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

		// frm.submit(function(ev) {
		// 	$.ajax({
		// 		type: frm.attr('method'),
		// 		url: frm.attr('action'),
		// 		data: frm.serialize(),
		// 		success: function(data) {
		// 			alert('Data Berhasil Disimpan !!');
		// 			table.ajax.reload();
		// 			$('#form-ajax').html("");
		// 		}
		// 	});
		// 	ev.preventDefault();
		// });

		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

		$("#JENIS_JABATAN_SAPK").jCombo("<?php echo site_url('riwayat_jabatan3/comboselect?filter=jenis_jabatan:ID:NAMA') ?>", {
			selected_value: '<?php echo $row["JENIS_JABATAN_SAPK"] ?>'
		});

		$("#jenisPenugasanId").jCombo("<?php echo site_url('riwayat_jabatan3/comboselect?filter=jenis_penugasan:JENIS_PENUGASAN_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["jenisPenugasanId"] ?>'
		});

		$("#jenisMutasiId").jCombo("<?php echo site_url('riwayat_jabatan3/comboselect?filter=jenis_mutasi:JENIS_MUTASI_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["jenisMutasiId"] ?>'
		});

		function handleFormVisibility() {
			var jenisJabatan = $("#JENIS_JABATAN_SAPK").val();
			var jenisMutasi = $("#jenisMutasiId").val();

			$(".form-group").hide(); // Hide all form groups initially
			$("#JENIS_JABATAN_SAPK").closest('.form-group').show();
			// $("#jenisPenugasanId").closest('.form-group').show();
			// $("#jenisMutasiId").closest('.form-group').show();

			if (jenisJabatan == '1') { // Jabatan Struktural (Pejabat Eselon)

				// $('input[name="NAMA"]').val('');
				// $('input[name="KETERANGAN_BUP"]').val('');
				$('input[name="JFU_ID_SAPK"]').val('');
				$('input[name="JFT_ID_SAPK"]').val('');

				// $("#jenisPenugasanId").closest('.form-group').show();
				$("#jenisPenugasanId").val('D').prop('readonly', true);
				$("#jenisMutasiId").val('MJ').prop('readonly', true);
				$("[name='tmtMutasi'], [name='eselonNama'], [name='TMT_JABATAN'], [name='namaUnor'], [name='CARI_SATKER_ID'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF'], [name='NAMA']").closest('.form-group').show();
			} else if (jenisJabatan == '2') { // Jabatan Fungsional
				// $('input[name="NAMA"]').val('');
				// $('input[name="KETERANGAN_BUP"]').val('');
				$('input[name="JFU_ID_SAPK"]').val('');

				$("#jenisMutasiId").closest('.form-group').show();
				$("#jenisMutasiId").prop('disabled', false);
				if (jenisMutasi == 'MJ') {
					$("[name='subJabatanNama'], [name='NAMA'], [name='KETERANGAN_BUP']").prop('readonly', true).closest('.form-group').show();
					$("[name='TMT_JABATAN'], [name='JFT_ID_SAPK']").prop('disabled', false).closest('.form-group').show();
					$("[name='subJabatanId'],[name='subJabatanNama'], [name='TMT_JABATAN'], [name='namaUnor'], [name='CARI_SATKER_ID'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF'], [name='JFT_ID_SAPK'], [name='NAMA']").closest('.form-group').show();
				} else if (jenisMutasi == 'MU') {
					// $("[name='TMT_JABATAN'], [name='JFT_ID_SAPK']").prop('disabled', true).closest('.form-group').show();
					// $("[name='tmtMutasi'], [name='namaUnor'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF'], [name='JFT_ID_SAPK']").prop('disabled', false).closest('.form-group').show();
					$("[name='subJabatanId'],[name='subJabatanNama'],[name='tmtMutasi'], [name='namaUnor'], [name='CARI_SATKER_ID'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF']").prop('disabled', false).closest('.form-group').show();
				}
			} else if (jenisJabatan == '4') { // Jabatan Pelaksana
				// $('input[name="NAMA"]').val('');
				// $('input[name="KETERANGAN_BUP"]').val('');
				$('input[name="JFT_ID_SAPK"]').val('');

				$("#jenisMutasiId").closest('.form-group').show();
				$("#jenisMutasiId").prop('disabled', false);
				if (jenisMutasi == 'MJ') {
					$("[name='NAMA'], [name='KETERANGAN_BUP']").prop('readonly', true).closest('.form-group').show();
					$("[name='TMT_JABATAN'], [name='JFU_ID_SAPK']").prop('disabled', false).closest('.form-group').show();
					$("[name='TMT_JABATAN'], [name='namaUnor'], [name='CARI_SATKER_ID'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF'], [name='JFU_ID_SAPK'], [name='NAMA']").closest('.form-group').show();
				} else if (jenisMutasi == 'MU') {
					// $("[name='TMT_JABATAN'], [name='JFU_ID_SAPK']").prop('disabled', true).closest('.form-group').show();
					// $("[name='tmtMutasi'], [name='namaUnor'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF'], [name='JFU_ID_SAPK']").prop('disabled', false).closest('.form-group').show();
					$("[name='tmtMutasi'], [name='namaUnor'], [name='CARI_SATKER_ID'], [name='NO_SK'], [name='TANGGAL_SK'], [name='TANGGAL_PELANTIKAN'], [name='FILE_PDF']").prop('disabled', false).closest('.form-group').show();
				}
			}
		}

		$("#JENIS_JABATAN_SAPK, #jenisMutasiId").change(handleFormVisibility);
		handleFormVisibility(); // Initial call
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
		function formatRepo(repo) {
			if (repo.loading) {
				return repo.text;
			}

			// var markup = "<div class='select2-result-repository__title'>" + repo.text + "</div>";
			var markup = repo.text;

			return markup;
		}

		function formatRepoSelection(repo) {
			return repo.text;
		}

		// Initialize Select2 for JFT ID SAPK
		$('#JFT_ID_SAPK').select2({
			ajax: {
				url: "<?php echo site_url('riwayat_jabatan3/getJftOptions'); ?>",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term // search term
					};
				},
				processResults: function(data) {
					return {
						results: data
					};
				},
				cache: true
			},
			placeholder: 'CARI JABATAN',
			minimumInputLength: 1,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
		}).on('select2:select', function(e) {
			var data = e.params.data;
			$("input[name='NAMA']").val(data.text);
			$("input[name='KETERANGAN_BUP']").val(data.bup);
			// Ambil kel_jabatan_id dari data yang dipilih
			var kel_jabatan_id = data.kel_jabatan_id;

			// Initialize Select2 for sub jabatan
			$('#subJabatanId').select2({
				ajax: {
					url: "<?php echo site_url('riwayat_jabatan3/getSubJabatanOptions'); ?>",
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							q: params.term, // search term
							// kel_jabatan_id: 'A5EB03E23DE9F6A0E040640A040252AD'
							kel_jabatan_id: kel_jabatan_id
						};
					},
					processResults: function(data) {
						return {
							results: data
						};
					},
					cache: true
				},
				placeholder: 'CARI SUB JABATAN',
				minimumInputLength: 1,
				templateResult: formatRepo,
				templateSelection: formatRepoSelection
			}).on('select2:select', function(e) {
				var data = e.params.data;
				// [name='subJabatanId'],[name='subJabatanNama']
				$("input[name='subJabatanNama']").val(data.text);
				// $("input[name='SUB_JABATAN_SIASN_ID']").val(data.id);
			});

		});

		// Initialize Select2 for JFU ID SAPK
		$('#JFU_ID_SAPK').select2({
			ajax: {
				url: "<?php echo site_url('riwayat_jabatan3/getJfuOptions'); ?>",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term // search term
					};
				},
				processResults: function(data) {
					return {
						results: data
					};
				},
				cache: true
			},
			placeholder: 'CARI JABATAN',
			minimumInputLength: 1,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
		}).on('select2:select', function(e) {
			var data = e.params.data;
			$("input[name='NAMA']").val(data.text);
			$("input[name='KETERANGAN_BUP']").val(data.bup);


		});




		// Initialize Select2 for SATKER ID
		$('#CARI_SATKER_ID').select2({
			ajax: {
				url: "<?php echo site_url('riwayat_jabatan3/getSatkerOptions'); ?>",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						q: params.term // search term
					};
				},
				processResults: function(data) {
					return {
						results: data
					};
				},
				cache: true
			},
			placeholder: 'CARI SATKER',
			minimumInputLength: 1,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
		}).on('select2:select', function(e) {
			var data = e.params.data;
			// console.log(data);
			$("input[name='namaUnor']").val(data.text);
			$("input[name='UNOR_NAMA_SAPK']").val(data.text);
			$("input[name='UNOR_ID_SAPK']").val(data.satker_id_sapk);
			$("input[name='SATKER_ID']").val(data.satker_id);

			if ($("#JENIS_JABATAN_SAPK").val() == 1) {
				$("input[name='KETERANGAN_BUP']").val(data.bup);
				$("input[name='ESELON_ID']").val(data.eselon_id);
				$("input[name='eselonNama']").val(data.nama_eselon);
				$("input[name='NAMA']").val(data.nama_jabatan);
			}

		});
	});
</script>