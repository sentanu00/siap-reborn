<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apimodel extends SB_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public static function getpegawaibiodata($nip)
	{


		return "   SELECT * FROM (SELECT a.NIP_BARU,CONCAT(IFNULL(a.GELAR_DEPAN,''),IF(IFNULL(a.GELAR_DEPAN,'') != '','. ',''),a.NAMA,IF(IFNULL(a.GELAR_BELAKANG,'') != '',', ',''),IFNULL(GELAR_BELAKANG,'')) as NAMA,d.NAMA AS JABATAN,e.PANGKAT,sa.NAMA as NAMA_SATKER,CONCAT('http://siap.bkd.probolinggokab.go.id/main/foto/',a.NIP_BARU,'/foto_setengah_',a.NIP_BARU,'.jpeg') AS URL_FOTO FROM pegawai a
LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
LEFT JOIN (SELECT PEGAWAI_ID,pa.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,pb.NAMA as PANGKAT FROM `pangkat_riwayat` pa INNER JOIN pangkat pb ON pb.PANGKAT_ID=pa.PANGKAT_ID WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID
INNER JOIN satker sa ON sa.`SATKER_ID`=LEFT(a.`SATKER_ID`,2) WHERE a.NIP_BARU = '$nip') AS pegawai";
	}

	public static function getlistpegawai($nama = '')
	{

		$ci = &get_instance();
		$wh = " AND a.NAMA LIKE '%$nama%'";

		$ttl = $ci->db->query("SELECT COUNT(*) as TTL FROM (SELECT a.NIP_BARU,CONCAT(IFNULL(a.GELAR_DEPAN,''),IF(IFNULL(a.GELAR_DEPAN,'') != '','. ',''),a.NAMA,IF(IFNULL(a.GELAR_BELAKANG,'') != '',', ',''),IFNULL(GELAR_BELAKANG,'')) as NAMA,d.NAMA AS JABATAN,e.PANGKAT,sa.NAMA as NAMA_SATKER,CONCAT('http://siap.bkd.probolinggokab.go.id/main/foto/',a.NIP_BARU,'/foto_setengah_',a.NIP_BARU,'.jpeg') AS URL_FOTO FROM pegawai a
LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
LEFT JOIN (SELECT PEGAWAI_ID,pa.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,pb.NAMA as PANGKAT FROM `pangkat_riwayat` pa INNER JOIN pangkat pb ON pb.PANGKAT_ID=pa.PANGKAT_ID WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID
INNER JOIN satker sa ON sa.`SATKER_ID`=LEFT(a.`SATKER_ID`,2) WHERE 0=0 $wh) AS pegawai")->row();
		$total = $ttl->TTL;
		$hasil = $ci->db->query("SELECT * FROM (SELECT a.NIP_BARU,CONCAT(IFNULL(a.GELAR_DEPAN,''),IF(IFNULL(a.GELAR_DEPAN,'') != '','. ',''),a.NAMA,IF(IFNULL(a.GELAR_BELAKANG,'') != '',', ',''),IFNULL(GELAR_BELAKANG,'')) as NAMA,d.NAMA AS JABATAN,e.PANGKAT,sa.NAMA as NAMA_SATKER,CONCAT('http://siap.bkd.probolinggokab.go.id/main/foto/',a.NIP_BARU,'/foto_setengah_',a.NIP_BARU,'.jpeg') AS URL_FOTO FROM pegawai a
LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
LEFT JOIN (SELECT PEGAWAI_ID,pa.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,pb.NAMA as PANGKAT FROM `pangkat_riwayat` pa INNER JOIN pangkat pb ON pb.PANGKAT_ID=pa.PANGKAT_ID WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID
INNER JOIN satker sa ON sa.`SATKER_ID`=LEFT(a.`SATKER_ID`,2) WHERE 0=0 $wh) AS pegawai")->result();
		$a = array('total' => $total, 'data' => $hasil);
		return $a;


		/*
		return "   SELECT * FROM (SELECT a.NIP_BARU,CONCAT(IFNULL(a.GELAR_DEPAN,''),IF(IFNULL(a.GELAR_DEPAN,'') != '','. ',''),a.NAMA,IF(IFNULL(a.GELAR_BELAKANG,'') != '',', ',''),IFNULL(GELAR_BELAKANG,'')) as NAMA,d.NAMA AS JABATAN,e.PANGKAT,sa.NAMA as NAMA_SATKER,CONCAT('http://siap.bkd.probolinggokab.go.id/main/foto/',a.NIP_BARU,'/foto_setengah_',a.NIP_BARU,'.jpeg') AS URL_FOTO FROM pegawai a
LEFT JOIN (SELECT PEGAWAI_ID,ESELON_ID,NAMA,TMT_JABATAN FROM `jabatan_riwayat` WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_JABATAN DESC) AS d ON a.`PEGAWAI_ID`=d.PEGAWAI_ID
LEFT JOIN (SELECT PEGAWAI_ID,pa.PANGKAT_ID,TANGGAL_SK,TMT_PANGKAT,pb.NAMA as PANGKAT FROM `pangkat_riwayat` pa INNER JOIN pangkat pb ON pb.PANGKAT_ID=pa.PANGKAT_ID WHERE FLAG_DATA_TERAKHIR = 1 GROUP BY PEGAWAI_ID ORDER BY TMT_PANGKAT DESC) AS e ON a.`PEGAWAI_ID`=e.PEGAWAI_ID
INNER JOIN satker sa ON sa.`SATKER_ID`=LEFT(a.`SATKER_ID`,2)) AS pegawai WHERE (NIP_BARU LIKE '%$nip%' OR a.NAMA LIKE '%$nama%')";
		*/
	}


	public function get_data_utama($sso_token, $api_mws_token, $nip_baru)
	{
		// $api_mws_token = $this->session->userdata('token_apimws');
		// $sso_token = $this->session->userdata('token_sso');

		$sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
		$api_mws_token = "Bearer " . $api_mws_token;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama/' . $nip_baru,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: ' . $sso_token,
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

		// return $response;
		return $response;
	}

	public function data_utama_update($sso_token, $api_mws_token, $email, $noHp, $id, $agamaId, $alamat, $emailGov, $karis_karsu, $kelas_jabatan, $lokasiKerjaId, $bpjs, $noTelp, $noNpwp, $tglNpwp, $noTaspen, $tanggal_taspen)
	{
		// $api_mws_token = $this->session->userdata('token_apimws');
		// $sso_token = $this->session->userdata('token_sso');

		$sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
		$api_mws_token = "Bearer " . $api_mws_token;

		//echo " -- pns id model : " . $id;
		// echo '{
		// 		"pns_orang_id": "' . $id . '",
		// 		"agama_id": "' . $agamaId . '",
		// 		"alamat": "' . $alamat . '",
		// 		"email": "' . $email . '",
		// 		"email_gov": "' . $emailGov . '",
		// 		"kabupaten_id": "A5EB03E21FA2F6A0E040640A040252AD",
		// 		"karis_karsu": "' . $karis_karsu . '",
		// 		"kelas_jabatan": "' . $kelas_jabatan . '",
		// 		"kpkn_id": "",
		// 		"lokasi_kerja_id": "' . $lokasiKerjaId . '",
		// 		"nomor_bpjs": "' . $bpjs . '",
		// 		"nomor_hp": "' . $noHp . '",
		// 		"nomor_telpon": "' . $noTelp . '",
		// 		"npwp_nomor": "' . $noNpwp . '",
		// 		"npwp_tanggal": "' . $tglNpwp . '",
		// 		"tanggal_taspen": "' . $tanggal_taspen . '",
		// 		"tapera_nomor": "",
		// 		"taspen_nomor": "' . $noTaspen . '"
		// 	  }';
		$curl = curl_init();


		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/data-utama-update',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
				"pns_orang_id": "' . $id . '",
				"agama_id": "' . $agamaId . '",
				"alamat": "' . $alamat . '",
				"email": "' . $email . '",
				"email_gov": "' . $emailGov . '",
				"kabupaten_id": "A5EB03E21FA2F6A0E040640A040252AD",
				"karis_karsu": "' . $karis_karsu . '",
				"kelas_jabatan": "' . $kelas_jabatan . '",
				"kpkn_id": "",
				"lokasi_kerja_id": "' . $lokasiKerjaId . '",
				"nomor_bpjs": "' . $bpjs . '",
				"nomor_hp": "' . $noHp . '",
				"nomor_telpon": "' . $noTelp . '",
				"npwp_nomor": "' . $noNpwp . '",
				"npwp_tanggal": "' . $tglNpwp . '",
				"tanggal_taspen": "' . $tanggal_taspen . '",
				"tapera_nomor": "",
				"taspen_nomor": "' . $noTaspen . '"
			  }',
			CURLOPT_HTTPHEADER => array(

				'Auth: ' . $sso_token,
				'Authorization: ' . $api_mws_token,
				'Content-Type: application/json',
				'Accept: application/json',
				'Cookie: BIGipServerpool_apiws_prod_8243=1091068938.13088.0000; ff8d625df24f2272ecde05bd53b814bc=52e92f5f7cb4b88510e149ff70ffd569'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// $hasil['data']['sso_token'] = $sso_token;
		// $hasil['data']['api_mws_token'] = $api_mws_token;
		// $hasil['data']['return'] = $response;

		// return $response;
		return $response;
	}

	public function getApiMwsToken2()
	{
		try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://apimws.bkn.go.id/oauth2/token',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				// CURLOPT_SSLVERSION => 5, // Set SSL version to 1.1 or 1.2
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded',
					'Authorization: Basic TkU5WGROUkJUZ0xSNGU5cmx6SGl3d0FsRkhRYTpLUDB0U3lmWVhzSFJtQlB2RU5nb2pqMUN0S2Nh',
					'Cookie: ff8d625df24f2272ecde05bd53b814bc=ce158eaac3b25204bfaa39e480fc50f7; pdns=1091068938.58148.0000'
				),
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
			));

			$response = curl_exec($curl);
			$response_error = curl_error($curl);

			curl_close($curl);

			// Mengubah respons JSON menjadi array asosiatif
			$data = json_decode($response, true);

			// Memeriksa apakah token berhasil diperoleh
			if (isset($data['access_token'])) {
				// Simpan token API MWS ke dalam sesi
				// $this->session->set_userdata('token_apimws', $data['access_token']);

				return $data['access_token'];
			} else {
				throw new Exception('Gagal memperoleh token API MWS: ' . $response_error);
			}
		} catch (Exception $e) {
			// Tangani error yang terjadi
			echo 'Error dalam fungsi getApiMwsToken(): ' . $e->getMessage();
		}
	}


	public function getApiMwsToken()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id/oauth2/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic TkU5WGROUkJUZ0xSNGU5cmx6SGl3d0FsRkhRYTpLUDB0U3lmWVhzSFJtQlB2RU5nb2pqMUN0S2Nh',
				'Cookie: pdns=1091068938.58148.0000'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// Mengubah respons JSON menjadi array asosiatif
		$data = json_decode($response, true);

		// Simpan token API MWS ke dalam sesi
		// $this->session->set_userdata('token_apimws', $data['access_token']);

		return $data['access_token'];
	}

	public function getSsoToken()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'client_id=kabprobolinggows&grant_type=password&username=198307042010012012&password=Kustanti4783',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded'
			),
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// Mengubah respons JSON menjadi array asosiatif
		$data = json_decode($response, true);

		// Simpan token SSO ke dalam sesi
		// $this->session->set_userdata('token_sso', $data['access_token']);

		return $data['access_token'];
	}

	public function get_rw_wsbkn($sso_token, $api_mws_token, $nip_baru, $jenis_api)
	{

		switch ($jenis_api) {
			case "angkakredit":
				$kode_api = "/pns/rw-angkakredit/";
				//echo "Endpoint /pns/rw-angkakredit/{nipBaru} dipanggil";
				break;

			case "cltn":
				$kode_api = "/pns/rw-cltn/";
				//echo "Endpoint /pns/rw-cltn/{nipBaru} dipanggil";
				break;

			case "diklat":
				$kode_api = "/pns/rw-diklat/";
				//echo "Endpoint /pns/rw-diklat/{nipBaru} dipanggil";
				break;

			case "dp3":
				$kode_api = "/pns/rw-dp3/";
				//echo "Endpoint /pns/rw-dp3/{nipBaru} dipanggil";
				break;

			case "golongan":
				$kode_api = "/pns/rw-golongan/";
				//echo "Endpoint /pns/rw-golongan/{nipBaru} dipanggil";
				break;

			case "hukdis":
				$kode_api = "/pns/rw-hukdis/";
				//echo "Endpoint /pns/rw-hukdis/{nipBaru} dipanggil";
				break;

			case "jabatan":
				$kode_api = "/pns/rw-jabatan/";
				//echo "Endpoint /pns/rw-jabatan/{nipBaru} dipanggil";
				break;

			case "kursus":
				$kode_api = "/pns/rw-kursus/";
				//echo "Endpoint /pns/rw-kursus/{nipBaru} dipanggil";
				break;

			case "masakerja":
				$kode_api = "/pns/rw-masakerja/";
				//echo "Endpoint /pns/rw-masakerja/{nipBaru} dipanggil";
				break;

			case "pemberhentian":
				$kode_api = "/pns/rw-pemberhentian/";
				//echo "Endpoint /pns/rw-pemberhentian/{nipBaru} dipanggil";
				break;

			case "pendidikan":
				$kode_api = "/pns/rw-pendidikan/";
				//echo "Endpoint /pns/rw-pendidikan/{nipBaru} dipanggil";
				break;

			case "penghargaan":
				$kode_api = "/pns/rw-penghargaan/";
				//echo "Endpoint /pns/rw-penghargaan/{nipBaru} dipanggil";
				break;

			case "pindahinstansi":
				$kode_api = "/pns/rw-pindahinstansi/";
				//echo "Endpoint /pns/rw-pindahinstansi/{nipBaru} dipanggil";
				break;

			case "pnsunor":
				$kode_api = "/pns/rw-pnsunor/";
				//echo "Endpoint /pns/rw-pnsunor/{nipBaru} dipanggil";
				break;

			case "pwk":
				$kode_api = "/pns/rw-pwk/";
				//echo "Endpoint /pns/rw-pwk/{nipBaru} dipanggil";
				break;

			case "skp":
				$kode_api = "/pns/rw-skp/";
				//echo "Endpoint /pns/rw-skp/{nipBaru} dipanggil";
				break;

			case "skp22":
				$kode_api = "/pns/rw-skp22/";
				//echo "Endpoint /pns/rw-skp22/{nipBaru} dipanggil";
				break;
			case "refunor":
				$kode_api = "/referensi/ref-unor";
				//echo "Endpoint /pns/rw-skp22/{nipBaru} dipanggil";
				break;
			///referensi/ref-unor
			default:
				// Jika endpoint tidak cocok dengan yang ada dalam switch case
				$peringatan['code'] = 0;
				$peringatan['jenis_api'] = array(
					"webservice_bkn/wsbkn_rw?jenis_api=angkakredit&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=cltn&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=diklat&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=dp3&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=golongan&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=hukdis&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=jabatan&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=kursus&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=masakerja&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=pemberhentian&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=pendidikan&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=penghargaan&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=pindahinstansi&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=pnsunor&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=pwk&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=skp&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=skp22&pegawaiid={...}",
					"webservice_bkn/wsbkn_rw?jenis_api=refunor"
				);

				$json = json_encode($peringatan);
				return $json;
				exit();
				break;
		}


		$sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
		$api_mws_token = "Bearer " . $api_mws_token;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0' . $kode_api . $nip_baru,
			// CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/rw-jabatan/' . $nip_baru,
			// CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/jabatan/pns/' . $nip_baru,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: ' . $sso_token,
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

	// get_api_ws
	public function get_api_ws($sso_token, $api_mws_token, $nip_baru, $path)
	{

		$sso_token = "bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3MzE5NTQ4MzUsImlhdCI6MTczMTkxMTYzNSwianRpIjoiMzcyZTliZTctZmNhYS00NjFhLWE0OTYtMGUxN2ZmMzI4MDUwIiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiIxNzhkOWQ4OC1iOGRlLTRjYWEtYmQ1OS05NDg0NjdlZDJiOTYiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrYWJwcm9ib2xpbmdnb3dzIiwic2Vzc2lvbl9zdGF0ZSI6Ijg2NjFkZjkxLTBjNzMtNDk2Zi05N2YxLTM3MmJkZmYzNTBmNiIsImFjciI6IjEiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cHM6Ly9kZXYtY2x1c3Rlci5wcm9ib2xpbmdnb2thYi5nby5pZCIsImh0dHA6Ly8xMjcuMC4wLjE6MzAwMC8qIiwiaHR0cDovLzEyNy4wLjAuMTozMDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwLyoiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiLCJodHRwczovL2Rldi1jbHVzdGVyLnByb2JvbGluZ2dva2FiLmdvLmlkLyoiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItaW5mb2phYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW1vbml0b3ItcGVyZW5jYW5hYW4ta2VwZWdhd2FpYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yLXNrcG5zIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItcGVtZW51aGFuLWtlYi1wZWdhd2FpIiwidW1hX2F1dGhvcml6YXRpb24iLCJyb2xlOnNpYXNuLWluc3RhbnNpOnNrazphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3ItZXZhamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yX2l6aW5fcHBwayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6aXBhc246bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IlNSSSBLVVNUQU5USSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODMwNzA0MjAxMDAxMjAxMiIsImdpdmVuX25hbWUiOiJTUkkiLCJmYW1pbHlfbmFtZSI6IktVU1RBTlRJIiwiZW1haWwiOiJrdXN0YW50aTQ3QGdtYWlsLmNvbSJ9.L4spM6cVggKdzQAS8jw99mzy_bz-J5HZ128QnHhWV65pzlWkSp286wzAjoWDfcaIM8PTo70k0PeRG0ZdTMQrKsJ3-w_50SAvDUjDQnWhLNnVnKsg6Et50ifrE1k6AMLA5BrPwIC8TpjbWaB7hTQ3xk9sz8KgejGA9e4mPzaV53tKuLa-r9LCYJ2tQNP2-XxYZtizHs9gI2B59YEVJkmR0ne-IIFImKo-oicnr-ePO1FFFPrOGQWXxqwavyDT6f93zAjMGN7Tjwghvlpvj563aT1yFaEGN1b_eQR2Un5pBgbiI54NP7mx7PIdrTYY-QIfbv1rine6ZqtVQhtcJVTEkA";
		$api_mws_token = "Bearer " . $api_mws_token;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0' . $path . $nip_baru,
			// CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/pns/rw-jabatan/' . $nip_baru,
			// CURLOPT_URL => 'https://apimws.bkn.go.id:8243/apisiasn/1.0/jabatan/pns/' . $nip_baru,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'Auth: ' . $sso_token,
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
	}

	public function get_data_siap_kirim_data()
	{
		$this->db->from('post_data_siap p');
		$this->db->where('p.status', 'siap kirim data');
		$this->db->where('p.flag_eksekusi', 1); // 🔥 tambahkan ini
		$this->db->order_by('p.id', 'asc');

		return $this->db->get()->result(); // hasil berupa array object
	}

	public function get_data_siap_kirim_file()
	{
		$this->db->from('post_data_siap p');
		$this->db->where('p.status', 'siap kirim file');
		$this->db->where('p.flag_eksekusi', 1); // 🔥 tambahkan ini
		$this->db->order_by('p.id', 'asc');

		return $this->db->get()->result(); // hasil berupa array object
	}

	public function update_status($id, $status, $message = null)
	{
		$this->db->where('id', $id);
		$this->db->update('post_data_siap', [
			'status' => $status,
			'message' => $message,
			'last_sync_date' => date('Y-m-d H:i:s')
		]);
	}

	public function update_status_error_data()
	{
		$this->db->where('status', 'gagal kirim data');
		$this->db->where('create_date >=', date('Y-m-d H:i:s', strtotime('-2 days')));

		$this->db->update('post_data_siap', [
			'status' => 'siap kirim data',
			'last_sync_date' => date('Y-m-d H:i:s')
		]);
	}


	public function update_status_error_file()
	{
		$this->db->where('status', 'gagal kirim file');
		$this->db->where('create_date >=', date('Y-m-d H:i:s', strtotime('-2 days')));

		$this->db->update('post_data_siap', [
			'status' => 'siap kirim file',
			'last_sync_date' => date('Y-m-d H:i:s')
		]);
	}
}
