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
<li class="breadcrumb-item"><a href="<?php echo site_url('riwayatpangkat') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>PANGKAT RIWAYAT ID</td>
						<td><?php echo $row['PANGKAT_RIWAYAT_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEJABAT PENETAP</td>
						<td><?php echo $row['PEJABAT_PENETAP_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PANGKAT</td>
						<td><?php echo $row['PANGKAT_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>STLUD</td>
						<td><?php echo $row['STLUD'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO STLUD</td>
						<td><?php echo $row['NO_STLUD'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL STLUD</td>
						<td><?php echo $row['TANGGAL_STLUD'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>TMT PANGKAT</td>
						<td><?php echo $row['TMT_PANGKAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KREDIT</td>
						<td><?php echo $row['KREDIT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JENIS KP</td>
						<td><?php echo $row['JENIS_KP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KETERANGAN</td>
						<td><?php echo $row['KETERANGAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MASA KERJA</td>
						<td><?php echo $row['MASA_KERJA_TAHUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MASA KERJA BULAN</td>
						<td><?php echo $row['MASA_KERJA_BULAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAL UPDATE</td>
						<td><?php echo $row['TANGGAL_UPDATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FLAG DATA TERAKHIR</td>
						<td><?php echo $row['FLAG_DATA_TERAKHIR'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>LINK FILE APPS STLUD</td>
						<td><?php echo $row['LINK_FILE_APPS_STLUD'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>STLUD FORMAT</td>
						<td><?php echo $row['STLUD_FORMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>STLUD UKURAN</td>
						<td><?php echo $row['STLUD_UKURAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>STLUD BLOB</td>
						<td><?php echo $row['STLUD_BLOB'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TMT JABATAN FUNGSIONAL</td>
						<td><?php echo $row['TMT_JABATAN_FUNGSIONAL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TINGKAT JABATAN ID</td>
						<td><?php echo $row['TINGKAT_JABATAN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TINGKAT JABATAN</td>
						<td><?php echo $row['TINGKAT_JABATAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE</td>
						<td><?php echo $row['BARCODE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BARCODE STLUD</td>
						<td><?php echo $row['BARCODE_STLUD'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('riwayatpangkat');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  