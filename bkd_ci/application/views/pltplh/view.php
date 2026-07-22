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
    "pltplh"
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
						<td width='30%' class='label-view text-right'>JABATAN RIWAYAT ID</td>
						<td><?php echo $row["JABATAN_RIWAYAT_ID"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row["PEGAWAI_ID"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Eselon</td>
						<td><?php echo $row["eselon"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisRiwayat</td>
						<td><?php echo $row["jenisRiwayat"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>EselonId</td>
						<td><?php echo $row["eselonId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Siasnid</td>
						<td><?php echo $row["siasnid"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>IdPns</td>
						<td><?php echo $row["idPns"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>InstansiKerjaId</td>
						<td><?php echo $row["instansiKerjaId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JabatanFungsionalId</td>
						<td><?php echo $row["jabatanFungsionalId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JabatanFungsionalNama</td>
						<td><?php echo $row["jabatanFungsionalNama"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JabatanFungsionalUmumId</td>
						<td><?php echo $row["jabatanFungsionalUmumId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JabatanFungsionalUmumNama</td>
						<td><?php echo $row["jabatanFungsionalUmumNama"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Jenis Jabatan</td>
						<td><?php echo $row["jenisJabatan"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisMutasiId</td>
						<td><?php echo $row["jenisMutasiId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JenisPenugasanId</td>
						<td><?php echo $row["jenisPenugasanId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nama Jabatan</td>
						<td><?php echo $row["namaJabatan"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NamaUnor</td>
						<td><?php echo $row["namaUnor"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NipBaru</td>
						<td><?php echo $row["nipBaru"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NipLama</td>
						<td><?php echo $row["nipLama"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Nomor SK</td>
						<td><?php echo $row["nomorSk"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SatuanKerjaId</td>
						<td><?php echo $row["satuanKerjaId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SatuanKerjaNama</td>
						<td><?php echo $row["satuanKerjaNama"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SubJabatanId</td>
						<td><?php echo $row["subJabatanId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TanggalSk</td>
						<td><?php echo $row["tanggalSk"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TMT Jabatan</td>
						<td><?php echo $row["tmtJabatan"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TmtMutasi</td>
						<td><?php echo $row["tmtMutasi"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TmtPelantikan</td>
						<td><?php echo $row["tmtPelantikan"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UnorId</td>
						<td><?php echo $row["unorId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UnorIndukId</td>
						<td><?php echo $row["unorIndukId"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UnorIndukNama</td>
						<td><?php echo $row["unorIndukNama"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>UnorNama</td>
						<td><?php echo $row["unorNama"]; ?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FILE PDF</td>
						<td><?php echo $row["FILE_PDF"]; ?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url(
        "pltplh"
    ); ?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  