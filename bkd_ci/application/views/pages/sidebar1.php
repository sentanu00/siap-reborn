<aside class="sidebar">
            
                <div class="sidebar-inner no-border for-blog">
                
                  <!--div class="sidebar-module">
                    <div class="sidebar-module-inner">
                      <div class="sidebar-mini-search">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Search for...">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="clear"></div-->

                  <div class="sidebar-module">
                    <h4 class="sidebar-title">Kategori</h4>
                    <div class="sidebar-module-inner">
                      <ul class="sidebar-category">
                        <?
                         foreach ($scategory as $key ) {
                           ?>
                            <li><a href="<?=site_url(strtolower(str_replace(' ', '-', $key->nama_kategori)));?>"><?=$key->nama_kategori?><span>(<?=$key->total?>)</span></a></li>
                           <?
                         }
                        ?>
                      
                      </ul>
                    </div>
                  </div>
                  
                  <div class="sidebar-module">
                    <h4 class="sidebar-title">Data Kecamatan</h4>
                    <div class="sidebar-module-inner">
                      <div class="sidebar-text-widget">
                        <p>Data Kecamatan di Banyuwangi silahkan pilih kecamatan untuk mendapatkan informasi terkait di kecamatan tersebut</p>
                      </div>
                      <div style="width:100%;height:500px;overflow:auto">
                         <ul class="sidebar-category">
                        <?
                         foreach ($skecamatan as $key ) {
                           ?>
                            <li><a href="<?=site_url('wilayah-'.$key->id.'-'.strtolower(str_replace(' ', '-', $key->nama)));?>"><?=$key->nama?><span>(<?=$key->total?>)</span></a></li>
                           <?
                         }
                        ?>
                      </ul>
                    </div>
                    </div>
                  </div>
                  
                  <div class="clear"></div>
                  
                  <div class="sidebar-module">
                    <h4 class="sidebar-title">Berita Terbaru</h4>
                    <div class="sidebar-module-inner">
                    
                      <ul class="sidebar-post">
                         <?
                         foreach ($slatest as $key ) {
                           ?>
                        <li class="clearfix">
                          <a href="<?php echo site_url(); ?>/berita-<?=$key->id;?>-<?php echo strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html">
                            <div class="image">
                              <img src="<?=base_url().''.$key->img;?>" alt="<?=$key->title?>">
                            </div>
                            <div class="content">
                              <h6><?=$key->title?></h6>
                              <p class="recent-post-sm-meta"><i class="fa fa-clock-o mr-5"></i><?=$key->tglpost?></p>
                            </div>
                          </a>
                        </li>
                         <?
                         }
                        ?>
                      </ul>
                    
                    </div>
                  </div>
                  
                  <div class="clear"></div>
                  
                  <div class="sidebar-module">
                    <h4 class="sidebar-title">Berita Pilihan</h4>
                    <div class="sidebar-module-inner">
                      
                      <ul class="sidebar-post">
                           <?
                         foreach ($spopular as $key ) {
                           ?>
                        <li class="clearfix">
                          <a href="<?php echo site_url(); ?>/berita-<?=$key->id;?>-<?php echo strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\s]/", "", $key->title))); ?>.html">
                            <div class="image">
                              <img src="<?=base_url().''.$key->img;?>" alt="<?=$key->title?>">
                            </div>
                            <div class="content">
                              <h6><?=$key->title?></h6>
                              <p class="recent-post-sm-meta"><i class="fa fa-clock-o mr-5"></i><?=$key->tglpost?></p>
                            </div>
                          </a>
                        </li>
                         <?
                         }
                        ?>
                      </ul>
                    
                    </div>
                  </div>
                  
                  <div class="clear"></div>
                  
                 

                </div>
              
              </aside>