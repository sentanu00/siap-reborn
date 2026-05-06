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
<li class="breadcrumb-item"><a href="<?php echo site_url('kursus_riwayat') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>Diklat Riwayat Id</td>
						<td><?php echo $row['diklat_riwayat_id'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Kursus Id Siasn</td>
						<td><?php echo $row['kursus_id_siasn'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PnsOrangId</td>
						<td><?php echo $row['pnsOrangId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisDiklatId</td>
						<td><?php echo $row['jenisDiklatId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisKursus</td>
						<td><?php echo $row['jenisKursus'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisKursusSertipikat</td>
						<td><?php echo $row['jenisKursusSertipikat'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NamaKursus</td>
						<td><?php echo $row['namaKursus'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>InstitusiPenyelenggara</td>
						<td><?php echo $row['institusiPenyelenggara'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NomorSertipikat</td>
						<td><?php echo $row['nomorSertipikat'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TanggalKursus</td>
						<td><?php echo $row['tanggalKursus'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TanggalSelesaiKursus</td>
						<td><?php echo $row['tanggalSelesaiKursus'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TahunKursus</td>
						<td><?php echo $row['tahunKursus'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JumlahJam</td>
						<td><?php echo $row['jumlahJam'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>RumpunDiklat</td>
						<td><?php echo $row['rumpunDiklat'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Instansi</td>
						<td><?php echo $row['instansi'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>InstansiId</td>
						<td><?php echo $row['instansiId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Lokasi</td>
						<td><?php echo $row['lokasi'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>LokasiId</td>
						<td><?php echo $row['lokasiId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FILE PDF</td>
						<td><?php echo $row['FILE_PDF'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dok Id</td>
						<td><?php echo $row['dok_id'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dok Uri</td>
						<td><?php echo $row['dok_uri'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dok Nama</td>
						<td><?php echo $row['dok_nama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Object</td>
						<td><?php echo $row['object'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Slug</td>
						<td><?php echo $row['slug'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Update By</td>
						<td><?php echo $row['update_by'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Insert By</td>
						<td><?php echo $row['insert_by'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Insert Date</td>
						<td><?php echo $row['insert_date'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisDiklatNama</td>
						<td><?php echo $row['jenisDiklatNama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisKursusNama</td>
						<td><?php echo $row['jenisKursusNama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>RumpunDiklatNama</td>
						<td><?php echo $row['rumpunDiklatNama'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('kursus_riwayat');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  