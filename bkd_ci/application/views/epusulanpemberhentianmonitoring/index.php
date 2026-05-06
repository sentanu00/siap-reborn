<?php usort($tableGrid, "SiteHelpers::_sort"); ?>

<style>
  .nav-tabs1 {
    border-bottom: 1px solid #ddd
}

.nav-tabs1 .nav-item {
    margin-bottom: -1px
}

.nav-tabs1 .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem
}

.nav-tabs1 .nav-link:focus,.nav-tabs1 .nav-link:hover {
    border-color: #e9ecef #e9ecef #ddd
}

.nav-tabs1 .nav-link.disabled {
    color: #868e96;
    background-color: transparent;
    border-color: transparent
}

.nav-tabs1 .nav-item.show .nav-link,.nav-tabs1 .nav-link.active {
    color: #495057;
    background-color: #fff;
    border-color: #ddd #ddd #fff
}
</style>
<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4><?php echo $pageTitle ;?></h4>
<span>data tabel <?php echo $pageTitle ;?></span>
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
            <div class="col-md-12">
              <div class="box box-danger">
              	

	 <div class="box-body">

	<div class="page-content-wrapper m-t">
    
<div class="sbox animated fadeIn">
	<div class="sbox-content">	
  <ul class="nav nav-tabs1 nav-fill" role="tablist" >
  <li class="nav-item">
    <a class="nav-link active" onclick="reloadData('0')" id="detaildata-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-download text-info" ></i><br />Semua Usulan</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link " onclick="reloadData('5')" id="dokumen-tab" data-toggle="tab"  role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-file"  style="color:#4452bc"></i><br />Terbit SK</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " onclick="reloadData('6')" id="contact-tab" data-toggle="tab" role="tab" aria-controls="keluarga" aria-selected="false"><i class="fa fa-ban text-danger" ></i><br />Ditolak</a>
  </li>
  
</ul>

	<?php echo $this->session->flashdata('message');?>
  <br />
	 <div class="table-responsive">
    <table class="table table-striped table-bordered nowrap dataTable" id="gridv">
        <thead>
			<tr>
				<th style="padding:10px"> No </th>

				<?php foreach ($tableGrid as $k => $t) : ?>
					<?php if($t['view'] =='1'): ?>
						<th style="padding:10px"><?php echo $t['label'] ?></th>
					<?php endif; ?>
				<?php endforeach; ?>
				<th style="padding:10px"> < /></th>
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
            "url": "<?php echo site_url('epusulanpemberhentianmonitoring/grids')?>/0",
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

        $('#gridv').on( 'dblclick', 'tr', function () {
        var id = table.row( this ).id();
    });
      });

      function reloadData(stt){
        table.ajax.url("<?php echo site_url('epusulanpemberhentianmonitoring/grids')?>/"+stt).load();
      }
</script>
