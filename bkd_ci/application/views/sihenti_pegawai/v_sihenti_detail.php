<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .card-custom {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .card-custom .card-header {
        font-weight: 600;
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
        padding: 0.8rem 1.25rem;
    }

    .detail-dt {
        font-weight: 600;
        color: #4a5568;
    }

    .doc-title {
        font-size: 0.925rem;
        font-weight: 600;
        color: #2d3748;
        line-height: 1.4;
        display: block;
        margin-bottom: 3px;
    }

    .doc-format {
        font-size: 0.775rem;
        color: #718096;
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        background: #f7fafc;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }

    .badge-origin {
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 500;
    }

    .badge-system {
        background-color: #ebf8ff;
        color: #2b6cb0;
        border: 1px solid #bee3f8;
    }

    .badge-manual-tag {
        background-color: #f7fafc;
        color: #4a5568;
        border: 1px solid #e2e8f0;
    }

    .table-berkas tbody tr:hover {
        background-color: #f8fafc;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold text-dark">
        <i class="bi bi-folder2-open text-primary me-1"></i> Detail Berkas Pemberhentian
    </h4>
    <a href="<?= site_url('sihenti_pegawai') ?>" class="btn btn-outline-secondary btn-sm rounded-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- ==================================================== -->
<!-- INFORMASI USULAN                                      -->
<!-- ==================================================== -->
<div class="card card-custom mb-3">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="bi bi-person-vcard me-2"></i> Informasi Usulan
    </div>
    <div class="card-body">
        <dl class="row mb-0 gy-2">
            <dt class="col-sm-3 detail-dt">NIP</dt>
            <dd class="col-sm-9 font-monospace text-dark fw-bold"><?= htmlspecialchars($usulan->nip) ?></dd>

            <dt class="col-sm-3 detail-dt">Nama Pegawai</dt>
            <dd class="col-sm-9 text-dark fw-semibold"><?= htmlspecialchars($usulan->nama) ?></dd>

            <dt class="col-sm-3 detail-dt">Status Pegawai</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->status_pegawai ?: '-') ?></dd>

            <dt class="col-sm-3 detail-dt">Jenis Usulan</dt>
            <dd class="col-sm-9"><span class="badge bg-light text-dark border"><?= htmlspecialchars($usulan->jenis_usulan) ?></span></dd>

            <dt class="col-sm-3 detail-dt">Tanggal Usul</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->tanggal_usul) ?></dd>

            <dt class="col-sm-3 detail-dt">Diusulkan Oleh</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->diusulkan_oleh) ?></dd>

            <dt class="col-sm-3 detail-dt">Status Usulan</dt>
            <dd class="col-sm-9">
                <?php
                $status_map = array(
                    'Draft'      => array('bg' => 'bg-secondary', 'text' => 'text-white', 'icon' => 'bi-file-earmark-text'),
                    'Input Data' => array('bg' => 'bg-info',      'text' => 'text-dark',  'icon' => 'bi-pencil-square'),
                    'Diajukan'   => array('bg' => 'bg-primary',   'text' => 'text-white', 'icon' => 'bi-send'),
                    'Diproses'   => array('bg' => 'bg-warning',   'text' => 'text-dark',  'icon' => 'bi-gear-wide-connected'),
                    'Disetujui'  => array('bg' => 'bg-success',   'text' => 'text-white', 'icon' => 'bi-check-circle'),
                    'Ditolak'    => array('bg' => 'bg-danger',    'text' => 'text-white', 'icon' => 'bi-x-circle'),
                    'Selesai'    => array('bg' => 'bg-dark',      'text' => 'text-white', 'icon' => 'bi-flag'),
                );
                $st = $usulan->status_usulan;
                $badge_cfg = isset($status_map[$st]) ? $status_map[$st] : array('bg' => 'bg-secondary', 'text' => 'text-white', 'icon' => 'bi-info-circle');
                ?>
                <span class="badge <?= $badge_cfg['bg'] ?> <?= $badge_cfg['text'] ?> px-2 py-1">
                    <i class="bi <?= $badge_cfg['icon'] ?> me-1"></i><?= htmlspecialchars($usulan->status_usulan) ?>
                </span>
            </dd>

            <dt class="col-sm-3 detail-dt">Keterangan</dt>
            <dd class="col-sm-9 text-muted mb-0"><?= htmlspecialchars($usulan->keterangan ?: '-') ?></dd>
        </dl>
    </div>
</div>

