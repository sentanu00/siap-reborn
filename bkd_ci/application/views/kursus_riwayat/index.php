   <?php usort($tableGrid, "SiteHelpers::_sort"); ?>


   <div class="page-header">
     <div class="row align-items-end">
       <div class="col-lg-8">
         <div class="page-header-title">
           <div class="d-inline">
             <h4><?php echo "Diklat / Seminar / Kursus"; ?></h4>
             <span>data <?php echo "Diklat / Seminar / Kursus"; ?></span>
           </div>
         </div>
       </div>
       <div class="col-lg-4">
         <div class="page-header-breadcrumb">
           <ul class="breadcrumb-title">

             <!-- start tombol get data dari BKN -->
             <li class="breadcrumb-item">&nbsp;&nbsp;
               <button type="button" class="btn btn-info btn-round" style="color:white;font-size:14px" data-toggle="modal" data-target="#modalBKN"><i class="fa fa-globe"></i> Data BKN</button>
             </li>
             <!-- end tombol get data dari BKN -->

             <li class="breadcrumb-item">&nbsp;&nbsp;
               <?php if ($this->access['is_add'] == 1) : ?>
                 <a href="javascript:getform('<?php echo site_url('kursus_riwayat/add') ?>','<?= $PEGAWAI_ID; ?>')" class="btn btn-success btn-round" style="color:white" title="Add New Data">
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
                           <?php if ($t['view'] == '1'): ?>
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

   <!-- start modal fungsi get diklat diklat -->
   <div id="modalBKN" class="modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered">
       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header" style="background-color: #2196F3; color: white;">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title" style="text-align: center; margin: 0 auto;"><i class="fa fa-globe"></i> Data BKN - Riwayat Jabatan</h4>

         </div>
         <div class="modal-body" id="modal-body">
           <!-- Data will be dynamically inserted here -->

           <div class="table-responsive ">
             <table class="table table-hover table-striped mb-0">
               <thead>
                 <tr>
                   <th>No</th>
                   <th>noSertipikat</th>
                   <th>tanggalKursus</th>
                   <th>jenisDiklatId</th>
                   <th>namaKursus</th>
                   <th>jumlahJam</th>
                   <th>institusiPenyelenggara</th>
                   <!-- <th>SK</th> -->
                 </tr>
               </thead>
               <tbody>

               </tbody>
             </table>
           </div>


         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
   <script>
     $(document).ready(function() {
       $.ajax({
         url: "<?php echo site_url('webservice_bkn/wsbkn_rw?jenis_api=kursus&pegawaiid=') ?><?php echo $PEGAWAI_ID ?>",
         dataType: 'json',
         success: function(response) {
           if (response.code === 1 && response.data.length > 0) {
             var data = response.data;

             var tableBody = $('#modal-body tbody');
             tableBody.empty(); // Clear previous table rows

             // Example of displaying the document URI from the path object
             for (var i = 0; i < data.length; i++) {
               var rowData = data[i];
               var row = '<tr>' +
                 '<td>' + (i + 1) + '</td>' +
                 '<td>' + rowData.noSertipikat + '</td>' +
                 '<td>' + rowData.tanggalKursus + '</td>' +
                 '<td>' + rowData.jenisDiklatId + '</td>' +
                 '<td>' + rowData.namaKursus + '</td>' +
                 '<td>' + rowData.jumlahJam + '</td>' +
                 '<td>' + rowData.institusiPenyelenggara + '</td>' +
                 '</tr>';

               tableBody.append(row);
             }
           } else {
             $('#modal-body').html('<p>No data available</p>');
           }
         },
         error: function() {
           console.log(xhr.responseText);
         }
       });
     });


     function ConfirmKirimSiasn(url, id) {
       if (confirm("Apakah Anda yakin ingin mengirim ke SIASN?")) {
         $.ajax({
           url: url,
           type: 'POST',
           data: {
             id: id
           },
           success: function(response) {
             alert(response);
           },
           error: function(xhr, status, error) {
             console.error(error);
             alert('Pengiriman gagal.');
           }
         });
       }
     }


     function ConfirmKirimFileSiasn(url, id) {
       if (confirm("Apakah Anda yakin ingin mengirim File ke SIASN?")) {
         $.ajax({
           url: url,
           type: 'POST',
           data: {
             id: id
           },
           success: function(response) {
             alert(response);
           },
           error: function(xhr, status, error) {
             console.error(error);
             alert('Pengiriman gagal.');
           }
         });
       }
     }
   </script>
   <!-- end fungsi get diklat diklat -->

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
           "url": "<?php echo site_url('kursus_riwayat/grids') ?>/<?= $PEGAWAI_ID; ?>",
           "type": "POST"
         },

         //Set column definition initialisation properties.
         "columnDefs": [{
           "targets": [-1], //last column
           "orderable": false, //set not orderable
         }, ],
       });

       $('#gridv').on('dblclick', 'tr', function() {
         var id = table.row(this).id();
         getform('<?php echo site_url('kursus_riwayat/add') ?>/' + id, '<?= $PEGAWAI_ID; ?>')
         //window.location = "<?= site_url('kursus_riwayat/add') ?>/"+id;
       });
     });
   </script>