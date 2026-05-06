<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4><?php echo $pageTitle ;?></h4>
<span>Detail <?php echo $pageTitle ;?></span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="<?php echo site_url('pegawai') ?>"><?php echo $pageTitle ?></a></li>
<li class="breadcrumb-item"><a href="#!">Detail</a>

</ul>
</div>
</div>
</div>
</div>
<hr />

          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
              	<div class="box-header with-border">	
				<div class="table-responsive">
					<table class="table table-striped table-bordered" >
						<tbody>	
					
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PROPINSI ID</td>
						<td><?php echo $row['PROPINSI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KABUPATEN ID</td>
						<td><?php echo $row['KABUPATEN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KECAMATAN ID</td>
						<td><?php echo $row['KECAMATAN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KELURAHAN ID</td>
						<td><?php echo $row['KELURAHAN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SATKER ID</td>
						<td><?php echo $row['SATKER_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEDUDUKAN ID</td>
						<td><?php echo $row['KEDUDUKAN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JENIS PEGAWAI ID</td>
						<td><?php echo $row['JENIS_PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BANK ID</td>
						<td><?php echo $row['BANK_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NIP LAMA</td>
						<td><?php echo $row['NIP_LAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NIP BARU</td>
						<td><?php echo $row['NIP_BARU'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA</td>
						<td><?php echo $row['NAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GELAR DEPAN</td>
						<td><?php echo $row['GELAR_DEPAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GELAR BELAKANG</td>
						<td><?php echo $row['GELAR_BELAKANG'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TEMPAT LAHIR</td>
						<td><?php echo $row['TEMPAT_LAHIR'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL LAHIR</td>
						<td><?php echo $row['TANGGAL_LAHIR'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JENIS KELAMIN</td>
						<td><?php echo $row['JENIS_KELAMIN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>STATUS KAWIN</td>
						<td><?php echo $row['STATUS_KAWIN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SUKU BANGSA</td>
						<td><?php echo $row['SUKU_BANGSA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GOLONGAN DARAH</td>
						<td><?php echo $row['GOLONGAN_DARAH'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>EMAIL</td>
						<td><?php echo $row['EMAIL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ALAMAT</td>
						<td><?php echo $row['ALAMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>RT</td>
						<td><?php echo $row['RT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>RW</td>
						<td><?php echo $row['RW'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TELEPON</td>
						<td><?php echo $row['TELEPON'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KODEPOS</td>
						<td><?php echo $row['KODEPOS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>STATUS PEGAWAI</td>
						<td><?php echo $row['STATUS_PEGAWAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KARTU PEGAWAI</td>
						<td><?php echo $row['KARTU_PEGAWAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ASKES</td>
						<td><?php echo $row['ASKES'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TASPEN</td>
						<td><?php echo $row['TASPEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NPWP</td>
						<td><?php echo $row['NPWP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NIK</td>
						<td><?php echo $row['NIK'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FOTO</td>
						<td><?php echo $row['FOTO'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO REKENING</td>
						<td><?php echo $row['NO_REKENING'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL MATI</td>
						<td><?php echo $row['TANGGAL_MATI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL PENSIUN</td>
						<td><?php echo $row['TANGGAL_PENSIUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL TERUSAN</td>
						<td><?php echo $row['TANGGAL_TERUSAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL UPDATE</td>
						<td><?php echo $row['TANGGAL_UPDATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TIPE PEGAWAI ID</td>
						<td><?php echo $row['TIPE_PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>AGAMA ID</td>
						<td><?php echo $row['AGAMA_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SATKER ID LAMA</td>
						<td><?php echo $row['SATKER_ID_LAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FOTO SETENGAH</td>
						<td><?php echo $row['FOTO_SETENGAH'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FOTO BLOB</td>
						<td><?php echo $row['FOTO_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FOTO BLOB OTHER</td>
						<td><?php echo $row['FOTO_BLOB_OTHER'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TEMP COL</td>
						<td><?php echo $row['TEMP_COL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TEMP COL2</td>
						<td><?php echo $row['TEMP_COL2'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>USER APP ID</td>
						<td><?php echo $row['USER_APP_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DOSIR KARPEG</td>
						<td><?php echo $row['DOSIR_KARPEG'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FORMAT KARPEG</td>
						<td><?php echo $row['FORMAT_KARPEG'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UKURAN KARPEG</td>
						<td><?php echo $row['UKURAN_KARPEG'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DOSIR ASKES</td>
						<td><?php echo $row['DOSIR_ASKES'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FORMAT ASKES</td>
						<td><?php echo $row['FORMAT_ASKES'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UKURAN ASKES</td>
						<td><?php echo $row['UKURAN_ASKES'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DOSIR TASPEN</td>
						<td><?php echo $row['DOSIR_TASPEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FORMAT TASPEN</td>
						<td><?php echo $row['FORMAT_TASPEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UKURAN TASPEN</td>
						<td><?php echo $row['UKURAN_TASPEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DOSIR NPWP</td>
						<td><?php echo $row['DOSIR_NPWP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FORMAT NPWP</td>
						<td><?php echo $row['FORMAT_NPWP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UKURAN NPWP</td>
						<td><?php echo $row['UKURAN_NPWP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LAST CREATE USER</td>
						<td><?php echo $row['LAST_CREATE_USER'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LAST CREATE DATE</td>
						<td><?php echo $row['LAST_CREATE_DATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LAST UPDATE USER</td>
						<td><?php echo $row['LAST_UPDATE_USER'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LAST UPDATE DATE</td>
						<td><?php echo $row['LAST_UPDATE_DATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LAST CREATE SATKER</td>
						<td><?php echo $row['LAST_CREATE_SATKER'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LAST UPDATE SATKER</td>
						<td><?php echo $row['LAST_UPDATE_SATKER'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO HP</td>
						<td><?php echo $row['NO_HP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JENIS OPERATOR</td>
						<td><?php echo $row['JENIS_OPERATOR'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO KPE</td>
						<td><?php echo $row['NO_KPE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO KTA</td>
						<td><?php echo $row['NO_KTA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JENIS PROFESI</td>
						<td><?php echo $row['JENIS_PROFESI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BBM</td>
						<td><?php echo $row['BBM'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FB</td>
						<td><?php echo $row['FB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TWITTER</td>
						<td><?php echo $row['TWITTER'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS</td>
						<td><?php echo $row['LINK_FILE_APPS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS KARPEG</td>
						<td><?php echo $row['LINK_FILE_APPS_KARPEG'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS ASKES</td>
						<td><?php echo $row['LINK_FILE_APPS_ASKES'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS TASPEN</td>
						<td><?php echo $row['LINK_FILE_APPS_TASPEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS NPWP</td>
						<td><?php echo $row['LINK_FILE_APPS_NPWP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS KPE</td>
						<td><?php echo $row['LINK_FILE_APPS_KPE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FORMAT KPE</td>
						<td><?php echo $row['FORMAT_KPE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UKURAN KPE</td>
						<td><?php echo $row['UKURAN_KPE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE KARPEG</td>
						<td><?php echo $row['BARCODE_KARPEG'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE KPE</td>
						<td><?php echo $row['BARCODE_KPE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE ASKES</td>
						<td><?php echo $row['BARCODE_ASKES'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE TASPEN</td>
						<td><?php echo $row['BARCODE_TASPEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE NPWP</td>
						<td><?php echo $row['BARCODE_NPWP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>QRCODE</td>
						<td><?php echo $row['QRCODE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PASSWORD</td>
						<td><?php echo $row['PASSWORD'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('pegawai');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  