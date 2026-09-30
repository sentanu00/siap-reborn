
          <div class="row">
            <div class="col-md-12">



		<?php echo $this->session->flashdata('message');?>
			<ul class="parsley-error-list">
				<?php echo $this->session->flashdata('errors');?>
			</ul>
		 <form action="<?php echo site_url('sihenti_pegawai/save/'.$row['PEGAWAI_ID']); ?>" class='form-horizontal' 
		 parsley-validate='true' novalidate='true' method="post" enctype="multipart/form-data" > 

<div class="row">
<div class="col-md-12">
									
								  <div class="form-group row  " >
									<label for="PEGAWAI ID" class=" control-label col-md-4 text-left"> PEGAWAI ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PEGAWAI_ID'];?>' name='PEGAWAI_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="PROPINSI ID" class=" control-label col-md-4 text-left"> PROPINSI ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PROPINSI_ID'];?>' name='PROPINSI_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KABUPATEN ID" class=" control-label col-md-4 text-left"> KABUPATEN ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KABUPATEN_ID'];?>' name='KABUPATEN_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KECAMATAN ID" class=" control-label col-md-4 text-left"> KECAMATAN ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KECAMATAN_ID'];?>' name='KECAMATAN_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KELURAHAN ID" class=" control-label col-md-4 text-left"> KELURAHAN ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KELURAHAN_ID'];?>' name='KELURAHAN_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="SATKER ID" class=" control-label col-md-4 text-left"> SATKER ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SATKER_ID'];?>' name='SATKER_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KEDUDUKAN ID" class=" control-label col-md-4 text-left"> KEDUDUKAN ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KEDUDUKAN_ID'];?>' name='KEDUDUKAN_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="JENIS PEGAWAI ID" class=" control-label col-md-4 text-left"> JENIS PEGAWAI ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JENIS_PEGAWAI_ID'];?>' name='JENIS_PEGAWAI_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BANK ID" class=" control-label col-md-4 text-left"> BANK ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BANK_ID'];?>' name='BANK_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NIP LAMA" class=" control-label col-md-4 text-left"> NIP LAMA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NIP_LAMA'];?>' name='NIP_LAMA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NIP BARU" class=" control-label col-md-4 text-left"> NIP BARU </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NIP_BARU'];?>' name='NIP_BARU'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NAMA" class=" control-label col-md-4 text-left"> NAMA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NAMA'];?>' name='NAMA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="GELAR DEPAN" class=" control-label col-md-4 text-left"> GELAR DEPAN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GELAR_DEPAN'];?>' name='GELAR_DEPAN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="GELAR BELAKANG" class=" control-label col-md-4 text-left"> GELAR BELAKANG </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GELAR_BELAKANG'];?>' name='GELAR_BELAKANG'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TEMPAT LAHIR" class=" control-label col-md-4 text-left"> TEMPAT LAHIR </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMPAT_LAHIR'];?>' name='TEMPAT_LAHIR'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL LAHIR" class=" control-label col-md-4 text-left"> TANGGAL LAHIR </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_LAHIR'];?>' name='TANGGAL_LAHIR'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="JENIS KELAMIN" class=" control-label col-md-4 text-left"> JENIS KELAMIN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JENIS_KELAMIN'];?>' name='JENIS_KELAMIN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="STATUS KAWIN" class=" control-label col-md-4 text-left"> STATUS KAWIN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['STATUS_KAWIN'];?>' name='STATUS_KAWIN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="SUKU BANGSA" class=" control-label col-md-4 text-left"> SUKU BANGSA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SUKU_BANGSA'];?>' name='SUKU_BANGSA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="GOLONGAN DARAH" class=" control-label col-md-4 text-left"> GOLONGAN DARAH </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['GOLONGAN_DARAH'];?>' name='GOLONGAN_DARAH'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="EMAIL" class=" control-label col-md-4 text-left"> EMAIL </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['EMAIL'];?>' name='EMAIL'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="ALAMAT" class=" control-label col-md-4 text-left"> ALAMAT </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ALAMAT'];?>' name='ALAMAT'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="RT" class=" control-label col-md-4 text-left"> RT </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['RT'];?>' name='RT'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="RW" class=" control-label col-md-4 text-left"> RW </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['RW'];?>' name='RW'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TELEPON" class=" control-label col-md-4 text-left"> TELEPON </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TELEPON'];?>' name='TELEPON'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KODEPOS" class=" control-label col-md-4 text-left"> KODEPOS </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KODEPOS'];?>' name='KODEPOS'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="STATUS PEGAWAI" class=" control-label col-md-4 text-left"> STATUS PEGAWAI </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['STATUS_PEGAWAI'];?>' name='STATUS_PEGAWAI'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KARTU PEGAWAI" class=" control-label col-md-4 text-left"> KARTU PEGAWAI </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KARTU_PEGAWAI'];?>' name='KARTU_PEGAWAI'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="ASKES" class=" control-label col-md-4 text-left"> ASKES </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ASKES'];?>' name='ASKES'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TASPEN" class=" control-label col-md-4 text-left"> TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TASPEN'];?>' name='TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NPWP" class=" control-label col-md-4 text-left"> NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NPWP'];?>' name='NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NIK" class=" control-label col-md-4 text-left"> NIK </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NIK'];?>' name='NIK'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FOTO" class=" control-label col-md-4 text-left"> FOTO </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FOTO'];?>' name='FOTO'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NO REKENING" class=" control-label col-md-4 text-left"> NO REKENING </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_REKENING'];?>' name='NO_REKENING'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL MATI" class=" control-label col-md-4 text-left"> TANGGAL MATI </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_MATI'];?>' name='TANGGAL_MATI'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL PENSIUN" class=" control-label col-md-4 text-left"> TANGGAL PENSIUN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_PENSIUN'];?>' name='TANGGAL_PENSIUN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL TERUSAN" class=" control-label col-md-4 text-left"> TANGGAL TERUSAN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_TERUSAN'];?>' name='TANGGAL_TERUSAN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL UPDATE" class=" control-label col-md-4 text-left"> TANGGAL UPDATE </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['TANGGAL_UPDATE'];?>' name='TANGGAL_UPDATE'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TIPE PEGAWAI ID" class=" control-label col-md-4 text-left"> TIPE PEGAWAI ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TIPE_PEGAWAI_ID'];?>' name='TIPE_PEGAWAI_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="AGAMA ID" class=" control-label col-md-4 text-left"> AGAMA ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['AGAMA_ID'];?>' name='AGAMA_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="SATKER ID LAMA" class=" control-label col-md-4 text-left"> SATKER ID LAMA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SATKER_ID_LAMA'];?>' name='SATKER_ID_LAMA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FOTO SETENGAH" class=" control-label col-md-4 text-left"> FOTO SETENGAH </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FOTO_SETENGAH'];?>' name='FOTO_SETENGAH'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FOTO BLOB" class=" control-label col-md-4 text-left"> FOTO BLOB </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FOTO_BLOB'];?>' name='FOTO_BLOB'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FOTO BLOB OTHER" class=" control-label col-md-4 text-left"> FOTO BLOB OTHER </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FOTO_BLOB_OTHER'];?>' name='FOTO_BLOB_OTHER'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TEMP COL" class=" control-label col-md-4 text-left"> TEMP COL </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMP_COL'];?>' name='TEMP_COL'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TEMP COL2" class=" control-label col-md-4 text-left"> TEMP COL2 </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TEMP_COL2'];?>' name='TEMP_COL2'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="USER APP ID" class=" control-label col-md-4 text-left"> USER APP ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['USER_APP_ID'];?>' name='USER_APP_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="DOSIR KARPEG" class=" control-label col-md-4 text-left"> DOSIR KARPEG </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DOSIR_KARPEG'];?>' name='DOSIR_KARPEG'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FORMAT KARPEG" class=" control-label col-md-4 text-left"> FORMAT KARPEG </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FORMAT_KARPEG'];?>' name='FORMAT_KARPEG'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="UKURAN KARPEG" class=" control-label col-md-4 text-left"> UKURAN KARPEG </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['UKURAN_KARPEG'];?>' name='UKURAN_KARPEG'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="DOSIR ASKES" class=" control-label col-md-4 text-left"> DOSIR ASKES </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DOSIR_ASKES'];?>' name='DOSIR_ASKES'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FORMAT ASKES" class=" control-label col-md-4 text-left"> FORMAT ASKES </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FORMAT_ASKES'];?>' name='FORMAT_ASKES'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="UKURAN ASKES" class=" control-label col-md-4 text-left"> UKURAN ASKES </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['UKURAN_ASKES'];?>' name='UKURAN_ASKES'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="DOSIR TASPEN" class=" control-label col-md-4 text-left"> DOSIR TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DOSIR_TASPEN'];?>' name='DOSIR_TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FORMAT TASPEN" class=" control-label col-md-4 text-left"> FORMAT TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FORMAT_TASPEN'];?>' name='FORMAT_TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="UKURAN TASPEN" class=" control-label col-md-4 text-left"> UKURAN TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['UKURAN_TASPEN'];?>' name='UKURAN_TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="DOSIR NPWP" class=" control-label col-md-4 text-left"> DOSIR NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['DOSIR_NPWP'];?>' name='DOSIR_NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FORMAT NPWP" class=" control-label col-md-4 text-left"> FORMAT NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FORMAT_NPWP'];?>' name='FORMAT_NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="UKURAN NPWP" class=" control-label col-md-4 text-left"> UKURAN NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['UKURAN_NPWP'];?>' name='UKURAN_NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LAST CREATE USER" class=" control-label col-md-4 text-left"> LAST CREATE USER </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_CREATE_USER'];?>' name='LAST_CREATE_USER'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LAST CREATE DATE" class=" control-label col-md-4 text-left"> LAST CREATE DATE </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['LAST_CREATE_DATE'];?>' name='LAST_CREATE_DATE'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LAST UPDATE USER" class=" control-label col-md-4 text-left"> LAST UPDATE USER </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_UPDATE_USER'];?>' name='LAST_UPDATE_USER'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LAST UPDATE DATE" class=" control-label col-md-4 text-left"> LAST UPDATE DATE </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['LAST_UPDATE_DATE'];?>' name='LAST_UPDATE_DATE'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LAST CREATE SATKER" class=" control-label col-md-4 text-left"> LAST CREATE SATKER </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_CREATE_SATKER'];?>' name='LAST_CREATE_SATKER'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LAST UPDATE SATKER" class=" control-label col-md-4 text-left"> LAST UPDATE SATKER </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LAST_UPDATE_SATKER'];?>' name='LAST_UPDATE_SATKER'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NO HP" class=" control-label col-md-4 text-left"> NO HP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_HP'];?>' name='NO_HP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="JENIS OPERATOR" class=" control-label col-md-4 text-left"> JENIS OPERATOR </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JENIS_OPERATOR'];?>' name='JENIS_OPERATOR'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NO KPE" class=" control-label col-md-4 text-left"> NO KPE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_KPE'];?>' name='NO_KPE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NO KTA" class=" control-label col-md-4 text-left"> NO KTA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_KTA'];?>' name='NO_KTA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="JENIS PROFESI" class=" control-label col-md-4 text-left"> JENIS PROFESI </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JENIS_PROFESI'];?>' name='JENIS_PROFESI'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BBM" class=" control-label col-md-4 text-left"> BBM </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BBM'];?>' name='BBM'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FB" class=" control-label col-md-4 text-left"> FB </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FB'];?>' name='FB'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TWITTER" class=" control-label col-md-4 text-left"> TWITTER </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TWITTER'];?>' name='TWITTER'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LINK FILE APPS" class=" control-label col-md-4 text-left"> LINK FILE APPS </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LINK_FILE_APPS'];?>' name='LINK_FILE_APPS'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LINK FILE APPS KARPEG" class=" control-label col-md-4 text-left"> LINK FILE APPS KARPEG </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LINK_FILE_APPS_KARPEG'];?>' name='LINK_FILE_APPS_KARPEG'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LINK FILE APPS ASKES" class=" control-label col-md-4 text-left"> LINK FILE APPS ASKES </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LINK_FILE_APPS_ASKES'];?>' name='LINK_FILE_APPS_ASKES'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LINK FILE APPS TASPEN" class=" control-label col-md-4 text-left"> LINK FILE APPS TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LINK_FILE_APPS_TASPEN'];?>' name='LINK_FILE_APPS_TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LINK FILE APPS NPWP" class=" control-label col-md-4 text-left"> LINK FILE APPS NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LINK_FILE_APPS_NPWP'];?>' name='LINK_FILE_APPS_NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LINK FILE APPS KPE" class=" control-label col-md-4 text-left"> LINK FILE APPS KPE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LINK_FILE_APPS_KPE'];?>' name='LINK_FILE_APPS_KPE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="FORMAT KPE" class=" control-label col-md-4 text-left"> FORMAT KPE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['FORMAT_KPE'];?>' name='FORMAT_KPE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="UKURAN KPE" class=" control-label col-md-4 text-left"> UKURAN KPE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['UKURAN_KPE'];?>' name='UKURAN_KPE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BARCODE KARPEG" class=" control-label col-md-4 text-left"> BARCODE KARPEG </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BARCODE_KARPEG'];?>' name='BARCODE_KARPEG'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BARCODE KPE" class=" control-label col-md-4 text-left"> BARCODE KPE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BARCODE_KPE'];?>' name='BARCODE_KPE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BARCODE ASKES" class=" control-label col-md-4 text-left"> BARCODE ASKES </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BARCODE_ASKES'];?>' name='BARCODE_ASKES'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BARCODE TASPEN" class=" control-label col-md-4 text-left"> BARCODE TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BARCODE_TASPEN'];?>' name='BARCODE_TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="BARCODE NPWP" class=" control-label col-md-4 text-left"> BARCODE NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['BARCODE_NPWP'];?>' name='BARCODE_NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="QRCODE" class=" control-label col-md-4 text-left"> QRCODE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['QRCODE'];?>' name='QRCODE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="PASSWORD" class=" control-label col-md-4 text-left"> PASSWORD </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PASSWORD'];?>' name='PASSWORD'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="ID SAPK" class=" control-label col-md-4 text-left"> ID SAPK </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ID_SAPK'];?>' name='ID_SAPK'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="SINGKRON JABATAN SIAP" class=" control-label col-md-4 text-left"> SINGKRON JABATAN SIAP </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['SINGKRON_JABATAN_SIAP'];?>' name='SINGKRON_JABATAN_SIAP'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="PANGKAT ID TERAKHIR" class=" control-label col-md-4 text-left"> PANGKAT ID TERAKHIR </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PANGKAT_ID_TERAKHIR'];?>' name='PANGKAT_ID_TERAKHIR'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="PENDIDIKAN ID TERAKHIR" class=" control-label col-md-4 text-left"> PENDIDIKAN ID TERAKHIR </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['PENDIDIKAN_ID_TERAKHIR'];?>' name='PENDIDIKAN_ID_TERAKHIR'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="JABATAN ID TERAKHIR" class=" control-label col-md-4 text-left"> JABATAN ID TERAKHIR </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['JABATAN_ID_TERAKHIR'];?>' name='JABATAN_ID_TERAKHIR'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="SATKER INDUK ID" class=" control-label col-md-4 text-left"> SATKER INDUK ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['SATKER_INDUK_ID'];?>' name='SATKER_INDUK_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KETERANGAN PEGAWAI" class=" control-label col-md-4 text-left"> KETERANGAN PEGAWAI </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KETERANGAN_PEGAWAI'];?>' name='KETERANGAN_PEGAWAI'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Ws Check Date" class=" control-label col-md-4 text-left"> Ws Check Date </label>
									<div class="col-md-8">
									  
				<input type='text' class='form-control input-sm datetime' placeholder='' value='<?php echo $row['ws_check_date'];?>' name='ws_check_date'
				style='width:150px !important;'	   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Ws Check Push" class=" control-label col-md-4 text-left"> Ws Check Push </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ws_check_push'];?>' name='ws_check_push'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="Ws Check Message" class=" control-label col-md-4 text-left"> Ws Check Message </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['ws_check_message'];?>' name='ws_check_message'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="EMAIL GOV" class=" control-label col-md-4 text-left"> EMAIL GOV </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['EMAIL_GOV'];?>' name='EMAIL_GOV'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KABUPATEN ID SIASN" class=" control-label col-md-4 text-left"> KABUPATEN ID SIASN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KABUPATEN_ID_SIASN'];?>' name='KABUPATEN_ID_SIASN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KARIS KARSU" class=" control-label col-md-4 text-left"> KARIS KARSU </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KARIS_KARSU'];?>' name='KARIS_KARSU'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="KELAS JABATAN" class=" control-label col-md-4 text-left"> KELAS JABATAN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['KELAS_JABATAN'];?>' name='KELAS_JABATAN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="NO TAPERA" class=" control-label col-md-4 text-left"> NO TAPERA </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['NO_TAPERA'];?>' name='NO_TAPERA'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LOKASI KERJA ID" class=" control-label col-md-4 text-left"> LOKASI KERJA ID </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LOKASI_KERJA_ID'];?>' name='LOKASI_KERJA_ID'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL NPWP" class=" control-label col-md-4 text-left"> TANGGAL NPWP </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_NPWP'];?>' name='TANGGAL_NPWP'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TANGGAL TASPEN" class=" control-label col-md-4 text-left"> TANGGAL TASPEN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TANGGAL_TASPEN'];?>' name='TANGGAL_TASPEN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="CEK PANGKAT SIASN" class=" control-label col-md-4 text-left"> CEK PANGKAT SIASN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['CEK_PANGKAT_SIASN'];?>' name='CEK_PANGKAT_SIASN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="CEK PENDIDIKAN SIASN" class=" control-label col-md-4 text-left"> CEK PENDIDIKAN SIASN </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['CEK_PENDIDIKAN_SIASN'];?>' name='CEK_PENDIDIKAN_SIASN'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LATITUDE" class=" control-label col-md-4 text-left"> LATITUDE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LATITUDE'];?>' name='LATITUDE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="LONGITUDE" class=" control-label col-md-4 text-left"> LONGITUDE </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['LONGITUDE'];?>' name='LONGITUDE'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 					
								  <div class="form-group row  " >
									<label for="TERDAFTAR SIGAWAI" class=" control-label col-md-4 text-left"> TERDAFTAR SIGAWAI </label>
									<div class="col-md-8">
									  <input type='text' class='form-control input-sm' placeholder='' value='<?php echo $row['TERDAFTAR_SIGAWAI'];?>' name='TERDAFTAR_SIGAWAI'   /> <br />
									  <i> <small></small></i>
									 </div> 
								  </div> 
			</div>
			
			
</div>
		
			<div style="clear:both"><hr /></div>	
				
 		<div class="toolbar-line text-center">		
			<?
			if($this->access['is_edit'] ==1 || $this->access['is_add'] ==1){
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
	$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

			$('input').on('keyup', function(event){
  if(event.keyCode == 13){ // 13 is the keycode for enter button
    $(this).next('input').focus();
  }
});
			
$(document).ready(function() { 

	var frm = $('form');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                alert('Data Berhasil Disimpan !!');
                 table.ajax.reload();
                  $('#form-ajax').html("");
            }
        });
        ev.preventDefault();
    });
 	
 


<?
			if($this->access['is_edit'] !=1 && $this->access['is_add'] !=1){
			?>
			$('form input').attr('readonly', 'readonly');
			<?
		}
			?>

});
</script>		 