<!-- ==================================================== -->
<!-- FORM PILIH DETAIL PEMBERHENTIAN                       -->
<!-- ==================================================== -->
<div class="card card-custom mb-3">
    <div class="card-header bg-secondary text-white d-flex align-items-center">
        <i class="bi bi-list-check me-2"></i> Detail Pemberhentian
    </div>
    <div class="card-body">
        <?php if (empty($jenis)): ?>
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Jenis pemberhentian <b>"<?= htmlspecialchars($usulan->jenis_usulan) ?>"</b>
                tidak ditemukan di master data. Hubungi administrator.
            </div>
        <?php elseif (empty($detail_list)): ?>
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Belum ada daftar detail pemberhentian untuk jenis ini.
            </div>
        <?php else: ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label detail-dt mb-1">Jenis Pemberhentian</label>
                    <input type="text" class="form-control bg-light" readonly
                        value="<?= htmlspecialchars($jenis->jenis) ?>">
                    <small class="text-muted mt-1 d-block">
                        Status Pegawai: <b class="text-dark"><?= htmlspecialchars($jenis->status_pegawai) ?></b>
                    </small>
                </div>

                <div class="col-md-6">
                    <label class="form-label detail-dt mb-1" for="select-detail">
                        Detail Pemberhentian <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="select-detail">
                        <option value="">— Pilih detail pemberhentian —</option>
                        <?php foreach ($detail_list as $d): ?>
                            <option value="<?= (int) $d->id ?>"
                                <?= (!empty($usulan->id_detail_pemberhentian) && (int) $usulan->id_detail_pemberhentian === (int) $d->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d->detail_pemberhentian) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted mt-1 d-block">
                        Pilih salah satu alasan detail sesuai dasar pemberhentian.
                    </small>
                </div>
            </div>

            <hr class="my-3">

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary btn-sm px-3" id="btn-simpan-detail"
                    data-id-usulan="<?= (int) $usulan->id ?>">
                    <i class="bi bi-save me-1"></i> Simpan Detail
                </button>
                <?php if (!in_array($usulan->status_usulan, ['Diajukan', 'Disetujui', 'Selesai'])): ?>
                    <button type="button" class="btn btn-success btn-sm px-3" id="btn-ajukan"
                        data-id-usulan="<?= (int) $usulan->id ?>">
                        <i class="bi bi-send me-1"></i> Ajukan Usulan
                    </button>
                <?php endif; ?>

                <!-- TOMBOL VALIDASI KHUSUS VALIDATOR -->
                <?php if ($this->session->userdata('gid') == 1 || $this->session->userdata('gid') == 20): ?>
                    <button type="button" class="btn btn-warning btn-sm px-3" id="btn-validasi-modal"
                        data-id-usulan="<?= (int) $usulan->id ?>"
                        data-status="<?= htmlspecialchars($usulan->status_usulan, ENT_QUOTES, 'UTF-8') ?>"
                        data-keterangan="<?= htmlspecialchars($usulan->keterangan ?: '', ENT_QUOTES, 'UTF-8') ?>">
                        <i class="bi bi-check-circle me-1"></i> Validasi
                    </button>
                <?php endif; ?>
            </div>
    </div>
<?php endif; ?>
</div>
</div>

