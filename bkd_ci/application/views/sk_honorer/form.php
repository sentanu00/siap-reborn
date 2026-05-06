<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('sk_honorer/save/' . $row['JABATAN_RIWAYAT_ID']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

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
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="TMT JABATAN" class=" control-label col-md-4 text-left"> TMT JABATAN <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_JABATAN']; ?>' name='TMT_JABATAN' style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TANGGAL SK" class=" control-label col-md-4 text-left"> TANGGAL SK </label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NO SK" class=" control-label col-md-4 text-left"> NO SK <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PEJABAT PENETAP" class=" control-label col-md-4 text-left"> PEJABAT PENETAP </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEJABAT_PENETAP']; ?>' name='PEJABAT_PENETAP' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="LAST CREATE USER" class=" control-label col-md-4 text-left"> LAST CREATE USER </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_CREATE_USER']; ?>' name='LAST_CREATE_USER' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="LAST CREATE DATE" class=" control-label col-md-4 text-left"> LAST CREATE DATE </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_CREATE_DATE']; ?>' name='LAST_CREATE_DATE' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="LAST UPDATE USER" class=" control-label col-md-4 text-left"> LAST UPDATE USER </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_UPDATE_USER']; ?>' name='LAST_UPDATE_USER' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="LAST UPDATE DATE" class=" control-label col-md-4 text-left"> LAST UPDATE DATE </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_UPDATE_DATE']; ?>' name='LAST_UPDATE_DATE' /> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<!-- <div class="form-group row  ">
						<label for="SATKER" class=" control-label col-md-4 text-left"> SATKER <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['SATKER']; 
																									?>' name='SATKER' required /> <br />
							<i> <small></small></i>
						</div>
					</div> -->

					<!-- start sataun kerja baru -->
					<div class="form-group row">
						<label for="SATKER" class="control-label col-md-4 text-left"> SATKER <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' id='SATKER' placeholder='' value='<?php echo $row['SATKER']; ?>' name='SATKER' required /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<!-- start sataun kerja baru -->

					<div class="form-group row  ">
						<label for="JABATAN" class=" control-label col-md-4 text-left"> JABATAN <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="GAJI" class=" control-label col-md-4 text-left"> GAJI </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GAJI']; ?>' name='GAJI' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">

						<!-- <label for="FILE PDF" class=" control-label col-md-4 text-left"> FILE SK (PDF) </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['FILE_PDF']; 
																									?>' name='FILE_PDF' /> <br />
							<i> <small></small></i>
						</div> -->

						<!-- start file pdf pendidikan -->

						<label for="ipt" class=" control-label col-md-4 text-left "> FILE SK (PDF) <span class="asterix"> * </span> </label>
						<div class="col-md-5">
							<!-- <input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF"> -->
							<!-- <input type="file" class="form-control input-sm" required id="FILE_PDF" name="FILE_PDF" accept=".pdf" onchange="checkFileSize(this)"> -->
							<input type="file" class="form-control input-sm" id="FILE_PDF" name="FILE_PDF" accept=".pdf" onchange="checkFileSize('FILE_PDF', 'fileSizeErrorFilePdf')">
							<!-- <input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf" /> -->

							<!-- <span id="fileSizeErrorFilePdf" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 2 MB.</span> -->
							<span id="fileSizeErrorFilePdf" style="color: red; display: none;">Ukuran file tidak boleh lebih dari 2 MB.</span>

							<input type="hidden" name="file_pdf_cek" value="<?php echo $row['FILE_PDF']; ?>" />
							<!-- <input type="hidden" name="FILE_PDF" value="<?php //echo $row['FILE_PDF']; 
																				?>" /> -->
							<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />

						</div>
						<div class="col-md-2">
							<?
							if ($row['FILE_PDF'] != '') {
								echo '<a href="javascript:SximoModal(\'' . site_url('sk_honorer/viewfile') . '/FILE_PDF/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							// if($row['FILE_PDF'] != ''){
							// 	echo '<br /><a href="javascript:SximoModal(\'' . site_url('skcpns/viewfile') . '/FILE_PDF/' . $row['SK_CPNS_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
							// 	}
							?>
						</div>

						<!-- end file pdf pendidikan -->
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



	$(document).ready(function() {

		var frm = $('form');
		$("#kirimdata").click(function() {
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


	function validateForm() {

		var SATKER = document.getElementById("SATKER");
		var NO_SK = document.getElementById("NO_SK");
		var TMT_JABATAN = document.getElementById("TMT_JABATAN");
		// var FILE_PDF = document.getElementById("FILE_PDF");

		var isEmptySatker = SATKER && SATKER.value === "";
		var isEmptyNoSK = NO_SK && NO_SK.value === "";
		var isEmptytMTjABATAN = TMT_JABATAN && TMT_JABATAN.value === "";
		// var isEmptyFilePDF = FILE_PDF && FILE_PDF.value === "";

		// var errorMessage = isEmptySatker && isEmptyNoSK && isEmptytMTjABATAN && isEmptyFilePDF ?
		var errorMessage = isEmptySatker && isEmptyNoSK && isEmptytMTjABATAN ?
			"Mohon kolom bertanda merah harap diisi." :
			isEmptySatker ?
			"Mohon kolom Satker diisi." :
			isEmptyNoSK ?
			"Mohon kolom No SK diisi." :
			isEmptytMTjABATAN ?
			"Mohon kolom TMT diisi" :
			"";



		if (errorMessage) {
			alert(errorMessage);
			return false;
		}

		return true;
	}

	$(document).ready(function() {
		var satkerData = [{
				label: "ASISTEN PEMERINTAHAN DAN KESEJAHTERAAN RAKYAT",
				value: "ASISTEN PEMERINTAHAN DAN KESEJAHTERAAN RAKYAT"
			},
			{
				label: "BAGIAN PEMERINTAHAN",
				value: "BAGIAN PEMERINTAHAN"
			},
			{
				label: "BAGIAN HUKUM",
				value: "BAGIAN HUKUM"
			},
			{
				label: "BAGIAN KESEJAHTERAAN RAKYAT",
				value: "BAGIAN KESEJAHTERAAN RAKYAT"
			},
			{
				label: "ASISTEN PEREKONOMIAN PEMBANGUNAN",
				value: "ASISTEN PEREKONOMIAN PEMBANGUNAN"
			},
			{
				label: "BAGIAN ADMINISTRASI PEMBANGUNAN",
				value: "BAGIAN ADMINISTRASI PEMBANGUNAN"
			},
			{
				label: "BAGIAN PENGADAAN BARANG DAN JASA",
				value: "BAGIAN PENGADAAN BARANG DAN JASA"
			},
			{
				label: "BAGIAN PEREKONOMIAN dan SUMBER DAYA ALAM",
				value: "BAGIAN PEREKONOMIAN dan SUMBER DAYA ALAM"
			},
			{
				label: "ASISTEN ADMINISTRASI UMUM",
				value: "ASISTEN ADMINISTRASI UMUM"
			},
			{
				label: "BAGIAN UMUM",
				value: "BAGIAN UMUM"
			},
			{
				label: "BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN",
				value: "BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN"
			},
			{
				label: "BAGIAN ORGANISASI",
				value: "BAGIAN ORGANISASI"
			},
			{
				label: "STAF AHLI BIDANG EKONOMI DAN KEUANGAN",
				value: "STAF AHLI BIDANG EKONOMI DAN KEUANGAN"
			},
			{
				label: "STAF AHLI BIDANG KEMASYARAKATAN DAN SDM",
				value: "STAF AHLI BIDANG KEMASYARAKATAN DAN SDM"
			},
			{
				label: "STAF AHLI BIDANG HUKUM, PEMERINTAHAN dan PEMBANGUNAN",
				value: "STAF AHLI BIDANG HUKUM, PEMERINTAHAN dan PEMBANGUNAN"
			},
			{
				label: "SEKRETARIAT DPRD",
				value: "SEKRETARIAT DPRD"
			},
			{
				label: "DINAS PENDIDIKAN DAN KEBUDAYAAN",
				value: "DINAS PENDIDIKAN DAN KEBUDAYAAN"
			},
			{
				label: "DINAS KESEHATAN",
				value: "DINAS KESEHATAN"
			},
			{
				label: "Unit Organisasi Bersifat Khusus RSUD Tongas",
				value: "Unit Organisasi Bersifat Khusus RSUD Tongas"
			},
			{
				label: "Unit Organisasi Bersifat Khusus RSUD Waluyo Jati",
				value: "Unit Organisasi Bersifat Khusus RSUD Waluyo Jati"
			},
			{
				label: "DINAS SOSIAL",
				value: "DINAS SOSIAL"
			},
			{
				label: "DINAS TENAGA KERJA",
				value: "DINAS TENAGA KERJA"
			},
			{
				label: "DINAS PERHUBUNGAN",
				value: "DINAS PERHUBUNGAN"
			},
			{
				label: "DINAS KEPENDUDUKAN dan PENCATATAN SIPIL",
				value: "DINAS KEPENDUDUKAN dan PENCATATAN SIPIL"
			},
			{
				label: "DINAS PEKERJAAN UMUM dan PENATAAN RUANG",
				value: "DINAS PEKERJAAN UMUM dan PENATAAN RUANG"
			},
			{
				label: "DINAS PERUMAHAN, KAWASAN PERMUKIMAN dan PERTANAHAN",
				value: "DINAS PERUMAHAN, KAWASAN PERMUKIMAN dan PERTANAHAN"
			},
			{
				label: "DINAS KOPERASI, USAHA MIKRO, PERDAGANGAN DAN PERINDUSTRIAN",
				value: "DINAS KOPERASI, USAHA MIKRO, PERDAGANGAN DAN PERINDUSTRIAN"
			},
			{
				label: "DINAS PERIKANAN",
				value: "DINAS PERIKANAN"
			},
			{
				label: "DINAS KEPEMUDAAN, OLAH RAGA DAN PARIWISATA",
				value: "DINAS KEPEMUDAAN, OLAH RAGA DAN PARIWISATA"
			},
			{
				label: "BADAN PENGELOLAAN PENDAPATAN, KEUANGAN DAN ASET DAERAH",
				value: "BADAN PENGELOLAAN PENDAPATAN, KEUANGAN DAN ASET DAERAH"
			},
			{
				label: "DINAS KOMUNIKASI, INFORMATIKA, STATISTIK DAN PERSANDIAN",
				value: "DINAS KOMUNIKASI, INFORMATIKA, STATISTIK DAN PERSANDIAN"
			},
			{
				label: "INSPEKTORAT DAERAH",
				value: "INSPEKTORAT DAERAH"
			},
			{
				label: "BADAN PERENCANAAN, PENELITIAN DAN PENGEMBANGAN DAERAH",
				value: "BADAN PERENCANAAN, PENELITIAN DAN PENGEMBANGAN DAERAH"
			},
			{
				label: "BADAN KESATUAN BANGSA DAN POLITIK",
				value: "BADAN KESATUAN BANGSA DAN POLITIK"
			},
			{
				label: "DINAS LINGKUNGAN HIDUP",
				value: "DINAS LINGKUNGAN HIDUP"
			},
			{
				label: "DINAS KETAHANAN PANGAN",
				value: "DINAS KETAHANAN PANGAN"
			},
			{
				label: "DINAS PEMBERDAYAAN MASYARAKAT DAN DESA",
				value: "DINAS PEMBERDAYAAN MASYARAKAT DAN DESA"
			},
			{
				label: "DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK, PENGENDALIAN PENDUDUK, DAN KELUARGA BERENCANA",
				value: "DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK, PENGENDALIAN PENDUDUK, DAN KELUARGA BERENCANA"
			},
			{
				label: "BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA",
				value: "BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA"
			},
			{
				label: "DINAS PERPUSTAKAAN DAN KEARSIPAN",
				value: "DINAS PERPUSTAKAAN DAN KEARSIPAN"
			},
			{
				label: "DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU",
				value: "DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU"
			},
			{
				label: "SATUAN POLISI PAMONG PRAJA ",
				value: "SATUAN POLISI PAMONG PRAJA "
			},
			{
				label: "KECAMATAN TONGAS",
				value: "KECAMATAN TONGAS"
			},
			{
				label: "KECAMATAN SUMBERASIH",
				value: "KECAMATAN SUMBERASIH"
			},
			{
				label: "KECAMATAN WONOMERTO",
				value: "KECAMATAN WONOMERTO"
			},
			{
				label: "KECAMATAN SUKAPURA",
				value: "KECAMATAN SUKAPURA"
			},
			{
				label: "KECAMATAN LUMBANG",
				value: "KECAMATAN LUMBANG"
			},
			{
				label: "KECAMATAN KURIPAN",
				value: "KECAMATAN KURIPAN"
			},
			{
				label: "KECAMATAN SUMBER",
				value: "KECAMATAN SUMBER"
			},
			{
				label: "KECAMATAN LECES",
				value: "KECAMATAN LECES"
			},
			{
				label: "KECAMATAN BANTARAN",
				value: "KECAMATAN BANTARAN"
			},
			{
				label: "KECAMATAN TEGALSIWALAN",
				value: "KECAMATAN TEGALSIWALAN"
			},
			{
				label: "KECAMATAN GENDING",
				value: "KECAMATAN GENDING"
			},
			{
				label: "KECAMATAN BANYUANYAR",
				value: "KECAMATAN BANYUANYAR"
			},
			{
				label: "KECAMATAN MARON",
				value: "KECAMATAN MARON"
			},
			{
				label: "KECAMATAN DRINGU",
				value: "KECAMATAN DRINGU"
			},
			{
				label: "KECAMATAN KRAKSAAN",
				value: "KECAMATAN KRAKSAAN"
			},
			{
				label: "KECAMATAN KREJENGAN",
				value: "KECAMATAN KREJENGAN"
			},
			{
				label: "KECAMATAN BESUK",
				value: "KECAMATAN BESUK"
			},
			{
				label: "KECAMATAN PAJARAKAN",
				value: "KECAMATAN PAJARAKAN"
			},
			{
				label: "KECAMATAN GADING",
				value: "KECAMATAN GADING"
			},
			{
				label: "KECAMATAN TIRIS",
				value: "KECAMATAN TIRIS"
			},
			{
				label: "KECAMATAN KRUCIL",
				value: "KECAMATAN KRUCIL"
			},
			{
				label: "KECAMATAN PAITON",
				value: "KECAMATAN PAITON"
			},
			{
				label: "KECAMATAN KOTAANYAR",
				value: "KECAMATAN KOTAANYAR"
			},
			{
				label: "KECAMATAN PAKUNIRAN",
				value: "KECAMATAN PAKUNIRAN"
			},
			{
				label: "BADAN PENANGGULANGAN BENCANA DAERAH ",
				value: "BADAN PENANGGULANGAN BENCANA DAERAH "
			},
			{
				label: "DINAS PERTANIAN",
				value: "DINAS PERTANIAN"
			},

		];

		$("#SATKER").autocomplete({
			source: function(request, response) {
				var results = $.ui.autocomplete.filter(satkerData, request.term);
				response(results.slice(0, 5)); // Limiting the results to 2 items
			},
		}).focus(function() {
			$(this).autocomplete("search", ""); // This triggers the dropdown to appear immediately
		});
	});
</script>