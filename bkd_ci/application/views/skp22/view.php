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
					<li class="breadcrumb-item"><a href="<?php echo site_url('skp22') ?>"><?php echo $pageTitle ?></a></li>
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
								<td width='30%' class='label-view text-right'>Skp22 Id</td>
								<td><?php echo $row['skp22_id']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Id</td>
								<td><?php echo $row['id']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Pegawai Id</td>
								<td><?php echo $row['PEGAWAI_ID']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Nip Baru</td>
								<td><?php echo $row['nip_baru']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>HasilKinerja</td>
								<td><?php echo $row['hasilKinerja']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>HasilKinerjaNilai</td>
								<td><?php echo $row['hasilKinerjaNilai']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>KuadranKinerja</td>
								<td><?php echo $row['kuadranKinerja']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>KuadranKinerjaNilai</td>
								<td><?php echo $row['KuadranKinerjaNilai']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>NamaPenilai</td>
								<td><?php echo $row['namaPenilai']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>NipNrpPenilai</td>
								<td><?php echo $row['nipNrpPenilai']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PenilaiGolonganId</td>
								<td><?php echo $row['penilaiGolonganId']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PenilaiJabatanNm</td>
								<td><?php echo $row['penilaiJabatanNm']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PenilaiUnorNm</td>
								<td><?php echo $row['penilaiUnorNm']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PerilakuKerja</td>
								<td><?php echo $row['perilakuKerja']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PerilakuKerjaNilai</td>
								<td><?php echo $row['PerilakuKerjaNilai']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PnsDinilaiId</td>
								<td><?php echo $row['pnsDinilaiId']; ?> </td>

							</tr>

							

							<tr>
								<td width='30%' class='label-view text-right'>StatusPenilai</td>
								<td><?php echo $row['statusPenilai']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Tahun</td>
								<td><?php echo $row['tahun']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Update Date</td>
								<td><?php echo $row['update_date']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Insert Date</td>
								<td><?php echo $row['insert_date']; ?> </td>

							</tr>

						</tbody>
					</table>
				</div>
				<a href="<?php echo site_url('skp22'); ?>" class="btn btn-sm btn-warning">
					<< Back </a>
			</div>
		</div>


	</div>
</div>