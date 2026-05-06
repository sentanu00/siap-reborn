<?php
?>
<section class="section page-heading animate-onscroll">
				
				<h3><?=$row->title;?></h3>
				<p class="breadcrumb"><a href="<?=base_url();?>">Home</a> / <a href="<?=base_url('gallery');?>">Gallery</a> / <?=$row->title;?></p>
				
			</section>
<!-- Section -->
			<section class="section full-width-bg gray-bg">
				
				<div class="row">
				
					<div class="col-lg-9 col-md-9 col-sm-8">
						
					
						
						<?php
						foreach ($rowdetail as $key) {
							# code...
						
						?>
							<div class="col-lg-4 col-md-6 col-sm-12 mix category-photos" data-nameorder="1" data-dateorder="3">
							
																						<!-- Media Item -->
							<div class="media-item animate-onscroll ">
								
								<div class="media-image">
								
									<img src="<?php echo site_url();?>uploads/gallery/<?php echo $key->img;?>" alt="">
									
									<div class="media-hover">
										<div class="media-icons">
											<a href="<?php echo site_url();?>uploads/gallery/<?php echo $key->img;?>" data-group="media-jackbox" data-thumbnail="<?php echo site_url();?>uploads/gallery/<?php echo $key->img;?>" class="jackbox media-icon"><i class="icons icon-zoom-in"></i></a>
											
										</div>
									</div>
								
								</div>
								
								
																
							</div>
							<!-- /Media Item -->							
							</div>
							<?php
								}
							?>
							<!-- Post Meta Track -->
							<div class="post-meta-track animate-onscroll">
								
								<table class="project-details">
									
									<tr>
										<td class="share-media">
											<ul class="social-share">	
												<li>Share this:</li>
												<li class="facebook"><a href="#" class="tooltip-ontop" title="Facebook"><i class="icons icon-facebook"></i></a></li>
												<li class="twitter"><a href="#" class="tooltip-ontop" title="Twitter"><i class="icons icon-twitter"></i></a></li>
												<li class="google"><a href="#" class="tooltip-ontop" title="Google Plus"><i class="icons icon-gplus"></i></a></li>
												<li class="pinterest"><a href="#" class="tooltip-ontop" title="Pinterest"><i class="icons icon-pinterest-3"></i></a></li>
												<li class="email"><a href="#" class="tooltip-ontop" title="Email"><i class="icons icon-mail"></i></a></li>
											</ul>
										</td>
										
									</tr>
									
								</table>
								
							</div>
						<!-- Post Comments -->
						<div class="post-comments">
							
							<h3 class="animate-onscroll">Comments</h3>
							<div id="disqus_thread"></div>
<script>
/**
* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');

s.src = '//csrprobolinggo.disqus.com/embed.js';

s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
							
							
						</div>
						
					</div>
					
					<?php echo $sidebarpage; ?>
					
					
					
				
				</div>
				
			</section>