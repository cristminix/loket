<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antrian extends CI_Controller {

	public function index()
	{
		$data = [
			
		];
		$this->load->view('antrian/index', $data);
	
	}
	public function loket()
	{
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$telp = License::GetPhone();
		$jenis_pendaftaran = $this->m_jenis_pendaftaran->get_jenis_pendaftaran();
		$data = [
			'jenis_pendaftaran' => $jenis_pendaftaran,
			'app_name' => $this->m_setting->get_value('app_name'),
			'alamat_instansi' => $address,
			'nama_instansi' => $nama_instansi,
			'ws_server'=> $this->config->item('ws_server')
			

		];

	 

		$this->load->view('antrian/loket', $data);
	}
	public function loket_init()
	{
		
			
		$date = date('Y-m-d H:i:s',time());
		$dt= date('Y-m-d',time());
		$dal = [
			'curr_no' => 'n/a',
			'a_cx' => 0,
			'b_cx' => 0,
			'c_cx' => 0,
			'date' => $date
		];
		$rs = $this->db->where('DATE(date)',$dt)->get('m_display_antrian_loket');

		if($rs->num_rows()>0){
			$dal = $rs->row_array();
		}else{
			$this->db->insert('m_display_antrian_loket',$dal);
		}

		echo json_encode($dal);
		
	}
	public function poli()
	{
		$jenis_pendaftaran = $this->m_jenis_pendaftaran->get_jenis_pendaftaran();
		$data = [
			'jenis_pendaftaran' => $jenis_pendaftaran,
			'test' => 12
		];

	 

		$this->load->view('antrian/poli', $data);
	}

	public function apotek()
	{
		$jenis_pendaftaran = $this->m_jenis_pendaftaran->get_jenis_pendaftaran();
		$data = [
			'jenis_pendaftaran' => $jenis_pendaftaran,
			'test' => 12
		];

	 

		$this->load->view('antrian/pendaftaran', $data);
	}
}