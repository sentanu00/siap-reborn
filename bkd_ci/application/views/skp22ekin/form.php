<div class="row">
	<div class="col-md-12">



		<?php echo $this->session->flashdata('message'); ?>
		<ul class="parsley-error-list">
			<?php echo $this->session->flashdata('errors'); ?>
		</ul>
		<form action="<?php echo site_url('skp22ekin/save/' . $row['skp22ekin_id']); ?>" class='form-horizontal'
			parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="Jenis" class=" control-label col-md-4 text-left"> Jenis </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jenis']; ?>' name='jenis' /> <br />
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
					<div class="form-group row  ">
						<label for="Nip" class=" control-label col-md-4 text-left"> Nip </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nip']; ?>' name='nip' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Nama" class=" control-label col-md-4 text-left"> Nama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['nama']; ?>' name='nama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Periode Awal Skp" class=" control-label col-md-4 text-left"> Periode Awal Skp </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['periode_awal_skp']; ?>' name='periode_awal_skp' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Periode Akhir Skp" class=" control-label col-md-4 text-left"> Periode Akhir Skp </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['periode_akhir_skp']; ?>' name='periode_akhir_skp' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Skp Unor" class=" control-label col-md-4 text-left"> Skp Unor </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skp_unor']; ?>' name='skp_unor' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Skp Unor Induk" class=" control-label col-md-4 text-left"> Skp Unor Induk </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skp_unor_induk']; ?>' name='skp_unor_induk' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Skp Jabatan" class=" control-label col-md-4 text-left"> Skp Jabatan </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skp_jabatan']; ?>' name='skp_jabatan' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Skp Jenis Jabatan" class=" control-label col-md-4 text-left"> Skp Jenis Jabatan </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['skp_jenis_jabatan']; ?>' name='skp_jenis_jabatan' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Is Skp Plt Plh Pjb" class=" control-label col-md-4 text-left"> Is Skp Plt Plh Pjb </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['is_skp_plt_plh_pjb']; ?>' name='is_skp_plt_plh_pjb' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Hasil Kerja" class=" control-label col-md-4 text-left"> Hasil Kerja </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['hasil_kerja']; ?>' name='hasil_kerja' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Perilaku Kerja" class=" control-label col-md-4 text-left"> Perilaku Kerja </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['perilaku_kerja']; ?>' name='perilaku_kerja' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Hasil Akhir" class=" control-label col-md-4 text-left"> Hasil Akhir </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['hasil_akhir']; ?>' name='hasil_akhir' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Tahun Skp" class=" control-label col-md-4 text-left"> Tahun Skp </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['tahun_skp']; ?>' name='tahun_skp' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Golru" class=" control-label col-md-4 text-left"> Golru </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['golru']; ?>' name='golru' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Jenis Pegawai" class=" control-label col-md-4 text-left"> Jenis Pegawai </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['jenis_pegawai']; ?>' name='jenis_pegawai' /> <br />
							<i> <small></small></i>
						</div>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group row  ">
						<label for="Pegawai Atasan Nip" class=" control-label col-md-4 text-left"> Pegawai Atasan Nip </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_atasan_nip']; ?>' name='pegawai_atasan_nip' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Pegawai Atasan Nama" class=" control-label col-md-4 text-left"> Pegawai Atasan Nama </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_atasan_nama']; ?>' name='pegawai_atasan_nama' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Pegawai Atasan Unor" class=" control-label col-md-4 text-left"> Pegawai Atasan Unor </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_atasan_unor']; ?>' name='pegawai_atasan_unor' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Pegawai Atasan Jabatan" class=" control-label col-md-4 text-left"> Pegawai Atasan Jabatan </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_atasan_jabatan']; ?>' name='pegawai_atasan_jabatan' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Pegawai Atasan Golru" class=" control-label col-md-4 text-left"> Pegawai Atasan Golru </label>
						<div class="col-md-8">
							<input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['pegawai_atasan_golru']; ?>' name='pegawai_atasan_golru' /> <br />
							<i> <small></small></i>
						</div>
					</div>
					<div class="form-group row  ">
						<label for="Waktu Dinilai" class=" control-label col-md-4 text-left"> Waktu Dinilai </label>
						<div class="col-md-8">

							<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['waktu_dinilai']; ?>' name='waktu_dinilai'
								style='width:150px !important;' /> <br />
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




		<?
		if ($this->access['is_edit'] != 1 && $this->access['is_add'] != 1) {
		?>
			$('form input').attr('readonly', 'readonly');
		<?
		}
		?>

	});
</script>