<!-- ==================================================== -->
<!-- CARD: BERKAS PERSYARATAN                              -->
<!-- ==================================================== -->
<div class="card card-custom mb-4">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <span class="fw-bold" style="color: #000;"><i class="bi bi-paperclip me-1"></i> Berkas Persyaratan Usulan</span>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-dark px-2 py-1" id="badge-berkas">
                <?php
                $total   = count($berkas_list);
                $lengkap = 0;
                foreach ($berkas_list as $b) if ($b['ada_file']) $lengkap++;
                echo "Kelengkapan: " . $lengkap . ' / ' . $total;
                ?>
            </span>
            <?php if ($lengkap > 0): ?>
                <a href="<?= site_url('sihenti_pegawai/download_semua_berkas/' . (int) $usulan->id) ?>"
                    id="btn-download-semua"
                    class="btn btn-sm btn-dark"
                    title="Unduh semua berkas dalam file ZIP">
                    <i class="bi bi-file-earmark-zip me-1"></i> Download Semua
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-berkas align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:45px;" class="text-center">#</th>
                        <th>Nama Berkas Dokumen</th>
                        <th style="width:100px;" class="text-center">Sifat</th>
                        <th style="width:140px;" class="text-center">Status File</th>
                        <th style="width:240px;" class="text-center">Aksi / Opsi Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($berkas_list as $b):
                        $is_manual = !empty($b['is_manual']);
                    ?>
                        <tr>
                            <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                            <td class="py-2">
                                <div class="d-flex align-items-center mb-1 gap-2">
                                    <span class="doc-title mb-0"><?= htmlspecialchars($b['label']) ?></span>
                                    <?php if ($is_manual): ?>
                                        <span class="badge badge-origin badge-manual-tag" title="Diunggah secara manual"><i class="bi bi-upload me-1"></i>Manual</span>
                                    <?php else: ?>
                                        <span class="badge badge-origin badge-system" title="Data Otomatis Sistem SIAP"><i class="bi bi-database me-1"></i>Sistem SIAP</span>
                                    <?php endif; ?>
                                </div>
                                <div class="doc-format">
                                    <i class="bi bi-file-earmark-code me-1"></i><?= htmlspecialchars($b['format_nama_file']) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php if ($b['wajib']): ?>
                                    <span class="badge bg-danger px-2">Wajib</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-2">Opsional</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($is_manual): ?>
                                    <?php if ($b['ada_file']): ?>
                                        <span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Sudah upload</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-exclamation-circle me-1"></i>Belum upload</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if (!$b['ada_record']): ?>
                                        <span class="badge bg-dark px-2 py-1"><i class="bi bi-x-circle me-1"></i>Data tidak ada</span>
                                    <?php elseif (!$b['ada_file']): ?>
                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-exclamation-circle me-1"></i>Belum upload</span>
                                    <?php else: ?>
                                        <span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Tersedia</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center py-2">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <!-- Tombol Lihat / Preview -->
                                    <?php if ($b['ada_file'] && !empty($b['link_file'])): ?>
                                        <?php if (isset($b['tipe_file']) && $b['tipe_file'] === 'image'): ?>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-success btn-preview-gambar"
                                                data-file-url="<?= htmlspecialchars($b['link_file'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-file-title="<?= htmlspecialchars($b['label'], ENT_QUOTES, 'UTF-8') ?>">
                                                <i class="bi bi-image"></i> Lihat
                                            </button>
                                        <?php else: ?>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-success btn-preview-berkas"
                                                data-file-url="<?= htmlspecialchars($b['link_file'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-file-title="<?= htmlspecialchars($b['label'], ENT_QUOTES, 'UTF-8') ?>">
                                                <i class="bi bi-eye"></i> Lihat
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Tombol Upload (Manual & System Upload) -->
                                    <?php if (!empty($b['bisa_upload'])): ?>
                                        <label class="btn btn-sm btn-outline-primary mb-0">
                                            <i class="bi bi-upload"></i>
                                            <?= $b['ada_file'] ? 'Ganti' : 'Upload' ?>
                                            <input type="file"
                                                class="d-none input-upload-berkas"
                                                data-id-usulan="<?= (int) $usulan->id ?>"
                                                data-kode="<?= htmlspecialchars($b['kode']) ?>"
                                                data-is-manual="<?= $is_manual ? '1' : '0' ?>"
                                                accept="application/pdf">
                                        </label>
                                    <?php elseif (!$b['ada_record'] && !$is_manual): ?>
                                        <small class="text-danger fw-semibold" style="font-size:0.75rem;">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Lengkapi di SIAP Online
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL PREVIEW FOTO                                   -->
<!-- ==================================================== -->
<div class="modal fade" id="modalPreviewGambar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulPreviewGambar">Preview Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="gambarPreview" src="" alt="Foto pegawai" class="img-fluid rounded shadow-sm" style="max-height:70vh; object-fit:contain;">
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL PREVIEW BERKAS PDF                             -->
<!-- ==================================================== -->
<div class="modal fade" id="modalPreviewBerkas" tabindex="-1" aria-labelledby="modalPreviewBerkasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px; width: calc(100% - 30px);">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPreviewBerkasLabel">Preview Berkas</h5>
                <div class="d-flex gap-2 ms-auto me-2">
                    <a href="#" id="btnBukaTabBaru" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tab Baru
                    </a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-0" style="height:80vh; position:relative; overflow:hidden;">
                <div id="previewLoading" class="justify-content-center align-items-center" style="display:flex; position:absolute; inset:0; z-index:2; background:#fff;">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 mb-0">Memuat berkas...</p>
                    </div>
                </div>
                <iframe id="iframePreviewBerkas" src="about:blank" title="Preview Berkas PDF" style="position:absolute; inset:0; display:none; width:100%; height:100%; border:0;"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL VALIDASI                                        -->
<!-- ==================================================== -->
<div class="modal fade" id="modalValidasi" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 500px !important; width: 90% !important; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title mb-0"><i class="bi bi-check-circle me-1"></i> Validasi Usulan Pemberhentian</h5>
                <button type="button" class="close text-dark border-0 bg-transparent opacity-100" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Status Usulan Validasi <span class="text-danger">*</span></label>
                    <select class="form-select" id="select-status-validasi">
                        <option value="">-- Pilih Status Validasi --</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan / Catatan</label>
                    <textarea class="form-control" id="text-keterangan-validasi" rows="3" placeholder="Masukkan keterangan atau alasan validasi…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" id="btn-simpan-validasi">Simpan Validasi</button>
            </div>
        </div>
    </div>
