<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sximo/jstree/themes/default/style.min.css">
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('kinerjadisiplin/save/' . $row['PERUBAHAN_DATA_ID']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-4">

					<input type='hidden' class='form-control input-sm' placeholder='' value='<?php echo $row['PERUBAHAN_DATA_ID']; ?>' name='PERUBAHAN_DATA_ID' />
					<div class="form-group row  ">
						<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI </label>
						<div class="col-md-8">
							<input type='hidden' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_ID']; ?>' name='PEGAWAI_ID' />

							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_NAMA; ?>' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="FORM FIP" class=" control-label col-md-4 text-left"> FORM FIP </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FORM_FIP']; ?>' name='FORM_FIP' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="DB TABLE" class=" control-label col-md-4 text-left"> DB TABLE </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DB_TABLE']; ?>' name='DB_TABLE' /> <br />
							<i> <small></small></i>
						</div>
					</div>

					<div class="form-group row  ">
						<label for="DB TABLE" class=" control-label col-md-4 text-left"> STATUS VALIDASI </label>
						<div class="col-md-8">
							<?
							$stt = array('0' => 'Perubahan / Penambahan', '1' => 'Validasi', '2' => 'Tolak');
							?>
							<select name="VALIDASI" rows="5" class="form-control input-sm" style="width: 100%;">
								<?
								foreach ($stt as $key => $val) {
									echo "<option  value ='$key' " . ($row['VALIDASI'] == $key ? " selected='selected' " : '') . ">$val</option>";
								}
								?>
							</select>
							<br />
							<i> <small></small></i>
						</div>
					</div>




				</div>
				<div class="col-md-8">
					<table class="table table-striped table-bordered nowrap dataTable no-footer">
						<thead>
							<tr>
								<td>NAMA FIELD</td>
								<td>DATA BARU</td>
								<td>DATA LAMA</td>
							</tr>
						</thead>
						<?
						$isilama = json_decode($row['ISI_LAMA'], true);
						if ($row['ISI_BARU'] == 'DELETE') {
							$isibaru = $isilama;
							$ardis = array("PEJABAT_PENETAP_ID", "PANGKAT_ID");
							foreach ($isibaru as $key => $value) {

								$r = '';
								if (isset($isilama[$key])) $r = $isilama[$key];
								if ($value == $r) {
									if ($key == 'PEJABAT_PENETAP_ID') {
									} else if (is_array($value)) {
										echo "<tr><td>" . $key . "</td><td>DELETE</td><td>" . $r . "</td></tr>";
									} else {
										echo "<tr><td>" . $key . "</td><td>DELETE</td><td>" . $r . "</td></tr>";
									}
								}
							}
						} else {
							$isibaru = json_decode($row['ISI_BARU']);
							$ardis = array("PEJABAT_PENETAP_ID", "PANGKAT_ID");
							foreach ($isibaru as $key => $value) {

								$r = '';
								if (isset($isilama[$key])) $r = $isilama[$key];
								if ($value != $r) {
									if ($key == 'PEJABAT_PENETAP_ID') {
									} else if (is_array($value)) {
										echo "<tr><td>" . $key . "</td><td>" . implode(",", $value) . "</td><td>" . $r . "</td></tr>";
									} else {
										echo "<tr><td>" . $key . "</td><td>" . $value . "</td><td>" . $r . "</td></tr>";
									}
								}
							}
						}
						?>
					</table>
				</div>


			</div>

			<div style="clear:both">
				<hr />
			</div>

			<div class="toolbar-line text-center">
				<?
				if ($row['VALIDASI']  == 0) {
				?>
					<input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
				<?
				}
				?>
				<a href="javascript:cancelform()" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a>
			</div>

		</form>

	</div>
</div>
<hr />
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
					table.ajax.reload();
					$('#form-ajax').html("");
				}
			});
			ev.preventDefault();
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