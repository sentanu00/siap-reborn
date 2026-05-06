<!-- start end Page title -->
<div class="main-wrapper">
			<div class="page-title" style="background-image:url('<?=base_url().''.$slide->img;?>');">
				
				<div class="container">
				
					<div class="row">
					
						<div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
						
							<h1 class="hero-title"><?=$t_nama;?></h1>
							<span style="font-size:15px"><?=$t_desc;?></span>
							<ol class="breadcrumb-list">
								<li><a href="<?=site_url();?>">Beranda</a></li>
								<?
								$link = '';
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
						
						<div class="col-sm-12 col-md-12">
							
							<div class="col-sm-8 col-md-9" >
							
							<div class="blog-wrapper">
                <?
                         foreach ($rows as $key ) {
                           ?>
                <!--div class="col-sm-6 col-md-6"-->
                <div class="blog-item">
                
                  <div class="blog-media">
                    <div class="overlay-box">
                      <a class="blog-image" href="<?php echo site_url(); ?>/berita-<?=$key->id;?>-<?php echo strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html">
                        <div class="flexslider-image-bg" style="height:200px;background: url(<?=base_url().''.$key->img;?>) center center no-repeat; background-size:cover">
                </div>
                        <div class="image-overlay">
                          <div class="overlay-content">
                            <!--div class="absolute-in-image">
                            <p class="lead" style="color:white;margin:5px;"><?=$key->title?></p>
                          </div-->
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                      
                  <div class="blog-content">
                    <h4><a href="<?php echo site_url(); ?>/berita-<?=$key->id;?>-<?php echo strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html" class="inverse"><?=$key->title?></a></h4>
                    <ul class="blog-meta clearfix">
                      <li>by <a href="#"><?=$key->userpost?></a></li>
                      <li>on <?=$key->tglpost1?></li>
                    </ul>
                    <div class="blog-entry">  
                      <?
                      $str = substr(strip_tags($key->descripsi), 0, 150) . ' ';
                      echo $str;
                      ?><a href="<?php echo site_url(); ?>/berita-<?=$key->id;?>-<?php echo strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html" class="btn-blog">Read More <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                    
                  </div>
                
                </div>
                <!--/div-->
                <?
                         }
                        ?>
               
                <div class="clear"></div>
                
                <div class="pager-wrappper mt-0 clearfix">
      
                  <div class="pager-innner">
                  
                    <?=$pages;?>
                    
                  </div>
                  
                </div>
                
              </div>
							</div>
							<div class="col-sm-4 col-md-3 " >
								<?=$sidebar;?>
							</div>
							
							
						</div>
						
					</div>
					
				</div>
				
			</div>
</div>
			