<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo  CNF_APPNAME ;?></title>
    <link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/bootstrap/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins-->
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/plugins/datepicker/datepicker3.css">


    <link rel="stylesheet" href="<?php echo base_url();?>adminlte/plugins/autocompletetable/tautocomplete.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?php echo base_url();?>adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url();?>sximo/js/plugins/jquery.cookie.js"></script>
    <script src="<?php echo base_url();?>adminlte/plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>adminlte/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url();?>adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url();?>adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url();?>adminlte/plugins/select2/select2.full.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url();?>adminlte/plugins/iCheck/icheck.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>adminlte/dist/js/app.min.js"></script>

    <script src="<?php echo base_url();?>sximo/js/plugins/jquery.jCombo.min.js"></script>
    <script src="<?php echo base_url();?>adminlte/plugins/autocompletetable/tautocomplete.js"></script>
    <script src="<?php echo base_url();?>adminlte/plugins/input-mask/jquery.number.js"></script>

    <!-- datepicker -->
    <script src="<?php echo base_url();?>adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url();?>sximo/js/plugins/parsley.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>sximo/js/plugins/bootstrap/maskmoney.js"></script>

    <style type="text/css">
        .number{
            text-align: right;
        }
    </style>
</head>

<body>

<body class="hold-transition skin-blue">
<div id="wrapper">

        <?php echo $content ;?>
</div>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright © 2018 <a href="#">SIMPG - PT. Perkebunan Nusantara XI</a>.</strong> All rights
    reserved.
</footer>



<script type="text/javascript">

    $(document).on({
        ajaxStart: function() { ajaxindicatorstart('loading data.. please wait..');    },
        ajaxStop: function() {ajaxindicatorstop(); }
    });

    function ajaxindicatorstart(text)
    {
        $('#imglogo').attr('src',"<?php echo base_url().'loading.gif'?>");
        jQuery('body').css('cursor', 'wait');
    }

    function ajaxindicatorstop()
    {
        $('#imglogo').attr('src',"<?php echo base_url('logo.png');?>");
        jQuery('body').css('cursor', 'default');
    }

    var intVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };

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

    function SximoConfirmDelete( url )
    {
        if(confirm('Are u sure deleting this record ? '))
        {
            window.location.href = url;
        }
        return false;
    }

    function SximoModal( url , title , wid)
    {
        if(wid != 0 && wid != ''){
            $("#modal-dial").css("width",wid+"px");
        }
        $('#sximo-modal-content').html(' ....Loading content , please wait ...');
        $('.modal-title').html(title);
        $('#sximo-modal-content').load(url,function(){
        });
        $('#sximo-modal').modal('show');
    }

    jQuery(document).ready(function ($) {
        $(".select2").select2();
        $("form").submit(function(){
            var temp1 = 0;
            $('.parsley-error-list').each(function(){
                temp1++;
            });

            if(temp1 > 0){
                $('input[type="submit"]').hide();
            }
        });


        $('input[type="checkbox"], input[type="radio"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        $('.date').datepicker({format:'yyyy-mm-dd',}).on('changeDate',function(e){
            $(this).datepicker('hide');
        })

        $('form').submit(function() {
            // your code here
            $('.number').each(function(i, obj) {
                // $(this).val($(this).autoNumeric('get'));
            });
            $('.number-d').each(function(i, obj) {
                //$(this).val($(this).autoNumeric('get'));
            });
        });
        //notif();
        /*$('.number').autoNumeric('init',{
         aPad:false,
         aSign: '',
         mDec:3
         });
         $('.number-d').autoNumeric('init',{
         pSign: 's',
         aSign: ' %'

         });
         */
    });


    /*
     function PopupCenter(url, title, w, h) {
     // Fixes dual-screen position                         Most browsers      Firefox
     var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
     var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

     var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
     var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

     var left = ((width / 2) - (w / 2)) + dualScreenLeft;
     var top = ((height / 2) - (h / 2)) + dualScreenTop;
     var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

     // Puts focus on the newWindow
     if (window.focus) {
     newWindow.focus();
     }
     }
     */

    function PopupCenter(url, title, w, h) {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    }



    function ConfirmGetit( url,id ,stt)
    {
        if(confirm('Apakah anda yakin melakukan ini ? '))
        {
            $.ajax({
                url: url,
                data:{id:id,stt:stt},
                type: "POST",
                success: function(data) {
                    alert("Data berhasil update !!");
                    table.ajax.reload( null, false );
                    //window.location.reload();
                }
            });
        }
        return false;
    }

    function printContent(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();
        location.reload();
        // document.body.innerHTML = originalContents;
        //window.close();
    }

    function addtgl(a, b,c) {
        if(c==''){
            var someDate = new Date("<?=date('Y-m-d');?>");
            someDate.setDate(someDate.getDate()+parseInt(a)); //number  of days to add, e.x. 15 days
            var dateFormated = someDate.toISOString().substr(0,10);
        }else{
            var dateFormated = c;
        }
        $('#'+b).datepicker('update', dateFormated);
    }

    $(document).ready(function(){
        $('a[title="Configuration"]').each(function() {
            $(this).hide();
        });
    });

    Number.prototype.formatMoney = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

</script>
</body>
</html>
