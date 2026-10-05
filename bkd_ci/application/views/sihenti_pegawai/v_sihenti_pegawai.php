<!-- ==================== STYLE ==================== -->
<style>
    .card-header {
        font-weight: 600;
    }

    .table-sm td,
    .table-sm th {
        vertical-align: middle;
    }

    .badge-status {
        font-size: .78rem;
        padding: .4em .6em;
    }

    #table-pegawai tbody tr:hover {
        background: #f8f9fa;
    }

    #pagination-pegawai .page-link {
        cursor: pointer;
    }

    .pegawai-loading {
        text-align: center;
        padding: 20px;
        color: #999;
    }
</style>

<h4 class="mb-3">
    <i class="bi bi-person-x"></i>
    <?= htmlspecialchars($pageTitle) ?>
</h4>

<?php if (!empty($pageNote)): ?>
    <p class="text-muted"><?= htmlspecialchars($pageNote) ?></p>
<?php endif; ?>

<!-- ==================================================== -->
<!-- TABEL 1 : USULAN PEMBERHENTIAN                       -->
<!-- ==================================================== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-list-check"></i> Daftar Usulan Pemberhentian
    </div>
    <div class="card-body table-responsive">
        <table class="table table-sm table-bordered table-hover align-middle" id="table-usulan">
            <thead class="table-light">
                <tr>
                    <th style="width:40px;">#</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Tgl Usul</th>
                    <th>Jenis Usulan</th>
                    <th>Diusulkan Oleh</th>
                    <th>Tgl Edit</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usulan_list)): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted py-3">
                            Belum ada usulan pemberhentian.
                        </td>
                    </tr>
                    <?php else: $no = 1;
                    foreach ($usulan_list as $u): ?>
                        <tr id="row-usulan-<?= $u->id ?>">
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($u->nip) ?></td>
                            <td><?= htmlspecialchars($u->nama) ?></td>
                            <td><?= htmlspecialchars($u->tanggal_usul) ?></td>
                            <td class="col-jenis"><?= htmlspecialchars($u->jenis_usulan) ?></td>
                            <td><?= htmlspecialchars($u->diusulkan_oleh) ?></td>
                            <td class="col-edit"><?= $u->tanggal_edit ?: '-' ?></td>
                            <td class="col-status"><?= _badge_status($u->status_usulan) ?></td>
                            <td><?= htmlspecialchars($u->keterangan ?: '-') ?></td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary btn-pilih-jenis"
                                    data-id="<?= $u->id ?>"
                                    data-nip="<?= htmlspecialchars($u->nip) ?>"
                                    data-nama="<?= htmlspecialchars($u->nama) ?>"
                                    data-jenis="<?= htmlspecialchars($u->jenis_usulan) ?>"
                                    title="Pilih Jenis Usulan">
                                    <i class="bi bi-tags"></i>
                                </button>
                                <a href="<?= site_url('sihenti_pegawai/detail/' . $u->id) ?>"
                                    class="btn btn-sm btn-outline-success"
                                    title="Detail Berkas">
                                    <i class="bi bi-folder2-open"></i> Detail
                                </a>
                            </td>
                        </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ==================================================== -->
<!-- TABEL 2 : DAFTAR PEGAWAI (AJAX + Pagination)         -->
<!-- ==================================================== -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-people"></i> Daftar Pegawai Aktif</span>
        <div class="d-flex align-items-center gap-2">
            <select id="per-page-pegawai" class="form-select form-select-sm" style="width:auto;">
                <option value="10" selected>10 / hal</option>
                <option value="25">25 / hal</option>
                <option value="50">50 / hal</option>
                <option value="100">100 / hal</option>
            </select>
            <input type="text" id="search-pegawai" class="form-control form-control-sm"
                placeholder="Cari NIP atau Nama…" style="min-width:260px;">
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-sm table-bordered table-hover align-middle mb-0" id="table-pegawai">
            <thead class="table-light">
                <tr>
                    <th style="width:40px;">#</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Satker</th>
                    <th>Satker Induk</th>
                    <th>Tanggal Pensiun</th>
                    <th class="text-center" style="width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody-pegawai">
                <tr>
                    <td colspan="7" class="pegawai-loading">Memuat data…</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted" id="info-pegawai">-</small>
        <nav>
            <ul class="pagination pagination-sm mb-0" id="pagination-pegawai"></ul>
        </nav>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL KONFIRMASI TAMBAH                               -->
