<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Epusulanpemberhentianmodel extends SB_Model
{

	public $table = 'ep_tx_usulan_pemberhentian';
	public $primaryKey = 'id';

	public function __construct()
	{
		parent::__construct();
	}

	public static function querySelect()
	{

		return "   SELECT ep_tx_usulan_pemberhentian.* FROM ep_tx_usulan_pemberhentian   ";

		// return "   SELECT ep_tx_usulan_pemberhentian.id, ep_tx_usulan_pemberhentian.satker_id, ep_tx_usulan_pemberhentian.usulan_nomor, ep_tx_usulan_pemberhentian.usulan_nomor_surat, ep_tx_usulan_pemberhentian.usulan_tanggal, ep_tx_usulan_pemberhentian.tgl_act, ep_tx_usulan_pemberhentian.user_act, ep_tx_usulan_pemberhentian.usulan_status, ep_tx_usulan_pemberhentian.user_update_act, ep_tx_usulan_pemberhentian.tgl_update_act FROM ep_tx_usulan_pemberhentian   ";
	}
	public static function queryWhere()
	{

		return "  WHERE ep_tx_usulan_pemberhentian.id IS NOT NULL  AND ep_tx_usulan_pemberhentian.is_deleted = 0   ";
	}

	public static function queryGroup()
	{
		return "   ";
	}

	public static function getDetailUsulan($id)
	{
		$ci = &get_instance();
		$sql = "SELECT * FROM `ep_tx_usulan_pemberhentian` a INNER JOIN  `vw_satker_select` b ON a.`satker_id`=b.`SATKER_ID` WHERE md5(a.id) = '" . $id . "'";
		$a = $ci->db->query($sql)->row_array();
		return $a;
	}
}
