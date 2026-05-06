<ul class="nav nav-tabs nav-underline">
	<li class="nav-item">
		<a class="nav-link active" href="javascript:changepages('orangtua/add')" aria-expanded="false"><i class="fa fa-user"></i> Orang Tua</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  " href="javascript:changepages('dfsview/orangtua/45')" aria-expanded="true"><i class="fa fa-image"></i> Kartu Keluarga</a>
	</li>
	<li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/orangtua/46')" aria-expanded="false"><i class="fa fa-image"></i> Akta</a>
	</li>
</ul>
<br />
<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('orangtua/save/'); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">
					<h5>Ayah</h5>
					<hr />
					<div class="form-group row hidethis " style="display:none;">
						<label for="ORANG TUA ID" class=" control-label col-md-4 text-left"> ORANG TUA ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ORANG_TUA_ID']; ?>' name='ORANG_TUA_ID[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JENIS KELAMIN" class=" control-label col-md-4 text-left"> JENIS KELAMIN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='L' name='JENIS_KELAMIN[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NAMA" class=" control-label col-md-4 text-left"> NAMA </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TEMPAT LAHIR" class=" control-label col-md-4 text-left"> TEMPAT LAHIR </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT_LAHIR']; ?>' name='TEMPAT_LAHIR[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TANGGAL LAHIR" class=" control-label col-md-4 text-left"> TANGGAL LAHIR </label>
						<div class="col-md-8">
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_LAHIR']; ?>' name='TANGGAL_LAHIR[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PEKERJAAN" class=" control-label col-md-4 text-left"> PEKERJAAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEKERJAAN']; ?>' name='PEKERJAAN[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="ALAMAT" class=" control-label col-md-4 text-left"> ALAMAT </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ALAMAT']; ?>' name='ALAMAT[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KODEPOS" class=" control-label col-md-4 text-left"> KODEPOS </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KODEPOS']; ?>' name='KODEPOS[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TELEPON" class=" control-label col-md-4 text-left"> TELEPON </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TELEPON']; ?>' name='TELEPON[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PROPINSI " class=" control-label col-md-4 text-left"> PROPINSI </label>
						<div class="col-md-8">
							<select name='PROPINSI_ID[]' rows='5' id='PROPINSI_ID' code='{$PROPINSI_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KABUPATEN " class=" control-label col-md-4 text-left"> KABUPATEN </label>
						<div class="col-md-8">
							<select name='KABUPATEN_ID[]' rows='5' id='KABUPATEN_ID' code='{$KABUPATEN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="KECAMATAN " class=" control-label col-md-4 text-left"> KECAMATAN </label>
						<div class="col-md-8">
							<select name='KECAMATAN_ID[]' rows='5' id='KECAMATAN_ID' code='{$KECAMATAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KELURAHAN " class=" control-label col-md-4 text-left"> KELURAHAN </label>
						<div class="col-md-8">
							<select name='KELURAHAN_ID[]' rows='5' id='KELURAHAN_ID' code='{$KELURAHAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<h5>Ibu</h5>
					<hr />
					<div class="form-group row hidethis " style="display:none;">
						<label for="ORANG TUA ID" class=" control-label col-md-4 text-left"> ORANG TUA ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['ORANG_TUA_ID']; ?>' name='ORANG_TUA_ID[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row hidethis " style="display:none;">
						<label for="JENIS KELAMIN" class=" control-label col-md-4 text-left"> JENIS KELAMIN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='P' name='JENIS_KELAMIN[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="NAMA" class=" control-label col-md-4 text-left"> NAMA </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['NAMA']; ?>' name='NAMA[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TEMPAT LAHIR" class=" control-label col-md-4 text-left"> TEMPAT LAHIR </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['TEMPAT_LAHIR']; ?>' name='TEMPAT_LAHIR[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TANGGAL LAHIR" class=" control-label col-md-4 text-left"> TANGGAL LAHIR </label>
						<div class="col-md-8">
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $rowx['TANGGAL_LAHIR']; ?>' name='TANGGAL_LAHIR[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PEKERJAAN" class=" control-label col-md-4 text-left"> PEKERJAAN </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['PEKERJAAN']; ?>' name='PEKERJAAN[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="ALAMAT" class=" control-label col-md-4 text-left"> ALAMAT </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['ALAMAT']; ?>' name='ALAMAT[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KODEPOS" class=" control-label col-md-4 text-left"> KODEPOS </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['KODEPOS']; ?>' name='KODEPOS[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="TELEPON" class=" control-label col-md-4 text-left"> TELEPON </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $rowx['TELEPON']; ?>' name='TELEPON[]' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="PROPINSI " class=" control-label col-md-4 text-left"> PROPINSI </label>
						<div class="col-md-8">
							<select name='PROPINSI_ID[]' rows='5' id='PROPINSI_ID_X' code='{$PROPINSI_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KABUPATEN " class=" control-label col-md-4 text-left"> KABUPATEN </label>
						<div class="col-md-8">
							<select name='KABUPATEN_ID[]' rows='5' id='KABUPATEN_ID_X' code='{$KABUPATEN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="KECAMATAN " class=" control-label col-md-4 text-left"> KECAMATAN </label>
						<div class="col-md-8">
							<select name='KECAMATAN_ID[]' rows='5' id='KECAMATAN_ID_X' code='{$KECAMATAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="KELURAHAN " class=" control-label col-md-4 text-left"> KELURAHAN </label>
						<div class="col-md-8">
							<select name='KELURAHAN_ID[]' rows='5' id='KELURAHAN_ID_X' code='{$KELURAHAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
							<i> <small></small></i>
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
					<input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
				<?
				}
				?>
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
		frm.submit(function(ev) {
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function(data) {
					alert('Data Berhasil Disimpan !!');
					// table.ajax.reload();
					//  $('#form-ajax').html("");
				}
			});
			ev.preventDefault();
		});


		$("#PROPINSI_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=propinsi:PROPINSI_ID:NAMA", {
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>'
		});

		$("#KABUPATEN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kabupaten:child_id:NAMA:PROPINSI_ID:", {
			parent: '#PROPINSI_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>'
		});

		$("#KECAMATAN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kecamatan:child_id:NAMA:parent_id:", {
			parent: '#KABUPATEN_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>*<?php echo $row['KECAMATAN_ID']; ?>'
		});


		$("#KELURAHAN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kelurahan:child_id:NAMA:parent_id:", {
			parent: '#KECAMATAN_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>*<?php echo $row['KECAMATAN_ID']; ?>*<?php echo $row['KELURAHAN_ID']; ?>'
		});



		$("#PROPINSI_ID_X").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=propinsi:PROPINSI_ID:NAMA", {
			selected_value: '<?php echo $rowx['PROPINSI_ID']; ?>'
		});

		$("#KABUPATEN_ID_X").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kabupaten:child_id:NAMA:PROPINSI_ID:", {
			parent: '#PROPINSI_ID_X',
			selected_value: '<?php echo $rowx['PROPINSI_ID']; ?>*<?php echo $rowx['KABUPATEN_ID']; ?>'
		});

		$("#KECAMATAN_ID_X").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kecamatan:child_id:NAMA:parent_id:", {
			parent: '#KABUPATEN_ID_X',
			selected_value: '<?php echo $rowx['PROPINSI_ID']; ?>*<?php echo $rowx['KABUPATEN_ID']; ?>*<?php echo $rowx['KECAMATAN_ID']; ?>'
		});


		$("#KELURAHAN_ID_X").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_kelurahan:child_id:NAMA:parent_id:", {
			parent: '#KECAMATAN_ID_X',
			selected_value: '<?php echo $rowx['PROPINSI_ID']; ?>*<?php echo $rowx['KABUPATEN_ID']; ?>*<?php echo $rowx['KECAMATAN_ID']; ?>*<?php echo $rowx['KELURAHAN_ID']; ?>'
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