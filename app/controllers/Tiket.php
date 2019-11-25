<?php
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
use GDText\Box;
use GDText\Color;
use GDText\HorizontalAlignment;
use GDText\TextWrapping;
use GDText\VerticalAlignment;
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends CI_Controller {

	public function index()
	{
		$ip_address = $this->input->ip_address();
		$restrict_ip_address = $this->config->item('restrict_tiket_local');
		if($ip_address != '127.0.0.1' && $restrict_ip_address){
			die('Sorry this service only available on localhost.');
		}
		$jenis_pendaftaran = $this->m_jenis_pendaftaran->get_jenis_pendaftaran();
		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$nama_kabupaten = License::GetNamaKabupaten();
		$tlp_instansi = License::GetPhone();
		$data = [
			'jenis_pendaftaran' => $jenis_pendaftaran,
			'nama_instansi' => $nama_instansi,
			'nama_kabupaten' => $nama_kabupaten,
			'alamat_instansi'=>$address,
			'tlp_instansi' => $tlp_instansi,
			'ws_server'=> $this->config->item('ws_server')

		];

	 

		$this->load->view('tiket/index', $data);
	}

	public function cetak($jenis)
	{

		$response = [
			'status' => 'ERR_TIMEOUT',
			'message' => 'OK'
		];

		$waktu_stop_tiket_enabled  = $this->config->item('waktu_stop_tiket_aktif');
		$waktu_stop_tiket_per_days = $this->config->item('waktu_stop_tiket_per_days');
		$tm = time();
		$day_index = date('N',$tm);

		if(isset($waktu_stop_tiket_per_days[$day_index])){
			$waktu_stop_tiket = $waktu_stop_tiket_per_days[$day_index];
			$current_dt = date('Y-m-d H:i:s');
			$current_tm = strtotime($current_dt);
			$stop_dt = date('Y-m-d ').$waktu_stop_tiket;
			$stop_tm = strtotime($stop_dt);
			if($waktu_stop_tiket == '-1'){
				$response['message'] = 'Mohon maaf pelayanan tiket untuk sementara tidak tersedia pada hari libur.';
				echo json_encode($response);
			    return;
			}
			if ($waktu_stop_tiket_enabled && ($current_tm > $stop_tm)) {
			    $response['message'] = 'Mohon maaf pelayanan tiket telah habis '.($day_index != 6 ? ', silahkan datang lagi esok hari':'silahkan datang lagi hari senin').'.';//"{$current_dt} > {$stop_dt}"
				echo json_encode($response);
			    
			    return;
			}
		}

	
		// echo "{$current_dt} < {$stop_dt}";
		$jp_ids = [];
		$kode_jenis_pendaftaran = $this->m_jenis_pendaftaran->get_kode_jenis_pendaftaran($jp_ids);
		$kode_jenis = $kode_jenis_pendaftaran[$jenis];
		$jp_id = $jp_ids[$jenis];

		$nomor_terkhir = $this->m_pendaftaran->get_nomor_pendaftaran($kode_jenis);
		$tiket_digit_format = $this->m_setting->get_value('tiket_digit_format');
		$nomor_antrian = $kode_jenis . sprintf($tiket_digit_format, $nomor_terkhir) ;

		$nama_instansi = License::GetOrganization();
		$address = License::GetAddress();
		$tlp_instansi = License::GetPhone();
		$nama_kabupaten = License::GetNamaKabupaten();
		$tanggal = tanggal_indo(date('Y-m-d'),true);
		$tanggal = explode(', ', $tanggal);
		$hari = $tanggal[0];
		$tanggal = str_replace(' ', '-', $tanggal[1]);
		$waktu   = date('H.i');


		// GET DEFAULT ID LOKET
		$default_loket_id = $this->m_setting->get_value('default_loket_id');
		// GET SETTING LOKET
		$loket_id_by_setting_loket = $this->m_setting_loket->get_loket_id($jp_id);
		if(!empty($loket_id_by_setting_loket)){
			$default_loket_id = $loket_id_by_setting_loket;
		}

		$queue = [
			'jp_id' => $jp_id,
			'nomor'=>$nomor_antrian,
			'tanggal'=>date('Y-m-d'),
			'waktu_mulai'=> date('H:i:s'),
			'status'=>1,
			'loket_id' => $default_loket_id
		];

		$data = [
			'jenis' => $jenis,
			'nomor_antrian' => $nomor_antrian,
			'nama_instansi'=>$nama_instansi,
			'alamat_instansi' => $address,
			'nama_kabupaten' => $nama_kabupaten,
			'tlp_instansi' => $tlp_instansi,
			'hari' => $hari,
			'tanggal' => $tanggal,
			'waktu' => $waktu
		];

		$this->m_antrian_loket->register($queue);

		$this->m_pendaftaran->set_next_nomor_pendaftaran($kode_jenis);
		// Ini lah sesuatu yang baru
	    
	   

		// file
		$cache_path = APPPATH."/cache/tiket/";
		$filename = "escpos-"  .md5(microtime());
		$html_filename = $filename . ".html";
		$png_filename  = $filename . ".png";

		/******************************************************************/
		// $dest = APPPATH."/cache/tiket/gd_text.png";


        $width = 585;
        $height = 405;

        $image = imagecreatetruecolor($width, $height);

        $bgcolor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgcolor);


        $font_path      = FCPATH . '/public/assets/fonts/';
        $roboto_bold    = $font_path . 'Roboto-Bold.ttf';
        $roboto_regular = $font_path . 'Roboto-Regular.ttf';
        $roboto_italic  = $font_path . 'Roboto-Italic.ttf';

        $black_color = new Color(0,0,0);

        $box = new Box($image);
        $box->setFontFace($roboto_bold);
        $box->setFontColor($black_color);

        $box->setFontSize(35);
        $box->setLineHeight(1);
        $box->setBox(0,10,$width,40);

        $box->setTextAlign('center','top');
        $box->draw($nama_instansi);

        $box = new Box($image);
        $box->setFontFace($roboto_bold);
        $box->setFontColor($black_color);

        $box->setFontSize(35);
        $box->setLineHeight(1);
        $box->setBox(0,50,$width,40);

        $box->setTextAlign('center','top');
        $box->draw($nama_kabupaten);

        // imageline(image, x1, y1, x2, y2, color)
        imageline($image, 0, 85, $width,85, 0x000000);

        //create 3 column box

        $bx_width  = $width/3;
        $bx_height = 30;

        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(22);
        $box->setLineHeight(1);
        $box->setBox(0,95,$bx_width,$bx_height);

        $box->setTextAlign('center','top');
        $box->draw(strtoupper($hari));


        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(22);
        $box->setLineHeight(1);
        $box->setBox($bx_width,95,$bx_width,$bx_height);

        $box->setTextAlign('center','top');
        $box->draw(strtoupper($tanggal));

        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(22);
        $box->setLineHeight(1);
        $box->setBox($bx_width*2,95,$bx_width,$bx_height);

        $box->setTextAlign('center','top');
        $box->draw($waktu);

        // imageline(image, x1, y1, x2, y2, color)
        imageline($image, 0, 120, $width,120, 0x000000);

        $box = new Box($image);
        $box->setFontFace($roboto_bold);
        $box->setFontColor($black_color);

        $box->setFontSize(35);
        $box->setLineHeight(1);
        $box->setBox(0,130,$width,40);

        $box->setTextAlign('center','top');
        $box->draw('NO. ANTRIAN ' . strtoupper($jenis));

        $box = new Box($image);
        $box->setFontFace($roboto_bold);
        $box->setFontColor($black_color);

        $box->setFontSize(140);
        $box->setLineHeight(1);
        $box->setBox(0,180,$width,40);

        $box->setTextAlign('center','top');
        $box->draw($nomor_antrian);


        /*
            <p>Silahkan Menunggu Sampai</p>
            <p>Nomor Tiket Anda Dipanggil</p>
            <i>Terima Kasih Atas Kunjungan Anda</i>
        */
        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(25);
        $box->setLineHeight(1);
        $box->setBox(0,321,$width,40);

        $box->setTextAlign('center','top');
        $box->draw('Silahkan Menunggu Sampai');

        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(25);
        $box->setLineHeight(1);
        $box->setBox(0,346,$width,40);

        $box->setTextAlign('center','top');
        $box->draw('Nomor Tiket Anda Dipanggil');

        $box = new Box($image);
        $box->setFontFace($roboto_italic);
        $box->setFontColor($black_color);

        $box->setFontSize(25);
        $box->setLineHeight(1);
        $box->setBox(0,371,$width,40);

        $box->setTextAlign('center','top');
        $box->draw('Terima Kasih Atas Kunjungan Anda');
            
        imagepng($image,$cache_path.$png_filename);
		/*******************************************************************/
        // echo $stdout;

        try {
            // Enter the share name for your USB printer here
            // $connector = null;
            $connector = new WindowsPrintConnector("POS-80C");
            $printer = new Printer($connector);

            ///////////////////////////////////////////
            /* Graphics - this demo will not work on some non-Epson printers */
            try {
                $logo = EscposImage::load($cache_path.$png_filename, false);
                $printer->bitImage($logo,Printer::IMG_DEFAULT);
                
            } catch (Exception $e) {
                /* Images not supported on your PHP, or image file not found */
                $printer -> text($e -> getMessage() . "\n");
            }
            $printer -> cut();

            ///////////////////////////////////////////
            
            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }

        @unlink($cache_path . $html_filename);
        @unlink($cache_path . $png_filename);

		/*****************************************************************************/
		$response['status'] = 'OK_PRINT';
		$response['nomor_antrian']=$nomor_antrian;


		$context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
	    $socket->send(json_encode(['cat'=>'onCetakTiket','data'=>$queue]));

		echo json_encode($response);
	}

	public function reset()
	{
		// echo "do reset";
		$this->db->truncate('m_nomor_pendaftaran');
		$this->db->truncate('m_display_antrian_loket');
		$tanggal = date('Y-m-d',time());
		$tbls = ['m_antrian_loket','m_antrian_poli','m_antrian_laborat','m_antrian_apotek'];

		$context = new ZMQContext();
	    $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
	    $socket->connect('tcp://127.0.0.1:5555');
	    // // print_r($socket);
	    $socket->send(json_encode(['cat'=>'onUpdateDal','data'=>$queue]));
	    $socket->send(json_encode(['cat'=>'onRegApotek','data'=>$queue]));
	    $socket->send(json_encode(['cat'=>'onRegLaborat','data'=>$queue]));
	    $socket->send(json_encode(['cat'=>'onRegPoli','data'=>$queue]));
	    $socket->send(json_encode(['cat'=>'onCetakTiket','data'=>$queue]));
	    
		foreach ($tbls as $table) {
			$this->db->where('tanggal',$tanggal)->delete($table);
		}
		

		echo json_encode(['result'=>1]);
	}
	public function shutdown()
	{
		$cmd = 'shutdown /s /t 0 /f /d P:1:1';
		echo shell_exec($cmd);
	}
	public function reboot()
	{
		$cmd = 'shutdown /r /t 0 /f /d P:1:1';
		echo shell_exec($cmd);
	}
}
