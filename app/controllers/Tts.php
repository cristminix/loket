<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tts extends CI_Controller {

	public function speak($text)
	{
		error_reporting(0);
		// echo "Speaking $text";
		$text=base64_decode($text);

		// change following setting to a cache folder could increase performance
		$base_dir =  basename(APPPATH);
		$base_dir .= '/cache/tts';

		// get input parameters
		//$text = $_GET['text'];

		if (isset($_GET['voice'])) {
		  $voice = $_GET['voice'];
		} else {
		  $voice = 'id';
		}

		if (isset($_GET['speedDelta'])) {
		  $speed_delta = $_GET['speedDelta'];
		} else {
		  $speed_delta = 0;
		}
		$speed = (int)(175 + 175 * $speed_delta / 100);
		if (isset($_GET['speed'])) {
		  $speed = $_GET['speed'];
		}
		if (isset($_GET['pitchDelta'])) {
		  $pitch_delta = $_GET['pitchDelta'];
		} else {
		  $pitch_delta = 0;
		}
		$pitch = (int)(50 + $pitch_delta / 2);

		if (isset($_GET['volumeDelta'])) {
		  $volume_delta = $_GET['volumeDelta'];
		} else {
		  $volume_delta = 0;
		}
		$volume = (int)(100 + $volume_delta);

		$filename = md5($text) . '.mp3';
		$filepath = $base_dir . '/v' . $voice . 's' . $speed . 'p' . $pitch .
		    'a' . $volume . 't' . $filename;

		// $text = preg_replace('/\W/', " ", $text);

		// print_r($filepath);
		// die();
	// 	ini_set('display_errors',1);
	// error_reporting(E_ALL);
				// APPLICATION PATHS AND CONFIG
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		    //This is a server using Windows!
		    define('ESPEAK', 'bin\espeak');
		    define('BALCON', 'bin\balcon');
		    define('LAME', 'bin\lame');
		} 
		else {
		    //This is a server not using Windows!
		    define('ESPEAK', '/usr/bin/espeak');
		    define('LAME', '/usr/bin/lame');
		}
		$output = '';
		$speed = 3;
		if (!file_exists($filepath)) {
		  $cmd =  BALCON." -n \"VE_Indonesian_Damayanti_22kHz\" -s ".$speed." -o raw -t \"$text\" | ".LAME." --preset voice -q 9 --vbr-new - $filepath";

		    // echo $cmd;
		    // die();
		    // echo getcwd() . "\n";
		    // echo "espeak " .( file_exists( "bin/espeak.exe") ? ' exist' : " not exist") . "\n";
		  $output = shell_exec($cmd);
		}
		// die();
		if(file_exists($filepath)){
			header('Content-Type: audio/mpeg');
			header('Content-Length: ' . filesize($filepath));
			readfile($filepath);
			unlink($filepath);
		}else{
			echo "$output error exec $cmd";
		}
		
	
	}
}