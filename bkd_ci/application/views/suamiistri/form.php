<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('suamiistri/save/' . $row['SUAMI_ISTRI_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> SUAMI ISTRI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SUAMI_ISTRI_ID']; ?>' name='SUAMI_ISTRI_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NAMA </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA']; ?>' name='NAMA' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PENDIDIKAN ID </label>
						<select name='PENDIDIKAN_ID' rows='5' id='PENDIDIKAN_ID' code='{$PENDIDIKAN_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TEMPAT LAHIR </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT_LAHIR']; ?>' name='TEMPAT_LAHIR' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL LAHIR </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_LAHIR']; ?>' name='TANGGAL_LAHIR' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> STATUS TUNJANGAN </label>
						<?php $STATUS_TUNJANGAN = explode(",", $row['STATUS_TUNJANGAN']); ?>
						<label class='checked checkbox-inline'>
							<input type='checkbox' name='STATUS_TUNJANGAN[]' value='1' class='' <?php if (in_array('1', $STATUS_TUNJANGAN)) echo 'checked'; ?> /> </label>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL KAWIN </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_KAWIN']; ?>' name='TANGGAL_KAWIN' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> STATUS PNS </label>
						<?php $STATUS_PNS = explode(",", $row['STATUS_PNS']); ?>
						<label class='checked checkbox-inline'>
							<input type='checkbox' name='STATUS_PNS[]' value='1' class='' <?php if (in_array('1', $STATUS_PNS)) echo 'checked'; ?> /> </label>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NIP PNS </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NIP_PNS']; ?>' name='NIP_PNS' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KARTU </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KARTU']; ?>' name='KARTU' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEKERJAAN </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEKERJAAN']; ?>' name='PEKERJAAN' />
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


		$("#PENDIDIKAN_ID").jCombo("<?php echo site_url('suamiistri/comboselect?filter=pendidikan:PENDIDIKAN_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["PENDIDIKAN_ID"] ?>'
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