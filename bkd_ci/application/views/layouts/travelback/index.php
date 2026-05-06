
<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?=$w_title;?> | TTG Banyuwangi</title>
	<meta name="description" content=" <?=$w_desc;?>" />
	<meta name="keywords" content="ttg,ttg banyuwangi,kementrian,kemendes, profil desa, profil daerah, banyuwangi, <?=$w_key;?>" />
	<meta name="author" content="TTG Banyuwangi">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- Fav and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="images/ico/favicon.png">

	<!-- CSS Plugins -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'sximo/themes/tourpacker/';?>bootstrap/css/bootstrap.min.css" media="screen">	
	<link href="<?php echo base_url().'sximo/themes/tourpacker/';?>css/animate.css" rel="stylesheet">
	<link href="<?php echo base_url().'sximo/themes/tourpacker/';?>css/main.css" rel="stylesheet">
	<link href="<?php echo base_url().'sximo/themes/tourpacker/';?>css/component.css" rel="stylesheet">
	
	<!-- CSS Font Icons -->
	<!-- CSS Font Icons -->
	<link rel="stylesheet" href="<?php echo base_url().'sximo/themes/tourpacker/';?>icons/ionicons/css/ionicons.css">
	<link rel="stylesheet" href="<?php echo base_url().'sximo/themes/tourpacker/';?>icons/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url().'sximo/themes/tourpacker/';?>icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
	<link rel="stylesheet" href="<?php echo base_url().'sximo/themes/tourpacker/';?>icons/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" href="<?php echo base_url().'sximo/themes/tourpacker/';?>icons/themify-icons/themify-icons.css">
	<link rel="stylesheet" href="<?php echo base_url().'sximo/themes/tourpacker/';?>icons/rivolicons/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

	<!-- CSS Custom -->
	<link href="<?php echo base_url().'sximo/themes/tourpacker/';?>css/style.css" rel="stylesheet">
	

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		.flexslider-image-bg {
    height: 450px;
}
	</style>
</head>

<body style="overflow-x:hidden;">

	<div id="introLoader" class="introLoading"></div>
	
	<!-- BEGIN # MODAL LOGIN -->
	<div class="modal fade modal-login modal-border-transparent" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<button type="button" class="btn btn-close close" data-dismiss="modal" aria-label="Close">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
				
				<div class="clear"></div>
				
				<!-- Begin # DIV Form -->
				<div id="modal-login-form-wrapper">
					
					<!-- Begin # Login Form -->
					<form id="tanya-form">
					
						<div class="modal-body pb-5">
					
							<h4 class="text-center heading mt-10 mb-20">Ada Pertanyaan ? Monggo Silahkan</h4>
							<div style="text-align:center" id="flashpesan"></div>
							<div class="modal-seperator">
								<span>BTO</span>
							</div>
							<?
							$agent = $_SERVER['HTTP_USER_AGENT'] ;
							$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							$ip = $_SERVER['REMOTE_ADDR'];
							if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
							    $ip = $_SERVER['HTTP_CLIENT_IP'];
							} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
							    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
							} 
							?>
							<input name="url" class="form-control" value="<?=$url;?>" type="hidden">
							<input name="titleurl" class="form-control" value="<?=$w_title;?>" type="hidden">
							<input name="status" class="form-control" value="0" type="hidden">
							<input name="jenis" class="form-control" value="6" type="hidden">
							<input name="ipaddr" class="form-control" value="<?=$ip;?>" type="hidden">
							<input name="browser" class="form-control" value="<?=$agent;?>" type="hidden">

							<div class="form-group"> 
								<input name="nama" id="pnama" class="form-control" required placeholder="Nama Anda" type="text"> 
							</div>
							<div class="form-group"> 
								<input name="email" id="pemail" class="form-control" required placeholder="E-mail@anda" type="email"> 
							</div>
							<div class="form-group"> 
								<textarea class="form-control" name="catatan" id="pcatatan" required placeholder="Isi Pertanyan disini" row="10"></textarea>
							</div>
			
							
						
						</div>
						
						<div class="modal-footer">
						
							<div class="row gap-10">
								<div class="col-xs-6 col-sm-6 mb-10">
									<button type="submit" class="btn btn-primary btn-block">Kirim</button>
								</div>
								<div class="col-xs-6 col-sm-6 mb-10">
									<button type="submit" class="btn btn-primary btn-block btn-inverse" data-dismiss="modal" aria-label="Close">Batal</button>
								</div>
							</div>
							
							
						</div>
					</form></div></div></div></div>
	<!-- start Container Wrapper -->
	<div class="container-wrapper">

	<?php $this->load->view('layouts/travelback/topbar');?>
	<!-- header section-->
		
		<!-- start Main Wrapper -->
		
		
			

				<!-- main section -->
				<?php echo $content ?>
			
		
		<!-- end Main Wrapper -->

		<footer class="footer">
			
			<div class="container">
			
				<div class="main-footer">
				
					<div class="row">
				
						<div class="col-xs-12 col-sm-6 col-md-6">
						
							<div class="footer-social">
							
								<a href="https://www.facebook.com/BTOAdventure/" data-toggle="tooltip" data-placement="top" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
								<a href="https://twitter.com/blakraxtrip" data-toggle="tooltip" data-placement="top" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
								<a href="https://plus.google.com/+BlakraxTripOrganizerMalang/posts" data-toggle="tooltip" data-placement="top" target="_blank" title="Google Plus"><i class="fa fa-google-plus"></i></a>
								<a href="https://www.instagram.com/blakraxtriporganizer/" target="_blank" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram"></i></a>
							
							</div>
							
							<p class="copy-right">&#169; Copyright 2016 TTG Banyuwangi. development By BTO Dev </p>
							
						</div>
						
						
						
					</div>

				</div>
				
			</div>
			
		</footer>
		
	</div>  <!-- end Container Wrapper -->
 

 
	<!-- start Back To Top -->
	<div id="back-to-top">
		 <a href="#"><i class="fa fa-angle-up"></i></a>
	</div>
	<!-- end Back To Top -->



