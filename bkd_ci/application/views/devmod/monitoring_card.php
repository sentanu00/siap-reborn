<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">

            <!-- HEADER -->
            <div class="panel-heading" style="background-color: #f5f5f5; border-radius: 8px 8px 0 0;">
                <h4 style="margin:0; font-weight: 600;">
                    <i class="fa fa-database" style="color: #337ab7;"></i>
                    <?= $judul ?>
                </h4>

            </div>

            <div class="panel-body">

                <!-- PROGRESS BAR -->
                <div class="progress" style="height: 30px; border-radius: 20px; overflow: hidden; margin-bottom: 20px;">
                    <div class="progress-bar progress-bar-success" style="width: <?= $persen_sukses ?>%; line-height: 30px; font-size: 13px; font-weight: bold;">
                        <?= number_format($persen_sukses, 2) ?>%
                    </div>
                    <div class="progress-bar progress-bar-warning" style="width: <?= $persen_antrian ?>%; line-height: 30px; font-size: 13px; font-weight: bold;">
                        <?= number_format($persen_antrian, 2) ?>%
                    </div>
                    <div class="progress-bar progress-bar-danger" style="width: <?= $persen_gagal ?>%; line-height: 30px; font-size: 13px; font-weight: bold;">
                        <?= number_format($persen_gagal, 2) ?>%
                    </div>
                </div>

                <!-- RINGKASAN CARD (lebih responsif) -->
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-6 col-md-3">
                        <div class="well text-center" style="padding: 15px 10px; margin-bottom: 10px; background: #f9f9f9; border: 1px solid #e3e3e3; border-radius: 6px;">
                            <h3 style="margin: 0 0 5px; font-weight: 700; color: #333;"><?= number_format($total) ?></h3>
                            <small style="color: #777; text-transform: uppercase; letter-spacing: 0.5px;">Total Data</small>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="well text-center" style="padding: 15px 10px; margin-bottom: 10px; background: #f9f9f9; border: 1px solid #e3e3e3; border-radius: 6px;">
                            <h3 class="text-warning" style="margin: 0 0 5px; font-weight: 700;"><?= number_format($antrian) ?></h3>
                            <small style="color: #777; text-transform: uppercase; letter-spacing: 0.5px;">Dalam Antrian</small>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="well text-center" style="padding: 15px 10px; margin-bottom: 10px; background: #f9f9f9; border: 1px solid #e3e3e3; border-radius: 6px;">
                            <h3 class="text-success" style="margin: 0 0 5px; font-weight: 700;"><?= number_format($sukses) ?></h3>
                            <small style="color: #777; text-transform: uppercase; letter-spacing: 0.5px;">Sudah Sinkron</small>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="well text-center" style="padding: 15px 10px; margin-bottom: 10px; background: #f9f9f9; border: 1px solid #e3e3e3; border-radius: 6px;">
                            <h3 class="text-danger" style="margin: 0 0 5px; font-weight: 700;"><?= number_format($gagal) ?></h3>
                            <small style="color: #777; text-transform: uppercase; letter-spacing: 0.5px;">Gagal</small>
                        </div>
                    </div>
                </div>

                <hr style="border-top: 1px solid #e8e8e8;">

                <!-- ANOMALI -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0;">
                        <i class="fa fa-exclamation-triangle text-danger"></i> Ringkasan Anomali
                    </h4>
                    <?php if (!empty($anomali)): ?>
                        <a href="<?= site_url('devmod/download_detail_anomali') ?>" class="btn btn-sm btn-success" style="border-radius: 20px;">
                            <i class="fa fa-download"></i> Download Detail (CSV)
                        </a>
                    <?php endif; ?>
                </div>

                <?php if (empty($anomali)): ?>
                    <div class="alert alert-success" style="border-radius: 6px; padding: 12px 18px;">
                        <i class="fa fa-check-circle"></i> Tidak ditemukan anomali.
                    </div>
                <?php else: ?>
                    <div class="table-responsive" style="border: 1px solid #e8e8e8; border-radius: 6px; overflow-x: auto;">
                        <table class="table table-striped table-hover" style="margin-bottom: 0;">
                            <thead style="background-color: #f9f9f9; border-bottom: 2px solid #ddd;">
                                <tr>
                                    <th style="padding: 10px 12px;">Jenis Anomali</th>
                                    <th width="120" class="text-center" style="padding: 10px 12px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($anomali as $a): ?>
                                    <tr>
                                        <td style="padding: 8px 12px;"><?= $a['nama']; ?></td>
                                        <td class="text-center" style="padding: 8px 12px;">
                                            <span class="label label-danger" style="font-size: 13px; padding: 4px 12px; border-radius: 12px;">
                                                <?= number_format($a['jumlah']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- tombol download juga bisa di bawah jika ingin -->
                <?php endif; ?>

                <!-- (opsional) Tombol download jika tidak ada anomali, tidak perlu ditampilkan -->
                <?php if (empty($anomali)): ?>
                    <div class="text-right" style="margin-top: 15px;">
                        <a href="<?= site_url('devmod/download_detail_anomali') ?>" class="btn btn-sm btn-success" style="border-radius: 20px;">
                            <i class="fa fa-download"></i> Download Detail (CSV)
                        </a>
                    </div>
                <?php endif; ?>

            </div> <!-- end panel-body -->
        </div> <!-- end panel -->
    </div> <!-- end col -->
</div> <!-- end row -->