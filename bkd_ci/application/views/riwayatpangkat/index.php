   <?php usort($tableGrid, "SiteHelpers::_sort"); ?>


   <div class="page-header">
     <div class="row align-items-end">
       <div class="col-lg-8">
         <div class="page-header-title">
           <div class="d-inline">
             <h4><?php echo $pageTitle; ?></h4>
             <span>data tabel <?php echo $pageTitle; ?></span>
           </div>
         </div>
       </div>
       <div class="col-lg-4">
         <div class="page-header-breadcrumb">
           <ul class="breadcrumb-title">
             <li class="breadcrumb-item">&nbsp;&nbsp;
               <button type="button" id="syncBKN" class="btn btn-info btn-round" style="color:white;font-size:14px"><i class="fa fa-globe"></i> Singkron Data BKN</button>
               <div id="loader" style="display:none">
                 <b>Proses Data...</b>
                 <img id='swing2' src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin" style="width:24px">
               </div>
             </li>
             <li class="breadcrumb-item">&nbsp;&nbsp;
               <?php if ($this->access['is_add'] == 1) : ?>
                 <a href="javascript:getform('<?php echo site_url('riwayatpangkat/add') ?>','<?= $PEGAWAI_ID; ?>')" class="btn btn-success btn-round" style="color:white" title="Add New Data">
                   <i class="ti-plus"></i>&nbsp;Tambah Data </a>
               <?php endif; ?>
             </li>
           </ul>

         </div>
       </div>
     </div>
   </div>

   <hr />
   <div class="row">
     <div class="col-md-12">
       <div class="box box-danger">


         <div class="box-body">

           <div class="page-content-wrapper m-t">

             <div class="sbox animated fadeIn">
               <div class="sbox-content">

                 <?php echo $this->session->flashdata('message'); ?>
                 <div id="form-ajax">
                 </div>
                 <div class="table-responsive">
                   <table class="table table-striped table-bordered nowrap dataTable" id="gridv">
                     <thead>
                       <tr>
                         <th style="padding:10px"> No </th>

                         <?php foreach ($tableGrid as $k => $t) : ?>
                           <?php if ($t['view'] == '1') : ?>
                             <th style="padding:10px"><?php echo $t['label'] ?></th>
                           <?php endif; ?>
                         <?php endforeach; ?>
                         <th style="padding:10px"> SK</th>
                         <th style="padding:10px">
                           < />
                         </th>
                       </tr>
                     </thead>



                   </table>
                 </div>

               </div>
             </div>


           </div>
         </div>
       </div>
     </div>
   </div>
   <script>
     $(document).on('click', '#syncBKN', function() {
       // Make the AJAX call here
       $.ajax({
         url: "<?php echo site_url('webservice_bkn/SingkronGolonganBkn?pegawai_id=' . $PEGAWAI_ID); ?>",
         type: "GET",
         dataType: "text",
         beforeSend: function() {
           // Show image container
           $("#loader").show();
         },
         success: function(response) {
           // Process the response data here if needed
           console.log("Success");
           alert("Data inserted or updated successfully.");
           location.reload();
         },
         complete: function(data) {
           // Hide image container
           $("#loader").hide();
         },
         error: function(jqXHR, textStatus, errorThrown) {
           // Handle any errors that occur during the AJAX call
           console.error(textStatus, errorThrown);
         }
       });
     });
   </script>
   <script>
     var table;
     $(function() {
       // $("#gridv").DataTable();
       table = $('#gridv').DataTable({
         "paging": true,
         "lengthChange": true,
         "rowId": "id",
         "searching": true,
         "ordering": true,
         "info": true,
         "autoWidth": false,
         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.

         // Load data for the table's content from an Ajax source
         "ajax": {
           "url": "<?php echo site_url('riwayatpangkat/grids') ?>/<?= $PEGAWAI_ID; ?>",
           "type": "POST"
         },

         //Set column definition initialisation properties.
         "columnDefs": [{
           "targets": [-1], //last column
           "orderable": false, //set not orderable
         }, ],
         order: [
           [6, 'desc']
         ]
       });

       $('#gridv').on('dblclick', 'tr', function() {
         var id = table.row(this).id();
         getform('<?php echo site_url('riwayatpangkat/add') ?>/' + id, '<?= $PEGAWAI_ID; ?>')
         //window.location = "<?= site_url('riwayatpangkat/add') ?>/"+id;
       });
     });
   </script>