<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> API BKD - KAB PROBOLINGGO</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sximo/js/plugins/bootstrap/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>sximo/css/sximo.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>sximo/css/icon.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/adminlte/dist/css/AdminLTE.min.css">

	<script src="<?php echo base_url(); ?>sximo/js/plugins/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>sximo/js/plugins/parsley.js"></script>
	<script src="<?php echo base_url(); ?>sximo/js/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->



</head>

<body class="gray-bg">
	<div class="content-wrapper" style="margin-left:0px">
		<section class="content-header">
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Apps </a></li>
				<li>API</li>
			</ol>
		</section>


		<section class="content">
			<div class="row" style="margin-top: 25px;">
				<div class="col-xs-12">
					<div class="box box-danger">
						<div class="box-header with-border">
							<h3 class="box-title">API BKD - KAB PROBOLINGGO</h3>
							<h4>Main URL : <?= site_url('apiexternal'); ?></h4>
						</div>
						<div class="box-body">

							<div class="page-content-wrapper m-t">

								<div class="sbox animated fadeIn">
									<div class="sbox-content">

										<div class="table-responsive">
											<table class="table table-bordered display">
												<thead>
													<tr>
														<th width="10px"> NO </th>
														<th> SERVICE </th>
														<th> URL ENDPOINT </th>
														<th> PARAM </th>
														<th> METHOD </th>
														<th> KETERANGAN </th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1</td>
														<td>API LIST PEGAWAI</td>
														<td>
															<a href="<?php echo site_url('apiexternal/pegawailist') ?>" target="_blank">pegawailist</a>
														</td>
														<td>
															- nama=<br />
															<a href="<?php echo site_url('apiexternal/pegawailist?nama=sentanu'); ?>" target="_blank">Contoh Searching</a><br />
														</td>
														<td>GET</td>
														<td>
															ada 3 status : <br />
															- error 1 <br />
															<pre>
{
    "status": "error",
    "msg": "maaf keyword anda kosong. masukan minimal 3 huruf"
}
																	</pre>
															- error 2<br />
															<pre>
{
    "status": "error",
    "msg": "maaf masukan minimal 3 huruf"
}
																	</pre>
															- success <br />

															<pre>
{
    "status": "success",
    "msg": "Pencarian berhasil",
    "result": {
        "total": "1",
        "data": [
            {
                "NIP_BARU": "199306302019031003",
                "NAMA": "INDRA SENTANU MARYONO, A.Md.Kom.",
                "JABATAN": "PENGELOLA DATABASE  ",
                "PANGKAT": "Pengatur",
                "NAMA_SATKER": "BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA",
                "URL_FOTO": "http://siap.bkd.probolinggokab.go.id:8082/main/foto/199306302019031003/foto_setengah_199306302019031003.jpeg"
            }
        ]
    }
}
																	</pre>
														</td>
													</tr>
													<tr>
														<td>2</td>
														<td>API BIODATA</td>
														<td>
															<a href="<?php echo site_url('apiexternal/biodata') ?>" target="_blank">biodata</a>
														</td>
														<td>
															- nip=<br />
															<a href="<?php echo site_url('apiexternal/biodata?nip=199306302019031003'); ?>" target="_blank">Contoh Searching</a><br />
														</td>
														<td>GET</td>
														<td>
															ada 2 status : <br />
															- error <br />
															<pre>
{
    "status": "error",
    "msg": "Maaf data tidak ada dengan NIP. 1993063020190310031"
}
																	</pre>
															- success <br />

															<pre>
{
    "status": "success",
    "msg": "Data ditemukan.",
    "data": [
        {
            "NIP_BARU": "199306302019031003",
            "NAMA": "INDRA SENTANU MARYONO, A.Md.Kom.",
            "JABATAN": "PENGELOLA DATABASE  ",
            "PANGKAT": null,
            "NAMA_SATKER": "BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA",
            "URL_FOTO": "http://siap.bkd.probolinggokab.go.id:8082/main/foto/199306302019031003/foto_setengah_199306302019031003.jpeg"
        }
    ]
}
																	</pre>
														</td>
													</tr>


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

		</section>
	</div>

</body>

</html>