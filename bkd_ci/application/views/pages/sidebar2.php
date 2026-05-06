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
                            <li><a href="<?=site_url(strtolower(str_replace(' ', '-', $key->nama_kategori)).'/'.$slugcat);?>"><?=$key->nama_kategori?><span>(<?=$key->total?>)</span></a></li>
                           <?
                         }
                        ?>
                      
                      </ul>
                    </div>
                  </div>
                  <div class="clear"></div>
                  <div class="sidebar-module">
                    <h4 class="sidebar-title">Data Kecamatan</h4>
                    <div class="sidebar-module-inner">
                      <div class="sidebar-text-widget">
                        <p>Data Kecamatan di Banyuwangi silahkan pilih Kecamatan untuk mendapatkan informasi terkait di Kelurahan tersebut</p>
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
                    <h4 class="sidebar-title">Data Kelurahan</h4>
                    <div class="sidebar-module-inner">
                      
                      <div style="width:100%;height:500px;overflow:auto">
                         <ul class="sidebar-category">
                        <?
                         foreach ($skelurahan as $key ) {
                           ?>
                            <li><a href="<?=site_url('wilayah-'.$key->parent_id.'-'.strtolower(str_replace(' ', '-', $key->nama_parent)).'/'.$key->id.'-'.strtolower(str_replace(' ', '-', $key->nama)));?>"><?=$key->nama?><span>(<?=$key->total?>)</span></a></li>
                           <?
                         }
                        ?>
                      </ul>
                    </div>
                    </div>
                  </div>
                  
                  <div class="clear"></div>
                  
                 

                </div>
              
              </aside> 