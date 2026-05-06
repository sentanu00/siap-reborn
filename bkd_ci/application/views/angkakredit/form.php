<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('angkakredit/save/' . $row['riwayat_angka_kredit_id']); ?>" class='form-horizontal'
			parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row hidethis " style="display:none;">
						<label for="Riwayat Angka Kredit Id" class=" control-label col-md-4 text-left"> Riwayat Angka Kredit Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['riwayat_angka_kredit_id']; ?>' name='riwayat_angka_kredit_id' /> <br />
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
						<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id']; ?>' name='id' /> <br />
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
					<div class="form-group row hidethis " style="display:none;">
						<label for="NamaJabatan" class=" control-label col-md-4 text-left"> NamaJabatan </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['namaJabatan']; ?>' name='namaJabatan' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="RwJabatanId" class=" control-label col-md-4 text-left"> RwJabatanId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['rwJabatanId']; ?>' name='rwJabatanId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="SkNomor" class=" control-label col-md-4 text-left"> Nomor SK <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skNomor']; ?>' name='skNomor' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Sumber" class=" control-label col-md-4 text-left"> Sumber </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['sumber']; ?>' name='sumber' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="AngkaKreditPenunjang" class=" control-label col-md-4 text-left"> AngkaKreditPenunjang </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['angkaKreditPenunjang']; ?>' name='angkaKreditPenunjang' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="AngkaKreditUtama" class=" control-label col-md-4 text-left"> AngkaKreditUtama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['angkaKreditUtama']; ?>' name='angkaKreditUtama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TotalAngkaKredit" class=" control-label col-md-4 text-left"> Total Angka Kredit <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['totalAngkaKredit']; ?>' name='totalAngkaKredit' required parsley-type='number' oninput="this.value = this.value.replace(',', '.')" /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Dok Uri" class=" control-label col-md-4 text-left"> Dok Uri </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['dok_uri']; ?>' name='dok_uri' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Insert Date" class=" control-label col-md-4 text-left"> Insert Date </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['insert_date']; ?>' name='insert_date' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Update Date" class=" control-label col-md-4 text-left"> Update Date </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['update_date']; ?>' name='update_date' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="HargaId" class=" control-label col-md-4 text-left"> HargaId </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['hargaId']; ?>' name='hargaId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Tahun" class=" control-label col-md-4 text-left"> Tahun </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahun']; ?>' name='tahun' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TahunMulaiPenilaian" class=" control-label col-md-4 text-left"> Tahun Mulai <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahunMulaiPenilaian']; ?>' name='tahunMulaiPenilaian' required parsley-type='number' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="BulanMulaiPenilaian" class=" control-label col-md-4 text-left"> Bulan Mulai <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<?php $bulanMulaiPenilaian = explode(',', $row['bulanMulaiPenilaian']);
							$bulanMulaiPenilaian_opt = array('1' => 'Januari',  '2' => 'Februari',  '3' => 'Maret',  '4' => 'April',  '5' => 'Mei',  '6' => 'Juni',  '7' => 'Juli',  '8' => 'Agustus',  '9' => 'September',  '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',); ?>
							<select name='bulanMulaiPenilaian' rows='5' required class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($bulanMulaiPenilaian_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['bulanMulaiPenilaian'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TahunSelesaiPenilaian" class=" control-label col-md-4 text-left"> Tahun Selesai <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahunSelesaiPenilaian']; ?>' name='tahunSelesaiPenilaian' required parsley-type='number' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="BulanSelesaiPenilaian" class=" control-label col-md-4 text-left"> Bulan Selesai <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<?php $bulanSelesaiPenilaian = explode(',', $row['bulanSelesaiPenilaian']);
							$bulanSelesaiPenilaian_opt = array('1' => 'Januari',  '2' => 'Februari',  '3' => 'Maret',  '4' => 'April',  '5' => 'Mei',  '6' => 'Juni',  '7' => 'Juli',  '8' => 'Agustus',  '9' => 'September',  '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',); ?>
							<select name='bulanSelesaiPenilaian' rows='5' required class='form-control input-sm select2' style='width: 100%;'>
								<?php
								foreach ($bulanSelesaiPenilaian_opt as $key => $val) {
									echo "<option  value ='$key' " . ($row['bulanSelesaiPenilaian'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Status Singkron" class=" control-label col-md-4 text-left"> Status Singkron </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['status_singkron']; ?>' name='status_singkron' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="Sync Date" class=" control-label col-md-4 text-left"> Sync Date </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['sync_date']; ?>' name='sync_date' /> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="SkDate" class=" control-label col-md-4 text-left"> TanggalSK <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['skDate']; ?>' name='skDate'
								style='width:150px !important;' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="IsIntegrasi" class=" control-label col-md-4 text-left"> Integrasi </label>
						<div class="col-md-8">
							<?php $isIntegrasi = explode(",", $row['isIntegrasi']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='isIntegrasi[]' value='1' class=''
									<?php if (in_array('1', $isIntegrasi)) echo 'checked'; ?> /> </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="IsKonversi" class=" control-label col-md-4 text-left"> Konversi </label>
						<div class="col-md-8">
							<?php $isKonversi = explode(",", $row['isKonversi']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='isKonversi[]' value='1' class=''
									<?php if (in_array('1', $isKonversi)) echo 'checked'; ?> /> </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="IsAngkaKreditPertama" class=" control-label col-md-4 text-left"> Angka Kredit Pertama </label>
						<div class="col-md-8">
							<?php $isAngkaKreditPertama = explode(",", $row['isAngkaKreditPertama']); ?>
							<label class='checked checkbox-inline'>
								<input type='checkbox' name='isAngkaKreditPertama[]' value='1' class=''
									<?php if (in_array('1', $isAngkaKreditPertama)) echo 'checked'; ?> /> </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="FILE PDF" class=" control-label col-md-4 text-left"> Dokumen Pendukung </label>
						<div class="col-md-8">
							<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php //echo $row['FILE_PDF']; 
																										?>' name='FILE_PDF' /> <br />
							<i> <small></small></i> -->

							<!-- rubah agar bisa terimafile pdf -->
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
								echo '<br /><a href="javascript:SximoModal(\'' . site_url('angkakredit/viewfile') . '/FILE_PDF/' . $row['riwayat_angka_kredit_id'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
							}
							?>
							<!-- batas rubah -->
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
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});
</script>