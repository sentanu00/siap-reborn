
<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h4><?php echo $pageTitle ;?></h4>
<span>Detail <?php echo $pageTitle ;?></span>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="#"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a href="<?php echo site_url('epusulanpemberhentian') ?>"><?php echo $pageTitle ?></a></li>
<li class="breadcrumb-item"><a href="#!">Detail</a>

</ul>
</div>
</div>
</div>
</div>
<hr />

          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
              	<div class="box-header with-border" style="background: #002542;color: white;">	
				<div class="table-responsive">
					<table class="table table-striped table-bordered" >
						<tbody>	
					
					<tr>
						<td width='10%' class='label-view text-right'>OPD</td>
						<td width='50%'><?php echo $row['NAMA'] ;?> </td>
						<td width='10%' class='label-view text-right'>Usulan Tanggal</td>
						<td  style="font-weight:bold"><?php echo SiteHelpers::datereport($row['usulan_tanggal']) ;?> </td>
					</tr>
				
					<tr>
						<td width='10%' class='label-view text-right'>Usulan Nomor</td>
						<td ><?php echo $row['usulan_nomor'] ;?> </td>
						<td width='10%' class='label-view text-right'>Usulan Status</td>
						<td ><?php echo SiteHelpers::getStatusUsulan($row['usulan_status']);?> 
            <?php
              if($row['usulan_status'] == 0){
                ?>
                <i class="fa fa-arrow-right"></i> <button class="btn btn-danger" onclick="kirimdata()">Kirim Data ke BKSDM</button>
                <?
              }
            ?>
          </td>
						<input type="hidden" id="id_usulan" value="<?php echo $row['id']; ?>" />
					</tr>
				
					
				
						</tbody>	
					</table>    
				</div>
					</div>
		</div>		
	

	</div>

	<div class="col-md-12">
              <div class="box box-danger">
              	<div class="box-header with-border">	
				  <div class="col-lg-12">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">

<li class="breadcrumb-item">&nbsp;&nbsp;
<?php if($this->access['is_add'] ==1 && $row['usulan_status'] == 0) : ?>
    <a href="javascript:SximoModal('<?php echo site_url('epusulanpemberhentianpegawai/add') ?>','Tambah Pegawai','')" class="btn btn-success btn-round" style="color:white"  title="Add New Data">
    <i class="ti-plus"></i>&nbsp;Tambah Pegawai </a>
    <?php endif;?>
  </li>
</ul>
</div>
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
<script>
var table;
 $(function () {
       // $("#gridv").DataTable();
        table = $('#gridv').DataTable({
          "paging": true,
          "lengthChange": false,
          "rowId": "id",
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('epusulanpemberhentianpegawai/grids')?>/<?=$id_usulan;?>",
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

    function kirimdata()
    {
      if(confirm('Apakah anda yakin untuk mengirim data ini ?')){
      $.ajax({
            type: 'POST',
            url: '<?php echo site_url("epusulanpemberhentian/kirimdataBKSDM");?>',
            data: {id:'<?=md5($id_usulan);?>'},
            dataType:'json',
            success: function (data) {
                if(!data.msg){
                  alert("error simpan : "+data.err);
                }else{
                  alert(data.msg);
                  location.reload();
                }
            }
        });
      }
    }
</script>