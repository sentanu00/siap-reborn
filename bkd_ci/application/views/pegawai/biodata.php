<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BIODATA<?php echo " " . $Nama . " - " . $NIP_BARU . " - " . date("YmdHis"); ?></title>
  <style>
    @media print {

      /* Atur margin dan skala untuk halaman pertama */
      @page :first {
        size: 215mm 330mm;
        margin: -30mm auto auto auto;
        /* Sesuaikan margin atas (10mm) sesuai kebutuhan */
      }

      /* Atur margin dan skala untuk halaman selanjutnya */
      @page {
        size: 215mm 330mm;
        margin: 10mm auto auto auto;
        /* Sesuaikan margin atas (10mm) sesuai kebutuhan */
      }

      /* Atur orientasi ke potrait */
      body {
        /* Sesuaikan skala sesuai dengan ukuran kertas */
        transform: scale(0.77);
        transform-origin: center center;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
      }
    }

    /* CSS untuk cetak di Mozilla Firefox */
    @-moz-document url-prefix() {

      /* Atur margin atas sesuai kebutuhan di Firefox */
      @page :first {
        size: 215mm 330mm;
        margin: -30mm auto auto auto;
        /* Sesuaikan margin atas (10mm) sesuai kebutuhan */
      }

      /* Atur margin dan skala untuk halaman selanjutnya */
      @page {
        size: 215mm 330mm;
        margin: 10mm auto auto auto;
        /* Sesuaikan margin atas (10mm) sesuai kebutuhan */
      }

      /* Atur orientasi ke potrait */
      body {
        /* Sesuaikan skala sesuai dengan ukuran kertas */
        transform: scale(0.77);
        transform-origin: center center;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
      }

      /* Atur tabel agar border tetap muncul di Firefox */
      table {
        border-collapse: separate !important;
      }
    }



    /* CSS untuk mengatur tampilan */
    body {

      /* width: 50%; */
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      /* align-items: center; */
    }



    body img {

      padding-bottom: 20px;
    }

    h1 {
      padding-bottom: 0px;
      /* Mengatur jarak dari bawah h1 ke h2 */
    }

    h2 {
      padding-top: 0px;
      /* Mengatur jarak dari atas h2 ke h1 */
    }

    .biodata {
      padding-top: 0px;
      /* Mengatur jarak dari atas h2 ke h1 */
      font-size: 30px;
      /* Ubah ukuran font sesuai keinginan Anda */
      background-color: #f0f0f0;
      /* Warna abu-abu (silakan ubah sesuai kebutuhan) */

    }


    h3 {
      padding-top: 20px;
      /* Mengatur jarak dari atas h2 ke h1 */
    }

    table {
      width: 220px;
      border-collapse: collapse;
      /* Menyatukan border sel dalam tabel */
    }

    .jarak {

      padding-bottom: 50px;
      border-top: 3px solid black;
      /* Misalnya, garis dengan ketebalan 1 piksel dan warna hitam */

    }

    .datadasar {

      font-family: Arial, sans-serif;
      text-align: left;
      padding-left: 50px;
    }

    td {
      max-width: 100px;
      /* Lebar maksimum sel */
      overflow: hidden;
      /* Potong teks yang melebihi lebar sel */
      white-space: normal;
      /* Hindari pemutaran teks */
    }

    .no_sk {
      word-wrap: break-word;
      /* Memungkinkan pematahan kata dan teks panjang */
      border: 1px solid black;
      /* Misalnya, border dengan ketebalan 1 piksel dan warna hitam */
    }

    .kolom_atas {
      background-color: #f0f0f0;
      /* Warna abu-abu (silakan ubah sesuai kebutuhan) */
      font-weight: bold;
      /* Membuat teks tebal */
      border: 1px solid black;
      /* Misalnya, border dengan ketebalan 1 piksel dan warna hitam */
    }

    .kolom_isi {
      border: 1px solid black;
      /* Misalnya, border dengan ketebalan 1 piksel dan warna hitam */
    }

    .foto {
      background-color: #f0f0f0;
      /* Warna abu-abu (silakan ubah sesuai kebutuhan) */
    }
  </style>
