<ul class="nav nav-tabs nav-underline">
	<li class="nav-item">
		<a class="nav-link active" href="javascript:changepages('honorer/identitas')" aria-expanded="false"><i class="fa fa-user"></i> IDENTITAS PEGAWAI</a>
	</li>
	<!-- <li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/kartupegawai')" aria-expanded="true"><i class="fa fa-image"></i> KARTU PEGAWAI</a>
	</li> -->
	<!-- <li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/askes')" aria-expanded="false"><i class="fa fa-image"></i> ASKES</a>
	</li> -->
	<!-- <li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/taspen')" aria-expanded="false"><i class="fa fa-image"></i> TASPEN</a>
	</li> -->
	<li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/npwphonorer')" aria-expanded="false"><i class="fa fa-image"></i> NPWP</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/ktphonorer')" aria-expanded="false"><i class="fa fa-image"></i> Kartu Tanda Penduduk (KTP)</a>
	</li>
</ul>
<hr />
<form action="<?php echo site_url('honorer/save') ?>" class="form-vertical" parsley-validate="true" id="formpegawai" novalidate="true" method="post" enctype="multipart/form-data">

	<div class="row">
		<div class="col-md-6">

			<div class="form-group hidethis " style="display:none;">
				<label for="ipt" class=" control-label "> PEGAWAI ID </label>
				<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['PEGAWAI_ID']; ?>" name="PEGAWAI_ID">
			</div>
			<div class="row" style="display:none;">
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> NIP LAMA </label>
					<input type="text" class="form-control input-sm" placeholder="<?php echo $row['NIP_LAMA']; ?>" value="" name="NIP_LAMA">
				</div>
				<div class="form-group  col-md-6" style="display:none;">
					<label for="ipt" class=" control-label "> NIP BARU </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NIP_BARU']; ?>" name="NIP_BARU">
				</div>
			</div>
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> NAMA </label>
				<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NAMA']; ?>" name="NAMA">
				<?php else : ?>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NAMA']; ?>" name="NAMA" readonly>
				<?php endif; ?>

			</div>
			<div class="row">
				<div class="form-group col-md-4 ">
					<label for="ipt" class=" control-label "> GELAR DEPAN </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['GELAR_DEPAN']; ?>" name="GELAR_DEPAN">
					<?php else : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['GELAR_DEPAN']; ?>" name="GELAR_DEPAN" readonly>
					<?php endif; ?>
				</div>

				<div class="form-group col-lg-8 ">
					<label for="ipt" class=" control-label "> GELAR BELAKANG </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['GELAR_BELAKANG']; ?>" name="GELAR_BELAKANG">
					<?php else : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['GELAR_BELAKANG']; ?>" name="GELAR_BELAKANG" readonly>
					<?php endif; ?>

				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 ">

					<label for="ipt" class=" control-label "> TEMPAT LAHIR </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['TEMPAT_LAHIR']; ?>" name="TEMPAT_LAHIR">
					<?php else : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['TEMPAT_LAHIR']; ?>" name="TEMPAT_LAHIR" readonly>
					<?php endif; ?>
				</div>
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> TANGGAL LAHIR </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="date" class="form-control input-sm" placeholder="" value="<?php echo $row['TANGGAL_LAHIR']; ?>" name="TANGGAL_LAHIR">
					<?php else : ?>
						<input type="date" class="form-control input-sm" placeholder="" value="<?php echo $row['TANGGAL_LAHIR']; ?>" name="TANGGAL_LAHIR" readonly>
					<?php endif; ?>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-3 ">
					<label for="ipt" class=" control-label "> KELAMIN </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<?
						$kelam = array('L' => 'L', 'P' => 'P');
						?>
						<select name="JENIS_KELAMIN" rows="5" class="form-control input-sm" style="width: 100%;">
							<?
							foreach ($kelam as $key => $val) {
								echo "<option  value ='$key' " . ($row['JENIS_KELAMIN'] == $key ? " selected='selected' " : '') . ">$val</option>";
							}
							?>
						</select>
					<?php else : ?>
						<input readonly name="JENIS_KELAMIN" rows="5" class="form-control input-sm" style="width: 100%;" value="<?php echo $row['JENIS_KELAMIN']; ?>">
						</input>
					<?php endif; ?>


				</div>
				<div class="form-group  col-md-9">
					<label for="ipt" class=" control-label "> AGAMA </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select name="AGAMA_ID" id="AGAMA_ID" rows="5" class="form-control input-sm" style="width: 100%;">
						</select>
					<?php else : ?>
						<select name="AGAMA_ID" id="AGAMA_ID" rows="5" class="form-control input-sm" style="width: 100%;" readonly>
						</select>
					<?php endif; ?>
				</div>
			</div>

			<div class="row">
				<div class="form-group  col-md-6">
					<?
					$sttkawin = array('1' => 'BELUM KAWIN', '2' => 'KAWIN',  '3' => 'JANDA', '4' => 'DUDA');
					?>
					<label for="ipt" class=" control-label "> STATUS KAWIN </label>
					<select name="STATUS_KAWIN" rows="5" class="form-control input-sm" style="width: 100%;">
						<?
						foreach ($sttkawin as $key => $val) {
							echo "<option  value ='$key' " . ($row['STATUS_KAWIN'] == $key ? " selected='selected' " : '') . ">$val</option>";
						}
						?>
					</select>

				</div>
				<div class="form-group col-md-6 ">
					<?
					$goldarah = array('' => '', 'A' => 'A',  'B' => 'B', 'AB' => 'AB', 'O' => 'O');
					?>
					<label for="ipt" class=" control-label "> GOLONGAN DARAH </label>
					<select name="GOLONGAN_DARAH" rows="5" class="form-control input-sm" style="width: 100%;">
						<?
						foreach ($goldarah as $key => $val) {
							echo "<option  value ='$key' " . ($row['GOLONGAN_DARAH'] == $key ? " selected='selected' " : '') . ">$val</option>";
						}
						?>
					</select>

				</div>
			</div>

			<div class="form-group  ">
				<label for="ipt" class=" control-label "> SUKU BANGSA </label>
				<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['SUKU_BANGSA']; ?>" name="SUKU_BANGSA">
			</div>

			<div class="form-group  ">
				<label for="ipt" class=" control-label "> ALAMAT </label>
				<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['ALAMAT']; ?>" name="ALAMAT">
			</div>
			<div class="row">
				<div class="form-group col-md-2 ">
					<label for="ipt" class=" control-label "> RT </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['RT']; ?>" name="RT">
				</div>
				<div class="form-group col-md-2 ">
					<label for="ipt" class=" control-label "> RW </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['RW']; ?>" name="RW">
				</div>
				<div class="form-group  col-md-8">
					<label for="ipt" class=" control-label "> KODEPOS </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['KODEPOS']; ?>" name="KODEPOS">
				</div>
			</div>


			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> PROPINSI </label>
					<select name="PROPINSI_ID" rows="5" id="PROPINSI_ID" code="{$PROPINSI_ID}" class="form-control input-sm select2 " style="width: 100%;">
						<option value=""></option>
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KABUPATEN </label>
					<select name="KABUPATEN_ID" rows="5" id="KABUPATEN_ID" code="{$KABUPATEN_ID}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KECAMATAN </label>
					<select name="KECAMATAN_ID" rows="5" id="KECAMATAN_ID" code="{$KECAMATAN_ID}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KELURAHAN </label>
					<select name="KELURAHAN_ID" rows="5" id="KELURAHAN_ID" code="{$KELURAHAN_ID}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
			</div>

			<div class="row">

				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> TELEPON </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['TELEPON']; ?>" name="TELEPON">
				</div>

				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> NO HP </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_HP']; ?>" name="NO_HP">
				</div>
			</div>




			<div class="col-md-6">
				<table style="font-size: 14px;width: 100%">
					<tbody>
						<tr>
							<!-- <td>Pangkat Terakhir</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$pangkat) {
										// 	echo '';
										// } else {
										// 	echo $pangkat->KODEPANGKAT . ' - ' . $pangkat->NAMAPANGKAT;
										// }
										?></td>
						</tr>
						<tr>
							<!-- <td>TMT Pangkat Terakhir</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$pangkat) {
										// 	echo '';
										// } else {
										// 	echo Sitehelpers::daterpt($pangkat->TMT_PANGKAT);
										// }
										?></td>
						</tr>

						<tr>
							<!-- <td>Gaji Pokok Terakhir</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$gaji) {
										// 	echo '';
										// } else {
										// 	echo number_format($gaji->GAJI_POKOK);
										// }
										?></td>
						</tr>
						<tr>
							<!-- <td>KGB Terakhir</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$gaji) {
										// 	echo '';
										// } else {
										// 	echo Sitehelpers::daterpt($gaji->TMT_SK);
										// }
										?></td>
						</tr>

						<tr>
							<!-- <td>Jabatan Terakhir</td>
							<td>:</td> -->
							<td width="10%" style="word-wrap: break-word">&nbsp;<?
																				// if (!$jabatan) {
																				// 	echo '';
																				// } else {
																				// 	echo ($jabatan->NAMA);
																				// }
																				?></td>
						</tr>
						<tr>
							<!-- <td>TMT Jabatan Terakhir</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$jabatan) {
										// 	echo '';
										// } else {
										// 	echo Sitehelpers::daterpt($jabatan->TMT_JABATAN);
										// }
										?></td>
						</tr>

						<tr>
							<!-- <td>Pendidikan Terakhir</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$pendidikan) {
										// 	echo '';
										// } else {
										// 	echo ($pendidikan->NAMA);
										// }
										?></td>
						</tr>
						<tr>
							<!-- <td>Tgl Ijazah</td>
							<td>:</td> -->
							<td>&nbsp;<?
										// if (!$pendidikan) {
										// 	echo '';
										// } else {
										// 	echo ($pendidikan->TANGGAL_STTB);
										// }
										?></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>

		<div class="col-md-6">
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> SATUAN KERJA </label>
				<input type="hidden" placeholder="" value="<?php echo $row['SATKER_ID']; ?>" name="SATKER_ID" id="SATKER_ID">


				<div class="input-group mb-3">
					<input type="text" readonly value="<?php echo $SATKER_NAMA; ?>" id="SATKER_NAMA" class="form-control form-control-sm " autocomplete="off">
					<div class="input-group-append">
						<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
							<button class="btn btn-sm btn-info" type="button" onclick="getsatker('<?php echo $row['SATKER_ID']; ?>')"><i class="fa fa-forward"></i></button>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> STATUS PEGAWAI </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select class="form-control input-sm" placeholder="" value='<?php echo $row['STATUS_PEGAWAI']; ?>' name="STATUS_PEGAWAI" id="STATUS_PEGAWAI2">
						</select>

					<?php else : ?>
						<select class="form-control input-sm" placeholder="" value='<?php echo $row['STATUS_PEGAWAI']; ?>' name="STATUS_PEGAWAI" id="STATUS_PEGAWAI2" readonly onmousedown="return false;">
						</select>

					<?php endif; ?>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> TIPE PEGAWAI </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select class="form-control input-sm" placeholder="" value="" name="TIPE_PEGAWAI_ID" id="TIPE_PEGAWAI_ID">
						</select>
					<?php else : ?>
						<select class="form-control input-sm" placeholder="" value="" name="TIPE_PEGAWAI_ID" id="TIPE_PEGAWAI_ID" readonly onmousedown="return false;">
						</select>
					<?php endif; ?>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> JENIS PEGAWAI </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select class="form-control input-sm" placeholder="" value="" name="JENIS_PEGAWAI_ID" id="JENIS_PEGAWAI_ID">
						</select>

					<?php else : ?>
						<select class="form-control input-sm" placeholder="" value="" name="JENIS_PEGAWAI_ID" id="JENIS_PEGAWAI_ID" readonly onmousedown="return false;">
						</select>
					<?php endif; ?>
				</div>
				<div class="form-group col-md-6 " style="display:none;">
					<label for="ipt" class=" control-label "> KEDUDUKAN </label>
					<select class="form-control input-sm" placeholder="" value="" name="KEDUDUKAN_ID" id="KEDUDUKAN_ID">
					</select>
				</div>
			</div>
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> TANGGAL BATAS USIA </label>
				<input type="date" class="form-control input-sm col-md-6" placeholder="" value="<?php echo $row['TANGGAL_PENSIUN']; ?>" name="TANGGAL_PENSIUN">
			</div>

			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> NIK </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NIK']; ?>" name="NIK">
					<?php else : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NIK']; ?>" name="NIK" readonly>
					<?php endif; ?>

				</div>

				<div class="form-group col-md-6 " style="display:none;>
					<label for=" ipt" class=" control-label "> KARTU PEGAWAI </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['KARTU_PEGAWAI']; ?>" name="KARTU_PEGAWAI">
				</div>
			</div>
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> NPWP </label>
				<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NPWP']; ?>" name="NPWP">
			</div>

			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> ASKES / BPJS </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['ASKES']; ?>" name="ASKES">
				</div>
				<div class="form-group  col-md-6" style="display:none;">
					<label for="ipt" class=" control-label "> TASPEN </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['TASPEN']; ?>" name="TASPEN">
				</div>
			</div>
			<div class="row">
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> BANK </label>
					<select class="form-control input-sm" placeholder="" value="" name="BANK_ID" id="BANK_ID">
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> NO REKENING </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_REKENING']; ?>" name="NO_REKENING">
				</div>
			</div>
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> EMAIL </label>
				<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['EMAIL']; ?>" name="EMAIL">
			</div>



			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> JABATAN PADA SK </label>

					<!-- <input type="text" class="form-control input-sm" placeholder="" value="<?php //echo $row['NO_KPE']; 
																								?>" name="NO_KPE"> -->

					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_KPE']; ?>" name="NO_KPE">
						</select>
					<?php else : ?>

						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_KPE']; ?>" name="NO_KPE" readonly onmousedown="return false;">

						</select>
					<?php endif; ?>

				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> PENDIDIKAN DI SK </label>

					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_KTA']; ?>" name="NO_KTA">
						</select>
					<?php else : ?>
						<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_KTA']; ?>" name="NO_KTA" readonly onmousedown="return false;">

						</select>
					<?php endif; ?>


				</div>
			</div>



			<div class="row">
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> FOTO </label>
					<input type="file" class="form-control input-sm" placeholder="" value="" name="FOTO">
					<img src="<?php echo $FOTO; ?>" style="height: 400px;width: 100%" />
				</div>

				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> FOTO SETENGAH </label>
					<input type="file" class="form-control input-sm" placeholder="" name="FOTO_SETENGAH">
					<img src="<?php echo $FOTO_SETENGAH; ?>" style="max-height: 400px;width: 100%" />
				</div>
			</div>

		</div>




	</div>

	<div style="clear:both">
		<hr>
	</div>

	<div class="toolbar-line text-center">

		<?
		if ($this->access['is_edit'] == 1 || $this->access['is_add'] == 1) {
		?>
			<input type="submit" class="btn btn-primary btn-sm" value="Simpan">
		<?
		}
		?>
		<a href="<?php echo site_url('pegawai') ?>" class="btn btn-sm btn-warning">Kembali </a>
	</div>

</form>

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

	function getsatker(id = 0) {
		SximoModal("<?php echo site_url('honorer/satkerpilih') ?>", "SATKER");
	}

	$(document).ready(function() {
		$('.select2').select2();
		$('#formpegawai').parsley();

		$("#PROPINSI_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=propinsi:PROPINSI_ID:NAMA", {
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>'
		});

		$("#KABUPATEN_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=vw_kabupaten:child_id:NAMA:PROPINSI_ID:", {
			parent: '#PROPINSI_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>'
		});

		$("#KECAMATAN_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=vw_kecamatan:child_id:NAMA:parent_id:", {
			parent: '#KABUPATEN_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>*<?php echo $row['KECAMATAN_ID']; ?>'
		});


		$("#KELURAHAN_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=vw_kelurahan:child_id:NAMA:parent_id:", {
			parent: '#KECAMATAN_ID',
			selected_value: '<?php echo $row['PROPINSI_ID']; ?>*<?php echo $row['KABUPATEN_ID']; ?>*<?php echo $row['KECAMATAN_ID']; ?>*<?php echo $row['KELURAHAN_ID']; ?>'
		});


		$("#AGAMA_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=agama:AGAMA_ID:NAMA", {
			selected_value: '<?php echo $row['AGAMA_ID']; ?>'
		});

		$("#BANK_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=bank:BANK_ID:NAMA", {
			selected_value: '<?php echo $row['BANK_ID']; ?>'
		});


		$("#STATUS_PEGAWAI").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=status_pegawai:STATUS_PEGAWAI_ID:NAMA", {
			selected_value: '<?php echo $row['STATUS_PEGAWAI']; ?>'
		});
		$("#TIPE_PEGAWAI_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=tipe_pegawai:TIPE_PEGAWAI_ID:TIPE_PEGAWAI_ID|NAMA", {
			selected_value: '<?php echo $row['TIPE_PEGAWAI_ID']; ?>'
		});
		$("#JENIS_PEGAWAI_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=jenis_pegawai:JENIS_PEGAWAI_ID:NAMA", {
			selected_value: '<?php echo $row['JENIS_PEGAWAI_ID']; ?>'
		});
		$("#KEDUDUKAN_ID").jCombo("<?= site_url(); ?>/honorer/comboselect?filter=kedudukan:KEDUDUKAN_ID:NAMA", {
			selected_value: '<?php echo $row['KEDUDUKAN_ID']; ?>'
		});
		/*

				var frm = $('form');
		    frm.submit(function (ev) {
		        $.ajax({
		            type: frm.attr('method'),
		            url: frm.attr('action'),
		            data: frm.serialize(),
		            success: function (data) {
		                alert('Data Berhasil Disimpan !!');
		                window.location = "<?php echo site_url('pegawai'); ?>/"+data;
		            }
		        });
		        ev.preventDefault();
		    });*/

	});


	$(document).ready(function() {
		var satkerData = [{
				label: "BLUD",
				value: "11"
			},
			{
				label: "SK BUPATI",
				value: "12"
			},
			{
				label: "SK OPD",
				value: "13"
			},
			{
				label: "HONORER WAFAT",
				value: "14"
			},
			{
				label: "HONORER MENGUNDURKAN DIRI",
				value: "15"
			},
			{
				label: "HONORER DIBERHENTIKAN",
				value: "16"
			},
			{
				label: "HONORER PENSIUN",
				value: "17"
			}
		];

		var $select = $('#STATUS_PEGAWAI2');
		satkerData.forEach(function(item) {
			$select.append($('<option>', {
				value: item.value,
				text: item.label
			}));
		});

		// Set the selected value if needed
		var selectedValue = '<?php echo $row["STATUS_PEGAWAI"]; ?>';
		$select.val(selectedValue);
	});
</script>