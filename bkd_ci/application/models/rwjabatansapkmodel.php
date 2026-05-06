<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rwjabatansapkmodel extends SB_Model 
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
	
	public function insert_rs_jabatan_sapk($data) {
		
		$timetmtJabatan = strtotime(''.$data->tmtJabatan);
		$timetanggalSk = strtotime(''.$data->tanggalSk);


		$data = array(
			'id'=>$data->id,
			'idPns'=>$data->idPns,
			'nipBaru'=>$data->nipBaru,
			'nipLama'=>$data->nipLama,
			'jenisJabatan'=>$data->jenisJabatan,
			'instansiKerjaId'=>$data->instansiKerjaId,
			'instansiKerjaNama'=>$data->instansiKerjaNama,
			'satuanKerjaId'=>$data->satuanKerjaId,
			'satuanKerjaNama'=>$data->satuanKerjaNama,
			'unorId'=>$data->unorId,
			'unorNama'=>$data->unorNama,
			'unorIndukId'=>$data->unorIndukId,
			'unorIndukNama'=>$data->unorIndukNama,
			'eselon'=>$data->eselon,
			'eselonId'=>$data->eselonId,
			'jabatanFungsionalId'=>$data->jabatanFungsionalId,
			'jabatanFungsionalNama'=>$data->jabatanFungsionalNama,
			'jabatanFungsionalUmumId'=>$data->jabatanFungsionalUmumId,
			'jabatanFungsionalUmumNama'=>$data->jabatanFungsionalUmumNama,

			
			// 'tmtJabatan'=>$data->tmtJabatan,
			'tmtJabatan'=>date("Y-m-d H:i:s", $timetmtJabatan),
			'nomorSk'=>$data->nomorSk,
			// 'tanggalSk'=>$data->tanggalSk
			'tanggalSk'=>date("Y-m-d H:i:s", $timetanggalSk)
			
        );
		return $this->db->insert('rw_jabatan_sapk',$data);

		 
	}

	
}

?>
