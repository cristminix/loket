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

class Artisan extends CI_Controller
{
    public function __construct($value = '')
    {
        parent::__construct();
        // $this->load_database();

        error_reporting(E_ALL);
    }
    
    public function console($cmd = '', $a = '', $b = '', $c = '', $d = '', $e = '')
    {
        $method = str_replace(':', '_', $cmd);

        if (method_exists($this, $method)) {
            return $this->{$method}($a, $b, $c, $d, $e);
        }

        echo ('Unexistent command '."$cmd\n");
    }

    public function _csv_str_to_array($csv_str)
    {
    	$csvs = explode("\n", $csv_str);
    	$csvs_real = [];
    	$csv_item = [];
    	$csv_array = [];
    	foreach ($csvs as $index => $value) {
    		if($index == 0){
    			$csv_item = [];
    			$csv_header = explode(',', $value);
    			foreach ($csv_header as $key) {
    				$k = str_replace('"', '', $key);
    				$csv_item[] = $k;
    			}
    		}else{
    			$csv_item_real = [];

    			$csv_value= explode(',',$value);
    			foreach ($csv_value as $index => $val) {
    				$v = str_replace('"', '', $val);
    				if(count($csv_value) == 5){
    					$csv_item_real[$csv_item[$index]] = $v;
    				}else{
    					break;
    				}
    			}
    			if(!empty($csv_item_real)){
    				$csv_array[]=$csv_item_real;
    			}
    		}
    	}
    	return $csv_array;
    }
    public function _chk_svc_shell($title,$image_name,$number,$subtitle="")
    {
    	echo "{$number}.Checking {$title}\n";
    	$cmd = 'tasklist  /FI "IMAGENAME eq '.$image_name.'" /FO csv';

    	$csv_str = shell_exec($cmd);
    	$csv_array = $this->_csv_str_to_array($csv_str);

    	// echo $csv_str;
    	$img_count = count($csv_array);
    	if(!empty($subtitle)){
    		$image_name = $subtitle;
    	}
    	$message = '';
    	$running_status = false;
    	if($img_count != 0){
    		$message = "  {$image_name} is running with {$img_count} threads\n";
    		$running_status = true;

    	}else{
    		$message = "  {$image_name} is not running\n";

    	}
    	return [
    		'message' => $message,
    		'csv_array' => $csv_array,
    		'running_status' => $running_status
    	];
    	
    }
    public function _stop_svc_shell($title,$image_name,$number)
    {
    	echo "{$number}.Stoping {$title}\n";
    	$cmd = 'taskkill /F /IM "'.$image_name.'"';

    	$std_str = shell_exec($cmd);

    	echo $std_str."\n";	
    }
    public function chk_svc()
    {


    	$nginx   = $this->_chk_svc_shell("nginx http server...","nginx.exe",1,"nginx");
    	echo $nginx['message'] . "\n";

    	$php_cgi = $this->_chk_svc_shell("php-cgi service...","php-cgi.exe",2,"php-cgi");
    	echo $php_cgi['message'] . "\n";

    	$php_zmq = $this->_chk_svc_shell("php-zmq service...","php.exe",3,"php-zmq");
    	echo $php_zmq['message'] . "\n";

    	$mariadb = $this->_chk_svc_shell("mariadb service..","mysqld.exe",4,"mariadb");
    	echo $mariadb['message'] . "\n";
    }
    public function stop_svc()
    {
    	echo "You must run this with admnistrator privilege\n\n";
    	
    	$this->_stop_svc_shell("nginx http server...","nginx.exe",1);
    	$this->_stop_svc_shell("php-cgi service...","php-cgi.exe",2);
    	$this->_stop_svc_shell("php-zmq service...","php.exe",3);
    	$this->_stop_svc_shell("mariadb service..","mysqld.exe",4);
    	
    }

    public function gen_lic()
    {

        $nama_instansi = 'P**KE**AS ***';
        $alamat = 'Jl. Raya *** No. ** Kec. BLA** 522**';
        $telp = '(0283)6183***';
        $nama_kabupaten = 'KAB. BREBES';
        $email = "sutoyocutez@gmail.com";

        $hwid = License::GetHardwareId('c');
        License::GenerateSerialNumber($hwid);
        License::GenerateSupportFile([
            'nama_instansi' => $nama_instansi,
            'alamat' => $alamat,
            'email' =>$email,
            'telp' => $telp,
            'nama_kabupaten' => $nama_kabupaten
        ]);
    }

    public function p_rint()
    {
        define('WKCMD', 'bin\wkhtmltoimage');
        $source = "http://localhost/tiket/cetak/bpjs";

        // $width = 585;
        $dest = APPPATH."/cache/tiket/gd_text.png";
        
        // $command = sprintf(
        //     WKCMD . " -f png -q --crop-w %s %s %s",
        //     escapeshellarg($width),
        //     escapeshellarg($source),
        //     escapeshellarg($dest)
        // );
        // echo $command . "\n";
        // $stdout = shell_exec($command);
        // echo $stdout;

        try {
            // Enter the share name for your USB printer here
            // $connector = null;
            $connector = new WindowsPrintConnector("POS-80C");
            $printer = new Printer($connector);

            ///////////////////////////////////////////
            /* Graphics - this demo will not work on some non-Epson printers */
            try {
                $logo = EscposImage::load($dest, false);
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
    }

    public function gd_text()
    {
        $dest = APPPATH."/cache/tiket/gd_text.png";


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
        $box->draw('PUSKESMAS CIKAKAK');

        $box = new Box($image);
        $box->setFontFace($roboto_bold);
        $box->setFontColor($black_color);

        $box->setFontSize(35);
        $box->setLineHeight(1);
        $box->setBox(0,50,$width,40);

        $box->setTextAlign('center','top');
        $box->draw('KAB. BREBES');

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
        $box->draw('SENIN');


        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(22);
        $box->setLineHeight(1);
        $box->setBox($bx_width,95,$bx_width,$bx_height);

        $box->setTextAlign('center','top');
        $box->draw('13-OKTOBER-2019');

        $box = new Box($image);
        $box->setFontFace($roboto_regular);
        $box->setFontColor($black_color);

        $box->setFontSize(22);
        $box->setLineHeight(1);
        $box->setBox($bx_width*2,95,$bx_width,$bx_height);

        $box->setTextAlign('center','top');
        $box->draw('10.30');

        // imageline(image, x1, y1, x2, y2, color)
        imageline($image, 0, 120, $width,120, 0x000000);

        $box = new Box($image);
        $box->setFontFace($roboto_bold);
        $box->setFontColor($black_color);

        $box->setFontSize(35);
        $box->setLineHeight(1);
        $box->setBox(0,130,$width,40);

        $box->setTextAlign('center','top');
        $box->draw('NO. ANTRIAN ' . $jenis);

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
            
        imagepng($image,$dest);
    }
}
