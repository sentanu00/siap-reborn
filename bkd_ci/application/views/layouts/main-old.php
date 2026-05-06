<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<title><?php echo  CNF_APPNAME ;?></title>


<!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="#">
<meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
<meta name="author" content="#">

<link rel="icon" type="image/x-icon" href="<?php echo base_url('faviconsiap.ico');?>">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>/adminlte/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/adminlte/plugins/autocompletetable/tautocomplete.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/adminlte/plugins/datepicker/datepicker3.css">
     <link rel="stylesheet" href="<?php echo base_url();?>/adminlte/dist/css/AdminLTE.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/icon/themify-icons/themify-icons.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/icon/icofont/css/icofont.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/icon/feather/css/feather.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/icon/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/prism/prism.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/css/style.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>sximo/bkdtheme/files/assets/css/jquery.mCustomScrollbar.css">

<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/bootstrap/js/bootstrap.min.js"></script>




<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/data-table/js/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/data-table/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/data-table/js/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>



<script src="<?php echo base_url();?>/adminlte/plugins/select2/select2.full.js"></script>
<script src="<?php echo base_url();?>sximo/js/plugins/jquery.jCombo.min.js"></script>
<script src="<?php echo base_url();?>/adminlte/plugins/autocompletetable/tautocomplete.js"></script>
<script src="<?php echo base_url();?>/adminlte/plugins/input-mask/jquery.number.js"></script>

<script src="<?php echo base_url();?>sximo/js/plugins/parsley.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>adminlte/upload/imageuploadify.min.css">
<script src="<?php echo base_url();?>adminlte/upload/imageuploadify.min.js" type="text/javascript"></script>
<style>
.asterix{
	color:red
}
</style>

</head>

<body >

<div class="theme-loader">
<div class="ball-scale">
<div class='contain'>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
</div>
</div>
</div>

<div id="pcoded" class="pcoded">
<div class="pcoded-overlay-box"></div>
<div class="pcoded-container navbar-wrapper">
    
    <?php $this->load->view('layouts/headmenu');?>
    
    <div class="pcoded-main-container">
<div class="pcoded-wrapper">

    <?php 
    if($this->session->userdata('gid') == 3){
      $this->load->view('layouts/sidemenupegawai');
    }else{
      $this->load->view('layouts/sidemenu');  
    }
    ?>

<div class="pcoded-content">
<div class="pcoded-inner-content">

  <div class="main-body">
<div class="page-wrapper">
    <?php echo $content ;?> 
  </div>
</div>
  </div>
</div>

</div>
</div>
</div>
</div>

<div class="footer bg-inverse" style="padding: 5px 0px;">
<p class="text-center" style="font-size: 10px">Copyright © 2019. Badan Kepegawaian Daerah Kabupaten Probolinggo</p>
</div>



<div class="modal fade" id="sximo-modal"  role="dialog">
<div class="modal-dialog" id="modal-dial">
  <div class="modal-content">
  <div class="modal-header bg-default">
    
    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Modal title</h4>
  </div>
  <div class="modal-body" id="sximo-modal-content">

  </div>

  </div>
</div>
</div>


<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/bower_components/modernizr/js/css-scrollbars.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/assets/pages/prism/custom-prism.js"></script>


<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/js/pcoded.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/js/menu/menu-header-fixed.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/js/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>sximo/bkdtheme/files/assets/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>adminlte/topbar.min.js"></script>

<!--script src="<?php echo base_url();?>sximo/bkdtheme/files/assets/js/rocket-loader.min.js" ></script-->

<script type="text/javascript">
$(function() {

topbar.config({
              autoRun      : true,
              barThickness : 3,
              barColors    : {
                '0'      : 'red',
                '.25'    : 'red',
                '.50'    : 'yellow',
                '.75'    : 'yellow',
                '1.0'    : 'green'
              },
              shadowBlur   : 10,
              shadowColor  : 'rgba(0,   0,   0,   .6)',
              className    : 'topbar'
            })
});

$(document).on({
    ajaxStart: function() { ajaxindicatorstart('loading data.. please wait..');    },
     ajaxStop: function() {ajaxindicatorstop(); }    
});
  function ajaxindicatorstart(text)
{
	topbar.show()
	$('.toolbar-line').hide()
}

function ajaxindicatorstop()
{
    topbar.hide()
	$('.toolbar-line').show()
}

  function SximoModal( url , title , wid)
  {
     if(wid != 0 && wid != ''){
      $("#modal-dial").css("width",wid+"px");
      $(".modal-content").css("width",wid+"px");
     }
    $('#sximo-modal-content').html(' ....Loading content , please wait ...');
    $('.modal-title').html(title);
    $('#sximo-modal-content').load(url,function(){
    });
    $('#sximo-modal').modal('show');  
  }

   function SximoConfirmDelete( url )
{
  if(confirm('Are u sure deleting this record ? '))
  {
    window.location.href = url; 
  }
  return false;
}

function ConfirmDelete( url,id )
  {
    if(confirm('Apakah anda yakin menghapus data ini ? '))
    {
      $.ajax({
      url: url,
      data:{id:id},
      type: "POST",
      success: function(data) {
        alert("Data berhasil dihapus !!");
        table.ajax.reload( null, false );
        //window.location.reload();
      }
      });
    }
    return false;
  }


function getform(url,idpeg){
  $.ajax({
      url: url,
      data:{id:idpeg},
      type: "POST",
      dataType:"html",
      success: function(data) {
        $('#form-ajax').html(data);
      }
      });
}

function cancelform(){
  $('#form-ajax').html("");
}

</script>


</body>
</html>

