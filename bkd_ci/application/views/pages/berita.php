<div class="main-wrapper scrollspy-container">
		
			<!-- start end Page title -->
			<div class="page-title" style="background-image:url('<?=base_url().''.$slide->img;?>');">
				
				<div class="container">
				
					<div class="row">
					
						<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
						
							<h1 class="hero-title"><?=$rows->title;?></h1>
							
							<ol class="breadcrumb-list">
								<li><a href="<?=site_url();?>">Beranda</a></li>
								<?
								$link = 'wilayah-';
								foreach ($bcum as $key => $value) {
									$link .= $value.'/';
									?>
										<li><a href="<?=site_url($link);?>"><?=$nama[$key];?></a></li>
									<?
								}
								?>
							</ol>
							
						</div>
						
					</div>

				</div>
				
			</div>
			<!-- end Page title -->
			
			<div class="content-wrapper">
			
				<div class="container">
				
					<div class="row">
					
						<div class="col-sm-8 col-md-9">
						
							<div class="blog-wrapper">

								<div class="blog-item blog-single">
								
									<div class="blog-media">
										<div class="flexslider-image-bg" style="height:300px;background: url(<?=base_url().''.$rows->img;?>) center center no-repeat; background-size:cover">
                </div>
									</div>
											
									<div class="blog-content">
										<h3><?=$rows->title;?></h3>
										<ul class="blog-meta clearfix">
											<li>by <a href="#"><?=$rows->userpost;?></a></li>
											<li><?=$rows->tglpost;?></li>
										</ul>
										<div class="blog-entry">  
											<?=$rows->descripsi;?>		
										</div>
									</div>
								
									<div class="blog-extra">
										<div class="row">
											<div class="col-xs-12 col-sm-6 col-md-7 xs-mb">
												
											</div>
											
											<div class="col-xs-12 col-sm-6 col-md-5 xs-mb">
												<ul class="social-share-sm mt-5 pull-right pull-left-xs mt-20-xs">
																		
													<li><span><i class="fa fa-share-square"></i> share</span></li>
													<li class="the-label"><a href="#">Facebook</a></li>
													<li class="the-label"><a href="#">Twitter</a></li>
													<li class="the-label"><a href="#">Google Plus</a></li>
													
												</ul>
											</div>
											<div class="clear"></div>
										</div>
									</div>
									
									
									<h4 class="uppercase"> Komentar</h4>
									
									<div id="comment-wrapper">
									<?
									foreach ($komentar as $key) {
										# code...
									}
									?>
										<ul class="comment-item">
											<li>
												<div class="comment-avatar">
													<img src="<?=base_url()?>User.png" alt="author image">
												</div>
												<div class="comment-header">
													<h6 class="heading mt-0"><?=$key->nama;?></h6>
													<span class="comment-time">23 minutes</span>
												</div>
												<div class="comment-content">
													<p><?=$key->komentar;?> </p>
												</div>
									</ul>
										
										<div class="clear"></div>
										
										
									</div><!-- End Comment -->
									
									<h3 class="uppercase">Leave a Comment</h3>

									<form method="post" id="contactForm" action="post" class="comment-form">
										<div class="row">
											<div class="col-xs-12 col-sm-6 col-md-6">
												<div class="form-group">
													<label for="comment-name">Your Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="comment-name">
												</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-6">
												<div class="form-group">
													<label for="comment-email">Your Email <span class="text-danger">*</span></label>
													<input type="text" class="form-control" id="comment-email">
												</div>
											</div>
										</div>
										<div class="clear"></div>
										<div class="row">
											<div class="col-md-12 mb-30">
												<div class="form-group">
													<label for="comment-message">Message <span class="text-danger">*</span></label>
													<textarea name="message" id="comment-message" class="form-control" rows="8"></textarea>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<button type="submit" class="btn btn-primary">Comment</button>
											</div>
										</div>
									</form>

									<div class="clear"></div>
									
									
									</div>
								
							</div>
						
						</div>
						
						<div class="col-sm-4 col-md-3 mt-50-xs">
						
							<?=$sidebar;?>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			

		</div>