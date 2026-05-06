$(document).ready(function(){
	
	//localStorage.setItem("id", "235752200026");
	//localStorage.setItem("nip", "196405031990032006");
	if(!localStorage.nip && !localStorage.id){
            //  localStorage.playerID = "<?php if(isset($_GET['playerID'])) echo $_GET['playerID'];?>";
              window.location = 'login.html';
    }else{
	getProfile();
	}
});

function logout(){
	if(confirm("Apakah anda Yakin akan keluar ?")){
		localStorage.removeItem("nip");
		localStorage.removeItem("id");
		location.reload();
	}
}

//

function getProfile(){
	nip = localStorage.getItem("nip");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/biodata",
            data: {nip:nip},
            dataType:'json',
            success: function (data) {
                var x = data.data;
				$('#nama').html(x.nama);
				$('#nip').html(x.nip_baru);
				$('#jabatansatker').html(x.jabatan+"<br />"+x.satker);
				 $("#fotoava").css("background-image", 'url("http://siap.bkd.probolinggokab.go.id/main/foto/'+nip+'/foto_setengah_'+nip+'.jpeg")');
			}
	});
}

function skpns(){
	$('#bodymodal').html('');
					$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/dataskpns",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					var d = data.data;
					$.each(d,function(i,a){
						i = i.replace('_',' ');
						htm += '<div class="form-group float-label active " >'+
                            '<input type="text" style="font-size:13px;font-weight:bold" class="form-control is-valid" value="'+a+'" readonly>'+
                            '<label class="form-control-label">'+i.toUpperCase()+'</label></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("SK. PNS");
			}
	});
}

function skcpns(){
	$('#bodymodal').html('');
					$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/dataskcpns",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					var d = data.data;
					$.each(d,function(i,a){
						i = i.replace('_',' ');
						htm += '<div class="form-group float-label active " >'+
                            '<input type="text" style="font-size:13px;font-weight:bold" class="form-control is-valid" value="'+a+'" readonly>'+
                            '<label class="form-control-label">'+i.toUpperCase()+'</label></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				$('#bodymodal').html(htm);
				$('#modal-title').html("SK. CPNS");
			}
	});
}

function pekerjaan(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	var htm='';
	htm += "<img src='img/nodata.jpg' style='width:100%' />";
	$('#bodymodal').html(htm);
	$('#modal-title').html("Riwayat Pekerjaan");
}

function pangkat(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/pangkatriwayat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+a1.jenis+' | '+a1.tmt_pangkat+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.nama_pangkat+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">No SK : '+a1.no_sk+'</p>'+
                                '<p class="">Tgl SK : '+a1.tanggal_sk+'</p>'+
                                '<h6 class="mb-1">'+a1.pejabat_penetap+'</h6>'+
                            '</div>'+
                            '<button class="btn btn-default btn-40 rounded-circle"><i class="material-icons">arrow_right</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Pangkat");
			}
	});
}

function mutasi(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/mutasiriwayat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">No SK  : '+a1.no_sk+'<br />'+
                                'Tgl SK : '+a1.tanggal_sk+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">Eselon : '+a1.eselon+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">'+a1.nama+'</p>'+
                                '<p class="">TMT Jabatan : '+a1.tmt_jabatan+'</p>'+
                                '<p class="mb-1">'+a1.nmpejabatpenetap+'</p>'+
                            '</div>'+
                            '<button class="btn btn-default btn-40 rounded-circle"><i class="material-icons">arrow_right</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Mutasi");
			}
	});
}

function gaji(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/gajiriwayat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">No SK  : '+a1.no_sk+'<br />'+
                                'Tgl SK : '+a1.tanggal_sk+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">Pangkat : '+a1.nmpangkat+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">Rp. '+(a1.gaji_pokok)+'</p>'+
                                '<p class="">TMT SK : '+a1.tmt_sk+'</p>'+
                                '<p class="mb-1">'+a1.nmpejabatpenetap+'</p>'+
                            '</div>'+
                            '<button class="btn btn-default btn-40 rounded-circle"><i class="material-icons">arrow_right</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Gaji");
			}
	});
}

function struktural(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/strukturaldiklat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">No STTP  : '+a1.no_sttpp+'<br />'+
                                'Tgl STTP : '+a1.tanggal_sttpp+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.tempat+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">'+a1.namadiklat+'</p>'+
                                '<p class="">'+a1.tanggal_mulai+' s/d '+a1.tanggal_selesai+'</p>'+
                                '<p class="mb-1">'+a1.penyelenggara+'</p>'+
                            '</div>'+
                            '<button class="btn btn-danger btn-40 rounded-circle"><i class="material-icons">place</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Diklat Struktural");
			}
	});
}

