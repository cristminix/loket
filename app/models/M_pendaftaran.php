<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendaftaran extends CI_Model {
	public function get_nomor_pendaftaran($kode_jenis,&$jenis_pendaftaran=[]) 
	{
		$jenis_pendaftaran = $this->db->where(['kode' => $kode_jenis])
									  ->get('m_jenis_pendaftaran')->row_array();
		

		// print_r($jenis_pendaftaran);

		// die();
									  
		$nomor_pendaftaran = $this->db->where(['tanggal' => date('Y-m-d'), 'parent' => $jenis_pendaftaran['id']])
									  ->get('m_nomor_pendaftaran');

		if($nomor_pendaftaran->num_rows() > 0){
			return $nomor_pendaftaran->row()->nomor;
		}else{
			$nomor_pendaftaran = [
				'tanggal' => date('Y-m-d'),
				'parent' => $jenis_pendaftaran['id'],
				'nomor' => 1
			];

			$this->db->insert('m_nomor_pendaftaran', $nomor_pendaftaran);
			return $nomor_pendaftaran['nomor'];
		}
	}
	public function set_next_nomor_pendaftaran($kode_jenis)
	{
		$jp = [];
		$current = $this->get_nomor_pendaftaran($kode_jenis, $jp);

		
		$next = $current + 1;

		$this->db->where(['tanggal'=>date('Y-m-d'),'parent'=>$jp['id']])->update('m_nomor_pendaftaran',['nomor' => $next]);
	}
}

