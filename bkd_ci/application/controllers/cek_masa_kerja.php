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

    /**
     * Format selisih dalam bulan menjadi string dengan tanda + atau -
     * Contoh: + 2 tahun 3 bulan, - 1 bulan, 0 bulan
     */
    private function formatSelisihTeks($selisihBulan)
    {
        if ($selisihBulan == 0) return '0 bulan';
        $abs = abs($selisihBulan);
        $tahun = floor($abs / 12);
        $bulan = $abs % 12;
        $tanda = ($selisihBulan < 0) ? '-' : '+';
        $str = '';
        if ($tahun > 0) $str .= $tahun . ' tahun';
        if ($bulan > 0) {
            if ($tahun > 0) $str .= ' ';
            $str .= $bulan . ' bulan';
        }
        if ($str == '') $str = '0 bulan';
        return $tanda . ' ' . $str;
    }

    private function prosesCek($riwayat)
    {
        $detail = [];
        if (empty($riwayat)) {
            return ['detail' => ['Tidak ada data.'], 'semua_sesuai' => false, 'kesimpulan' => 'Tidak ada data'];
        }

        $awal = $riwayat[0];
        $mkAwal = $awal['mk_tahun'] * 12 + $awal['mk_bulan'];
        $tmtAwal = $awal['tmt'];
        $detail[] = "AWAL: TMT {$awal['tmt']}, Pangkat {$awal['pangkat']} ({$awal['pangkat_nama']}), MK = {$awal['mk_tahun']} thn {$awal['mk_bulan']} bln";

        $semuaSesuai = true;

        for ($i = 1; $i < count($riwayat); $i++) {
            $curr = $riwayat[$i];

            $selisihWaktu = $this->selisihBulan($tmtAwal, $curr['tmt']);
            $totalPotongan = 0;
            for ($j = 1; $j <= $i; $j++) {
                $prev = $riwayat[$j - 1];
                $curr2 = $riwayat[$j];
                $totalPotongan += $this->getPotongan($prev['pangkat'], $curr2['pangkat']);
            }

            $mkBaru = $mkAwal + $selisihWaktu - $totalPotongan;
            $mkTercatat = $curr['mk_tahun'] * 12 + $curr['mk_bulan'];
            $selisihMK = $mkBaru - $mkTercatat;
            $status = ($selisihMK == 0) ? "✅ SESUAI" : "❌ SELISIH";

            $detail[] = "-----------------------------------------";
            $detail[] = "Kenaikan ke-" . $i . ": " . $awal['pangkat_nama'] . " -> " . $curr['pangkat_nama'] . " (kode " . $awal['pangkat'] . " -> " . $curr['pangkat'] . ")";
            $detail[] = "  TMT awal      : {$tmtAwal}";
            $detail[] = "  TMT sekarang  : {$curr['tmt']}";
            $detail[] = "  Selisih waktu : " . $this->formatBulan($selisihWaktu) . " (" . $selisihWaktu . " bln)";
            $detail[] = "  Potongan total: " . $this->formatBulan($totalPotongan) . " (" . $totalPotongan . " bln)";
            $detail[] = "  MK awal       : " . $this->formatBulan($mkAwal) . " (" . $mkAwal . " bln)";
            $detail[] = "  MK hitung     : " . $this->formatBulan($mkBaru) . " (" . $mkBaru . " bln)";
            $detail[] = "  MK tercatat   : " . $this->formatBulan($mkTercatat) . " (" . $mkTercatat . " bln)";
            $detail[] = "  Status        : $status";
            if ($selisihMK != 0) {
                $detail[] = "  >> Selisih    : " . $this->formatSelisih($selisihMK);
                $semuaSesuai = false;
            }
            $detail[] = "";
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

    /**
     * Hitung ulang masa kerja dari TMT awal (CPNS) untuk setiap langkah
     */
    private function hitungMasaKerjaDetail($riwayat)
    {
        $result = ['langkah' => [], 'semua_sesuai' => true];
        if (empty($riwayat)) {
            return $result;
        }

        $awal = $riwayat[0];
        $mkAwal = $awal['mk_tahun'] * 12 + $awal['mk_bulan'];
        $tmtAwal = $awal['tmt'];

        $semuaSesuai = true;

        for ($i = 1; $i < count($riwayat); $i++) {
            $curr = $riwayat[$i];

            $selisihWaktu = $this->selisihBulan($tmtAwal, $curr['tmt']);
            $totalPotongan = 0;
            for ($j = 1; $j <= $i; $j++) {
                $prev = $riwayat[$j - 1];
                $curr2 = $riwayat[$j];
                $totalPotongan += $this->getPotongan($prev['pangkat'], $curr2['pangkat']);
            }

            $mkBaru = $mkAwal + $selisihWaktu - $totalPotongan;
            $mkTercatat = $curr['mk_tahun'] * 12 + $curr['mk_bulan'];
            $selisihMK = $mkBaru - $mkTercatat;
            $sesuai = ($selisihMK == 0);

            $result['langkah'][] = [
                'pangkat_riwayat_id' => $curr['pangkat_riwayat_id'],
                'pangkat_awal'       => $riwayat[$i - 1]['pangkat_nama'],
                'pangkat_akhir'      => $curr['pangkat_nama'],
                'tmt_awal'           => $tmtAwal,
                'tmt_akhir'          => $curr['tmt'],
                'mk_hitung'          => $mkBaru,
                'mk_tercatat'        => $mkTercatat,
                'selisih'            => $selisihMK,
                'sesuai'             => $sesuai
            ];

            if (!$sesuai) {
                $semuaSesuai = false;
            }
        }

        $result['semua_sesuai'] = $semuaSesuai;
        return $result;
    }

    public function cekMasaKerjaBatch($limit = 1000)
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo "=========================================\n";
        echo "PROSES CEK MASA KERJA BATCH\n";
        echo "Dimulai : " . date('Y-m-d H:i:s') . "\n";
        echo "=========================================\n\n";

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

            // Jika hanya 1 riwayat
            if (count($riwayatDb) == 1) {
                $r = $riwayatDb[0];
                $this->db->where('PANGKAT_RIWAYAT_ID', $r['PANGKAT_RIWAYAT_ID'])
                    ->update('pangkat_riwayat', [
                        'HASIL_HITUNG_MASA_KERJA_TAHUN' => (int)$r['MASA_KERJA_TAHUN'],
                        'HASIL_HITUNG_MASA_KERJA_BULAN' => (int)$r['MASA_KERJA_BULAN'],
                        'HASIL_HITUNG_KETERANGAN'       => 'Sesuai (hanya 1 riwayat)',
                        'SELISIH_HASIL_HITUNG_'         => '0 bulan'
                    ]);
                $this->db->where('id', $row->id)->update('siasnpegawaiid', ['golongan' => 4]);
                echo "HANYA 1 RIWAYAT - langsung set\n";
                $processed++;
                continue;
            }

            // Format riwayat
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

            $hasil = $this->hitungMasaKerjaDetail($riwayat);

            $adaSelisih = false;
            foreach ($hasil['langkah'] as $langkah) {
                $mk_tahun = floor($langkah['mk_hitung'] / 12);
                $mk_bulan = $langkah['mk_hitung'] % 12;
                $keterangan = $langkah['sesuai'] ? 'Sesuai' : 'Selisih';

                // Format selisih untuk kolom
                $selisihStr = $this->formatSelisihTeks($langkah['selisih']);

                if (!$langkah['sesuai']) {
                    $adaSelisih = true;
                }

                $this->db->where('PANGKAT_RIWAYAT_ID', $langkah['pangkat_riwayat_id'])
                    ->update('pangkat_riwayat', [
                        'HASIL_HITUNG_MASA_KERJA_TAHUN' => $mk_tahun,
                        'HASIL_HITUNG_MASA_KERJA_BULAN' => $mk_bulan,
                        'HASIL_HITUNG_KETERANGAN'       => $keterangan,
                        'SELISIH_HASIL_HITUNG_'         => $selisihStr
                    ]);
            }

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

        if (count($rows) == 1) {
            echo "=========================================\n";
            echo "PENGECEKAN MASA KERJA PNS\n";
            echo "NIP: $nip\n";
            echo "=========================================\n\n";
            echo "Hanya ada 1 riwayat pangkat untuk NIP ini.\n";
            echo "Tidak ada perbandingan.\n";
            echo "Masa Kerja: " . $rows[0]['MASA_KERJA_TAHUN'] . " tahun " . $rows[0]['MASA_KERJA_BULAN'] . " bulan\n";
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
}
