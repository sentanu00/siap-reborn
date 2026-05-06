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


        </ul>
      </div>
    </div>
  </div>
</div>

<hr />
<div class="row">
  <?php
  $guest = false;
  if ($this->session->userdata('gid') != 1) {
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

<script>
  var table;
  var idrow = "";
  var idsatker = 0;
  var sttpeg = "1,2,10";
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
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('kompetensi/grids') ?>?satker=0&sttpeg=1,2,10&thn=<?php echo date('Y'); ?>",
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
      //window.location = "<?= site_url('pegawai/add') ?>/"+id;
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
        "url": "<?= site_url('kompetensi/satker'); ?>",
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
    thn = $('#tahun').val();
    table.ajax.url("<?php echo site_url('kompetensi/grids') ?>?satker=" + idsatker + "&sttpeg=" + sttpeg + "&thn=" + thn).load();
  }


  function mutasiPegawai() {
    SximoModal('<?= site_url("mutasi/addfrontend"); ?>/' + idrow, "Mutasi", 1000);
  }

  function cetaklaporan(a) {
    if (idsatker == '0' || idsatker == '') {
      idsatker = '01';
      alert('Pilih OPD Terlebih Dahulu');
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
        case 8:

          url = "<?php echo site_url('Reportlaporanbulanan/cetak'); ?>/" + idsatker;
          break;
      }

      window.open(url);
    } else {
      if (a == 8) {
        url = "<?php echo site_url('Reportlaporanbulanan/cetak'); ?>/" + idsatker;
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
    $("#gridv_length").append('<select class="form-control" id="status_peg" onchange="reloadgridx()" style="width:150px">' +
      '<option value="1,2,10" selected>CPNS/PNS/PPPK</option>' +
      '</select>');

    var thnskg = parseInt('<?php echo date("Y"); ?>');
    var thnop = '';
    for (var ix = thnskg - 1; ix <= thnskg; ix++) {
      thnop += '<option value="' + ix + '">' + ix + '</option>';
    }

    $("#gridv_length").append('Thn <select class="form-control" id="tahun" onchange="reloadgridx()" style="width:150px">' + thnop + '</select>');


  });
</script>