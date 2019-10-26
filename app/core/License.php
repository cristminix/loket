<?php

/**
 * License.php
 * Class to generate and check app license
 */
use phpseclib\Crypt\RSA;
class License 
{
	private static $ci;
	 

	public static function GetVolumeLabel($drive) {
		if(preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir '.$drive.':'), $m)) {
			$volname = ' ('.$m[1].')';
		} else {
			$volname = '';
		}
		return $volname;
	}

	public static function GetHardwareId($drive='c')
	{
		return  str_replace("(","",str_replace(")","",License::GetVolumeLabel($drive)));
	}

	private static function generate_pp($text){
		$ci 	=& get_instance();
	   /**
		* ELEMENT OF LICENSE
		* 1. CI Exncryption Key
		* 2. SALT , your own salt
		* 3. HARDWARE ID 
		* 4. PP , Password to build RSA Cert 
		* 5. Password Algoritm in extension
		* 6. Salt in Extension
		*/

		$ci_ekey= $ci->config->item('encryption_key');
		$salt 	= 'Grinting0K*#';
		$pp 	= md5($ci_ekey.$salt.$hardware_id);
		return $pp;
	}
	public static function GenerateSerialNumber($hardware_id)
	{
		
		$pp = self::generate_pp($hardware_id);

		$rsa 	= new RSA();
		
		$rsa->setPassword($pp);
		
		$data = $rsa->createKey();

		$license_path = "license/";

		$pk_path 	  = $license_path . "/pk";
		$pub_path 	  = $license_path . "/pub";

		$pk = "";
		$pub = "";

		if(!file_exists($pk_path)){
			file_put_contents($pk_path, $data['privatekey']);

		}
		if(!file_exists($pub_path)){
			file_put_contents($pub_path, $data['publickey']);

		}

		if(file_exists($pk_path)){
			$pk = file_get_contents($pk_path);
		}
		if(file_exists($pub_path)){
			$pub = file_get_contents($pub_path);
		}
		return json_encode([$pk,$pub]);

	}
	public function GenerateSupportFile($data)
	{
		$license_path = "license/";

		$org_path  = $license_path . "/org.json";
		$raw = json_encode($data);
		$chipertext = License::Encrypt($raw);
		if(is_dir($license_path)){
			file_put_contents($org_path,$chipertext);
		}
		
	}
	public static function CheckSerialNumber($hardware_id)
	{
		$license_path = "license/";

		$pk_path 	  = $license_path . "/pk";
		$pub_path 	  = $license_path . "/pub";

		$org_path  	  = $license_path . "/org.json";

	}
	
	public static function IsSoftwareLicensed()
	{
		$hardware_id = License::GetHardwareId('c');
		$license_path = "license/";
		if(!is_dir($license_path)){
			return false;
		}
		$pk_path 	  = $license_path . "/pk";
		$pub_path 	  = $license_path . "/pub";

		$pk = "";
		$pub = "";

		if(!file_exists($pk_path)){
			file_put_contents($pk_path, $data['privatekey']);

		}
		if(!file_exists($pub_path)){
			file_put_contents($pub_path, $data['publickey']);

		}

		if(file_exists($pk_path)){
			$pk = @file_get_contents($pk_path);
		}
		if(file_exists($pub_path)){
			$pub = @file_get_contents($pub_path);
		}
		if(!empty($pk) && !empty($pub)){
			$rsa = new RSA();
			$pp = self::generate_pp($hardware_id);

			$rsa->setPassword($pp);
			/* private key */
			$rsa->loadKey($pk); 

			$plaintext = 'HelloWorld';

			$signature = $rsa->sign($plaintext);
			/* public key */
			$rsa->loadKey($pub); 
			return $rsa->verify($plaintext, $signature);
		}
		return false;
		

	}
	

	public static function GetOrganization()
	{
		$license_path = "license/";

		$org_path  = $license_path . "/org.json";
		$chipertext = @file_get_contents($org_path);
		$raw = License::Decrypt($chipertext);

		$obj = json_decode($raw);
		
		if(is_object($obj)){
			return $obj->nama_instansi;
		}
		return 'N/A';
	}
	public static function GetAddress()
	{
		$license_path = "license/";

		$org_path  = $license_path . "/org.json";
		$chipertext = @file_get_contents($org_path);
		$raw = License::Decrypt($chipertext);

		$obj = json_decode($raw);

		if(is_object($obj)){
			return $obj->alamat;
		}
		return 'N/A';
	}

	public static function GetEmail()
	{
		$license_path = "license/";

		$org_path  = $license_path . "/org.json";
		$chipertext = @file_get_contents($org_path);
		$raw = License::Decrypt($chipertext);

		$obj = json_decode($raw);

		if(is_object($obj)){
			return $obj->email;
		}
		return 'N/A';
	}
	public static function GetNamaKabupaten()
	{
		$license_path = "license/";

		$org_path  = $license_path . "/org.json";
		$chipertext = @file_get_contents($org_path);
		$raw = License::Decrypt($chipertext);

		$obj = json_decode($raw);

		if(is_object($obj)){
			return $obj->nama_kabupaten;
		}
		return 'N/A';
	}
	public static function GetPhone()
	{
		$license_path = "license/";

		$org_path  = $license_path . "/org.json";
		$chipertext = @file_get_contents($org_path);
		$raw = License::Decrypt($chipertext);

		$obj = json_decode($raw);

		if(is_object($obj)){
			return $obj->telp;
		}
		return 'N/A';
	}
	public static function Encrypt($plaintext)
	{
		$hardware_id = License::GetHardwareId('c');
		$license_path = "license/";

		$pk_path 	  = $license_path . "/pk";
		$pub_path 	  = $license_path . "/pub";

		$pk = "";
		$pub = "";

		

		if(file_exists($pk_path)){
			$pk = file_get_contents($pk_path);
		}
		if(file_exists($pub_path)){
			$pub = file_get_contents($pub_path);
		}
		if(!empty($pk) && !empty($pub)){
			
			$rsa = new RSA();
			$pp = self::generate_pp($hardware_id);

			$rsa->setPassword($pp);

			$rsa->loadKey($pub); 
			$rsa->loadKey($pk); 

			
			return $rsa->encrypt($plaintext);

			
		}
		return '';
	}
	public static function Decrypt($cipertext)
	{
		$hardware_id = License::GetHardwareId('c');
		$license_path = "license/";

		if(!self::IsSoftwareLicensed()){
			return 'N/A';
		}

		$pk_path 	  = $license_path . "/pk";
		$pub_path 	  = $license_path . "/pub";

		$pk = "";
		$pub = "";
 

		if(file_exists($pk_path)){
			$pk = @file_get_contents($pk_path);
		}
		if(file_exists($pub_path)){
			$pub = @file_get_contents($pub_path);
		}
		if(!empty($pk) && !empty($pub) ){
			
			$rsa = new RSA();
			$pp = self::generate_pp($hardware_id);

			$rsa->setPassword($pp);
			$rsa->loadKey($pub); 
			return $rsa->decrypt($cipertext);
		}
		return '';
	}
}