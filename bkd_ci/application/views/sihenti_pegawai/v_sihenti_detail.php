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
                            <br><p>Format: <?= htmlspecialchars($b['format_nama_file']) ?></p>
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
                                <?php if ($b['ada_file']): ?>
                                    <a href="<?= htmlspecialchars($b['link_file']) ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-file-pdf"></i> Lihat
                                    </a>
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
</script>