<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('users/save/' . $row['id']); ?>" class='form-horizontal' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-12">

					<div class="form-group row hidethis " style="display:none;">
						<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['id']; ?>' name='id' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Group / Level" class=" control-label col-md-4 text-left"> Group / Level <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<select name='group_id' rows='5' id='group_id' code='{$group_id}' class='form-control input-sm select2 ' style='width: 100%;' required></select> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Username" class=" control-label col-md-4 text-left"> Username <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['username']; ?>' name='username' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="First Name" class=" control-label col-md-4 text-left"> First Name <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['first_name']; ?>' name='first_name' required /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Last Name" class=" control-label col-md-4 text-left"> Last Name </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['last_name']; ?>' name='last_name' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Email" class=" control-label col-md-4 text-left"> Email <span class="asterix"> * </span></label>
						<div class="col-md-8">
							<input type='email' class='form-control input-sm' placeholder='' value='<?php echo $row['email']; ?>' name='email' required parsley-type='email' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
						<div class="col-md-8">

							<label class='radio radio-inline'>
								<input type='radio' name='active' value='0' requred <?php if ($row['active'] == '0') echo 'checked="checked"'; ?>> Inactive </label>
							<label class='radio radio-inline'>
								<input type='radio' name='active' value='1' requred <?php if ($row['active'] == '1') echo 'checked="checked"'; ?>> Active </label> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Alamat" class=" control-label col-md-4 text-left"> Alamat </label>
						<div class="col-md-8">
							<textarea name='alamat' rows='2' id='alamat' class='form-control input-sm '><?php echo $row['alamat']; ?></textarea> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Notlp" class=" control-label col-md-4 text-left"> Notlp </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['notlp']; ?>' name='notlp' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Website" class=" control-label col-md-4 text-left"> Website </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['website']; ?>' name='website' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="OPD" class=" control-label col-md-4 text-left"> OPD </label>
						<div class="col-md-8">
							<select name='satker' rows='5' id='satker' code='{$satker}' class='form-control input-sm select2 ' style='width: 100%;'></select> <br />
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
				<a href="<?php echo site_url("users"); ?>" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a>
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




		$("#group_id").jCombo("<?php echo site_url('users/comboselect?filter=tb_groups:group_id:name') ?>", {
			selected_value: '<?php echo $row["group_id"] ?>'
		});

		$("#satker").jCombo("<?php echo site_url('users/comboselect?filter=vw_satker_parent:SATKER_ID:NAMA') ?>", {
			selected_value: '<?php echo $row["satker"] ?>'
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