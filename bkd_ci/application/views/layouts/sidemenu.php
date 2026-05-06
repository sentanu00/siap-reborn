<nav class="pcoded-navbar">

<div class="pcoded-inner-navbar">
<div class="pcoded-inner-navbar main-menu">
<div class="pcoded-navigatio-lavel">Navigation</div>
<ul class="pcoded-item pcoded-left-item">
<?php $sidebar = SiteHelpers::menus('sidebar');?>
<?php foreach ($sidebar as $menu) : ?>

<li class="pcoded-hasmenu">
<a <?php 
      if($menu['menu_type'] =='external') { 
        echo 'href="'.$menu['url'].'"';  
      } else {
        if($menu['module'] == '') echo 'href="#"';
        else echo 'href="'.site_url($menu['module']).'"';
      }
      ?> >
<span class="pcoded-micon"><i class="<?php echo $menu['menu_icons'];?>"></i></span>
<span class="pcoded-mtext"><?php  echo $menu['menu_name'];?></span>
</a>

<?php if(count($menu['childs']) > 0) :?>

<ul class="pcoded-submenu">

  <?php foreach ($menu['childs'] as $menu2) : ?>
<li class="pcoded-hasmenu ">
<a 
  <?php 
            if($menu2['menu_type'] =='external') {  
              echo 'href="'.$menu2['url'].'"';  
            } else {
              if($menu2['module'] == '') echo 'href="#"';
        else echo 'href="'.site_url($menu2['module']).'"';
            }
            ?>  
 data-i18n="nav.menu-levels.main">
<span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
<span class="pcoded-mtext"><?php  echo $menu2['menu_name'];?></span>
</a>

<?php if(count($menu2['childs']) > 0) : ?>
<ul class="pcoded-submenu">
   <?php foreach($menu2['childs'] as $menu3) : ?>
<li class="">
<a  <?php 
                  if($menu3['menu_type'] =='external') {  
                    echo 'href="'.$menu3['url'].'"';  
                  } else {
                    if($menu['module'] == '') echo 'href="#"';
        else echo 'href="'.site_url($menu3['module']).'"';
                  }
                  ?>  data-i18n="nav.menu-levels.menu-level-22.menu-level-31">
<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
<span class="pcoded-mtext"><?php  echo $menu3['menu_name'];?></span>
</a>
</li>
<?php endforeach;?>
</ul>
<?php endif;?>
</li>
<?php endforeach;?>
</ul>
<?php endif;?>
</li>
<?php endforeach;?> 
  
</ul>
</div>
</div>

</nav>

