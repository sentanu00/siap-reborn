<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4><?php echo $pageTitle; ?></h4>
<span>Detail <?php echo $pageTitle; ?></span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="<?php echo site_url(
    "kinerja"
); ?>"><?php echo $pageTitle; ?></a></li>
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
						<td width='30%' class='label-view text-right'>Id</td>
						<td><?php echo $row["id"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nama Lengkap</td>
						<td><?php echo $row["nama_lengkap"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nip Baru</td>
						<td><?php echo $row["nip_baru"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Satker Id</td>
						<td><?php echo $row["satker_id"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Prosen Kehadiran</td>
						<td><?php echo $row["prosen_kehadiran"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Hukuman</td>
						<td><?php echo $row["hukuman"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tidak Masuk Kerja</td>
						<td><?php echo $row["tidak_masuk_kerja"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sanksi Disiplin</td>
						<td><?php echo $row["sanksi_disiplin"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Persentase Pengurang</td>
						<td><?php echo $row["persentase_pengurang"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bulan</td>
						<td><?php echo $row["bulan"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tahun</td>
						<td><?php echo $row["tahun"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td><?php echo $row["id"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nip Baru</td>
						<td><?php echo $row["nip_baru"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nama Lengkap</td>
						<td><?php echo $row["nama_lengkap"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Jumlah Menit</td>
						<td><?php echo $row["jumlah_menit"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Prosen</td>
						<td><?php echo $row["prosen"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bulan</td>
						<td><?php echo $row["bulan"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tahun</td>
						<td><?php echo $row["tahun"]; ?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url(
        "kinerja"
    ); ?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  