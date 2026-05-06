<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mutasimodel extends SB_Model
{



	public $table = 'jabatan_riwayat';
	public $primaryKey = 'JABATAN_RIWAYAT_ID';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{


		return "   SELECT jabatan_riwayat.* FROM jabatan_riwayat   ";
	}
	public static function queryWhere()
	{

		return "  WHERE jabatan_riwayat.JABATAN_RIWAYAT_ID IS NOT NULL   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}


	public function input_filename($data)
	{
		$this->db->insert('jabatan_riwayat', $data);
	}

	public function get_master_jabatan_fungsional_umum($nama)
	{
		$this->db->select('*');
		$this->db->from('master_jabatan_fungsional_umum');
		$this->db->like('nama', $nama);
		$this->db->where('aktif', 1);

		// if ($limit !== null) {
		// 	$this->db->limit($limit);
		// }

		// if ($offset !== null) {
		// 	$this->db->limit($offset);
		// }
		// $this->db->limit($limit);
		// $this->db->offset($offset);
		return $this->db->get()->result();
	}

	public function get_master_jabatan_fungsional_tertentu($nama)
	{
		$this->db->select('*');
		$this->db->from('master_jabatan_fungsional_tertentu');
		$this->db->like('nama', $nama);
		$this->db->where('aktif', 1);

		// if ($limit !== null) {
		// 	$this->db->limit($limit);
		// }

		// if ($offset !== null) {
		// 	$this->db->limit($offset);
		// }

		// $this->db->limit($limit);
		// $this->db->offset($offset);
		return $this->db->get()->result();
	}
	public function get_master_satker($id)
	{
		$this->db->select('*');
		$this->db->from('satker');
		$this->db->where('satker_id', $id);
		return $this->db->get()->result();
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
}
