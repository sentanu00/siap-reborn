<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Webservice_model
{

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
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// Mengubah respons JSON menjadi array asosiatif
		$data = json_decode($response, true);

		// Simpan token API MWS ke dalam sesi
		$this->session->set_userdata('token_apimws', $data['access_token']);

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
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// Mengubah respons JSON menjadi array asosiatif
		$data = json_decode($response, true);

		// Simpan token SSO ke dalam sesi
		$this->session->set_userdata('token_sso', $data['access_token']);

		return $data['access_token'];
	}
}
