<ul class="nav nav-tabs nav-underline">
	<li class="nav-item">
		<a class="nav-link active" href="javascript:changepages('pegawai/identitas')" aria-expanded="false"><i class="fa fa-user"></i> IDENTITAS PEGAWAI</a>
	</li>
	<li class="nav-item">
		<a class="nav-link " href="javascript:changepages('dfsview/kartupegawai')" aria-expanded="true"><i class="fa fa-image"></i> KARTU PEGAWAI</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/askes')" aria-expanded="false"><i class="fa fa-image"></i> ASKES</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/taspen')" aria-expanded="false"><i class="fa fa-image"></i> TASPEN</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/npwp')" aria-expanded="false"><i class="fa fa-image"></i> NPWP</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="javascript:changepages('dfsview/ktp')" aria-expanded="false"><i class="fa fa-image"></i> Kartu Tanda Penduduk (KTP)</a>
	</li>
</ul>
<hr />
<form action="<?php echo site_url('pegawai/save') ?>" class="form-vertical" parsley-validate="true" id="formpegawai" novalidate="true" method="post" enctype="multipart/form-data">

	<div class="row">
		<div class="col-md-6">

			<div class="form-group hidethis " style="display:none;">
				<label for="ipt" class=" control-label "> PEGAWAI ID </label>
				<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['PEGAWAI_ID']; ?>" name="PEGAWAI_ID">
			</div>
			<div class="row">
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> NIP LAMA </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" placeholder="<?php echo $row['NIP_LAMA']; ?>" value="" name="NIP_LAMA">
					<?php else : ?>
						<input type="text" class="form-control input-sm" placeholder="<?php echo $row['NIP_LAMA']; ?>" value="" name="NIP_LAMA" readonly>
					<?php endif; ?>
				</div>
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> NIP BARU </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<input type="text" class="form-control input-sm" required placeholder="" oninput="removeSpacesAndNonDigits(this)" value="<?php echo $row['NIP_BARU']; ?>" name="NIP_BARU">
					<?php else : ?>
						<input type="text" class="form-control input-sm" required placeholder="" oninput="removeSpacesAndNonDigits(this)" value="<?php echo $row['NIP_BARU']; ?>" name="NIP_BARU" readonly>
					<?php endif; ?>
					<script>
						function removeSpacesAndNonDigits(inputElement) {
							// Ambil nilai dari input
							let inputValue = inputElement.value;

							// Hapus spasi dari nilai
							let cleanedValue = inputValue.replace(/\s/g, '');

							// Hapus karakter selain angka dari nilai
							let digitsOnly = cleanedValue.replace(/\D/g, '');

							// Setelah membersihkan nilai, kembalikan ke input
							inputElement.value = digitsOnly;
						}
					</script>

				</div>
			</div>
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> NAMA </label>
				<input type="text" class="form-control input-sm" required placeholder="" value="<?php echo $row['NAMA']; ?>" name="NAMA">
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
					<input type="text" class="form-control input-sm" required placeholder="" value="<?php echo $row['TEMPAT_LAHIR']; ?>" name="TEMPAT_LAHIR">
				</div>
				<div class="form-group  col-md-6">
					<label for="ipt" class=" control-label "> TANGGAL LAHIR </label>
					<input type="date" class="form-control input-sm" required placeholder="" value="<?php echo $row['TANGGAL_LAHIR']; ?>" name="TANGGAL_LAHIR">
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-3 ">
					<label for="ipt" class=" control-label "> KELAMIN </label>

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
				</div>
				<div class="form-group  col-md-9">
					<label for="ipt" class=" control-label "> AGAMA </label>
					<select name="AGAMA_ID" id="AGAMA_ID" rows="5" class="form-control input-sm" style="width: 100%;">
					</select>
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
				<input type="text" class="form-control input-sm" required placeholder="" value="<?php echo $row['ALAMAT']; ?>" name="ALAMAT">
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
					<select name="PROPINSI_ID" rows="5" id="PROPINSI_ID" required code="{$PROPINSI_ID}" class="form-control input-sm select2 " style="width: 100%;">
						<option value=""></option>
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KABUPATEN </label>
					<select name="KABUPATEN_ID" rows="5" id="KABUPATEN_ID" required code="{$KABUPATEN_ID}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KECAMATAN </label>
					<select name="KECAMATAN_ID" rows="5" id="KECAMATAN_ID" required code="{$KECAMATAN_ID}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KELURAHAN </label>
					<select name="KELURAHAN_ID" rows="5" id="KELURAHAN_ID" required code="{$KELURAHAN_ID}" class="form-control input-sm select2 " style="width: 100%;" disabled="disabled">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="form-container">
				<br>
				<h4 class=" control-label ">Koordinat Alamat Rumah</h4>

				<label for="ipt" class=" control-label ">LATITUDE</label>
				<input type="text" id="LATITUDE" name="LATITUDE" value="<?php echo $row['LATITUDE']; ?>" class="form-control" readonly />

				<label for="ipt" class=" control-label ">LONGITUDE</label>
				<input type="text" id="LONGITUDE" name="LONGITUDE" value="<?php echo $row['LONGITUDE']; ?>" class="form-control" readonly />

				<button type="button" onclick="openMap()" class="btn btn-primary btn-sm" style="margin-top:10px;">Pilih Titik Lokasi</button>
				<br>
			</div>


			<!-- Modal Popup Map -->
			<div id="mapModal"
				style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
     background:rgba(0,0,0,0.5); z-index:9999;">
				<div style="background:#fff; width:80%; height:80%; margin:40px auto; 
              position:relative; border-radius:8px; padding:10px;">
					<h4>Pilih Lokasi Rumah</h4>

					<div id="popupMap" style="height:85%;"></div>

					<button type="button" onclick="closeMap()" class="btn btn-secondary">Tutup</button>
				</div>
			</div>

			<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
			<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


			<script>
				let popupMap = null;
				let popupMarker = null;

				function openMap() {

					// Tampilkan modal
					document.getElementById('mapModal').style.display = 'block';

					// Delay agar modal benar-benar tampil
					setTimeout(() => {

						if (!popupMap) {
							// Default ke Probolinggo
							popupMap = L.map('popupMap').setView([-7.75, 113.22], 11);

							L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
								maxZoom: 19
							}).addTo(popupMap);

							// Klik map untuk memilih titik
							popupMap.on('click', function(e) {
								const lat = e.latlng.lat;
								const lng = e.latlng.lng;

								document.getElementById('LATITUDE').value = lat;
								document.getElementById('LONGITUDE').value = lng;

								if (popupMarker) {
									popupMarker.setLatLng(e.latlng);
								} else {
									popupMarker = L.marker(e.latlng).addTo(popupMap);
								}
							});
						}

						popupMap.invalidateSize();

						// ◼ Kondisi: Akses GPS
						if (navigator.geolocation) {

							navigator.geolocation.getCurrentPosition(

								// === Jika GPS Sukses ===
								function(pos) {
									const lat = pos.coords.latitude;
									const lng = pos.coords.longitude;

									// Pusatkan map ke lokasi GPS
									popupMap.setView([lat, lng], 15);

									// Set marker default ke posisi GPS
									if (popupMarker) {
										popupMarker.setLatLng([lat, lng]);
									} else {
										popupMarker = L.marker([lat, lng]).addTo(popupMap);
									}

									// Isi ke input form
									document.getElementById('LATITUDE').value = lat;
									document.getElementById('LONGITUDE').value = lng;
								},

								// === Jika GPS Ditolak / Error ===
								function(err) {
									console.warn("GPS error:", err.message);

									// Tetap di Probolinggo (default)
									popupMap.setView([-7.75, 113.22], 11);

									// Tidak set marker apa pun
								},

								{
									enableHighAccuracy: true,
									timeout: 8000,
									maximumAge: 0
								}
							);
						} else {
							console.warn("Geolocation tidak didukung browser");
						}

					}, 300);
				}

				function closeMap() {
					document.getElementById('mapModal').style.display = 'none';
				}
			</script>

			<!-- Leaflet Library -->
			<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
			<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
			<br><br>
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
							<td>Pangkat Terakhir</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$pangkat) {
											echo '';
										} else {
											echo $pangkat->KODEPANGKAT . ' - ' . $pangkat->NAMAPANGKAT;
										}
										?></td>
						</tr>
						<tr>
							<td>TMT Pangkat Terakhir</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$pangkat) {
											echo '';
										} else {
											echo Sitehelpers::daterpt($pangkat->TMT_PANGKAT);
										}
										?></td>
						</tr>

						<tr>
							<td>Gaji Pokok Terakhir</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$gaji) {
											echo '';
										} else {
											echo number_format($gaji->GAJI_POKOK);
										}
										?></td>
						</tr>
						<tr>
							<td>KGB Terakhir</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$gaji) {
											echo '';
										} else {
											echo Sitehelpers::daterpt($gaji->TMT_SK);
										}
										?></td>
						</tr>

						<tr>
							<td>Jabatan Terakhir</td>
							<td>:</td>
							<td width="10%" style="word-wrap: break-word">&nbsp;<?
																				if (!$jabatan) {
																					echo '';
																				} else {
																					echo ($jabatan->NAMA);
																				}
																				?></td>
						</tr>
						<tr>
							<td>TMT Jabatan Terakhir</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$jabatan) {
											echo '';
										} else {
											echo Sitehelpers::daterpt($jabatan->TMT_JABATAN);
										}
										?></td>
						</tr>

						<tr>
							<td>Pendidikan Terakhir</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$pendidikan) {
											echo '';
										} else {
											echo ($pendidikan->NAMA);
										}
										?></td>
						</tr>
						<tr>
							<td>Tgl Ijazah</td>
							<td>:</td>
							<td>&nbsp;<?
										if (!$pendidikan) {
											echo '';
										} else {
											echo ($pendidikan->TANGGAL_STTB);
										}
										?></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>

		<div class="col-md-6">
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> SATUAN KERJA </label>
				<input type="hidden" placeholder="" required value="<?php echo $row['SATKER_ID']; ?>" name="SATKER_ID" id="SATKER_ID">


				<div class="input-group mb-3">
					<input type="text" readonly required value="<?php echo $SATKER_NAMA; ?>" id="SATKER_NAMA" class="form-control form-control-sm " autocomplete="off">
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
						<select class="form-control input-sm" required placeholder="" value="" name="STATUS_PEGAWAI" id="STATUS_PEGAWAI">
						</select>

					<?php else : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="STATUS_PEGAWAI" id="STATUS_PEGAWAI" disabled>
						</select>

					<?php endif; ?>
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> TIPE PEGAWAI </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="TIPE_PEGAWAI_ID" id="TIPE_PEGAWAI_ID">
						</select>
					<?php else : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="TIPE_PEGAWAI_ID" id="TIPE_PEGAWAI_ID" disabled>
						</select>
					<?php endif; ?>


				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> JENIS PEGAWAI </label>
					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="JENIS_PEGAWAI_ID" id="JENIS_PEGAWAI_ID">
						</select>

					<?php else : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="JENIS_PEGAWAI_ID" id="JENIS_PEGAWAI_ID" disabled>
						</select>
					<?php endif; ?>


				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KEDUDUKAN </label>

					<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="KEDUDUKAN_ID" id="KEDUDUKAN_ID">
						</select>
					<?php else : ?>
						<select class="form-control input-sm" required placeholder="" value="" name="KEDUDUKAN_ID" id="KEDUDUKAN_ID" disabled>
						</select>
					<?php endif; ?>


				</div>
			</div>
			<div class="form-group  ">
				<label for="ipt" class=" control-label "> TANGGAL PENSIUN </label>
				<input type="date" class="form-control input-sm col-md-6" placeholder="" value="<?php echo $row['TANGGAL_PENSIUN']; ?>" name="TANGGAL_PENSIUN">
			</div>

			<div class="row">
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> NIK </label>
					<input type="text" class="form-control input-sm" required placeholder="" value="<?php echo $row['NIK']; ?>" name="NIK">
				</div>

				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> KARTU PEGAWAI </label>
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
				<div class="form-group  col-md-6">
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
					<label for="ipt" class=" control-label "> NO KPE </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_KPE']; ?>" name="NO_KPE">
				</div>
				<div class="form-group col-md-6 ">
					<label for="ipt" class=" control-label "> NO KTA </label>
					<input type="text" class="form-control input-sm" placeholder="" value="<?php echo $row['NO_KTA']; ?>" name="NO_KTA">
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
			<input type="submit" class="btn btn-primary btn-sm" value="Simpan" id="submitButton">
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
		SximoModal("<?php echo site_url('pegawai/satkerpilih') ?>", "SATKER");
	}

	$(document).ready(function() {
		$('.select2').select2();
		$('#formpegawai').parsley();

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


		$("#AGAMA_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=agama:AGAMA_ID:NAMA", {
			selected_value: '<?php echo $row['AGAMA_ID']; ?>'
		});

		$("#BANK_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=bank:BANK_ID:NAMA", {
			selected_value: '<?php echo $row['BANK_ID']; ?>'
		});




		$("#STATUS_PEGAWAI").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=status_pegawai:STATUS_PEGAWAI_ID:NAMA", {
			selected_value: '<?php echo $row['STATUS_PEGAWAI']; ?>'
		});
		$("#TIPE_PEGAWAI_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=tipe_pegawai:TIPE_PEGAWAI_ID:TIPE_PEGAWAI_ID|NAMA", {
			selected_value: '<?php echo $row['TIPE_PEGAWAI_ID']; ?>'
		});
		$("#JENIS_PEGAWAI_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=jenis_pegawai:JENIS_PEGAWAI_ID:NAMA", {
			selected_value: '<?php echo $row['JENIS_PEGAWAI_ID']; ?>'
		});
		$("#KEDUDUKAN_ID").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=kedudukan:KEDUDUKAN_ID:NAMA", {
			selected_value: '<?php echo $row['KEDUDUKAN_ID']; ?>'
		});

		$("#submitButton").click(function() {
			// Hapus atribut disabled dari elemen sebelum form disubmit
			$("#JENIS_PEGAWAI_ID").removeAttr("disabled");
			$("#STATUS_PEGAWAI").removeAttr("disabled");
			$("#TIPE_PEGAWAI_ID").removeAttr("disabled");
			$("#KEDUDUKAN_ID").removeAttr("disabled");
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
</script>