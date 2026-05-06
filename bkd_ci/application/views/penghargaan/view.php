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
<li class="breadcrumb-item"><a href="<?php echo site_url('penghargaan') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>PENGHARGAAN ID</td>
						<td><?php echo $row['PENGHARGAAN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEJABAT PENETAP </td>
						<td><?php echo SiteHelpers::gridDisplayView($row['PEJABAT_PENETAP_ID'],'PEJABAT_PENETAP_ID','1:pejabat_penetap:PEJABAT_PENETAP_ID:JABATAN') ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA</td>
						<td><?php echo $row['NAMA'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>TAHUN</td>
						<td><?php echo $row['TAHUN'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>BARCODE</td>
						<td><?php echo $row['BARCODE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FILE PDF</td>
						<td><?php echo $row['FILE_PDF'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>HARGAID</td>
						<td><?php echo $row['HARGAID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KETERANGAN</td>
						<td><?php echo $row['KETERANGAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MESSAGE</td>
						<td><?php echo $row['MESSAGE'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('penghargaan');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  