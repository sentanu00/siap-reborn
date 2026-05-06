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
<li class="breadcrumb-item"><a href="<?php echo site_url('skcpns') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>SK CPNS ID</td>
						<td><?php echo $row['SK_CPNS_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEJABAT PENETAP ID</td>
						<td><?php echo $row['PEJABAT_PENETAP_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PANGKAT ID</td>
						<td><?php echo $row['PANGKAT_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO NOTA</td>
						<td><?php echo $row['NO_NOTA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL NOTA</td>
						<td><?php echo $row['TANGGAL_NOTA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO SK</td>
						<td><?php echo $row['NO_SK'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL SK</td>
						<td><?php echo $row['TANGGAL_SK'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TMT CPNS</td>
						<td><?php echo $row['TMT_CPNS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL TUGAS</td>
						<td><?php echo $row['TANGGAL_TUGAS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO STTPP</td>
						<td><?php echo $row['NO_STTPP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL STTPP</td>
						<td><?php echo $row['TANGGAL_STTPP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL UPDATE</td>
						<td><?php echo $row['TANGGAL_UPDATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA PENETAP</td>
						<td><?php echo $row['NAMA_PENETAP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NIP PENETAP</td>
						<td><?php echo $row['NIP_PENETAP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEJABAT PENETAP</td>
						<td><?php echo $row['PEJABAT_PENETAP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FOTO BLOB</td>
						<td><?php echo $row['FOTO_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MASA KERJA TAHUN</td>
						<td><?php echo $row['MASA_KERJA_TAHUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MASA KERJA BULAN</td>
						<td><?php echo $row['MASA_KERJA_BULAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FORMAT</td>
						<td><?php echo $row['FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UKURAN</td>
						<td><?php echo $row['UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>USER APP ID</td>
						<td><?php echo $row['USER_APP_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GAJI POKOK</td>
						<td><?php echo $row['GAJI_POKOK'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO PERSETUJUAN NIP</td>
						<td><?php echo $row['NO_PERSETUJUAN_NIP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL PERSETUJUAN NIP</td>
						<td><?php echo $row['TANGGAL_PERSETUJUAN_NIP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JURUSAN</td>
						<td><?php echo $row['JURUSAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENDIDIKAN ID</td>
						<td><?php echo $row['PENDIDIKAN_ID'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>LINK FILE APPS</td>
						<td><?php echo $row['LINK_FILE_APPS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS KONVERSI</td>
						<td><?php echo $row['LINK_FILE_APPS_KONVERSI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS PENETAPAN NIP</td>
						<td><?php echo $row['LINK_FILE_APPS_PENETAPAN_NIP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS SPMT</td>
						<td><?php echo $row['LINK_FILE_APPS_SPMT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS PRAJAB</td>
						<td><?php echo $row['LINK_FILE_APPS_PRAJAB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LINK FILE APPS D2</td>
						<td><?php echo $row['LINK_FILE_APPS_D2'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SPMT FORMAT</td>
						<td><?php echo $row['SPMT_FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SPMT UKURAN</td>
						<td><?php echo $row['SPMT_UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>D2 FORMAT</td>
						<td><?php echo $row['D2_FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>D2 UKURAN</td>
						<td><?php echo $row['D2_UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PRAJAB FORMAT</td>
						<td><?php echo $row['PRAJAB_FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PRAJAB UKURAN</td>
						<td><?php echo $row['PRAJAB_UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KONVERSI NIP FORMAT</td>
						<td><?php echo $row['KONVERSI_NIP_FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KONVERSI NIP UKURAN</td>
						<td><?php echo $row['KONVERSI_NIP_UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENETAPAN NIP FORMAT</td>
						<td><?php echo $row['PENETAPAN_NIP_FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENETAPAN NIP UKURAN</td>
						<td><?php echo $row['PENETAPAN_NIP_UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KONVERSI NIP BLOB</td>
						<td><?php echo $row['KONVERSI_NIP_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENETAPAN NIP BLOB</td>
						<td><?php echo $row['PENETAPAN_NIP_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SPMT BLOB</td>
						<td><?php echo $row['SPMT_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>D2 BLOB</td>
						<td><?php echo $row['D2_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PRAJAB BLOB</td>
						<td><?php echo $row['PRAJAB_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE</td>
						<td><?php echo $row['BARCODE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE KONVERSI</td>
						<td><?php echo $row['BARCODE_KONVERSI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE PENETAPAN NIP</td>
						<td><?php echo $row['BARCODE_PENETAPAN_NIP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE SPMT</td>
						<td><?php echo $row['BARCODE_SPMT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE PRAJAB</td>
						<td><?php echo $row['BARCODE_PRAJAB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE D2</td>
						<td><?php echo $row['BARCODE_D2'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('skcpns');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  