</div>
<!-- ==================================================== -->
<!-- MODAL LOADING DOWNLOAD ZIP (Versi Cantik)             -->
<!-- ==================================================== -->
<style>
    /* ===== Modal shell ===== */
    .dl-modal-content {
        border: none !important;
        border-radius: 20px !important;
        box-shadow: 0 25px 60px -12px rgba(15, 23, 42, 0.35),
            0 8px 20px -8px rgba(15, 23, 42, 0.15) !important;
        overflow: hidden;
        animation: dl-modal-in .4s cubic-bezier(.16, 1, .3, 1);
    }

    @keyframes dl-modal-in {
        0% {
            transform: scale(.92) translateY(8px);
            opacity: 0;
        }

        100% {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    .dl-modal-body {
        padding: 2.5rem 2rem 2rem;
        text-align: center;
        position: relative;
        background:
            radial-gradient(circle at 50% 30%, rgba(59, 130, 246, .10), transparent 55%),
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    }

    /* ===== Circular progress ===== */
    .dl-circle-wrap {
        position: relative;
        width: 128px;
        height: 128px;
        margin: 0 auto 1.5rem;
    }

    .dl-circle-svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
        transform-origin: center;
        overflow: visible;
    }

    .dl-circle-bg {
        fill: none;
        stroke: #e2e8f0;
        stroke-width: 5;
    }

    .dl-circle-fg {
        fill: none;
        stroke: url(#dl-gradient);
        stroke-width: 5;
        stroke-linecap: round;
        stroke-dasharray: 276.46;
        /* 2π × 44 */
        stroke-dashoffset: 276.46;
        transition: stroke-dashoffset .35s cubic-bezier(.4, 0, .2, 1),
            stroke .3s ease;
        filter: drop-shadow(0 2px 6px rgba(59, 130, 246, .35));
    }

    /* Indeterminate spin (state loading) */
    .dl-state-loading .dl-circle-svg {
        animation: dl-spin 1.6s linear infinite;
    }

    .dl-state-loading .dl-circle-fg {
        animation: dl-dash 1.6s ease-in-out infinite;
    }

    @keyframes dl-spin {
        from {
            transform: rotate(-90deg);
        }

        to {
            transform: rotate(270deg);
        }
    }

    @keyframes dl-dash {
        0% {
            stroke-dashoffset: 276.46;
        }

        50% {
            stroke-dashoffset: 69.115;
        }

        100% {
            stroke-dashoffset: 276.46;
        }
    }

    /* ===== Ikon tengah ===== */
    .dl-circle-center {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        pointer-events: none;
    }

    .dl-icon-download,
    .dl-icon-check,
    .dl-icon-error,
    .dl-percent {
        display: none;
    }

    .dl-icon-download {
        display: block;
        font-size: 2.2rem;
        color: #3b82f6;
        animation: dl-float 1.6s ease-in-out infinite;
    }

    @keyframes dl-float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(5px);
        }
    }

    .dl-state-progress .dl-icon-download {
        display: none;
    }

    .dl-state-progress .dl-percent {
        display: block;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e40af;
        letter-spacing: -0.02em;
        font-variant-numeric: tabular-nums;
    }

    .dl-state-success .dl-icon-download,
    .dl-state-success .dl-percent {
        display: none;
    }

    .dl-state-success .dl-icon-check {
        display: block;
        font-size: 2.6rem;
        color: #10b981;
        animation: dl-pop .45s cubic-bezier(.34, 1.56, .64, 1);
    }

    .dl-state-success .dl-circle-fg {
        stroke: #10b981;
        stroke-dashoffset: 0 !important;
        filter: drop-shadow(0 2px 8px rgba(16, 185, 129, .4));
    }

    .dl-state-error .dl-icon-download,
    .dl-state-error .dl-percent {
        display: none;
    }

    .dl-state-error .dl-icon-error {
        display: block;
        font-size: 2.4rem;
        color: #ef4444;
        animation: dl-pop .45s cubic-bezier(.34, 1.56, .64, 1);
    }

    .dl-state-error .dl-circle-fg {
        stroke: #ef4444;
        stroke-dashoffset: 0 !important;
        filter: drop-shadow(0 2px 8px rgba(239, 68, 68, .4));
    }

    @keyframes dl-pop {
        0% {
            transform: scale(0) rotate(-45deg);
            opacity: 0;
        }

        100% {
            transform: scale(1) rotate(0);
            opacity: 1;
        }
    }

    /* ===== Teks ===== */
    .dl-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 .35rem;
        letter-spacing: -.01em;
    }

    .dl-subtitle {
        font-size: .875rem;
        color: #64748b;
        margin: 0 0 .75rem;
        min-height: 1.25rem;
        line-height: 1.4;
    }

    /* Animasi titik-titik */
    .dl-dots span {
        display: inline-block;
        animation: dl-dot 1.4s infinite;
        opacity: .25;
    }

    .dl-dots span:nth-child(2) {
        animation-delay: .2s;
    }

    .dl-dots span:nth-child(3) {
        animation-delay: .4s;
    }

    @keyframes dl-dot {

        0%,
        60%,
        100% {
            opacity: .25;
            transform: translateY(0);
        }

        30% {
            opacity: 1;
            transform: translateY(-2px);
        }
    }

    .dl-state-progress .dl-dots,
    .dl-state-success .dl-dots,
    .dl-state-error .dl-dots {
        display: none;
    }

    /* ===== Info ukuran ===== */
    .dl-size-info {
        font-size: .78rem;
        color: #94a3b8;
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
        min-height: 1.1rem;
        margin-bottom: .25rem;
        letter-spacing: .01em;
    }

    /* ===== Tombol fallback error ===== */
    .dl-error-actions {
        display: none;
        margin-top: 1rem;
    }

    .dl-state-error .dl-error-actions {
        display: block;
    }
