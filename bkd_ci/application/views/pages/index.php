  <?php usort($tableGrid, "SiteHelpers::_sort"); ?>
   <section class="content-header">
          <h1>
            <?php echo $pageTitle ;?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><?php echo $pageNote ;?></li>
          </ol>
        </section>


<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
              	<div class="box-header with-border">
                  <h3 class="box-title"><?php echo $pageTitle ;?></h3>
                  <div class="box-tools pull-right">
 	
		<?php if($this->access['is_add'] ==1) : ?>
		<a href="<?php echo site_url('pages/add') ?>" class="tips btn btn-xs btn-info"  title="<?php echo $this->lang->line('core.btn_new'); ?>">
		<i class="fa fa-plus"></i>&nbsp;<?php echo $this->lang->line('core.btn_new'); ?> (F2) </a>
		<?php endif;

		if($this->access['is_excel'] ==1) : ?>	
		<a href="<?php echo site_url('pages/download') ?>" class="tips btn btn-xs btn-default" title="<?php echo $this->lang->line('core.btn_download'); ?>">
		<i class="fa fa-download"></i>&nbsp;<?php echo $this->lang->line('core.btn_download'); ?></a>
		<?php endif;
		if($this->session->userdata('gid') ==1) : ?>	
		<a href="<?php echo site_url('sximo/module/config/pages') ?>" class="tips btn btn-xs btn-default"  title="<?php echo $this->lang->line('core.btn_config'); ?>">
		<i class="fa fa-cog"></i>&nbsp;<?php echo $this->lang->line('core.btn_config'); ?></a>
		<?php endif; ?>		

                  </div>
                </div>

	 <div class="box-body">

	<div class="page-content-wrapper m-t">
    
<div class="sbox animated fadeIn">
	<div class="sbox-content">	

	<?php echo $this->session->flashdata('message');?>
	 <div class="table-responsive">
    <table class="table table-bordered display" id="gridv">
        <thead>
			<tr>
				<th> No </th>

				<?php foreach ($tableGrid as $k => $t) : ?>
					<?php if($t['view'] =='1'): ?>
						<th><?php echo $t['label'] ?></th>
					<?php endif; ?>
				<?php endforeach; ?>
				<th><?php echo $this->lang->line('core.btn_action'); ?></th>
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
        </section>

<script>
var table;
 $(function () {
       // $("#gridv").DataTable();
        table = $('#gridv').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('pages/grids')?>",
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
</script>
