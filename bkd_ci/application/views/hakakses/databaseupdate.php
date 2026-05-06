<section class="content-header">
          <h1>
            Updates
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>List Semua Update</li>
          </ol>
        </section>
	

	<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
              	<div class="box-header with-border">
                  <h3 class="box-title">Sinkronisasi Database</h3>
 <div class="box-body">
 	<div class="page-content-wrapper">
<table class="table table-bordered display dataTable no-footer" id="gridv" role="grid" aria-describedby="gridv_info">
        <thead>
          <th>Nama File</th>
          <th>Tanggal Updates</th>
          <th>Sinkronisasi Local</th>
        </thead>
  <?php

    foreach ($direktori as $key) {
      if($key->status_sync == 0){
      echo "<tr><td>".$key->nama_file."</td><td>".$key->dateadd."</td><td>
      <a href='javascript:getupdatesdb(".$key->id.")' class='btn btn-info'><i class='fa fa-sync'></i> Sync</a>
      </td></tr>";
      }else{
      echo "<tr><td>".$key->nama_file."</td><td>".$key->dateadd."</td><td>".$key->datesync."</td></tr>";
      }
    }
  ?>
  </table>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>

  <script type="text/javascript">
    
    function getupdatesdb(id){
      if(confirm('Apakah anda yakin untuk sync database ini ?')){
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('hakakses/syncdatabase');?>",
            data: {id:id},
            success: function (data) {
                alert('Database Berhasil disinkronisasikan !!');
              //  window.reload();
              window.location = '<?php echo site_url('hakakses/databaseupdate');?>';
        
            }
        });
      }
    }

    function getresetdata(jns){
      if(confirm('Apakah anda yakin untuk reset database ini, semua data master dan transaksi akan hilang ?')){
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('hakakses/resetdata');?>",
            data: {jns:jns},
            success: function (data) {
                alert('Database Berhasil direset !!');
              //  window.reload();
             // window.location = '<?php echo site_url('hakakses/databaseupdate');?>';
        
            }
        });
      }
    }
  </script>