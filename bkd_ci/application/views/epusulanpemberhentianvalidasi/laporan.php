<style type="text/css">
@media all {
 .page-break  { display: none; }
}

@media print {
 .page-break  { display: block; page-break-before: always; }
}
td{
	padding: 3px;
}
</style>
<body>
<table  style="width:100%">
<tbody>
<tr>
<td style="text-align: center;">
    
<table  style="height: 5px;font-family:Monospace;" border="0" width="100%">
<tbody>
<tr>
<td align="left" colspan="3" style="font-size:10px;border-bottom: dashed 1px;">
<b>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</b><br />
	KABUPATEN PROBOLINGGO
</td>
</tr>
<tr>
<td align="center" colspan="3" style="border-bottom: dashed 1px;">
DAFTAR USULAN PEMBERHENTIAN <br />
PERIODE <?=$title;?> 
</td>
</tr>
<tr>
<td colspan="3">
<table style="height: 55px;font-size:11px;font-family:Monospace" width="100%" border="1" cellpadding="0" cellspacing="0">
<tbody><thead>
<tr bgcolor="silver">
<td align="center">NO</td>
<td align="center">USULAN NO</td>
<td align="center">USULAN TGL</td>
<td align="center">GOLONGAN</td>
<td align="center">JENIS</td>
<td align="center">OPD</td>
<td align="center">NIP</td>
<td align="center">NAMA</td>
<td align="center">TMT PNS</td>
<td align="center">TMT PENSIUN</td>
<td align="center">STATUS</td>
</tr></thead>

<?php
$no=0;
$total =0;
//$total=$totalxs;

	foreach($rw as $row){
?>
<tr>
<td align="center"><?=$no+1;?></td>
<td><?=$row->usulan_nomor;?></td>
<td align="left"><?=SiteHelpers::datereport($row->usulan_tanggal);?></td>
<td align="left"><?=$row->golongan_pemberhentian_nama;?></td>
<td align="left"><?=$row->jenis_pemberhentian_nama;?></td>
<td align="left"><?=$row->satuan_kerja;?></td>
<td align="left"><?=$row->NIP_BARU;?></td>
<td align="left"><?=$row->NAMA_PEGAWAI;?></td>
<td align="left"><?=SiteHelpers::datereport($row->tmt_pns);?></td>
<td align="left"><?=SiteHelpers::datereport($row->tmt_pensiun);?></td>
<td align="left"><?=SiteHelpers::getStatusUsulanPegawai($row->usulan_status);?></td>
</tr>
<?php
}
?>
</tbody>
</table>
</td>
</tr>

</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</body>
<?php
       
   //echo $html;
?>