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
<li class="breadcrumb-item"><a href="<?php echo site_url('keppo_presensi') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>KEPPO PRESENSI ID</td>
						<td><?php echo $row['KEPPO_PRESENSI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NIP BARU</td>
						<td><?php echo $row['NIP_BARU'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SATKER ID</td>
						<td><?php echo $row['SATKER_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA INSTANSI</td>
						<td><?php echo $row['NAMA_INSTANSI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPPO TARGET</td>
						<td><?php echo $row['KEPPO_TARGET'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPPO REALISASI</td>
						<td><?php echo $row['KEPPO_REALISASI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPPO PERSEN</td>
						<td><?php echo $row['KEPPO_PERSEN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPPO KETERANGAN</td>
						<td><?php echo $row['KEPPO_KETERANGAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PRESENSI</td>
						<td><?php echo $row['PRESENSI'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('keppo_presensi');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  