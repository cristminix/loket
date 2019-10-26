<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jenis_pendaftaran extends CI_Model {

	public function get_kode_jenis_pendaftaran(&$jp_ids=[])
	{
		$kode_jenis_pendaftaran = [];
		$jenis_pendaftaran = $this->get_jenis_pendaftaran();

		foreach ($jenis_pendaftaran as $jp) {
			$kode_jenis_pendaftaran[$jp->slug]=$jp->kode;
			$jp_ids[$jp->slug]=$jp->id;
		}

		return $kode_jenis_pendaftaran;
	}

	public function get_jenis_pendaftaran()
	{
		return $this->db->get('m_jenis_pendaftaran')->result_object();
	}
}
