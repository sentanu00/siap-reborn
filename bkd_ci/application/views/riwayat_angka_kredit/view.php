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
<li class="breadcrumb-item"><a href="<?php echo site_url('riwayat_angka_kredit') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>NIP BARU</td>
						<td><?php echo $row['NIP_BARU'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NAMA</td>
						<td><?php echo $row['NAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Riwayat Angka Kredit Id</td>
						<td><?php echo $row['riwayat_angka_kredit_id'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td><?php echo $row['id'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PnsOrangId</td>
						<td><?php echo $row['pnsOrangId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NamaJabatan</td>
						<td><?php echo $row['namaJabatan'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>RwJabatanId</td>
						<td><?php echo $row['rwJabatanId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sumber</td>
						<td><?php echo $row['sumber'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SkDate</td>
						<td><?php echo $row['skDate'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BulanMulaiPenilaian</td>
						<td><?php echo $row['bulanMulaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TahunMulaiPenilaian</td>
						<td><?php echo $row['tahunMulaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BulanSelesaiPenilaian</td>
						<td><?php echo $row['bulanSelesaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TahunSelesaiPenilaian</td>
						<td><?php echo $row['tahunSelesaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>IsAngkaKreditPertama</td>
						<td><?php echo $row['isAngkaKreditPertama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>IsIntegrasi</td>
						<td><?php echo $row['isIntegrasi'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>IsKonversi</td>
						<td><?php echo $row['isKonversi'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>AngkaKreditUtama</td>
						<td><?php echo $row['angkaKreditUtama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>AngkaKreditPenunjang</td>
						<td><?php echo $row['angkaKreditPenunjang'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TotalAngkaKredit</td>
						<td><?php echo $row['totalAngkaKredit'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SkNomor</td>
						<td><?php echo $row['skNomor'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FILE PDF</td>
						<td><?php echo $row['FILE_PDF'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dok Uri</td>
						<td><?php echo $row['dok_uri'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Insert Date</td>
						<td><?php echo $row['insert_date'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Update Date</td>
						<td><?php echo $row['update_date'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>HargaId</td>
						<td><?php echo $row['hargaId'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tahun</td>
						<td><?php echo $row['tahun'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Status Singkron</td>
						<td><?php echo $row['status_singkron'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sync Date</td>
						<td><?php echo $row['sync_date'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('riwayat_angka_kredit');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  