</style>

<div class="modal fade" id="modalDownloadLoading" tabindex="-1"
    data-bs-backdrop="static" data-bs-keyboard="false"
    data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content dl-modal-content dl-state-loading">
            <div class="dl-modal-body">

                <!-- Circular progress -->
                <div class="dl-circle-wrap">
                    <svg class="dl-circle-svg" viewBox="0 0 100 100">
                        <defs>
                            <linearGradient id="dl-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3b82f6" />
                                <stop offset="100%" stop-color="#8b5cf6" />
                            </linearGradient>
                        </defs>
                        <circle class="dl-circle-bg" cx="50" cy="50" r="44" />
                        <circle class="dl-circle-fg" cx="50" cy="50" r="44" />
                    </svg>
                    <div class="dl-circle-center">
                        <i class="bi bi-cloud-arrow-down-fill dl-icon-download"></i>
                        <span class="dl-percent">0%</span>
                        <i class="bi bi-check-circle-fill dl-icon-check"></i>
                        <i class="bi bi-exclamation-triangle-fill dl-icon-error"></i>
                    </div>
                </div>

                <!-- Teks -->
                <h5 class="dl-title">Menyiapkan berkas</h5>
                <p class="dl-subtitle">
                    <span class="dl-subtitle-text">Sedang mengumpulkan file dari server</span>
                    <span class="dl-dots"><span>.</span><span>.</span><span>.</span></span>
                </p>

                <!-- Info ukuran -->
                <div class="dl-size-info"></div>

                <!-- Aksi error -->
                <div class="dl-error-actions">
                    <a class="btn btn-sm btn-primary rounded-pill px-3"
                        target="_blank" rel="noopener" id="dl-fallback-link">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Coba Cara Lain
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ==================================================== -->
<!-- SCRIPT                                               -->
<!-- ==================================================== -->
<script>
    (function() {
        const BASE = "<?= site_url('sihenti_pegawai') ?>";
        let CSRF_NAME = "<?= $this->security->get_csrf_token_name() ?>";
        let CSRF_HASH = "<?= $this->security->get_csrf_hash() ?>";

        function postForm(url, fields) {
            const fd = new FormData();
            Object.keys(fields).forEach(k => fd.append(k, fields[k]));
            fd.append(CSRF_NAME, CSRF_HASH);
            return fetch(url, {
                method: 'POST',
                body: fd,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(r => r.json()).then(res => {
                if (res.csrf_hash) CSRF_HASH = res.csrf_hash;
                if (res.csrf_name) CSRF_NAME = res.csrf_name;
                return res;
            });
        }

        // ---- Simpan detail ----
        const btnSimpan = document.getElementById('btn-simpan-detail');
        if (btnSimpan) {
            btnSimpan.addEventListener('click', function() {
                const sel = document.getElementById('select-detail');
                const idDet = sel.value;
                if (!idDet) {
                    alert('Pilih detail pemberhentian terlebih dahulu.');
                    return;
                }

                const original = btnSimpan.innerHTML;
                btnSimpan.disabled = true;
                btnSimpan.textContent = 'Menyimpan…';

                postForm(BASE + '/simpan_detail', {
                        id_usulan: this.dataset.idUsulan,
                        id_detail_pemberhentian: idDet
                    })
                    .then(res => {
                        alert(res.message);
                        if (res.status === 'success') location.reload();
                    })
                    .catch(err => alert('Error: ' + err))
                    .finally(() => {
                        btnSimpan.disabled = false;
                        btnSimpan.innerHTML = original;
                    });
            });
        }

        // ---- Validasi Usulan  ----
        const btnValidasiModal = document.getElementById('btn-validasi-modal');
        if (btnValidasiModal) {
            btnValidasiModal.addEventListener('click', function() {
                const statusLama = this.dataset.status;
                const ketLama = this.dataset.keterangan;

                const selStatus = document.getElementById('select-status-validasi');
                const textKet = document.getElementById('text-keterangan-validasi');

                if (selStatus) selStatus.value = statusLama || '';
                if (textKet) textKet.value = ketLama || '';

                if (window.bootstrap && window.bootstrap.Modal) {
                    window.bootstrap.Modal.getOrCreateInstance(document.getElementById('modalValidasi')).show();
                } else if (window.jQuery && window.jQuery.fn.modal) {
                    window.jQuery('#modalValidasi').modal('show');
                }
            });
        }

        const btnSimpanValidasi = document.getElementById('btn-simpan-validasi');
        if (btnSimpanValidasi) {
            btnSimpanValidasi.addEventListener('click', function() {
                const selStatus = document.getElementById('select-status-validasi').value;
                const textKet = document.getElementById('text-keterangan-validasi').value;
                const idUsulan = btnValidasiModal ? btnValidasiModal.dataset.idUsulan : null;

                if (!selStatus) {
                    alert('Silakan pilih status validasi terlebih dahulu.');
                    return;
                }

                const original = btnSimpanValidasi.innerHTML;
                btnSimpanValidasi.disabled = true;
                btnSimpanValidasi.textContent = 'Menyimpan…';

                postForm(BASE + '/validasi_usulan', {
                        id_usulan: idUsulan,
                        status_usulan: selStatus,
                        keterangan: textKet
                    })
                    .then(res => {
                        alert(res.message);
                        if (res.status === 'success') {
                            if (window.jQuery && window.jQuery.fn.modal) {
                                window.jQuery('#modalValidasi').modal('hide');
                            }
                            location.reload();
                        }
                    })
                    .catch(err => alert('Error: ' + err))
                    .finally(() => {
                        btnSimpanValidasi.disabled = false;
                        btnSimpanValidasi.innerHTML = original;
                    });
            });
        }

        // ---- Ajukan usulan ----
        const btnAjukan = document.getElementById('btn-ajukan');
        if (btnAjukan) {
            btnAjukan.addEventListener('click', function() {
                if (!confirm('Ajukan usulan ini? Setelah diajukan, data tidak dapat diubah lagi.')) return;
                const original = btnAjukan.innerHTML;
                btnAjukan.disabled = true;
                btnAjukan.textContent = 'Memproses…';

                postForm(BASE + '/ajukan_usulan', {
                        id: this.dataset.idUsulan
                    })
                    .then(res => {
                        alert(res.message);
                        if (res.status === 'success') location.reload();
                    })
                    .catch(err => alert('Error: ' + err))
                    .finally(() => {
                        btnAjukan.disabled = false;
                        btnAjukan.innerHTML = original;
                    });
            });
        }

        // ---- Upload berkas (Auto Detect System/Manual) ----
        document.querySelectorAll('.input-upload-berkas').forEach(function(inp) {
            inp.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                const isManual = this.dataset.isManual === '1';
                const maxSizeBytes = isManual ? (2048 * 1024) : (1000 * 1024);
                const maxLabel = isManual ? '2 MB' : '1 MB';

                if (file.type !== 'application/pdf') {
                    alert('File harus format PDF.');
                    this.value = '';
                    return;
                }
                if (file.size > maxSizeBytes) {
                    alert('Ukuran file maksimal ' + maxLabel + '.');
                    this.value = '';
                    return;
                }

                const id_usulan = this.dataset.idUsulan;
                const kode = this.dataset.kode;

                const fd = new FormData();
                fd.append('file_berkas', file);
                fd.append('id_usulan', id_usulan);
                fd.append('kode_berkas', kode);
                fd.append(CSRF_NAME, CSRF_HASH);

                const elInput = this;
                elInput.disabled = true;

                // Tentukan endpoint berdasarkan tipe berkas
                const targetUrl = isManual ?
                    (BASE + '/upload_berkas_manual') :
                    (BASE + '/upload_berkas_pegawai');

                fetch(targetUrl, {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.csrf_hash) CSRF_HASH = res.csrf_hash;
                        if (res.csrf_name) CSRF_NAME = res.csrf_name;

                        alert(res.message);
                        if (res.status === 'success') location.reload();
                    })
                    .catch(err => alert('Error: ' + err))
                    .finally(() => {
                        elInput.disabled = false;
                        elInput.value = '';
                    });
            });
        });
    })();

    // ====================================================
    // PREVIEW BERKAS - KOMPATIBEL BOOTSTRAP 4 / 5
    // ====================================================
    (function() {
        const modalEl = document.getElementById('modalPreviewBerkas');
        const iframe = document.getElementById('iframePreviewBerkas');
        const loading = document.getElementById('previewLoading');
        const judul = document.getElementById('modalPreviewBerkasLabel');
        const btnTabBaru = document.getElementById('btnBukaTabBaru');

        if (!modalEl || !iframe || !loading || !judul || !btnTabBaru) {
            console.error('Elemen modal preview tidak lengkap.');
            return;
        }

        let modalBS5 = null;
        let modeModal = '';

        if (window.bootstrap && window.bootstrap.Modal) {
            modalBS5 = window.bootstrap.Modal.getOrCreateInstance(modalEl);
            modeModal = 'bs5';
        } else if (window.jQuery && window.jQuery.fn.modal) {
            modeModal = 'bs4';
        }

        function bukaModal() {
            if (modeModal === 'bs5') {
                modalBS5.show();
            } else if (modeModal === 'bs4') {
                window.jQuery(modalEl).modal('show');
            } else {
                alert('Bootstrap Modal tidak ditemukan.');
            }
        }

        function tutupModal() {
            if (modeModal === 'bs5') {
                modalBS5.hide();
            } else if (modeModal === 'bs4') {
                window.jQuery(modalEl).modal('hide');
            }
        }

        document.addEventListener('click', function(event) {
            const btn = event.target.closest('.btn-preview-berkas');
            if (!btn) return;

            event.preventDefault();

            const url = btn.dataset.fileUrl;
            const nama = btn.dataset.fileTitle || 'Preview Berkas';

            if (!url) {
                alert('URL berkas tidak tersedia.');
                return;
            }

            if (!modeModal) {
                alert('Bootstrap Modal tidak ditemukan.');
                return;
            }

            judul.textContent = 'Preview Berkas - ' + nama;
            btnTabBaru.href = url;

            loading.innerHTML =
                '<div class="text-center">' +
                '<div class="spinner-border text-primary" role="status"></div>' +
                '<p class="mt-2">Memuat berkas...</p>' +
                '</div>';

            loading.style.display = 'flex';
            iframe.style.display = 'block';

            bukaModal();

            setTimeout(function() {
                iframe.src = url;
            }, 300);

            setTimeout(function() {
                loading.style.display = 'none';
            }, 1500);
        });

        modalEl.querySelectorAll('[data-bs-dismiss="modal"], [data-dismiss="modal"]')
            .forEach(function(btn) {
                btn.addEventListener('click', function() {
                    tutupModal();
                });
            });

        if (modeModal === 'bs5') {
            modalEl.addEventListener('hidden.bs.modal', function() {
                iframe.src = 'about:blank';
                iframe.style.display = 'none';
                loading.style.display = 'block';
            });
        } else if (modeModal === 'bs4') {
            window.jQuery(modalEl).on('hidden.bs.modal', function() {
                iframe.src = 'about:blank';
                iframe.style.display = 'none';
                loading.style.display = 'block';
            });
        }
    })();

    (function() {
        const modalEl = document.getElementById('modalPreviewGambar');
        const gambar = document.getElementById('gambarPreview');
        const judul = document.getElementById('judulPreviewGambar');

        if (!modalEl || !gambar || !judul) return;

        document.addEventListener('click', function(event) {
            const btn = event.target.closest('.btn-preview-gambar');
            if (!btn) return;

            event.preventDefault();

            const url = btn.dataset.fileUrl;
            if (!url) {
                alert('URL foto tidak tersedia.');
                return;
            }

            gambar.src = url;
            judul.textContent = 'Preview Foto - ' + (btn.dataset.fileTitle || 'Foto Pegawai');

            if (window.bootstrap && window.bootstrap.Modal) {
                window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
            } else if (window.jQuery && window.jQuery.fn.modal) {
                window.jQuery(modalEl).modal('show');
            } else {
                window.open(url, '_blank', 'noopener');
            }
        });

        modalEl.addEventListener('hidden.bs.modal', function() {
            gambar.src = '';
        });
    })();

    // ====================================================
    // DOWNLOAD SEMUA BERKAS (ZIP) — versi cantik
    // ====================================================
    (function() {
        const btn = document.getElementById('btn-download-semua');
        if (!btn) return;

        const modalEl = document.getElementById('modalDownloadLoading');
        const contentEl = modalEl.querySelector('.dl-modal-content');
        const titleEl = modalEl.querySelector('.dl-title');
        const subtitleText = modalEl.querySelector('.dl-subtitle-text');
        const percentEl = modalEl.querySelector('.dl-percent');
        const sizeInfoEl = modalEl.querySelector('.dl-size-info');
        const circleFg = modalEl.querySelector('.dl-circle-fg');
        const fallbackLink = document.getElementById('dl-fallback-link');

        const CIRCUMFERENCE = 2 * Math.PI * 44; // ≈ 276.46

        let modeModal = '';
        if (window.bootstrap && window.bootstrap.Modal) modeModal = 'bs5';
        else if (window.jQuery && window.jQuery.fn.modal) modeModal = 'bs4';

        function showModal() {
            if (modeModal === 'bs5') window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
            else if (modeModal === 'bs4') window.jQuery(modalEl).modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function hideModal() {
            if (modeModal === 'bs5') window.bootstrap.Modal.getOrCreateInstance(modalEl).hide();
            else if (modeModal === 'bs4') window.jQuery(modalEl).modal('hide');
        }

        function setState(state) {
            contentEl.classList.remove('dl-state-loading', 'dl-state-progress', 'dl-state-success', 'dl-state-error');
            contentEl.classList.add('dl-state-' + state);
        }

        function setProgress(pct) {
            pct = Math.max(0, Math.min(100, pct));
            const offset = CIRCUMFERENCE - (CIRCUMFERENCE * pct / 100);
            circleFg.style.strokeDashoffset = offset;
            percentEl.textContent = pct + '%';
        }

        function formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1024 / 1024).toFixed(2) + ' MB';
        }

        function extractFilename(headers, fallback) {
            const cd = headers.get('Content-Disposition') || '';
            let m = cd.match(/filename\*\s*=\s*UTF-8''([^;]+)/i);
            if (m) {
                try {
                    return decodeURIComponent(m[1].trim());
                } catch (e) {}
            }
            m = cd.match(/filename\s*=\s*["']?([^"';]+)["']?/i);
            if (m) return m[1].trim();
            return fallback;
        }

        function saveBlob(blob, filename) {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            setTimeout(function() {
                URL.revokeObjectURL(url);
            }, 1500);
        }

        function resetUI() {
            setState('loading');
            titleEl.textContent = 'Menyiapkan berkas';
            subtitleText.textContent = 'Sedang mengumpulkan file dari server';
            percentEl.textContent = '0%';
            sizeInfoEl.textContent = '';
            circleFg.style.strokeDashoffset = CIRCUMFERENCE;
        }

        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            const url = this.href;

            resetUI();
            showModal();

            try {
                const res = await fetch(url, {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const ctype = (res.headers.get('Content-Type') || '').toLowerCase();
                const isZip = ctype.indexOf('zip') !== -1 ||
                    ctype.indexOf('octet-stream') !== -1 ||
                    ctype.indexOf('force-download') !== -1;

                if (!res.ok || !isZip) {
                    let msg = 'Gagal mengunduh berkas (HTTP ' + res.status + ').';
                    try {
                        const text = await res.text();
                        const m = text.match(/<p>([^<]{5,300})<\/p>/i) ||
                            text.match(/<h1>([^<]{5,300})<\/h1>/i);
                        if (m) msg = m[1].replace(/\s+/g, ' ').trim();
                    } catch (_) {}
                    throw new Error(msg);
                }

                // --- Download dengan progress ---
                const contentLength = parseInt(res.headers.get('Content-Length') || '0', 10);
                const filename = extractFilename(res.headers, 'Berkas_Pemberhentian.zip');

                // Begitu headers diterima → ganti ke mode progress
                setState('progress');
                titleEl.textContent = 'Mengunduh berkas';
                subtitleText.textContent = 'File sedang dikirim dari server';

                const reader = res.body.getReader();
                const chunks = [];
                let received = 0;

                while (true) {
                    const {
                        done,
                        value
                    } = await reader.read();
                    if (done) break;
                    chunks.push(value);
                    received += value.length;

                    if (contentLength > 0) {
                        const pct = Math.min(100, Math.round(received / contentLength * 100));
                        setProgress(pct);
                        sizeInfoEl.textContent =
                            formatSize(received) + ' / ' + formatSize(contentLength);
                    } else {
                        // Server tidak kirim Content-Length → tetap loading state,
                        // hanya update info ukuran
                        sizeInfoEl.textContent = formatSize(received) + ' terunduh';
                    }
                }

                // --- Selesai ---
                const blob = new Blob(chunks, {
                    type: 'application/zip'
                });
                saveBlob(blob, filename);

                setState('success');
                setProgress(100);
                titleEl.textContent = 'Berhasil!';
                subtitleText.textContent = 'File ZIP berhasil diunduh';
                sizeInfoEl.textContent = formatSize(blob.size) + ' · ' + filename;

                setTimeout(hideModal, 1800);

            } catch (err) {
                setState('error');
                titleEl.textContent = 'Gagal mengunduh';
                subtitleText.textContent = err.message || 'Terjadi kesalahan.';
                sizeInfoEl.textContent = '';
                if (fallbackLink) fallbackLink.href = url;
                console.error('Download error:', err);
            }
        });
    })();
</script>