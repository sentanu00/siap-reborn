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
<li class="breadcrumb-item"><a href="<?php echo site_url('penilaianasn') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>PENILAIAN SKP ID</td>
						<td><?php echo $row['PENILAIAN_SKP_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI PEJABAT PENILAI ID</td>
						<td><?php echo $row['PEGAWAI_PEJABAT_PENILAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ATASAN PEJABAT ID</td>
						<td><?php echo $row['PEGAWAI_ATASAN_PEJABAT_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SKP NILAI</td>
						<td><?php echo $row['SKP_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SKP HASIL</td>
						<td><?php echo $row['SKP_HASIL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>ORIENTASI NILAI</td>
						<td><?php echo $row['ORIENTASI_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>INTEGRITAS NILAI</td>
						<td><?php echo $row['INTEGRITAS_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KOMITMEN NILAI</td>
						<td><?php echo $row['KOMITMEN_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DISIPLIN NILAI</td>
						<td><?php echo $row['DISIPLIN_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KERJASAMA NILAI</td>
						<td><?php echo $row['KERJASAMA_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPEMIMPINAN NILAI</td>
						<td><?php echo $row['KEPEMIMPINAN_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JUMLAH NILAI</td>
						<td><?php echo $row['JUMLAH_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>RATA NILAI</td>
						<td><?php echo $row['RATA_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PERILAKU NILAI</td>
						<td><?php echo $row['PERILAKU_NILAI'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PERILAKU HASIL</td>
						<td><?php echo $row['PERILAKU_HASIL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PRESTASI HASIL</td>
						<td><?php echo $row['PRESTASI_HASIL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEBERATAN</td>
						<td><?php echo $row['KEBERATAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEBERATAN TANGGAL</td>
						<td><?php echo $row['KEBERATAN_TANGGAL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAPAN</td>
						<td><?php echo $row['TANGGAPAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TANGGAPAN TANGGAL</td>
						<td><?php echo $row['TANGGAPAN_TANGGAL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPUTUSAN</td>
						<td><?php echo $row['KEPUTUSAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>KEPUTUSAN TANGGAL</td>
						<td><?php echo $row['KEPUTUSAN_TANGGAL'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>REKOMENDASI</td>
						<td><?php echo $row['REKOMENDASI'] ;?> </td>
						
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
						<td width='30%' class='label-view text-right'>TAHUN</td>
						<td><?php echo $row['TAHUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI PEJABAT PENILAI NIP</td>
						<td><?php echo $row['PEGAWAI_PEJABAT_PENILAI_NIP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI PEJABAT PENILAI NAMA</td>
						<td><?php echo $row['PEGAWAI_PEJABAT_PENILAI_NAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ATASAN PEJABAT NIP</td>
						<td><?php echo $row['PEGAWAI_ATASAN_PEJABAT_NIP'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ATASAN PEJABAT NAMA</td>
						<td><?php echo $row['PEGAWAI_ATASAN_PEJABAT_NAMA'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('penilaianasn');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  