function fungsional(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/fungsionaldiklat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">No STTP  : '+a1.no_sttpp+'<br />'+
                                'Tgl STTP : '+a1.tanggal_sttpp+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.tempat+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">'+a1.nama+'</p>'+
                                '<p class="">'+a1.tanggal_mulai+' s/d '+a1.tanggal_selesai+'</p>'+
                                '<p class="mb-1">'+a1.penyelenggara+'</p>'+
                            '</div>'+
                            '<button class="btn btn-info btn-40 rounded-circle"><i class="material-icons">place</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Diklat Fungsional");
			}
	});
}

function teknis(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/teknisdiklat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">No STTP  : '+a1.no_sttpp+'<br />'+
                                'Tgl STTP : '+a1.tanggal_sttpp+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.tempat+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">'+a1.nama+'</p>'+
                                '<p class="">'+a1.tanggal_mulai+' s/d '+a1.tanggal_selesai+'</p>'+
                                '<p class="mb-1">'+a1.penyelenggara+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">place</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Diklat Fungsional");
			}
	});
}

function pendidikan(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/pendidikanriwayat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">No STTB  : '+a1.no_sttb+'<br />'+
                                'Tgl STTB : '+a1.tanggal_sttb+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.pendidikan+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="">'+a1.pendidikan+' '+a1.jurusan+'</p>'+
                                '<p class="mb-1 text-default">'+a1.nama+'</p>'+
                                '<p class="mb-1">'+a1.kepala+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">school</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Pendidikan");
			}
	});
}

function keluarga(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/keluarga",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						nm = "IBU";
						if(a1.jenis_kelamin == 'L') nm = "AYAH";
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+nm+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success"></p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="">'+a1.nama+'</p>'+
                                '<p class="mb-1 text-default">TTL : '+a1.tempat_lahir+', '+a1.tanggal_lahir+'</p>'+
                                '<p class="mb-1">Pekerjaan : '+a1.pekerjaan+'</p>'+
                                '<p class="mb-1">Alamat : '+a1.alamat+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">family_restroom</i></button>'+
							'</div></div></div>';
						
					});
					var d = data.suamiistri;
					$.each(d,function(i1,a1){
						nm = "Suami / Istri";
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+nm+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">PNS : '+a1.nmpns+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="">'+a1.nama+'</p>'+
                                '<p class="mb-1 text-default">TTL : '+a1.tempat_lahir+', '+a1.tanggal_lahir+'</p>'+
                                '<p class="mb-1">Pekerjaan : '+a1.pekerjaan+'</p>'+
                            '</div>'+
                            '<button class="btn btn-primary btn-40 rounded-circle"><i class="material-icons">family_restroom</i></button>'+
							'</div></div></div>';
						
					});
					
					var d = data.anak;
					$.each(d,function(i1,a1){
						nm = "Anak Perempuan";
						if(a1.jenis_kelamin == 'L') nm = "Anak Laki-laki";
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+nm+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">Tunj. '+a1.tunjangan+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="">'+a1.nama+' ('+a1.keluarga+')</p>'+
                                '<p class="mb-1 text-default">TTL : '+a1.tempat_lahir+', '+a1.tanggal_lahir+'</p>'+
                                '<p class="mb-1">Pekerjaan : '+a1.nmpendidikan+'</p>'+
                            '</div>'+
                            '<button class="btn btn-danger btn-40 rounded-circle"><i class="material-icons">family_restroom</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Keluarga");
			}
	});
}

function organisasi(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/organisasiriwayat",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+a1.tanggal_awal+' s/d '+a1.tanggal_akhir+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.tempat+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="">'+a1.nama+'</p>'+
                                '<p class="mb-1 text-default">Jabatan : '+a1.jabatan+'</p>'+
                                '<p class="mb-1">Pimpinan : '+a1.pimpinan+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">place</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Organisasi");
			}
	});
}

function penilaian(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/penilaian",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">TAHUN : '+a1.tahun+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.rata_rata+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">Kesetiaan : '+a1.kesetiaan+'</p>'+
                                '<p class="mb-1 text-default">Prestasi : '+a1.prestasi+'</p>'+
                                '<p class="mb-1 text-default">Tanggung Jawab : '+a1.tanggung_jawab+'</p>'+
                                '<p class="mb-1 text-default">Ketaatan : '+a1.ketaatan+'</p>'+
                                '<p class="mb-1 text-default">Kejujuran : '+a1.kejujuran+'</p>'+
                                '<p class="mb-1 text-default">Kerjasama : '+a1.kerjasama+'</p>'+
                                '<p class="mb-1 text-default">Prakarsa : '+a1.prakarsa+'</p>'+
                                '<p class="mb-1 text-default">Kepemimpinan : '+a1.kepemimpinan+'</p>'+
                                '<p class="mb-1 text-danger">Jumlah : '+a1.jumlah+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">event</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Penilaian DP-3");
			}
	});
}

