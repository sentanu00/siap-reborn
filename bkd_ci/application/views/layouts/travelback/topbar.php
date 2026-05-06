<?php $menus = SiteHelpers::menus('top') ;?>
<header id="header">
	  
			<!-- start Navbar (Header) -->
			<nav class="navbar navbar-primary navbar-fixed-top navbar-sticky-function">

				<div class="navbar-top">
				
					<div class="container">
						
						<div class="flex-row flex-align-middle">
							<div class="flex-shrink flex-columns">
								<a class="navbar-logo" data-toggle="modal" href="#">
									<span style="color:white;font-size:21px">Website TTG Banyuwangi</span>
								</a>
							</div>
							<div class="flex-columns">
								<div class="pull-right">
								
									<div class="navbar-mini">
							
							
										<ul class="clearfix">
										
											<li class="dropdown bt-dropdown-click hidden-xs">
												<a href="https://www.facebook.com/ttgbanyuwangi/" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook" target="_blank"></i></a>
												
											</li>
											
											<li class="dropdown bt-dropdown-click hidden-xs">
												<a href="https://twitter.com/ttgbanyuwangi" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter" target="_blank"></i></a>
											</li>
											
											
											

										</ul>
									</div>
						
								</div>
							</div>
						</div>

					</div>
					
				</div>
				
				<div class="navbar-bottom hidden-sm hidden-xs">
				
					<div class="container">
					
						<div class="row">
						
							<div class="col-sm-9">
								
								<div id="navbar" class="collapse navbar-collapse navbar-arrow">
									<ul class="nav navbar-nav" id="responsive-menu">
										<?php foreach ($menus as $menu){?>
			 <li class="<?php if($this->uri->segment(1) == $menu['module']) echo 'active';?>" >
			 	<a  
				<?php if($menu['menu_type'] =='external'){?>
					href="<?php echo $menu['url'];?>" 
				<?php }else{ ?>
					href="<?php echo site_url($menu['module']);?>" 
				<?php } ?> 
			 
				 <?php if(count($menu['childs']) > 0 ) echo 'class="dropdown-toggle" data-toggle="dropdown" ';?>>
			 		<i class="<?php  echo $menu['menu_icons'];?>"></i> <span>
						<?php	
						
							if(CNF_MULTILANG ==1 && isset($menu['menu_lang']['title'][$this->session->userdata('lang')])){
								echo  $menu['menu_lang']['title'][$this->session->userdata('lang')] ;
							}else{
								echo $menu['menu_name'];
							}
						?>	

					</span>
					<?php  if(count($menu['childs']) > 0 ){ ?>
					
					<?php }?>  
				</a> 
				<?php if(count($menu['childs']) > 0){?>
					 <ul class="dropdown-menu dropdown-menu-right">
						<?php foreach ($menu['childs'] as $menu2){?>
						 <li class=" 
						 <?php if(count($menu2['childs']) > 0) echo 'dropdown-submenu';?>
						 <?php if($this->uri->segment(1) == $menu2['module']) echo 'active ';?>">
						 	<a 
								<?php if($menu2['menu_type'] =='external'){?>
									href="<?php  echo $menu2['url'];?>" 
								<?php }else{?>
									href="<?php  echo site_url($menu2['module']);?>" 
								<?php }?>
											
							>
								<i class="<?php echo $menu2['menu_icons'];?>"></i> 
								<?php	
								
									if(CNF_MULTILANG ==1 && isset($menu2['menu_lang']['title'][$this->session->userdata('lang')])){
										echo  $menu2['menu_lang']['title'][$this->session->userdata('lang')] ;
									}else{
										echo $menu2['menu_name'];
									}
								?>	
							</a> 
							<?php if(count($menu2['childs']) > 0){?>
							<ul class="dropdown-menu dropdown-menu-right">
								<?php foreach($menu2['childs'] as $menu3){?>
									<li <?php  if($this->uri->segment(1) == $menu3['module']) echo 'class="active"';?>>
										<a 
											<?php if($menu3['menu_type'] =='external'){?>
												href="<?php  echo $menu3['url'];?>" 
											<?php }else {?>
												href="<?php echo site_url($menu3['module']);?>" 
											<?php }?>										
										
										> <i class="<?php  echo $menu3['menu_icons'];?>"></i>
											<span>
											<?php	
											
												if(CNF_MULTILANG ==1 && isset($menu3['menu_lang']['title'][$this->session->userdata('lang')])){
													echo  $menu3['menu_lang']['title'][$this->session->userdata('lang')] ;
												}else{
													echo $menu3['menu_name'];
												}
											?>	
											</span>  
										</a>
									</li>	
								<?php } ?>
							</ul>
							<?php }?>						
							
						</li>							
						<?php }?>
					</ul>
				<?php }?>
			</li>
		<?php }?> 
									</ul>
								</div><!--/.nav-collapse -->
								
							</div>
							
							<div class="col-sm-3">
							
								<div class="navbar-phone"><i class="fa fa-mail"></i> info@ttgbanyuwangi.com </div>
							
							</div>

						</div>
						
					</div>
				
				</div>

				<div id="slicknav-mobile"></div>
				
			</nav>
			<!-- end Navbar (Header) -->

		</header>
		
		<div class="clear"></div>