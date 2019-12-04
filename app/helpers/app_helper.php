<?php

function parse_setting_template($text,$i=1)
{
	$parsed = "";
	$captured = [];
	preg_match_all('/\{([a-zA-Z0-9|_]+)\}/', $text, $captured);
	$ci =& get_instance();
	foreach ($captured[1] as $index => $key) {
		$real_value = $ci->m_setting->get_value($key);
		if(!empty($real_value)){
			$text = str_replace($captured[0], $real_value, $text);
			if($i == 1){
				$text = parse_setting_template($text,2);
			}
		}
		else{
			// $parsed = $text;
		}
		
	}
	return $text;
}

function uuid($salt="Tju-Path-Khay"){
    return md5(microtime().base64_encode($salt));
}
function date_format_id($mysql_date,$sep='/')
{
    return date("d{$sep}m{$sep}Y", strtotime($mysql_date));
}

function date_format_mysql($id_date,$sep='/')
{
    $str = explode($sep, $id_date);
    $Y   = $str[2];
    $m   = $str[1];
    $d   = $str[0];
    return date('Y-m-d', strtotime("$Y-$m-$d"));
}
function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array ( 1 =>    'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
            
    $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $tanggal = date('Y-m-d', strtotime($tanggal));
    $split    = explode('-', $tanggal);
    $tgl_indo = preg_replace('/^0/', '', $split[2]) . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    
    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}
// function waktu_stop_tiket_enabled()
// {
//   # code...
// }
// function get_waktu_stop_tiket_by_day()
// {
//   # code...
// }
function time_ago($original, $date_orig = '')
{


    date_default_timezone_set('Asia/Jakarta');
    $chunks = array(
      array(60 * 60 * 24 * 365, 'tahun'),
      array(60 * 60 * 24 * 30, 'bulan'),
      array(60 * 60 * 24 * 7, 'minggu'),
      array(60 * 60 * 24, 'hari'),
      array(60 * 60, 'jam'),
      array(60, 'menit'),
    );
 
    $today = time();
    $since = $today - $original;
 
    if ($since > 604800) {
      // $print = date("M jS", $original);
        if ($since > 31536000) {
            $print = date("Y-m-d", $original);
            return tanggal_indo($print, true);
        }
    }
 
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
 
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }
 
    $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
    return $print . ' yang lalu';
}

function title_case($str){
    $buffer = '';
    $str = preg_replace('/\W/', ' ', $str);
    $str = explode(' ', $str);
    if(is_array($str)){
        foreach ($str as $s) {
            $buffer .= ucfirst($s) . ' ';
        }
    }else{
        $buffer = $s;
    }
    

    return $buffer;
} 
function string2ByteArray($string) {
  return unpack('C*', $string);
}

function byteArray2String($byteArray) {
  $chars = array_map("chr", $byteArray);
  return join($chars);
}

function byteArray2Hex($byteArray) {
  $chars = array_map("chr", $byteArray);
  $bin = join($chars);
  return bin2hex($bin);
}

function hex2ByteArray($hexString) {
  $string = hex2bin($hexString);
  return unpack('C*', $string);
}

function string2Hex($string) {
  return bin2hex($string);
}

function hex2String($hexString) {
  return hex2bin($hexString);
}

function app_cfg($key,$sub=""){
  $data = get_instance()->config->item($key);
  if(empty($sub)){
    return $data;
  }

  if(isset($data[$sub])){
    return $data[$sub];
  }
  return '';
}