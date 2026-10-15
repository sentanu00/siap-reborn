<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .detail-dt {
        font-weight: 600;
        color: #555;
    }

    .badge-soft-info {
        background: #e7f1ff;
        color: #0d6efd;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">
        <i class="bi bi-folder2-open"></i> Detail Berkas Pemberhentian
    </h4>
    <a href="<?= site_url('sihenti_pegawai') ?>" class="btn btn-outline-secondary btn-md">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- ==================================================== -->
<!-- INFORMASI USULAN                                      -->
<!-- ==================================================== -->
<div class="card shadow-sm mb-3">
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
            <dd class="col-sm-9">
                <span class="badge bg-info badge-status">
                    <?= htmlspecialchars($usulan->status_usulan) ?>
                </span>
            </dd>

            <dt class="col-sm-3 detail-dt">Keterangan</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($usulan->keterangan ?: '-') ?></dd>
        </dl>
    </div>
</div>

<!-- ==================================================== -->
<!-- FORM PILIH DETAIL PEMBERHENTIAN                       -->
<!-- ==================================================== -->
<div class="card shadow-sm mb-3">
    <div class="card-header bg-secondary text-white">
        <i class="bi bi-list-check"></i> Detail Pemberhentian
    </div>
    <div class="card-body">
        <?php if (empty($jenis)): ?>
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle"></i>
                Jenis pemberhentian <b>"<?= htmlspecialchars($usulan->jenis_usulan) ?>"</b>
                tidak ditemukan di master data. Hubungi administrator.
            </div>
        <?php elseif (empty($detail_list)): ?>
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle"></i>
                Belum ada daftar detail pemberhentian untuk jenis ini.
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label class="form-label detail-dt">Jenis Pemberhentian</label>
                <input type="text" class="form-control" readonly
                    value="<?= htmlspecialchars($jenis->jenis) ?>">
                <p class="text-muted">
                    Status Pegawai: <b><?= htmlspecialchars($jenis->status_pegawai) ?></b>
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label detail-dt" for="select-detail">
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
                <small class="text-muted">
                    Pilih salah satu alasan detail sesuai dasar pemberhentian.
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" id="btn-simpan-detail"
                    data-id-usulan="<?= (int) $usulan->id ?>">
                    <i class="bi bi-save"></i> Simpan Detail
                </button>
                <button type="button" class="btn btn-success" id="btn-ajukan"
                    data-id-usulan="<?= (int) $usulan->id ?>">
                    <i class="bi bi-send"></i> Ajukan Usulan
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- ==================================================== -->
<!-- CARD: BERKAS PERSYARATAN                              -->
<!-- ==================================================== -->
<div class="card shadow-sm mb-3">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <span style="color: black;"><i class="bi bi-paperclip"></i> Berkas Persyaratan</span>
        <span class="badge bg-dark" id="badge-berkas">
            <?php
            $total   = count($berkas_list);
            $lengkap = 0;
            foreach ($berkas_list as $b) if ($b['ada_file']) $lengkap++;
            echo $lengkap . ' / ' . $total;
            ?>
        </span>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Berkas</th>
                    <th style="width:90px;" class="text-center">Wajib</th>
                    <th style="width:180px;">Status</th>
                    <th style="width:280px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($berkas_list as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <strong><?= htmlspecialchars($b['label']) ?></strong>
                            <br>
                            <p>Format: <?= htmlspecialchars($b['format_nama_file']) ?></p>
                        </td>
                        <td class="text-center">
                            <?php if ($b['wajib']): ?>
                                <span class="badge bg-danger">Wajib</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Opsional</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$b['ada_record']): ?>
                                <span class="badge bg-dark">Data belum ada</span>
                            <?php elseif (!$b['ada_file']): ?>
                                <span class="badge bg-warning text-dark">Belum upload</span>
                            <?php else: ?>
                                <span class="badge bg-success">Sudah ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if (!$b['ada_record']): ?>
                                <small class="text-danger">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Lengkapi di menu <b>Pegawai Siap Online</b>
                                </small>
                            <?php else: ?>
                                <?php if ($b['ada_file'] && !empty($b['link_file'])): ?>
                                    <?php if (
                                        isset($b['tipe_file']) &&
                                        $b['tipe_file'] === 'image'
                                    ): ?>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-success btn-preview-gambar"
                                            data-file-url="<?= htmlspecialchars($b['link_file'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-file-title="<?= htmlspecialchars($b['label'], ENT_QUOTES, 'UTF-8') ?>">
                                            <i class="bi bi-image"></i> Lihat Foto
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

                                <!-- <label class="btn btn-sm btn-outline-primary mb-0">
                                    <i class="bi bi-upload"></i>
                                    <?= $b['ada_file'] ? 'Ganti' : 'Upload' ?>
                                    <input type="file"
                                        class="d-none input-upload-berkas"
                                        data-id-usulan="<?= (int) $usulan->id ?>"
                                        data-kode="<?= htmlspecialchars($b['kode']) ?>"
                                        accept="application/pdf">
                                </label> -->

                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ==================================================== -->
