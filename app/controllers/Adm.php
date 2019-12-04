<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm extends CI_Controller {

	// one : satu loket
	// multiple : dua atau tiga loket per tombol tiket
	//    param : id_loket
	// allinone : semua menangani semua
	// merge    : satu menangani satu , dua menangani lebih dari satu
	public function loket($mode="one",$param="")
	{
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$telp = License::GetPhone();
		$daftar_poli_rs = $this->db->get('m_poli')->result_object();
		$daftar_poli = ['5'=>'Poli Kesehatan Awal'];
		$daftar_poli_all = [''=>'--PILIH POLI--'];

		foreach ($daftar_poli_rs as $poli) {
			$daftar_poli_all[$poli->id] = $poli->nama;
		}
		$dd_poli = form_dropdown('id_poli',$daftar_poli,'5','class="form-control" v-model="form.id_poli" @change="onChangePoli()" :disabled="form.id_antrian==\'\'"');
		$dd_poli_all = form_dropdown('id_poli',$daftar_poli_all,'','class="form-control" v-model="form.id_poli" @change="onChangePoli()" :disabled="form.id_antrian==\'\'"');
		$data = [
			'lokets' => $this->db->get('m_loket')->result_object(),
			'nama_instansi' => $nama_instansi,
			'alamat_instansi' => $address,
			'telp' => $telp,
			'dd_poli'=>$dd_poli,
			'dd_poli_all'=>$dd_poli_all,
			'mode'=>$mode,
			'ws_server'=> $this->config->item('ws_server')
			
		];
		switch ($mode) {
			case 'multiple':
				if(empty($param)){
					die('invalid param');
				}
				$data['jps'] = $this->m_jenis_pendaftaran->get_jenis_pendaftaran();
				$data['jp_id'] = $param;
			break;
			case 'merge':
				if(empty($param)){
					die('invalid param');
				}
				$data['jps'] = $this->m_jenis_pendaftaran->get_jenis_pendaftaran();
				$data['jp_ids'] = $param;
				$data['jp_ids_arr'] = explode('_',$param);
				$data['jp_ids_cx'] = count($data['jp_ids_arr']);
				// print_r($data['jp_ids_cx']);
				// die();
				$data['grid_width'] = 12/$data['jp_ids_cx'] ;
			break;
			default:
				# code...
				break;
		}
		$this->load->view('adm/loket/'.$mode, $data);
	
	}
	// Tampilkan daftar antrian tabular data
	public function loket_list()
	{
		$mode = $this->input->get('mode');

		

		$dt = date('Y-m-d', time());
		$db = $this->db->select('al.id,al.status,al.tanggal,al.nomor,al.waktu_mulai,jp.slug,jp.kode,jp.id jp_id')->where([
									'al.tanggal' => $dt,
									'al.status <>'=>' 5',
								])
							  ->join('m_jenis_pendaftaran jp','al.jp_id=jp.id')
							  ->order_by('al.id','asc');
		if($mode == 'multiple'){
			$jp_id = $this->input->get('jp_id');
			$db->where('jp.id',$jp_id);
		}
		if($mode == 'merge'){
			$jp_ids = $this->input->get('jp_ids');
			$jp_ids = explode('_', $jp_ids);
			$db->where_in('jp.id',$jp_ids);
		}
		$loket_list = $db->get('m_antrian_loket al')->result_array();
		echo json_encode($loket_list);
	}
	public function poli_list($id_poli="0")
	{
		$dt = date('Y-m-d', time());
/*
SELECT
map.id,
map.al_id,
map.tanggal,
map.waktu_mulai,
map.waktu_dilayani,
map.`status`,
map.nama,
map.alamat,
map.poli_id,
mp.nama AS nama_poli,
mal.nomor,
mjp.slug AS jenis
FROM
m_antrian_poli AS map
INNER JOIN m_poli AS mp ON map.poli_id = mp.id
INNER JOIN m_antrian_loket AS mal ON map.al_id = mal.id
INNER JOIN m_jenis_pendaftaran AS mjp ON mal.jp_id = mjp.id

*/
		$list = $this->db->select('map.id, map.al_id, map.tanggal, map.waktu_mulai, map.waktu_dilayani, map.status, map.nama, map.alamat, map.poli_id, mp.nama AS nama_poli, mal.nomor, mjp.slug AS jenis ')
						 ->join('m_poli mp','map.poli_id = mp.id','inner')
						 ->join('m_antrian_loket mal','map.al_id = mal.id','inner')
						 ->join('m_jenis_pendaftaran mjp','mal.jp_id = mjp.id','inner')
						 ->where('map.tanggal',$dt)
						 ->where('map.poli_id',$id_poli)
						 ->where('map.status <>',5)
						 ->order_by('map.id','asc')
						 ->get('m_antrian_poli map')
						 ->result_array();
						 // echo $this->db->last_query();
		echo json_encode($list);
	}
	public function apotek_list()
	{
		/*
SELECT
maa.tanggal,
maa.waktu_mulai,
maa.waktu_dilayani,
maa.`status`,
maa.poli_id,
maa.nama,
maa.alamat,
mjp.nama jenis,
mjp.slug jenis_slug
FROM
m_antrian_apotek AS maa
INNER JOIN m_antrian_poli AS map ON maa.map_id = map.id
INNER JOIN m_antrian_loket AS mal ON map.al_id = mal.id
INNER JOIN m_jenis_pendaftaran AS mjp ON mal.jp_id = mjp.id

		*/
		$dt = date('Y-m-d', time());
		$rs = $this->db->select("
				maa.id,
				maa.tanggal,
				maa.waktu_mulai,
				maa.waktu_dilayani,
				maa.`status`,
				maa.poli_id,
				maa.nama,
				maa.alamat,
				mjp.nama jenis,
				mjp.slug jenis_slug
			")->join('m_antrian_poli map','maa.map_id=map.id','left')
		      ->join('m_antrian_loket mal','map.al_id=mal.id','left')
		      ->join('m_jenis_pendaftaran mjp','mal.jp_id=mjp.id','left')
		      ->where('maa.tanggal',$dt)
		      ->where('maa.status <>',5)
		      ->order_by('maa.id','asc')
		      ->get('m_antrian_apotek maa')->result_array();

		    
		echo json_encode($rs);
	}
	public function laborat_list()
	{
		/*
SELECT
mal.tanggal,
mal.waktu_mulai,
mal.waktu_dilayani,
mal.`status`,
mal.poli_id,
mal.nama,
mal.alamat,
mjp.nama jenis,
mjp.slug jenis_slug
FROM
m_antrian_laborat AS mal
INNER JOIN m_antrian_poli AS map ON mal.map_id = map.id
INNER JOIN m_antrian_loket AS mal ON map.al_id = mal.id
INNER JOIN m_jenis_pendaftaran AS mjp ON mal.jp_id = mjp.id

		*/
		$dt = date('Y-m-d', time());
		$rs = $this->db->select("
				mal.id,
				mal.tanggal,
				mal.waktu_mulai,
				mal.waktu_dilayani,
				mal.`status`,
				mal.poli_id,
				mal.nama,
				mal.alamat,
				mjp.nama jenis,
				mjp.slug jenis_slug
			")->join('m_antrian_poli map','mal.map_id=map.id','left')
		      ->join('m_antrian_loket ml','map.al_id=ml.id','left')
		      ->join('m_jenis_pendaftaran mjp','ml.jp_id=mjp.id','left')
		      ->where('mal.tanggal',$dt)
		      ->where('mal.status <>',5)
		      ->order_by('mal.id','asc')
		      ->get('m_antrian_laborat mal')->result_array();
		echo json_encode($rs);
	}
	// Tampilkan daftar antrian tabular data
	public function loket_skip($id)
	{
		$this->db->where('id',$id)->update('m_antrian_loket',['status'=>3]);
	}
	
	public function poli_skip($id)
	{
		// copy record
		$old_record = $this->db->where('id',$id)->get('m_antrian_poli')->row_array();
		// create new record
		$new_record = $old_record;
		unset($new_record['id']);
		$new_record['status'] = 1;

		// delete record
		$this->db->where('id',$id)->delete('m_antrian_poli');

		// insert new record
		$this->db->insert('m_antrian_poli',$new_record);

		// create new record
		# code...
	}
	
	public function laborat_skip($id)
	{
		
		// copy record
		$old_record = $this->db->where('id',$id)->get('m_antrian_laborat')->row_array();
		// create new record
		$new_record = $old_record;
		unset($new_record['id']);
		$new_record['status'] = 1;

		// delete record
		$this->db->where('id',$id)->delete('m_antrian_laborat');

		// insert new record
		$this->db->insert('m_antrian_laborat',$new_record);
	}
	public function apotek_skip($id)
	{
		
		// copy record
		$old_record = $this->db->where('id',$id)->get('m_antrian_apotek')->row_array();
		// create new record
		$new_record = $old_record;
		unset($new_record['id']);
		$new_record['status'] = 1;

		// delete record
		$this->db->where('id',$id)->delete('m_antrian_apotek');

		// insert new record
		$this->db->insert('m_antrian_apotek',$new_record);
	}
	public function loket_register()
	{
		$form = json_decode(file_get_contents('php://input'));
		// print_r($form);

		$al_id   = $form->id_antrian;
		$nomor   = $form->nomor;
		$kode    = $form->kode;
		$nama    = $form->nama;
		$alamat  = $form->alamat;
		$id_poli = $form->id_poli;
		$tanggal = $form->tanggal;
		
		$tanggal = date('Y-m-d',time());
		$waktu   = date('H:i:s',time());

		$rec_al  = [
			'status' => 5,
			'poli_id' => $id_poli,
			'waktu_dilayani'=> $waktu
		];
		//UPDATE AL
		$this->db->where('id',$al_id)->update('m_antrian_loket',$rec_al);

		$rec_ap = [
			'al_id' => $al_id,
			'nama' => $nama,
			'alamat' => $alamat,
			'poli_id'=>$id_poli,
			'tanggal'=>$tanggal,
			'waktu_mulai'=>$waktu,
			'status'=>1
		];
		//CHECK AP
		$rs = $this->db->where(['al_id'=>$al_id])->get('m_antrian_poli');
		if($rs->num_rows() > 0){
			//REC exists
			unset($rec_ap['al_id']);
			$this->db->where(['al_id'=>$al_id])->update('m_antrian_poli',$rec_ap);
		}else{
			// NEW rec
			$this->db->insert('m_antrian_poli',$rec_ap);
		}
		$result = [
			'status' => true,
			'ap' => $rec_ap,
			'al' => $rec_al
		];
		// UPDATE DAL 
		// $this->db->where('date',$tanggal)
		$context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
		$socket->send(json_encode(['cat'=>'onRegPoli','data'=>$rec_ap]) );
		
		$this->loket_update_dal((object)['nomor'=>$nomor,'skip'=>true]);

		echo json_encode($result);
	}
	
	public function loket_update_dal($src_lkt='')
	{
		$lkt = json_decode(file_get_contents('php://input'));
		
		if(!empty($src_lkt)){
			$lkt = $src_lkt;
		}
		
		$date = date('Y-m-d H:i:s',time());
		$dt= date('Y-m-d',time());
		$tanggal = date('Y-m-d',time());

		$a_cx = $this->db->where(['tanggal'=>$tanggal,'jp_id'=>1,'status'=>5])->get('m_antrian_loket')->num_rows();
		$b_cx = $this->db->where(['tanggal'=>$tanggal,'jp_id'=>2,'status'=>5])->get('m_antrian_loket')->num_rows();
		$c_cx = $this->db->where(['tanggal'=>$tanggal,'jp_id'=>3,'status'=>5])->get('m_antrian_loket')->num_rows();
		
		$dal = [
			'curr_no' => $lkt->nomor,
			'a_cx' => $a_cx,
			'b_cx' => $b_cx,
			'c_cx' => $c_cx,
			'date' => $date
		];

		//CHECK
		$rs = $this->db->where('DATE(date)',$dt)->get('m_display_antrian_loket')->num_rows();
		if($rs > 0){
			$this->db->where('DATE(date)',$dt)->update('m_display_antrian_loket',$dal);
		}else{
			$this->db->insert('m_display_antrian_loket',$dal);
		}

		// Ini lah sesuatu yang baru
	    
	    $context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
	    if(!empty($_GET['repeatCall'])){
			$socket->send(json_encode(['cat'=>'onRepeatCall','data'=>$dal]) );
		}
	    $socket->send(json_encode(['cat'=>'onUpdateDal','data'=>$dal]) );

	    if(empty($src_lkt)){
	    	echo json_encode($lkt);
	    }
		
	}
	public function poli_register()
	{
		$form = json_decode(file_get_contents('php://input'));
		// print_r($form);

		$id_ap   = $form->id_ap;
		$id_poli   = $form->id_poli;
		$to_id_poli = $form->to_id_poli;


		
		$tanggal = date('Y-m-d',time());
		$waktu   = date('H:i:s',time());

		$rec_apo  = [
			'status' => 5,
			// 'poli_id' => $id_poli,
			'waktu_dilayani'=> $waktu
		];
		//UPDATE AP
		$this->db->where('id',$id_ap)->update('m_antrian_poli',$rec_apo);

		$rec_ap = $this->db->where('id',$id_ap)->get('m_antrian_poli')->row_array();
		unset($rec_ap['id']);
		unset($rec_ap['waktu_dilayani']);


		$rec_ap ['waktu_mulai'] = $waktu;
		$rec_ap	['status'] = 1;
		$rec_ap	['poli_id'] = $to_id_poli;

		
			// NEW rec
			$this->db->insert('m_antrian_poli',$rec_ap);
		// }
		$result = [
			'status' => true,
			'dst' => $rec_ap,
			// 'src' => $rec_al
		];
		// UPDATE DAL 
		// $this->db->where('date',$tanggal)
		$context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
		$socket->send(json_encode(['cat'=>'onRegPoli','data'=>$rec_ap]) );
		
		$this->loket_update_dal((object)['nomor'=>$nomor,'skip'=>true]);

		echo json_encode($result);
	}
	public function lab_register()
	{
		$form = json_decode(file_get_contents('php://input'));
		// print_r($form);

		$id_lab   = $form->id_lab;
		$id_poli   = $form->id_poli;
		$to_id_poli = $form->to_id_poli;


		
		$tanggal = date('Y-m-d',time());
		$waktu   = date('H:i:s',time());

		$rec_apo  = [
			'status' => 5,
			// 'poli_id' => $id_poli,
			'waktu_dilayani'=> $waktu
		];
		//UPDATE AP
		$this->db->where('id',$id_lab)->update('m_antrian_laborat',$rec_apo);

		$rec_ap = $this->db->where('id',$id_lab)->get('m_antrian_laborat')->row_array();
		unset($rec_ap['id']);
		$al_id = $this->db->select('map.al_id')
						  ->from('m_antrian_laborat mal')
						  ->join('m_antrian_poli map','map.id = mal.map_id')
						  ->get()->row()->al_id;

		$rec_ap ['waktu_mulai'] = $waktu;
		unset($rec_ap ['waktu_dilayani']);
		$rec_ap ['tanggal'] = $tanggal;
		$rec_ap	['status'] = 1;
		$rec_ap	['poli_id'] = $to_id_poli;
		// $rec_ap	['al_id'] = $to_id_poli;
		unset($rec_ap['map_id']);
				//CHECK AP
		$rs = $this->db->where(['al_id'=>$al_id,'poli_id'=>$to_id_poli])->get('m_antrian_poli');
		

		// die($this->db->last_query());					  
		$rec_ap['al_id'] = $al_id;				  
		// if($rs->num_rows() > 0){
		// 	//REC exists
		// 	// unset();
			
		// 	$this->db->where(['al_id'=>$al_id,'poli_id'=>$to_id_poli])->update('m_antrian_poli',$rec_ap);
		// }else{
			// NEW rec
			// unset($rec_ap['al_id']);
			
			$this->db->insert('m_antrian_poli',$rec_ap);
		// }
		$result = [
			'status' => true,
			'dst' => $rec_ap,
			// 'src' => $rec_al
		];
		// UPDATE DAL 
		// $this->db->where('date',$tanggal)
		$context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
		$socket->send(json_encode(['cat'=>'onRegPoli','data'=>$rec_ap]) );
		
		$this->loket_update_dal((object)['nomor'=>$nomor,'skip'=>true]);

		echo json_encode($result);
	}
	public function poli($id_poli="",$slug="")
	{
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$telp = License::GetPhone();
		$daftar_poli_rs = $this->db->get('m_poli')->result_object();
		$daftar_poli = [''=>'--Pilih Poli--'];
		$daftar_poli_obj = [];
		foreach ($daftar_poli_rs as $poli) {
			$daftar_poli[$poli->id] = $poli->nama;
			$daftar_poli_obj[$poli->id] = $poli;
		}
		$dd_poli = form_dropdown('id_poli',$daftar_poli,'','class="form-control" v-model="id_poli" @change="onChangePoli()" v-show="id_poli.length==0"');
		
		$daftar_poli_rs2 = $this->db->where('id <>',5)->get('m_poli')->result_object();
		$daftar_poli2 = [''=>'--Pilih Poli--'];
		$daftar_poli_obj2 = [];
		foreach ($daftar_poli_rs2 as $poli) {
			$daftar_poli2[$poli->id] = $poli->nama;
			$daftar_poli_obj2[$poli->id] = $poli;
		}
		$dd_poli2 = form_dropdown('to_id_poli',$daftar_poli2,'','class="form-control" v-model="to_id_poli"  v-show="id_poli==5"');

		$data = [
			'lokets' => $this->db->get('m_loket')->result_object(),
			'nama_instansi' => $nama_instansi,
			'alamat_instansi' => $address,
			'telp' => $telp,
			'dd_poli_all'=>$dd_poli,
			'dd_poli2'=>$dd_poli2,
			'id_poli'=>$id_poli,
			'daftar_poli'=>$daftar_poli,
			'map'=>$daftar_poli_obj[$id_poli],
			'ws_server'=> $this->config->item('ws_server')
			
		];
		$this->load->view('adm/poli', $data);
	
	}
	public function poli_apotek($id)
	{
		$form = json_decode(file_get_contents('php://input'));
		// print_r($form);

		$id_ap   = $form->id_ap;
		$nama    = $form->nama;
		$alamat  = $form->alamat;
		$id_poli = $form->id_poli;
		$tanggal = date('Y-m-d');
		$waktu   = date('H:i:s');

		$rec_ap  = [
			'status' => 5,
			'waktu_dilayani'=> $waktu
		];

		//UPDATE AP
		$this->db->where('id',$id_ap)->update('m_antrian_poli',$rec_ap);
		$rec_apo = [
			'map_id' => $id_ap,
			'nama' => $nama,
			'alamat' => $alamat,
			'poli_id'=>$id_poli,
			'tanggal'=>$tanggal,
			'waktu_mulai'=>$waktu,
			'status'=>1,
			'from'=>1
		];
		//CHECK AP
		$rs = $this->db->where(['map_id'=>$id_ap])->get('m_antrian_apotek');
		if($rs->num_rows() > 0){
			//REC exists
			unset($rec_ap['map_id']);
			$this->db->where(['map_id'=>$id_ap])->update('m_antrian_apotek',$rec_apo);
		}else{
			// NEW rec
			$this->db->insert('m_antrian_apotek',$rec_apo);
		}
		$result = [
			'status' => true,
			'apo' => $rec_apo,
			'map' => $rec_ap
		];
		// Ini lah sesuatu yang baru
	    
	    $context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
	    $socket->send(json_encode(['cat'=>'onRegApotek','data'=>$rec_apo]) );

	    echo json_encode($result);
	}
	public function poli_laborat($id)
	{
		$form = json_decode(file_get_contents('php://input'));
		// print_r($form);

		$id_ap   = $form->id_ap;
		$nama    = $form->nama;
		$alamat  = $form->alamat;
		$id_poli = $form->id_poli;
		$tanggal = date('Y-m-d',time());
		$waktu   = date('H:i:s',time());

		$rec_ap  = [
			'status' => 5,
			'waktu_dilayani'=> $waktu
		];

		//UPDATE AP
		$this->db->where('id',$id_ap)->update('m_antrian_poli',$rec_ap);
		$rec_lab = [
			'map_id' => $id_ap,
			'nama' => $nama,
			'alamat' => $alamat,
			'poli_id'=>$id_poli,
			'tanggal'=>$tanggal,
			'waktu_mulai'=>$waktu,
			'status'=>1
		];
		//CHECK AP
		// $rs = $this->db->where(['map_id'=>$id_ap])->get('m_antrian_laborat');
		// if($rs->num_rows() > 0){
		// 	//REC exists
		// 	unset($rec_ap['map_id']);
		// 	$this->db->where(['map_id'=>$id_ap])->update('m_antrian_laborat',$rec_lab);
		// }else{
			// NEW rec
			$this->db->insert('m_antrian_laborat',$rec_lab);
		// }
		$result = [
			'status' => true,
			'lab' => $rec_lab,
			'map' => $rec_ap
		];
		// Ini lah sesuatu yang baru
	    
	    $context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
	    $socket->send(json_encode(['cat'=>'onRegLaborat','data'=>$rec_lab]) );

	    echo json_encode($result);
	}
	public function laborat_apotek($id)
	{
		$form = json_decode(file_get_contents('php://input'));
		// print_r($form);

		$id_lab   = $form->id_lab;
		$nama    = $form->nama;
		$alamat  = $form->alamat;
		$id_poli = $form->id_poli;
		$tanggal = date('Y-m-d');
		$waktu   = date('H:i:s');

		$rec_ap  = [
			'status' => 5,
			'waktu_dilayani'=> $waktu
		];

		//UPDATE AP
		$this->db->where('id',$id_lab)->update('m_antrian_laborat',$rec_ap);
		$rec_apo = [
			'map_id' => $id_lab,
			'nama' => $nama,
			'alamat' => $alamat,
			'poli_id'=>$id_poli,
			'tanggal'=>$tanggal,
			'waktu_mulai'=>$waktu,
			'status'=>1,
			'from'=>2
		];
		//CHECK AP
		$rs = $this->db->where(['map_id'=>$id_lab])->get('m_antrian_apotek');
		if($rs->num_rows() > 0){
			//REC exists
			unset($rec_ap['map_id']);
			$this->db->where(['map_id'=>$id_lab])->update('m_antrian_apotek',$rec_apo);
		}else{
			// NEW rec
			$this->db->insert('m_antrian_apotek',$rec_apo);
		}
		$result = [
			'status' => true,
			'apo' => $rec_apo,
			'map' => $rec_ap
		];
		// Ini lah sesuatu yang baru
	    
	    $context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
	    $socket->send(json_encode(['cat'=>'onRegApotek','data'=>$rec_apo]) );

	    echo json_encode($result);
	}
	public function apotek()
	{
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$telp = License::GetPhone();
		// $daftar_poli_rs = $this->db->get('m_poli')->result_object();
		// $daftar_poli = [''=>'--Pilih Poli--'];
		// $daftar_poli_obj = [];
		// foreach ($daftar_poli_rs as $poli) {
		// 	$daftar_poli[$poli->id] = $poli->nama;
		// 	$daftar_poli_obj[$poli->id] = $poli;
		// }
		// $dd_poli = form_dropdown('id_poli',$daftar_poli,'','class="form-control" v-model="id_poli" @change="onChangePoli()" v-show="id_poli.length==0"');
		$data = [
			'lokets' => $this->db->get('m_loket')->result_object(),
			'nama_instansi' => $nama_instansi,
			'alamat_instansi' => $address,
			'telp' => $telp,
			// 'daftar_poli'=>$daftar_poli,
			// 'daftar_poli_obj'=>$daftar_poli_obj,
			'ws_server'=> $this->config->item('ws_server')
			
		];
		$this->load->view('adm/apotek', $data);
	
	}
	public function laborat()
	{
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$telp = License::GetPhone();
		$daftar_poli_rs = $this->db->where('laborat','1')->get('m_poli')->result_object();
		$daftar_poli = [''=>'--Pilih Poli--'];
		$daftar_poli_obj = [];
		foreach ($daftar_poli_rs as $poli) {
			$daftar_poli[$poli->id] = $poli->nama;
			$daftar_poli_obj[$poli->id] = $poli;
		}
		$dd_poli = form_dropdown('to_id_poli',$daftar_poli,'','class="form-control" v-model="to_id_poli"');
		$data = [
			// 'lokets' => $this->db->get('m_loket')->result_object(),
			'nama_instansi' => $nama_instansi,
			'alamat_instansi' => $address,
			'telp' => $telp,
			'dd_poli'=>$dd_poli,
			// 'daftar_poli'=>$daftar_poli,
			// 'daftar_poli_obj'=>$daftar_poli_obj,
			'ws_server'=> $this->config->item('ws_server')
			
		];
		$this->load->view('adm/laborat', $data);
	
	}
	public function apotek_finish($id)
	{

		$form = json_decode(file_get_contents('php://input'));
		$id_maa = $form->id_maa;
		// $tanggal = date('Y-m-d');
		$waktu   = date('H:i:s');

		$rec_maa  = [
			'status' => 5,
			'waktu_dilayani'=> $waktu
		];

		$this->db->where('id',$id_maa)->update('m_antrian_apotek',$rec_maa);
		echo json_encode($rec_maa);

	}
}