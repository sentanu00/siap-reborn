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
<li class="breadcrumb-item"><a href="<?php echo site_url('angkakredit') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>Tanggal SK</td>
						<td><?php echo $row['skDate'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bulan Mulai</td>
						<td><?php echo $row['bulanMulaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tahun Mulai</td>
						<td><?php echo $row['tahunMulaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bulan Selesai</td>
						<td><?php echo $row['bulanSelesaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tahun Selesai</td>
						<td><?php echo $row['tahunSelesaiPenilaian'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>IsAngkaKreditPertama</td>
						<td><?php echo $row['isAngkaKreditPertama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Integrasi</td>
						<td><?php echo $row['isIntegrasi'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Konversi</td>
						<td><?php echo $row['isKonversi'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Angka Kredit Utama</td>
						<td><?php echo $row['angkaKreditUtama'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Angka Kredit Penunjang</td>
						<td><?php echo $row['angkaKreditPenunjang'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Angka Kredit</td>
						<td><?php echo $row['totalAngkaKredit'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nomor SK</td>
						<td><?php echo $row['skNomor'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Dokumen</td>
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
				<a href="<?php echo site_url('angkakredit');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  