<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cek_masa_kerja extends SB_Controller
{

    private $api_mws_token;
    private $sso_token;

    function __construct()
    {
        parent::__construct();

        $this->load->model('apimodel');

        $this->api_mws_token = $this->apimodel->getApiMwsToken();
    }

    public function index()
    {
        header('Content-Type: text/plain; charset=utf-8');
        // echo "Gunakan endpoint: /cek_masa_kerja/cekMasaKerja?nip=197107182007011010\n";

        // $this->load->model('apimodel');

        // $this->api_mws_token = $this->apimodel->getApiMwsToken();
        // echo "API MWS Token: " . $this->api_mws_token . "\n";
    }
    /**
     * Hitung selisih bulan berdasarkan TAHUN dan BULAN saja (abaikan hari)
     */
    function selisihBulan($tgl1, $tgl2)
    {
        $ts1 = strtotime($tgl1);
        $ts2 = strtotime($tgl2);
        $tahun1 = date('Y', $ts1);
        $bulan1 = date('m', $ts1);
        $tahun2 = date('Y', $ts2);
        $bulan2 = date('m', $ts2);
        return ($tahun2 - $tahun1) * 12 + ($bulan2 - $bulan1);
    }

    /**
     * Tentukan potongan (dalam bulan) berdasarkan kenaikan golongan
     */
    function getPotongan($kodeAwal, $kodeAkhir)
    {
        $golAwal = (int) substr($kodeAwal, 0, 1);
        $golAkhir = (int) substr($kodeAkhir, 0, 1);
        if ($golAkhir > $golAwal) {
            if ($golAwal == 1 && $golAkhir == 2) return 6 * 12;
            if ($golAwal == 2 && $golAkhir == 3) return 5 * 12;
            if ($golAwal == 3 && $golAkhir == 4) return 0;
        }
        return 0;
    }

    private function formatSelisih($bulan)
    {
        if ($bulan == 0) return '0 bulan';
        $abs = abs($bulan);
        $tahun = floor($abs / 12);
        $sisaBulan = $abs % 12;
        $tanda = ($bulan < 0) ? '-' : '';
        if ($tahun == 0) return $tanda . $sisaBulan . ' bulan';
        if ($sisaBulan == 0) return $tanda . $tahun . ' tahun';
        return $tanda . $tahun . ' tahun ' . $tanda . $sisaBulan . ' bulan';
    }

    private function formatBulan($totalBulan)
    {
        $tahun = floor($totalBulan / 12);
        $bulan = $totalBulan % 12;
        if ($tahun == 0) return $bulan . ' bln';
        if ($bulan == 0) return $tahun . ' thn';
        return $tahun . ' thn ' . $bulan . ' bln';
    }

    private function prosesCek($riwayat)
    {
        $detail = [];
        if (empty($riwayat)) {
            return ['detail' => ['Tidak ada data.'], 'semua_sesuai' => false, 'kesimpulan' => 'Tidak ada data'];
        }

        $prev = $riwayat[0];
        $prevMK = $prev['mk_tahun'] * 12 + $prev['mk_bulan'];
        $detail[] = "AWAL: TMT {$prev['tmt']}, Pangkat {$prev['pangkat']} ({$prev['pangkat_nama']}), MK = {$prev['mk_tahun']} thn {$prev['mk_bulan']} bln";

        $semuaSesuai = true;

        for ($i = 1; $i < count($riwayat); $i++) {
            $curr = $riwayat[$i];

            $selisihWaktu = $this->selisihBulan($prev['tmt'], $curr['tmt']);
            $potongan = $this->getPotongan($prev['pangkat'], $curr['pangkat']);
            $mkBaru = $prevMK + $selisihWaktu - $potongan;
            $mkTercatat = $curr['mk_tahun'] * 12 + $curr['mk_bulan'];
            $selisihMK = $mkBaru - $mkTercatat;
            $status = ($selisihMK == 0) ? "✅ SESUAI" : "❌ SELISIH";

            $detail[] = "-----------------------------------------";
            $detail[] = "Kenaikan ke-" . $i . ": " . $prev['pangkat_nama'] . " -> " . $curr['pangkat_nama'] . " (kode " . $prev['pangkat'] . " -> " . $curr['pangkat'] . ")";
            $detail[] = "  TMT sebelumnya : {$prev['tmt']}";
            $detail[] = "  TMT sekarang   : {$curr['tmt']}";
            $detail[] = "  Selisih waktu  : " . $this->formatBulan($selisihWaktu) . " (" . $selisihWaktu . " bln)";
            $detail[] = "  Potongan       : " . $this->formatBulan($potongan) . " (" . $potongan . " bln)";
            $detail[] = "  MK hitung      : " . $this->formatBulan($mkBaru) . " (" . $mkBaru . " bln)";
            $detail[] = "  MK tercatat    : " . $this->formatBulan($mkTercatat) . " (" . $mkTercatat . " bln)";
            $detail[] = "  Status         : $status";
            if ($selisihMK != 0) {
                $detail[] = "  >> Selisih     : " . $this->formatSelisih($selisihMK);
                $semuaSesuai = false;
            }
            $detail[] = "";

            $prev = $curr;
            $prevMK = $mkBaru;
        }

        $kesimpulan = $semuaSesuai ? "Semua data konsisten." : "Ada ketidaksesuaian, periksa detail di atas.";
        $detail[] = "=========================================";
        $detail[] = "KESIMPULAN: $kesimpulan";

        return [
            'detail'        => $detail,
            'semua_sesuai'  => $semuaSesuai,
            'kesimpulan'    => $kesimpulan
        ];
    }

    public function cekMasaKerja()
    {
        header('Content-Type: text/plain; charset=utf-8');

        $nip = $this->input->get('nip');
        if (empty($nip)) {
            echo "ERROR: Parameter 'nip' wajib diisi.\n";
            echo "Contoh: ?nip=197107182007011010";
            return;
        }

        $sql = "
            SELECT 
                p.NIP_BARU, 
                pr.PANGKAT_RIWAYAT_ID, 
                pr.PEGAWAI_ID, 
                pr.PANGKAT_ID, 
                p2.KODE as PANGKAT_NAMA, 
                pr.TMT_PANGKAT, 
                pr.MASA_KERJA_TAHUN, 
                pr.MASA_KERJA_BULAN
            FROM pegawai p 
            JOIN pangkat_riwayat pr ON p.PEGAWAI_ID = pr.PEGAWAI_ID 
            JOIN pangkat p2 ON pr.PANGKAT_ID = p2.PANGKAT_ID 
            WHERE p.NIP_BARU = ? 
            ORDER BY pr.TMT_PANGKAT ASC
        ";

        $query = $this->db->query($sql, [$nip]);
        $rows = $query->result_array();

        if (empty($rows)) {
            echo "Tidak ditemukan data untuk NIP: $nip";
            return;
        }

        $riwayat = [];
        foreach ($rows as $row) {
            $riwayat[] = [
                'tmt'           => $row['TMT_PANGKAT'],
                'pangkat'       => $row['PANGKAT_ID'],
                'pangkat_nama'  => $row['PANGKAT_NAMA'],
                'mk_tahun'      => (int)($row['MASA_KERJA_TAHUN'] ?? 0),
                'mk_bulan'      => (int)($row['MASA_KERJA_BULAN'] ?? 0)
            ];
        }

        echo "=========================================\n";
        echo "PENGECEKAN MASA KERJA PNS\n";
        echo "NIP: $nip\n";
        echo "=========================================\n\n";

        $hasil = $this->prosesCek($riwayat);

        foreach ($hasil['detail'] as $baris) {
            echo $baris . "\n";
        }
    }




    public function SingkronGolonganBkn()
    {
        // Ambil pegawai_id dari GET (atau bisa juga dari POST)
        $peg_id = $this->input->get('pegawai_id');
        if (empty($peg_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Parameter pegawai_id wajib diisi.']);
            return;
        }
        // echo "\n peg_id : ".$peg_id;

        // Cek data pegawai
        $data_peg = $this->db->get_where('pegawai', ['pegawai_id' => $peg_id])->row();
        if (!$data_peg) {
            echo json_encode(['status' => 'error', 'message' => 'Pegawai tidak ditemukan.']);
            return;
        }

        // echo "\n data_peg->NIP_BARU : ".$data_peg->NIP_BARU;

        // Panggil web service SIASN untuk mendapatkan riwayat golongan
        $golonganData = $this->get_golongan($this->api_mws_token, $data_peg->NIP_BARU);
        // echo "\n golonganData : ".$golonganData;
        
        $data = json_decode($golonganData, true);

        // echo "\n data['data'] : ".$data['data'];

        // Cek apakah response sukses dan ada data
        if (!isset($data['data']) || empty($data['data'])) {
            echo json_encode(['status' => 'error', 'message' => $data['message'].' '.$data['description'] ?? 'Tidak ada data riwayat golongan dari SIASN atau terjadi kesalahan.']);
            return;
        }

        $total = 0;
        $inserted = 0;
        $updated = 0;

        foreach ($data['data'] as $golongan) {
            
            // echo "\n Golongan : ". $golongan['nipBaru']." - ". $golongan['golongan'];
            $total++;

            // Ambil nilai dari SIASN
            $siasn_id           = $golongan['id'];                    // ID unik riwayat dari SIASN
            $pangkat_id         = $golongan['golonganId'];
            $tmt                = date('Y-m-d', strtotime($golongan['tmtGolongan']));
            $nipBaru            = $golongan['nipBaru'];
            $no_nota            = $golongan['noPertekBkn'];
            $tgl_nota           = !empty($golongan['tglPertekBkn']) ? date('Y-m-d', strtotime($golongan['tglPertekBkn'])) : null;
            $no_sk              = $golongan['skNomor'];
            $tgl_sk             = !empty($golongan['skTanggal']) ? date('Y-m-d', strtotime($golongan['skTanggal'])) : null;
            $mk_tahun           = $golongan['masaKerjaGolonganTahun'];
            $mk_bulan           = $golongan['masaKerjaGolonganBulan'];
            $jumlah_kredit_utama    = $golongan['jumlahKreditUtama'];
            $jumlah_kredit_tambahan = $golongan['jumlahKreditTambahan'];
            $jenis_kp_id        = $golongan['jenisKPId'];
            $jenis_kp_nama      = $golongan['jenisKPNama'];
            $idPns              = $golongan['idPns'];
            $dok_uri              = $golongan['path']['858']['dok_uri'];
            // echo "\n dok_uri : ". $dok_uri;

            // Cek apakah data dengan SIASN_PANGKAT_ID dan PEGAWAI_ID sudah ada
            $existing = $this->db->get_where('pangkat_riwayat', [
                // 'SIASN_PANGKAT_ID' => $siasn_id,
                'PANGKAT_ID' => $pangkat_id,
                'PEGAWAI_ID'        => $peg_id
            ])->row();

            // echo "\n 2";
            if ($existing) {
                // UPDATE data yang ada
                $update_data = [
                    'PANGKAT_ID'            => $pangkat_id,
                    'NO_NOTA'               => $no_nota,
                    'TANGGAL_NOTA'          => $tgl_nota,
                    'NO_SK'                 => $no_sk,
                    'TANGGAL_SK'            => $tgl_sk,
                    'TMT_PANGKAT'           => $tmt,
                    'MASA_KERJA_TAHUN'      => $mk_tahun,
                    'MASA_KERJA_BULAN'      => $mk_bulan,
                    'JUMLAHKREDITUTAMA'     => $jumlah_kredit_utama,
                    'JUMLAHKREDITTAMBAHAN'  => $jumlah_kredit_tambahan,
                    'JENISKPID'             => $jenis_kp_id,
                    'JENISKPNAMA'           => $jenis_kp_nama,
                    'SIASN_IDPNS'           => $idPns,
                    'NIPBARU'               => $nipBaru,
                    'DOK_URI'               => $dok_uri,
                    'KETERANGAN'            => "UPDATE BY WS SIASN",
                    'TANGGAL_UPDATE'        => date('Y-m-d'),
                    'LAST_UPDATE_DATE'      => date('Y-m-d')
                ];
                $this->db->where('PANGKAT_ID', $pangkat_id)
                        ->where('PEGAWAI_ID', $peg_id)
                        ->update('pangkat_riwayat', $update_data);
                $updated++;

            // echo "\n 3";
            } else {

            // echo "\n 4";
                // INSERT data baru
                $insert_data = [
                    'PEGAWAI_ID'            => $peg_id,
                    'PANGKAT_ID'            => $pangkat_id,
                    'NO_NOTA'               => $no_nota,
                    'TANGGAL_NOTA'          => $tgl_nota,
                    'NO_SK'                 => $no_sk,
                    'TANGGAL_SK'            => $tgl_sk,
                    'TMT_PANGKAT'           => $tmt,
                    'MASA_KERJA_TAHUN'      => $mk_tahun,
                    'MASA_KERJA_BULAN'      => $mk_bulan,
                    'JUMLAHKREDITUTAMA'     => $jumlah_kredit_utama,
                    'JUMLAHKREDITTAMBAHAN'  => $jumlah_kredit_tambahan,
                    'JENISKPID'             => $jenis_kp_id,
                    'JENISKPNAMA'           => $jenis_kp_nama,
                    'SIASN_PANGKAT_ID'     => $siasn_id,
                    'SIASN_IDPNS'           => $idPns,
                    'NIPBARU'               => $nipBaru,
                    'DOK_URI'               => $dok_uri,
                    'KETERANGAN'            => "INSERT BY WS SIASN",
                    'LAST_CREATE_DATE'      => date('Y-m-d')
                ];
                $this->db->insert('pangkat_riwayat', $insert_data);
                $inserted++;

            // echo "\n 4";
            }


        }


            // echo "\n 7";
        // Kirim response JSON
        echo json_encode([
            'status'    => 'success',
            'message'   => "Sinkronisasi selesai. Total data: $total, Insert: $inserted, Update: $updated",
            'total'     => $total,
            'inserted'  => $inserted,
            'updated'   => $updated
        ]);

            // echo "\n 8";
    }


    public function get_golongan($api_mws_token, $nip_baru)
	{


        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/rw-golongan/' . $nip_baru,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA',
				'Authorization: ' . $api_mws_token,
				'Cookie: ff8d625df24f2272ecde05bd53b814bc=ce158eaac3b25204bfaa39e480fc50f7; pdns=1091068938.13088.0000'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// $hasil['data']['sso_token'] = $sso_token;
		// $hasil['data']['api_mws_token'] = $api_mws_token;
		// $hasil['data']['return'] = $response;

		return $response;
		// return $hasil;
	}

}