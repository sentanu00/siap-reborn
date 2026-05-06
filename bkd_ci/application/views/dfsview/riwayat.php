<div class="row">
            <div class="col-md-12">
			<a href="javascript:uploaddoc()" class='btn btn-danger btn-sm uploaddfs'>Upload Dokumen</a>
	<?php
	$ada = false;
		foreach($dfs as $d){
			$ada = true;
			?>
			<div class="col-md-12" style="margin-top:20px"><img src="<?php echo site_url('dfsview/generateimage/'.$d->id_dokumen);?>" style="max-width:100%"></div>
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
		$('.close').trigger( "click" );
		setTimeout(function() {
		SximoModal('<?=site_url("dfsview/formupload");?>/<?=$jns;?>/<?=$id;?>','Upload Document',1000);
		}, 1000)
	}
	</script>