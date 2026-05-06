<ul class="nav nav-tabs nav-underline">
					<li class="nav-item">
						<a class="nav-link "  href="javascript:changepages('pegawai/skpns')" aria-expanded="false"><i class="fa fa-user"></i> SK PNS</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if($jns == 12) echo "active";?> " href="javascript:changepages('dfsview/pns/12')"  aria-expanded="true"><i class="fa fa-image"></i> Lampiran SK</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if($jns == 13) echo "active";?>" href="javascript:changepages('dfsview/pns/13')"  aria-expanded="false"><i class="fa fa-image"></i> Sumpah PNS</a>
					</li>
					
				</ul>
<br />
	 <div class="row">
            <div class="col-md-12">
			<a href="javascript:uploaddoc()" class='btn btn-danger btn-sm uploaddfs'>Upload Dokumen</a>
	<?php
	$ada = false;
		foreach($dfs as $d){
			$ada = true;
			?>
			<div class="col-md-10" style="margin-top:20px"><img src="<?php echo site_url('dfsview/generateimage/'.$d->id_dokumen);?>" style="max-width:100%"></div>
			<?php
		}
		
		if(!$ada){
			?>
			<center><img src="<?php echo base_url('nodoc.png');?>" style="max-width:250px"><br /><br /><h3>TIDAK ADA DOKUMENT</h3></center>
			<?
		}
	?>
	</div>
	</div>
	
	<script>
	function uploaddoc()
	{
		SximoModal('<?=site_url("dfsview/formupload");?>/<?=$jns;?>/<?=$id;?>','Upload Document',1000);
	}
	</script>