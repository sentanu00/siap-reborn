$(document).ready(function(){
	
	//localStorage.setItem("id", "235752200026");
	//localStorage.setItem("nip", "196405031990032006");
	getProfile();
});
function getProfile(){
	nip = localStorage.getItem("nip");
	$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/biodata",
            data: {nip:nip},
            dataType:'json',
            success: function (data) {
                var x = data.data;
				$('#namalengkap').html(x.nama);
				$('#nipbaru').html(x.nip_baru);
				$('#jabatan').html(x.jabatan);
				$('#satker').html(x.satker);
				 $("#fotoava").css("background-image", 'url("http://siap.bkd.probolinggokab.go.id/main/foto/'+nip+'/foto_setengah_'+nip+'.jpeg")');
				$('#gol').html(x.nmgolruang+' ('+x.gol_ruang+')');
				
				$('#pangkatterakhir').val(x.nmgolruang+' ('+x.gol_ruang+')');
				$('#tmtpangkat').val(x.tmt_pangkat);
				
				$('#jabatanterakhir').val(x.jabatan);
				$('#tmtjabatan').val(x.tmt_jabatan);
				
				$('#pendidikanterakhir').val(x.pendidikan);
				$('#thnlulus').val(x.lulus);
				
				$('#tipepegawai').val(x.tipe_pegawai_id);
				$('#statuspegawai').val(x.status_pegawai);
				
				$('#nip').val(x.nip_lama+' / '+x.nip_baru);
				$('#ttl').val(x.tempat_lahir+", "+x.tanggal_lahir);
				$('#jeniskelamin').val(x.kelamin);
				$('#statuskawin').val(x.kawin);
				$('#agama').val(x.agama);
				
				
				
				$.ajax({
            type: "GET",
            url: "http://siap.bkd.probolinggokab.go.id:8080/bkd_laravel/public/rest/resource/pegawaitable",
            data: {nip:nip},
            dataType:'json',
            success: function (data) {
				var d = data.data;
				$('#kodepos').val(d.kodepos);
				$('#alamat').val(d.alamat+" RT. "+d.rt+" RW. "+d.rw);
				$('#telepon').val(d.no_hp);
				$('#nik').val(d.nik);
				$('#npwp').val(d.npwp);
				$('#taspen').val(d.taspen);
				$('#askes').val(d.askes);
				$('#email').val(d.email);
				$('#kpe').val(d.no_kpe);
				$('#rekening').val(d.no_rekening);
				$('#kartupegawai').val(d.kartu_pegawai);
			}
            });
			}
				
        });
}