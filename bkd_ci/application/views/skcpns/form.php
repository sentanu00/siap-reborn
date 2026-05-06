<ul class="nav nav-tabs nav-underline">
	<li class="nav-item">
		<a class="nav-link active" href="javascript:changepages('pegawai/skcpns')" aria-expanded="false"><i class="fa fa-user"></i> SK CPNS</a>
	</li>
	<!--li class="nav-item">
		<a class="nav-link  " href="javascript:changepages('dfsview/cpns/6')" aria-expanded="true"><i class="fa fa-image"></i> Lampiran SK</a>
	</li-->
	<!--li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/cpns/7')" aria-expanded="false"><i class="fa fa-image"></i> Konversi NIP</a>
	</li>
	<li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/cpns/8')" aria-expanded="false"><i class="fa fa-image"></i> Penetapan NIP</a>
	</li-->
	<!--li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/cpns/9')" aria-expanded="false"><i class="fa fa-image"></i> SPMT</a>
	</li-->
	<!--li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/cpns/10')" aria-expanded="false"><i class="fa fa-image"></i> Prajabatan</a>
	</li>

	<li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/cpns/11')" aria-expanded="false"><i class="fa fa-image"></i> Lampiran D2</a>
	</li-->
</ul>
<br />
<div class="page-header">
	<div class="row align-items-end">
		<div class="col-lg-8">
			<div class="page-header-title">
				<div class="d-inline">
					<h4>SK CPNS</h4>
				</div>
			</div>
		</div>
		<div class="col-lg-4">

		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">


		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('skcpns/save/' . $row['SK_CPNS_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group">
						<label for="ipt" class=" control-label "> NO NOTA </label>
						<input type='text' required class='form-control input-sm' placeholder='' value='<?php echo $row['NO_NOTA']; ?>' name='NO_NOTA' />
					</div>
					<div class="form-group ">
						<label for="ipt" class=" control-label "> TANGGAL NOTA </label>
						<input type='date' class='form-control input-sm col-md-8' placeholder='' value='<?php echo $row['TANGGAL_NOTA']; ?>' required name='TANGGAL_NOTA' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> SK CPNS ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SK_CPNS_ID']; ?>' name='SK_CPNS_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP </label>
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;'></select>
					</div>
				</div>

				<div class="col-md-4">


					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK </label>
						<input type='text' required class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' />
					</div>
					<div class="form-group ">
						<label for="ipt" class=" control-label "> TANGGAL SK </label>
						<input type='date' required class='form-control input-sm col-md-8' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' />
					</div>
					<div class="form-group   ">
						<label for="ipt" class=" control-label "> TMT </label>
						<input type='date' class='form-control input-sm col-md-8' placeholder='' value='<?php echo $row['TMT_CPNS']; ?>' name='TMT_CPNS' required />
					</div>
				</div>

				<div class="col-md-4">
					<div class="row">
						<div class="form-group  col-md-4 ">
							<label for="ipt" class=" control-label "> GOL/RUANG </label>
							<select name='PANGKAT_ID' rows='5' id='PANGKAT_ID' code='{$PANGKAT_ID}' class='select2 form-control input-sm  ' style='width: 100%;'></select>
						</div>

						<div class="form-group  col-md-8">
							<label for="ipt" class=" control-label "> TANGGAL TUGAS </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_TUGAS']; ?>' name='TANGGAL_TUGAS' />
						</div>
					</div>

					<div class="form-group">
						<label for="ipt" class=" control-label "> NO STTPP </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_STTPP']; ?>' name='NO_STTPP' />
					</div>
					<div class="form-group">
						<label for="ipt" class=" control-label "> TANGGAL STTPP </label>
						<input type='date' class='form-control input-sm col-md-8' placeholder='' value='<?php echo $row['TANGGAL_STTPP']; ?>' name='TANGGAL_STTPP' />
					</div>


				</div>
				<div class="col-md-12">
					<b>FILE PENDUKUNG</b>
					<hr />
				</div>
				<div class="col-md-4">
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> DOKUMEN SK (*) </label>
						<input type='file' class='form-control input-sm' id="FILE_PDF" name="FILE_PDF" accept="application/pdf" />
						<input type="hidden" name="file_pdf_cek" value="<?php echo $row['FILE_PDF']; ?>" />
						<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />

						<?
						if ($row['FILE_PDF'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('skcpns/viewfile') . '/FILE_PDF/' . $row['SK_CPNS_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
						}
						?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> DOKUMEN SPMT </label>
						<input type='file' class='form-control input-sm' id="FILE_SPMT" name="FILE_SPMT" accept="application/pdf" />
						<input type="hidden" name="file_spmt_cek" value="<?php echo $row['FILE_SPMT']; ?>" />
						<input type="hidden" name="FILE_SPMT" value="<?php echo $row['FILE_SPMT']; ?>" />
						<?
						if ($row['FILE_SPMT'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('skcpns/viewfile') . '/FILE_SPMT/' . $row['SK_CPNS_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
						}
						?>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> DOKUMEN PK </label>
						<input type='file' class='form-control input-sm' id="FILE_PK" name="FILE_PK" accept="application/pdf" />
						<input type="hidden" name="file_pk_cek" value="<?php echo $row['FILE_PK']; ?>" />
						<input type="hidden" name="FILE_PK" value="<?php echo $row['FILE_PK']; ?>" />
						<?
						if ($row['FILE_PK'] != '') {
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('skcpns/viewfile') . '/FILE_PK/' . $row['SK_CPNS_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="' . base_url('/assets/icon/adadoc.png') . '" style="width:20px"> Preview File</a>';
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
					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
				<?
				}
				?>


				<!--a href="<?php echo site_url('skcpns'); ?>" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a-->
			</div>

		</form>

	</div>
</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('.select2').select2();
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



		//$("#form-datax").validate();

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
					changepages('pegawai/skcpns');
				}
			});
		});


		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('skcpns/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});

		$("#PANGKAT_ID").jCombo("<?php echo site_url('skcpns/comboselect?filter=pangkat:PANGKAT_ID:KODE') ?>", {
			selected_value: '<?php echo $row["PANGKAT_ID"] ?>'
		});

	});
</script>