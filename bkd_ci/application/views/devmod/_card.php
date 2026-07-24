<div class="panel panel-default">

    <div class="panel-heading">

        <strong>

            <i class="fa <?= $icon ?>"></i>

            <?= $judul ?>

        </strong>

        <span class="pull-right">

            <?= number_format($persen_sukses, 2) ?> %

        </span>

    </div>

    <div class="panel-body">

        <div class="progress">

            <div class="progress-bar progress-bar-success"

                style="width:<?= $persen_sukses ?>%"></div>

            <div class="progress-bar progress-bar-warning"

                style="width:<?= $persen_antrian ?>%"></div>

            <div class="progress-bar progress-bar-danger"

                style="width:<?= $persen_gagal ?>%"></div>

        </div>


        <div class="row text-center">

            <div class="col-md-3">

                <h4><?= number_format($total) ?></h4>

                <small>Total</small>

            </div>

            <div class="col-md-3">

                <h4 class="text-success">

                    <?= number_format($sukses) ?>

                </h4>

                <small>Sinkron</small>

            </div>

            <div class="col-md-3">

                <h4 class="text-warning">

                    <?= number_format($antrian) ?>

                </h4>

                <small>Antrian</small>

            </div>

            <div class="col-md-3">

                <h4 class="text-danger">

                    <?= number_format($gagal) ?>

                </h4>

                <small>Gagal</small>

            </div>

        </div>

        <?php if (!empty($anomali)) { ?>

            <hr>

            <table class="table table-condensed table-striped">

                <?php foreach ($anomali as $a) { ?>

                    <tr>

                        <td><?= $a['nama'] ?></td>

                        <td width="100" align="right">

                            <span class="label label-danger">

                                <?= $a['jumlah'] ?>

                            </span>

                        </td>

                    </tr>

                <?php } ?>

            </table>

        <?php } ?>

    </div>

</div>