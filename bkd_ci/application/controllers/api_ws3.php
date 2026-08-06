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
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        header('Content-Type: text/html');

        $this->apimodel->update_status_error_data();


        $data = $this->apimodel->get_data_siap_kirim_data();
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
                $hasil = $this->kirim_ws_siasn_get($apimwstoken, $row->url);
            } elseif ($row->postget == 'POST') {

                // if ($row->url == "https://apimws.bkn.go.id:8243/apisiasn/1.0/upload-dok-rw") {
                //     //disini fungsi untuk upload file
                //     echo "upload id= " . $row->id . " " . $row->id_table . " " . $row->url;
                //     $hasil = $this->kirimfilesiasnbasic($row->id_table, $apimwstoken);
                // } else {
                $hasil = $this->kirim_ws_siasn_post($apimwstoken, $row->url, $row->bodyjson);
                echo "data " . $row->url;
                // }
            } elseif ($row->postget == 'DELETE') {
                $hasil = $this->kirim_ws_siasn_delete($apimwstoken, $row->url);
                echo "data " . $row->url;
            } else {
                echo "<b style='color:red;'>✖ Method tidak dikenali</b><br>";
                continue; // skip ke data berikutnya
            }

            //---------------------------------------------------------------------------------"Message":"Data Tidak Ada Perubahan"

            if ((isset($hasil['Error']) && $hasil['Error'] === 'false') || (isset($hasil['success']) && $hasil['success'] === true)
                || (isset($hasil['code']) && $hasil['code'] === 200)
                ||  (isset($hasil['Message']) && $hasil['Message'] === "Data Tidak Ada Perubahan")
            ) {

                $this->apimodel->update_status($row->id, 'sukses', json_encode($hasil));

                //disini bakal cek ketika nama = "/jabatan/save"
                if ($row->nama == '/jabatan/save' && $row->table_name == 'jabatan_riwayat') {
                    $rwJabatanId = $hasil['mapData']['rwJabatanId'];
                    echo "rwJabatanId: " . $rwJabatanId . "<br>";
                    $this->handle_after_success_rwjabatan($rwJabatanId, $row->id_table);
                } else if ($row->nama == '/jabatan/save' && $row->table_name == 'plt_plh') {
                    $rwJabatanId = $hasil['mapData']['rwJabatanId'];
                    echo "<br> - plt plh setelah sukses - ";
                    echo "rwJabatanId: " . $rwJabatanId . "<br>";
                    $this->handle_after_success_rwpltplh($rwJabatanId, $row->id_table);
                }

                echo "<b style='color:green;'>✔ Sukses dikirim</b><br>";
            } else {

                $this->apimodel->update_status($row->id, 'gagal kirim data', json_encode($hasil));

                echo "<b style='color:red;'>✖ Gagal dikirim</b><br>";

                if (isset($hasil['message'])) {
                    echo "Error: " . $hasil['message'] . "<br>";
                }
            }

            echo "<hr>";
        }
    }



    public function exe_ws_siasn_file()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        header('Content-Type: text/html');

        $this->apimodel->update_status_error_file();

        $data = $this->apimodel->get_data_siap_kirim_file();
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


            if ($row->postget == 'POST') {
                $hasil = $this->kirimfilesiasnbasic($row->id_table, $apimwstoken);
            }

            //---------------------------------------------------------------------------------"Message":"Data Tidak Ada Perubahan"

            if ($hasil['message'] === "File berhasil di upload") {

                $this->apimodel->update_status($row->id, 'sukses', json_encode($hasil));

                echo "<b style='color:green;'>✔ Sukses dikirim</b><br>";
            } else {

                $this->apimodel->update_status($row->id, 'gagal kirim file', json_encode($hasil));

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

    public function kirim_ws_siasn_get($api_mws_token, $url)
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

    public function kirim_ws_siasn_delete($api_mws_token, $url)
    {
        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token,
            ),

            // 🔥 penting untuk SIASN
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,

            // 🔥 WAJIB (biar gak kena reset 104)
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',

            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
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


    public function handle_after_success_rwjabatan($rwJabatanId, $id_table)
    {
        // 1. Update jabatan_riwayat
        $this->db->query("
        UPDATE jabatan_riwayat 
        SET RW_JABATAN_ID_SAPK = ? 
        WHERE JABATAN_RIWAYAT_ID = ?
    ", [$rwJabatanId, $id_table]);

        // 2. Ambil data upload dokumen
        $query = $this->db->query("
        SELECT * FROM post_data_siap 
        WHERE nama = '/upload-dok' 
        AND status = 'tunggu id riwayat'
    ");

        $results = $query->result();

        foreach ($results as $p) {

            $body = json_decode($p->bodyjson, true);

            if ($body) {
                $body['id_riwayat'] = $rwJabatanId;

                $this->db->query("
                UPDATE post_data_siap 
                SET bodyjson = ?, status = 'siap kirim'
                WHERE id = ?
            ", [json_encode($body), $p->id]);
            }
        }
    }

    public function handle_after_success_rwpltplh($rwJabatanId, $id_table)
    {
        // 1. Update plt_plh
        $this->db->query("
        UPDATE plt_plh 
        SET RW_JABATAN_ID_SAPK = ? 
        WHERE JABATAN_RIWAYAT_ID = ?
    ", [$rwJabatanId, $id_table]);

        // 2. Ambil data upload dokumen
        $query = $this->db->query("
        SELECT * FROM post_data_siap 
        WHERE nama = '/upload-dok' 
        AND status = 'tunggu id riwayat'
    ");

        $results = $query->result();

        foreach ($results as $p) {

            $body = json_decode($p->bodyjson, true);

            if ($body) {
                $body['id_riwayat'] = $rwJabatanId;

                $this->db->query("
                UPDATE post_data_siap 
                SET bodyjson = ?, status = 'siap kirim'
                WHERE id = ?
            ", [json_encode($body), $p->id]);
            }
        }
    }


    public function kirimfilesiasnbasic($id, $getApiMwsToken)
    {

        if ($id) {
            $this->db->select('s.RW_JABATAN_ID_SAPK, s.FILE_PDF, s.ESELON_ID, s.INSTANSI_KERJA_ID_SAPK, s.JFT_ID_SAPK, s.JFU_ID_SAPK, s.JENIS_JABATAN_SAPK, s.jenisMutasiId, s.jenisPenugasanId, s.NO_SK, p.ID_SAPK, s.SATUAN_KERJA_ID_SAPK, s.TANGGAL_SK, s.TMT_JABATAN, s.tmtMutasi, s.TANGGAL_PELANTIKAN, s.UNOR_ID_SAPK');
            $this->db->from('jabatan_riwayat s');
            $this->db->join('pegawai p', 's.PEGAWAI_ID = p.PEGAWAI_ID');
            $this->db->where('s.JABATAN_RIWAYAT_ID', $id);
            $query = $this->db->get();

            if ($query->num_rows() == 0) return false;
            $result = $query->row();

            // Panggil fungsi copyToTemp
            if (!$this->copyToTemp($result->FILE_PDF)) {
                // Catat error, update status, dan return
                echo "Gagal menyalin file ke temp, kirim dibatalkan.<br>";
                return ['message' => 'Gagal copy file ke temp'];
            }

            $file2 = FCPATH . "tmp_dokumen/" . basename($result->FILE_PDF);
            if (!file_exists($file2)) {
                echo "File temp tidak ditemukan setelah copy!<br>";
                return ['message' => 'File temp tidak ada'];
            }

            // Kirim ke SIASN
            $id_ref_dokumen = '872';
            $hasil = $this->post_file($getApiMwsToken, $result->RW_JABATAN_ID_SAPK, $id_ref_dokumen, $file2);
            $responseArray = json_decode($hasil, true);
            $this->deleteAllTempFiles();
            return $responseArray;
        }
    }

    public function post_file($api_mws_token, $id_riwayat, $id_ref_dokumen, $file)
    {

        // $fields = array(
        // 	'id_riwayat' =>   $id_riwayat,
        // 	'id_ref_dokumen' =>   $id_ref_dokumen,
        // 	'file' => new CURLFILE($file)
        // );

        // echo '<pre>';
        // print_r($fields);
        // echo '</pre>';

        $sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
        $api_mws_token = "Bearer " . $api_mws_token;

        $curl = curl_init();

        echo " masuk post upload ";
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/upload-dok-rw',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  array('id_riwayat' => $id_riwayat, 'id_ref_dokumen' => $id_ref_dokumen, 'file' => new CURLFILE($file)),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: multipart/form-data',
                'Accept: application/json',
                'Auth: ' . $sso_token,
                'Authorization: ' . $api_mws_token,
                'Cookie: BIGipServerpool_apiws_prod_8243=1091068938.13088.0000; ff8d625df24f2272ecde05bd53b814bc=72356b83ca8501c29aa28542a6d89aa6'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));



        $response = curl_exec($curl);

        // echo "<pre>";
        // echo "HTTP CODE: " . "\n\n";
        // echo "RESPONSE:\n";
        // print_r($response);
        // echo "</pre>";
        // die();



        $messagex = '';

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            $messagex = "cURL Error: " . $error_msg . ' --- file : ' . $file;
        } else {
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // echo "HTTP Status Code: " . $http_code . "\n";
            // echo "Response: " . $response;
            $messagex = $response;
        }


        curl_close($curl);
        // $hasil['data']['sso_token'] = $sso_token;
        // $hasil['data']['api_mws_token'] = $api_mws_token;
        // $hasil['data']['return'] = $response;

        // echo $response;
        return $messagex;
        // return $hasil;
    }

    // // copy file pdf dari yang  di tampilkan aplikasi siap ke folder tmp_dikumen sebelum dikirim ke siasn
    // public function copyToTemp($source_path)
    // {
    //     // TRACE 1: Cek parameter input
    //     echo "<pre>";
    //     echo "=== TRACE COPY TOTEMP ===\n";
    //     echo "Source path: " . $source_path . "\n";

    //     // Tentukan lokasi folder temporary
    //     $temp_path = FCPATH . "tmp_dokumen/";
    //     echo "Temp path: " . $temp_path . "\n";

    //     // Cek apakah folder temporary ada, jika tidak maka buat foldernya
    //     if (!is_dir($temp_path)) {
    //         echo "Folder temp tidak ditemukan, mencoba membuat...\n";
    //         $mkdir_result = mkdir($temp_path, 0777, true);
    //         echo "Hasil membuat folder: " . ($mkdir_result ? "BERHASIL" : "GAGAL") . "\n";
    //         if (!$mkdir_result) {
    //             echo "Error creating directory: " . error_get_last()['message'] . "\n";
    //         }
    //     } else {
    //         echo "Folder temp sudah ada\n";
    //     }

    //     // Cek apakah folder bisa ditulisi
    //     if (!is_writable($temp_path)) {
    //         echo "ERROR: Folder temp tidak bisa ditulisi!\n";
    //         echo "Permission: " . substr(sprintf('%o', fileperms($temp_path)), -4) . "\n";
    //     }

    //     // URL sumber file
    //     $source_url = "https://siap-bkpsdm.probolinggokab.go.id/" . $source_path;
    //     echo "Source URL: " . $source_url . "\n";

    //     // Nama file untuk disimpan di folder temporary
    //     $file_name = basename($source_url);
    //     $destination_path = $temp_path . $file_name;
    //     echo "Destination path: " . $destination_path . "\n";

    //     // TRACE 2: Cek koneksi ke URL
    //     echo "\n=== MENCoba KONEKSI KE URL ===\n";

    //     // Coba dengan cURL (lebih informatif)
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $source_url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //     curl_setopt($ch, CURLOPT_NOBODY, true); // Cek header saja dulu
    //     curl_exec($ch);
    //     $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     $curl_error = curl_error($ch);
    //     curl_close($ch);

    //     echo "HTTP Response Code: " . $http_code . "\n";
    //     if ($curl_error) {
    //         echo "CURL Error: " . $curl_error . "\n";
    //     }

    //     if ($http_code != 200) {
    //         echo "ERROR: File tidak bisa diakses! HTTP Code: " . $http_code . "\n";
    //         echo "Coba akses manual: " . $source_url . "\n";
    //         echo "</pre>";
    //         return false;
    //     }

    //     // TRACE 3: Ambil konten file
    //     echo "\n=== MENGAMBIL KONTEN FILE ===\n";

    //     // Coba dengan file_get_contents
    //     $file_content = @file_get_contents($source_url);
    //     if ($file_content === false) {
    //         echo "file_get_contents gagal, mencoba cURL...\n";

    //         // Fallback dengan cURL untuk ambil konten
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $source_url);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //         $file_content = curl_exec($ch);
    //         $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //         $curl_error = curl_error($ch);
    //         curl_close($ch);

    //         echo "cURL HTTP Code: " . $http_code . "\n";
    //         if ($curl_error) {
    //             echo "cURL Error: " . $curl_error . "\n";
    //         }

    //         if ($http_code != 200 || $file_content === false) {
    //             echo "ERROR: Gagal mengambil konten file!\n";
    //             echo "</pre>";
    //             return false;
    //         }

    //         echo "Berhasil mengambil konten dengan cURL, size: " . strlen($file_content) . " bytes\n";
    //     } else {
    //         echo "Berhasil mengambil konten dengan file_get_contents, size: " . strlen($file_content) . " bytes\n";
    //     }

    //     // TRACE 4: Tulis file
    //     echo "\n=== MENULIS FILE ===\n";
    //     $result = file_put_contents($destination_path, $file_content);

    //     if ($result === false) {
    //         echo "ERROR: Gagal menulis file ke: $destination_path\n";
    //         echo "Error terakhir: " . error_get_last()['message'] . "\n";
    //         echo "Cek permission folder: " . $temp_path . "\n";
    //         echo "</pre>";
    //         error_log("Gagal menulis file ke folder temporary: $destination_path");
    //         return false;
    //     } else {
    //         echo "SUKSES! File berhasil ditulis, size: " . $result . " bytes\n";
    //         echo "File ada di: " . $destination_path . "\n";
    //         echo "=== TRACE SELESAI ===\n";
    //         echo "</pre>";
    //         return true;
    //     }
    // }


    public function copyToTemp($source_path)
    {
        // Tentukan folder temporary
        $temp_dir = FCPATH . "tmp_dokumen/";
        if (!is_dir($temp_dir)) {
            if (!mkdir($temp_dir, 0777, true)) {
                error_log("Gagal membuat folder temp: " . $temp_dir);
                return false;
            }
        }

        // Nama file
        $file_name = basename($source_path);
        $dest_path = $temp_dir . $file_name;

        // Path lokal absolut (asumsi file ada di dalam FCPATH)
        $local_source = FCPATH . $source_path; // contoh: /var/www/html/dokumen/.../file.pdf

        // Cek apakah file ada di lokal
        if (file_exists($local_source) && is_readable($local_source)) {
            // Salin langsung dengan copy()
            if (copy($local_source, $dest_path)) {
                echo "File berhasil disalin dari lokal: $local_source<br>";
                return true;
            } else {
                error_log("Gagal menyalin file dari $local_source ke $dest_path");
                return false;
            }
        }

        // Jika file tidak ditemukan secara lokal, coba melalui HTTP (fallback)
        $source_url = "https://siap-bkpsdm.probolinggokab.go.id/" . $source_path;
        echo "File lokal tidak ditemukan, mencoba HTTP: $source_url<br>";

        $file_content = @file_get_contents($source_url);
        if ($file_content === false) {
            // Coba dengan cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $source_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $file_content = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code != 200 || empty($file_content)) {
                echo "ERROR: File tidak dapat diakses (HTTP $http_code)<br>";
                error_log("Gagal mengambil file dari URL: $source_url, HTTP $http_code");
                return false;
            }
        }

        // Tulis ke temp
        if (file_put_contents($dest_path, $file_content) === false) {
            error_log("Gagal menulis file ke $dest_path");
            return false;
        }

        echo "File berhasil diunduh dari HTTP dan disimpan ke temp<br>";
        return true;
    }

    // hapus semua yang ada di tmp_dokumen
    public function deleteAllTempFiles()
    {
        $temp_directory = "tmp_dokumen/";

        // Cek apakah folder temporary ada
        if (is_dir($temp_directory)) {
            // Ambil semua file di dalam folder
            $files = scandir($temp_directory);

            foreach ($files as $file) {
                // Lewati direktori '.' dan '..'
                if ($file !== '.' && $file !== '..') {
                    $file_path = $temp_directory . $file;

                    // Hapus file jika itu adalah file
                    if (is_file($file_path)) {
                        unlink($file_path);
                    }
                }
            }
            return true; // Semua file berhasil dihapus
        } else {
            return false; // Folder tidak ditemukan
        }
    }
}
