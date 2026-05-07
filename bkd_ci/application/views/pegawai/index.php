<script src="<?php echo base_url(); ?>sximo/jstree/jstree.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sximo/jstree/themes/default/style.min.css">

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
            <?php if ($this->access['is_add'] == 1) : ?>

              <?php if ($this->session->userdata('gid') == 1) : ?>
                <a href="<?php echo site_url('pegawai/add') ?>" class="btn btn-success" style="color:white" title="Add New Data">
                  <i class="ti-plus"></i>&nbsp;Tambah Data
                </a>
              <?php else : ?>
                <a href="<?php echo site_url('pegawai/add') ?>" class="btn btn-success" style="color:white; display:none;" title="Add New Data">
                  <i class="ti-plus"></i>&nbsp;Tambah Data
                </a>
              <?php endif; ?>


              <a href="#" class="btn btn-warning" style="color:white" title="Download FIP" id="downloadBtn">
                <i class="ti-download"></i>&nbsp;Download FIP </a>

              <!-- <a href="javascript:mutasiPegawai()" class="btn btn-info" style="color:white" title="Mutasi Pegawai">
                <i class="ti-share"></i>&nbsp;Mutasi </a> -->

            <?php endif; ?>
            <div class="btn-group" role="group">
              <a id="btnGroupDrop1" class="btn btn-danger" style="color:white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-print"></i>&nbsp;Cetak
              </a>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <!-- <a class="dropdown-item" href="javascript:cetak(1)">FIP-01</a> -->
                <!-- <a class="dropdown-item" href="javascript:cetak(2)">FIP-02</a> -->
                <a class="dropdown-item" href="javascript:cetak(3)">Biodata</a>
                <a class="dropdown-item" href="javascript:cetak(4)">Biodata Singkat</a>
                <!-- <a class="dropdown-item" href="javascript:cetak(5)">Model DK-Depan</a> -->
                <!-- <a class="dropdown-item" href="javascript:cetak(6)">Model DK-Belakang</a> -->
                <!-- <a class="dropdown-item" href="javascript:cetak(7)">Cetak Pegawai</a> -->
                <a class="dropdown-item" href="javascript:cetaklaporan(8)">Laporan Bulanan Data Pegawai</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<hr />
<div class="row">
  <?php
  $guest = false;
  if ($this->session->userdata('gid') != 1 && $this->session->userdata('gid') != 4 && $this->session->userdata('gid') != 5 && $this->session->userdata('gid') != 6) {
    $guest = true;
  }

  if (!$guest) {
  ?>
    <div class="col-md-3">
      <div class="box box-primary">

        <div class="box-body">

          <div class="page-content-wrapper m-t">

            <div class="sbox animated fadeIn">
              <div class="sbox-content " style="overflow: auto;height: 770px">
                <a href="javascript:reloadgridx()" class="btn btn-danger" style="width: 100%"> PEMERINTAH KABUPATEN PROBOLINGGO</a>
                <div id="data" class="demo"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?
  }
  ?>
  <div class="<? if ($guest) {
                echo "col-md-12";
              } else {
                echo "col-md-9";
              } ?>">
    <div class="box box-danger">


      <div class="box-body">

        <div class="page-content-wrapper m-t">

          <div class="sbox animated fadeIn">
            <div class="sbox-content">

              <?php echo $this->session->flashdata('message'); ?>
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
                      <th style="padding:10px"><?php echo $this->lang->line('core.btn_action'); ?></th>
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

<!-- The modal to display the PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfModalLabel">FIP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe src="" frameborder="0" width="100%" height="800"></iframe>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Button click event
    $("#downloadBtn").click(function(e) {
      e.preventDefault(); // Prevent default link behavior
      var pdfUrl = "/file_refrensi/blank.pdf"; // Replace this with the actual URL of the PDF file
      $("#pdfModal iframe").attr("src", pdfUrl); // Set the iframe source to display the PDF
      $("#pdfModal").modal("show"); // Show the modal
    });
  });
</script>

