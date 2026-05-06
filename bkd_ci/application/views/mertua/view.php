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
<li class="breadcrumb-item"><a href="<?php echo site_url('mertua') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>MERTUA ID</td>
						<td><?php echo $row['MERTUA_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JENIS KELAMIN</td>
						<td><?php echo $row['JENIS_KELAMIN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA</td>
						<td><?php echo $row['NAMA'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>PEKERJAAN</td>
						<td><?php echo $row['PEKERJAAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ALAMAT</td>
						<td><?php echo $row['ALAMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KODEPOS</td>
						<td><?php echo $row['KODEPOS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TELEPON</td>
						<td><?php echo $row['TELEPON'] ;?> </td>
						
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
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('mertua');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  