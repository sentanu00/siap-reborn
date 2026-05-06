<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('mutasi/save/' . $row['JABATAN_RIWAYAT_ID']); ?>" class='form-vertical'  method="post" enctype="multipart/form-data" id="form-datax">

			<div class="row">
				<div class="col-md-4">

					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> JABATAN RIWAYAT ID </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_RIWAYAT_ID']; ?>' name='JABATAN_RIWAYAT_ID' />
					</div>
					<div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label "> PEGAWAI ID <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $PEGAWAI_ID; ?>' name='PEGAWAI_ID' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> NO SK <span class="asterix"> * </span> </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_SK']; ?>' name='NO_SK' required />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> JABATAN <span class="asterix"> * </span> </label>
						<input type="hidden" name="NAMA" id="NAMA" value="<?php echo $row['NAMA']; ?>">

						<select name='JABATAN_FUNGSIONAL_ID' rows='5' id='JABATAN_FUNGSIONAL_ID' code='{$JABATAN_FUNGSIONAL_ID}' class='form-control input-sm select2 ' style='width: 100%;' required onchange="getnamajabatan()"></select>
					</div>


					<div class="form-group  ">
						<label for="ipt" class=" control-label "> SATUAN KERJA <span class="asterix"> * </span> </label>
						<input type="hidden" placeholder="" required value="<?php echo $row['SATKER_ID']; ?>" name="SATKER_ID" id="SATKER_ID">


						<div class="input-group mb-3">
							<input type="text" readonly required value="<?php echo $SATKER_NAMA; ?>" id="SATKER_NAMA" class="form-control form-control-sm " autocomplete="off">
							<div class="input-group-append">
								<button class="btn btn-sm btn-info" type="button" onclick="getsatker('<?php echo $row['SATKER_ID']; ?>')"><i class="fa fa-forward"></i></button>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-4">
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> TMT JABATAN <span class="asterix"> * </span> </label>
						<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TMT_JABATAN']; ?>' name='TMT_JABATAN' required style="width: 150px" />
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> PEJABAT PENETAP <span class="asterix"> * </span> </label> <input type="hidden" name="PEJABAT_PENETAP" id="PEJABAT_PENETAP" value="<?php echo $row['PEJABAT_PENETAP']; ?>">
						<select name='PEJABAT_PENETAP_ID' rows='5' id='PEJABAT_PENETAP_ID' code='{$PEJABAT_PENETAP_ID}' class='form-control input-sm select2 ' style='width: 100%;' required onchange="getnamapejabat()"></select>
					</div>
					<div class="form-group  ">
						<label for="ipt" class=" control-label "> KETERANGAN BUP </label>
						<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN_BUP']; ?>' name='KETERANGAN_BUP' />
					</div>
				</div>

				<div class="col-md-4">
					<div class="row">
						<div class="form-group  col-md-6 ">
							<label for="ipt" class=" control-label "> TANGGAL SK </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_SK']; ?>' name='TANGGAL_SK' style="width: 150px" />
						</div>
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> TUNJANGAN </label>
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TUNJANGAN']; ?>' name='TUNJANGAN' />
						</div>
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label for="ipt" class=" control-label "> BULAN DIBAYAR </label>
							<input type='date' class='form-control input-sm' placeholder='' value='<?php echo $row['BULAN_DIBAYAR']; ?>' name='BULAN_DIBAYAR' style="width: 150px" />
						</div>
						<div class="form-group   col-md-6">
							<label for="ipt" class=" control-label "> KELAS JABATAN </label>
							<input type='text' class='form-control input-sm' readonly placeholder='' value='<?php echo $row['KELAS_JABATAN']; ?>' name='KELAS_JABATAN' id='KELAS_JABATAN'  />
						</div>
						
						<div class="form-group   col-md-12">
						<label for="ipt" class=" control-label "> SK JABATAN <span class="asterix">*</span> </label>
						<input type='file' class='form-control input-sm' accept="application/pdf" required id="FILE_PDF" name="FILE_PDF">
							<input type="hidden" name="file_pdf_cek"  value="<?php echo $row['FILE_PDF']; ?>" />
						<?
							if($row['FILE_PDF'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('mutasi/viewfile') . '/FILE_PDF/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
							}
							?>
					</div> 
					
					<div class="form-group   col-md-12">
						<label for="ipt" class=" control-label "> SURAT PELANTIKAN  </label>
						<input type='file' class='form-control input-sm' accept="application/pdf" id="FILE_PELANTIKAN" name="FILE_PELANTIKAN">
							<input type="hidden" name="file_pelantikan_cek"  value="<?php echo $row['FILE_PELANTIKAN']; ?>" />
						<?
							if($row['FILE_PELANTIKAN'] != ''){
							echo '<br /><a href="javascript:SximoModal(\'' . site_url('mutasi/viewfile') . '/FILE_PELANTIKAN/' . $row['JABATAN_RIWAYAT_ID'] . '\',\'View File\',1000)" class="btn btn-danger"><img src="'.base_url('/assets/icon/adadoc.png').'" style="width:20px"> Preview File</a>';
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

	function getnamapejabat() {
		var data = $('#PEJABAT_PENETAP_ID').select2('data');
		if (data[0].id != '') {
			$('#PEJABAT_PENETAP').val(data[0].text);
		}
	}

	function getnamajabatan() {
		var data = $('#JABATAN_FUNGSIONAL_ID').select2('data');
		if (data[0].id != '') {
			$('#NAMA').val(data[0].text);
			getkelasjabatan();
		}
	}

	function getkelasjabatan() {
		$.ajax({
			type: "GET",
			url: "<?= site_url('mutasi/getkelas'); ?>/" + $("#JABATAN_FUNGSIONAL_ID").val(),
			dataType: "html",
			success: function(data) {
				$('#KELAS_JABATAN').val(data);
			}
		});
	}

	$(document).ready(function() {
		//$('form').parsley();
		$('.select2').select2();
		var frm = $('form');
		

		$("#kirimdata").click(function(){
			
				var form_data = new FormData(frm[0]);
				//var files = $('#FILE_PDF')[0].files;
				// form_data.append('FILE_PDF',files[0]);
			if(!frm.valid()) return false;
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: form_data,
                    cache: false,
                    processData: false,
                    contentType: false, 
				success: function(data) {
					  alert('Data Berhasil Disimpan !!');
					  table.ajax.reload();
					  $('#form-ajax').html("");
				}
			});
			
			
			
		});



		$("#PEJABAT_PENETAP_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ?>", {
			selected_value: '<?php echo $row["PEJABAT_PENETAP_ID"] ?>'
		});

		$("#JABATAN_FUNGSIONAL_ID").jCombo("<?php echo site_url('mutasi/comboselect?filter=master_jabatan:id:nm_jabatan|ket') ?>", {
			selected_value: '<?php echo $row["JABATAN_FUNGSIONAL_ID"] ?>'
		});



		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});

	function getsatker(id = 0) {
		SximoModal("<?php echo site_url('pegawai/satkerpilih') ?>", "SATKER");
	}
</script>