<!-- MODAL PREVIEW BERKAS                                 -->
<!-- ==================================================== -->
<div class="modal fade" id="modalPreviewGambar"
    tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulPreviewGambar">
                    Preview Foto
                </h5>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img id="gambarPreview"
                    src=""
                    alt="Foto pegawai"
                    style="max-width:100%; max-height:70vh; object-fit:contain;">
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL PREVIEW BERKAS PDF                             -->
<!-- ==================================================== -->
<div class="modal fade" id="modalPreviewBerkas"
    tabindex="-1" aria-labelledby="modalPreviewBerkasLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered"
        style="max-width: 750px; width: calc(100% - 30px);">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPreviewBerkasLabel">
                    Preview Berkas
                </h5>

                <div class="d-flex gap-2 ms-auto me-2">
                    <a href="#" id="btnBukaTabBaru"
                        class="btn btn-sm btn-outline-primary"
                        target="_blank" rel="noopener">
                        <i class="bi bi-box-arrow-up-right"></i>
                        Buka Tab Baru
                    </a>
                </div>

                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    data-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-0"
                style="height:80vh; position:relative; overflow:hidden;">

                <div id="previewLoading"
                    class="justify-content-center align-items-center"
                    style="display:flex; position:absolute; inset:0; z-index:2; background:#fff;">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 mb-0">Memuat berkas...</p>
                    </div>
                </div>

                <iframe id="iframePreviewBerkas"
                    src="about:blank"
                    title="Preview Berkas PDF"
                    style="position:absolute; inset:0; display:none; width:100%; height:100%; border:0;">
                </iframe>

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
    })();
    // ---- Upload berkas ----
    document.querySelectorAll('.input-upload-berkas').forEach(function(inp) {
        inp.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            // Validasi client
            if (file.type !== 'application/pdf') {
                alert('File harus PDF.');
                this.value = '';
                return;
            }
            if (file.size > 1000 * 1024) {
                alert('Ukuran file maksimal 1 MB.');
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

            fetch(BASE + '/upload_berkas_pegawai', {
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

        // Deteksi Bootstrap 5
        if (window.bootstrap && window.bootstrap.Modal) {
            modalBS5 = window.bootstrap.Modal.getOrCreateInstance(modalEl);
            modeModal = 'bs5';
        }
        // Deteksi Bootstrap 4
        else if (window.jQuery && window.jQuery.fn.modal) {
            modeModal = 'bs4';
        }

        function bukaModal() {
            if (modeModal === 'bs5') {
                modalBS5.show();
            } else if (modeModal === 'bs4') {
                window.jQuery(modalEl).modal('show');
            } else {
                alert(
                    'Bootstrap Modal tidak ditemukan. ' +
                    'Periksa JavaScript Bootstrap pada layouts/main.'
                );
            }
        }

        function tutupModal() {
            if (modeModal === 'bs5') {
                modalBS5.hide();
            } else if (modeModal === 'bs4') {
                window.jQuery(modalEl).modal('hide');
            }
        }

        // Event delegation: preview PDF
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

            // Atur judul dan tautan untuk membuka PDF di tab baru
            judul.textContent = 'Preview Berkas - ' + nama;
            btnTabBaru.href = url;

            // Tampilkan iframe dan lapisan pemuatan
            loading.innerHTML =
                '<div class="text-center">' +
                '<div class="spinner-border text-primary" role="status"></div>' +
                '<p class="mt-2">Memuat berkas...</p>' +
                '</div>';

            loading.style.display = 'flex';
            iframe.style.display = 'block';

            // Buka modal
            bukaModal();

            // Muat PDF setelah modal mulai dibuka
            setTimeout(function() {
                iframe.src = url;
            }, 300);

            // Hilangkan tulisan pemuatan agar tidak menutupi PDF
            setTimeout(function() {
                loading.style.display = 'none';
            }, 1500);
        });

        // Tombol tutup modal, kompatibel BS4 dan BS5
        modalEl.querySelectorAll('[data-bs-dismiss="modal"], [data-dismiss="modal"]')
            .forEach(function(btn) {
                btn.addEventListener('click', function() {
                    tutupModal();
                });
            });

        // Bersihkan dokumen saat modal ditutup
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
            judul.textContent =
                'Preview Foto - ' + (btn.dataset.fileTitle || 'Foto Pegawai');

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
</script>