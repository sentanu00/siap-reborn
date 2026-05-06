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



	<div class="col-md-12">
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
		changepages('honorer/identitas');

		// setTimeout(function(){ $('#mobile-collapse').click(); }, 500);
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
		if (page.lenght > 1) ext = page[1];
		ext = page;
		alert(ext);
	}
</script>