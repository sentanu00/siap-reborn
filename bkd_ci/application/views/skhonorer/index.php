   <?php usort($tableGrid, "SiteHelpers::_sort"); ?>
   <style>
     .modal-dialog {
       max-width: 1000px !important;
       ;
       /* Adjust the width to your desired value */
       margin: 0 auto !important;
       ;
       /* Center the modal horizontally */
     }
   </style>

   <div class="page-header">
     <div class="row align-items-end">
       <div class="col-lg-8">
         <div class="page-header-title">
           <div class="d-inline">
             <h4><?php echo 'Riwayat SK'; ?></h4>
             <span>data tabel <?php echo 'Riwayat SK'; ?></span>
           </div>
         </div>
       </div>
       <div class="col-lg-4">
         <div class="page-header-breadcrumb">
           <ul class="breadcrumb-title">
             <!-- <li class="breadcrumb-item">&nbsp;&nbsp;
               <button type="button" class="btn btn-info btn-round" style="color:white;font-size:14px" data-toggle="modal" data-target="#modalBKN"><i class="fa fa-globe"></i> Data BKN</button>
             </li> -->
             <li class="breadcrumb-item">&nbsp;&nbsp;
               <?php if ($this->access['is_add'] == 1) : ?>
                 <a href="javascript:getform('<?php echo site_url('skhonorer/add') ?>','<?= $PEGAWAI_ID; ?>')" class="btn btn-success btn-round" style="color:white" title="Add New Data">
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

   <!-- Modal -->
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
                   <th>No SK</th>
                   <th>Tanggal SK</th>
                   <th>TMT Jabatan</th>
                   <th>Nama Jabatan</th>
                   <th>Nama UNOR</th>
                   <th>Eselon</th>
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
         url: "<?php echo site_url('webservice_bkn/wsbkn_rw?jenis_api=jabatan&pegawaiid=') ?><?php echo $PEGAWAI_ID ?>",
         dataType: 'json',
         success: function(response) {
           if (response.code === 1 && response.data.length > 0) {
             var data = response.data;

             var tableBody = $('#modal-body tbody');
             tableBody.empty(); // Clear previous table rows

             // Example of displaying the document URI from the path object
             for (var i = 0; i < data.length; i++) {
               var rowData = data[i];
               if (rowData.jenisJabatan == '1') {
                 var row = '<tr>' +
                   '<td>' + (i + 1) + '</td>' +
                   '<td>' + rowData.nomorSk + '</td>' +
                   '<td>' + rowData.tanggalSk + '</td>' +
                   '<td>' + rowData.tmtJabatan + '</td>' +
                   '<td>' + rowData.namaJabatan + '</td>' +
                   '<td>' + rowData.namaUnor + '</td>' +
                   '<td>' + (rowData.eselon || '') + '</td>' +
                   '</tr>';
               } else if (rowData.jenisJabatan == '2') {
                 var row = '<tr>' +
                   '<td>' + (i + 1) + '</td>' +
                   '<td>' + rowData.nomorSk + '</td>' +
                   '<td>' + rowData.tanggalSk + '</td>' +
                   '<td>' + rowData.tmtJabatan + '</td>' +
                   '<td>' + rowData.jabatanFungsionalNama + '</td>' +
                   '<td>' + rowData.namaUnor + '</td>' +
                   '<td>' + (rowData.eselon || '') + '</td>' +
                   '</tr>';
               } else if (rowData.jenisJabatan == '4') {
                 var row = '<tr>' +
                   '<td>' + (i + 1) + '</td>' +
                   '<td>' + rowData.nomorSk + '</td>' +
                   '<td>' + rowData.tanggalSk + '</td>' +
                   '<td>' + rowData.tmtJabatan + '</td>' +
                   '<td>' + rowData.jabatanFungsionalUmumNama + '</td>' +
                   '<td>' + rowData.namaUnor + '</td>' +
                   '<td>' + (rowData.eselon || '') + '</td>' +
                   '</tr>';
               }
               //   if (rowData.path && Object.keys(rowData.path).length > 0) {
               //   var pathData = rowData.path;
               //   var pathRow = '';
               //   for (var key in pathData) {
               //     if (pathData.hasOwnProperty(key)) {
               //       var pathItem = pathData[key];
               //       pathRow += '<p><strong>Document URI:</strong> ' + pathItem.dok_uri + '</p>';
               //     }
               //   }
               //   row += '<td>' + pathRow + '</td>';
               // } else {
               //   row += '<td></td>';
               // }

               // row += '</tr>';

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
           "url": "<?php echo site_url('skhonorer/grids') ?>/<?= $PEGAWAI_ID; ?>",
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
         getform('<?php echo site_url('skhonorer/add') ?>/' + id, '<?= $PEGAWAI_ID; ?>')
         //window.location = "<?= site_url('skhonorer/add') ?>/"+id;
       });
     });
   </script>