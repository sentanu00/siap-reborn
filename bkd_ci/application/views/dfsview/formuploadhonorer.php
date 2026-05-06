<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('dfsview/uploaddata'); ?>" class='form-vertical' method="post" enctype="multipart/form-data" id='formupload'>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> Jenis Dokumen <span>*</span> </label>
						<input type='hidden' name='fid_pegawai' value='<?= $pegawai; ?>' />
						<input type='hidden' name='id' value='<?= $id; ?>' />
						<select required class='form-control input-sm' placeholder='' id='fid_jenis_dokumen' name='fid_jenis_dokumen'></select>
					</div>
				</div>
				<div class="col-md-4" style="display:none">
					<label for="ipt" class=" control-label "> Jumlah Halaman Dokumen <span>*</span> </label>
					<input type='text' class='form-control input-sm' placeholder='' id='halaman' name='halaman'>
				</div>

				<div class="col-md-4" style="display:none">
					<label for="ipt" class=" control-label "> keterangan Dokumen </label>
					<input type='text' class='form-control input-sm' placeholder='' id='keterangan' name='keterangan'>
				</div>
				<!--/div>

<div class='row'-->
				<div class="col-md-8">

					<label for="formFile" class="control-label">File PDF (*)</label>
					<input type="file" name='datafile[]' id='datafile' accept="application/pdf" class="form-control" multiple required />

					<hr />

					<div class="toolbar-line text-center">
						<input type="submit" name="submit" class="btn btn-primary btn-sm" value="SIMPAN" />
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		//$('#datafile').imageuploadify();
		var frms = $('#formupload');
		frms.submit(function(ev) {
			$.ajax({
				type: frms.attr('method'),
				url: frms.attr('action'),
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function(data) {
					alert(data);
					let ax = $('#fid_jenis_dokumen').val();
					let halaman = [];
					//1. KTP, 2. NPWP 3. KARPEG 4. TASPEN 5. ASKES
					halaman[1] = 'dfsview/ktphonorer';
					halaman[2] = 'dfsview/npwphonorer';
					// halaman[3] = 'dfsview/kartupegawai';
					// halaman[4] = 'dfsview/taspen';
					// halaman[5] = 'dfsview/askes';
					changepages(halaman[ax]);
				}
			});
			ev.preventDefault();

		});

		$("#fid_jenis_dokumen").jCombo("<?php echo site_url('dfsview/comboselect?filter=jenis_dokumen:id_jenis_dokumen:jenis_dokumen:id_jenis_dokumen:' . $jenis) ?>", {
			selected_value: '<?php echo $jenis ?>'
		});



	});
</script>