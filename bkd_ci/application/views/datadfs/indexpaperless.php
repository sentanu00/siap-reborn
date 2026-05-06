   <?php usort($tableGrid, "SiteHelpers::_sort"); ?>


<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Paperless BKN</h4>
<span>data tabel Paperless BKN</span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">

<li class="breadcrumb-item">&nbsp;&nbsp;

    <a href="javascript:changepages('datadfs/indexchecklist')" class="btn btn-success btn-round" style="color:white"  title="Checklist Dokumen">
    <i class="ti-check"></i>&nbsp;Checklist Dokumen </a>

    <a href="javascript:changepages('datadfs/indexpaperless')" class="btn btn-danger btn-round" style="color:white"  title="Paperless BKN">
    <i class="ti-download"></i>&nbsp;Paperless BKN </a>
    
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
    <label>Jenis Pengajuan</label>
	<select id="jenispengajuan" class="form-control" style="width: 300px"  onchange="reloadgrid(this.value)">
   <?
   foreach ($selectGrid as $key) {
     ?>
        <option value="<?=$key->id_jenis_pengajuan;?>"><?=$key->jenis_pengajuan;?></option>
     <?
   }
   ?> 
  </select>
  <div id="form-ajax">
  </div>
	 <div class="table-responsive">
    <table class="table table-striped table-bordered nowrap dataTable" id="gridv">
        <thead>
			<tr>
				<th style="padding:10px"> No </th>
            <th style="padding:10px">Nama Dokumen</th>
            <th style="padding:10px">Nama File</th>
            <th style="padding:10px">Status</th>

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
  var nip = $("#nip_dfs").val();
  $(document).ready(function(){
      var x = $("#jenispengajuan").val();
      generategrid(x);
  });
  function reloadgrid(a){
    table.ajax.url("<?php echo site_url('datadfs/getpaperlessdata')?>/"+a+"/<?=$PEGAWAI_ID;?>/"+nip).load();
  }
function generategrid(a) {
       // $("#gridv").DataTable();
        table = $('#gridv').DataTable({
          "paging": false,
          "lengthChange": false,
          "rowId": "id",
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": false, //Feature control DataTables' server-side processing mode.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('datadfs/getpaperlessdata')?>/"+a+"/<?=$PEGAWAI_ID;?>/"+nip,
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],
        });

    }


</script>
