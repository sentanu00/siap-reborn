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
<li class="breadcrumb-item"><a href="<?php echo site_url('mastersatker') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>KODE</td>
						<td><?php echo $row['SATKER_ID'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>SATKER ID PARENT</td>
						<td><?php echo $row['SATKER_ID_PARENT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KODE</td>
						<td><?php echo $row['KODE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA</td>
						<td><?php echo $row['NAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SIFAT</td>
						<td><?php echo $row['SIFAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ALAMAT</td>
						<td><?php echo $row['ALAMAT'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TELEPON</td>
						<td><?php echo $row['TELEPON'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FAXIMILE</td>
						<td><?php echo $row['FAXIMILE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KODEPOS</td>
						<td><?php echo $row['KODEPOS'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>EMAIL</td>
						<td><?php echo $row['EMAIL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ESELON ID</td>
						<td><?php echo $row['ESELON_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PANGKAT ID</td>
						<td><?php echo $row['PANGKAT_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TMT JABATAN</td>
						<td><?php echo $row['TMT_JABATAN'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('mastersatker');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  