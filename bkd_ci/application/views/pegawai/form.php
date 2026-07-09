<style>
	.unvalid {
		color: white;
		background-color: #7a0101;
	}

	.valid {
		color: black;
		background-color: #ffffff;
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="page-header">
	<div class="row align-items-end">
		<div class="col-lg-8">
			<div class="page-header-title">
				<div class="d-inline">
					<h4><?php echo $pageTitle; ?></h4>
					<span>Form <?php echo $pageTitle; ?></span>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="page-header-breadcrumb">
				<ul class="breadcrumb-title">
					<li class="breadcrumb-item">
						<a href="#"> <i class="feather icon-home"></i> </a>
					</li>
					<li class="breadcrumb-item"><a href="<?php echo site_url('pegawai') ?>"><?php echo $pageTitle ?></a></li>
					<li class="breadcrumb-item"><a href="#!">Form</a>

				</ul>
			</div>
		</div>
	</div>
</div>
<hr />
<div class="row">

	<div class="col-md-3">
		<div class="box box-primary">
			<div class="box-body box-profile text-center">

				<img class="profile-user-img img-responsive img-circle" src="<?php echo $fotoprofile; ?>" alt="User profile picture" style="width:100px;height:110px">
				<input type="hidden" value="<?php echo $row['NIP_BARU']; ?>" id="nip_dfs">
				<h3 class="profile-username text-center"><?php echo $row['GELAR_DEPAN']; ?> <?php echo $row['NAMA']; ?> <?php echo $row['GELAR_BELAKANG']; ?></h3>
				<p class="text-muted text-center">
					<?
					if ($row['NAMA'] != '') {
					?>
						<!-- <a href="javascript:changepages('datadfs')" class="btn btn-danger">
							<i class="fa fa-file"></i> Digital File <br /> (Integrasi ReDoc)
						</a> -->

						<?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : ?>

							<a href="" class="btn btn-primary">
								<i class="fas fa-sync-alt"></i><b>Sinkron Data Pegawai</b>
							</a>
						<?php else : ?>

						<?php endif; ?>
					<?
					}
					?>
				</p>
			</div>
		</div>

		<div class="box box-danger">
			<div class="box-body ">

				<ul class="sidebar-menu tree">
					<li class="treeview"><a href="javascript:changepages('pegawai/identitas')">
							<span>Identitas Pegawai</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>
					<!-- <li class="treeview"> -->
					<!-- <a href="javascript:changepages('pegawai/skcpns')"> -->
					<!-- <span>SK CPNS</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span> -->

					<!-- </a></li> -->
					<li class="treeview">
						<?php if ($row['STATUS_PEGAWAI'] == 10 || $row['STATUS_PEGAWAI'] == 18) : ?>
							<a href="javascript:changepages('pegawai/skpppk')">
								<span>SK PPPK</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a>
						<?php else : ?>
							<a href="javascript:changepages('pegawai/skcpns')">
								<span>SK CPNS</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a>
						<?php endif; ?>
					</li>

					<li class="treeview">
						<?php if ($row['STATUS_PEGAWAI'] == 10 || $row['STATUS_PEGAWAI'] == 18) : ?>

						<?php else : ?>
							<a href="javascript:changepages('pegawai/skpns')">
								<span>SK PNS</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a>
						<?php endif; ?>
					</li>

					<!-- <li class="treeview"><a href="javascript:changepages('pegawai/skpns')">
							<span>SK PNS</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->
					<!--li class="treeview"><a href="javascript:changepages('pengalamankerja')">
      <span>Pengalaman Kerja</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li-->
				</ul>
			</div>
		</div>

		<div class="box box-danger">
			<div class="box-body " style="height: 500px;overflow: auto">

				<ul class="sidebar-menu tree">

					<?php if ($row['STATUS_PEGAWAI'] == 10 || $row['STATUS_PEGAWAI'] == 18) : ?>
						<li class="treeview"><a href="javascript:changepages('riwayat_perjanjian_kerja')">
								<span>Riwayat Perjanjian Kerja</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>
					<?php else : ?>
						<li class="treeview"><a href="javascript:changepages('riwayatpangkat')">
								<span>Riwayat Pangkat</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>
						<!-- <li class="treeview"><a href="javascript:changepages('mutasi')">
								<span>Riwayat Jabatan</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li> -->
						<li class="treeview"><a href="javascript:changepages('riwayat_jabatan4')">
								<span>Riwayat Jabatan</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>
						<li class="treeview"><a href="javascript:changepages('riwayatgaji')">
								<span>Riwayat Gaji</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>
					<?php endif; ?>


					<!-- <?php //if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 5) : 
							?>
						<li class="treeview"><a href="javascript:changepages('riwayat_jabatan3')">
								<span>Riwayat Jabatan baru</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>

					<?php //endif; 
					?> -->

					<li class="treeview"><a href="javascript:changepages('pltplh')">
							<span>Riwayat PLT/PLH</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a>
					</li>




					<li class="treeview"><a href="javascript:changepages('riwayatpendidikan')">
							<span>Pendidikan Umum</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('diklatstruktural')">
							<span>Diklat Struktural</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<!-- <li class="treeview"><a href="javascript:changepages('diklatfungsional')">
							<span>Diklat Fungsional</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->

					<!-- <li class="treeview"><a href="javascript:changepages('diklatteknis')">
							<span>Diklat Teknis</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->
					<!-- <li class="treeview"><a href="javascript:changepages('penataran')">
							<span>Penataran</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->

					<!-- <li class="treeview"><a href="javascript:changepages('seminar')">
							<span>Seminar</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->

					<!-- <li class="treeview"><a href="javascript:changepages('workshop')">
							<span>Lokakarya / Workshop</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->

					<li class="treeview"><a href="javascript:changepages('kursus_riwayat')">
							<span>Diklat / Seminar / Kursus </span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('penghargaan')">
							<span>Penghargaan</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>
					<li class="treeview"><a href="javascript:changepages('tim_kerja')">
							<span>Tim Kerja</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('Keahlianprofesi')">
							<span>Keahlian / Profesi</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('orangtua/add')">
							<span>Orang Tua</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('mertua/add')">
							<span>Mertua</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('suamiistri')">
							<span>Suami / Istri</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('anak')">
							<span>Anak</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('saudara')">
							<span>Saudara</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('organisasi')">
							<span>Organisasi</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<?php if ($row['STATUS_PEGAWAI'] == 10 || $row['STATUS_PEGAWAI'] == 18) : ?>

					<?php else : ?>
						<li class="treeview"><a href="javascript:changepages('penilaiandptiga')">
								<span>Penilaian DP-3</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>

						<li class="treeview"><a href="javascript:changepages('penilaianasn')">
								<span>Sasaran Kinerja Pegawai (SKP)</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>

						<li class="treeview"><a href="javascript:changepages('tambahanmk/add')">
								<span>Tambahan Masa Kerja</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>
					<?php endif; ?>
					<li class="treeview"><a href="javascript:changepages('hukuman')">
							<span>Hukuman</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('cuti')">
							<span>Cuti</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('penugasan')">
							<span>Riwayat Penugasan</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('penguasaanbahasa')">
							<span>Penguasaan Bahasa</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<!-- <li class="treeview"><a href="javascript:changepages('nikah')">
							<span>Nikah</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->

					<li class="treeview"><a href="javascript:changepages('keppo_presensi')">
							<span>Keppo dan Presensi</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('skp22ekin')">
							<span>Kinerja Bulanan</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<li class="treeview"><a href="javascript:changepages('skp22')">
							<span>Kinerja Tahunan (tahun 2022 Keatas)</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>
					<?php if ($row['STATUS_PEGAWAI'] == 10 || $row['STATUS_PEGAWAI'] == 18) : ?>

					<?php else : ?>
						<li class="treeview"><a href="javascript:changepages('angkakredit')">
								<span>Penetapan Angka Kredit</span>
								<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
							</a></li>
					<?php endif; ?>

					<li class="treeview"><a href="javascript:changepages('view_dir_file')">
							<span>File Direktori </span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li>

					<!-- <li class="treeview"><a href="javascript:changepages('file_lama')">
							<span>File Lama</span>
							<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
						</a></li> -->

				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-9">
		<div class="box box-danger">
			<div class="box-header with-border">


				<?php echo $this->session->flashdata('message'); ?>
				<ul class="parsley-error-list">
					<?php echo $this->session->flashdata('errors'); ?>
				</ul>
				<div id="page-ajax">
				</div>


			</div>
		</div>
	</div>
</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		changepages('pegawai/identitas');

		setTimeout(function() {
			$('#mobile-collapse').click();
		}, 500);
	});

	function changepages(page) {
		$.ajax({
			url: "<?= site_url(); ?>/" + page,
			data: {
				id: "<?= $id; ?>"
			},
			type: "POST",
			dataType: "html",
			success: function(data) {
				$('#page-ajax').html(data);
			}
		});

		var ext;
		var page = page.split("/");

		if (page.length > 1) {
			if (page[0] == 'orangtua' || page[0] == 'mertua') ext = page[0];
			else ext = page[1];
		} else ext = page[0];


		// console.log(ext);
		setTimeout(
			function() {
				$.ajax({
					url: "<?= site_url(); ?>/validasidata/cekdata",
					data: {
						id: "<?= $id; ?>",
						page: ext
					},
					type: "POST",
					dataType: "json",
					success: function(e) {
						$.each(e.data, function(i, item) {
							var idx = item.DB_KEY_VALUE;
							$('#' + idx).attr("style", "color:white;background-color:#7a0101");
							//	$('#'+idx).addClass("unvalid");
						});
					}
				})
			}, 100);
	}
</script>