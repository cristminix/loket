<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loket extends CI_Controller {

	public function index()
	{
		// $serial_number = License::GenerateSerialNumber($hardware_id);
		
		// License::GenerateSupportFile([
		// 	'nama_instansi'=>'PUSKESMAS GRINTING',
		// 	'alamat'=>'Jl. Dr. Sudrajat No. 66',
		// 	'telp'=>'089612436675',
		// 	'email'=>'puskesmasgrinting@gmail.com'
		// ]);
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$telp = License::GetPhone();
		$hardware_id = License::GetHardwareId('c');
		
		$is_licensed = License::IsSoftwareLicensed();
		$data = [
			'nama_instansi' => $nama_instansi,
			'alamat_instansi' => $address,
			'hardware_id'=>$hardware_id,
			'telp' => $telp,
			'is_licensed'=>$is_licensed
		];

		$this->load->view('loket/index', $data);
	}

	public function info()
	{
		phpinfo();
	}
}
