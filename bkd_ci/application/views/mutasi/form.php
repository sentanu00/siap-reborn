<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('mutasi/save/' . $row['JABATAN_RIWAYAT_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-4">


					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> JABATAN RIWAYAT ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_RIWAYAT_ID']; ?>' name='JABATAN_RIWAYAT_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID <span class="asterix"> * </span> </label>
						<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_ID']; ?>' name='PEGAWAI_ID'  required /> -->
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class="control-label"> PEJABAT PENETAP<span class="asterix"> * </span></label>
						<input type="hidden" name="PEJABAT_PENETAP" id="PEJABAT_PENETAP" value="<?php echo $row['PEJABAT_PENETAP']; ?>">
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;' required onchange="getnamapejabat()"></select>
					</div>

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' id='NO_SK' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JENIS JABATAN SAPK <span class="asterix"> * </span> </label>
						<select name='JENIS_JABATAN_SAPK' rows='5' id='JENIS_JABATAN_SAPK' code='{$JENIS_JABATAN_SAPK}' class='form-control input-sm' style='width: 100%;' required></select>
					</div>
					<!-- <div class="form-group  " >
									<label for="ipt" class=" control-label "> SATUAN KERJA  <span class="asterix"> * </span>  </label>									
									  <select name='SATKER_ID' rows='5' id='SATKER_ID' code='{$SATKER_ID}' class='form-control input-sm select2 ' style='width: 100%;' required  ></select> 						
								  </div> -->
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SATUAN KERJA <span class="asterix"> * </span> </label>
						<small class="form-text text-muted">Pilih penempatan pegawai secara spesifik</small>
						<input type="hidden" placeholder="" required value="<?php echo $row['SATKER_ID']; ?>" name="SATKER_ID" id="SATKER_ID">


						<div class="input-group mb-3">
							<input type="text" readonly required value="<?php echo $SATKER_NAMA; ?>" id="SATKER_NAMA" class="form-control form-control-sm " autocomplete="off">
							<div class="input-group-append">
								<button class="btn btn-sm btn-info" type="button" onclick="getsatker('<?php echo $row['SATKER_ID']; ?>')"><i class="fa fa-forward"></i></button>
							</div>
						</div>
					</div>
					<input type="hidden" placeholder="" value="" name="UNOR_ID_SAPK" id="UNOR_ID_SAPK">
					<input type="hidden" placeholder="" value="" name="UNOR_NAMA_SAPK" id="UNOR_NAMA_SAPK">
					<input type="hidden" placeholder="" value="" name="KETERANGAN_BUP" id="KETERANGAN_BUP">
					<input type="hidden" placeholder="" value="A5EB03E23B3BF6A0E040640A040252AD" name="INSTANSI_KERJA_ID_SAPK" id="INSTANSI_KERJA_ID_SAPK">
					<input type="hidden" placeholder="" value="Pemerintah Kab. Probolinggo" name="INSTANSI_KERJA_NAMA_SAPK" id="INSTANSI_KERJA_NAMA_SAPK">
					<input type="hidden" placeholder="" value="A5EB03E24222F6A0E040640A040252AD" name="SATUAN_KERJA_ID_SAPK" id="SATUAN_KERJA_ID_SAPK">
					<input type="hidden" placeholder="" value="Pemerintah Kab. Probolinggo" name="SATUAN_KERJA_NAMA_SAPK" id="SATUAN_KERJA_NAMA_SAPK">
					<input type='hidden' placeholder="" value='<?php echo $idPns; ?>' name='idPns' name='idPns' required />
					<!-- <div class="form-group  " >
									<label for="ipt" class=" control-label "> JABATAN  <span class="asterix"> * </span>  </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_FUNGSIONAL_ID']; ?>' name='JABATAN_FUNGSIONAL_ID'
									  id= 'JABATAN_FUNGSIONAL_ID' required /> 						
								  </div> -->
					<input type="hidden" name="NAMA" id="NAMA" value="<?php echo $row['NAMA']; ?>">
					<div class="form-group" id="jabatan_id">
						<label for="ipt" class=" control-label "> JABATAN <span class="asterix"> * </span></label>
						<!-- <input type="hidden" name="NAMA" id="NAMA" value="<?php echo $row['NAMA']; ?>"> -->

						<!-- <select name="JABATAN_FUNGSIONAL_ID" rows="5" id="JABATAN_FUNGSIONAL_ID" code="<?php echo $JABATAN_FUNGSIONAL_ID; ?>" class="form-control input-sm select2" style="width: 100%;" required></select> -->

						<!-- <input type="text" class="form-control input-sm" name="JABATAN_FUNGSIONAL_ID" id="JABATAN_FUNGSIONAL_ID" value="-"> -->
						<select name="JABATAN_FUNGSIONAL_ID" rows="5" id="JABATAN_FUNGSIONAL_ID" class="form-control input-sm select2" style="width: 100%;" value='<?php echo $row['JFT_ID_SAPK']; ?>'></select>


						<!-- <input type="text" class='form-control input-sm' name="NAMA" id="NAMA" value="<?php echo $row['NAMA']; ?>" read-only> -->
						<!-- <select name='JABATAN_FUNGSIONAL_ID' rows='5' id='JABATAN_FUNGSIONAL_ID' code='{$JABATAN_FUNGSIONAL_ID}' class='form-control input-sm select2 ' style='width: 100%;' required onchange="getnamajabatan()"></select> -->
					</div>
					<div class="form-group">
						<label for="ipt" class=" control-label "> TMT JABATAN <span class="asterix"> * </span> </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_JABATAN']; ?>' name='TMT_JABATAN' id='TMT_JABATAN' required />
					</div>
					<div class="form-group" id="jft_id_sapk">
						<label for="ipt" class=" control-label "> JABATAN FUNGSIONAL TERTENTU <span class="asterix"> * </span></label>
						<select name='JFT_ID_SAPK' rows='5' id='JFT_ID_SAPK' code='{$JFT_ID_SAPK}' class='form-control input-sm select2 ' style='width: 100%;' value='<?php echo $row['JFT_ID_SAPK']; ?>'></select>
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> JFT NAMA SAPK </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JFT_NAMA_SAPK']; ?>' name='JFT_NAMA_SAPK' id='JFT_NAMA_SAPK' />
					</div>
					<div class="form-group" id="jfu_id_sapk">
						<label for="ipt" class=" control-label "> JABATAN FUNGSIONAL UMUM <span class="asterix"> * </span></label>
						<select name='JFU_ID_SAPK' rows='5' id='JFU_ID_SAPK' code='{$JFU_ID_SAPK}' class='form-control input-sm select2' style='width: 100%;' value='<?php echo $row['JFU_ID_SAPK']; ?>'></select>
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> JFU NAMA SAPK</label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JFU_NAMA_SAPK']; ?>' name='JFU_NAMA_SAPK' id='JFU_NAMA_SAPK' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SK JABATAN <span class="asterix">*</span> </label>
						<!-- <input  type='file' name='FILE_PDF' id='FILE_PDF' required <?php if ($row['FILE_PDF'] == '') echo 'class="required"'; ?> style='width:150px !important;'  />
										<?php echo SiteHelpers::showUploadedFile($row['FILE_PDF'], ''); ?> -->
						<input type='file' class='form-control input-sm' accept="application/pdf" required id="FILE_PDF" name="FILE_PDF">
						<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />
						<?
						if ($row['FILE_PDF'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('mutasi/viewfile') . '/FILE_PDF/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
						}
						?>

					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SURAT PELANTIKAN </label>
						<!-- <label for="ipt" class=" control-label "> SURAT PELANTIKAN </label>									
									  <input  type='file' name='FILE_PELANTIKAN' id='FILE_PELANTIKAN' <?php if ($row['FILE_PELANTIKAN'] == '') echo 'class="required"'; ?> style='width:150px !important;'  />
										<?php echo SiteHelpers::showUploadedFile($row['FILE_PELANTIKAN'], ''); ?> -->

						<input type='file' class='form-control input-sm' accept="application/pdf" id="FILE_PELANTIKAN" name="FILE_PELANTIKAN">
						<!-- <input type="hidden" name="file_pelantikan_cek" value="<?php echo $row['FILE_PELANTIKAN']; ?>" /> -->
						<input type="hidden" name="FILE_PELANTIKAN" value="<?php echo $row['FILE_PELANTIKAN']; ?>" />
						<?
						if ($row['FILE_PELANTIKAN'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('mutasi/viewfile') . '/FILE_PELANTIKAN/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
						}
						?>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> ESELON </label>
						<select name='ESELON_ID' rows='5' id='ESELON_ID' code='{$ESELON_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL SK </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TMT ESELON </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_ESELON']; ?>' name='TMT_ESELON' />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TUNJANGAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TUNJANGAN']; ?>' name='TUNJANGAN' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> BULAN DIBAYAR </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BULAN_DIBAYAR']; ?>' name='BULAN_DIBAYAR' />
					</div>
					<!-- <div class="form-group  " >
									<label for="ipt" class=" control-label "> KELAS JABATAN    </label>									
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KELAS_JABATAN']; ?>' name='KELAS_JABATAN'   /> 						
								  </div>  -->
					<div class="form-group col-md-6" style="display:none">
						<label for="ipt" class=" control-label "> KELAS JABATAN </label>
						<input type='hidden' class='form-control input-sm' readonly placeholder='' name='KELAS_JABATAN' id='KELAS_JABATAN' value='<?php echo $row['KELAS_JABATAN']; ?>' />
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
	if ($row['FILE_PDF'] != '') {
	?>
		$('#FILE_PDF').prop('required', false);
	<?
	} else {
	?>
		$('#FILE_PDF').prop('required', true);
	<?
	}
	?>

	function getnamapejabat() {
		var data = $('#PEJABAT_PENETAP_ID').select2('data');
		if (data[0].id != '') {
			$('#PEJABAT_PENETAP').val(data[0].text);
		}
	}

	function getnamajabatan() {
		var data = $('#JABATAN_FUNGSIONAL_ID').select2('data');
		if (data[0].id != '') {
			$('#NAMA').val(data[0].text);
			getkelasjabatan();
		}
	}

	function getkelasjabatan() {
		$.ajax({
			type: "GET",
			url: "<?= site_url('mutasi/getkelas'); ?>/" + $("#JABATAN_FUNGSIONAL_ID").val(),
			dataType: "html",
			success: function(data) {
				$('#KELAS_JABATAN').val(data);
			}
		});
	}


	$(document).ready(function() {
		$('.select2').select2();

		var namaJabatan; // Define the global variable	
		var get_satker = document.getElementById("SATKER_ID");
		var initialValue = get_satker.value;
		// console.log("Initial value:", initialValue);
		const jenis_jabatan = document.getElementById('JENIS_JABATAN_SAPK');
		const dataSelect_jabatan = document.getElementById('JABATAN_FUNGSIONAL_ID');
		// const originalOptions = dataSelect_jabatan.innerHTML;
		const originalOptions = Array.from(dataSelect_jabatan.options);
		const originalClass = dataSelect_jabatan.className;
		const select2Span = document.querySelector('span[id*="select2-JABATAN_FUNGSIONAL_ID-container"]');
		const select2SpanJFU = document.querySelector('span[id*="select2-JFU_ID_SAPK-container"]');
		const select2SpanJFT = document.querySelector('span[id*="select2-JFT_ID_SAPK-container"]');
		const jabatandiv = document.getElementById('jabatan_id');
		const jftIdElement = document.getElementById('JFT_ID_SAPK');
		const jftIdContainer = document.getElementById('select2-JFT_ID_SAPK-container');
		const jftIdDiv = document.getElementById('jft_id_sapk');
		const jfuIdElement = document.getElementById('JFU_ID_SAPK');
		const jfuIdDiv = document.getElementById('jfu_id_sapk');
		const namajabatan = document.getElementById('NAMA');
		const klsjabatan = document.getElementById('KELAS_JABATAN');
		const jftnama = document.getElementById('JFT_NAMA_SAPK');
		const jfunama = document.getElementById('JFU_NAMA_SAPK');
		const unorid = document.getElementById('UNOR_ID_SAPK');
		const unornama = document.getElementById('UNOR_NAMA_SAPK');
		// const satkeridsapk = document.getElementById('SATUAN_KERJA_ID_SAPK');
		const ketbup = document.getElementById('KETERANGAN_BUP');

		jenis_jabatan.addEventListener('change', function() {
			const data_value = jenis_jabatan.value;
			// console.log("data: "+data_value);
			if (data_value === '1') {
				dataSelect_jabatan.innerHTML = '';
				const option = document.createElement('option');
				option.value = '-';
				option.text = '-';
				dataSelect_jabatan.setAttribute('required', 'required');
				dataSelect_jabatan.disabled = false;
				dataSelect_jabatan.appendChild(option);
				select2Span.textContent = '-';
				select2Span.setAttribute('title', '-');
				jabatandiv.style.display = 'block';
				jftIdDiv.style.display = 'none';
				jftIdElement.disabled = true;
				jftIdElement.removeAttribute('required');
				jfuIdDiv.style.display = 'none';
				jfuIdElement.disabled = true;
				jfuIdElement.removeAttribute('required');

			} else if (data_value === '2') {
				dataSelect_jabatan.disabled = true;
				select2Span.style.display = 'block';
				dataSelect_jabatan.removeAttribute('required');
				select2SpanJFT.textContent = '-- Please Select --';
				select2SpanJFT.setAttribute('title', '-- Please Select --');
				dataSelect_jabatan.className = originalClass
					.replace('select3z', '')
					.replace('select3', '');
				jabatandiv.style.display = 'none';
				jftIdDiv.style.display = 'block';
				jftIdElement.setAttribute('required', 'required');
				jftIdElement.disabled = false;
				jfuIdDiv.style.display = 'none';
				jfuIdElement.disabled = true;
				jfuIdElement.removeAttribute('required');
				$("#JABATAN_FUNGSIONAL_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=master_jabatan:id:nm_jabatan|ket') ?>", {
					selected_value: '<?php echo $row["JABATAN_FUNGSIONAL_ID"] ?>'
				});
				// $("#JFT_ID_SAPK").jCombo("<?php echo site_url('mutasi/comboselect?filter=master_jabatan_fungsional_tertentu:JFT_SIASN_ID:NAMA|BUP_USIA') ?>",{  selected_value : '<?php echo $row["JFT_ID_SAPK"] ?>' });
				$.ajax({
					// url: 'http://localhost:8082/index.php/api/get_master_jabatan_fungsional_tertentu',
					url: "<?php echo site_url('api/get_master_jabatan_fungsional_tertentu'); ?>",
					method: 'GET',
					dataType: 'json',
					success: function(data) {
						// Parse the JSON response
						var options = '';
						var kelas_jabatan_tpp = '';
						$.each(data, function(index, item) {
							// Create option elements
							options += '<option value="' + item.JFT_SIASN_ID + '">' + item.NAMA + '</option>';
						});
						// Append options to the select element
						$('#JFT_ID_SAPK').append(options);

						// Event listener for select change
						$('#JFT_ID_SAPK').on('change', function() {
							var selectedOption = $(this).find('option:selected');
							var selectedText = selectedOption.text();
							$('#NAMA').val(selectedText);
							dataSelect_jabatan.innerHTML = '';
							const option = document.createElement('option');
							option.value = selectedOption.val();
							option.text = selectedText;
							dataSelect_jabatan.appendChild(option);
							select2Span.textContent = selectedText;
							select2Span.setAttribute('title', selectedText);
							jftnama.value = selectedText;
							$.ajax({
								// url: 'http://localhost:8082/index.php/api/get_master_jabatan_fungsional_tertentu?nama='+selectedText,
								url: "<?php echo site_url('api/get_master_jabatan_fungsional_tertentu?nama=') ?>" + selectedText,
								method: 'GET',
								success: function(response) {
									klsjabatan.value = response[0].id_jabatan_tpp;
									ketbup.value = response[0].BUP_USIA;
								}
							})
						});

					},
					error: function() {
						console.log('Error occurred while retrieving data from the API.');
					}
				});


				// namajabatan.value = jftIdContainer.textContent;
				//    console.log("nama: "+jftIdContainer.textContent);


			} else if (data_value === '4') {
				dataSelect_jabatan.disabled = true;
				select2Span.style.display = 'block';
				dataSelect_jabatan.removeAttribute('required');
				select2SpanJFU.textContent = '-- Please Select --';
				select2SpanJFU.setAttribute('title', '-- Please Select --');
				dataSelect_jabatan.className = originalClass
					.replace('select3z', '')
					.replace('select3', '');
				jabatandiv.style.display = 'none';
				jfuIdDiv.style.display = 'block';
				jfuIdElement.setAttribute('required', 'required');
				jfuIdElement.disabled = false;
				jftIdDiv.style.display = 'none';
				jftIdElement.disabled = true;
				jftIdElement.removeAttribute('required');
				$("#JABATAN_FUNGSIONAL_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=master_jabatan:id:nm_jabatan|ket') ?>", {
					selected_value: '<?php echo $row["JABATAN_FUNGSIONAL_ID"] ?>'
				});
				$.ajax({
					// url: 'http://localhost:8082/index.php/api/get_master_jabatan_fungsional_umum',
					url: "<?php echo site_url('api/get_master_jabatan_fungsional_umum'); ?>",
					method: 'GET',
					dataType: 'json',
					success: function(data) {
						// // Parse the JSON response


						var options = '';
						var kelas_jabatan_tpp4 = '';
						$.each(data, function(index, item) {
							// Create option elements
							options += '<option value="' + item.JFU_SIASN_ID + '">' + item.NAMA + '</option>';
						});
						// Append options to the select element
						$('#JFU_ID_SAPK').append(options);

						// Event listener for select change
						$('#JFU_ID_SAPK').on('change', function() {
							var selectedOption4 = $(this).find('option:selected');
							var selectedText4 = selectedOption4.text();
							$('#NAMA').val(selectedText4);
							dataSelect_jabatan.innerHTML = '';
							const option = document.createElement('option');
							option.value = selectedOption4.val();
							option.text = selectedText4;
							dataSelect_jabatan.appendChild(option);
							select2Span.textContent = selectedText4;
							select2Span.setAttribute('title', selectedText4);
							jfunama.value = selectedText4;
							$.ajax({
								// url: 'http://localhost:8082/index.php/api/get_master_jabatan_fungsional_umum?nama='+selectedText4,
								url: "<?php echo site_url('api/get_master_jabatan_fungsional_umum?nama=') ?>" + selectedText4,
								method: 'GET',
								success: function(response) {
									klsjabatan.value = response[0].id_jabatan_tpp;
									ketbup.value = response[0].BUP_USIA;
								}
							})
						});

					},
					error: function() {
						console.log('Error occurred while retrieving data from the API.');
					}
				});
				// $("#JFU_ID_SAPK").jCombo("<?php echo site_url('mutasi/comboselect?filter=master_jabatan_fungsional_umum:JFU_SIASN_ID:NAMA') ?>",{  selected_value : '<?php echo $row["JFU_ID_SAPK"] ?>' });

			} else {
				dataSelect_jabatan.innerHTML = '';
				const option = document.createElement('option');
				option.value = '-';
				option.text = '-';
				dataSelect_jabatan.disabled = true;
				select2Span.style.display = 'none';
				dataSelect_jabatan.className = originalClass
					.replace('select3z', '')
					.replace('select3', '');
				jfuIdDiv.style.display = 'none';
				jfuIdElement.removeAttribute('required', 'required');
				jfuIdElement.disabled = true;
				jftIdDiv.style.display = 'none';
				jftIdElement.disabled = true;
				jftIdElement.removeAttribute('required');
			}

			var observer = new MutationObserver(function(mutationsList) {
				for (var mutation of mutationsList) {
					if (mutation.type === "attributes" && mutation.attributeName === "value") {
						var updatedValue = mutation.target.value;
						// console.log("<?php echo site_url('api/get_master_satker?id=') ?>"+updatedValue);
						$.ajax({
							// url: "http://localhost:8082/index.php/api/get_master_satker?id="+updatedValue,
							url: "<?php echo site_url('api/get_master_satker?id=') ?>" + updatedValue,
							dataType: "json",
							success: function(response) {

								idjabatansatker = response[0].SATKER_ID;

								unorid.value = response[0].SATKER_ID;
								unornama.value = response[0].NAMA;
								// satkeridsapk.value = response[0].SATKER_ID_SAPK;
								// console.log("Nama Unor:", response[0].NAMA);
								if (data_value === '1') {
									namaJabatan = response[0].NAMA_JABATAN;
									kelas_jabatan_tpp = response[0].id_jabatan_tpp;
									dataSelect_jabatan.innerHTML = '';
									const option = document.createElement('option');
									option.value = idjabatansatker;
									option.text = namaJabatan;
									dataSelect_jabatan.disabled = false;
									dataSelect_jabatan.appendChild(option);
									select2Span.textContent = namaJabatan;
									select2Span.setAttribute('title', namaJabatan);
									jftIdDiv.style.display = 'none';
									jftIdElement.disabled = true;
									jftIdElement.removeAttribute('required');
									jfuIdDiv.style.display = 'none';
									jfuIdElement.disabled = true;
									jfuIdElement.removeAttribute('required');
									namajabatan.value = namaJabatan;
									klsjabatan.value = kelas_jabatan_tpp;
									ketbup.value = response[0].BUP_USIA;
								}
							}
						});

					}
				}
			});
			observer.observe(get_satker, {
				attributes: true
			});


		});
		var frm = $('form');
		$("#kirimdata").click(function() {
			//var data = frm.serialize();
			var form_data = new FormData(frm[0]);
			//var files = $('#FILE_PDF')[0].files;
			//form_data.append('FILE_PDF', files[0]);

			if (!frm.valid()) return false;

			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: form_data,
				cache: false,
				processData: false,
				contentType: false,
				success: function(data) {
					// Execute the controller code
					var jabatanRiwayatId = <?php echo json_encode($row['JABATAN_RIWAYAT_ID']); ?>;
					var url = "<?php echo site_url(); ?>";
					if (jabatanRiwayatId != "") {
						$.ajax({
							type: 'GET',
							// url: 'http://localhost:8082/index.php/mutasi/postSiasn/'+jabatanRiwayatId, 
							url: url + '/mutasi/postSiasn/' + jabatanRiwayatId, // Replace 'controller' with the actual URL to your controller
							success: function(response) {
								// Handle the response from the controller code
								console.log("postSIASN Success");
							}
						});
					}
					alert('Data Berhasil Disimpan !!!');
					// alert(data);
					table.ajax.reload();
					$('#form-ajax').html("");
				}
			});
		});
		// frm.submit(function (ev) {
		//     $.ajax({
		//         type: frm.attr('method'),
		//         url: frm.attr('action'),
		//         data: frm.serialize(),
		//         success: function (data) {
		//             alert('Data Berhasil Disimpan !!');
		//              table.ajax.reload();
		//               $('#form-ajax').html("");
		//         }
		//     });
		//     ev.preventDefault();
		// });


		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});

		$("#JENIS_JABATAN_SAPK").jCombo("<?php echo site_url('mutasi/comboselect?filter=jenis_jabatan:ID:NAMA') ?>", {
			selected_value: '<?php echo $row["JENIS_JABATAN_SAPK"] ?>'
		});

		$("#SATKER_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=satker:SATKER_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["SATKER_ID"] ?>'
		});

		$("#ESELON_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=eselon:ESELON_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["ESELON_ID"] ?>'
		});




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>



	});

	function getsatker(id = 0) {
		SximoModal("<?php echo site_url('pegawai/satkerpilih') ?>", "SATKER");
	}

	function validateForm() {
		const jenis_jabatan = document.getElementById('JENIS_JABATAN_SAPK');
		const data_value = jenis_jabatan.value;
		if (data_value === '2') {
			var JFT_ID_SAPK = document.getElementById("JFT_ID_SAPK");
			var isEmptyJFT = JFT_ID_SAPK && JFT_ID_SAPK.value === "";
		} else if (data_value === '4') {
			var JFU_ID_SAPK = document.getElementById("JFU_ID_SAPK");
			var isEmptyJFU = JFU_ID_SAPK && JFU_ID_SAPK.value === "";
		} else if (data_value === '1') {
			var JABATAN_FUNGSIONAL_ID = document.getElementById("JABATAN_FUNGSIONAL_ID");
			var isEmptyJabfung = JABATAN_FUNGSIONAL_ID && JABATAN_FUNGSIONAL_ID.value === "";
		}
		var PEJABAT_PENETAP_ID = document.getElementById("PEJABAT_PENETAP_ID");
		var NO_SK = document.getElementById("NO_SK");
		var JENIS_JABATAN_SAPK = document.getElementById("JENIS_JABATAN_SAPK");
		var SATKER_ID = document.getElementById("SATKER_ID");
		var TMT_JABATAN = document.getElementById("TMT_JABATAN");
		var FILE_PDF = document.getElementById("FILE_PDF");
		var isEmptyInputPejabat = PEJABAT_PENETAP_ID && PEJABAT_PENETAP_ID.value === "";
		var isEmptyNoSK = NO_SK && NO_SK.value === "";
		var isEmptyJenisJabatan = JENIS_JABATAN_SAPK && JENIS_JABATAN_SAPK.value === "";
		var isEmptySatker = SATKER_ID && SATKER_ID.value === "";
		var isEmptyTMTJabatan = TMT_JABATAN && TMT_JABATAN.value === "";
		var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

		if (data_value === '2') {
			var errorMessage = isEmptyInputPejabat && isEmptyNoSK && isEmptyJenisJabatan && isEmptySatker && isEmptyTMTJabatan && isEmptyFile ?
				"Mohon kolom Pejabat Penetap, No SK, Jenis Jabatan SAPK, Satuan Kerja, TMT Jabatan, dan Dokumen SK Jabatan harap diisi." :
				isEmptyInputPejabat ?
				"Mohon kolom Pejabat Penetap diisi." :
				isEmptyNoSK ?
				"Mohon kolom No SK diisi." :
				isEmptyJenisJabatan ?
				"Mohon kolom Jenis Jabatan SAPK diisi" :
				isEmptySatker ?
				"Mohon kolom Satuan Kerja diisi" :
				isEmptyTMTJabatan ?
				"Mohon TMT Jabatan harap diisi" :
				isEmptyFile ?
				"Mohon Dokumen SK KP harap diisi" :
				"";
		} else if (data_value === '4') {
			var errorMessage = isEmptyInputPejabat && isEmptyNoSK && isEmptyJenisJabatan && isEmptySatker && isEmptyTMTJabatan && isEmptyFile ?
				"Mohon kolom Pejabat Penetap, No SK, Jenis Jabatan SAPK, Satuan Kerja, TMT Jabatan, dan Dokumen SK Jabatan harap diisi." :
				isEmptyInputPejabat ?
				"Mohon kolom Pejabat Penetap diisi." :
				isEmptyNoSK ?
				"Mohon kolom No SK diisi." :
				isEmptyJenisJabatan ?
				"Mohon kolom Jenis Jabatan SAPK diisi" :
				isEmptySatker ?
				"Mohon kolom Satuan Kerja diisi" :
				isEmptyTMTJabatan ?
				"Mohon TMT Jabatan harap diisi" :
				isEmptyFile ?
				"Mohon Dokumen SK KP harap diisi" :
				"";
		} else if (data_value === '1') {
			var errorMessage = isEmptyInputPejabat && isEmptyNoSK && isEmptyJenisJabatan && isEmptySatker && isEmptyTMTJabatan && isEmptyFile ?
				"Mohon kolom Pejabat Penetap, No SK, Jenis Jabatan SAPK, Satuan Kerja, TMT Jabatan, dan Dokumen SK Jabatan harap diisi." :
				isEmptyInputPejabat ?
				"Mohon kolom Pejabat Penetap diisi." :
				isEmptyNoSK ?
				"Mohon kolom No SK diisi." :
				isEmptyJenisJabatan ?
				"Mohon kolom Jenis Jabatan SAPK diisi" :
				isEmptySatker ?
				"Mohon kolom Satuan Kerja diisi" :
				isEmptyTMTJabatan ?
				"Mohon TMT Jabatan harap diisi" :
				isEmptyFile ?
				"Mohon Dokumen SK KP harap diisi" :
				"";
		} else {
			var errorMessage = isEmptyInputPejabat && isEmptyNoSK && isEmptyJenisJabatan && isEmptySatker && isEmptyJabfung && isEmptyTMTJabatan && isEmptyFile ?
				"Mohon kolom Pejabat Penetap, No SK, Jenis Jabatan SAPK, Satuan Kerja, Jabatan, TMT Jabatan, dan Dokumen SK Jabatan harap diisi." :
				isEmptyInputPejabat ?
				"Mohon kolom Pejabat Penetap diisi." :
				isEmptyNoSK ?
				"Mohon kolom No SK diisi." :
				isEmptyJenisJabatan ?
				"Mohon kolom Jenis Jabatan SAPK diisi" :
				isEmptySatker ?
				"Mohon kolom Satuan Kerja diisi" :
				isEmptyJabfung ?
				"Mohon kolom Jabatan diisi" :
				isEmptyTMTJabatan ?
				"Mohon TMT Jabatan harap diisi" :
				isEmptyFile ?
				"Mohon Dokumen SK KP harap diisi" :
				"";
		}

		if (errorMessage) {
			alert(errorMessage);
			return false;
		}

		return true;
	}
</script>