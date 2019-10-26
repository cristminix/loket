<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_setting extends CI_Model {

	// public function get_kode_jenis_pendaftaran()
	// {
	// 	$kode_jenis_pendaftaran = [];
	// 	$jenis_pendaftaran = $this->get_jenis_pendaftaran();

	// 	foreach ($jenis_pendaftaran as $jp) {
	// 		$kode_jenis_pendaftaran[$jp->slug]=$jp->kode;
	// 	}

	// 	return $kode_jenis_pendaftaran;
	// }

	public function get_setting($key)
	{
		return $this->db->get('m_setting')->row()->{$key};
	}

	public function get_all()
	{
		return $this->db->get('m_setting')->result_object();
	
	}
	public function get_value($key)
	{
		return $this->db->where('key',$key)->select('value')->get('m_setting')->row()->value;
		# code...
	}
	public function update($pl)
	{
		return $this->db->where('key',$pl->key)->update('m_setting',['value'=>$pl->value]);
		# code...
	}
}
