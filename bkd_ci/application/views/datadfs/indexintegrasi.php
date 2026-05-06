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
    <table class="table table-striped table-bordered nowrap dataTable" id="gridv">
        <thead>
			<tr>
				<th style="padding:10px"> No </th>
            <th style="padding:10px">Nama Dokumen</th>
            <th style="padding:10px">Keterangan</th>

			  </tr>
        </thead>
		<tbody>
			<?
		/*	$a = $this->db->query("SELECT * FROM jenis_dokumen order by kode")->result();
			$no = 1;
			foreach($a as $b){
				$ss = '';
				if($b->level == 0) $ss = 'style="font-weight:bold"';
					echo '<tr '.$ss.'><td>'.$no.'</td><td>'.$b->jenis_dokumen.'</td><td>-</td></tr>';
				if($b->tipe == 2 && $b->table_view != ''){
					$table = $b->table_view;
					$id_d = $b->id_name;
					$det = $this->db->query("SELECT * FROM $table WHERE PEGAWAI_ID = '$PEGAWAI_ID'")->result();
					$nx = 1;
					foreach($det as $dd){
						if($b->id_jenis_dokumen == 18){
							//diklat struktural
							echo '<tr><td>'.$no.'.'.$nx.'</td><td>'.$dd->NO_STTPP.'</td><td>-</td></tr>';
						}else{
							echo '<tr><td>'.$no.'.'.$nx.'</td><td>'.$dd->NAMA.'</td><td>-</td></tr>';
						}
						
						$nx++;
					}
				}
				
				$no++;
				
			}*/
			?>
		</tbody>
        

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
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "processing": true, //Feature control the processing indicator.
          "serverSide": false, //Feature control DataTables' server-side processing mode.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('datadfs/getdataintegrasi')?>/<?=$PEGAWAI_ID;?>",
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
        getform('<?php echo site_url('datadfs/add') ?>/'+id,'<?=$PEGAWAI_ID;?>')
        //window.location = "<?=site_url('datadfs/add')?>/"+id;
    });
      });

 function getgambar(jenis,id){
  
  SximoModal("<?php echo site_url('datadfs/downloadgambar')?>/"+id+"/"+jenis,"View Dokumen","900");
 }
</script>
