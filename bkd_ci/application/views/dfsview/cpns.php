<ul class="nav nav-tabs nav-underline">
					<li class="nav-item">
						<a class="nav-link "  href="javascript:changepages('pegawai/skcpns')" aria-expanded="false"><i class="fa fa-user"></i> SK CPNS</a>
					</li>
					<!--li class="nav-item">
						<a class="nav-link <?php if($jns == 6) echo "active";?> " href="javascript:changepages('dfsview/cpns/6')"  aria-expanded="true"><i class="fa fa-image"></i> Lampiran SK</a>
					</li-->
					<!--li class="nav-item">
						<a class="nav-link <?php if($jns == 7) echo "active";?>" href="javascript:changepages('dfsview/cpns/7')"  aria-expanded="false"><i class="fa fa-image"></i> Konversi NIP</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if($jns == 8) echo "active";?>" href="javascript:changepages('dfsview/cpns/8')"  aria-expanded="false"><i class="fa fa-image"></i> Penetapan NIP</a>
					</li-->
					<!--li class="nav-item">
						<a class="nav-link <?php if($jns == 9) echo "active";?>" href="javascript:changepages('dfsview/cpns/9')" aria-expanded="false"><i class="fa fa-image"></i> SPMT</a>
					</li-->
					<!--li class="nav-item">
						<a class="nav-link <?php if($jns == 10) echo "active";?>" href="javascript:changepages('dfsview/cpns/10')"  aria-expanded="false"><i class="fa fa-image"></i> Prajabatan</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link <?php if($jns == 11) echo "active";?>" href="javascript:changepages('dfsview/cpns/11')"  aria-expanded="false"><i class="fa fa-image"></i> Lampiran D2</a>
					</li-->
				</ul>
<br />
	 <div class="row">
            <div class="col-md-12">
			<a href="javascript:uploaddoc()" class='btn btn-danger btn-sm uploaddfs'>Upload Dokumen</a>
	<?php
	$ada = false;
		foreach($dfs as $d){
			$ada = true;
			//echo $this->generateimage($d->id_dokumen);
			//echo site_url('dfsview/generateimage/'.$d->id_dokumen);
			
			$sql = $this->db->query("SELECT nama_file FROM dokumen WHERE id_dokumen = '$d->id_dokumen'")->row();
		$namafile = $sql->nama_file;
		$ext = explode(".",$namafile);
		$maxext = count($ext);
		$extn = $ext[$maxext-1];
		if($extn == 'pdf'){
			$urlberkas = base_url($sql->nama_file);
			echo '<div class="col-md-12" style="margin-top:20px"><iframe src="' . $urlberkas . '" width="100%" height="600px"></iframe></div>';
		}else{
			$urlberkas = base_url($sql->nama_file);
			echo '<div class="col-md-12" style="margin-top:20px"><img src="'.$urlberkas.'" style="max-width:100%"></div>';
		}
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