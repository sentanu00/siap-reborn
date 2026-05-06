<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Singkron_postgree extends SB_Controller
{


	public function coba()
	{
		echo "hayo lo";
	}

	function __construct()
	{
		parent::__construct();


		// Inisialisasi koneksi ke database Oracle
		$this->load->database('postgre');
		$this->db->initialize();
	}

	public function sync_data()
	{
		// Contoh query untuk mengambil data pegawai dari database Oracle
		$this->db->where('NIP_BARU', '199306302019031003');
		$query = $this->db->get('pegawai');
		$result = $query->result();
		// echo $result;
		print_r($result);
	}

	public function index()
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');

		// echo "1 gajah";
		$this->load->model('webservice_model');

		// echo "2 gajah";
		// Memperoleh token API MWS
		$this->api_mws_token = $this->webservice_model->getApiMwsToken();

		// echo "2 " . $api_mws_token . " yuhu";

		// Menampilkan token API MWS
		// echo $api_mws_token;

		// Memperoleh token SSO
		$this->sso_token = $this->webservice_model->getSsoToken();

		// Menampilkan token SSO
		// echo $sso_token;

		// Menggunakan token API MWS dan SSO yang telah disimpan dalam sesi
		// $token_apimws = $this->session->userdata('token_apimws');
		// $token_sso = $this->session->userdata('token_sso');


		// echo $token_apimws;
		// echo $token_sso;

		//-----------------------------------------------
		// Memperoleh data utama
		// $data_utama = $this->webservice_model->get_data_utama($this->sso_token, $this->api_mws_token, '199306302019031003');

		// Memperoleh data golongan
		// $data_utama = $this->webservice_model->get_golongan($this->sso_token, $this->api_mws_token, '199306302019031003');

		//----------------------------------------------


		// Menampilkan data utama
		// echo $data_utama['data']['sso_token'] . "<br><br>";
		// echo $data_utama['data']['api_mws_token'] . "<br><br>";
		// echo $data_utama['data']['return'] . "<br><br>";

		// echo $data_utama;
	}

	// Fungsi untuk melakukan operasi update atau insert pada tabel pangkat_riwayat
	public function processGolonganData($nipBaru)
	{


		// echo "1 <br><br>";
		$golonganData = $this->webservice_model->get_golongan($this->sso_token, $this->api_mws_token, $nipBaru);


		$data = json_decode($golonganData, true);

		// echo "2 <br><br>";
		foreach ($data['data'] as $golongan) {

			// echo "3 <br><br>";
			$golonganId = $golongan['golonganId'];
			$tmtGolongan = $golongan['tmtGolongan'];
			$nipBaru = $golongan['nipBaru'];

			// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
			$pegawaiData = $this->db->get_where('pegawai', array('nip_baru' => $nipBaru))->row();

			if ($pegawaiData) {

				// echo "4 <br><br>";
				// Jika data pegawai dengan nip_baru ditemukan
				// Lakukan pengecekan pada tabel pangkat_riwayat berdasarkan PANGKAT_ID
				$existingData = $this->db->get_where('pangkat_riwayat', array(
					'PANGKAT_ID' => $golonganId,
					'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID
				))->row();

				if ($existingData) {

					// echo "5 <br><br>";

					$existingDate = date('Y-m-d', strtotime($existingData->TMT_PANGKAT));
					$tmtDate = date('Y-m-d', strtotime($tmtGolongan));

					// Jika data dengan PANGKAT_ID sudah ada, cek apakah tmtGolongan sama dengan TMT_PANGKAT
					if ($existingDate != $tmtDate) {

						// echo "6 <br><br>";
						// Lakukan operasi update jika tmtGolongan berbeda dengan TMT_PANGKAT
						$this->db->where('PANGKAT_ID', $golonganId)
							->where('PEGAWAI_ID', $pegawaiData->PEGAWAI_ID)
							->update('pangkat_riwayat', array(
								'PANGKAT_ID' => $golongan['golonganId'],
								'NO_NOTA' => $golongan['noPertekBkn'],
								'TANGGAL_NOTA' => date('Y-m-d', strtotime($golongan['tglPertekBkn'])),
								// 'TANGGAL_NOTA' => $golongan['tglPertekBkn'],
								'NO_SK' => $golongan['skNomor'],
								'TANGGAL_SK' => date('Y-m-d', strtotime($golongan['skTanggal'])),
								// 'TANGGAL_SK' => $golongan['skTanggal'],
								'TMT_PANGKAT' => date('Y-m-d', strtotime($golongan['tmtGolongan'])),
								// 'TMT_PANGKAT' => $golongan['tmtGolongan'],
								'KETERANGAN' => "UPDATE BY WS SIASN",
								'MASA_KERJA_TAHUN' => $golongan['masaKerjaGolonganTahun'],
								'MASA_KERJA_BULAN' => $golongan['masaKerjaGolonganBulan'],
								'SIASN_PANGKTAT_ID' => $golongan['id'],
								'SIASN_IDPNS' => $golongan['idPns'],
								'NIPBARU' => $golongan['nipBaru'],
								'JUMLAHKREDITUTAMA' => $golongan['jumlahKreditUtama'],
								'JUMLAHKREDITTAMBAHAN' => $golongan['jumlahKreditTambahan'],
								'JENISKPID' => $golongan['jenisKPId'],

								'TANGGAL_UPDATE' => date('Y-m-d'),
								'LAST_UPDATE_DATE' => date('Y-m-d'),

								'JENISKPNAMA' => $golongan['jenisKPNama']

							));
					}
				} else {

					// echo "7 <br><br>";
					// Jika data dengan PANGKAT_ID belum ada, lakukan operasi insert ke tabel pangkat_riwayat
					$data = array(
						'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
						'PANGKAT_ID' => $golongan['golonganId'],
						'NO_NOTA' => $golongan['noPertekBkn'],
						'TANGGAL_NOTA' => date('Y-m-d', strtotime($golongan['tglPertekBkn'])),
						// 'TANGGAL_NOTA' => $golongan['tglPertekBkn'],
						'NO_SK' => $golongan['skNomor'],
						'TANGGAL_SK' => date('Y-m-d', strtotime($golongan['skTanggal'])),
						// 'TANGGAL_SK' => $golongan['skTanggal'],
						'TMT_PANGKAT' => date('Y-m-d', strtotime($golongan['tmtGolongan'])),
						// 'TMT_PANGKAT' => $golongan['tmtGolongan'],
						'KETERANGAN' => "INSERT BY WS SIASN",
						'MASA_KERJA_TAHUN' => $golongan['masaKerjaGolonganTahun'],
						'MASA_KERJA_BULAN' => $golongan['masaKerjaGolonganBulan'],
						'SIASN_PANGKTAT_ID' => $golongan['id'],
						'SIASN_IDPNS' => $golongan['idPns'],
						'NIPBARU' => $golongan['nipBaru'],
						'JUMLAHKREDITUTAMA' => $golongan['jumlahKreditUtama'],
						'JUMLAHKREDITTAMBAHAN' => $golongan['jumlahKreditTambahan'],
						'JENISKPID' => $golongan['jenisKPId'],

						'LAST_CREATE_DATE' => date('Y-m-d'),

						'JENISKPNAMA' => $golongan['jenisKPNama']
						// Tambahkan field lain yang perlu diisikan
					);

					$this->db->insert('pangkat_riwayat', $data);
				}
			} else {

				// echo "8 <br><br>";
				// Jika data pegawai dengan nip_baru tidak ditemukan
				// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			}

			// echo "9 <br><br>";
		}
	}


	// Fungsi untuk melakukan operasi update atau insert pada tabel pangkat_riwayat
	public function processSkp($nipBaru)
	{
		// $nipBaru = '199306302019031003';

		echo "1 <br><br> gaja";
		$skp22nData = $this->webservice_model->get_skp22($this->sso_token, $this->api_mws_token, $nipBaru);


		$data = json_decode($skp22nData, true);

		// echo "2 <br><br>";
		foreach ($data['data'] as $skp22) {

			// echo "3 <br><br>";
			$tahun = $skp22['tahun'];
			// $nipBaru = $skp22['nipBaru'];

			// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
			$pegawaiData = $this->db->get_where('pegawai', array('nip_baru' => $nipBaru))->row();

			if ($pegawaiData) {

				// echo "4 <br><br>";
				// Jika data pegawai dengan nip_baru ditemukan
				// Lakukan pengecekan pada tabel pangkat_riwayat berdasarkan PANGKAT_ID
				$existingData = $this->db->get_where('skp22', array(
					'tahun' => $tahun,
					'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID
				))->row();

				if ($existingData) {

					// echo "5 <br><br>";

					// $existingDate = date('Y-m-d', strtotime($existingData->TMT_PANGKAT));
					// $tmtDate = date('Y-m-d', strtotime($tmtGolongan));

					// Jika data dengan PANGKAT_ID sudah ada, cek apakah tmtGolongan sama dengan TMT_PANGKAT
					if ($tahun != $existingData->tahun) {

						// echo "6 <br><br>";
						// Lakukan operasi update jika tmtGolongan berbeda dengan TMT_PANGKAT
						$this->db->where('TAHUN', $tahun)
							->where('PEGAWAI_ID', $pegawaiData->PEGAWAI_ID)
							->update('skp22', array(

								// 'id' => $skp22['id'],
								'id' => $skp22['id'],
								'pegawai_id' => $pegawaiData->PEGAWAI_ID,
								'hasilKinerja' => $skp22['hasilKinerja'],
								'hasilKinerjaNilai' => $skp22['hasilKinerjaNilai'],
								'kuadranKinerja' => $skp22['kuadranKinerja'],
								'KuadranKinerjaNilai' => $skp22['KuadranKinerjaNilai'],
								'namaPenilai' => $skp22['namaPenilai'],
								'nipNrpPenilai' => $skp22['nipNrpPenilai'],
								'penilaiGolonganId' => $skp22['penilaiGolonganId'],
								'penilaiJabatanNm' => $skp22['penilaiJabatanNm'],
								'penilaiUnorNm' => $skp22['penilaiUnorNm'],
								'perilakuKerja' => $skp22['perilakuKerja'],
								'PerilakuKerjaNilai' => $skp22['PerilakuKerjaNilai'],
								'pnsDinilaiId' => $skp22['pnsDinilaiId'],
								'nip_baru' => $nipBaru,
								'statusPenilai' => $skp22['statusPenilai'],
								'tahun' => $skp22['tahun'],
								'update_date' => date('Y-m-d')
								// 'insert_date' => $skp22['']

								// 'PANGKAT_ID' => $skp22['golonganId'],
								// 'NO_NOTA' => $skp22['noPertekBkn'],
								// 'TANGGAL_NOTA' => date('Y-m-d', strtotime($skp22['tglPertekBkn'])),
								// 'NO_SK' => $skp22['skNomor'],
								// 'TANGGAL_SK' => date('Y-m-d', strtotime($skp22['skTanggal'])),
								// 'TMT_PANGKAT' => date('Y-m-d', strtotime($skp22['tmtGolongan'])),
								// 'KETERANGAN' => "UPDATE BY WS SIASN",
								// 'MASA_KERJA_TAHUN' => $skp22['masaKerjaGolonganTahun'],
								// 'MASA_KERJA_BULAN' => $skp22['masaKerjaGolonganBulan'],
								// 'SIASN_PANGKTAT_ID' => $skp22['id'],
								// 'SIASN_IDPNS' => $skp22['idPns'],
								// 'NIPBARU' => $skp22['nipBaru'],
								// 'JUMLAHKREDITUTAMA' => $skp22['jumlahKreditUtama'],
								// 'JUMLAHKREDITTAMBAHAN' => $skp22['jumlahKreditTambahan'],
								// 'JENISKPID' => $skp22['jenisKPId'],

								// 'TANGGAL_UPDATE' => date('Y-m-d'),
								// 'LAST_UPDATE_DATE' => date('Y-m-d'),

								// 'JENISKPNAMA' => $skp22['jenisKPNama']

							));
					}
				} else {

					// echo "7 <br><br>";
					// Jika data dengan PANGKAT_ID belum ada, lakukan operasi insert ke tabel pangkat_riwayat
					$data = array(


						// 'id' => $skp22['id'],
						'pegawai_id' => $pegawaiData->PEGAWAI_ID,
						'id' => $skp22['id'],
						'hasilKinerja' => $skp22['hasilKinerja'],
						'hasilKinerjaNilai' => $skp22['hasilKinerjaNilai'],
						'kuadranKinerja' => $skp22['kuadranKinerja'],
						'KuadranKinerjaNilai' => $skp22['KuadranKinerjaNilai'],
						'namaPenilai' => $skp22['namaPenilai'],
						'nipNrpPenilai' => $skp22['nipNrpPenilai'],
						'penilaiGolonganId' => $skp22['penilaiGolonganId'],
						'penilaiJabatanNm' => $skp22['penilaiJabatanNm'],
						'penilaiUnorNm' => $skp22['penilaiUnorNm'],
						'perilakuKerja' => $skp22['perilakuKerja'],
						'PerilakuKerjaNilai' => $skp22['PerilakuKerjaNilai'],
						'pnsDinilaiId' => $skp22['pnsDinilaiId'],
						'nip_baru' => $nipBaru,
						'statusPenilai' => $skp22['statusPenilai'],
						'tahun' => $skp22['tahun'],
						//'update_date' => date('Y-m-d')
						'insert_date' => date('Y-m-d')

						// 'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
						// 'PANGKAT_ID' => $skp22['golonganId'],
						// 'NO_NOTA' => $skp22['noPertekBkn'],
						// 'TANGGAL_NOTA' => date('Y-m-d', strtotime($skp22['tglPertekBkn'])),
						// 'NO_SK' => $skp22['skNomor'],
						// 'TANGGAL_SK' => date('Y-m-d', strtotime($skp22['skTanggal'])),
						// 'TMT_PANGKAT' => date('Y-m-d', strtotime($skp22['tmtGolongan'])),
						// 'KETERANGAN' => "INSERT BY WS SIASN",
						// 'MASA_KERJA_TAHUN' => $skp22['masaKerjaGolonganTahun'],
						// 'MASA_KERJA_BULAN' => $skp22['masaKerjaGolonganBulan'],
						// 'SIASN_PANGKTAT_ID' => $skp22['id'],
						// 'SIASN_IDPNS' => $skp22['idPns'],
						// 'NIPBARU' => $skp22['nipBaru'],
						// 'JUMLAHKREDITUTAMA' => $skp22['jumlahKreditUtama'],
						// 'JUMLAHKREDITTAMBAHAN' => $skp22['jumlahKreditTambahan'],
						// 'JENISKPID' => $skp22['jenisKPId'],

						// 'LAST_CREATE_DATE' => date('Y-m-d'),

						// 'JENISKPNAMA' => $skp22['jenisKPNama']
						// Tambahkan field lain yang perlu diisikan
					);

					$this->db->insert('skp22', $data);
				}
			} else {

				// echo "8 <br><br>";
				// Jika data pegawai dengan nip_baru tidak ditemukan
				// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			}

			// echo "9 <br><br>";
		}
	}


	public function updateGolongan()
	{
		echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->where('tgl_update_golongan <', '2023-05-24')
			->order_by('nip_baru', 'desc')
			->limit(70);
		$query = $this->db->get('pegawai_singkronasi');
		$results = $query->result();
		// echo $results;
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			$this->processGolonganData($row->nip_baru);
			echo $row->nip_baru . " ";

			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_golongan' => date('Y-m-d')]);
		}
	}

	public function updateSkp22()
	{
		echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->where('tgl_update_skp22 <', '2023-05-29')
			->order_by('nip_baru', 'desc')
			->limit(70);
		$query = $this->db->get('pegawai_singkronasi');

		echo "2";
		$results = $query->result();
		echo $results;
		echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			$this->processSkp($row->nip_baru);
			echo $row->nip_baru . " ";

			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_skp22' => date('Y-m-d')]);
		}
	}

	public function singkron_webservice()
	{
		$this->updateSkp22();
	}
}