<!-- ==================================================== -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Konfirmasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="konfirmasi-text" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" id="btn-konfirmasi-ya">Ya, Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL PILIH JENIS USULAN                              -->
<!-- ==================================================== -->
<div class="modal fade" id="modalJenis" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Pilih Jenis Usulan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Pegawai:
                    <strong id="jenis-nama"></strong>
                    (<span id="jenis-nip"></span>)
                </p>
                <label class="form-label">Jenis Usulan Pemberhentian</label>
                <select class="form-select" id="select-jenis">
                    <?php foreach ($jenis_usulan_options as $opt): ?>
                        <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted d-block mt-2">
                    Setelah dipilih, status akan berubah menjadi <b>Input Data</b>.
                </small>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" id="btn-simpan-jenis">Simpan</button>
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
        const CSRF_NAME = "<?= $this->security->get_csrf_token_name() ?>";
        const CSRF_HASH = "<?= $this->security->get_csrf_hash() ?>";

        /* =========================================================
         * BAGIAN A: PEGAWAI - AJAX + Pagination + Search
         * ========================================================= */
        const statePegawai = {
            page: 1,
            per_page: 10,
            q: '',
            total_page: 0,
            loading: false,
            requestId: 0,
        };

        const tbodyPegawai = document.getElementById('tbody-pegawai');
        const infoPegawai = document.getElementById('info-pegawai');
        const paginasi = document.getElementById('pagination-pegawai');
        const searchInput = document.getElementById('search-pegawai');
        const perPageSel = document.getElementById('per-page-pegawai');

        function escapeHtml(s) {
            if (s === null || s === undefined) return '';
            return String(s)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function renderPegawai(data) {
            if (!data || data.length === 0) {
                tbodyPegawai.innerHTML =
                    '<tr><td colspan="7" class="text-center text-muted py-3">' +
                    'Tidak ada data pegawai.</td></tr>';
                return;
            }
            let html = '';
            const start = (statePegawai.page - 1) * statePegawai.per_page;
            data.forEach(function(row, i) {
                html += '<tr>';
                html += '<td>' + (start + i + 1) + '</td>';
                html += '<td>' + escapeHtml(row.nip) + '</td>';
                html += '<td>' + escapeHtml(row.nama) + '</td>';
                html += '<td>' + escapeHtml(row.satker) + '</td>';
                html += '<td>' + escapeHtml(row.satker_induk) + '</td>';
                html += '<td>' + escapeHtml(row.tanggal_pensiun) + '</td>';
                html += '<td class="text-center">';
                if (row.is_aktif) {
                    html += '<button class="btn btn-sm btn-secondary" disabled ' +
                        'title="Sudah ada usulan aktif">' +
                        '<i class="bi bi-check2-circle"></i> Terdaftar</button>';
                } else {
                    html += '<button type="button" ' +
                        'class="btn btn-sm btn-success btn-tambah" ' +
                        'data-nip="' + escapeHtml(row.nip) + '" ' +
                        'data-nama="' + escapeHtml(row.nama) + '">' +
                        '<i class="bi bi-plus-circle"></i> Tambah</button>';
                }
                html += '</td>';
                html += '</tr>';
            });
            tbodyPegawai.innerHTML = html;

            // rebind tombol tambah
            tbodyPegawai.querySelectorAll('.btn-tambah').forEach(function(btn) {
                btn.addEventListener('click', onKlikTambah);
            });
        }

        function renderPagination() {
            const total = statePegawai.total_page;
            const curr = statePegawai.page;
            if (total <= 1) {
                paginasi.innerHTML = '';
                return;
            }

            let html = '';
            const mkBtn = function(label, page, disabled, active) {
                let cls = 'page-item';
                if (disabled) cls += ' disabled';
                if (active) cls += ' active';
                return '<li class="' + cls + '"><a class="page-link" data-page="' +
                    page + '">' + label + '</a></li>';
            };

            html += mkBtn('&laquo;', curr - 1, curr <= 1, false);

            // window 5 halaman
            let start = Math.max(1, curr - 2);
            let end = Math.min(total, start + 4);
            if (end - start < 4) start = Math.max(1, end - 4);

            if (start > 1) {
                html += mkBtn(1, 1, false, curr === 1);
                if (start > 2) html += '<li class="page-item disabled"><span class="page-link">…</span></li>';
            }
            for (let i = start; i <= end; i++) {
                html += mkBtn(i, i, false, curr === i);
            }
            if (end < total) {
                if (end < total - 1) html += '<li class="page-item disabled"><span class="page-link">…</span></li>';
                html += mkBtn(total, total, false, curr === total);
            }

            html += mkBtn('&raquo;', curr + 1, curr >= total, false);
            paginasi.innerHTML = html;

            paginasi.querySelectorAll('a.page-link').forEach(function(a) {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    const p = parseInt(this.dataset.page, 10);
                    if (!p || p === statePegawai.page) return;
                    statePegawai.page = p;
                    loadPegawai();
                });
            });
        }

        function loadPegawai() {
            if (statePegawai.loading) return;
            statePegawai.loading = true;
            statePegawai.requestId++;
            const myReq = statePegawai.requestId;

            tbodyPegawai.innerHTML =
                '<tr><td colspan="7" class="pegawai-loading">' +
                '<div class="spinner-border spinner-border-sm text-secondary"></div> Memuat…' +
                '</td></tr>';

            const url = BASE + '/get_pegawai?page=' + statePegawai.page +
                '&per_page=' + statePegawai.per_page +
                '&q=' + encodeURIComponent(statePegawai.q);

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(res) {
                    if (myReq !== statePegawai.requestId) return; // buang response lama
                    if (res.status !== 'success') {
                        tbodyPegawai.innerHTML =
                            '<tr><td colspan="7" class="text-center text-danger py-3">' +
                            'Gagal memuat data.</td></tr>';
                        return;
                    }
                    statePegawai.total_page = res.total_page;
                    renderPegawai(res.data);
                    renderPagination();

                    const from = res.total === 0 ? 0 : ((res.page - 1) * res.per_page) + 1;
                    const to = Math.min(res.page * res.per_page, res.total);
                    infoPegawai.textContent =
                        'Menampilkan ' + from + '–' + to + ' dari ' + res.total + ' pegawai' +
                        (res.q ? ' (pencarian: "' + res.q + '")' : '');
                })
                .catch(function(err) {
                    if (myReq !== statePegawai.requestId) return;
                    tbodyPegawai.innerHTML =
                        '<tr><td colspan="7" class="text-center text-danger py-3">' +
                        'Error: ' + err + '</td></tr>';
                })
                .finally(function() {
                    if (myReq === statePegawai.requestId) statePegawai.loading = false;
                });
        }

        /* --- Debounce pencarian (300ms) --- */
        let searchTimer = null;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            const val = this.value.trim();
            searchTimer = setTimeout(function() {
                statePegawai.q = val;
                statePegawai.page = 1;
                loadPegawai();
            }, 300);
        });

        /* --- Ganti jumlah per halaman --- */
        perPageSel.addEventListener('change', function() {
            statePegawai.per_page = parseInt(this.value, 10) || 10;
            statePegawai.page = 1;
            loadPegawai();
        });

        /* --- Load pertama --- */
        loadPegawai();

        let pendingTambah = null;
        let modalKonfirmasiInstance = null; // ⭐ lazy init

        function getModalKonfirmasi() {
            if (!modalKonfirmasiInstance) {
                modalKonfirmasiInstance = new bootstrap.Modal('#modalKonfirmasi');
            }
            return modalKonfirmasiInstance;
        }

        function onKlikTambah() {
            const nip = this.dataset.nip;
            const nama = this.dataset.nama;
            pendingTambah = {
                nip: nip,
                nama: nama
            };

            document.getElementById('konfirmasi-text').innerHTML =
                'Apakah Anda yakin ingin menambahkan <b>' + escapeHtml(nama) +
                ' (' + escapeHtml(nip) + ')</b> ke usulan pemberhentian?';

            getModalKonfirmasi().show(); // ⭐ dibuat saat diklik
        }

        document.getElementById('btn-konfirmasi-ya').addEventListener('click', function() {
            if (!pendingTambah) return;
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Memproses…';

            const fd = new FormData();
            fd.append('nip', pendingTambah.nip);
            fd.append('nama', pendingTambah.nama);
            fd.append(CSRF_NAME, CSRF_HASH);

            fetch(BASE + '/tambah_usulan', {
                    method: 'POST',
                    body: fd
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(res) {
                    // update CSRF baru dari server
                    if (res.csrf_hash) CSRF_HASH = res.csrf_hash;
                    if (res.csrf_name) CSRF_NAME = res.csrf_name;

                    if (res.status === 'success') {
                        getModalKonfirmasi().hide();
                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message);
                        if (res.debug) console.error('Debug:', res.debug);
                    }
                })
                .catch(function(err) {
                    alert('Error: ' + err);
                })
                .finally(function() {
                    btn.disabled = false;
                    btn.textContent = 'Ya, Tambahkan';
                    pendingTambah = null;
                });
        });

        /* =========================================================
         * BAGIAN C: PILIH JENIS USULAN
         * ========================================================= */
        let pendingJenis = null;
        let modalJenisInstance = null; // ⭐ lazy init

        function getModalJenis() {
            if (!modalJenisInstance) {
                modalJenisInstance = new bootstrap.Modal('#modalJenis');
            }
            return modalJenisInstance;
        }

        document.querySelectorAll('.btn-pilih-jenis').forEach(function(btn) {
            btn.addEventListener('click', function() {
                pendingJenis = {
                    id: this.dataset.id
                };
                document.getElementById('jenis-nama').textContent = this.dataset.nama;
                document.getElementById('jenis-nip').textContent = this.dataset.nip;

                const sel = document.getElementById('select-jenis');
                for (let i = 0; i < sel.options.length; i++) {
                    if (sel.options[i].value === this.dataset.jenis) {
                        sel.selectedIndex = i;
                        break;
                    }
                }
                getModalJenis().show(); // ⭐
            });
        });

        document.getElementById('btn-simpan-jenis').addEventListener('click', function() {
            if (!pendingJenis) return;
            const btn = this;
            const jenis = document.getElementById('select-jenis').value;

            btn.disabled = true;
            btn.textContent = 'Menyimpan…';

            const fd = new FormData();
            fd.append('id', pendingJenis.id);
            fd.append('jenis_usulan', jenis);
            fd.append(CSRF_NAME, CSRF_HASH);

            fetch(BASE + '/pilih_jenis_usulan', {
                    method: 'POST',
                    body: fd
                })
                .then(function(r) {
                    return r.json();
                })
                .then(function(res) {
                    if (res.csrf_hash) CSRF_HASH = res.csrf_hash;
                    if (res.csrf_name) CSRF_NAME = res.csrf_name;

                    if (res.status === 'success') {
                        getModalJenis().hide();
                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message);
                        if (res.debug) console.error('Debug:', res.debug);
                    }
                })
                .catch(function(err) {
                    alert('Error: ' + err);
                })
                .finally(function() {
                    btn.disabled = false;
                    btn.textContent = 'Simpan';
                    pendingJenis = null;
                });
        });
    })();
</script>

<?php
if (!function_exists('_badge_status')) {
    function _badge_status($s)
    {
        $map = array(
            'Draft'       => 'secondary',
            'Input Data'  => 'info',
            'Diajukan'    => 'primary',
            'Diproses'    => 'warning',
            'Disetujui'   => 'success',
            'Ditolak'     => 'danger',
            'Selesai'     => 'dark',
        );
        $cls = isset($map[$s]) ? $map[$s] : 'secondary';
        return '<span class="badge bg-' . $cls . ' badge-status">'
            . htmlspecialchars($s) . '</span>';
    }
}
?>