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
<li class="breadcrumb-item"><a href="<?php echo site_url('datapensiun') ?>"><?php echo $pageTitle ?></a></li>
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
						<td width='30%' class='label-view text-right'>PENSIUN ID</td>
						<td><?php echo $row['PENSIUN_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
						<td><?php echo $row['PEGAWAI_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>JABATAN AKHIR NAMA</td>
						<td><?php echo $row['JABATAN_AKHIR_NAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SATKER ID</td>
						<td><?php echo $row['SATKER_ID'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>SATKER NAMA</td>
						<td><?php echo $row['SATKER_NAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PANGKAT LAMA</td>
						<td><?php echo SiteHelpers::gridDisplayView($row['PANGKAT_LAMA_ID'],'PANGKAT_LAMA_ID','1:pangkat:PANGKAT_ID:KODE') ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PANGKAT BARU</td>
						<td><?php echo SiteHelpers::gridDisplayView($row['PANGKAT_BARU_ID'],'PANGKAT_BARU_ID','1:pangkat:PANGKAT_ID:KODE') ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MK GOLONGAN BULAN</td>
						<td><?php echo $row['MK_GOLONGAN_BULAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MK GOLONGAN TAHUN</td>
						<td><?php echo $row['MK_GOLONGAN_TAHUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GAJI POKOK LAMA</td>
						<td><?php echo $row['GAJI_POKOK_LAMA'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>GAJI POKOK BARU</td>
						<td><?php echo $row['GAJI_POKOK_BARU'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MK PENSIUN BULAN</td>
						<td><?php echo $row['MK_PENSIUN_BULAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>MK PENSIUN TAHUN</td>
						<td><?php echo $row['MK_PENSIUN_TAHUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BERHENTI AKHIR BULAN</td>
						<td><?php echo $row['BERHENTI_AKHIR_BULAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>BERHENTI AKHIR TAHUN</td>
						<td><?php echo $row['BERHENTI_AKHIR_TAHUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>TMT PENSIUN</td>
						<td><?php echo $row['TMT_PENSIUN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENSIUN POKOK</td>
						<td><?php echo $row['PENSIUN_POKOK'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DATE CREATE</td>
						<td><?php echo $row['DATE_CREATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>DATE UPDATE</td>
						<td><?php echo $row['DATE_UPDATE'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>FILE PDF</td>
						<td><?php echo $row['FILE_PDF'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>NO SK</td>
						<td><?php echo $row['NO_SK'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENANDA TANGAN</td>
						<td><?php echo $row['PENANDA_TANGAN'] ;?> </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>PENANDATANGAN ID</td>
						<td><?php echo $row['PENANDATANGAN_ID'] ;?> </td>
						
					</tr>
				
						</tbody>	
					</table>    
				</div>
				<a href="<?php echo site_url('datapensiun');?>" class="btn btn-sm btn-warning"> << Back </a>
			</div>
		</div>		
	

	</div>
</div>
	  