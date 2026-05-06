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
          <button type="button" class="btn btn-primary" id="generateDataBtn" style="color:white;font-size:14px">
            <i class="fa fa-refresh"></i><b> Generate Data Presensi Terbaru</b></button>
          <button type="button" class="btn btn-success" id="generateDataKeppoBtn" style="color:white;font-size:14px">
            <i class="fa fa-refresh"></i><b> Generate Data SIKEPPO Terbaru</b></button>
          <!-- <a href="<?php //echo site_url('kinerja/download_excel'); 
                        ?>" 
          class="btn btn-success" 
          style="color:white;font-size:14px">
          <i class="fa fa-refresh"></i><b> UNDUH FILE EXCEL</b>
        </a> -->
          <button type="button" class="btn btn-success" id="downloadExcelBtn" style="color:white;font-size:14px">
            <i class="fa fa-download"></i><b> UNDUH FILE EXCEL</b>
          </button>

          <div id="loader" style="display:none">
            <b>Proses Data...</b>
            <img id='swing2' src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin"
              style="width:24px">
          </div>
          <br>
          <hr>
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
  $(document).ready(function() {
    // Define a batch size for splitting the API data
    const batchSize = 50;
    const currentDate = new Date();
    // const currentMonth = currentDate.getMonth() - 1; // Add 1 because getMonth() returns zero-based month (0 for January, 1 for February, etc.)
    const currentMonth = String(currentDate.getMonth()).padStart(2, '0');
    const currentYear = currentDate.getFullYear();
    const apiUrl = `https://sipp2.bkd.probolinggokab.go.id/api/pelaporan/search/${currentMonth}/${currentYear}`;

    $('#generateDataBtn').on('click', function() {
      // Send the AJAX request to fetch data from the API
      $.ajax({
        url: '<?php echo site_url('kinerja/delete_data_to_presensi'); ?>',
        type: 'GET',
        // dataType: 'json',
        beforeSend: function() {
          // Show image container
          $("#loader").show();
        },
        success: function(response) {
          console.log(response.status);
          // After deletion, proceed to fetch and insert new data
          fetchDataAndInsert();
        },
        error: function(xhr, textStatus, errorThrown) {
          console.error('Error deleting data from API:', textStatus, errorThrown);
        }
      });
    });

    function fetchDataAndInsert() {
      // Send the AJAX request to fetch data from the API
      $.ajax({
        url: apiUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          // Split the API data into batches
          const batches = chunkArray(response, batchSize);

          // Send each batch to the server for storage
          batches.forEach(function(batch) {
            storeDataToPresensi(batch);
          });
        },
        error: function(xhr, textStatus, errorThrown) {
          console.error('Error fetching data from API:', textStatus, errorThrown);
        }
      });
    }

    function chunkArray(array, size) {
      const result = [];
      for (let i = 0; i < array.length; i += size) {
        result.push(array.slice(i, i + size));
      }
      return result;
    }

    function storeDataToPresensi(apiData) {
      // Send the API data to the server-side using CodeIgniter's AJAX controller
      $.ajax({
        url: "<?php echo site_url('kinerja/store_data_to_presensi'); ?>",
        type: "POST",
        data: {
          api_data: apiData
        },
        // dataType: "json",
        beforeSend: function() {
          // Show image container
          $("#loader").show();
        },
        success: function(response) {
          // Handle the response from the server if needed
          console.log("Data successfully stored in presensi table:", response);
        },
        complete: function(data) {
          // $.ajax({
          //   url: '<?php echo site_url('kinerja/presensidelete_double'); ?>',
          //   type: 'GET',
          //   success: function(response) {
          //         // Split the API data into batches
          //         console.log("success multiple deleted");

          //     }
          // });
          // Hide image container
          $("#loader").hide();
        },
        error: function(xhr, textStatus, errorThrown) {
          // Handle error if the server-side operation fails
          console.error("Server-side Error:", textStatus, errorThrown);
        }
      });
    }
  });

  $(document).ready(function() {
    // Define a batch size for splitting the API data
    const batchSize = 50;
    const currentDate = new Date();
    // const currentMonth = currentDate.getMonth() - 1; // Add 1 because getMonth() returns zero-based month (0 for January, 1 for February, etc.)
    const currentMonth = String(currentDate.getMonth()).padStart(2, '0');
    const currentYear = currentDate.getFullYear();
    // const apiUrl = `https://skp.bkd.probolinggokab.go.id/keppo/integrasi/integrasi_json/ambil_prosen?reqTahun=${currentYear}&reqBulan=${currentMonth}`;
    const apiUrl = `https://skp.bkd.probolinggokab.go.id:8336/api/rekap_bulanan_kinerja_tpp?tahun=${currentYear}&bulan=${currentMonth}`;

    $('#generateDataKeppoBtn').on('click', function() {
      // Send the AJAX request to fetch data from the API
      $.ajax({
        url: '<?php echo site_url('kinerja/delete_data_to_keppo'); ?>',
        type: 'GET',
        // dataType: 'json',
        beforeSend: function() {
          // Show image container
          $("#loader").show();
        },
        success: function(response) {
          // Split the API data into batches
          console.log(response.status);
          // After deletion, proceed to fetch and insert new data
          fetchDataAndInsert();
        },
        error: function(xhr, textStatus, errorThrown) {
          console.error('Error fetching data from API:', textStatus, errorThrown);
        }
      });
    });


    function fetchDataAndInsert() {
      // Send the AJAX request to fetch data from the API
      $.ajax({
        url: apiUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          // Split the API data into batches
          const batches = chunkArray(response['data'], batchSize);

          // Send each batch to the server for storage
          batches.forEach(function(batch) {
            storeDataToKeppo(batch);
          });
        },
        error: function(xhr, textStatus, errorThrown) {
          console.error('Error fetching data from API:', textStatus, errorThrown);
        }
      });
    }

    function chunkArray(array, size) {
      const result = [];
      for (let i = 0; i < array.length; i += size) {
        result.push(array.slice(i, i + size));
      }
      return result;
    }

    //   function storeDataToKeppo(apiData) {
    //     const batchNipBaru = apiData.map(data => data.nip_baru);
    //     const batchBulan = apiData[0].bulan; // Assuming all data in the batch have the same bulan and tahun
    //     const batchTahun = apiData[0].tahun; // Assuming all data in the batch have the same bulan and tahun

    //     // Send an AJAX request to check if any existing entries match the criteria
    //     $.ajax({
    //         url: "<?php echo site_url('kinerja/keppocheck_existing_entries'); ?>",
    //         type: "POST",
    //         data: {
    //             nip_baru: batchNipBaru,
    //             bulan: batchBulan,
    //             tahun: batchTahun
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             // Delete the existing entries if any
    //             if (response.status === "found") {
    //                 const existingIds = response.ids;
    //                 deleteExistingEntries(existingIds, apiData);
    //             } else {
    //                 // No existing entries found, proceed with data insertion
    //                 insertData(apiData);
    //             }
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             console.error("Error checking existing entries:", textStatus, errorThrown);
    //         }
    //     });
    // }

    // function deleteExistingEntries(existingIds, apiData) {
    //     // Send an AJAX request to delete the existing entries by their IDs
    //     $.ajax({
    //         url: "<?php echo site_url('kinerja/keppodelete_existing_entries'); ?>",
    //         type: "POST",
    //         data: { ids: existingIds },
    //         dataType: "json",
    //         success: function(response) {
    //             console.log("Existing entries deleted:", response);
    //             // Proceed with data insertion after existing entries are deleted
    //             insertData(apiData);
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             console.error("Error deleting existing entries:", textStatus, errorThrown);
    //         }
    //     });
    // }

    // function insertData(apiData) {
    //     // Send the API data to the server-side using CodeIgniter's AJAX controller for insertion
    //     $.ajax({
    //         url: "<?php echo site_url('kinerja/store_data_to_keppo'); ?>",
    //         type: "POST",
    //         data: { api_data: apiData },
    //         // dataType: "json",
    //         beforeSend: function() {
    //             // Show image container
    //             $("#loader").show();
    //         },
    //         success: function(response) {
    //             // Handle the response from the server if needed
    //             console.log("Data successfully stored in keppo table:", response);
    //         },
    //         complete: function(data) {
    //             // Hide image container
    //             $("#loader").hide();
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             // Handle error if the server-side operation fails
    //             console.error("Server-side Error:", textStatus, errorThrown);
    //         }
    //     });
    // }



    function storeDataToKeppo(apiData) {
      // Send the API data to the server-side using CodeIgniter's AJAX controller
      $.ajax({
        url: "<?php echo site_url('kinerja/store_data_to_keppo'); ?>",
        type: "POST",
        data: {
          api_data: apiData
        },
        // dataType: "json",
        beforeSend: function() {
          // Show image container
          $("#loader").show();
        },
        success: function(response) {
          // Handle the response from the server if needed
          console.log("Data successfully stored in keppo table:", response);
          // check_existing_entries(apiData);
        },
        complete: function(data) {
          // $.ajax({
          //   url: '<?php echo site_url('kinerja/keppodelete_double'); ?>',
          //   type: 'GET',
          //   success: function(response) {
          //         // Split the API data into batches
          //         console.log("success multiple deleted");

          //     }
          // });

          // Hide image container
          $("#loader").hide();
        },
        error: function(xhr, textStatus, errorThrown) {
          // Handle error if the server-side operation fails
          console.error("Server-side Error:", textStatus, errorThrown);
        }
      });
    }

    //    function check_existing_entries(apiData) {
    //     const batchNipBaru = apiData.map(data => data.nip_baru);
    //     const batchBulan = apiData[0].bulan; // Assuming all data in the batch have the same bulan and tahun
    //     const batchTahun = apiData[0].tahun; // Assuming all data in the batch have the same bulan and tahun

    //     // Send an AJAX request to check if any existing entries match the criteria
    //     $.ajax({
    //         url: "<?php echo site_url('kinerja/keppocheck_existing_entries'); ?>",
    //         type: "POST",
    //         data: {
    //             nip_baru: batchNipBaru,
    //             bulan: batchBulan,
    //             tahun: batchTahun
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             // Delete the existing entries if any
    //             if (response.status === "found") {
    //                 const existingIds = response.ids;
    //                 deleteExistingEntries(existingIds, apiData);
    //             } 
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             console.error("Error checking existing entries:", textStatus, errorThrown);
    //         }
    //     });
    // }

    // function deleteExistingEntries(existingIds, apiData) {
    //     // Send an AJAX request to delete the existing entries by their IDs
    //     $.ajax({
    //         url: "<?php echo site_url('kinerja/keppodelete_existing_entries'); ?>",
    //         type: "POST",
    //         data: { ids: existingIds },
    //         dataType: "json",
    //         success: function(response) {
    //             console.log("Existing entries deleted:", response);
    //             // Proceed with data insertion after existing entries are deleted
    //             insertData(apiData);
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             console.error("Error deleting existing entries:", textStatus, errorThrown);
    //         }
    //     });
    // }

  });
