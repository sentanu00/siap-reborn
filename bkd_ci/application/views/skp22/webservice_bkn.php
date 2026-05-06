<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webservice_bkn extends SB_Controller
{


	private $api_mws_token;
	private $sso_token;

	public function coba()
	{
		echo "hayo lo";
	}

	function __construct()
	{
		parent::__construct();
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
					//cek file pdf bkn pada api
					$pathData = $golongan['path'];
					if (!empty($pathData)) {
						foreach ($pathData as $pathId => $pathDetails) {
							$dokId = $pathDetails['dok_id'];
							$dokNama = $pathDetails['dok_nama'];
							$dokUri = $pathDetails['dok_uri'];
							$slug = $pathDetails['slug'];

							// Insert the path details into the database or perform any other desired operations
							// Example SQL statement to insert into the "path_pdf_bkn" table
							// $sql = "INSERT INTO path_pdf_bkn (dok_id, dok_nama, dok_uri, slug) VALUES ('$dokId', '$dokNama', '$dokUri', '$slug')";
							$this->insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug, $golongan['id'], $golongan['idPns'], $golongan['nipBaru']);
							// Execute the SQL statement or perform any other desired operations
							// ...
						}
					}

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

						// $pathData = $golongan['path'];
						// if (!empty($pathData)) {
						// 	foreach ($pathData as $pathId => $pathDetails) {
						// 		$dokId = $pathDetails['dok_id'];
						// 		$dokNama = $pathDetails['dok_nama'];
						// 		$dokUri = $pathDetails['dok_uri'];
						// 		$slug = $pathDetails['slug'];

						// 		// Insert the path details into the database or perform any other desired operations
						// 		// Example SQL statement to insert into the "path_pdf_bkn" table
						// 		// $sql = "INSERT INTO path_pdf_bkn (dok_id, dok_nama, dok_uri, slug) VALUES ('$dokId', '$dokNama', '$dokUri', '$slug')";
						// 		$this->insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug);
						// 		// Execute the SQL statement or perform any other desired operations
						// 		// ...
						// 	}
						// }
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

					// $pathData = $golongan['path'];
					// if (!empty($pathData)) {
					// 	foreach ($pathData as $pathId => $pathDetails) {
					// 		$dokId = $pathDetails['dok_id'];
					// 		$dokNama = $pathDetails['dok_nama'];
					// 		$dokUri = $pathDetails['dok_uri'];
					// 		$slug = $pathDetails['slug'];

					// 		// Insert the path details into the database or perform any other desired operations
					// 		// Example SQL statement to insert into the "path_pdf_bkn" table
					// 		// $sql = "INSERT INTO path_pdf_bkn (dok_id, dok_nama, dok_uri, slug) VALUES ('$dokId', '$dokNama', '$dokUri', '$slug')";
					// 		$this->insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug);
					// 		// Execute the SQL statement or perform any other desired operations
					// 		// ...
					// 	}
					// }
				}
			} else {

				// echo "8 <br><br>";
				// Jika data pegawai dengan nip_baru tidak ditemukan
				// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			}

			// echo "9 <br><br>";
		}
	}


	public function insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug, $api_id, $idPns, $nipBaru)
	{
		// $this->insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug, $golongan['id'],$golongan['idPns'],$golongan['nipBaru']);
		// $dokId = $pathDetails['dok_id'];
		// $dokNama = $pathDetails['dok_nama'];
		// $dokUri = $pathDetails['dok_uri'];
		// $slug = $pathDetails['slug'];

		// Check if the data already exists in the database
		$this->db->where('api_id', $api_id);
		$this->db->where('dok_id', $dok_id);
		$query = $this->db->get('path_pdf_bkn');
		$rowCount = $query->num_rows();

		if ($rowCount > 0) {
			// Data already exists, perform update
			$data = array(
				'dok_nama' => $dokNama,
				'dok_uri' => $dokUri,
				'idPns' => $idPns,
				'nipBaru' => $nipBaru,
				'slug' => $slug
			);
			$this->db->where('dok_id', $dokId);
			$this->db->update('path_pdf_bkn', $data);
		} else {
			// Data does not exist, perform insert
			$data = array(
				'dok_id' => $dokId,
				'dok_nama' => $dokNama,
				'dok_uri' => $dokUri,
				'idPns' => $idPns,
				'nipBaru' => $nipBaru,
				'api_id' => $api_id,
				'slug' => $slug
			);
			$this->db->insert('path_pdf_bkn', $data);
		}

		// Check if the insert or update was successful
		if ($this->db->affected_rows() > 0) {
			echo "Data inserted or updated successfully.";
		} else {
			echo "Error: Failed to insert or update data.";
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
		$this->db->where('tgl_update_golongan <', '2023-06-06')
			->order_by('nip_baru', 'desc');
		// ->limit(70);
		$query = $this->db->get('pegawai_singkronasi');
		$results = $query->result();
		// echo $results;
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			$this->processGolonganData($row->nip_baru);
			// $this->processGolonganData('199306302019031003');
			echo $row->nip_baru . " ";
			// exit();

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


	public function set_pangkat_flag0($nip_baru)
	{

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// set semua flag jadi 0
		$this->db->set('FLAG_DATA_TERAKHIR', '0')
			->where('PEGAWAI_ID', $pegawaiId)
			->update('pangkat_riwayat');

		if ($this->db->affected_rows() > 0) {
			// Update berhasil
			echo "Update 0 berhasil " . $nip_baru . " " . $pegawaiId . " ";
		} else {
			// Update tidak berhasil
			echo "Update 0 tidak berhasil " . $nip_baru . " " . $pegawaiId . " ";
		}
	}

	public function set_jabatan_flag0($nip_baru)
	{

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// set semua flag jadi 0
		$this->db->set('FLAG_DATA_TERAKHIR', '0')
			->where('PEGAWAI_ID', $pegawaiId)
			->update('jabatan_riwayat');

		if ($this->db->affected_rows() > 0) {
			// Update berhasil
			echo "Update 0 berhasil " . $nip_baru . " " . $pegawaiId . " ";
		} else {
			// Update tidak berhasil
			echo "Update 0 tidak berhasil " . $nip_baru . " " . $pegawaiId . " ";
		}
	}

	public function set_pendidikan_flag0($nip_baru)
	{

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// set semua flag jadi 0
		$this->db->set('FLAG_DATA_TERAKHIR', '0')
			->where('PEGAWAI_ID', $pegawaiId)
			->update('pendidikan_riwayat');

		if ($this->db->affected_rows() > 0) {
			// Update berhasil
			echo "Update 0 berhasil " . $nip_baru . " " . $pegawaiId . " ";
		} else {
			// Update tidak berhasil
			echo "Update 0 tidak berhasil " . $nip_baru . " " . $pegawaiId . " ";
		}
	}

	public function set_pangkat_terakhir($nip_baru)
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// echo " 2";

		$query1 = $this->db->query("UPDATE pangkat_riwayat AS pr
		INNER JOIN (
				SELECT pr2.pangkat_riwayat_id
				FROM pangkat_riwayat AS pr2
				LEFT JOIN pegawai p ON pr2.PEGAWAI_ID = p.PEGAWAI_ID
				WHERE p.NIP_BARU = '" . $nip_baru . "'
				AND pr2.TMT_PANGKAT IS NOT NULL
				ORDER BY pr2.tmt_pangkat DESC
				LIMIT 1
		) AS subquery ON pr.PANGKAT_RIWAYAT_ID = subquery.pangkat_riwayat_id
		SET pr.FLAG_DATA_TERAKHIR = '1'");

		// echo "4";
		if ($this->db->affected_rows() > 0) {
			// Query berhasil
			echo "dan Update flag terakhir berhasil " . $nip_baru . "\n";
		} else {
			// Query tidak berhasil
			echo "dan Update flag terakhir tidak berhasil " . $nip_baru . "\n";
		}
		// $result1 = $query1->result();
		// $subquery = $this->db->select('pangkat_riwayat_id')
		// 	->from('pangkat_riwayat')
		// 	->where('PEGAWAI_ID', $pegawaiId)
		// 	->whereNotNull('TMT_PANGKAT')
		// 	->orderBy('TMT_PANGKAT', 'DESC')
		// 	->limit(1)
		// 	->get();

		// echo $result1;

		// $this->db->where('PANGKAT_RIWAYAT_ID', $subquery->row()->pangkat_riwayat_id)
		// 	->set('FLAG_DATA_TERAKHIR', '1')
		// 	->update('pangkat_riwayat');

		// echo " 3";
		// if ($this->db->affected_rows() > 0) {
		// 	// Update berhasil
		// 	echo "dan Update flag terakhir berhasil" . $nip_baru . "<br>";
		// } else {
		// 	// Update tidak berhasil
		// 	echo "dan Update flag terakhir tidak berhasil" . $nip_baru . "<br>";
		// }
	}


	public function set_jabatan_terakhir($nip_baru)
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// echo " 2";

		$query1 = $this->db->query("UPDATE jabatan_riwayat AS pr
		INNER JOIN (
				SELECT pr2.jabatan_riwayat_id
				FROM jabatan_riwayat AS pr2
				LEFT JOIN pegawai p ON pr2.PEGAWAI_ID = p.PEGAWAI_ID
				WHERE p.NIP_BARU = '" . $nip_baru . "'
				AND pr2.TMT_JABATAN IS NOT NULL
				ORDER BY pr2.tmt_jabatan DESC
				LIMIT 1
		) AS subquery ON pr.JABATAN_RIWAYAT_ID = subquery.jabatan_riwayat_id
		SET pr.FLAG_DATA_TERAKHIR = '1'");

		// echo "4";
		if ($this->db->affected_rows() > 0) {
			// Query berhasil
			echo "dan Update flag terakhir berhasil " . $nip_baru . "\n";
		} else {
			// Query tidak berhasil
			echo "dan Update flag terakhir tidak berhasil " . $nip_baru . "\n";
		}
	}

	public function set_pendidikan_terakhir($nip_baru)
	{
		// Mengatur tipe konten header sebagai application/json
		header('Content-Type: application/json');

		$this->db->select('p.PEGAWAI_ID')
			->from('pegawai as p')
			->where('p.NIP_BARU', $nip_baru);
		$query = $this->db->get();
		$result = $query->row();
		$pegawaiId = $result->PEGAWAI_ID;

		// echo " 2";

		$query1 = $this->db->query("UPDATE pendidikan_riwayat AS pr
		INNER JOIN (
				SELECT pr2.pendidikan_riwayat_id
				FROM pendidikan_riwayat AS pr2
				LEFT JOIN pegawai p ON pr2.PEGAWAI_ID = p.PEGAWAI_ID
				WHERE p.NIP_BARU = '" . $nip_baru . "'
				AND pr2.TANGGAL_STTB IS NOT NULL
				ORDER BY pr2.TANGGAL_STTB DESC
				LIMIT 1
		) AS subquery ON pr.PENDIDIKAN_RIWAYAT_ID = subquery.pendidikan_riwayat_id
		SET pr.FLAG_DATA_TERAKHIR = '1'");

		// echo "4";
		if ($this->db->affected_rows() > 0) {
			// Query berhasil
			echo "dan Update flag terakhir berhasil " . $nip_baru . "\n";
		} else {
			// Query tidak berhasil
			echo "dan Update flag terakhir tidak berhasil " . $nip_baru . "\n";
		}
	}


	public function updatepangkatterakhir()
	{
		// echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->select('*')
			->from('pegawai_singkronasi')
			->where('tgl_update_pangkat_terakhir IS NULL')
			->or_where('tgl_update_pangkat_terakhir <', '2023-05-07');
		$query = $this->db->get();

		// echo "2";
		$results = $query->result();
		// echo $results;
		// echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			$this->set_pangkat_flag0($row->nip_baru);
			$this->set_pangkat_terakhir($row->nip_baru);
			// echo $row->nip_baru . " ";
			// exit();
			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_pangkat_terakhir' => date('Y-m-d')]);
		}
	}


	public function wsbkn_rw()
	{

		$pegawaiid = $_GET['pegawaiid'];
		// $nipBaru = $_GET['nipBaru'];
		$jenis_api = $_GET['jenis_api'];
		// echo "1";

		if ($_GET['jenis_api'] == 'refunor') {
			// echo "2";
			$jabatanData = $this->webservice_model->get_rw_wsbkn($this->sso_token, $this->api_mws_token, '', $jenis_api);
			print_r($jabatanData);
			exit();
		}

		if (empty($_GET['pegawaiid'])) {
			// echo "2";
			$peringatan['code'] = 0;
			$peringatan['keterangan'] = 'Pegawai id tidak diisi';
			$json = json_encode($peringatan);
			echo $json;
			exit();
		}
		// echo "3";

		// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
		$pegawaiData = $this->db->get_where('pegawai', array('pegawai_id' => $pegawaiid))->row();
		if ($pegawaiData) {
			$nipBaru = $pegawaiData->NIP_BARU;
		} else {
			$peringatan['code'] = 0;
			$peringatan['keterangan'] = 'Pegawai id tidak ditemukan';
			$json = json_encode($peringatan);
			echo $json;
			exit();
		}

		$jabatanData = $this->webservice_model->get_rw_wsbkn($this->sso_token, $this->api_mws_token, $nipBaru, $jenis_api);

		print_r($jabatanData);
	}



	public function download_pdf()
	{

		$filePath = $_GET['filePath'];
		// $nipBaru = $_GET['nipBaru'];
		// $jenis_api = $_GET['jenis_api'];

		// $nipBaru = '199306302019031003';
		// echo "1 <br><br>";
		// $hasil = new stdClass();
		$jabatanData = $this->webservice_model->get_pdf_siasn($this->sso_token, $this->api_mws_token, $filePath);
		$hasil['token_sso'] = 'bearer ' . $this->sso_token;
		$hasil['token_api_mws'] = 'Bearer ' . $this->api_mws_token;
		$hasil['hasil'] = $jabatanData;
		// $json = json_encode($hasil);
		// print_r($jabatanData);

		print_r($hasil);
		// exit();
	}

	public function wsbkn_rw_f($nipBaru, $jenis_api)
	{

		$jabatanData = $this->webservice_model->get_rw_wsbkn($this->sso_token, $this->api_mws_token, $nipBaru, $jenis_api);

		return $jabatanData;
	}
	// Fungsi untuk melakukan operasi update atau insert pada tabel jabatan
	public function processJabatanData($nipBaru)
	{
		// $nipBaru = '199306302019031003';
		// echo "1 <br><br>";
		$jabatanData = $this->wsbkn_rw_f($nipBaru, 'jabatan');
		// print_r($jabatanData);
		// echo $jabatanData;
		// exit();	

		$data = json_decode($jabatanData, true);
		// echo "2 <br><br>";
		foreach ($data['data'] as $jabatan) {
			// echo "3 <br><br>";
			// $golonganId = $golongan['golonganId'];
			$tmtJabatan = $jabatan['tmtJabatan'];
			$nipBaru = $jabatan['nipBaru'];
			// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
			$pegawaiData = $this->db->get_where('pegawai', array('nip_baru' => $nipBaru))->row();
			if ($pegawaiData) {
				// echo "4 <br><br>";
				// Jika data pegawai dengan nip_baru ditemukan
				// Lakukan pengecekan pada tabel pangkat_riwayat berdasarkan PANGKAT_ID
				$existingData = $this->db->get_where('jabatan_riwayat', array(
					'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
					'DATE_FORMAT(TMT_JABATAN, "%Y-%m") =' => date('Y-m', strtotime($tmtJabatan))
				))->row();
				if ($existingData) {
					// echo "5 <br><br>";
					// $existingDate = date('Y-m', strtotime($existingData->TMT_JABATAN));
					// $tmtDate = date('Y-m', strtotime($tmtJabatan));
					// Jika data dengan PANGKAT_ID sudah ada, cek apakah tmtGolongan sama dengan TMT_PANGKAT
					// if ($existingDate != $tmtDate) {
					// echo "6 <br><br>";
					// Lakukan operasi update jika tmtGolongan berbeda dengan TMT_PANGKAT
					$namaJabatan = $jabatan['namaJabatan'];
					$jabatanFungsionalNama = $jabatan['jabatanFungsionalNama'];
					$jabatanFungsionalUmumNama = $jabatan['jabatanFungsionalUmumNama'];
					$satuanKerjaNama = $jabatan['satuanKerjaNama'];

					if (empty($namaJabatan)) {
						$namaJabatan = !empty($jabatanFungsionalNama) ? $jabatanFungsionalNama : (!empty($jabatanFungsionalUmumNama) ? $jabatanFungsionalUmumNama : ('Kepala ' . $satuanKerjaNama));
					}

					$this->db
						->where('PEGAWAI_ID', $pegawaiData->PEGAWAI_ID)
						->where('DATE_FORMAT(TMT_JABATAN, "%Y-%m") =', date('Y-m', strtotime($tmtJabatan)))
						->update(
							'jabatan_riwayat',
							array(
								'NO_SK' => $jabatan['nomorSk'],
								'TANGGAL_SK' => date('Y-m-d', strtotime($jabatan['tanggalSk'])),
								'TMT_JABATAN' => date('Y-m-d', strtotime($jabatan['tmtJabatan'])),
								// 'NAMA' => $jabatan['namaJabatan'],
								'NAMA' => $namaJabatan,
								'TANGGAL_PELANTIKAN' => date('Y-m-d', strtotime($jabatan['tmtPelantikan'])),
								'RW_JABATAN_ID_SAPK' => $jabatan['id'],
								'JENIS_JABATAN_SAPK' => $jabatan['jenisJabatan'],
								'INSTANSI_KERJA_ID_SAPK' => $jabatan['instansiKerjaId'],
								'INSTANSI_KERJA_NAMA_SAPK' => $jabatan['instansiKerjaNama'],
								'SATUAN_KERJA_ID_SAPK' => $jabatan['satuanKerjaId'],
								'SATUAN_KERJA_NAMA_SAPK' => $jabatan['satuanKerjaNama'],
								'UNOR_ID_SAPK' => $jabatan['unorId'],
								'UNOR_NAMA_SAPK' => $jabatan['unorNama'],
								'JFT_ID_SAPK' => $jabatan['jabatanFungsionalId'],
								'JFT_NAMA_SAPK' => $jabatan['jabatanFungsionalNama'],
								'JFU_ID_SAPK' => $jabatan['jabatanFungsionalUmumId'],
								'JFU_NAMA_SAPK' => $jabatan['jabatanFungsionalUmumNama'],
								'unorIndukIdSapk' => $jabatan['unorIndukId'],
								'unorIndukNama' => $jabatan['unorIndukNama'],
								'eselonNama' => $jabatan['eselon'],
								'eselonIdSAPK' => $jabatan['eselonId'],
								'idPns' => $jabatan['idPns'],
								'nipBaru' => $jabatan['nipBaru'],
								'nipLama' => $jabatan['nipLama'],
								'namaUnor' => $jabatan['namaUnor'],
								// 'LAST_CREATE_USER' => $jabatan['0'],
								// 'LAST_CREATE_DATE' => $jabatan['0'],
								'LAST_UPDATE_USER' => 'wssiasn',
								'TANGGAL_UPDATE' => date('Y-m-d'),
								'LAST_UPDATE_DATE' => date('Y-m-d'),
								'KETERANGAN_DATA' => 'UPDATE BY WS SIASN'

							)
						);
					// }
				} else {
					// echo "7 <br><br>";
					// Jika data dengan PANGKAT_ID belum ada, lakukan operasi insert ke tabel pangkat_riwayat

					$namaJabatan = $jabatan['namaJabatan'];
					$jabatanFungsionalNama = $jabatan['jabatanFungsionalNama'];
					$jabatanFungsionalUmumNama = $jabatan['jabatanFungsionalUmumNama'];
					$satuanKerjaNama = $jabatan['satuanKerjaNama'];

					if (empty($namaJabatan)) {
						$namaJabatan = !empty($jabatanFungsionalNama) ? $jabatanFungsionalNama : (!empty($jabatanFungsionalUmumNama) ? $jabatanFungsionalUmumNama : ('Kepala ' . $satuanKerjaNama));
					}

					$data = array(
						'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
						'NO_SK' => $jabatan['nomorSk'],
						'TANGGAL_SK' => date('Y-m-d', strtotime($jabatan['tanggalSk'])),
						'TMT_JABATAN' => date('Y-m-d', strtotime($jabatan['tmtJabatan'])),
						// 'NAMA' => $jabatan['namaJabatan'],
						'NAMA' => $namaJabatan,
						'TANGGAL_PELANTIKAN' => date('Y-m-d', strtotime($jabatan['tmtPelantikan'])),
						'RW_JABATAN_ID_SAPK' => $jabatan['id'],
						'JENIS_JABATAN_SAPK' => $jabatan['jenisJabatan'],
						'INSTANSI_KERJA_ID_SAPK' => $jabatan['instansiKerjaId'],
						'INSTANSI_KERJA_NAMA_SAPK' => $jabatan['instansiKerjaNama'],
						'SATUAN_KERJA_ID_SAPK' => $jabatan['satuanKerjaId'],
						'SATUAN_KERJA_NAMA_SAPK' => $jabatan['satuanKerjaNama'],
						'UNOR_ID_SAPK' => $jabatan['unorId'],
						'UNOR_NAMA_SAPK' => $jabatan['unorNama'],
						'JFT_ID_SAPK' => $jabatan['jabatanFungsionalId'],
						'JFT_NAMA_SAPK' => $jabatan['jabatanFungsionalNama'],
						'JFU_ID_SAPK' => $jabatan['jabatanFungsionalUmumId'],
						'JFU_NAMA_SAPK' => $jabatan['jabatanFungsionalUmumNama'],
						'unorIndukIdSapk' => $jabatan['unorIndukId'],
						'unorIndukNama' => $jabatan['unorIndukNama'],
						'eselonNama' => $jabatan['eselon'],
						'eselonIdSAPK' => $jabatan['eselonId'],
						'idPns' => $jabatan['idPns'],
						'nipBaru' => $jabatan['nipBaru'],
						'nipLama' => $jabatan['nipLama'],
						'namaUnor' => $jabatan['namaUnor'],
						'LAST_CREATE_USER' => 'wssiasn',
						'LAST_CREATE_DATE' =>  date('Y-m-d'),
						// 'LAST_UPDATE_USER' => 'wssiasn',
						// 'LAST_UPDATE_DATE' => date('Y-m-d'),
						'KETERANGAN_DATA' => 'INSERT BY WS SIASN'

					);
					$this->db->insert('jabatan_riwayat', $data);
				}
			} else {
				// echo "8 <br><br>";
				// Jika data pegawai dengan nip_baru tidak ditemukan
				// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			}
			// echo "9 <br><br>";
		}
	}

	public function processPendidikanData($nipBaru)
	{
		// $nipBaru = '199306302019031003';
		// echo "1 <br><br>";
		$pendidikanData = $this->wsbkn_rw_f($nipBaru, 'pendidikan');
		// print_r($jabatanData);
		// echo $jabatanData;
		// exit();	

		$data = json_decode($pendidikanData, true);
		// echo "2 <br><br>";
		foreach ($data['data'] as $pendidikan) {
			// echo "3 <br><br>";
			// $golonganId = $golongan['golonganId'];
			$tglLulus = $pendidikan['tglLulus'];
			$nipBaru = $pendidikan['nipBaru'];
			// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
			$pegawaiData = $this->db->get_where('pegawai', array('nip_baru' => $nipBaru))->row();
			if ($pegawaiData) {
				// echo "4 <br><br>";
				// Jika data pegawai dengan nip_baru ditemukan
				// Lakukan pengecekan pada tabel pangkat_riwayat berdasarkan PANGKAT_ID
				$existingData = $this->db->get_where('pendidikan_riwayat', array(
					'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
					'DATE_FORMAT(TANGGAL_STTB, "%Y") =' => date('Y', strtotime($tglLulus))
				))->row();
				if ($existingData) {
					// echo "5 <br><br>";

					$pendidikanId = $pendidikan['tkPendidikanId'];
					$nilaipendidikanid = '';

					switch ($pendidikanId) {
						case '5':
							$nilaipendidikanid = '1';
							break;
						case '10':
						case '12':
							$nilaipendidikanid = '2';
							break;
						case '15':
						case '17':
						case '18':
							$nilaipendidikanid = '4';
							break;
						case '20':
							$nilaipendidikanid = '5';
							break;
						case '25':
							$nilaipendidikanid = '6';
							break;
						case '30':
							$nilaipendidikanid = '7';
							break;
						case '35':
							$nilaipendidikanid = '8';
							break;
						case '40':
							$nilaipendidikanid = '9';
							break;
						case '45':
							$nilaipendidikanid = '10';
							break;
						case '50':
							$nilaipendidikanid = '11';
							break;
					}

					// echo $nilaipendidikanid;

					$this->db
						->where('PEGAWAI_ID', $pegawaiData->PEGAWAI_ID)
						->where('DATE_FORMAT(TANGGAL_STTB, "%Y-%m") =', date('Y-m', strtotime($tglLulus)))
						->update(
							'pendidikan_riwayat',
							array(
								'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
								'PENDIDIKAN_ID' => $nilaipendidikanid,
								'NAMA' => $pendidikan['pendidikanNama'],
								'TEMPAT' => $pendidikan['namaSekolah'],
								'NO_STTB' => $pendidikan['nomorIjasah'],

								// 'TANGGAL_PELANTIKAN' => date('Y-m-d', strtotime($jabatan['tmtPelantikan'])),
								'TANGGAL_STTB' => date('Y-m-d', strtotime($pendidikan['tglLulus'])),
								// 'LAST_CREATE_USER' => $pendidikan['isi'],
								// 'LAST_CREATE_DATE' => $pendidikan['isi'],
								'LAST_UPDATE_USER' => 'wssiasn',
								'LAST_UPDATE_DATE' => date('Y-m-d'),
								'id_Sapk' => $pendidikan['id'],
								'idPns' => $pendidikan['idPns'],
								'nipBaru' => $pendidikan['nipBaru'],
								'nipLama' => $pendidikan['nipLama'],
								'pendidikanId' => $pendidikan['pendidikanId'],
								'tkPendidikanId' => $pendidikan['tkPendidikanId'],
								'tkPendidikanNama' => $pendidikan['tkPendidikanNama'],
								'tahunLulus' => $pendidikan['tahunLulus'],
								'isPendidikanPertama' => $pendidikan['isPendidikanPertama'],
								'gelarDepan' => $pendidikan['gelarDepan'],
								'gelarBelakang' => $pendidikan['gelarBelakang'],
								'KETERANGAN' => 'UPDATE BY WS SIASN'


							)
						);
					// }
				} else {
					// echo "7 <br><br>";
					$pendidikanId = $pendidikan['tkPendidikanId'];
					$nilaipendidikanid = '';

					switch ($pendidikanId) {
						case '5':
							$nilaipendidikanid = '1';
							break;
						case '10':
						case '12':
							$nilaipendidikanid = '2';
							break;
						case '15':
						case '17':
						case '18':
							$nilaipendidikanid = '4';
							break;
						case '20':
							$nilaipendidikanid = '5';
							break;
						case '25':
							$nilaipendidikanid = '6';
							break;
						case '30':
							$nilaipendidikanid = '7';
							break;
						case '35':
							$nilaipendidikanid = '8';
							break;
						case '40':
							$nilaipendidikanid = '9';
							break;
						case '45':
							$nilaipendidikanid = '10';
							break;
						case '50':
							$nilaipendidikanid = '11';
							break;
					}

					$data = array(

						'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
						'PENDIDIKAN_ID' => $nilaipendidikanid,
						'NAMA' => $pendidikan['pendidikanNama'],
						'TEMPAT' => $pendidikan['namaSekolah'],
						'NO_STTB' => $pendidikan['nomorIjasah'],
						'TANGGAL_STTB' => date('Y-m-d', strtotime($pendidikan['tglLulus'])),
						'LAST_CREATE_USER' => 'wssiasn',

						// 'TANGGAL_PELANTIKAN' => date('Y-m-d', strtotime($jabatan['tmtPelantikan'])),
						'LAST_CREATE_DATE' => date('Y-m-d'),
						// 'LAST_UPDATE_USER' => 'wssiasn',
						// 'LAST_UPDATE_DATE' => date('Y-m-d'),
						'id_Sapk' => $pendidikan['id'],
						'idPns' => $pendidikan['idPns'],
						'nipBaru' => $pendidikan['nipBaru'],
						'nipLama' => $pendidikan['nipLama'],
						'pendidikanId' => $pendidikan['pendidikanId'],
						'tkPendidikanId' => $pendidikan['tkPendidikanId'],
						'tkPendidikanNama' => $pendidikan['tkPendidikanNama'],
						'tahunLulus' => $pendidikan['tahunLulus'],
						'isPendidikanPertama' => $pendidikan['isPendidikanPertama'],
						'gelarDepan' => $pendidikan['gelarDepan'],
						'gelarBelakang' => $pendidikan['gelarBelakang'],
						'KETERANGAN' => 'INSERT BY WS SIASN'


					);
					$this->db->insert('pendidikan_riwayat', $data);
				}
			} else {
				// echo "8 <br><br>";
				// Jika data pegawai dengan nip_baru tidak ditemukan
				// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			}
			// echo "9 <br><br>";
		}
	}


	public function processDiklatData($nipBaru)
	{
		// $nipBaru = '199306302019031003';
		// echo "1 <br><br>";
		$diklatData = $this->wsbkn_rw_f($nipBaru, 'diklat');
		// print_r($jabatanData);
		// echo $jabatanData;
		// exit();	

		$data = json_decode($diklatData, true);
		// echo "2 <br><br>";
		foreach ($data['data'] as $diklat) {
			// echo "3 <br><br>";
			$tglLulus = $diklat['tanggal'];
			$nipBaru = $diklat['nipBaru'];
			// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
			$pegawaiData = $this->db->get_where('pegawai', array('nip_baru' => $nipBaru))->row();
			if ($pegawaiData) {
				// echo "4 <br><br>";
				// Jika data pegawai dengan nip_baru ditemukan
				// Lakukan pengecekan pada tabel pangkat_riwayat berdasarkan PANGKAT_ID
				$existingData = $this->db->get_where('diklat_struktural', array(
					'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
					'DATE_FORMAT(TANGGAL_STTPP, "%Y-%m-%d") =' => date('Y-m-d', strtotime($tglLulus))
				))->row();
				if ($existingData) {
					// echo "5 <br><br>";

					$diklatId = $diklat['latihanStrukturalId'];
					$nilaidiklatid = '';

					switch ($diklatId) {
						case '1':
							$nilaidiklatid = '1';
							break;
						case '2':
							$nilaidiklatid = '2';
							break;
						case '3':
							$nilaidiklatid = '3';
							break;
						case '4':
							$nilaidiklatid = '4';
							break;
						case '5':
							$nilaidiklatid = '5';
							break;
						case '6':
							$nilaidiklatid = '7';
							break;
						case '7':
							$nilaidiklatid = '8';
							break;
						case '8':
							$nilaidiklatid = '0';
							break;
					}
					// echo $nilaidiklatid;

					$this->db
						->where('PEGAWAI_ID', $pegawaiData->PEGAWAI_ID)
						->where('DATE_FORMAT(TANGGAL_STTPP, "%Y-%m-%d") =', date('Y-m-d', strtotime($tglLulus)))
						->update(
							'diklat_struktural',
							array(
								'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
								'DIKLAT_ID' => $nilaidiklatid,
								'PENYELENGGARA' => $diklat['institusiPenyelenggara'],
								'TAHUN' => $diklat['tahun'],
								'TANGGAL_SELESAI' => date('Y-m-d', strtotime($diklat['tanggalSelesai'])),
								'TANGGAL_STTPP' => date('Y-m-d', strtotime($diklat['tanggal'])),

								'id_sapk' => $diklat['id'],
								'idPns' => $diklat['idPns'],
								'nipBaru' => $diklat['nipBaru'],
								'nipLama' => $diklat['nipLama'],
								'latihanStrukturalId' => $diklat['latihanStrukturalId'],
								'latihanStrukturalNama' => $diklat['idPlatihanStrukturalNamans'],
								'nomor' => $diklat['nomor'],
								'NO_STTPP' => $diklat['nomor'],
								'LAST_UPDATE_USER' => 'wssiasn',
								'LAST_UPDATE_DATE' => date('Y-m-d'),
								// 'LAST_CREATE_USER' => 'wssiasn',
								// 'LAST_CREATE_DATE' => date('Y-m-d'),
								'KETERANGAN' => 'UPDATE BY WS SIASN'


							)
						);
					// }
				} else {
					// echo "7 <br><br>";
					$diklatId = $diklat['latihanStrukturalId'];
					$nilaidiklatid = '';

					switch ($diklatId) {
						case '1':
							$nilaidiklatid = '1';
							break;
						case '2':
							$nilaidiklatid = '2';
							break;
						case '3':
							$nilaidiklatid = '3';
							break;
						case '4':
							$nilaidiklatid = '4';
							break;
						case '5':
							$nilaidiklatid = '5';
							break;
						case '6':
							$nilaidiklatid = '7';
							break;
						case '7':
							$nilaidiklatid = '8';
							break;
						case '8':
							$nilaidiklatid = '0';
							break;
					}

					$data = array(

						'PEGAWAI_ID' => $pegawaiData->PEGAWAI_ID,
						'DIKLAT_ID' => $nilaidiklatid,
						'PENYELENGGARA' => $diklat['institusiPenyelenggara'],
						'TAHUN' => $diklat['tahun'],
						'TANGGAL_SELESAI' => date('Y-m-d', strtotime($diklat['tanggalSelesai'])),
						'TANGGAL_STTPP' => date('Y-m-d', strtotime($diklat['tanggal'])),

						'id_sapk' => $diklat['id'],
						'idPns' => $diklat['idPns'],
						'nipBaru' => $diklat['nipBaru'],
						'nipLama' => $diklat['nipLama'],
						'latihanStrukturalId' => $diklat['latihanStrukturalId'],
						'latihanStrukturalNama' => $diklat['idPlatihanStrukturalNamans'],
						'nomor' => $diklat['nomor'],
						'NO_STTPP' => $diklat['nomor'],
						// 'LAST_UPDATE_USER' => 'wssiasn',
						// 'LAST_UPDATE_DATE' => date('Y-m-d'),
						'LAST_CREATE_USER' => 'wssiasn',
						'LAST_CREATE_DATE' => date('Y-m-d'),
						'KETERANGAN' => 'INSERT BY WS SIASN'
					);
					$this->db->insert('diklat_struktural', $data);
				}
			} else {
				// echo "8 <br><br>";
				// Jika data pegawai dengan nip_baru tidak ditemukan
				// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			}
			// echo "9 <br><br>";
		}
	}


	public function singkronjabatansiasn()
	{
		echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->select('*')
			->from('pegawai_singkronasi')
			->where('tgl_update_jabatan IS NULL')
			->or_where('tgl_update_jabatan <', '2023-05-07');
		$query = $this->db->get();

		echo "2";
		$results = $query->result();
		// echo $results;
		echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			echo "4";
			$this->processJabatanData($row->nip_baru);
			echo "5";
			$this->set_jabatan_flag0($row->nip_baru);
			echo "6";
			$this->set_jabatan_terakhir($row->nip_baru);
			// echo $row->nip_baru . " ";
			// exit();
			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_jabatan' => date('Y-m-d')]);
		}
	}

	public function singkronpendidikansiasn()
	{
		echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->select('*')
			->from('pegawai_singkronasi')
			->where('tgl_update_pendidikan IS NULL')
			->or_where('tgl_update_pendidikan <', '2023-05-07');
		$query = $this->db->get();

		echo "2";
		$results = $query->result();
		// echo $results;
		echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			echo "4";
			$this->processpendidikanData($row->nip_baru);
			echo "5";
			$this->set_pendidikan_flag0($row->nip_baru);
			echo "6";
			$this->set_pendidikan_terakhir($row->nip_baru);
			// echo $row->nip_baru . " ";
			// exit();
			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_pendidikan' => date('Y-m-d')]);
		}
	}

	public function singkrondiklatsiasn()
	{
		echo "1";
		// Ambil data pegawai_singkronasi yang memenuhi kriteria
		$this->db->select('*')
			->from('pegawai_singkronasi')
			->where('tgl_update_diklat IS NULL')
			->or_where('tgl_update_diklat <', '2023-05-07');
		$query = $this->db->get();

		echo "2";
		$results = $query->result();
		// echo $results;
		echo "3";
		// Perulangan dan pembaruan tanggal
		foreach ($results as $row) {

			echo " - " . $row->nip_baru;
			$this->processDiklatData($row->nip_baru);
			// echo "5";
			// $this->set_pendidikan_flag0($row->nip_baru);
			// echo "6";
			// $this->set_pendidikan_terakhir($row->nip_baru);
			// echo $row->nip_baru . " ";
			// exit();
			// Update tanggal tgl_update_golongan menjadi tanggal sekarang
			$this->db->where('pegawai_id', $row->pegawai_id)
				->update('pegawai_singkronasi', ['tgl_update_diklat' => date('Y-m-d')]);
		}
	}


	// 


	// public function getRWData($rwData, $nipBaru)
	// {
	// 	$hasil = $this->webservice_model->get_angkakredit($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_cltn($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_diklat($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_dp3($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_golongan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_hukdis($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_jabatan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_kursus($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_masakerja($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_pemberhentian($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_pendidikan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_penghargaan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_pindahinstansi($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_pnsunor($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_pwk($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_skp($this->sso_token, $this->api_mws_token, $nipBaru);
	// 	$hasil = $this->webservice_model->get_skp22($this->sso_token, $this->api_mws_token, $nipBaru);
	// }

	// public function getRWData($rw, $nipBaru)
	// {
	// 	$hasil = null;

	// 	switch ($rw) {
	// 		case 'angkakredit':
	// 			$hasil = $this->webservice_model->get_angkakredit($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'cltn':
	// 			$hasil = $this->webservice_model->get_cltn($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'diklat':
	// 			$hasil = $this->webservice_model->get_diklat($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'dp3':
	// 			$hasil = $this->webservice_model->get_dp3($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'golongan':
	// 			$hasil = $this->webservice_model->get_golongan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'hukdis':
	// 			$hasil = $this->webservice_model->get_hukdis($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'jabatan':
	// 			$hasil = $this->webservice_model->get_jabatan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'kursus':
	// 			$hasil = $this->webservice_model->get_kursus($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'masakerja':
	// 			$hasil = $this->webservice_model->get_masakerja($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'pemberhentian':
	// 			$hasil = $this->webservice_model->get_pemberhentian($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'pendidikan':
	// 			$hasil = $this->webservice_model->get_pendidikan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'penghargaan':
	// 			$hasil = $this->webservice_model->get_penghargaan($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'pindahinstansi':
	// 			$hasil = $this->webservice_model->get_pindahinstansi($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'pnsunor':
	// 			$hasil = $this->webservice_model->get_pnsunor($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'pwk':
	// 			$hasil = $this->webservice_model->get_pwk($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'skp':
	// 			$hasil = $this->webservice_model->get_skp($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		case 'skp22':
	// 			$hasil = $this->webservice_model->get_skp22($this->sso_token, $this->api_mws_token, $nipBaru);
	// 			break;
	// 		default:
	// 			// Penanganan jika $rw tidak cocok dengan nilai yang diharapkan
	// 			$hasil['rw'] = array(
	// 				"angkakredit",
	// 				"cltn",
	// 				"diklat",
	// 				"dp3",
	// 				"golongan",
	// 				"hukdis",
	// 				"jabatan",
	// 				"kursus",
	// 				"masakerja",
	// 				"pemberhentian",
	// 				"pendidikan",
	// 				"penghargaan",
	// 				"pindahinstansi",
	// 				"pnsunor",
	// 				"pwk",
	// 				"skp",
	// 				"skp22"
	// 			);
	// 			break;
	// 	}
	// 	return $hasil;
	// }


	public function post_jabatan_2($sso_token, $api_mws_token, $eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, $dok_uri, $object)
	// public function post_jabatan()
	{
		$this->api_mws_token = $this->webservice_model->getApiMwsToken();

		$this->sso_token = $this->webservice_model->getSsoToken();
		// $eselonId = $this->input->post('eselonId');
		// $instansiId = $this->input->post('instansiId');
		// $jabatanFungsionalId = $this->input->post('jabatanFungsionalId');
		// $jabatanFungsionalUmumId = $this->input->post('jabatanFungsionalUmumId');
		// $jenisJabatan = $this->input->post('jenisJabatan');
		// $nomorSk = $this->input->post('nomorSk');
		// $pnsId = $this->input->post('pnsId');
		// $satuanKerjaId = $this->input->post('satuanKerjaId');
		// $tanggalSk = $this->input->post('tanggalSk');
		// $tmtJabatan = $this->input->post('tmtJabatan');
		// $tmtPelantikan = $this->input->post('tmtPelantikan');
		// $unorId = $this->input->post('unorId');
		// $dok_uri = $this->input->post('dok_uri');
		// $object = $this->input->post('object');

		// echo $pnsId;
		// exit();

		$jabatanData = $this->webservice_model->post_jabatan($sso_token, $api_mws_token, $eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, $dok_uri, $object);

		print_r($jabatanData);
	}

	public function post_jabatan_3()
	{
		$pegawai_idx = $this->input->post('pegawai_id');
		$pegawai = $this->db->query("select p.NIP_BARU, 
		p.PEGAWAI_ID, 
		p.ID_SAPK as pnsId, 
		j.JABATAN_RIWAYAT_ID, 
		j.ESELON_ID, 
		j.JFT_ID_SAPK, 
		j.JFU_ID_SAPK, 
		j.JENIS_JABATAN_SAPK, 
		j.NO_SK, 
		p.ID_SAPK, 
		
		DATE_FORMAT(j.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK, 
		DATE_FORMAT(j.TMT_JABATAN, '%d-%m-%Y') as TMT_JABATAN, 
		DATE_FORMAT(j.TANGGAL_PELANTIKAN, '%d-%m-%Y') as TANGGAL_PELANTIKAN, 
		
		j.UNOR_ID_SAPK  
		
		from pegawai as p 
		join jabatan_riwayat as j 
		on p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID
		where p.PEGAWAI_ID = '$pegawai_idx'")->row();


		$api_mws_token = $this->webservice_model->getApiMwsToken();

		$sso_token = $this->webservice_model->getSsoToken();

		// print_r($pegawai);
		// exit();

		$eselonId = $pegawai->ESELON_ID;
		$instansiId =  'A5EB03E23B3BF6A0E040640A040252AD';
		$jabatanFungsionalId = $pegawai->JFT_ID_SAPK;
		// echo $jabatanFungsionalId;
		$jabatanFungsionalUmumId = $pegawai->JFU_ID_SAPK;
		$jenisJabatan = $pegawai->JENIS_JABATAN_SAPK;
		$nomorSk = $pegawai->NO_SK;
		$pnsId = $pegawai->pnsId;
		$satuanKerjaId = 'A5EB03E24222F6A0E040640A040252AD';
		$tanggalSk = $pegawai->TANGGAL_SK;
		$tmtJabatan = $pegawai->TMT_JABATAN;
		$tmtPelantikan = $pegawai->TANGGAL_PELANTIKAN;
		$unorId = $pegawai->UNOR_ID_SAPK;


		// $eselonId = $this->input->post('eselonId');
		// $instansiId =  'A5EB03E23B3BF6A0E040640A040252AD';
		// $jabatanFungsionalId = $this->input->post('jabatanFungsionalId');
		// $jabatanFungsionalUmumId = $this->input->post('jabatanFungsionalUmumId');
		// $jenisJabatan = $this->input->post('jenisJabatan');
		// $nomorSk = $this->input->post('nomorSk');
		// $pnsId = $this->input->post('pnsId');
		// $satuanKerjaId = 'A5EB03E24222F6A0E040640A040252AD';
		// $tanggalSk = $this->input->post('tanggalSk');
		// $tmtJabatan = $this->input->post('tmtJabatan');
		// $tmtPelantikan = $this->input->post('tmtPelantikan');
		// $unorId = $this->input->post('unorId');
		// // $instansiId = $this->input->post('instansiId');
		// // $satuanKerjaId = $this->input->post('satuanKerjaId');
		// // $dok_uri = $this->input->post('dok_uri');
		// // $object = $this->input->post('object');

		// echo $pnsId;
		// exit();

		$jabatanData = $this->webservice_model->post_jabatan('bearer ' . $sso_token, 'Bearer ' . $api_mws_token, $eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, '', '');

		print_r($jabatanData);
	}

	public function singkron_jabatan_all()
	{
		// Ambil data pegawai yang SINGKRON_JABATAN_SIAP tidak sama dengan minggu ini
		$query = "SELECT pegawai_id FROM pegawai WHERE STATUS_PEGAWAI IN ('1','2') and (SINGKRON_JABATAN_SIAP < CURDATE() - INTERVAL WEEKDAY(CURDATE()) DAY
		OR SINGKRON_JABATAN_SIAP > CURDATE() - INTERVAL WEEKDAY(CURDATE()) - 6 DAY) ";
		$result = $this->db->query($query);

		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$pegawai_idx = $row->pegawai_id;

				$pegawai = $this->db->query("select p.NIP_BARU, 
					p.PEGAWAI_ID, 
					p.ID_SAPK as pnsId, 
					j.JABATAN_RIWAYAT_ID, 
					j.ESELON_ID, 
					j.JFT_ID_SAPK, 
					j.JFU_ID_SAPK, 
					j.JENIS_JABATAN_SAPK, 
					j.NO_SK, 
					p.ID_SAPK, 
					
					DATE_FORMAT(j.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK, 
					DATE_FORMAT(j.TMT_JABATAN, '%d-%m-%Y') as TMT_JABATAN, 
					DATE_FORMAT(j.TANGGAL_PELANTIKAN, '%d-%m-%Y') as TANGGAL_PELANTIKAN, 
					
					j.UNOR_ID_SAPK  
					
					from pegawai as p 
					join jabatan_riwayat as j 
					on p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID
					where p.PEGAWAI_ID = '$pegawai_idx'")->row();


				$api_mws_token = $this->webservice_model->getApiMwsToken();

				$sso_token = $this->webservice_model->getSsoToken();


				$eselonId = $pegawai->ESELON_ID;
				$instansiId =  'A5EB03E23B3BF6A0E040640A040252AD';
				$jabatanFungsionalId = $pegawai->JFT_ID_SAPK;
				// echo $jabatanFungsionalId;
				$jabatanFungsionalUmumId = $pegawai->JFU_ID_SAPK;
				$jenisJabatan = $pegawai->JENIS_JABATAN_SAPK;
				$nomorSk = $pegawai->NO_SK;
				$pnsId = $pegawai->pnsId;
				$satuanKerjaId = 'A5EB03E24222F6A0E040640A040252AD';
				$tanggalSk = $pegawai->TANGGAL_SK;
				$tmtJabatan = $pegawai->TMT_JABATAN;
				$tmtPelantikan = $pegawai->TANGGAL_PELANTIKAN;
				$unorId = $pegawai->UNOR_ID_SAPK;

				$jabatanData = $this->webservice_model->post_jabatan('bearer ' . $sso_token, 'Bearer ' . $api_mws_token, $eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, '', '');

				print_r($jabatanData);

				// Lakukan pemrosesan terhadap respons curl sesuai kebutuhan Anda

				// Setelah curl selesai, perbarui SINGKRON_JABATAN_SIAP dengan tanggal dan waktu eksekusi
				$update_query = "UPDATE pegawai SET SINGKRON_JABATAN_SIAP = NOW() WHERE pegawai_id =" . $pegawai_idx;
				$this->db->query($update_query);

				curl_close($curl);


				$this->SingkronGolonganBkn_pegid($pegawai_idx);
			}
		} else {
			echo "Tidak ada pegawai yang memenuhi kriteria.";
		}
	}



	public function post_cpns()
	{
		$pegawai_idx = $this->input->post('pegawai_id');
		$nip_barux = $this->input->post('nip_baru');
		$pegawai = $this->db->query("select 
		sc.PEJABAT_PENETAP as nama_jabatan_angkat_cpns, 
		sc.NO_SK as nomor_sk_cpns, 
		sp.NO_SK as nomor_sk_pns, 
		p.ID_SAPK as pns_orang_id, 
		DATE_FORMAT(sc.TMT_CPNS, '%d-%m-%Y') as tgl_sk_cpns, 
		DATE_FORMAT(sp.TMT_PNS, '%d-%m-%Y') as tmt_pns
		
		from pegawai as p
		join sk_cpns as sc on p.PEGAWAI_ID = sc.PEGAWAI_ID
		join sk_pns as sp on p.PEGAWAI_ID = sp.PEGAWAI_ID
		where p.NIP_BARU = '$nip_barux'")->row();


		$api_mws_token = $this->webservice_model->getApiMwsToken();

		$sso_token = $this->webservice_model->getSsoToken();


		$kartu_pegawai = '';
		$nama_jabatan_angkat_cpns = 'BUPATI PROBOLINGGO';
		$nomor_dokter_pns = '';
		$nomor_sk_cpns =  $pegawai->nomor_sk_cpns; //'821/193/426.307/2008';
		$nomor_spmt = '';
		$nomor_sk_pns = $pegawai->nomor_sk_pns; // '821/193/426.307/2008';
		$nomor_sttpl = '';
		$pertek_cpns_pns_l2th_nomor = '';
		$pertek_cpns_pns_l2th_tanggal = '';
		$pns_orang_id = $pegawai->pns_orang_id; //'A5EB040EF2BAF6A0E040640A040252AD';
		$status_cpns_pns = 'P';
		$tanggal_dokter_pns = '';
		$tgl_sk_cpns = $pegawai->tgl_sk_cpns; // '01-01-2007';
		$tgl_sk_pns = $pegawai->tgl_sk_pns; //'01-01-2007';
		$tgl_sttpl = '';
		$tmt_pns = $pegawai->tmt_pns; // '01-01-2007';

		// $eselonId = $this->input->post('eselonId');
		// $instansiId =  'A5EB03E23B3BF6A0E040640A040252AD';
		// $jabatanFungsionalId = $this->input->post('jabatanFungsionalId');
		// $jabatanFungsionalUmumId = $this->input->post('jabatanFungsionalUmumId');
		// $jenisJabatan = $this->input->post('jenisJabatan');
		// $nomorSk = $this->input->post('nomorSk');
		// $pnsId = $this->input->post('pnsId');
		// $satuanKerjaId = 'A5EB03E24222F6A0E040640A040252AD';
		// $tanggalSk = $this->input->post('tanggalSk');
		// $tmtJabatan = $this->input->post('tmtJabatan');
		// $tmtPelantikan = $this->input->post('tmtPelantikan');
		// $unorId = $this->input->post('unorId');
		// // $instansiId = $this->input->post('instansiId');
		// // $satuanKerjaId = $this->input->post('satuanKerjaId');
		// // $dok_uri = $this->input->post('dok_uri');
		// // $object = $this->input->post('object');

		// echo $pnsId;
		// exit();

		$jabatanData = $this->webservice_model->post_cpns(
			'bearer ' . $sso_token,
			'Bearer ' . $api_mws_token,
			$kartu_pegawai,
			$nama_jabatan_angkat_cpns,
			$nomor_dokter_pns,
			$nomor_sk_cpns,
			$nomor_spmt,
			$nomor_sk_pns,
			$nomor_sttpl,
			$pertek_cpns_pns_l2th_nomor,
			$pertek_cpns_pns_l2th_tanggal,
			$pns_orang_id,
			$status_cpns_pns,
			$tanggal_dokter_pns,
			$tgl_sk_cpns,
			$tgl_sk_pns,
			$tgl_sttpl,
			$tmt_pns
		);

		print_r($jabatanData);
	}

	// public function post_jabatan($eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, $dok_uri, $object)
	public function post_jabatan()
	{
		$eselonId = $this->input->post('eselonId');
		$instansiId = $this->input->post('instansiId');
		$jabatanFungsionalId = $this->input->post('jabatanFungsionalId');
		$jabatanFungsionalUmumId = $this->input->post('jabatanFungsionalUmumId');
		$jenisJabatan = $this->input->post('jenisJabatan');
		$nomorSk = $this->input->post('nomorSk');
		$pnsId = $this->input->post('pnsId');
		$satuanKerjaId = $this->input->post('satuanKerjaId');
		$tanggalSk = $this->input->post('tanggalSk');
		$tmtJabatan = $this->input->post('tmtJabatan');
		$tmtPelantikan = $this->input->post('tmtPelantikan');
		$unorId = $this->input->post('unorId');
		$dok_uri = $this->input->post('dok_uri');
		$object = $this->input->post('object');

		// echo $pnsId;
		// exit();

		$jabatanData = $this->webservice_model->post_jabatan($this->sso_token, $this->api_mws_token, $eselonId, $instansiId, $jabatanFungsionalId, $jabatanFungsionalUmumId, $jenisJabatan, $nomorSk, $pnsId, $satuanKerjaId, $tanggalSk, $tmtJabatan, $tmtPelantikan, $unorId, $dok_uri, $object);

		print_r($jabatanData);
	}

	// public function post_skp22($hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, $dok_uri, $object)
	public function post_skp22($sso_token, $api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, $dok_uri, $object)
	{

		$this->api_mws_token = $this->webservice_model->getApiMwsToken();

		$this->sso_token = $this->webservice_model->getSsoToken();
		// $hasilKinerjaNilai = $this->input->post('hasilKinerjaNilai');
		// $id = $this->input->post('id');
		// $kuadranKinerjaNilai = $this->input->post('kuadranKinerjaNilai');
		// $penilaiGolongan = $this->input->post('penilaiGolongan');
		// $penilaiJabatan = $this->input->post('penilaiJabatan');
		// $penilaiNama = $this->input->post('penilaiNama');
		// $penilaiNipNrp = $this->input->post('penilaiNipNrp');
		// $penilaiUnorNama = $this->input->post('penilaiUnorNama');
		// $perilakuKerjaNilai = $this->input->post('perilakuKerjaNilai');
		// $pnsDinilaiOrang = $this->input->post('pnsDinilaiOrang');
		// $statusPenilai = $this->input->post('statusPenilai');
		// $tahun = $this->input->post('tahun');
		// $dok_uri = $this->input->post('dok_uri');
		// $object = $this->input->post('object');

		// echo $pnsId;
		// exit();

		$skp22Data = $this->webservice_model->post_skp22($sso_token, $api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, $dok_uri, $object);

		print_r($skp22Data);
	}

	public function post_skp22_post()
	{
		$sso_token = $this->input->post('sso_token');
		$api_mws_token = $this->input->post('api_mws_token');
		$hasilKinerjaNilai = $this->input->post('hasilKinerjaNilai');
		$id = $this->input->post('id');
		$kuadranKinerjaNilai = $this->input->post('kuadranKinerjaNilai');
		$penilaiGolongan = $this->input->post('penilaiGolongan');
		$penilaiJabatan = $this->input->post('penilaiJabatan');
		$penilaiNama = $this->input->post('penilaiNama');
		$penilaiNipNrp = $this->input->post('penilaiNipNrp');
		$penilaiUnorNama = $this->input->post('penilaiUnorNama');
		$perilakuKerjaNilai = $this->input->post('perilakuKerjaNilai');
		$pnsDinilaiOrang = $this->input->post('pnsDinilaiOrang');
		$statusPenilai = $this->input->post('statusPenilai');
		$tahun = $this->input->post('tahun');
		$dok_uri = $this->input->post('dok_uri');
		$object = $this->input->post('object');

		// echo $pnsId;
		// exit();

		$skp22Data = $this->webservice_model->post_skp22($sso_token, $api_mws_token, $hasilKinerjaNilai, $id, $kuadranKinerjaNilai, $penilaiGolongan, $penilaiJabatan, $penilaiNama, $penilaiNipNrp, $penilaiUnorNama, $perilakuKerjaNilai, $pnsDinilaiOrang, $statusPenilai, $tahun, $dok_uri, $object);

		print_r($skp22Data);
	}


	// Fungsi untuk melakukan operasi update atau insert pada tabel pangkat_riwayat
	public function SingkronGolonganBkn()
	{

		$peg_id = $_GET['pegawai_id'];
		if (isset($peg_id) && !empty($peg_id)) {
			// Lakukan operasi dengan nilai $peg_id karena memiliki nilai yang valid
			// Contoh:
			// echo "Nilai 'pegawai_id' adalah: " . $peg_id;
		} else {
			// Tangani ketika 'pegawai_id' tidak didefinisikan atau kosong
			// Contoh:
			echo "Nilai 'pegawai_id' tidak ada atau kosong.";
		}
		// $nipBaru = $_GET['nip_baru'];

		// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
		$data_peg = $this->db->get_where('pegawai', array('pegawai_id' => $peg_id))->row();

		// echo "1 <br><br>";
		$golonganData = $this->webservice_model->get_golongan($this->sso_token, $this->api_mws_token, $data_peg->NIP_BARU);


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
					//cek file pdf bkn pada api
					$pathData = $golongan['path'];
					if (!empty($pathData)) {
						foreach ($pathData as $pathId => $pathDetails) {
							$dokId = $pathDetails['dok_id'];
							$dokNama = $pathDetails['dok_nama'];
							$dokUri = $pathDetails['dok_uri'];
							$slug = $pathDetails['slug'];

							// Insert the path details into the database or perform any other desired operations
							// Example SQL statement to insert into the "path_pdf_bkn" table
							// $sql = "INSERT INTO path_pdf_bkn (dok_id, dok_nama, dok_uri, slug) VALUES ('$dokId', '$dokNama', '$dokUri', '$slug')";
							$this->insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug, $golongan['id'], $golongan['idPns'], $golongan['nipBaru']);
							// Execute the SQL statement or perform any other desired operations
							// ...
						}
					}

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
			}
			//else {

			// echo "8 <br><br>";
			// Jika data pegawai dengan nip_baru tidak ditemukan
			// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			//}

			// echo "9 <br><br>";
		}
	}


	public function SingkronGolonganBkn_pegid($peg_id)
	{

		// $peg_id = $_GET['pegawai_id'];
		if (isset($peg_id) && !empty($peg_id)) {
			// Lakukan operasi dengan nilai $peg_id karena memiliki nilai yang valid
			// Contoh:
			// echo "Nilai 'pegawai_id' adalah: " . $peg_id;
		} else {
			// Tangani ketika 'pegawai_id' tidak didefinisikan atau kosong
			// Contoh:
			echo "Nilai 'pegawai_id' tidak ada atau kosong.";
		}
		// $nipBaru = $_GET['nip_baru'];

		// Lakukan pengecekan pada tabel pegawai berdasarkan nip_baru
		$data_peg = $this->db->get_where('pegawai', array('pegawai_id' => $peg_id))->row();

		// echo "1 <br><br>";
		$golonganData = $this->webservice_model->get_golongan($this->sso_token, $this->api_mws_token, $data_peg->NIP_BARU);


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
					//cek file pdf bkn pada api
					$pathData = $golongan['path'];
					if (!empty($pathData)) {
						foreach ($pathData as $pathId => $pathDetails) {
							$dokId = $pathDetails['dok_id'];
							$dokNama = $pathDetails['dok_nama'];
							$dokUri = $pathDetails['dok_uri'];
							$slug = $pathDetails['slug'];

							// Insert the path details into the database or perform any other desired operations
							// Example SQL statement to insert into the "path_pdf_bkn" table
							// $sql = "INSERT INTO path_pdf_bkn (dok_id, dok_nama, dok_uri, slug) VALUES ('$dokId', '$dokNama', '$dokUri', '$slug')";
							$this->insert_path_pdf_bkn($dokId, $dokNama, $dokUri, $slug, $golongan['id'], $golongan['idPns'], $golongan['nipBaru']);
							// Execute the SQL statement or perform any other desired operations
							// ...
						}
					}

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
			}
			//else {

			// echo "8 <br><br>";
			// Jika data pegawai dengan nip_baru tidak ditemukan
			// Lakukan operasi sesuai kebutuhan, misalnya lempar pesan error atau melakukan tindakan lainnya
			//}

			// echo "9 <br><br>";
		}
	}



	public function updatePendidikanTerakhir($nipBaru)
	{
		// $nipBaru = '199306302019031003';
		// echo "1 <br><br>";
		$pendidikanData = $this->wsbkn_rw_f($nipBaru, 'pendidikan');
		// print_r($jabatanData);
		// echo $jabatanData;
		// exit();	

		$data = json_decode($pendidikanData, true);
		// echo "2 <br><br>";

		$maxPendidikanId = -1; // Inisialisasi dengan nilai yang lebih rendah dari id yang mungkin ada

		foreach ($data['data'] as $pendidikan) {

			$tkPendidikanId = $pendidikan['tkPendidikanId'];

			//mencari pendidikan id terbesar
			// Periksa apakah nilai $tkPendidikanId lebih besar dari nilai maksimum yang sudah ada
			if ($tkPendidikanId > $maxPendidikanId) {
				$maxPendidikanId = $tkPendidikanId;
			}
		}

		// get riwayat data pendidikan
		// d looping untuk mencari ID_SAPK tertinggi

		$this->db->query("select p.NIP_BARU, 
		p.PEGAWAI_ID, 
		p.ID_SAPK as pnsId, 
		j.JABATAN_RIWAYAT_ID, 
		j.ESELON_ID, 
		j.JFT_ID_SAPK, 
		j.JFU_ID_SAPK, 
		j.JENIS_JABATAN_SAPK, 
		j.NO_SK, 
		p.ID_SAPK, 
		
		DATE_FORMAT(j.TANGGAL_SK, '%d-%m-%Y') as TANGGAL_SK, 
		DATE_FORMAT(j.TMT_JABATAN, '%d-%m-%Y') as TMT_JABATAN, 
		DATE_FORMAT(j.TANGGAL_PELANTIKAN, '%d-%m-%Y') as TANGGAL_PELANTIKAN, 
		
		j.UNOR_ID_SAPK  
		
		from pegawai as p 
		join jabatan_riwayat as j 
		on p.JABATAN_ID_TERAKHIR = j.JABATAN_RIWAYAT_ID	")->row();
	}
}
