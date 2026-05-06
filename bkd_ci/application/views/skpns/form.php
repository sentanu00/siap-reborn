<ul class="nav nav-tabs nav-underline">
	<li class="nav-item">
		<a class="nav-link active" href="javascript:changepages('pegawai/skpns')" aria-expanded="false"><i class="fa fa-user"></i> SK PNS</a>
	</li>
	<!--li class="nav-item">
		<a class="nav-link  " href="javascript:changepages('dfsview/pns/12')" aria-expanded="true"><i class="fa fa-image"></i> Lampiran SK</a>
	</li>
	<li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/pns/13')" aria-expanded="false"><i class="fa fa-image"></i> Sumpah PNS</a>
	</li-->

</ul>
<br />

<div class="page-header">
	<div class="row align-items-end">
		<div class="col-lg-8">
			<div class="page-header-title">
				<div class="d-inline">
					<h4>SK PNS</h4>
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
		<form action="<?php echo site_url('skpns/save/' . $row['SK_PNS_ID']); ?>" class='form-vertical' parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> SK PNS ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SK_PNS_ID']; ?>' name='SK_PNS_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP <span class="asterix"> * </span> </label>
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL SK <span class="asterix"> * </span> </label>
						<input type='date' class='form-control input-sm col-md-6' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' required />
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TMT PNS <span class="asterix"> * </span> </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_PNS']; ?>' name='TMT_PNS' required />
					</div>
					<div class="row">
						<div class="form-group col-lg-6 ">
							<label for="ipt" class=" control-label "> PANGKAT <span class="asterix"> * </span> </label>
							<select name='PANGKAT_ID' rows='5' id='PANGKAT_ID' code='{$PANGKAT_ID}' class='form-control input-sm select2 ' style='width: 100%;' required></select>
						</div>
						<div class="form-group col-lg-6 ">
							<label for="ipt" class=" control-label "> SUMPAH </label>
							<?php $SUMPAH = explode(",", $row['SUMPAH']); ?>

							<input type='checkbox' name='SUMPAH[]' value='1' class='' <?php if (in_array('1', $SUMPAH)) echo 'checked'; ?> />
						</div>
					</div>
				</div>

				<div class="col-md-4">

					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO PRAJAB </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_PRAJAB']; ?>' name='NO_PRAJAB' />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TANGGAL PRAJAB </label>
						<input type='date' class='form-control input-sm col-md-6' placeholder='' value='<?php echo $row['TANGGAL_PRAJAB']; ?>' name='TANGGAL_PRAJAB' />
					</div>
					<div class="row">
						<div class="form-group col-md-6 ">
							<label for="ipt" class=" control-label "> MASA KERJA THN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA_TAHUN']; ?>' name='MASA_KERJA_TAHUN' />
						</div>
						<div class="form-group col-md-6">
							<label for="ipt" class=" control-label "> MASA KERJA BLN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['MASA_KERJA_BULAN']; ?>' name='MASA_KERJA_BULAN' />
						</div>

						<div class="form-group  col-md-12">
							<label for="ipt" class=" control-label "> DOKUMEN SK PNS(*) </label>
							<input type='file' class='form-control input-sm' accept="application/pdf" id="FILE_PDF" name="FILE_PDF">
							<!-- <input type="hidden" name="file_pdf_cek" value="<?php echo $row['FILE_PDF']; ?>" /> -->
							<input type="hidden" name="FILE_PDF" value="<?php echo $row['FILE_PDF']; ?>" />
							<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('skpns/viewfile') . '/FILE_PDF/' . $row['SK_PNS_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
							}
							?>
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
					<input type="button" id="kirimdata" class="btn btn-primary btn-sm" value="<?php echo $this->lang->line('core.sb_submit'); ?>" />
				<?
				}
				?>
				<!--a href="<?php echo site_url('skpns'); ?>" class="btn btn-sm btn-warning"><?php echo $this->lang->line('core.sb_cancel'); ?> </a-->
			</div>

		</form>

	</div>
</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('.select2').select2();
		
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
					changepages('pegawai/skpns')
				}
			});
		});

		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('skpns/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});

		$("#PANGKAT_ID").jCombo("<?php echo site_url('skpns/comboselect?filter=pangkat:PANGKAT_ID:KODE') ?>", {
			selected_value: '<?php echo $row["PANGKAT_ID"] ?>'
		});

	});
</script>