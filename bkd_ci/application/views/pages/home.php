<div class="main-wrapper">
<div class="flexslider-hero-slider">
        <div id="mainFlexSlider">
          <div class="flexslider">
            <ul class="slides">
              <?php
              foreach ($slide as $key) {
                # code...
                ?>
                <li class="slide">
                <div class="flexslider-image-bg " style="background: url(<?=base_url().''.$key->img;?>) center center no-repeat; background-size:cover">
                </div>
                 <div class="main-search-holder flexslider-overlay">
            
          <div class="container">
  
            <div class="row">
          
              <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
              
                <h1 class="hero-title" style="font-size:40px"><?=ucwords($key->title);?></h1>
                <p class="lead" style="font-size:15px"><?
                      $str = substr(strip_tags($key->descripsi), 0, 150) . ' ';
                      echo $str;
                      ?><a href="<?php echo site_url(); ?>/berita-<?=$key->id;?>-<?php echo strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html" class="btn-blog">Read More <i class="fa fa-long-arrow-right"></i></a></p>

              </div>
              
            </div>
            
            

          </div>
        
        </div>
              </li><!-- slide1 end -->
                <?
              }
              ?>
              

              
            </ul><!-- slides end -->

            
          </div><!-- flexslider end -->
        </div>
        
       
        
      </div>
      
      <div class="clear"></div>


      <section>
      
        <div class="container">
          
          <div class="content-wrapper">
      
        <div class="container">
        
          <div class="row">
          
            <div class="col-sm-8 col-md-9">
            
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
            
            <div class="col-sm-4 col-md-3 mt-50-xs">
            
              <?=$sidebar;?>
              
            </div>
          
          </div>
          
        </div>
        
      </div>
          
        </div>
        
      </section>
      
      
      
      
      
    
      
      
      </div>