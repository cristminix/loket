<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_antrian_loket extends CI_Model {

	// public function get_kode_jenis_pendaftaran()
	// {
	// 	$kode_jenis_pendaftaran = [];
	// 	$jenis_pendaftaran = $this->get_jenis_pendaftaran();

	// 	foreach ($jenis_pendaftaran as $jp) {
	// 		$kode_jenis_pendaftaran[$jp->slug]=$jp->kode;
	// 	}

	// 	return $kode_jenis_pendaftaran;
	// }

	// public function get_setting($key)
	// {
	// 	return $this->db->get('m_setting')->row()->{$key};
	// }
	public function register($data)
	{
		return $this->db->insert('m_antrian_loket',$data);
	}
	public function pick($jp_id,$date,$status=1)
	{
		$row = $this->db->where(['status'=>$status,'jp_id'=>$jp_id,'tanggal'=>$date])
						->order_by('id','asc')
						->get('m_antrian_loket')
						->row();
		return $row();
	}
}