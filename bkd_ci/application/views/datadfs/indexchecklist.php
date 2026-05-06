   <?php usort($tableGrid, "SiteHelpers::_sort"); ?>


<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4>Checklist Dokumen</h4>
<span>data tabel Checklist Dokumen</span>
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

	<?php echo $this->session->flashdata('message');?>
  <div id="form-ajax">
  </div>
	 <div class="table-responsive">
    <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Download Dokumen
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a class="dropdown-item" href="javascript:downloadallPDF()">Download All PDF</a>
      <a class="dropdown-item" href="javascript:downloadallZIP()">Download All ZIP</a>

      <a class="dropdown-item" href="javascript:downloadcheckPDF()">Download Check PDF</a>
      <a class="dropdown-item" href="javascript:downloadcheckZIP()">Download Check ZIP</a>
    </div>
  </div>
    <table class="table table-striped table-bordered nowrap dataTable" id="gridv">
        <thead>
			<tr>
				<th style="padding:10px"> No </th>
        <th style="padding:10px"> Pilih </th>
            <th style="padding:10px">Nama Dokumen</th>
            <th style="padding:10px">Keterangan</th>

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
 $(function () {
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
            "url": "<?php echo site_url('datadfs/getdatachecklist')?>/<?=$PEGAWAI_ID;?>",
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

        
      });

 function getgambar(jenis,id){
  
  SximoModal("<?php echo site_url('datadfs/downloadgambar')?>/"+id+"/"+jenis,"View Dokumen","900");
 }


 function downloadallPDF()
 {
  var nip = $('#nip_dfs').val();
  var id = "<?=$PEGAWAI_ID;?>";
  window.open("<?=site_url('datadfs/downloadallpdf');?>/"+nip+"/"+id);
 }

 function downloadallZIP()
 {
  var nip = $('#nip_dfs').val();
  var id = "<?=$PEGAWAI_ID;?>";
  window.open("<?=site_url('datadfs/downloadallzip');?>/"+nip+"/"+id);
 }

 function downloadcheckPDF()
 {
  var nip = $('#nip_dfs').val();
  var id = "<?=$PEGAWAI_ID;?>";
  var val = [];
   $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
   var jns = JSON.stringify(val);
  window.open("<?=site_url('datadfs/downloadcheckpdf');?>/"+nip+"/"+id+"?jns="+jns);
 }


 function downloadcheckZIP()
 {
  var nip = $('#nip_dfs').val();
  var id = "<?=$PEGAWAI_ID;?>";
  var val = [];
   $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
   var jns = JSON.stringify(val);
  window.open("<?=site_url('datadfs/downloadcheckzip');?>/"+nip+"/"+id+"?jns="+jns);
 }
</script>