</script>

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
        "url": "<?php echo site_url('kinerja/grids') ?>?satker=0&sttpeg=1,2,10&thn=<?php echo date('Y'); ?>&bln=<?php echo date('m'); ?>",
        "type": "POST"
      },
      // Load data for the table's content from an Ajax source
      // "ajax": {
      //   "url": "<?php echo site_url('kinerja/grids') ?>?satker=0&sttpeg=1,2,10&bln=<?php echo date('m'); ?>",
      //   "type": "POST"
      // },

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
        "url": "<?= site_url('kinerja/satker'); ?>",
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
    thn = $('#thn').val();
    bln = $('#bln').val();
    table.ajax.url("<?php echo site_url('kinerja/grids') ?>?satker=" + idsatker + "&sttpeg=" + sttpeg + "&thn=" + thn + "&bln=" + bln).load();
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
    var currentYear = new Date().getFullYear();
    var thnop = '';
    // for (var ix = thnskg; ix < (thnskg + 5); ix++) {
    //   thnop += '<option value="' + ix + '">' + ix + '</option>';
    // }
    for (var ix = currentYear - 2; ix <= currentYear; ix++) {
      thnop += '<option value="' + ix + '">' + ix + '</option>';
    }

    $("#gridv_length").append('Thn <select class="form-control" id="thn" onchange="reloadgridx()" style="width:150px">' + thnop + '</select>');

    var blnskg = parseInt('<?php echo date("m"); ?>');
    var blnop = '';
    for (var ix = 1; ix <= 12; ix++) {
      blnop += '<option value="' + ix + '">' + ix + '</option>';
    }
    $("#gridv_length").append('bln <select class="form-control" id="bln" onchange="reloadgridx()" style="width:150px">' + blnop + '</select>');

  });
  // Fungsi untuk download Excel dengan parameter filter
  $('#downloadExcelBtn').on('click', function() {
    var satker = idsatker || '0';
    var sttpeg = $('#status_peg').val() || '1,2,10';
    var thn = $('#thn').val() || '<?php echo date('Y'); ?>';
    var bln = $('#bln').val() || '<?php echo date('m'); ?>';

    var url = '<?php echo site_url('kinerja/download_excel'); ?>' +
      '?satker=' + encodeURIComponent(satker) +
      '&sttpeg=' + encodeURIComponent(sttpeg) +
      '&thn=' + encodeURIComponent(thn) +
      '&bln=' + encodeURIComponent(bln);

    window.location.href = url;
  });
</script>