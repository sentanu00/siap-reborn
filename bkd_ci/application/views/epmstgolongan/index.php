   <?php usort($tableGrid, "SiteHelpers::_sort"); ?>


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

<li class="breadcrumb-item">&nbsp;&nbsp;
<?php if($this->access['is_add'] ==1) : ?>
    <a href="javascript:getform('<?php echo site_url('epmstgolongan/add') ?>','')" class="btn btn-success btn-round" style="color:white"  title="Add New Data">
    <i class="ti-plus"></i>&nbsp;Tambah Data </a>
    <?php endif;?>
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
            "url": "<?php echo site_url('epmstgolongan/grids')?>",
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
        getform('<?php echo site_url('epmstgolongan/add') ?>/'+id,'')
        //window.location = "<?=site_url('epmstgolongan/add')?>/"+id;
    });
      });
</script>