<!-- JS -->
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/SmoothScroll.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.slicknav.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/instagram.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/spin.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.introLoader.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/select2.full.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.responsivegrid.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/readmore.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/slick.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/validator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.raty.js"></script> 
<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/customs.js"></script>

<script type="text/javascript" src="<?php echo base_url().'sximo/themes/tourpacker/';?>js/jquery.flexslider-min.js"></script> 
<script>
$(document).ready(function(){


	$('#mainFlexSlider').flexslider(
		{
			animation: 'fade',
			slideshow: true,
			pauseOnHover: false,  
			controlNav: false,
			directionNav: false,
			slideshowSpeed: 4000, 
		}
	);

});

/**
*  Sidebar Sticky
*/

!function ($) {

  $(function(){

    var $window = $(window)
    var $body   = $(document.body)

    var navHeight = $('.navbar').outerHeight(true) + 50

    $body.scrollspy({
      target: '.scrollspy-sidebar',
      offset: navHeight
    })

    $window.on('load', function () {
      $body.scrollspy('refresh')
    })

    $('.scrollspy-container [href=#]').click(function (e) {
      e.preventDefault()
    })

    // back to top
    setTimeout(function () {
      var $sideBar = $('.scrollspy-sidebar')

      $sideBar.affix({
        offset: {
          top: function () {
            var offsetTop      = $sideBar.offset().top
            var sideBarMargin  = parseInt($sideBar.children(0).css('margin-top'), 10)
            var navOuterHeight = $('.scrollspy-nav').height()

            return (this.top = offsetTop - navOuterHeight - sideBarMargin)
          }
        , bottom: function () {
            return (this.bottom = $('.scrollspy-footer').outerHeight(true))
          }
        }
      })
    }, 100)
		
  })

}(window.jQuery);


$('.star-rating-12px').raty({
			path: "<?=base_url().'sximo/themes/tourpacker/';?>images/raty",
			starHalf: 'star-half-sm.png',
			starOff: 'star-off-sm.png',
			starOn: 'star-on-sm.png',
			readOnly: true,
			round : { down: .2, full: .6, up: .8 },
			half: true,
			space: false,
			score: function() {
				return $(this).attr('data-rating-score');
			}
		});
</script>

</body>
</html>