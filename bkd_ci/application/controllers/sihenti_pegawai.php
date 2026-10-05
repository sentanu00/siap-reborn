<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sihenti_pegawai extends SB_Controller
{

	protected $layout   = "layouts/main";
	public $module      = 'sihenti_pegawai';
	public $per_page    = '10';
	public $idx         = '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('sihenti_pegawaimodel');
		$this->model = $this->sihenti_pegawaimodel;
		$idx = $this->model->primaryKey;

		$this->info   = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);

		$this->data = array_merge($this->data, array(
			'pageTitle'  => $this->info['title'],
			'pageNote'   => $this->info['note'],
			'pageModule' => 'sihenti_pegawai',
		));

		$this->col = array();
		$this->con = array();
		$inf = $this->info['config']['grid'];
		$inf = SiteHelpers::array_sort($inf, 'sortlist', SORT_ASC);
		$in = 0;
		foreach ($inf as $key => $t) {
			if ($t['view'] == '1') {
				$in++;
				$this->col[$in] = $t['field'];
				$this->con[$in] = $t['conn'];
			}
		}

		if (!$this->session->userdata('logged_in')) redirect('user/login', 301);
	}

	/* =====================================================
     * HALAMAN UTAMA - 2 TABEL
     * (Tabel pegawai dimuat via AJAX, tidak di-query di sini)
     * ===================================================== */
	public function index()
	{
		// ---------- Tabel Atas: Usulan Pemberhentian ----------
		$this->data['usulan_list'] = $this->db
			->select('id, nip, nama, tanggal_usul, jenis_usulan,
                      diusulkan_oleh, tanggal_edit, status_usulan, keterangan')
			->from('usulan_pemberhentian')
			->order_by('tanggal_usul', 'DESC')
			->order_by('id', 'DESC')
			->get()->result();

		// ---------- NIP yang masih punya usulan aktif ----------
		$aktif = $this->db
			->select('nip')
			->from('usulan_pemberhentian')
			->where('status_usulan !=', 'Selesai')
			->get()->result();
		$this->data['nip_aktif'] = array_column($aktif, 'nip');

		// ---------- Opsi Jenis Usulan ----------
		$this->data['jenis_usulan_options'] = array(
			'Pensiun',
			'Pengunduran Diri',
			'Pemberhentian Dengan Hormat',
			'Pemberhentian Tidak Dengan Hormat',
			'Meninggal Dunia',
			'Habis Masa Kontrak',
			'Mutasi',
		);

		// Konfigurasi pagination pegawai
		$this->data['pegawai_per_page'] = 10;

		// ---------- Render view ----------
		$this->data['content'] = $this->load->view(
			'sihenti_pegawai/v_sihenti_pegawai',
			$this->data,
			TRUE
		);

		$this->load->view('layouts/main', $this->data);
	}

	/* =====================================================
 * AJAX: Data Pegawai dengan Pagination + Search
 * Params: page (int), per_page (int), q (string)
 * ===================================================== */
	public function get_pegawai()
	{
		$page     = max(1, (int) $this->input->get('page'));
		$per_page = (int) $this->input->get('per_page');
		$q        = trim($this->input->get('q', TRUE));

		if ($per_page < 1)   $per_page = 10;
		if ($per_page > 100) $per_page = 100;
		$offset = ($page - 1) * $per_page;

		// ---------- Bangun kondisi pencarian (aman dari SQL injection) ----------
		// CI2 tidak punya group_start/group_end → pakai where manual dengan parentheses
		$cond = '';
		if ($q !== '') {
			$q_like = $this->db->escape_like_str($q);   // escape wildcard % dan _
			$cond   = "(p.NIP_BARU LIKE '%{$q_like}%' OR p.NAMA LIKE '%{$q_like}%')";
		}

		// ---------- Hitung total ----------
		$this->db
			->from('pegawai p')
			->join('satker s1', 'p.SATKER_ID = s1.SATKER_ID')
			->join('satker s2', 's1.SATKER_INDUK_ID = s2.SATKER_ID')
			->where_in('p.STATUS_PEGAWAI', array('1', '2', '10', '18'));

		if ($cond !== '') {
			$this->db->where($cond, NULL, FALSE);   // FALSE = jangan di-escape lagi
		}

		$total = $this->db->count_all_results();

		// ---------- Ambil data halaman ini ----------
		$this->db
			->select('p.NIP_BARU, p.NAMA, s1.NAMA AS satker,
                  s2.NAMA AS satker_induk, p.TANGGAL_PENSIUN')
			->from('pegawai p')
			->join('satker s1', 'p.SATKER_ID = s1.SATKER_ID')
			->join('satker s2', 's1.SATKER_INDUK_ID = s2.SATKER_ID')
			->where_in('p.STATUS_PEGAWAI', array('1', '2', '10', '18'));

		if ($cond !== '') {
			$this->db->where($cond, NULL, FALSE);
		}

		$rows = $this->db
			->order_by('p.TANGGAL_PENSIUN', 'DESC')
			->limit($per_page, $offset)
			->get()->result();

		// ---------- NIP yang sudah aktif diusulkan ----------
		$aktif = $this->db
			->select('nip')
			->from('usulan_pemberhentian')
			->where('status_usulan !=', 'Selesai')
			->get()->result();
		$nip_aktif = array();
		foreach ($aktif as $a) {
			$nip_aktif[] = $a->nip;
		}

		// ---------- Susun response ----------
		$data = array();
		foreach ($rows as $r) {
			$data[] = array(
				'nip'             => $r->NIP_BARU,
				'nama'            => $r->NAMA,
				'satker'          => $r->satker,
				'satker_induk'    => $r->satker_induk,
				'tanggal_pensiun' => $r->TANGGAL_PENSIUN,
				'is_aktif'        => in_array($r->NIP_BARU, $nip_aktif),
			);
		}

		return $this->_json(array(
			'status'     => 'success',
			'data'       => $data,
			'total'      => $total,
			'page'       => $page,
			'per_page'   => $per_page,
			'total_page' => (int) ceil($total / $per_page),
			'q'          => $q,
		));
	}
	public function tambah_usulan()
	{
		$nip  = trim($this->input->post('nip', TRUE));
		$nama = trim($this->input->post('nama', TRUE));

		if (empty($nip) || empty($nama)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Data tidak lengkap (nip/nama kosong).'
			));
		}

		// ---------- Cek duplikat usulan aktif ----------
		$cek = $this->db
			->where('nip', $nip)
			->where('status_usulan !=', 'Selesai')
			->get('usulan_pemberhentian')
			->row();

		if ($cek) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => "NIP {$nip} masih memiliki usulan aktif (status: {$cek->status_usulan})."
			));
		}

		// ---------- Siapkan data ----------
		$userNama = $this->session->userdata('nama');
		if (empty($userNama)) $userNama = $this->session->userdata('username');
		if (empty($userNama)) $userNama = 'Administrator';

		$insert = array(
			'nip'            => $nip,
			'nama'           => $nama,
			'tanggal_usul'   => date('Y-m-d'),
			'jenis_usulan'   => 'Pensiun',
			'diusulkan_oleh' => $userNama,
			'status_usulan'  => 'Draft',
			'keterangan'     => NULL,
		);

		// ---------- Eksekusi + tangkap error ----------
		$ok = $this->db->insert('usulan_pemberhentian', $insert);

		if (!$ok) {
			// CI2: pakai method dengan underscore
			$mysqlErr = '';
			if (method_exists($this->db, '_error_message')) {
				$mysqlErr = $this->db->_error_message();
			}

			return $this->_json(array(
				'status'   => 'error',
				'message'  => 'Gagal menyimpan ke database. ' . $mysqlErr,
				'debug'    => array(
					'last_query' => $this->db->last_query(),
					'error'      => $mysqlErr,
				)
			));
		}

		return $this->_json(array(
			'status'  => 'success',
			'message' => "Berhasil menambahkan {$nama} ({$nip}) ke usulan pemberhentian.",
			'id'      => $this->db->insert_id(),
		));
	}

	/* =====================================================
     * AJAX: PILIH JENIS USULAN → status = 'Input Data'
     * ===================================================== */
	public function pilih_jenis_usulan()
	{
		$id    = (int) $this->input->post('id');
		$jenis = $this->input->post('jenis_usulan', TRUE);

		if (!$id || empty($jenis)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Data tidak lengkap (id/jenis_usulan kosong).'
			));
		}

		// Validasi nilai ENUM (biar tidak error MySQL "Data truncated")
		$allowed = array(
			'Pensiun',
			'Pengunduran Diri',
			'Pemberhentian Dengan Hormat',
			'Pemberhentian Tidak Dengan Hormat',
			'Meninggal Dunia',
			'Habis Masa Kontrak',
			'Mutasi',
		);
		if (!in_array($jenis, $allowed)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Jenis usulan tidak valid.'
			));
		}

		// Pastikan barisnya ada
		$row = $this->db->where('id', $id)->get('usulan_pemberhentian')->row();
		if (!$row) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => "Data usulan dengan id {$id} tidak ditemukan."
			));
		}

		// Update
		$this->db->where('id', $id)->update('usulan_pemberhentian', array(
			'jenis_usulan'  => $jenis,
			'status_usulan' => 'Input Data',
			'tanggal_edit'  => date('Y-m-d H:i:s'),
		));

		$err = method_exists($this->db, '_error_message') ? $this->db->_error_message() : '';
		if (!empty($err)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Gagal update: ' . $err,
				'debug'   => array('last_query' => $this->db->last_query())
			));
		}

		return $this->_json(array(
			'status'  => 'success',
			'message' => 'Jenis usulan berhasil dipilih. Status berubah menjadi "Input Data".'
		));
	}

	/* =====================================================
     * HALAMAN DETAIL
     * ===================================================== */
	public function detail($id = NULL)
	{
		if (!$id) redirect('sihenti_pegawai');

		$usulan = $this->db
			->where('id', $id)
			->get('usulan_pemberhentian')->row();

		if (!$usulan) redirect('sihenti_pegawai');

		$this->data['pageTitle'] = 'Detail Usulan Pemberhentian';
		$this->data['usulan']    = $usulan;

		$this->data['content'] = $this->load->view(
			'sihenti_pegawai/v_sihenti_detail',
			$this->data,
			TRUE
		);

		$this->load->view('layouts/main', $this->data);
	}

	/**
	 * Helper JSON + auto-refresh CSRF token
	 * (CI2 regenerasi CSRF setelah POST → hash lama jadi stale)
	 */
	private function _json($arr)
	{
		if (!is_array($arr)) $arr = array();

		// Sertakan CSRF terbaru agar JS selalu punya token valid
		$arr['csrf_name'] = $this->security->get_csrf_token_name();
		$arr['csrf_hash'] = $this->security->get_csrf_hash();

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));

		// Hentikan eksekusi supaya tidak ada output tambahan
		// (bisa di-nonaktifkan kalau ada hook yang perlu jalan)
		// exit;  // <- opsional, aktifkan kalau ada output bocor
	}
}
