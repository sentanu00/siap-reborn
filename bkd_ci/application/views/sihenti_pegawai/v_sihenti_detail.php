<style>
    .detail-dt {
        font-weight: 600;
        color: #555;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">
        <i class="bi bi-folder2-open"></i> Detail Berkas Pemberhentian
    </h4>
    <a href="<?= site_url('sihenti_pegawai') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        Informasi Usulan
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3 detail-dt">NIP</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->nip) ?></dd>

            <dt class="col-sm-3 detail-dt">Nama</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->nama) ?></dd>

            <dt class="col-sm-3 detail-dt">Status Pegawai</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->status_pegawai ?: '-') ?></dd>

            <dt class="col-sm-3 detail-dt">Jenis Usulan</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->jenis_usulan) ?></dd>

            <dt class="col-sm-3 detail-dt">Tanggal Usul</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->tanggal_usul) ?></dd>

            <dt class="col-sm-3 detail-dt">Diusulkan Oleh</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->diusulkan_oleh) ?></dd>

            <dt class="col-sm-3 detail-dt">Status</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->status_usulan) ?></dd>

            <dt class="col-sm-3 detail-dt">Keterangan</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->keterangan ?: '-') ?></dd>
        </dl>
    </div>
</div>

<div class="alert alert-info mt-3">
    <i class="bi bi-info-circle"></i>
    Di halaman ini nanti akan ditampilkan form untuk melengkapi berkas
    sesuai jenis usulan: <b><?= htmlspecialchars($usulan->jenis_usulan) ?></b>.
</div>