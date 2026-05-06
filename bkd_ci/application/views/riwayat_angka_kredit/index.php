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

             <!-- <li class="breadcrumb-item">&nbsp;&nbsp;
               <?php //if ($this->access['is_add'] == 1) : 
                ?>
                 <a href="javascript:getform('<?php //echo site_url('riwayat_angka_kredit/add') 
                                              ?>','<? //= $PEGAWAI_ID; 
                                                    ?>')" class="btn btn-success btn-round" style="color:white" title="Add New Data">
                   <i class="ti-plus"></i>&nbsp;Tambah Data </a>
               <?php //endif; 
                ?>
             </li> -->
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

                   <div class="row mb-3">
                     <div class="col-md-3">
                       <label>Dari Tanggal</label>
                       <input type="date" id="start_date" class="form-control" />
                     </div>
                     <div class="col-md-3">
                       <label>Sampai Tanggal</label>
                       <input type="date" id="end_date" class="form-control" />
                     </div>
                     <div class="col-md-2">
                       <label>&nbsp;</label><br>
                       <button id="filter" class="btn btn-primary">Filter</button>
                     </div>
                     <div class="col-md-2">
                       <label>&nbsp;</label><br>
                       <button id="download" class="btn btn-success">Download</button>
                     </div>
                   </div>


                   <table class="table table-striped table-bordered nowrap dataTable" id="gridv">
                     <thead>
                       <tr>
                         <th style="padding:10px"> No </th>

                         <?php foreach ($tableGrid as $k => $t) : ?>
                           <?php if ($t['view'] == '1'): ?>
                             <th style="padding:10px"><?php echo $t['label'] ?></th>
                           <?php endif; ?>
                         <?php endforeach; ?>
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
     var table;
     $(function() {
       table = $('#gridv').DataTable({
         "paging": true,
         "lengthChange": true,
         "rowId": "id",
         "searching": true,
         "ordering": true,
         "info": true,
         "autoWidth": false,
         "processing": true,
         "serverSide": true,
         "ajax": {
           "url": "<?php echo site_url('riwayat_angka_kredit/grids') ?>",
           "type": "POST",
           "data": function(d) {
             d.start_date = $('#start_date').val();
             d.end_date = $('#end_date').val();
           }
         },
         "columnDefs": [{
           "targets": [-1],
           "orderable": false,
         }]
       });

       // tombol filter ditekan
       $('#filter').click(function() {
         table.ajax.reload();
       });

       // klik dua kali baris
       $('#gridv').on('dblclick', 'tr', function() {
         var id = table.row(this).id();
         getform('<?php echo site_url('riwayat_angka_kredit/add') ?>/' + id, '<?= $PEGAWAI_ID; ?>')
       });

       $('#download').click(function() {
         let start_date = $('#start_date').val();
         let end_date = $('#end_date').val();

         // Redirect ke URL download (controller export)
         let url = "<?php echo site_url('riwayat_angka_kredit/download'); ?>?start_date=" + start_date + "&end_date=" + end_date;
         window.open(url, '_blank');
       });


     });
   </script>