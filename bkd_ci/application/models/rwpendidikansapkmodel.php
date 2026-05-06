<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwpendidikansapkmodel extends SB_Model 
{

	public function __construct() {
		parent::__construct();
		
	}

	public function get_nip_pegawai() {
		
		// $sql ="  SELECT * FROM pegawai AS p WHERE p.NIP_BARU LIKE '199306302019031003'   ";
		// // $query =  json_encode($this->db->query($sql));
		// $query = $this->db->query($sql);
		// return $query->result_array();

		$this->db->from('pegawai');
		$this->db->limit('2');
		$query = $this->db->get();
		return $query; 
		// ->result_array();
		
	}
	
	public function insert_rs_pendidikan_sapk($data) {
		
		// $sql ="  SELECT * FROM pegawai AS p WHERE p.NIP_BARU LIKE '199306302019031003'   ";
		// // $query =  json_encode($this->db->query($sql));
		// $query = $this->db->query($sql);
		// return $query->result_array();

		$data = array(
            // 'id'=>$data['id'],
            // 'idPns'=>$data['idPns'],
            // 'nipBaru'=>$data['nipBaru'],
            // 'nipLama'=>$data['nipLama'],
            // 'pendidikanId'=>$data['pendidikanId'],
            // 'pendidikanNama'=>$data['pendidikanNama'],
            // 'tahunLulus'=>$data['tahunLulus'],
            // 'tglLulus'=>$data['tglLulus'],
            // 'isPendidikanPertama'=>$data['isPendidikanPertama'],
            // 'namaSekolah'=>$data['namaSekolah'],
            // 'gelarDepan'=>$data['gelarDepan'],
            // 'gelarBelakang'=>$data['gelarBelakang'],

			'id'=>$data->id,
'idPns'=>$data->idPns,
'nipBaru'=>$data->nipBaru,
'nipLama'=>$data->nipLama,
'pendidikanId'=>$data->pendidikanId,
'pendidikanNama'=>$data->pendidikanNama,
'tahunLulus'=>$data->tahunLulus,
'tglLulus'=>$data->tglLulus,
'isPendidikanPertama'=>$data->isPendidikanPertama,
'namaSekolah'=>$data->namaSekolah,
'gelarDepan'=>$data->gelarDepan,
'gelarBelakang'=>$data->gelarBelakang,
        );
		return $this->db->insert('rw_pendidikan_sapk',$data);

		// $this->db->from('pegawai');
		// $this->db->limit('2');
		// $query = $this->db->get();
		// return $query; 
		// ->result_array();
		
	}

	
}

?>
