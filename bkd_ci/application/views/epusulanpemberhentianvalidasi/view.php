<style>
	.nav-item{
		padding-left: 3px;
		padding-right: 3px;
		background-color: #c0c0c045;
		
	}
	.tab-pane{
		padding: 10px;
	}
	</style>
          <div class="row">
		  <div class="col-md-12">
              <div class="box box-danger">
              	<div class="box-header with-border" >	
				<div class="table-responsive">
					<table class="table table-striped table-bordered" >
						<tbody>	
					
					<tr>
						<td width='10%' class='label-view text-right' style="background: #002542;color: white;">NIP</td>
						<td width='50%'><?php echo $row['NIP_BARU'] ;?> </td>
						<td width='10%' class='label-view text-right' style="background: #002542;color: white;">UNOR</td>
						<td  ><?php echo $row['unor'] ;?> </td>
					</tr>
				
					<tr>
						
						<td width='10%' class='label-view text-right' style="background: #002542;color: white;">NAMA</td>
						<td  ><?php echo $row['NAMA_PEGAWAI'] ;?> </td>
						<td width='10%' class='label-view text-right' style="background: #002542;color: white;">SATUAN KERJA</td>
						<td  ><?php echo $row['satuan_kerja'];?> </td>
						<input type="hidden" id="id_usulan" value="<?php echo $row['id']; ?>" />
					</tr>
					<tr>
						
					<td width='10%' class='label-view text-right' style="background: #002542;color: white;">GOL. PEMBERHENTIAN</td>
						<td ><?php echo $row['golongan_pemberhentian_nama'] ;?> </td>
						
						<td width='10%' class='label-view text-right' style="background: #002542;color: white;">JENIS PEMBERHENTIAN</td>
						<td ><?php echo $row['jenis_pemberhentian_nama'];?> </td>
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
				
				  <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" onclick="getTabData('detaildata','1')" id="detaildata-tab" data-toggle="tab" href="#detaildata" role="tab" aria-controls="home" aria-selected="true"><i class="ti-list" style="color:red"></i><br />Detail Data</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " onclick="getTabData('keterangan','2')" id="detaildata-tab" data-toggle="tab" href="#keterangan" role="tab" aria-controls="keterangan" aria-selected="true"><i class="ti-pencil-alt" style="color:magenta"></i><br />Keterangan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " onclick="getTabData('dokumen','3')" id="dokumen-tab" data-toggle="tab" href="#dokumen" role="tab" aria-controls="profile" aria-selected="false"><i class="ti-export"  style="color:#4452bc"></i><br />Dokumen Persyaratan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " onclick="getTabData('keluarga','4')" id="contact-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false"><i class="fa fa-group"  style="color:#a39e18"></i><br />Keluarga</a>
  </li>
  <?php
  if($row['usulan_status'] == 2){
  ?>
  <li class="nav-item">
    <a class="nav-link " onclick="validasiFormView()" id="validasi-tab" data-toggle="tab" href="#validasi" role="tab" aria-controls="validasi" aria-selected="false"><i class="fa fa-check text-success" ></i><br />Validasi Data</a>
  </li>
  <?php
  }else if($row['usulan_status'] == 3){
	?>
	<li class="nav-item">
    <a class="nav-link " onclick="UploadSKFormView()" id="uploadskform-tab" data-toggle="tab" href="#uploadskform" role="tab" aria-controls="uploadskform" aria-selected="false"><i class="fa fa-upload text-success" ></i><br />Upload SK</a>
  </li>
	<?
}
  ?>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="detaildata" role="tabpanel" aria-labelledby="detaildata-tab"> Loading ...</div>
  <div class="tab-pane fade" id="keterangan" role="tabpanel" aria-labelledby="keterangan-tab">Loading ...</div>
  <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">Loading ...</div>
  <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">Loading...</div>
  <div class="tab-pane fade" id="validasi" role="tabpanel" aria-labelledby="validasi-tab">Loading...</div>
  <div class="tab-pane fade" id="uploadskform" role="tabpanel" aria-labelledby="uploadskform-tab">Loading...</div>
</div>


			</div>
		</div>		
	

	</div>
</div>
	  
<script>
$(document).ready(function(){
	getTabData('detaildata',1);

	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var $target = $(e.target);
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

	
})

function nextTab(elem) {
    $(elem).parent().next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).parent().prev().find('a[data-toggle="tab"]').click();
}

function validasiFormView(){
	$.ajax({
				url: "<?php echo site_url('epusulanpemberhentianvalidasi') ?>/validasiForm",
				data:{id:'<?php echo $id;?>'},
				type: "POST",
				dataType:"html",
				success: function(data) {
					$('#validasi').html(data);

					$(".next-step").click(function (e) {
						var $active = $('.nav-tabs li>.active');
						$active.parent().next().find('.nav-link').removeClass('disabled');
						nextTab($active);
					});

					$(".prev-step").click(function (e) {
						var $active = $('.nav-tabs li>a.active');
						prevTab($active);
					});
				}
			});
}

function UploadSKFormView(){
	$.ajax({
				url: "<?php echo site_url('epusulanpemberhentianvalidasi') ?>/uploadskForm",
				data:{id:'<?php echo $id;?>'},
				type: "POST",
				dataType:"html",
				success: function(data) {
					$('#uploadskform').html(data);

					$(".next-step").click(function (e) {
						var $active = $('.nav-tabs li>.active');
						$active.parent().next().find('.nav-link').removeClass('disabled');
						nextTab($active);
					});

					$(".prev-step").click(function (e) {
						var $active = $('.nav-tabs li>a.active');
						prevTab($active);
					});
				}
			});
}


function getTabData(hal,loc){
	var url = "<?php echo site_url('epusulanpemberhentianpegawai') ?>/"+hal;
	if(loc == '4') url = "<?php echo site_url('epusulanpemberhentianvalidasi') ?>/"+hal;
	$.ajax({
				url: url,
				data:{id:'<?php echo $id;?>'},
				type: "POST",
				dataType:"html",
				success: function(data) {
					$('#'+hal).html(data);

					$(".next-step").click(function (e) {
						var $active = $('.nav-tabs li>.active');
						$active.parent().next().find('.nav-link').removeClass('disabled');
						nextTab($active);
					});

					$(".prev-step").click(function (e) {
						var $active = $('.nav-tabs li>a.active');
						prevTab($active);
					});
				}
			});
}
</script>