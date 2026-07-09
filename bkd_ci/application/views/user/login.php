<section class="login-block">

	<div class="container">
		<div class="row">
			<div class="col-sm-12">


				<?php $attributes = array('class' => "md-float-material form-material", 'autocomplete' => 'off'); ?>
				<?php echo form_open('user/postlogin', $attributes); ?>

				<div class="auth-box card">
					<div class="card-block">
						<div class="row m-b-20">
							<div class="col-md-12">

								<h3 class="text-center">SIAP REBORN</h3>
								<div class="text-center">
									<span style="font-size: 14px"><b>Badan Kepegawaian Dan<br>Pengembangan Sumber Daya Manusia</b><br />Kabupaten Probolinggo</span>
									<!--img src="<?php echo base_url() . 'logo.jpf'; ?>"  height="70" /-->
								</div>
								<?php echo $this->session->flashdata('message'); ?>
							</div>
						</div>

						<!-- INPUT PALSU UNTUK MEMBINGUNGKAN BROWSER -->
						<div style="display:none">
							<input type="text" name="fake_username" id="fake_username" value="">
							<input type="password" name="fake_password" id="fake_password" value="">
						</div>

						<div class="form-group form-primary">
							<input type="text" name="username" class="form-control" required="" placeholder="Your Username"
								autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
							<span class="form-bar"></span>
						</div>
						<div class="form-group form-primary">
							<input type="password" name="password" class="form-control" required="" placeholder="Password"
								autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="off" readonly onfocus="this.removeAttribute('readonly')">
							<span class="form-bar"></span>
						</div>
						<div class="row m-t-25 text-left">
							<div class="col-12">
								<div class="checkbox-fade fade-in-primary d-">
									<label>
										<input type="checkbox" value="">
										<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
										<span class="text-inverse">Remember me</span>
									</label>
								</div>
								<div class="forgot-phone text-right f-right">
									<a href="<?php echo site_url('user/forgot_password'); ?>" class="text-right f-w-600">Lupa Password?</a>
								</div>
							</div>
						</div>
						<div class="row m-t-30">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
							</div>
						</div>
						<hr />

					</div>
				</div>
				</form>

			</div>

		</div>

	</div>

</section>