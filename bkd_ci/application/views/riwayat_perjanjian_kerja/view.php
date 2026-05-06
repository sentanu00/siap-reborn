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
					<li class="breadcrumb-item"><a href="<?php echo site_url('riwayat_perjanjian_kerja') ?>"><?php echo $pageTitle ?></a></li>
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
					<table class="table table-striped table-bordered">
						<tbody>

							<tr>
								<td width='30%' class='label-view text-right'>Id</td>
								<td><?php echo $row['id']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>No Sk</td>
								<td><?php echo $row['no_sk']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
								<td><?php echo $row['PEGAWAI_ID']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Penanda Tangan</td>
								<td><?php echo $row['penanda_tangan']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Nama</td>
								<td><?php echo SiteHelpers::gridDisplayView($row['nama'], 'nama', '1:pegawai:PEGAWAI_ID:NAMA'); ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Jenis Jabatan</td>
								<td><?php echo SiteHelpers::gridDisplayView($row['jenis_jabatan'], 'jenis_jabatan', '1:jenis_jabatan:ID:NAMA'); ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Jabatan</td>
								<td><?php echo $row['jabatan']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Jabatan Id</td>
								<td><?php echo $row['jabatan_id']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Unor Nama</td>
								<td><?php echo $row['unor_nama']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Unor Id</td>
								<td><?php echo SiteHelpers::gridDisplayView($row['unor_id'], 'unor_id', '1:satker:SATKER_ID_SAPK:hirarki_nama'); ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Satker Id</td>
								<td><?php echo SiteHelpers::gridDisplayView($row['satker_id'], 'satker_id', '1:satker:SATKER_ID:NAMA'); ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Masa Kerja Tahun</td>
								<td><?php echo $row['masa_kerja_tahun']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Masa Kerja Bulan</td>
								<td><?php echo $row['masa_kerja_bulan']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Tanggal Awal Kontrak</td>
								<td><?php echo $row['tanggal_awal_kontrak']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Tanggal Akhir Kontrak</td>
								<td><?php echo $row['tanggal_akhir_kontrak']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>File Pk</td>
								<td><?php echo $row['file_pk']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>File Sk</td>
								<td><?php echo $row['file_sk']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Created At</td>
								<td><?php echo $row['created_at']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Updated At</td>
								<td><?php echo $row['updated_at']; ?> </td>

							</tr>

						</tbody>
					</table>
				</div>
				<a href="<?php echo site_url('riwayat_perjanjian_kerja'); ?>" class="btn btn-sm btn-warning">
					<< Back </a>
			</div>
		</div>


	</div>
</div>