<script>
  var table;
  var idrow = "";
  var idsatker = 0;
  var sttpeg = "1,2";
  $(function() {
    // $("#gridv").DataTable();
    table = $('#gridv').DataTable({
      // "dom": '<"toolbar">frtip',
      "pageLength": 25,
      select: true,
      "rowId": "id",
      "paging": true,
      "lengthChange": true,
      "sScrollY": ($(window).height() - 320),
      "sScrollX": "100%",
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('pegawai/grids') ?>?satker=0&sttpeg=1,2,10,18",
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

      // alert( 'Clicked row id '+id );
      window.location = "<?= site_url('pegawai/add') ?>/" + id;
    });

    $('#gridv').on('click', 'tr', function() {
      var id = table.row(this).id();
      idrow = id;

      // alert( 'Clicked row id '+id );
    });
  });




  $('#data').on('changed.jstree', function(e, data) {
    var i, j, r = [];
    for (i = 0, j = data.selected.length; i < j; i++) {
      r.push(data.instance.get_node(data.selected[i]).id);
    }
    idsatker = r.join(', ');
    reloadgridx(idsatker);
    // reloadgrid(r.join(', '));
    //console.log('Selected: ' + r.join(', '));
  }).jstree({
    'core': {
      'data': {
        "url": "<?= site_url('pegawai/satker'); ?>",
        'data': function(node) {
          return {
            'id': node.id
          };
        },
        "dataType": "json" // needed only if you do not supply JSON headers
      }
    }

  });

  function reloadgridx(idsatker = '') {
    sttpeg = $('#status_peg').val();
    table.ajax.url("<?php echo site_url('pegawai/grids') ?>?satker=" + idsatker + "&sttpeg=" + sttpeg).load();
  }

  function mutasiPegawai() {
    SximoModal('<?= site_url("mutasi/addfrontend"); ?>/' + idrow, "Mutasi", 1000);
  }

  function cetaklaporan(a) {
    if (idsatker == '0' || idsatker == '') {
      // idsatker = '01';
      idsatker = '<?php echo  $this->session->userdata('satker'); ?>';
      // alert('Pilih OPD Terlebih Dahulu');
      SximoModal("<?php echo site_url('reportlaporanbulanan/popupdata'); ?>", " Cetak Laporan Bulanan");
    } else {
      SximoModal("<?php echo site_url('reportlaporanbulanan/popupdata'); ?>", " Cetak Laporan Bulanan");
    }
  }

  function cetak(a) {
    var url = "";
    if (idrow != "") {
      switch (a) {
        case 1:
          url = "<?php echo site_url('reportbiodata/cetakfip01'); ?>/" + idrow;
          break;
        case 2:
          url = "<?php echo site_url('pegawai/cetakfip01'); ?>/" + idrow;
          break;
        case 3:
          url = "<?php echo site_url('reportbiodata/cetakbiodata'); ?>/" + idrow;
          break;
        case 4:
          url = "<?php echo site_url('reportbiodata/cetakbiodatasingkat'); ?>/" + idrow;
          break;
        case 8:

          url = "<?php echo site_url('reportlaporanbulanan/cetak'); ?>/" + idsatker;
          break;
      }

      window.open(url);
    } else {
      if (a == 8) {
        url = "<?php echo site_url('reportlaporanbulanan/cetak'); ?>/" + idsatker;
        window.open(url);
      } else if (a == 3) {
        url = "<?php echo site_url('pegawai/biodata'); ?>/" + idrow;
        window.open(url);
      } else if (a == 4) {
        url = "<?php echo site_url('pegawai/biodatasingkat'); ?>/" + idrow;
        window.open(url);
      } else {
        alert("Pilih Pegawai terlebih dahulu !!");
      }
    }
  }




  $(document).ready(function() {
    setTimeout(function() {
      $('#mobile-collapse').click();
    }, 500);
    $("#gridv_length").append(' Status Pegawai <select class="form-control" id="status_peg" onchange="reloadgridx()" style="width:150px">' +
      '<option value="1,2,10,0,3,4,5,6,7,8,9,18,19,20,21">SEMUA</option>' +
      '<option value="0">USULAN</option>' +
      '<option value="1">CPNS</option>' +
      '<option value="2">PNS</option>' +
      '<option value="10">PPPK</option>' +
      '<option value="18">PPPK Paruh Waktu</option>' +
      '<option value="1,2,10,18" selected>CPNS/PNS/PPPK/PPPK PW</option>' +
      '<option value="3">PENSIUN</option>' +
      '<option value="19">PENSIUN PPPK</option>' +
      '<option value="20">PENSIUN PPPK PW</option>' +
      '<option value="21">PENSIUN KARENA UZUR</option>' +
      '<option value="4">P3D</option>' +
      '<option value="5">TEWAS</option>' +
      '<option value="6">WAFAT</option>' +
      '<option value="7">PINDAH</option>' +
      '<option value="8">DIBERHENTIKAN</option>' +
      '<option value="9">MPP</option>' +
      '</select>');

  });
</script>