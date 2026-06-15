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
									<li class="nav-item"><a class="nav-link" href="#mfa" data-toggle="tab"><?php echo "Token / Multi-Factor Authentication"; ?> </a></li>
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

										<!-- Menampilkan pesan sukses/error -->
										<?php echo $this->session->flashdata('message'); ?>

										<div class="alert alert-info">
											<i class="fa fa-shield-alt"></i> <strong>Autentikasi Dua Langkah</strong><br>
											Pilih metode keamanan tambahan yang akan diminta setiap kali login setelah memasukkan password.
										</div>

										<!-- Status Metode Saat Ini -->
										<div class="form-group">
											<label class="control-label col-md-4">Metode Aktif</label>
											<div class="col-md-8">
												<?php if ($info->two_factor_method == 'token'): ?>
													<span class="label label-info"><i class="fa fa-key"></i> Token 6 Digit (Aktif)</span>
												<?php elseif ($info->two_factor_method == 'totp'): ?>
													<span class="label label-success"><i class="fa fa-google"></i> Google Authenticator (Aktif)</span>
												<?php else: ?>
													<span class="label label-default"><i class="fa fa-ban"></i> Belum Diaktifkan</span>
												<?php endif; ?>
											</div>
										</div>

										<!-- Jika metode = token -->
										<?php if ($info->two_factor_method == 'token'): ?>
											<div class="form-group">
												<label class="control-label col-md-4">Opsi Token</label>
												<div class="col-md-8">
													<a href="#" class="btn btn-sm btn-warning btn-generate-token">
														<i class="fa fa-refresh"></i> Generate Token Baru
													</a>
													<p class="help-block">Token 6 digit digunakan setiap login. Jika lupa atau ingin mengganti, klik tombol di samping.</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-4">Beralih Metode</label>
												<div class="col-md-8">
													<a href="<?php echo site_url('user/switch_2fa_method/totp'); ?>" class="btn btn-sm btn-primary">
														<i class="fa fa-exchange"></i> Beralih ke Google Authenticator
													</a>
												</div>
											</div>
										<?php endif; ?>

										<!-- Jika metode = totp -->
										<?php if ($info->two_factor_method == 'totp'): ?>
											<div class="form-group">
												<label class="control-label col-md-4">Opsi MFA</label>
												<div class="col-md-8">
													<a href="<?php echo site_url('user/reset_mfa'); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Reset MFA akan menonaktifkan Google Authenticator. Anda harus setup ulang. Lanjutkan?');">
														<i class="fa fa-refresh"></i> Reset MFA
													</a>
													<p class="help-block">Reset MFA jika Anda kehilangan akses ke Google Authenticator atau ingin mengganti perangkat.</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-4">Beralih Metode</label>
												<div class="col-md-8">
													<a href="<?php echo site_url('user/switch_2fa_method/token'); ?>" class="btn btn-sm btn-warning" onclick="return confirm('Beralih ke token akan menghasilkan token baru, menghapus MFA, dan Anda akan logout. Lanjutkan?');">
														<i class="fa fa-exchange"></i> Beralih ke Token 6 Digit
													</a>
												</div>
											</div>
										<?php endif; ?>

										<!-- Jika belum ada metode (two_factor_method = 'none') -->
										<?php if ($info->two_factor_method == 'none'): ?>
											<div class="form-group">
												<label class="control-label col-md-4">Aktifkan Autentikasi Dua Langkah</label>
												<div class="col-md-8">
													<a href="<?php echo site_url('user/switch_2fa_method/token'); ?>" class="btn btn-sm btn-info">
														<i class="fa fa-key"></i> Aktifkan Token 6 Digit
													</a>
													<a href="<?php echo site_url('user/switch_2fa_method/totp'); ?>" class="btn btn-sm btn-success">
														<i class="fa fa-google"></i> Aktifkan Google Authenticator
													</a>
												</div>
											</div>
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

	<!-- Modal untuk menampilkan token baru -->
	<div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="tokenModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="max-width: 450px; width: 90%;">
			<div class="modal-content">
				<div class="modal-header" style="background: #0b2b5c; color: white; border-bottom: none;">
					<button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">&times;</button>
					<h4 class="modal-title" id="tokenModalLabel" style="font-weight: 600;">
						<i class="fa fa-key"></i> Token Keamanan Baru
					</h4>
				</div>
				<div class="modal-body text-center" style="padding: 20px;">
					<p style="font-size: 14px; margin-bottom: 15px;">
						Simpan token 6 digit berikut. Token ini akan diminta saat login berikutnya.
					</p>
					<div style="background: #f5f5f5; padding: 15px 10px; border-radius: 12px; margin: 10px 0; border: 1px solid #ddd;">
						<span id="newTokenValue" style="font-size: 32px; font-weight: bold; letter-spacing: 5px; font-family: 'Courier New', monospace;">------</span>
					</div>
					<div class="alert alert-warning" style="font-size: 12px; padding: 8px 12px; margin-top: 15px; border-radius: 8px;">
						<i class="fa fa-exclamation-triangle"></i> <strong>Catatan:</strong> Token lama sudah tidak berlaku. Simpan token baru ini.
					</div>
				</div>
				<div class="modal-footer" style="border-top: none; text-align: center; padding-bottom: 20px;">
					<button type="button" class="btn btn-primary" data-dismiss="modal" style="padding: 6px 20px; background: #0b2b5c; border: none;">
						Saya Sudah Menyimpan
					</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			// Event untuk tombol Generate Token Baru
			$(document).on('click', '.btn-generate-token', function(e) {
				e.preventDefault();
				var btn = $(this);
				var originalText = btn.text();
				btn.text('Memproses...').prop('disabled', true);

				$.ajax({
					url: '<?php echo site_url('user/ajax_generate_token'); ?>',
					type: 'GET',
					dataType: 'json',
					success: function(res) {
						if (res.status === 'success') {
							$('#newTokenValue').text(res.token);
							$('#tokenModal').modal('show');
						} else {
							alert('Gagal generate token: ' + res.message);
						}
					},
					error: function() {
						alert('Terjadi kesalahan. Silakan coba lagi.');
					},
					complete: function() {
						btn.text(originalText).prop('disabled', false);
					}
				});
			});
		});
	</script>

</section>