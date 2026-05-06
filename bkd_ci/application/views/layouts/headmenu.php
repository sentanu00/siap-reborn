<nav class="navbar header-navbar pcoded-header">
<div class="navbar-wrapper">
<div class="navbar-logo" style="background: #99bdfd">
<a class="mobile-menu" id="mobile-collapse" href="#!">
<i class="feather icon-menu"></i>
</a>
<a href="" >
<img class="img-fluid" src="<?php echo base_url().'logo-siap.png';?>" width="100px" style="margin-top: -10px"  alt="Logo BKD" />
</a>
<a class="mobile-options">
<i class="feather icon-more-horizontal"></i>
</a>
</div>
<div class="navbar-container container-fluid">
<ul class="nav-left">
<li class="header-search"> 
<div class="main-search morphsearch-search">
<div class="input-group">
<span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
<input type="text" class="form-control">
<span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
</div>
</div>
</li>
<li>
<a href="#!" onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()" data-cf-modified-7ac93970d9999fd732cd8b9a-="">
<i class="feather icon-maximize full-screen"></i>
</a>
</li>
</ul>
<ul class="nav-right">

<li class="user-profile header-notification">
<div class="dropdown-primary dropdown">
<div class="dropdown-toggle" data-toggle="dropdown">
<img src="<?php echo base_url('User.png');?>" class="img-radius" alt="User-Profile-Image">
<span><?=$this->session->userdata('username');?></span>
<i class="feather icon-chevron-down"></i>
</div>
<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

<li>
<a href="<?php echo site_url('user/profile');?>">
<i class="feather icon-user"></i> Profil
</a>
</li>

<?php if($this->session->userdata('gid') ==1) : ?>
<li>
<a href="<?php echo site_url('users') ;?>">
<i class="feather icon-users"></i> Setting User
</a>
</li>

<li>
<a href="<?php echo site_url('sximo/menu/index?pos=sidebar') ;?>">
<i class="feather icon-lock"></i> Setting Menu
</a>
</li>

<li>
<a href="<?php echo site_url('hakakses') ;?>">
<i class="feather icon-check"></i> Settings Akses
</a>
</li>


<li>
<a href="<?php echo site_url('sximo/module') ;?>">
<i class="feather icon-settings"></i> Module CRUD
</a>
</li>

<?php endif;?>

<li>
<a href="<?php echo site_url('user/logout') ;?>">
<i class="feather icon-log-out"></i> Logout
</a>
</li>
</ul>
</div>
</li>
</ul>
</div>
</div>
</nav>




