<label for="ipt" class=" control-label "> Pegawai Tanda Tangan </label>
<select rows="5" id="ttd_pegawai" class="form-control input-sm select2 " style="width: 100%;">
	<option value=""></option>
</select>
<hr />
<a href="javascript:cetakLaporanBulanan()" class="btn btn-info" style="color:white" title="Print Report">
	<i class="ti-print"></i>&nbsp;Cetak Laporan </a>
<script type="text/javascript">
	$(document).ready(function() {
		$('.select2').select2();
		$("#ttd_pegawai").jCombo("<?= site_url(); ?>/pegawai/comboselect?filter=vw_pegawai_aktif:PEGAWAI_ID:NIP_BARU|NAMA_LENGKAP:SATKER_PARENT:" + idsatker, {
			selected_value: ''
		});
	});

	function cetakLaporanBulanan() {
		if ($('#ttd_pegawai').val() == '') {
			alert("Pilih Pegawai terlebih dahulu");
		} else {
			url = "<?php echo site_url('reportlaporanbulanan/cetak'); ?>/" + idsatker + "/" + $('#ttd_pegawai').val();
			window.open(url);
		}
	}
</script>