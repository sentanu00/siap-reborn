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


    public function cekMasaKerjaOtomatis($nip)
    {
        header('Content-Type: text/plain; charset=utf-8');

        // $nip = $this->input->get('nip');
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

    /**
     * Hitung ulang masa kerja dan kembalikan detail per langkah
     * @param array $riwayat - array dengan key: tmt, pangkat, pangkat_nama, mk_tahun, mk_bulan, pangkat_riwayat_id
     * @return array [
     *   'langkah' => [
     *       'pangkat_riwayat_id' => ...,
     *       'pangkat_awal' => ...,
     *       'pangkat_akhir' => ...,
     *       'tmt_awal' => ...,
     *       'tmt_akhir' => ...,
     *       'mk_hitung' => int (total bulan),
     *       'mk_tercatat' => int (total bulan),
     *       'selisih' => int,
     *       'sesuai' => bool
     *   ],
     *   'semua_sesuai' => bool
     * ]
     */
    private function hitungMasaKerjaDetail($riwayat)
    {
        $result = ['langkah' => [], 'semua_sesuai' => true];
        if (empty($riwayat)) {
            return $result;
        }

        $prev = $riwayat[0];
        $prevMK = $prev['mk_tahun'] * 12 + $prev['mk_bulan'];
        $semuaSesuai = true;

        for ($i = 1; $i < count($riwayat); $i++) {
            $curr = $riwayat[$i];

            $selisihWaktu = $this->selisihBulan($prev['tmt'], $curr['tmt']);
            $potongan = $this->getPotongan($prev['pangkat'], $curr['pangkat']);
            $mkBaru = $prevMK + $selisihWaktu - $potongan;
            $mkTercatat = $curr['mk_tahun'] * 12 + $curr['mk_bulan'];
            $selisihMK = $mkBaru - $mkTercatat;
            $sesuai = ($selisihMK == 0);

            $result['langkah'][] = [
                'pangkat_riwayat_id' => $curr['pangkat_riwayat_id'], // tambahkan ini
                'pangkat_awal'       => $prev['pangkat_nama'],
                'pangkat_akhir'      => $curr['pangkat_nama'],
                'tmt_awal'           => $prev['tmt'],
                'tmt_akhir'          => $curr['tmt'],
                'mk_hitung'          => $mkBaru,
                'mk_tercatat'        => $mkTercatat,
                'selisih'            => $selisihMK,
                'sesuai'             => $sesuai
            ];

            if (!$sesuai) $semuaSesuai = false;

            $prev = $curr;
            $prevMK = $mkBaru;
        }

        $result['semua_sesuai'] = $semuaSesuai;
        return $result;
    }

    public function cekMasaKerjaBatch($limit = 100)
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo "=========================================\n";
        echo "PROSES CEK MASA KERJA BATCH\n";
        echo "Dimulai : " . date('Y-m-d H:i:s') . "\n";
        echo "=========================================\n\n";

        // 1. Ambil pegawai yang perlu dicek
        $query = $this->db
            ->select('s.*, p.NIP_BARU')
            ->from('siasnpegawaiid s')
            ->join('pegawai p', 's.pegawai_id = p.PEGAWAI_ID')
            ->where('s.golongan', 0)
            ->where_in('s.statusPegawai', ['PNS', 'CPNS'])
            ->order_by('s.id')
            ->limit($limit)
            ->get();

        $rows = $query->result();
        $total = count($rows);

        if ($total == 0) {
            echo "Tidak ada pegawai yang perlu dicek.\n";
            return;
        }

        echo "Total pegawai yang akan diproses: $total\n\n";

        $processed = 0;
        $updated = 0;
        $error = 0;

        foreach ($rows as $row) {
            $nip = $row->NIP_BARU;
            $pegawai_id = $row->pegawai_id;

            echo "Proses NIP: $nip ... ";

            // 2. Ambil riwayat pangkat dari tabel (sertakan PANGKAT_RIWAYAT_ID)
            $sql = "
            SELECT 
                pr.PANGKAT_RIWAYAT_ID, 
                pr.PEGAWAI_ID, 
                pr.PANGKAT_ID, 
                p2.KODE as PANGKAT_NAMA, 
                pr.TMT_PANGKAT, 
                pr.MASA_KERJA_TAHUN, 
                pr.MASA_KERJA_BULAN
            FROM pangkat_riwayat pr
            JOIN pangkat p2 ON pr.PANGKAT_ID = p2.PANGKAT_ID
            WHERE pr.PEGAWAI_ID = ?
            ORDER BY pr.TMT_PANGKAT ASC
        ";

            $riwayatDb = $this->db->query($sql, [$pegawai_id])->result_array();

            if (empty($riwayatDb)) {
                echo "TIDAK ADA RIWAYAT\n";
                $this->db->where('id', $row->id)->update('siasnpegawaiid', ['golongan' => 4]);
                $error++;
                continue;
            }

            // Format riwayat (tambahkan pangkat_riwayat_id)
            $riwayat = [];
            foreach ($riwayatDb as $r) {
                $riwayat[] = [
                    'pangkat_riwayat_id' => $r['PANGKAT_RIWAYAT_ID'],
                    'tmt'           => $r['TMT_PANGKAT'],
                    'pangkat'       => $r['PANGKAT_ID'],
                    'pangkat_nama'  => $r['PANGKAT_NAMA'],
                    'mk_tahun'      => (int)($r['MASA_KERJA_TAHUN'] ?? 0),
                    'mk_bulan'      => (int)($r['MASA_KERJA_BULAN'] ?? 0)
                ];
            }

            // 3. Hitung ulang
            $hasil = $this->hitungMasaKerjaDetail($riwayat);

            // 4. Update kolom hasil_hitung untuk setiap langkah (baris ke-1 dan seterusnya)
            $adaSelisih = false;
            foreach ($hasil['langkah'] as $langkah) {
                $mk_tahun = floor($langkah['mk_hitung'] / 12);
                $mk_bulan = $langkah['mk_hitung'] % 12;
                $keterangan = $langkah['sesuai'] ? 'Sesuai' : 'Selisih';

                if (!$langkah['sesuai']) {
                    $adaSelisih = true;
                }

                $this->db->where('PANGKAT_RIWAYAT_ID', $langkah['pangkat_riwayat_id'])
                    ->update('pangkat_riwayat', [
                        'HASIL_HITUNG_MASA_KERJA_TAHUN' => $mk_tahun,
                        'HASIL_HITUNG_MASA_KERJA_BULAN' => $mk_bulan,
                        'HASIL_HITUNG_KETERANGAN'       => $keterangan
                    ]);
            }

            // 5. Update status di siasnpegawaiid menjadi 4 (sudah dicek)
            $this->db->where('id', $row->id)->update('siasnpegawaiid', ['golongan' => 4]);

            if ($adaSelisih) {
                echo "SELISIH DITEMUKAN\n";
                $updated++;
            } else {
                echo "OK (semua sesuai)\n";
            }

            $processed++;
        }

        echo "\n=========================================\n";
        echo "SELESAI\n";
        echo "Diproses : $processed\n";
        echo "Ada selisih : $updated\n";
        echo "Error    : $error\n";
        echo "Waktu    : " . date('Y-m-d H:i:s') . "\n";
        echo "=========================================\n";
    }
}
