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
     * ===================================================== */
	public function index()
	{
		$this->load->model('jenispemberhentianmodel');
		$this->data['jenis_pemberhentian_list'] = $this->db->get('jenis_pemberhentian')->result();

		$this->data['usulan_list'] = $this->db
			->select('
        u.id,
        u.nip,
        u.nama,
        u.tanggal_usul,
        u.jenis_usulan,
        u.diusulkan_oleh,
        u.tanggal_edit,
        u.status_usulan,
        u.keterangan,
        sp.nama AS status_pegawai
    ')
			->from('usulan_pemberhentian u')
			->join('pegawai p', 'p.NIP_BARU = u.nip', 'left')
			->join('status_pegawai sp', 'p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID', 'left')
			->order_by('u.tanggal_usul', 'DESC')
			->order_by('u.id', 'DESC')
			->get()->result();

		$aktif = $this->db
			->select('nip')
			->from('usulan_pemberhentian')
			->where('status_usulan !=', 'Selesai')
			->get()->result();
		$this->data['nip_aktif'] = array_column($aktif, 'nip');

		$this->data['pegawai_per_page'] = 10;

		$this->data['content'] = $this->load->view(
			'sihenti_pegawai/v_sihenti_pegawai',
			$this->data,
			TRUE
		);

		$this->load->view('layouts/main', $this->data);
	}

	/* =====================================================
     * AJAX: Data Pegawai dengan Pagination + Search
     * ===================================================== */
	public function get_pegawai()
	{
		$page     = max(1, (int) $this->input->get('page'));
		$per_page = (int) $this->input->get('per_page');
		$q        = trim($this->input->get('q', TRUE));

		if ($per_page < 1)   $per_page = 10;
		if ($per_page > 100) $per_page = 100;
		$offset = ($page - 1) * $per_page;

		$cond = '';
		if ($q !== '') {
			$q_like = $this->db->escape_like_str($q);
			$cond   = "(p.NIP_BARU LIKE '%{$q_like}%' OR p.NAMA LIKE '%{$q_like}%')";
		}

		$this->db
			->from('pegawai p')
			->join('status_pegawai sp', 'p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID')
			->join('satker s1', 'p.SATKER_ID = s1.SATKER_ID')
			->join('satker s2', 's1.SATKER_INDUK_ID = s2.SATKER_ID')
			->where_in('p.STATUS_PEGAWAI', array('1', '2', '10', '18'));

		if ($cond !== '') {
			$this->db->where($cond, NULL, FALSE);
		}

		$total = $this->db->count_all_results();

		$this->db
			->select('p.NIP_BARU, p.NAMA, sp.nama as status, s1.NAMA AS satker,
                  s2.NAMA AS satker_induk, p.TANGGAL_PENSIUN')
			->from('pegawai p')
			->join('status_pegawai sp', 'p.STATUS_PEGAWAI = sp.STATUS_PEGAWAI_ID')
			->join('satker s1', 'p.SATKER_ID = s1.SATKER_ID')
			->join('satker s2', 's1.SATKER_INDUK_ID = s2.SATKER_ID')
			->where_in('p.STATUS_PEGAWAI', array('1', '2', '10', '18'));

		if ($cond !== '') {
			$this->db->where($cond, NULL, FALSE);
		}

		$rows = $this->db
			->order_by('p.TANGGAL_PENSIUN', 'ASC')
			->limit($per_page, $offset)
			->get()->result();

		$aktif = $this->db
			->select('nip')
			->from('usulan_pemberhentian')
			->where('status_usulan !=', 'Selesai')
			->get()->result();
		$nip_aktif = array_column($aktif, 'nip');

		$data = array();
		foreach ($rows as $r) {
			$data[] = array(
				'nip'             => $r->NIP_BARU,
				'nama'            => $r->NAMA,
				'status'          => $r->status,
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

	/* =====================================================
     * AJAX: TAMBAH USULAN (Menerima NIP, Nama & Jenis Usulan)
     * ===================================================== */
	public function tambah_usulan()
	{
		$nip           = $this->input->post('nip', TRUE);
		$nama          = $this->input->post('nama', TRUE);
		$jenis_usulan  = $this->input->post('jenis_usulan', TRUE);
		$status_pegawai = $this->input->post('status_pegawai', TRUE);

		if (empty($nip) || empty($nama) || empty($jenis_usulan)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Data tidak lengkap (NIP, Nama, atau Jenis Usulan kosong).'
			));
		}

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

		$userNama = $this->session->userdata('nama');
		if (empty($userNama)) $userNama = $this->session->userdata('username');
		if (empty($userNama)) $userNama = 'Administrator';

		$insert = array(
			'nip'            => $nip,
			'nama'           => $nama,
			'status_pegawai' => $status_pegawai,
			'tanggal_usul'   => date('Y-m-d'),
			'jenis_usulan'   => $jenis_usulan,
			'diusulkan_oleh' => $userNama,
			'status_usulan'  => 'Input Data',
			'keterangan'     => NULL,
		);

		$ok = $this->db->insert('usulan_pemberhentian', $insert);

		if (!$ok) {
			$mysqlErr = method_exists($this->db, '_error_message') ? $this->db->_error_message() : '';

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
     * AJAX: PILIH JENIS USULAN
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

		$row = $this->db->where('id', $id)->get('usulan_pemberhentian')->row();
		if (!$row) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => "Data usulan dengan id {$id} tidak ditemukan."
			));
		}

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
			'message' => 'Jenis usulan berhasil dipilih.'
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

		$jenis = $this->db
			->where('jenis', $usulan->jenis_usulan)
			->get('jenis_pemberhentian')->row();

		$detail_list = array();
		if ($jenis) {
			$detail_list = $this->db
				->where('id_siasn_jenis_pemberhentian', (int) $jenis->id_siasn)
				->order_by('detail_pemberhentian', 'ASC')
				->get('detail_pemberhentian')->result();
		}

		$berkas_list = $this->_get_berkas_list($usulan);

		$this->data['pageTitle']   = 'Detail Usulan Pemberhentian';
		$this->data['usulan']      = $usulan;
		$this->data['jenis']       = $jenis;
		$this->data['detail_list'] = $detail_list;
		$this->data['berkas_list'] = $berkas_list;

		$this->data['content'] = $this->load->view(
			'sihenti_pegawai/v_sihenti_detail',
			$this->data,
			TRUE
		);

		$this->load->view('layouts/main', $this->data);
	}

	/* =====================================================
     * AJAX: SIMPAN DETAIL PEMBERHENTIAN
     * ===================================================== */
	public function simpan_detail()
	{
		$id_usulan               = (int) $this->input->post('id_usulan');
		$id_detail_pemberhentian = (int) $this->input->post('id_detail_pemberhentian');

		if (!$id_usulan || !$id_detail_pemberhentian) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Parameter tidak lengkap.'
			));
		}

		$this->db->where('id', $id_usulan)->update('usulan_pemberhentian', array(
			'id_detail_pemberhentian' => $id_detail_pemberhentian,
			'tanggal_edit'            => date('Y-m-d H:i:s'),
		));

		return $this->_json(array(
			'status'  => 'success',
			'message' => 'Detail pemberhentian berhasil disimpan.'
		));
	}

	/* =====================================================
     * AJAX: UPLOAD BERKAS PEGAWAI SYSTEM (SK CPNS, PNS, Pangkat, Jabatan, Gaji, SKP)
     * ===================================================== */
	public function upload_berkas_pegawai()
	{
		$id_usulan = (int) $this->input->post('id_usulan');
		$kode      = $this->input->post('kode_berkas', TRUE);

		if (!$id_usulan || empty($kode)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Parameter tidak lengkap.'
			));
		}

		$config_all = $this->_berkas_config();
		if (!isset($config_all[$kode])) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Kode berkas tidak valid.'
			));
		}
		$cfg = $config_all[$kode];

		$usulan = $this->db->where('id', $id_usulan)
			->get('usulan_pemberhentian')->row();
		if (!$usulan) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Usulan tidak ditemukan.'
			));
		}

		$pegawai = $this->db->select('PEGAWAI_ID')
			->where('NIP_BARU', $usulan->nip)
			->get('pegawai')->row();
		if (!$pegawai) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Data pegawai tidak ditemukan di tabel pegawai.'
			));
		}
		$pegawai_id = $pegawai->PEGAWAI_ID;

		$this->db->select($cfg['pk'] . ' AS id_record');
		$this->db->where('PEGAWAI_ID', $pegawai_id);

		// Pengecekan spesifik untuk SKP (sesuai tahun n-1)
		if ($kode === 'skp') {
			$tahun_lalu = (int) date('Y') - 1;
			$this->db->where('TAHUN', $tahun_lalu);
		} else {
			$this->db->order_by($cfg['kolom_order'], $cfg['order_dir']);
			$this->db->order_by($cfg['pk'], 'DESC');
		}

		$this->db->limit(1);
		$rec = $this->db->get($cfg['tabel'])->row();

		if (!$rec) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Data ' . $cfg['label'] . ' belum ada di database sistem.'
			));
		}

		$nip         = $usulan->nip;
		$upload_path = './dokumen/' . $nip . '/';
		if (!is_dir($upload_path)) {
			@mkdir($upload_path, 0777, TRUE);
		}

		$tgl       = date('Ymd');
		$nama_file = str_replace(
			array('{NIP}', '{TGL}'),
			array($nip, $tgl),
			$cfg['nama_file']
		);

		$config = array(
			'upload_path'   => $upload_path,
			'allowed_types' => 'pdf',
			'max_size'      => 1000,
			'overwrite'     => TRUE,
			'file_name'     => $nama_file,
		);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_berkas')) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Upload gagal: ' . $this->upload->display_errors('', '')
			));
		}

		$this->db->where($cfg['pk'], $rec->id_record);
		$this->db->update($cfg['tabel'], array($cfg['kolom_file'] => $nama_file));

		$err = method_exists($this->db, '_error_message') ? $this->db->_error_message() : '';
		if (!empty($err)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'File terupload, tapi gagal update DB: ' . $err,
				'debug'   => array('last_query' => $this->db->last_query())
			));
		}

		return $this->_json(array(
			'status'   => 'success',
			'message'  => 'Berkas ' . $cfg['label'] . ' berhasil diupload.',
			'file_pdf' => $nama_file,
		));
	}

	/* =====================================================
     * AJAX: UPLOAD DOKUMEN MANUAL (detail_file_pemberhentian)
     * ===================================================== */
	public function upload_berkas_manual()
	{
		$id_usulan   = (int) $this->input->post('id_usulan');
		$kode        = $this->input->post('kode_berkas', TRUE);
		$halaman     = (int) $this->input->post('halaman') ?: 1;

		if (!$id_usulan || empty($kode)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Parameter tidak lengkap.'
			));
		}

		$manual_config = $this->_dokumen_manual_config();
		if (!isset($manual_config[$kode])) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Kode dokumen manual tidak terdaftar.'
			));
		}
		$cfg = $manual_config[$kode];

		$usulan = $this->db->where('id', $id_usulan)->get('usulan_pemberhentian')->row();
		if (!$usulan) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Data usulan tidak ditemukan.'
			));
		}

		$pegawai = $this->db->select('PEGAWAI_ID')->where('NIP_BARU', $usulan->nip)->get('pegawai')->row();
		$pegawai_id = $pegawai ? $pegawai->PEGAWAI_ID : 0;

		$nip         = $usulan->nip;
		$upload_path = './dokumen/' . $nip . '/';
		if (!is_dir($upload_path)) {
			@mkdir($upload_path, 0777, TRUE);
		}

		$tgl       = date('Ymd_His');
		$nama_file = str_replace(array('{NIP}', '{TGL}'), array($nip, $tgl), $cfg['nama_file']);

		$config = array(
			'upload_path'   => $upload_path,
			'allowed_types' => 'pdf',
			'max_size'      => 2048, // 2 MB
			'overwrite'     => TRUE,
			'file_name'     => $nama_file,
		);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_berkas')) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Upload gagal: ' . $this->upload->display_errors('', '')
			));
		}

		// Cek apakah sudah pernah upload berdasarkan nama_dokumen
		$cek = $this->db
			->where('id_usulan', $id_usulan)
			->where('nama_dokumen', $cfg['label'])
			->get('detail_file_pemberhentian')
			->row();

		if ($cek) {
			// Update
			$this->db->where('id', $cek->id)->update('detail_file_pemberhentian', array(
				'nama_file'   => $nama_file,
				'halaman'     => $halaman,
				'updated_at'  => date('Y-m-d H:i:s'),
			));
		} else {
			// Insert Baru
			$this->db->insert('detail_file_pemberhentian', array(
				'id_usulan'     => $id_usulan,
				'fid_pegawai'   => $pegawai_id,
				'jenis_dokumen' => $kode,
				'nama_dokumen'  => $cfg['label'],
				'nama_file'     => $nama_file,
				'halaman'       => $halaman,
				'updated_at'    => date('Y-m-d H:i:s'),
			));
		}

		return $this->_json(array(
			'status'   => 'success',
			'message'  => 'Dokumen ' . $cfg['label'] . ' berhasil diupload.',
			'file_pdf' => $nama_file,
		));
	}

	public function ajukan_usulan()
	{
		$id = (int) $this->input->post('id');
		if (!$id) {
			return $this->_json(array('status' => 'error', 'message' => 'ID tidak valid.'));
		}

		$row = $this->db->where('id', $id)->get('usulan_pemberhentian')->row();
		if (!$row) {
			return $this->_json(array('status' => 'error', 'message' => 'Usulan tidak ditemukan.'));
		}

		if (empty($row->id_detail_pemberhentian)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Pilih detail pemberhentian terlebih dahulu.'
			));
		}

		$berkas_list = $this->_get_berkas_list($row);
		$belum = array();
		foreach ($berkas_list as $b) {
			if ($b['wajib'] && !$b['ada_file']) {
				$belum[] = $b['label'];
			}
		}
		if (!empty($belum)) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Berkas berikut belum lengkap: ' . implode(', ', $belum)
			));
		}

		$this->db->where('id', $id)->update('usulan_pemberhentian', array(
			'status_usulan' => 'Diajukan',
			'tanggal_edit'  => date('Y-m-d H:i:s'),
		));

		return $this->_json(array(
			'status'  => 'success',
			'message' => 'Usulan berhasil diajukan.'
		));
	}

	public function hapus_usulan()
	{
		$id = (int) $this->input->post('id');

		if (!$id) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => 'ID usulan tidak valid.'
			));
		}

		$row = $this->db->where('id', $id)->get('usulan_pemberhentian')->row();
		if (!$row) {
			return $this->_json(array(
				'status'  => 'error',
				'message' => "Data usulan dengan ID {$id} tidak ditemukan."
			));
		}

		$ok = $this->db->where('id', $id)->delete('usulan_pemberhentian');

		if (!$ok) {
			$mysqlErr = method_exists($this->db, '_error_message') ? $this->db->_error_message() : '';

			return $this->_json(array(
				'status'  => 'error',
				'message' => 'Gagal menghapus data dari database. ' . $mysqlErr,
				'debug'   => array('last_query' => $this->db->last_query())
			));
		}

		return $this->_json(array(
			'status'  => 'success',
			'message' => "Usulan pemberhentian untuk {$row->nama} ({$row->nip}) berhasil dihapus."
		));
	}

	private function _json($arr)
	{
		if (!is_array($arr)) $arr = array();

		$arr['csrf_name'] = $this->security->get_csrf_token_name();
		$arr['csrf_hash'] = $this->security->get_csrf_hash();

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));
	}

	/* =====================================================
     * HELPER: Definisi berkas sistem
     * ===================================================== */
	private function _berkas_config()
	{
		return array(
			'sk_cpns' => array(
				'label'       => 'SK CPNS / PPPK',
				'tabel'       => 'sk_cpns',
				'pk'          => 'SK_CPNS_ID',
				'kolom_file'  => 'FILE_PDF',
				'kolom_order' => 'SK_CPNS_ID',
				'order_dir'   => 'DESC',
				'nama_file'   => 'CPNS_SK_{NIP}.pdf',
				'wajib'       => TRUE,
			),
			'sk_pns' => array(
				'label'       => 'SK PNS',
				'tabel'       => 'sk_pns',
				'pk'          => 'SK_PNS_ID',
				'kolom_file'  => 'FILE_PDF',
				'kolom_order' => 'TMT_PNS',
				'order_dir'   => 'DESC',
				'nama_file'   => 'SK_PNS_{NIP}_{TGL}.pdf',
				'wajib'       => TRUE,
			),
			'spmt' => array(
				'label'       => 'SPMT',
				'tabel'       => 'sk_cpns',
				'pk'          => 'SK_CPNS_ID',
				'kolom_file'  => 'FILE_SPMT',
				'kolom_order' => 'SK_CPNS_ID',
				'order_dir'   => 'DESC',
				'nama_file'   => 'SPMT_SK_{NIP}.pdf',
				'wajib'       => TRUE,
			),
			'pangkat' => array(
				'label'       => 'SK Pangkat Terakhir',
				'tabel'       => 'pangkat_riwayat',
				'pk'          => 'PANGKAT_RIWAYAT_ID',
				'kolom_file'  => 'FILE_PDF',
				'kolom_order' => 'TMT_PANGKAT',
				'order_dir'   => 'DESC',
				'nama_file'   => 'SK_KP_{NIP}_{TGL}.pdf',
				'wajib'       => TRUE,
			),
			'jabatan' => array(
				'label'       => 'SK Jabatan Terakhir',
				'tabel'       => 'jabatan_riwayat',
				'pk'          => 'JABATAN_RIWAYAT_ID',
				'kolom_file'  => 'FILE_PDF',
				'kolom_order' => 'TMT_JABATAN',
				'order_dir'   => 'DESC',
				'nama_file'   => 'SK_Jabatan_{NIP}_{TGL}.pdf',
				'wajib'       => TRUE,
			),
			'gaji' => array(
				'label'       => 'SK Gaji Terakhir',
				'tabel'       => 'gaji_riwayat',
				'pk'          => 'GAJI_RIWAYAT_ID',
				'kolom_file'  => 'FILE_PDF',
				'kolom_order' => 'TMT_SK',
				'order_dir'   => 'DESC',
				'nama_file'   => 'SK_Gaji_{NIP}_{TGL}.pdf',
				'wajib'       => TRUE,
			),
			'skp' => array(
				'label'       => 'Penilaian SKP Terakhir',
				'tabel'       => 'skp22',
				'pk'          => 'skp22_id',
				'kolom_file'  => 'FILE_PDF',
				'kolom_order' => 'TAHUN',
				'order_dir'   => 'DESC',
				'nama_file'   => 'SKP_{NIP}_{TGL}.pdf',
				'wajib'       => FALSE,
			),
		);
	}

	/* =====================================================
     * HELPER: Daftar Dokumen Tambahan (Upload Manual)
     * ===================================================== */
	private function _dokumen_manual_config()
	{
		return array(
			'skp' => array(
				'label'     => 'Penilaian SKP Terakhir',
				'nama_file' => 'SKP_{NIP}_{TGL}.pdf',
				'wajib'     => FALSE,
			),
			'sk_jft_pertama' => array(
				'label'     => 'SK PENGANGKATAN PERTAMA DALAM JABATAN FUNGSIONAL',
				'nama_file' => 'SK_JFT1_{NIP}_{TGL}.pdf',
				'wajib'     => FALSE,
			),
			'sk_pmk' => array(
				'label'     => 'SK PENAMBAHAN MASA KERJA (PMK)',
				'nama_file' => 'SK_PMK_{NIP}_{TGL}.pdf',
				'wajib'     => FALSE,
			),
			'buku_tabungan' => array(
				'label'     => 'BUKU TABUNGAN',
				'nama_file' => 'TABUNGAN_{NIP}_{TGL}.pdf',
				'wajib'     => TRUE,
			),
			'surat_kuliah' => array(
				'label'     => 'SURAT KETERANGAN MASIH KULIAH DARI KAMPUS / LEMBAGA BAGI ANAK USIA 21 s/d 25 TAHUN (BELUM MENIKAH / BEKERJA)',
				'nama_file' => 'SURAT_KULIAH_{NIP}_{TGL}.pdf',
				'wajib'     => FALSE,
			),
			'dpcp' => array(
				'label'     => 'DATA PERORANGAN CALON PENERIMA PENSIUN (DPCP)',
				'nama_file' => 'DPCP_{NIP}_{TGL}.pdf',
				'wajib'     => TRUE,
			),
			'usulan_pd' => array(
				'label'     => 'Surat / Usulan pensiun dari Kepala Perangkat Daerah',
				'nama_file' => 'USULAN_PD_{NIP}_{TGL}.pdf',
				'wajib'     => TRUE,
			),
			'sk_tidak_hd' => array(
				'label'     => 'SURAT KETERANGAN TIDAK DIJATUHI HUKUMAN DISIPLIN TINGKAT SEDANG / BERAT',
				'nama_file' => 'SK_TIDAK_HD_{NIP}_{TGL}.pdf',
				'wajib'     => TRUE,
			),
			'akta_kematian_cerai' => array(
				'label'     => 'Akta Kematian / Akta Cerai (bagi PNS yang menikah lebih dari 1 kali)',
				'nama_file' => 'AKTA_NIKAH_CERAI_{NIP}_{TGL}.pdf',
				'wajib'     => FALSE,
			),
		);
	}

	/* =====================================================
     * HELPER: Ambil daftar berkas + status untuk 1 usulan
     * ===================================================== */
	private function _get_berkas_list($usulan)
	{
		$pegawai = $this->db
			->select('PEGAWAI_ID, FOTO_SETENGAH')
			->where('NIP_BARU', $usulan->nip)
			->get('pegawai')
			->row();

		$pegawai_id = $pegawai ? $pegawai->PEGAWAI_ID : NULL;

		// ================================================
		// 1. FOTO, KTP, DAN KK DARI SIAP ONLINE
		// ================================================
		if ($pegawai_id) {
			$nama_foto = $pegawai->FOTO_SETENGAH ?? NULL;

			$list[] = array(
				'kode'             => 'foto',
				'label'            => 'Foto Berwarna',
				'wajib'            => TRUE,
				'id_record'        => NULL,
				'file_pdf'         => $nama_foto,
				'ada_record'       => !empty($nama_foto),
				'ada_file'         => !empty($nama_foto),
				'bisa_upload'      => FALSE,
				'format_nama_file' => $nama_foto ?: '-',
				'link_file'        => !empty($nama_foto)
					? 'https://siap-bkpsdm.probolinggokab.go.id/' . ltrim($nama_foto, '/')
					: NULL,
				'tipe_file'        => 'image',
			);

			$dokumen_config = array(
				'ktp' => array(
					'label' => 'KTP',
					'jenis' => 1,
				),
				'kk' => array(
					'label' => 'Kartu Keluarga (KK)',
					'jenis' => 29,
				),
			);

			foreach ($dokumen_config as $kode => $cfg) {
				$dok = $this->db
					->select('id_dokumen, nama_file')
					->where('fid_jenis_dokumen', $cfg['jenis'])
					->where('fid_pegawai', $pegawai_id)
					->order_by('id_dokumen', 'DESC')
					->limit(1)
					->get('dokumen')
					->row();

				$nama_file = $dok ? $dok->nama_file : NULL;

				$list[] = array(
					'kode'             => $kode,
					'label'            => $cfg['label'],
					'wajib'            => TRUE,
					'id_record'        => $dok ? $dok->id_dokumen : NULL,
					'file_pdf'         => $nama_file,
					'ada_record'       => !empty($nama_file),
					'ada_file'         => !empty($nama_file),
					'bisa_upload'      => FALSE,
					'format_nama_file' => $nama_file ?: '-',
					'link_file'        => !empty($nama_file)
						? 'https://siap-bkpsdm.probolinggokab.go.id/' . ltrim($nama_file, '/')
						: NULL,
					'tipe_file'        => 'dokumen',
				);
			}
		}

		$tgl = date('Ymd');

		// ================================================
		// 2. BERKAS RIWAYAT SISTEM (EXCLUDE SKP)
		// ================================================
		foreach ($this->_berkas_config() as $kode => $cfg) {
			if ($kode === 'skp') continue; // SKP diproses terpisah secara dinamis di bawah

			$item = array(
				'kode'             => $kode,
				'label'            => $cfg['label'],
				'wajib'            => $cfg['wajib'],
				'id_record'        => NULL,
				'file_pdf'         => NULL,
				'ada_record'       => FALSE,
				'ada_file'         => FALSE,
				'bisa_upload'      => FALSE,
				'format_nama_file' => str_replace(
					array('{NIP}', '{TGL}'),
					array($usulan->nip, $tgl),
					$cfg['nama_file']
				),
				'link_file'        => NULL,
			);

			if ($pegawai_id) {
				$this->db->select($cfg['pk'] . ' AS id_record, ' . $cfg['kolom_file'] . ' AS file_pdf');
				$this->db->where('PEGAWAI_ID', $pegawai_id);
				$this->db->order_by($cfg['kolom_order'], $cfg['order_dir']);
				$this->db->order_by($cfg['pk'], 'DESC');
				$this->db->limit(1);
				$row = $this->db->get($cfg['tabel'])->row();

				if ($row) {
					$item['id_record']   = (int) $row->id_record;
					$item['file_pdf']    = $row->file_pdf;
					$item['ada_record']  = TRUE;
					$item['ada_file']    = !empty($row->file_pdf);
					$item['bisa_upload'] = TRUE;

					if (!empty($row->file_pdf)) {
						$item['link_file'] = "https://siap-bkpsdm.probolinggokab.go.id/" . $row->file_pdf;
					}
				}
			}

			$list[] = $item;
		}

		// ================================================
		// 3. DINAMIS: PENGECEKAN SKP PERIODE (TAHUN - 1)
		// ================================================
		$tahun_lalu = (int) date('Y') - 1; // Misal sekarang 2026 -> 2025
		$skp_22     = NULL;

		if ($pegawai_id) {
			$skp_22 = $this->db
				->where('PEGAWAI_ID', $pegawai_id)
				->where('TAHUN', $tahun_lalu)
				->get('skp22')
				->row();
		}

		if ($skp_22) {
			// Mode Sistem: Pegawai punya data SKP22 di tahun (n-1)
			$list[] = array(
				'kode'             => 'skp',
				'label'            => "Penilaian SKP Terakhir ({$tahun_lalu})",
				'wajib'            => FALSE,
				'id_record'        => (int) $skp_22->skp22_id,
				'file_pdf'         => $skp_22->FILE_PDF,
				'ada_record'       => TRUE,
				'ada_file'         => !empty($skp_22->FILE_PDF),
				'bisa_upload'      => TRUE,
				'is_manual'        => FALSE,
				'format_nama_file' => "SKP_{$usulan->nip}_{$tgl}.pdf",
				'link_file'        => !empty($skp_22->FILE_PDF) ? "https://siap-bkpsdm.probolinggokab.go.id/" . $skp_22->FILE_PDF : NULL,
				'tipe_file'        => 'dokumen',
			);
		} else {
			// upload manual jika user tidak punya skp22 di tahun (n-1) di sistem
			$dok_manual = $this->db
				->where('id_usulan', $usulan->id)
				->where('nama_dokumen', 'Penilaian SKP Terakhir')
				->get('detail_file_pemberhentian')
				->row();

			$nama_file = $dok_manual ? $dok_manual->nama_file : NULL;

			$list[] = array(
				'kode'             => 'skp',
				'label'            => 'Penilaian SKP Terakhir',
				'wajib'            => FALSE,
				'id_record'        => $dok_manual ? $dok_manual->id : NULL,
				'file_pdf'         => $nama_file,
				'ada_record'       => !empty($dok_manual),
				'ada_file'         => !empty($nama_file),
				'bisa_upload'      => TRUE,
				'is_manual'        => TRUE,
				'format_nama_file' => "SKP_{$usulan->nip}_{$tgl}.pdf",
				'link_file'        => !empty($nama_file) ? base_url('dokumen/' . $usulan->nip . '/' . $nama_file) : NULL,
				'tipe_file'        => 'dokumen',
			);
		}

		// ================================================
		// 4. DOKUMEN MANUAL LAINNYA
		// ================================================
		foreach ($this->_dokumen_manual_config() as $kode => $cfg) {
			if ($kode === 'skp') continue; 
			$dok_manual = $this->db
				->where('id_usulan', $usulan->id)
				->where('nama_dokumen', $cfg['label'])
				->get('detail_file_pemberhentian')
				->row();

			$nama_file = $dok_manual ? $dok_manual->nama_file : NULL;

			$list[] = array(
				'kode'             => $kode,
				'label'            => $cfg['label'],
				'wajib'            => $cfg['wajib'],
				'id_record'        => $dok_manual ? $dok_manual->id : NULL,
				'file_pdf'         => $nama_file,
				'ada_record'       => !empty($dok_manual),
				'ada_file'         => !empty($nama_file),
				'bisa_upload'      => TRUE,
				'is_manual'        => TRUE,
				'format_nama_file' => str_replace(array('{NIP}', '{TGL}'), array($usulan->nip, $tgl), $cfg['nama_file']),
				'link_file'        => !empty($nama_file) ? base_url('dokumen/' . $usulan->nip . '/' . $nama_file) : NULL,
				'tipe_file'        => 'dokumen',
			);
		}

		return $list;
	}
}