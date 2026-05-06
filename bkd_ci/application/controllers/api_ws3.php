<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Api_ws3 extends SB_Controller
{

    private $api_mws_token;
    private $sso_token;


    function __construct()
    {
        parent::__construct();
        // Mengatur tipe konten header sebagai application/json
        header('Content-Type: application/json');

        $this->load->model('apimodel');

        $this->api_mws_token = $this->apimodel->getApiMwsToken();

        // $this->sso_token = $this->apimodel->getSsoToken();
    }


    public function exe_ws_siasn()
    {
        header('Content-Type: text/html');

        $data = $this->apimodel->get_data_siap_kirim();
        $apimwstoken = $this->api_mws_token;


        foreach ($data as $row) {

            echo "ID: " . $row->id . "<br>";
            echo "Nama: " . $row->nama . "<br>";
            echo "URL: " . $row->url . "<br>";
            echo "Method: " . $row->postget . "<br>";
            echo "Create Date: " . $row->create_date . "<br>";

            $json = json_decode($row->bodyjson, true);

            // default aman
            $pnsId = '-';
            $nomorSk = '-';

            if (is_array($json)) {
                $pnsId = isset($json['pnsId']) && $json['pnsId'] != '' ? $json['pnsId'] : '-';
                $nomorSk = isset($json['nomorSk']) && $json['nomorSk'] != '' ? $json['nomorSk'] : '-';
            }

            echo "PNS ID: " . $pnsId . "<br>";
            echo "Nomor SK: " . $nomorSk . "<br>";

            //bila $row->postget == GET maka masuk ke kirim_ws_siasn_get, bila POST maka masuk ke kirim_ws_siasn_post

            if ($row->postget == 'GET') {
                $hasil = $this->kirim_ws_siasn_get($apimwstoken, $row->url, $row->bodyjson);
            } elseif ($row->postget == 'POST') {
                $hasil = $this->kirim_ws_siasn_post($apimwstoken, $row->url, $row->bodyjson);
            }

            //---------------------------------------------------------------------------------

            if ((isset($hasil['Error']) && $hasil['Error'] === 'false') || (isset($hasil['success']) && $hasil['success'] === true)) {

                $this->apimodel->update_status($row->id, 'sukses', json_encode($hasil));

                echo "<b style='color:green;'>✔ Sukses dikirim</b><br>";
            } else {

                $this->apimodel->update_status($row->id, 'gagal', json_encode($hasil));

                echo "<b style='color:red;'>✖ Gagal dikirim</b><br>";

                if (isset($hasil['message'])) {
                    echo "Error: " . $hasil['message'] . "<br>";
                }
            }

            echo "<hr>";
        }
    }


    public function kirim_ws_siasn_post($api_mws_token, $url, $bodyjson)
    {
        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $bodyjson,
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token,
                'Content-Type: application/json',
                'Cookie: ff8d625df24f2272ecde05bd53b814bc=fff6ac8c4f312ac61c70a7442621f607; pdns=1091068938.13088.0000'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);
        $jabatanData = json_decode($response, true);


        curl_close($curl);
        return $jabatanData;
    }

    public function kirim_ws_siasn_get($api_mws_token, $url, $bodyjson)
    {
        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token,
            ),

            // 🔥 penting untuk SIASN
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,

            // 🔥 WAJIB (biar gak kena reset 104)
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ));

        $response = curl_exec($curl);
        $jabatanData = json_decode($response, true);


        curl_close($curl);
        return $jabatanData;
    }

    public function cek_get_siasn()
    {
        if (!isset($_GET['link'])) {
            echo "link kosong";
            return;
        }

        // 🔥 WAJIB: decode dulu untuk jaga2 kalau sudah di-encode dari luar
        $link = urldecode($_GET['link']);

        // gabungkan URL
        $linkall = 'https://apimws.bkn.go.id:8243/apisiasn/1.0' . $link;

        // token
        $api_mws_token = "Bearer " . $this->api_mws_token;
        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $linkall,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token,
            ),

            // 🔥 penting untuk SIASN
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,

            // 🔥 WAJIB (biar gak kena reset 104)
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'Curl error: ' . curl_error($curl);
        } else {
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }

        curl_close($curl);
    }
}