function prestasi(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/prestasi",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">TAHUN : '+a1.tahun+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">JUMLAH NILAI : '+a1.jumlah_nilai+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">SKP : '+a1.skp_nilai+'</p>'+
                                '<p class="mb-1 text-default">ORIENTASI : '+a1.orientasi_nilai+'</p>'+
                                '<p class="mb-1 text-default">INTEGRITAS : '+a1.integritas_nilai+'</p>'+
                                '<p class="mb-1 text-default">KOMITMEN : '+a1.komitmen_nilai+'</p>'+
                                '<p class="mb-1 text-default">DISIPLIN : '+a1.disiplin_nilai+'</p>'+
                                '<p class="mb-1 text-default">KERJASAMA : '+a1.kerjasama_nilai+'</p>'+
                                '<p class="mb-1 text-default">KEPEMIMPINAN : '+a1.kepemimpinan_nilai+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">event</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Penilaian SKP");
			}
	});
}

function hukuman(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/hukuman",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+a1.tanggal_awal+' s/d '+a1.tanggal_akhir+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.permasalahan+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="">'+a1.jenis_hukuman+'</p>'+
                                '<p class="mb-1 text-default">NO SK '+a1.no_sk+'</p>'+
                                '<p class="mb-1">TGL SK : '+a1.tgl_sk+'</p>'+
                                '<p class="mb-1">TMT SK : '+a1.tmt_sk+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">place</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Hukuman");
			}
	});
}

function cuti(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/cuti",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small">'+a1.tanggal_mulai+' s/d '+a1.tanggal_selesai+'</p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.nmcuti+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">NO Surat '+a1.no_surat+'</p>'+
                                '<p class="mb-1">TGL Surat : '+a1.tanggal_surat+'</p>'+
                                '<p class="mb-1">TGL Permohonan : '+a1.tanggal_permohonan+'</p>'+
                                '<p class="mb-1 text-danger">Lama : '+a1.lama+' Hari</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">place</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Cuti");
			}
	});
}

function bahasa(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/bahasa",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small"></p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.nama+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">'+a1.nama+'</p>'+
                                '<p class="mb-1">Kemampuan : '+a1.mampu+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">translate</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Riwayat Cuti");
			}
	});
}

function penghargaan(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/penghargaan",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '';
				if(data.status == "true"){
					
					var d = data.data;
					$.each(d,function(i1,a1){
						htm += '<div class="card mb-3">'+
						'<div class="card-body position-relative">'+
                        '<div class="row mb-2">'+
                            '<div class="col">'+
                                '<p class="text-secondary small"></p>'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<p class="text-success">'+a1.tahun+'</p>'+
                            '</div>'+
                        '</div>'+
                        '<div class="media">'+                           
                            '<div class="media-body">'+
                                '<p class="mb-1 text-default">'+a1.nmpenghargaan+'</p>'+
                                '<p class="mb-1">No. SK : '+a1.no_sk+'</p>'+
                                '<p class="mb-1">Tgl. SK : '+a1.tgl_sk+'</p>'+
                                '<p class="mb-1">Pejabat Penetap : '+a1.nmpejabatpenetap+'</p>'+
                            '</div>'+
                            '<button class="btn btn-warning btn-40 rounded-circle"><i class="material-icons">military_tech</i></button>'+
							'</div></div></div>';
						
					});
					
				}else{
					htm += "<img src='img/nodata.jpg' style='width:100%' />";
				}
				
				$('#bodymodal').html(htm);
				$('#modal-title').html("Penghargaan");
			}
	});
}

function laporandfs(){
	$('#bodymodal').html('');
	$('#modal-title').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/laporandfs",
            data: {id:id},
            dataType:'json',
            success: function (data) {
				var htm = '<div class="card-body p-0">'+
                        '<div class="table-responsive">'+
                            '<table class="table table-striped">'+
                                '<thead>'+
                                    '<tr>'+
                                        '<th scope="col">#</th>'+
                                        '<th scope="col">Nama</th>'+
                                        '<th scope="col">Handle</th>'+
                                    '</tr></thead><tbody>';
				console.log(data);
				$.each(data,function(i,a){
					if(a.t == 0){
						htm += '<tr><th scope="row">'+a.no+'</th>'+
                             '<td>'+a.nm+'</td>'+
                              '<td><button class="btn btn-sm btn-warning px-4 rounded" onclick="downloaddoc('+a.no+')" data-toggle="modal" data-target="#modal-dialog-file"><span class="material-icons">file_download</span></button></td></tr>';
					}else{
						htm += '<tr><th scope="row">'+a.no+'</th>'+
                             '<td>'+a.nm+'</td>'+
                              '<td>'+a.hal+'</td></tr>';
					}
					 
				});
				 htm += ' </tbody></table></div> </div>';
				$('#bodymodal').html(htm);
				$('#modal-title').html("Checklist DFS");
			}
	});
}

function downloaddoc(i){
	$('#bodymodalfile').html('');
	$('#modal-title-file').html("Loading..");
	var id = localStorage.getItem("id");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/downloaddoc",
            data: {id:i,pegid:id},
            dataType:'html',
            success: function (data) {
				//var htm;
				$('#bodymodalfile').html(data);
				$('#modal-title-file').html("View DFS");
			}
	});
}