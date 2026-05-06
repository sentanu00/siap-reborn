<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('skp22/save/' . $row['skp22_id']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">


			<div class="row">
				<div class="col-md-12">

					<div class="form-group row " style="display:none">
						<label for="Skp22 Id" class=" control-label col-md-4 text-left"> Skp22 Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skp22_id']; ?>' name='skp22_id' id='skp22_id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row" style="display:none">
						<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id']; ?>' name='id' id='id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row" style="display:none">
						<label for="Pegawai Id" class=" control-label col-md-4 text-left"> Pegawai Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' id='PEGAWAI_ID' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="Nip Baru" class=" control-label col-md-4 text-left"> NIP Baru </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nip_baru']; ?>' name='nip_baru' readonly /> <br />
							<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $NIP_BARU; ?>' name='nip_baru' /> <br /> -->
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="HasilKinerja" class="control-label col-md-4 text-left">Hasil Kinerja</label>
						<div class="col-md-8">
							<select class="form-control input-sm" name="hasilKinerja" id="hasilKinerja">
								<option value="DIBAWAH EKSPEKTASI" <?php if ($row['hasilKinerja'] === 'DIBAWAH EKSPEKTASI') echo 'selected'; ?>>DIBAWAH EKSPEKTASI</option>
								<option value="SESUAI EKSPEKTASI" <?php if ($row['hasilKinerja'] === 'SESUAI EKSPEKTASI') echo 'selected'; ?>>SESUAI EKSPEKTASI</option>
								<option value="DIATAS EKSPEKTASI" <?php if ($row['hasilKinerja'] === 'DIATAS EKSPEKTASI') echo 'selected'; ?>>DIATAS EKSPEKTASI</option>
							</select>
							<br />
							<i><small></small></i>
						</div>
					</div>

					<div class="form-group row">
						<label for="HasilKinerjaNilai" class="control-label col-md-4 text-left">Nilai Hasil Kinerja</label>
						<div class="col-md-8">
							<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['hasilKinerjaNilai']; ?>" name="hasilKinerjaNilai" id="hasilKinerjaNilai" readonly />
							<br />
							<i><small></small></i>
						</div>
					</div>
					<!-- <div class="form-group row  ">
						<label for="HasilKinerjaNilai" class=" control-label col-md-4 text-left"> Nilai Hasil Kinerja</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['hasilKinerjaNilai']; ?>' name='hasilKinerjaNilai' id='hasilKinerjaNilai' /> <br />
							<i> <small></small></i>
						</div>
					</div> -->



					<div class="form-group row  ">
						<label for="KuadranKinerja" class=" control-label col-md-4 text-left"> Kuadran Kinerja </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['kuadranKinerja']; ?>' name='kuadranKinerja' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KuadranKinerjaNilai" class=" control-label col-md-4 text-left">Nilai Kuadran Kinerja</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KuadranKinerjaNilai']; ?>' name='KuadranKinerjaNilai' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NamaPenilai" class=" control-label col-md-4 text-left"> Nama Penilai </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['namaPenilai']; ?>' name='namaPenilai' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NipNrpPenilai" class=" control-label col-md-4 text-left"> NIP Penilai </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nipNrpPenilai']; ?>' name='nipNrpPenilai' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  " style="display:none">
						<label for="PenilaiGolonganId" class=" control-label col-md-4 text-left"> Penilai Golongan Id</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['penilaiGolonganId']; ?>' name='penilaiGolonganId' id='penilaiGolonganId' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PenilaiJabatanNm" class=" control-label col-md-4 text-left"> Jabatan Penilai</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['penilaiJabatanNm']; ?>' name='penilaiJabatanNm' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  " style="display:none">
						<label for="PenilaiUnorNm" class=" control-label col-md-4 text-left"> UNOR Penilai </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['penilaiUnorNm']; ?>' name='penilaiUnorNm' id='penilaiUnorNm' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="StatusPenilai" class=" control-label col-md-4 text-left"> Status Penilai </label>
						<div class="col-md-8">
							<!-- <input type='text' class='form-control input-sm' placeholder='' value='<?php // echo $row['statusPenilai']; 
																										?>' name='statusPenilai' /> -->
							<select class='form-control input-sm' name='statusPenilai'>
								<option value="ASN" <?php echo ($row['statusPenilai'] == 'ASN') ? 'selected' : ''; ?>>ASN</option>
								<option value="NON ASN" <?php echo ($row['statusPenilai'] == 'NON ASN') ? 'selected' : ''; ?>>NON ASN</option>
							</select>
							<br />
							<br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row">
						<label for="PerilakuKerja" class="control-label col-md-4 text-left">Perilaku Kerja</label>
						<div class="col-md-8">
							<select class="form-control input-sm" name="perilakuKerja" id='perilakuKerja'>
								<option value="DIBAWAH EKSPEKTASI" <?php if ($row['perilakuKerja'] === 'DIBAWAH EKSPEKTASI') echo 'selected'; ?>>DIBAWAH EKSPEKTASI</option>
								<option value="SESUAI EKSPEKTASI" <?php if ($row['perilakuKerja'] === 'SESUAI EKSPEKTASI') echo 'selected'; ?>>SESUAI EKSPEKTASI</option>
								<option value="DIATAS EKSPEKTASI" <?php if ($row['perilakuKerja'] === 'DIATAS EKSPEKTASI') echo 'selected'; ?>>DIATAS EKSPEKTASI</option>
							</select>
							<br />
							<i><small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PerilakuKerjaNilai" class=" control-label col-md-4 text-left"> Nilai Perilaku Kerja</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PerilakuKerjaNilai']; ?>' name='PerilakuKerjaNilai' id='PerilakuKerjaNilai' readonly /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  " style="display:none">
						<label for="PnsDinilaiId" class=" control-label col-md-4 text-left"> PNS Dinilai Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pnsDinilaiId']; ?>' name='pnsDinilaiId' id='pnsDinilaiId' /> <br />
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
						<label for="BulanSKP" class=" control-label col-md-4 text-left"> Bulan </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['bulan']; ?>' name='BulanSKP' id='BulanSKP' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="TipeSKP" class=" control-label col-md-4 text-left"> Tipe SKP </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tipe']; ?>' name='TipeSKP' id='TipeSKP' /> <br />
							<i> <small></small></i>
						</div>
					</div>



					<div class="form-group row  " style="display:none">
						<label for="Update Date" class=" control-label col-md-4 text-left"> Update Date </label>
						<div class="col-md-8">

							<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['update_date']; ?>' name='update_date' id='update_date' style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row " style="display:none">
						<label for="bulan" class=" control-label col-md-4 text-left">Bulan</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['bulan']; ?>' name='bulan' id='bulan' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row " style="display:none">
						<label for="tipe" class=" control-label col-md-4 text-left">Tipe</label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tipe']; ?>' name='tipe' id='tipe' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row " style="display:none">
						<label for="LAST_UPDATE_USER" class=" control-label col-md-4 text-left"> LAST_UPDATE_USER </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_UPDATE_USER']; ?>' name='LAST_UPDATE_USER' id='LAST_UPDATE_USER' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  " style="display:none">
						<label for="Insert Date" class=" control-label col-md-4 text-left"> Insert Date </label>
						<div class="col-md-8">

							<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['insert_date']; ?>' name='insert_date' id='insert_date' style='width:150px !important;' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">

						<label for="Nip Baru" class=" control-label col-md-4 text-left"> Lampiran </label>
						<div class="col-md-8">
							<!-- <input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf"> -->
							<input type='file' class='form-control input-sm' required id="FILE_PDF" name="FILE_PDF" accept="application/pdf" onchange="checkFileSize(this)">
							<!-- <input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />
						</div>
						<?
						if ($row['FILE_PDF'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('skp22/viewfile') . '/FILE_PDF/' . $row['skp22_id'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
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
					<!-- <input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" /> -->
					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
				<?
				}
				?>
				<a href="javascript:cancelform()" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a>
			</div>

		</form>

	</div>
</div>
</section>
<script>
	function checkFileSize(input) {
		var file = input.files[0];
		if (file) {
			var fileSize = file.size / 1024 / 1024; // Size in MB
			if (fileSize > 2) {
				alert("File size should be 2MB or less.");
				// Reset the file input to clear the selected file
				input.value = '';
			}
		}
	}
	// Function to update the "HasilKinerjaNilai" input based on the selected option of "HasilKinerja"
	function updateHasilKinerjaNilai() {
		var hasilKinerja = document.getElementById("hasilKinerja").value;
		var hasilKinerjaNilai = document.getElementById("hasilKinerjaNilai");

		switch (hasilKinerja) {
			case "DIBAWAH EKSPEKTASI":
				hasilKinerjaNilai.value = "3";
				break;
			case "SESUAI EKSPEKTASI":
				hasilKinerjaNilai.value = "2";
				break;
			case "DIATAS EKSPEKTASI":
				hasilKinerjaNilai.value = "1";
				break;
			default:
				hasilKinerjaNilai.value = "";
				break;
		}
	}

	// Call the updateHasilKinerjaNilai function when the "HasilKinerja" select option changes
	document.getElementById("hasilKinerja").addEventListener("change", updateHasilKinerjaNilai);

	// Initial call to set the initial value of "HasilKinerjaNilai"
	updateHasilKinerjaNilai();
	//end HasilKinerjaNilai

	function updatePerilakuKerjaNilai() {
		var perilakuKerja = document.getElementById("perilakuKerja").value;
		var PerilakuKerjaNilai = document.getElementById("PerilakuKerjaNilai");

		switch (perilakuKerja) {
			case "DIBAWAH EKSPEKTASI":
				PerilakuKerjaNilai.value = "3";
				break;
			case "SESUAI EKSPEKTASI":
				PerilakuKerjaNilai.value = "2";
				break;
			case "DIATAS EKSPEKTASI":
				PerilakuKerjaNilai.value = "1";
				break;
			default:
				PerilakuKerjaNilai.value = "";
				break;
		}
	}

	// Call the updateHasilKinerjaNilai function when the "HasilKinerja" select option changes
	document.getElementById("perilakuKerja").addEventListener("change", updatePerilakuKerjaNilai);

	// Initial call to set the initial value of "HasilKinerjaNilai"
	updatePerilakuKerjaNilai();
</script>
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
					// var skpid = <?php echo json_encode($row['skp22_id']); ?>;
					// var url = "<?php echo site_url(); ?>";
					// if (skpid != "") {
					// 	$.ajax({
					// 		type: 'GET',
					// 		// url: 'http://localhost:8082/index.php/skp22/postSiasn/'+jabatanRiwayatId, 
					// 		url: url + '/skp22/postSiasn/' + skpid, // Replace 'controller' with the actual URL to your controller
					// 		success: function(response) {
					// 			// Handle the response from the controller code
					// 			console.log("postSIASN Success");
					// 		}
					// 	});
					// }
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




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

		<?php if ($row['LAST_UPDATE_USER'] == "estamina" || $row['LAST_UPDATE_USER'] == "Inserted By Estamina" ) { ?>
			$(document).ready(function() {
				$('form input').not('[type="file"],[type="hidden"], [type="button"], [id="insert_date"], [id="update_date"], [id="pnsDinilaiId"], [id="penilaiUnorNm"], [id="penilaiGolonganId"], [id="PEGAWAI_ID"], [id="id"], [id="skp22_id"]').each(function() {
					$(this).attr('readonly', 'readonly');
				});
				$('form select').each(function() {
					$(this).attr('readonly', 'readonly');
				});

			});
		<?php } else { ?>
			$('form input[id="BulanSKP"], form input[id="TipeSKP"]').each(function() {
				$(this).attr('readonly', 'readonly').hide();
				$('label[for="' + this.id + '"]').hide();
			});
		<?php } ?>

	});
</script>