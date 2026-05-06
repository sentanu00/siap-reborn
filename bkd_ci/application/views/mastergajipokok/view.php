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
<li class="breadcrumb-item"><a href="<?php echo site_url('mastergajipokok') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>GAJI POKOK ID</td>
						<td><?php echo $row['GAJI_POKOK_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MASA KERJA</td>
						<td><?php echo $row['MASA_KERJA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GAJI</td>
						<td><?php echo $row['GAJI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PANGKAT ID</td>
						<td><?php echo $row['PANGKAT_ID'] ;?> </td>
						
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
				<a href="<?php echo site_url('mastergajipokok');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  