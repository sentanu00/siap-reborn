<?
/*
<div class="pcoded-navbar" style="overflow: auto;">

 <div class="box box-primary">
  <div class="box-body box-profile text-center"> 

    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>/loading.gif" alt="User profile picture">
    <h5 class="profile-username text-center" style="font-size: 13px"><?php echo $row['GELAR_DEPAN'];?> <?php echo $row['NAMA'];?> <?php echo $row['GELAR_BELAKANG'];?></h5>
    <p class="text-muted text-center"><?
    if($row['NAMA'] != ''){
      ?>
      <a href="javascript:changepages('datadfs')" class="btn btn-danger">
        <i class="fa fa-file"></i>  Digital File
      </a>
      <?
    }
    ?></p>
  </div>
</div>

 <div class="box box-danger">
  <div class="box-body "> 

    <ul class="sidebar-menu tree" style="font-size: 13px">
      <li class="treeview"><a href="javascript:changepages('pegawai/identitas')">
      <span>Identitas Pegawai</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>
    <li class="treeview"><a href="javascript:changepages('pegawai/skcpns')">
      <span>SK CPNS</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>
    <li class="treeview"><a href="javascript:changepages('pegawai/skpns')">
      <span>SK PNS</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>
    <li class="treeview"><a href="javascript:changepages('pengalamankerja')">
      <span>Pengalaman Kerja</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>
  </ul>
</div>
</div>

              <div class="box box-danger">
  <div class="box-body " > 

    <ul class="sidebar-menu tree">
      
    
    <li class="treeview"><a href="javascript:changepages('riwayatpangkat')">
      <span>Riwayat Pangkat</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>
    <li class="treeview"><a href="#">
      <span>Riwayat Mutasi</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('riwayatgaji')">
      <span>Riwayat Gaji</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="#">
      <span>Pendidikan Umum</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('diklatstruktural')">
      <span>Diklat Struktural</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('diklatfungsional')">
      <span>Diklat Fungsional</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('diklatteknis')">
      <span>Diklat Teknis</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>
    <li class="treeview"><a href="javascript:changepages('penataran')">
      <span>Penataran</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('seminar')">
      <span>Seminar</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('workshop')">
      <span>Lokakarya / Workshop</span>
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

    <li class="treeview"><a href="javascript:changepages('penghargaan')">
      <span>Penghargaan</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('penilaiandptiga')">
      <span>Penilaian DP-3</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('penilaianasn')">
      <span>Penilaian Prestasi Kerja ASN</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

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

    <li class="treeview"><a href="javascript:changepages('nikah')">
      <span>Nikah</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    <li class="treeview"><a href="javascript:changepages('tambahanmk/add')">
      <span>Tambahan Masa Kerja</span>
      <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
    </a></li>

    </ul>
    </div>
  </div>



</div>
*/
?>

