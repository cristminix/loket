<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

	public function index()
	{
		$data = [
			
		];
		$this->load->view('master/index', $data);
	
	}
}