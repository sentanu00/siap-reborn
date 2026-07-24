<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">

            <!-- HEADER -->
            <div class="panel-heading" style="background-color: #f5f5f5; border-radius: 8px 8px 0 0;">
                <h4 style="margin:0; font-weight: 600;">
                    <i class="fa fa-database" style="color: #337ab7;"></i>
                    <?= $judul ?>
                    <!-- <span class="pull-right">
                        <span style="font-size: 22px; font-weight: 700; color: #28a745; background: #e8f5e9; padding: 6px 20px; border-radius: 30px; border: 2px solid #28a745; box-shadow: 0 2px 8px rgba(40,167,69,0.3); display: inline-block;">
                            <i class="fa fa-check-circle"></i> <? //= number_format($persen_sukses, 2) 
                                                                ?>% Sukses
                        </span>
                    </span> -->
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

                <!-- RINGKASAN CARD -->
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

                <!-- =========================================== -->
                <!-- ANOMALI - GRID (jika asosiatif) / TABEL     -->
                <!-- =========================================== -->
                <?php if (empty($anomali)): ?>
                    <div class="alert alert-success" style="border-radius: 6px; padding: 12px 18px;">
                        <i class="fa fa-check-circle"></i> Tidak ditemukan anomali.
                    </div>
                <?php else: ?>

                    <?php
                    // Deteksi apakah $anomali berupa array asosiatif (key string) atau numerik
                    $isAssoc = false;
                    if (is_array($anomali)) {
                        $keys = array_keys($anomali);
                        $isAssoc = !(isset($keys[0]) && is_numeric($keys[0]));
                    }
                    ?>

                    <?php if ($isAssoc): ?>
                        <!-- ================================== -->
                        <!-- TAMPILAN GRID PER KATEGORI        -->
                        <!-- ================================== -->
                        <div style="margin-bottom: 15px;">
                            <h4 style="margin: 0 0 10px;">
                                <i class="fa fa-exclamation-triangle text-danger"></i> Ringkasan Anomali per Kategori
                            </h4>
                        </div>

                        <div class="row">
                            <?php foreach ($anomali as $kategori => $items): ?>
                                <div class="col-md-6 col-lg-4" style="margin-bottom: 20px;">
                                    <div class="panel panel-default" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); height: 100%;">
                                        <div class="panel-heading" style="background-color: #f5f5f5; border-bottom: 2px solid #ddd;">
                                            <h5 style="margin:0; font-weight: 600; text-transform: capitalize;">
                                                <i class="fa fa-tag text-info"></i> Anomali <?= ucfirst($kategori) ?>
                                                <span class="pull-right">
                                                    <span class="badge" style="background-color: #d9534f;"><?= array_sum(array_column($items, 'jumlah')) ?></span>
                                                </span>
                                            </h5>
                                        </div>
                                        <div class="panel-body" style="padding: 10px 15px;">
                                            <?php if (empty($items)): ?>
                                                <p class="text-success" style="margin: 5px 0;">
                                                    <i class="fa fa-check-circle"></i> Tidak ada anomali
                                                </p>
                                            <?php else: ?>
                                                <ul class="list-unstyled" style="margin: 0;">
                                                    <?php foreach ($items as $item): ?>
                                                        <li style="padding: 6px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                                                            <span style="font-size: 13px;"><?= $item['nama'] ?></span>
                                                            <span class="label label-danger" style="border-radius: 12px; font-size: 12px;">
                                                                <?= number_format($item['jumlah']) ?>
                                                            </span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($items)): ?>
                                            <div class="panel-footer" style="background: #fff; border-top: 1px solid #e8e8e8; padding: 8px 15px; text-align: right;">
                                                <a href="<?= site_url('devmod/download_anomali_' . $kategori) ?>" class="btn btn-xs btn-success" style="border-radius: 15px;">
                                                    <i class="fa fa-download"></i> Download CSV
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Tombol download semua (opsional) -->
                        <div class="text-right" style="margin-top: 10px;">
                            <a href="<?= site_url('devmod/download_all_anomali') ?>" class="btn btn-sm btn-primary" style="border-radius: 20px;">
                                <i class="fa fa-file-archive-o"></i> Download Semua (CSV)
                            </a>
                        </div>

                    <?php else: ?>
                        <!-- ================================== -->
                        <!-- TAMPILAN TABEL (FALLBACK)          -->
                        <!-- ================================== -->
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

                        <?php if (empty($anomali)): ?>
                            <div class="text-right" style="margin-top: 15px;">
                                <a href="<?= site_url('devmod/download_detail_anomali') ?>" class="btn btn-sm btn-success" style="border-radius: 20px;">
                                    <i class="fa fa-download"></i> Download Detail (CSV)
                                </a>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>
                <?php endif; ?>

            </div> <!-- end panel-body -->
        </div> <!-- end panel -->
    </div> <!-- end col -->
</div> <!-- end row -->