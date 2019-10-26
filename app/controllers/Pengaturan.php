<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	public function index()
	{
		$data = [
			'settings' => $this->m_setting->get_all()
		];
		$this->load->view('pengaturan/index', $data);
	
	}
	public function save()
	{
		$pl = json_decode(file_get_contents('php://input'));
		$pl->value = xss_clean($pl->value);
		$this->m_setting->update($pl);
		echo json_encode($pl);
	}
}