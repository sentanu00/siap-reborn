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
					<li class="breadcrumb-item"><a href="<?php echo site_url('skp22ekin') ?>"><?php echo $pageTitle ?></a></li>
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
								<td width='30%' class='label-view text-right'>Pegawai Id</td>
								<td><?php echo $row['PEGAWAI_ID']; ?> </td>

							</tr>
							<tr>
								<td width='30%' class='label-view text-right'>Nama</td>
								<td><?php echo $row['nama']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Periode Awal Skp</td>
								<td><?php echo $row['periode_awal_skp']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Periode Akhir Skp</td>
								<td><?php echo $row['periode_akhir_skp']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Skp Unor</td>
								<td><?php echo $row['skp_unor']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Skp Unor Induk</td>
								<td><?php echo $row['skp_unor_induk']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Hasil Kerja</td>
								<td><?php echo $row['hasil_kerja']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Perilaku Kerja</td>
								<td><?php echo $row['perilaku_kerja']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Hasil Akhir</td>
								<td><?php echo $row['hasil_akhir']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Pegawai Atasan Nama</td>
								<td><?php echo $row['pegawai_atasan_nama']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Pegawai Atasan Jabatan</td>
								<td><?php echo $row['pegawai_atasan_jabatan']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Waktu Dinilai</td>
								<td><?php echo $row['waktu_dinilai']; ?> </td>

							</tr>

						</tbody>
					</table>
				</div>
				<a href="<?php echo site_url('skp22ekin'); ?>" class="btn btn-sm btn-warning">
					<< Back </a>
			</div>
		</div>


	</div>
</div>