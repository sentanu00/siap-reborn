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
					<li class="breadcrumb-item"><a href="<?php echo site_url('users') ?>"><?php echo $pageTitle ?></a></li>
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
								<td width='30%' class='label-view text-right'>Group</td>
								<td><?php echo SiteHelpers::gridDisplayView($row['group_id'], 'group_id', '1:tb_groups:group_id:name'); ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Username</td>
								<td><?php echo $row['username']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>First Name</td>
								<td><?php echo $row['first_name']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Last Name</td>
								<td><?php echo $row['last_name']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Email</td>
								<td><?php echo $row['email']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Created At</td>
								<td><?php echo $row['created_at']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Last Login</td>
								<td><?php echo $row['last_login']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Active</td>
								<td><?php echo $row['active']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Activation</td>
								<td><?php echo $row['activation']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Alamat</td>
								<td><?php echo $row['alamat']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Notlp</td>
								<td><?php echo $row['notlp']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>Website</td>
								<td><?php echo $row['website']; ?> </td>

							</tr>

							<tr>
								<td width='30%' class='label-view text-right'>OPD</td>
								<td><?php echo SiteHelpers::gridDisplayView($row['satker'], 'satker', '1:vw_satker_parent:SATKER_ID:NAMA'); ?> </td>

							</tr>

						</tbody>
					</table>
				</div>
				<a href="<?php echo site_url('users'); ?>" class="btn btn-sm btn-warning">
					<< Back </a>
			</div>
		</div>


	</div>
</div>