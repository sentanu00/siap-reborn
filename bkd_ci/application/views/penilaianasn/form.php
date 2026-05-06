<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('penilaianasn/save/' . $row['PENILAIAN_SKP_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PENILAIAN SKP ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENILAIAN_SKP_ID']; ?>' name='PENILAIAN_SKP_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> ORIENTASI NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['ORIENTASI_NILAI']; ?>' name='ORIENTASI_NILAI' id='ORIENTASI_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> INTEGRITAS NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['INTEGRITAS_NILAI']; ?>' name='INTEGRITAS_NILAI' id='INTEGRITAS_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KERJASAMA NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['KERJASAMA_NILAI']; ?>' name='KERJASAMA_NILAI' id='KERJASAMA_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TAHUN <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['TAHUN']; ?>' name='TAHUN' id='TAHUN' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEGAWAI PEJABAT PENILAI NIP <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_PEJABAT_PENILAI_NIP']; ?>' name='PEGAWAI_PEJABAT_PENILAI_NIP' id='PEGAWAI_PEJABAT_PENILAI_NIP' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEGAWAI PEJABAT PENILAI NAMA <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_PEJABAT_PENILAI_NAMA']; ?>' name='PEGAWAI_PEJABAT_PENILAI_NAMA' id='PEGAWAI_PEJABAT_PENILAI_NAMA' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEGAWAI ATASAN PEJABAT NIP <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_ATASAN_PEJABAT_NIP']; ?>' name='PEGAWAI_ATASAN_PEJABAT_NIP' id='PEGAWAI_ATASAN_PEJABAT_NIP' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEGAWAI ATASAN PEJABAT NAMA <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_ATASAN_PEJABAT_NAMA']; ?>' name='PEGAWAI_ATASAN_PEJABAT_NAMA' id='PEGAWAI_ATASAN_PEJABAT_NAMA' required/>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KOMITMEN NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['KOMITMEN_NILAI']; ?>' name='KOMITMEN_NILAI' id='KOMITMEN_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> DISIPLIN NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['DISIPLIN_NILAI']; ?>' name='DISIPLIN_NILAI' id='DISIPLIN_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KEPEMIMPINAN NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KEPEMIMPINAN_NILAI']; ?>' name='KEPEMIMPINAN_NILAI' id='KEPEMIMPINAN_NILAI' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PERILAKU NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PERILAKU_NILAI']; ?>' name='PERILAKU_NILAI' id='PERILAKU_NILAI' required />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> RATA NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['RATA_NILAI']; ?>' name='RATA_NILAI' id='RATA_NILAI'/>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JUMLAH NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['JUMLAH_NILAI']; ?>' name='JUMLAH_NILAI' id='JUMLAH_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SKP NILAI <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['SKP_NILAI']; ?>' name='SKP_NILAI' id='SKP_NILAI' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SKP HASIL <span class="asterix">*</span> </label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['SKP_HASIL']; ?>' name='SKP_HASIL' id='SKP_HASIL' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PERILAKU HASIL <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' placeholder='' required value='<?php echo $row['PERILAKU_HASIL']; ?>' name='PERILAKU_HASIL' id='PERILAKU_HASIL' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PRESTASI HASIL <span class="asterix">*</span></label>
						<input type='text' class='form-control input-sm' required placeholder='' value='<?php echo $row['PRESTASI_HASIL']; ?>' name='PRESTASI_HASIL' id='PRESTASI_HASIL' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> LAMPIRAN <span class="asterix">*</span></label>
						<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF"  value="<?php echo $row['FILE_PDF']; ?>" />
							
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('penilaianasn/viewfile') . '/FILE_PDF/' . $row['PENILAIAN_SKP_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
							}
							?>
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




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});

	function validateForm() {
    var TAHUN = document.getElementById("TAHUN");
	var ORIENTASI_NILAI = document.getElementById("ORIENTASI_NILAI");
	var INTEGRITAS_NILAI = document.getElementById("INTEGRITAS_NILAI");
	var KERJASAMA_NILAI = document.getElementById("KERJASAMA_NILAI");
	var PEGAWAI_PEJABAT_PENILAI_NIP = document.getElementById("PEGAWAI_PEJABAT_PENILAI_NIP");
	var PEGAWAI_PEJABAT_PENILAI_NAMA = document.getElementById("PEGAWAI_PEJABAT_PENILAI_NAMA");
	var PEGAWAI_ATASAN_PEJABAT_NIP = document.getElementById("PEGAWAI_ATASAN_PEJABAT_NIP");
	var PEGAWAI_ATASAN_PEJABAT_NAMA = document.getElementById("PEGAWAI_ATASAN_PEJABAT_NAMA");
	var KOMITMEN_NILAI = document.getElementById("KOMITMEN_NILAI");
	var DISIPLIN_NILAI = document.getElementById("DISIPLIN_NILAI");
	var KEPEMIMPINAN_NILAI = document.getElementById("KEPEMIMPINAN_NILAI");
	var PERILAKU_NILAI = document.getElementById("PERILAKU_NILAI");
	var RATA_NILAI = document.getElementById("RATA_NILAI");
	var JUMLAH_NILAI = document.getElementById("JUMLAH_NILAI");
	var SKP_NILAI = document.getElementById("SKP_NILAI");
	var PERILAKU_HASIL = document.getElementById("PERILAKU_HASIL");
	var PRESTASI_HASIL = document.getElementById("PRESTASI_HASIL");
	var SKP_HASIL = document.getElementById("SKP_HASIL");
	var FILE_PDF = document.getElementById("FILE_PDF");

    var isEmptyTahun = TAHUN && TAHUN.value === "";
	var isEmptyOrientasi= ORIENTASI_NILAI && ORIENTASI_NILAI.value === "";
	var isEmptyIntegritas= INTEGRITAS_NILAI && INTEGRITAS_NILAI.value === "";
	var isEmptyKerjasama= KERJASAMA_NILAI && KERJASAMA_NILAI.value === "";
	var isEmptyPPPNip= PEGAWAI_PEJABAT_PENILAI_NIP && PEGAWAI_PEJABAT_PENILAI_NIP.value === "";
	var isEmptyPPPNama= PEGAWAI_PEJABAT_PENILAI_NAMA && PEGAWAI_PEJABAT_PENILAI_NAMA.value === "";
	var isEmptyPAPNip= PEGAWAI_ATASAN_PEJABAT_NIP && PEGAWAI_ATASAN_PEJABAT_NIP.value === "";
	var isEmptyPAPNama= PEGAWAI_ATASAN_PEJABAT_NAMA && PEGAWAI_ATASAN_PEJABAT_NAMA.value === "";
	var isEmptyKomitmen= KOMITMEN_NILAI && KOMITMEN_NILAI.value === "";
	var isEmptyDisiplin= DISIPLIN_NILAI && DISIPLIN_NILAI.value === "";
	var isEmptyKepemimpinan= KEPEMIMPINAN_NILAI && KEPEMIMPINAN_NILAI.value === "";
	var isEmptyPerilaku= PERILAKU_NILAI && PERILAKU_NILAI.value === "";
	var isEmptyRataNilai= RATA_NILAI && RATA_NILAI.value === "";
	var isEmptyJumlahNilai= JUMLAH_NILAI && JUMLAH_NILAI.value === "";
	var isEmptySKPNilai= SKP_NILAI && SKP_NILAI.value === "";
	var isEmptyPerilakuHasil= PERILAKU_HASIL && PERILAKU_HASIL.value === "";
	var isEmptyPrestasiHasil= PRESTASI_HASIL && PRESTASI_HASIL.value === "";
	var isEmptySKPHasil= SKP_HASIL && SKP_HASIL.value === "";
	var isEmptyFile = FILE_PDF && FILE_PDF.value === "";

    var errorMessage = isEmptyTahun && isEmptyOrientasi && isEmptyIntegritas && isEmptyKerjasama && isEmptyPPPNip && isEmptyPPPNama && isEmptyPAPNip && isEmptyPAPNama && isEmptyKomitmen && isEmptyDisiplin && isEmptyKepemimpinan && isEmptyPerilaku && isEmptyRataNilai && isEmptyJumlahNilai && isEmptySKPNilai && isEmptyPerilakuHasil && isEmptyPrestasiHasil && isEmptySKPHasil && isEmptyFile
    ? "Mohon semua kolom inputan harap diisi."
        : isEmptyTahun
        ? "Mohon kolom Tahun diisi."
			: isEmptyOrientasi
			? "Mohon kolom Orientasi Nilai diisi."
				: isEmptyIntegritas
				? "Mohon kolom Integritas Nilai diisi."
					: isEmptyKerjasama
					? "Mohon kolom Kerja Sama Nilai diisi."
						: isEmptyPPPNip
						? "Mohon kolom PEGAWAI PEJABAT PENILAI NIP diisi."
							: isEmptyPPPNama
							? "Mohon kolom PEGAWAI PEJABAT PENILAI NAMA  diisi."
								: isEmptyPAPNip
								? "Mohon kolom PEGAWAI ATASAN PEJABAT NIP diisi."
									: isEmptyPAPNama
									? "Mohon kolom PEGAWAI ATASAN PEJABAT NAMA diisi."
										: isEmptyKomitmen
										? "Mohon kolom Komitmen Nilai diisi."
											: isEmptyDisiplin
											? "Mohon kolom Disiplin Nilai diisi."
												: isEmptyKepemimpinan
												? "Mohon kolom Kepemimpinan Nilai diisi."
													: isEmptyPerilaku
													? "Mohon kolom Perilaku Nilai diisi."
														: isEmptyRataNilai
														? "Mohon kolom Rata Nilai diisi."
															: isEmptyJumlahNilai
															? "Mohon kolom Jumlah Nilai diisi."
																: isEmptySKPNilai
																? "Mohon kolom SKP Nilai diisi."
																	: isEmptyPerilakuHasil
																	? "Mohon kolom Perilaku Hasil diisi."
																		: isEmptyPrestasiHasil
																		? "Mohon kolom Prestasi Hasil diisi."
																			: isEmptySKPHasil
																			? "Mohon kolom SKP Hasil diisi."
																				: isEmptyFile
																				? "Mohon Lampiran harap diisi"
																					: "";

    if (errorMessage) {
        alert(errorMessage);
        return false;
    }

    return true;
}
</script>