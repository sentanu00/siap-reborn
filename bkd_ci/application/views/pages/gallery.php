<?php
?>
<section class="section page-heading animate-onscroll">
				
				<h1><?=$nama;?></h1>
				<p class="breadcrumb"><a href="<?=base_url();?>">Home</a> / <?=$nama;?></p>
				
			</section>
<!-- Section -->
			<section class="section full-width-bg gray-bg">
				
				<div class="row">
				
					<div class="col-lg-9 col-md-9 col-sm-8">
						
						<div class="row">
							
							<div class="col-lg-12 col-md-12 col-sm-12">
								<?php
									foreach ($rows as $key) {
										# code...
									}
								?>
								<div class="col-lg-4 col-md-6 col-sm-12 mix category-photos" data-nameorder="1" data-dateorder="3">
								<div class="media-item animate-onscroll ">
								
								<div class="media-image">
								
									<img src="<?php echo site_url();?>uploads/img/<?php echo $key->img?>" alt="">
									
									<!--div class="media-hover">
										<div class="media-icons">
											<a href="img/media/media1.jpg" data-group="media-jackbox" data-thumbnail="img/media/media1.jpg" class="jackbox media-icon"><i class="icons icon-zoom-in"></i></a>
											<a href="portfolio-single-sidebar.html" class="media-icon"><i class="icons icon-link"></i></a>
										</div>
									</div-->
								
								</div>
								
																
								<div class="media-info">
								
									<div class="media-header">
										
										<div class="media-format">
											<div>
											<i class="icons icon-picture"></i>
											</div>
										</div>
										
										<div class="media-caption">
											<h2><a href="<?php echo base_url(); ?><?php echo 'gallery/'.$key->id.'-'.
			strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html"><?php echo $key->title?></a></h2>
											<span class="tags"><a href="#"><?php echo $key->tgl?></a></span>
										</div>
										
									</div>
									
									
								
								</div>
								
																
							</div>
						</div>
							</div>
							
							
						</div>
						
						<div class="animate-onscroll">
						
							<div class="divider"></div>
							
						</div>
						
					</div>
					
					<?php echo $sidebarpage; ?>
					
				
				</div>
				
			</section>