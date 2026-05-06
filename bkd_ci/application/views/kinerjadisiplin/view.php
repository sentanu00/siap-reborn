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
					<li class="breadcrumb-item"><a href="<?php echo site_url('kinerjadisiplin') ?>"><?php echo $pageTitle ?></a></li>
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
								<td width='30%' class='label-view text-right'>PERUBAHAN DATA ID</td>
								<td><?php echo $row['PERUBAHAN_DATA_ID']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PEGAWAI ID</td>
								<td><?php echo $row['PEGAWAI_ID']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>FORM FIP</td>
								<td><?php echo $row['FORM_FIP']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>DB TABLE</td>
								<td><?php echo $row['DB_TABLE']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>ISI LAMA</td>
								<td><?php echo $row['ISI_LAMA']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>ISI BARU</td>
								<td><?php echo $row['ISI_BARU']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>VALIDASI</td>
								<td><?php echo $row['VALIDASI']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>VALIDATOR</td>
								<td><?php echo $row['VALIDATOR']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>TANGGAL</td>
								<td><?php echo $row['TANGGAL']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>SATKER ID</td>
								<td><?php echo $row['SATKER_ID']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>TIPE PERUBAHAN DATA</td>
								<td><?php echo $row['TIPE_PERUBAHAN_DATA']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>FORM FIP PRIMARY</td>
								<td><?php echo $row['FORM_FIP_PRIMARY']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>PERUBAHAN DATA UNIQUE</td>
								<td><?php echo $row['PERUBAHAN_DATA_UNIQUE']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>USER APP ID</td>
								<td><?php echo $row['USER_APP_ID']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>USER</td>
								<td><?php echo $row['LAST_CREATE_USER']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>AT</td>
								<td><?php echo $row['LAST_CREATE_DATE']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>LAST UPDATE USER</td>
								<td><?php echo $row['LAST_UPDATE_USER']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>LAST UPDATE DATE</td>
								<td><?php echo $row['LAST_UPDATE_DATE']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>LAST CREATE SATKER</td>
								<td><?php echo $row['LAST_CREATE_SATKER']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>LAST UPDATE SATKER</td>
								<td><?php echo $row['LAST_UPDATE_SATKER']; ?> </td>

							</tr>

						</tbody>
					</table>
				</div>
				<a href="<?php echo site_url('kinerjadisiplin'); ?>" class="btn btn-sm btn-warning">
					<< Back </a>
			</div>
		</div>


	</div>
</div>