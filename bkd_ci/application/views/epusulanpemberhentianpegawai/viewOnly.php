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
    <a class="nav-link disabled" onclick="getTabData('keterangan','2')" id="detaildata-tab" data-toggle="tab" href="#keterangan" role="tab" aria-controls="keterangan" aria-selected="true"><i class="ti-pencil-alt" style="color:magenta"></i><br />Keterangan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" onclick="getTabData('dokumen','3')" id="dokumen-tab" data-toggle="tab" href="#dokumen" role="tab" aria-controls="profile" aria-selected="false"><i class="ti-export"  style="color:#4452bc"></i><br />Dokumen Persyaratan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" onclick="getTabData('keluarga','4')" id="contact-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false"><i class="fa fa-group"  style="color:#a39e18"></i><br />Keluarga</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="detaildata" role="tabpanel" aria-labelledby="detaildata-tab"> Loading ...</div>
  <div class="tab-pane fade" id="keterangan" role="tabpanel" aria-labelledby="keterangan-tab">Loading ...</div>
  <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">Loading ...</div>
  <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">Loading...</div>
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

function getTabData(hal,loc){
	$.ajax({
				url: "<?php echo site_url('epusulanpemberhentianpegawai') ?>/"+hal,
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