</head>

<body>
  <table border="0">
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <td colspan="4"><img src="<?= base_url('assets/icon/logo_pemda.svg') ?>" alt="Logo Daerah" width="150"></td>
      <td colspan="16">
        <h2>PEMERINTAH KABUPATEN PROBOLINGGO</h2>
        <h1>BADAN KEPEGAWAIAN DAN<br>PENGEMBANGAN SUMBER DAYA MANUSIA</h1>
        <p>Jl. Raya Panglima Sudirman No. 134 Kraksaan Telp. (0335) 8401552 dan 8401554 Fax (0335) 8401555<br>Website : www.bkpsdm.probolinggokab.go.id e-mail : bkpsdm@probolinggokab.go.id</p>
      </td>
    </tr>
    <tr>
      <td class="jarak" colspan="20"></td>
    </tr>
    <tr>
      <td colspan="20">
        <h2 class="biodata">BIODATA</h2>
      </td>
    </tr>
    <tr>
      <td colspan="20">
        <h3>I. KETERANGAN PERORANGAN</h3>
      </td>
    </tr>
    <tr>
      <td colspan="20">
        <img class="foto" src="<?= base_url("foto/" . $NIP_BARU . "/foto_setengah_" . $NIP_BARU . ".jpeg") ?>" alt="fotopegawai" width="180" height="220" id="fotoPegawai">
      </td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">Nip Baru</td>
      <td class="kolom_isi" colspan="5"><?php echo $NIP_BARU; ?></td>
      <td class="kolom_atas" colspan="4">Pangkat Terakhir</td>
      <td class="kolom_isi" colspan="5"><?php echo $Pangkat_Terakhir; ?></td>
      <td></td>
    </tr>

    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">Nama</td>
      <td class="kolom_isi" colspan="5"><?php
                                        $namax = $Nama;
                                        if ($GELAR_DEPAN != null) {
                                          $namax = $GELAR_DEPAN . " " . $namax;
                                        }
                                        if ($GELAR_BELAKANG != null) {
                                          $namax = $namax . " " . $GELAR_BELAKANG;
                                        }

                                        echo $namax; ?></td>
      <td class="kolom_atas" colspan="4">TMT Pangkat Terakhir</td>
      <td class="kolom_isi" colspan="5"><?php echo $TMT_Pangkat_Terakhir; ?></td>
      <td></td>
    </tr>

    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">Tempat Lahir</td>
      <td class="kolom_isi" colspan="5"><?php echo $Tempat_Lahir; ?></td>
      <td class="kolom_atas" colspan="4">Tingkat Pendidikan Terakhir</td>
      <td class="kolom_isi" colspan="5"><?php echo $Tingkat_Pendidikan; ?></td>
      <td></td>
    </tr>

    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">Tanggal Lahir</td>
      <td class="kolom_isi" colspan="5"><?php echo $Tanggal_Lahir; ?></td>
      <td class="kolom_atas" colspan="4">Jurusan</td>
      <td class="kolom_isi" colspan="5"><?php echo $Jurusan; ?></td>
      <td></td>
    </tr>

    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">Agama</td>
      <td class="kolom_isi" colspan="5"><?php echo $Agama; ?></td>
      <td class="kolom_atas" colspan="4">Sekolah</td>
      <td class="kolom_isi" colspan="5"><?php echo $Sekolah; ?></td>
      <td></td>
    </tr>

    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">Alamat</td>
      <td class="kolom_isi" colspan="5"><?php echo $Alamat; ?></td>
      <td class="kolom_atas" colspan="4">Tahun Lulus</td>
      <td class="kolom_isi" colspan="5"><?php echo $Tahun_Lulus; ?></td>
      <td></td>
    </tr>

    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">TMT Pensiun</td>
      <td class="kolom_isi" colspan="5"><?php echo $tmt_pensiun; ?></td>
      <td class="kolom_atas" colspan="4">Jabatan Terakhir</td>
      <td class="kolom_isi" colspan="5"><?php echo $Jabatan_Terakhir; ?></td>
      <td></td>
    </tr>

    <!-- riwayat pangkat -->
    <tr>
      <td colspan="20">
        <h3>II. Riwayat Kepangkatan</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="2">Gol Ruang</td>
      <td class="kolom_atas" colspan="3">TMT</td>
      <td class="kolom_atas" colspan="5">Nomor SK</td>
      <td class="kolom_atas" colspan="3">Tanggal SK</td>
      <td class="kolom_atas" colspan="4">Pejabat Yang Menetapkan</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($RPangkat as $x) {
      // $diklat = $this->model->getdiklat($peg->PEGAWAI_ID);
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['gol_ruang']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['TMT_PANGKAT']; ?></td>
        <td class="no_sk" colspan="5"><?php echo $x['NO_SK']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['TANGGAL_SK']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['PEJABAT_PENETAP']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- III. Riwayat Jabatan Struktural / Fungsional -->
    <tr>
      <td colspan="20">
        <h3>III. Riwayat Jabatan Struktural / Fungsional</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="5">Jabatan</td>
      <td class="kolom_atas" colspan="2">TMT</td>
      <td class="kolom_atas" colspan="4">Nomor SK</td>
      <td class="kolom_atas" colspan="2">Tanggal SK</td>
      <td class="kolom_atas" colspan="4">Pejabat Yang Menetapkan</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($RJabatan as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="5"><?php echo $x['NAMA']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TMT_JABATAN']; ?></td>
        <td class="no_sk" colspan="4"><?php echo $x['NO_SK']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_SK']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['PEJABAT_PENETAP']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- IV. Riwayat Pendidikan -->
    <tr>
      <td colspan="20">
        <h3>IV. Riwayat Pendidikan</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="4">Jenjang Jurusan</td>
      <td class="kolom_atas" colspan="4">Nama Sekolah</td>
      <td class="kolom_atas" colspan="4">Kepala Sekolah / Dekan</td>
      <td class="kolom_atas" colspan="3">No Ijazah</td>
      <td class="kolom_atas" colspan="2">Tanggal Ijazah</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($RPendidikan as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['jurusan']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['TEMPAT']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['KEPALA']; ?></td>
        <td class="no_sk" colspan="3"><?php echo $x['NO_STTB']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_STTB']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- V. Riwayat Diklat Struktural -->
    <tr>
      <td colspan="20">
        <h3>V. Riwayat Diklat Struktural</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas" class="kolom_isi">No. </td>
      <td class="kolom_atas" colspan="6">Nama Diklat</td>
      <td class="kolom_atas" colspan="4">Tempat / Penyelenggara</td>
      <td class="kolom_atas" colspan="2">Angkatan / Tanggal Diklat</td>
      <td class="kolom_atas" colspan="3">No Sttpp</td>
      <td class="kolom_atas" colspan="2">Tanggal Sttpp</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rdikstruk as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="6"><?php echo $x['NAMA_DIKLAT']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['TEMPAT']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['ANGKATAN']; ?></td>
        <td class="no_sk" colspan="3"><?php echo $x['NO_STTPP']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_STTPP']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- VI. Riwayat Diklat Fungsional -->
    <tr>
      <td colspan="20">
        <h3>VI. Riwayat Diklat Fungsional</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="6">Nama Diklat</td>
      <td class="kolom_atas" colspan="4">Tempat / Penyelenggara</td>
      <td class="kolom_atas" colspan="2">Angkatan / Tanggal Diklat</td>
      <td class="kolom_atas" colspan="3">No Sttpp</td>
      <td class="kolom_atas" colspan="2">Tanggal Sttpp</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rdikfung as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="6"><?php echo $x['NAMA']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['TEMPAT']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['ANGKATAN']; ?></td>
        <td class="no_sk" colspan="3"><?php echo $x['NO_STTPP']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_STTPP']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- VII. Riwayat Diklat Teknis -->
    <tr>
      <td colspan="20">
        <h3>VII. Riwayat Diklat Teknis</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="6">Nama Diklat</td>
      <td class="kolom_atas" colspan="4">Tempat / Penyelenggara</td>
      <td class="kolom_atas" colspan="2">Angkatan / Tanggal Diklat</td>
      <td class="kolom_atas" colspan="3">No Piagam</td>
      <td class="kolom_atas" colspan="2">Tanggal Piagam</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rdiktek as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="6"><?php echo $x['NAMA']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['TEMPAT']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['ANGKATAN']; ?></td>
        <td class="no_sk" colspan="3"><?php echo $x['NO_STTPP']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_STTPP']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>

    <!-- VIII. Penataran -->
    <tr>
      <td colspan="20">
        <h3>VIII. Penataran</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="6">Nama Diklat</td>
      <td class="kolom_atas" colspan="4">Tempat / Penyelenggara</td>
      <td class="kolom_atas" colspan="2">Angkatan / Tanggal Diklat</td>
      <td class="kolom_atas" colspan="3">No Piagam</td>
      <td class="kolom_atas" colspan="2">Tanggal Piagam</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rpenataran as $x) {
    ?>
      <tr>
        <td></td>
        <<td class="kolom_atas"><?php echo $i++; ?></td>
          <td class="kolom_isi" colspan="6"><?php echo $x['NAMA']; ?></td>
          <td class="kolom_isi" colspan="4"><?php echo $x['TEMPAT']; ?></td>
          <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_SELESAI']; ?></td>
          <td class="no_sk" colspan="3"><?php echo $x['NO_PIAGAM']; ?></td>
          <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_PIAGAM']; ?></td>
          <td></td>
      </tr>
    <?
    }
    ?>
    <!-- IX. Seminar/Lokakarya/Simposium -->
    <tr>
      <td colspan="20">
        <h3>IX. Seminar/Lokakarya/Simposium</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="6">Nama Diklat</td>
      <td class="kolom_atas" colspan="4">Tempat / Penyelenggara</td>
      <td class="kolom_atas" colspan="2">Angkatan / Tanggal Diklat</td>
      <td class="kolom_atas" colspan="3">No Piagam</td>
      <td class="kolom_atas" colspan="2">Tanggal Piagam</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rseminar as $x) {
    ?>
      <tr>
        <td></td>
        <<td class="kolom_atas"><?php echo $i++; ?></td>
          <td class="kolom_isi" colspan="6"><?php echo $x['NAMA']; ?></td>
          <td class="kolom_isi" colspan="4"><?php echo $x['TEMPAT']; ?></td>
          <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_SELESAI']; ?></td>
          <td class="no_sk" colspan="3"><?php echo $x['NO_PIAGAM']; ?></td>
          <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_PIAGAM']; ?></td>
          <td></td>
      </tr>
    <?
    }
    ?>
    <!-- X. Riwayat Keluarga -->
    <tr>
      <td colspan="20">
        <h3>X. Riwayat Keluarga</h3>
      </td>
    </tr>

    <tr>
      <td></td>
      <td class="kolom_atas" colspan="4"></td>
      <td class="kolom_atas" colspan="7">Ayah</td>
      <td class="kolom_atas" colspan="7">Ibu</td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">1. Nama</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['NAMA']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['NAMA']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">2. Tempat Lahir</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['TEMPAT_LAHIR']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['TEMPAT_LAHIR']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">3. Pekerjaan</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['PEKERJAAN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['PEKERJAAN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">4. Alamat</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['ALAMAT']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['ALAMAT']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;a. Telepon</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['TELEPON']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['TELEPON']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;b. Provinsi</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['PROVINSI']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['PROVINSI']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;c. kota / Kabupaten</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['KABUPATEN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['KABUPATEN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;d. Kecamatan</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['KECAMATAN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['KECAMATAN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;e. kelurahan / Desa</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['KELURAHAN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['KELURAHAN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;f. Kode Pos</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[0]['KODE_POS']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rorangtua[1]['KODE_POS']; ?></td>
      <td></td>
    </tr>


    <!-- X. Riwayat Mertua -->
    <tr>
      <td colspan="20">
        <h3></h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas" colspan="4"></td>
      <td class="kolom_atas" colspan="7">Ayah Mertua</td>
      <td class="kolom_atas" colspan="7">Ibu Mertua</td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">1. Nama</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['NAMA']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['NAMA']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">2. Tempat Lahir</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['TEMPAT_LAHIR']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['TEMPAT_LAHIR']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">3. Pekerjaan</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['PEKERJAAN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['PEKERJAAN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">4. Alamat</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['ALAMAT']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['ALAMAT']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;a. Telepon</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['TELEPON']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['TELEPON']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;b. Provinsi</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['PROVINSI']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['PROVINSI']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;c. kota / Kabupaten</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['KABUPATEN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['KABUPATEN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;d. Kecamatan</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['KECAMATAN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['KECAMATAN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;e. kelurahan / Desa</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['KELURAHAN']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['KELURAHAN']; ?></td>
      <td></td>
    </tr>
    <tr class="datadasar">
      <td></td>
      <td class="kolom_atas" colspan="4">&#160;&#160;&#160;&#160;f. Kode Pos</td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[0]['KODEPOS']; ?></td>
      <td class="kolom_isi" colspan="7"><?php echo $Rmertua[1]['KODEPOS']; ?></td>
      <td></td>
    </tr>
    <!-- XI. Data Suami / Istri -->
    <tr>
      <td colspan="20">
        <h3>XI. Data Suami / Istri</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="4">Nama Suami / Istri</td>
      <td class="kolom_atas" colspan="3">Tempat dan Tanggal Lahir</td>
      <td class="kolom_atas" colspan="3">Pendidikan</td>
      <td class="kolom_atas" colspan="2">Tanggal Kawin</td>
      <td class="kolom_atas" colspan="2">Tunjangan</td>
      <td class="kolom_atas" colspan="3">Pekerjaan</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rpasangan as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['NAMA']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['TTL']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['PENDIDIKAN']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_KAWIN']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['STATUS_TUNJANGAN']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['PEKERJAAN']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>

    <!-- XII. Data Anak -->
    <tr>
      <td colspan="20">
        <h3>XII. Data Anak</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="4">Nama Anak</td>
      <td class="kolom_atas" colspan="3">Tempat dan Tanggal Lahir</td>
      <td class="kolom_atas" colspan="1">L/P</td>
      <td class="kolom_atas" colspan="2">Keluarga</td>
      <td class="kolom_atas" colspan="2">Tunjangan</td>
      <td class="kolom_atas" colspan="2">Pendidikan</td>
      <td class="kolom_atas" colspan="3">Pekerjaan</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Ranak as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['NAMA']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['TTL']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['JENIS_KELAMIN']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['STATUS_KELUARGA']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['STATUS_TUNJANGAN']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['PENDIDIKAN']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['PEKERJAAN']; ?></td>
        <td></td>
      </tr>

    <?
    }
    ?>

    <!-- XIII. Riwayat Keanggotaan Organisasi -->
    <tr>
      <td colspan="20">
        <h3>XIII. Riwayat Keanggotaan Organisasi</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="4">Nama Organisasi</td>
      <td class="kolom_atas" colspan="4">Jabatan</td>
      <td class="kolom_atas" colspan="2">Lama Menjabat</td>
      <td class="kolom_atas" colspan="4">Nama Pimpinan</td>
      <td class="kolom_atas" colspan="3">Tempat</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rorganisasi as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['NAMA']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['JABATAN']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['selisih_tanggal']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['PIMPINAN']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['TEMPAT']; ?></td>
        <td></td>
      </tr>

    <?
    }
    ?>
    <!-- XIV. Riwayat Penghargaan -->
    <tr>
      <td colspan="20">
        <h3>XIV. Riwayat Penghargaan</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="5">Nama Penghargaan</td>
      <td class="kolom_atas" class="no_sk" colspan="4">No SK</td>
      <td class="kolom_atas" colspan="2">Tanggal SK</td>
      <td class="kolom_atas" colspan="4">Nama Pimpinan</td>
      <td class="kolom_atas" colspan="2">Tahun</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rpenghargaan as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="5"><?php echo $x['NAMA']; ?></td>
        <td class="no_sk" colspan="4"><?php echo $x['NO_SK']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_SK']; ?></td>
        <td class="kolom_isi" colspan="4"><?php echo $x['PIMPINAN']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TAHUN']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- XV. Riwayat Daftar Penilaian Pelaksanaan Pekerjaan -->
    <tr>
      <td colspan="20">
        <h3>XV. Riwayat Daftar Penilaian Pelaksanaan Pekerjaan</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="3">Tahun</td>
      <td class="kolom_atas" colspan="1">N1</td>
      <td class="kolom_atas" colspan="1">N2</td>
      <td class="kolom_atas" colspan="1">N3</td>
      <td class="kolom_atas" colspan="1">N4</td>
      <td class="kolom_atas" colspan="1">N5</td>
      <td class="kolom_atas" colspan="1">N6</td>
      <td class="kolom_atas" colspan="1">N7</td>
      <td class="kolom_atas" colspan="1">N8</td>
      <td class="kolom_atas" colspan="3">Jumlah</td>
      <td class="kolom_atas" colspan="3">Rata-Rata</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rskplama as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['TAHUN']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N1']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N2']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N3']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N4']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N5']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N6']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N7']; ?></td>
        <td class="kolom_isi" colspan="1"><?php echo $x['N8']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['JUMLAH']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['RATARATA']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <tr>
      <td colspan="20"><br></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td colspan="2">Keterangan</td>
      <td colspan="15"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N1</td>
      <td> : </td>
      <td colspan="2">Kesetiaan</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N2</td>
      <td> : </td>
      <td colspan="2">Prestasi Kerja</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N3</td>
      <td> : </td>
      <td colspan="2">Tanggung Jawab</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N4</td>
      <td> : </td>
      <td colspan="2">Ketaatan</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N5</td>
      <td> : </td>
      <td colspan="2">Kejujuran</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N6</td>
      <td> : </td>
      <td colspan="2">Kerjasama</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N7</td>
      <td> : </td>
      <td colspan="2">Prakarsa</td>
      <td colspan="13"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>N8</td>
      <td> : </td>
      <td colspan="2">Kepemimpinan</td>
      <td colspan="13"></td>
    </tr>

    <!-- XVI. Riwayat Hukuman Disiplin Pegawai -->
    <tr>
      <td colspan="20">
        <h3>XVI. Riwayat Hukuman Disiplin Pegawai</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="3">Jenis Pelanggaran</td>
      <td class="kolom_atas" colspan="5">Detail Pelanggaran</td>
      <td class="kolom_atas" colspan="4">No SK</td>
      <td class="kolom_atas" colspan="2">Tanggal SK</td>
      <td class="kolom_atas" colspan="3">Pejabat yang Menetapkan</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->

    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rhukdis as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['JENIS_PELANGGARAN']; ?></td>
        <td class="kolom_isi" colspan="5"><?php echo $x['DETAIL_PELANGGARAN']; ?></td>
        <td class="no_sk" colspan="4"><?php echo $x['NO_SK']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_SK']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['PEJABAT_PENETAP']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- XVII. Riwayat Cuti -->
    <tr>
      <td colspan="20">
        <h3>XVII. Riwayat Cuti</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="2">Tahun</td>
      <td class="kolom_atas" colspan="3">Jenis Cuti</td>
      <td class="kolom_atas" colspan="3">No Surat</td>
      <td class="kolom_atas" colspan="2">Tanggal Surat</td>
      <td class="kolom_atas" colspan="2">Awal cuti</td>
      <td class="kolom_atas" colspan="2">Akhir cuti</td>
      <td class="kolom_atas" colspan="3">Keterangan</td>
      <td></td>
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->

    <?php
    // var_dump($RPangkat);
    $i = 1;
    foreach ($Rcuti as $x) {
    ?>
      <tr>
        <td></td>
        <td class="kolom_isi"><?php echo $i++; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TAHUN']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['JENIS_CUTI']; ?></td>
        <td class="no_sk" colspan="3"><?php echo $x['NO_SURAT']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['TANGGAL_SURAT']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['AWAL_CUTI']; ?></td>
        <td class="kolom_isi" colspan="2"><?php echo $x['AKHIR_CUTI']; ?></td>
        <td class="kolom_isi" colspan="3"><?php echo $x['KETERANGAN']; ?></td>
        <td></td>
      </tr>
    <?
    }
    ?>
    <!-- XVIII. Riwayat Penugasan Luar Negeri -->
    <!-- <tr>
      <td colspan="20">
        <h3>XVIII. Riwayat Penugasan Luar Negeri</h3>
      </td>
    </tr>
    <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="4">Nama Negara</td>
      <td class="kolom_atas" colspan="4">Jenis Penugasan</td>
      <td class="kolom_atas" colspan="5">Keterangan</td>
      <td class="kolom_atas" colspan="2">Lama Tugas</td>
      <td class="kolom_atas" colspan="2">Tahun</td>
      <td></td>
    </tr> -->
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <!-- <tr>
      <td></td>
      <td class="kolom_isi">1 </td>
      <td class="kolom_isi" colspan="4">Jerman</td>
      <td class="kolom_isi" colspan="4">Rahasia</td>
      <td class="kolom_isi" colspan="5">Menyelamatkan Dunia</td>
      <td class="kolom_isi" colspan="2">3 Bulan</td>
      <td class="kolom_isi" colspan="2">2030</td>
      <td></td>
    </tr> -->

    <!-- XIX. Riwayat Penguasaan Bahasa -->
    <!-- <tr>
      <td colspan="20">
        <h3>XIX. Riwayat Penguasaan Bahasa</h3>
      </td>
    </tr> -->
    <!-- <tr>
      <td></td>
      <td class="kolom_atas">No. </td>
      <td class="kolom_atas" colspan="4">Jenis Bahasa</td>
      <td class="kolom_atas" colspan="8">Nama Bahasa</td>
      <td class="kolom_atas" colspan="5">Kemampuan Bicara</td>
      <td></td> -->
    </tr>
    <!-- loopig data riwayat pangkat dari awal sampai akhir -->
    <!-- <tr>
      <td></td>
      <td class="kolom_isi">1 </td>
      <td class="kolom_isi" colspan="4">Daerah</td>
      <td class="kolom_isi" colspan="8">Jawa</td>
      <td class="kolom_isi" colspan="5">Aktif</td>
      <td></td>
    </tr> -->

    <!-- Anda dapat menambahkan baris data lainnya di sini -->
    <tr>
      <td colspan="20"><br><br></td>
    </tr>
    <tr style="opacity: 0;">
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
      <td>xxxxxx</td>
    </tr>
  </table>
</body>

<?php
// Ambil data NIP_BARU dari PHP
// $NIP_BARU = "196410141991021003"; // Gantilah dengan nilai sesuai kebutuhan

// Buat skrip JavaScript untuk mengatur URL gambar
echo '<script>';
echo 'var urlFoto = "https://siap-bkpsdm.probolinggokab.go.id/main/foto/' . $NIP_BARU . '/foto_setengah_' . $NIP_BARU . '.jpeg";';
echo '</script>';
?>
<script>
  var fotoPegawai = document.getElementById('fotoPegawai');
  var urlFoto = "https://siap-bkpsdm.probolinggokab.go.id/foto/" + $NIP_BARU + "/foto_setengah_" + $NIP_BARU + ".jpeg";
  // var urlFoto = "https://siap-bkpsdm.probolinggokab.go.id/foto/" . $NIP_BARU . "/foto_setengah_" . $NIP_BARU . ".jpeg";

  // Cek apakah gambar tersedia atau tidak
  var img = new Image();
  img.onload = function() {
    // Gambar tersedia, atur src ke URL gambar
    fotoPegawai.src = urlFoto;
  };
  img.onerror = function() {
    // Gambar tidak tersedia, atur src ke gambar default
    fotoPegawai.src = '<?= base_url('assets/icon/blank_profil.png') ?>';
  };
  img.src = urlFoto;
</script>

</html>
<script type="text/javascript">
  window.print();
  //setTimeout(window.close(), 10000)
</script>