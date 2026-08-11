<div class="page-content">

  <div class="row">

    <div class="col-md-12">

      <div class="alert alert-info">

        <h3 style="margin-top:0">
          <i class="fa fa-server"></i>
          Developer Dashboard
        </h3>

        Monitoring proses sinkronisasi antara
        <b>SIAP BKPSDM</b> dengan
        <b>SIASN BKN</b>.

      </div>

    </div>

  </div>

  <?php foreach ($monitoring as $item) { ?>

    <?php $this->load->view('devmod/monitoring_card', $item); ?>

  <?php } ?>

  <!-- TAMBAHKAN: Monitoring Rw Jabatan -->
  <?php foreach ($monitoringRwJabatan as $item) { ?>

    <?php $this->load->view('devmod/monitoring_card_jabatan', $item); ?>

  <?php } ?>

  <!-- TAMBAHKAN: Monitoring Rw Golongan -->
  <?php foreach ($monitoringRwGolongan as $item) { ?>

    <?php $this->load->view('devmod/monitoring_card_pangkat', $item); ?>

  <?php } ?>

  <!-- TAMBAHKAN: Monitoring Rw Pendidikan -->
  <?php foreach ($monitoringRwPendidikan as $item) { ?>

    <?php $this->load->view('devmod/monitoring_card_pendidikan', $item); ?>

  <?php } ?>


</div>