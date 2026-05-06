				<ul class="nav nav-tabs nav-underline">
					<li class="nav-item">
						<a class="nav-link" href="javascript:changepages('mertua/add')" aria-expanded="false"><i class="fa fa-user"></i> Mertua</a>
					</li>
					<li class="nav-item">
						<a class="nav-link  <?php if ($jns == 45) echo "active"; ?>" href="javascript:changepages('dfsview/mertua/48')" aria-expanded="true"><i class="fa fa-image"></i> Kartu Keluarga Mertua</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($jns == 46) echo "active"; ?>" href="javascript:changepages('dfsview/mertua/49')" aria-expanded="false"><i class="fa fa-image"></i> Akta Mertua</a>
					</li>



				</ul>
				<br />
				<div class="row">
					<div class="col-md-12">
						<a href="javascript:uploaddoc()" class='btn btn-danger btn-sm uploaddfs'>Upload Dokumen</a>
						<?php
						$ada = false;
						foreach ($dfs as $d) {
							$ada = true;
							//echo $this->generateimage($d->id_dokumen);
							//echo site_url('dfsview/generateimage/'.$d->id_dokumen);

							$sql = $this->db->query("SELECT nama_file FROM dokumen WHERE id_dokumen = '$d->id_dokumen'")->row();
							$namafile = $sql->nama_file;
							$ext = explode(".", $namafile);
							$maxext = count($ext);
							$extn = $ext[$maxext - 1];
							if ($extn == 'pdf') {
								$urlberkas = base_url($sql->nama_file);
								echo '<div class="col-md-12" style="margin-top:20px"><iframe src="' . $urlberkas . '" width="100%" height="600px"></iframe></div>';
							} else {
								$urlberkas = base_url($sql->nama_file);
								echo '<div class="col-md-12" style="margin-top:20px"><img src="' . $urlberkas . '" style="max-width:100%"></div>';
							}
						}

						if (!$ada) {
						?>
							<center><img src="<?php echo base_url('nodoc.png'); ?>" style="max-width:250px"><br /><br />
								<h3>TIDAK ADA DOKUMENT</h3>
							</center>
						<?
						}
						?>
					</div>
				</div>

				<script>
					function uploaddoc() {
						SximoModal('<?= site_url("dfsview/formupload"); ?>/<?= $jns; ?>/<?= $id; ?>', 'Upload Document', 1000);
					}
				</script>