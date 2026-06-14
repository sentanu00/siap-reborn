<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo $pageTitle; ?></h3>
					<div class="box-body">

						<div class="page-content-wrapper m-t">
							<!-- Page header -->

							<div class="page-content-wrapper m-t">
								<ul class="nav nav-tabs nav-underline">
									<li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab"><?php echo $this->lang->line('core.personalinfo'); ?> </a></li>
									<li class="nav-item"><a class="nav-link" href="#pass" data-toggle="tab"><?php echo $this->lang->line('core.password'); ?> </a></li>
									<li class="nav-item"><a class="nav-link" href="#mfa" data-toggle="tab"><?php echo "Multi-Factor Authentication"; ?> </a></li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active m-t" id="info">
										<br />
										<?php echo $this->session->flashdata('message'); ?>
										<?php echo validation_errors(); ?>
										<form class="form-horizontal" action="<?php echo site_url('user/saveProfile'); ?>" method="post" parsley-validate='true' novalidate='true' enctype="multipart/form-data">
											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"> Username </label>
												<div class="col-md-8">
													<input name="username" type="text" id="username" disabled="disabled" class="form-control input-sm" required value="<?php echo $info->username; ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"> Email </label>
												<div class="col-md-8">
													<input name="email" type="email" id="email" class="form-control" value="<?php echo $info->email ?>" />
													<?php echo form_error('email'); ?>
												</div>
											</div>

											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.firstname'); ?> </label>
												<div class="col-md-8">
													<input name="first_name" type="text" id="first_name" class="form-control " required value="<?php echo $info->first_name ?>" />
												</div>
											</div>

											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.lastname'); ?> </label>
												<div class="col-md-8">
													<input name="last_name" type="text" id="last_name" class="form-control " required value="<?php echo $info->last_name ?>" />
												</div>
											</div>

											<div class="form-group  ">
												<label for="ipt" class=" control-label col-md-4 text-right"> Avatar </label>
												<div class="col-md-8">
													<input type="file" name="avatar">
													<br />
													Image Dimension 80 x 80 px <br />
													<?php echo SiteHelpers::showUploadedFile($info->avatar, '/uploads/users/') ?>

												</div>
											</div>

											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"> </label>
												<div class="col-md-8">
													<button class="btn btn-success" type="submit"><?php echo $this->lang->line('core.sb_savechanges'); ?> </button>
												</div>
											</div>

										</form>
									</div>

									<div class="tab-pane  m-t" id="pass">
										<br />
										<form class="form-horizontal" action="<?php echo site_url('user/savePassword'); ?>" method="post" parsley-validate='true' novalidate='true'>

											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.newpassword'); ?> </label>
												<div class="col-md-8">
													<input name="password" type="password" id="password" class="form-control input-sm" value="" />
												</div>
											</div>

											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.repassword'); ?> </label>
												<div class="col-md-8">
													<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />
												</div>
											</div>


											<div class="form-group">
												<label for="ipt" class=" control-label col-md-4"> </label>
												<div class="col-md-8">
													<button class="btn btn-danger" type="submit"><?php echo $this->lang->line('core.sb_savechanges'); ?> </button>
												</div>
											</div>
										</form>
									</div>

									<div class="tab-pane m-t" id="mfa">
										<br />
										<div class="alert alert-info">
											<i class="fa fa-shield-alt"></i> <strong>Multi-Factor Authentication (MFA)</strong><br>
											Tingkatkan keamanan akun Anda dengan mengaktifkan MFA menggunakan Google Authenticator.
										</div>

										<div class="form-group">
											<label class="control-label col-md-4">Status MFA</label>
											<div class="col-md-8">
												<?php if (!empty($info->mfa_enabled) && $info->mfa_enabled == 1): ?>
													<span class="label label-success"><i class="fa fa-check-circle"></i> AKTIF</span>
													<p class="help-block">MFA sudah aktif. Setiap login akan memerlukan kode OTP dari Google Authenticator.</p>
												<?php else: ?>
													<span class="label label-danger"><i class="fa fa-times-circle"></i> NONAKTIF</span>
													<p class="help-block">MFA belum diaktifkan. Klik tombol di bawah untuk mengatur.</p>
												<?php endif; ?>
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-offset-4 col-md-8">
												<?php if (empty($info->mfa_enabled) || $info->mfa_enabled == 0): ?>
													<a href="<?php echo site_url('user/setup_mfa'); ?>" class="btn btn-primary">
														<i class="fa fa-qrcode"></i> Setup Google Authenticator
													</a>
												<?php else: ?>
													<a href="<?php echo site_url('user/reset_mfa'); ?>" class="btn btn-warning" onclick="return confirm('Reset MFA akan menonaktifkan perlindungan dua langkah. Anda harus setup ulang. Lanjutkan?');">
														<i class="fa fa-refresh"></i> Reset MFA
													</a>
												<?php endif; ?>
											</div>
										</div>
									</div>



								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>