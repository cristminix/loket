<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$app_name?></title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/video-js.css">

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/popper.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/clock.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/video.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/videojs-playlist.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/axios.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/vue.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/autobahn.js"></script>

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/modules/antrian/loket.js?<?=md5(microtime())?>"></script>
<script type="text/javascript">
	function base_url(str) {
		return '<?=base_url()?>'+(typeof str != 'undefined'?str:'');
	}
	function site_url(str) {
		return base_url(str);
	}
	function get_ws_server(){
		return '<?=$ws_server?>';
	}
</script>
</head>
<body>

<div class="container-fluid" id="appMonitor">
	<div class="row a">
		<div class="col-md-12 row-a" style="color: #fff;padding: 1em">
			<h4 class="" style="font-size: 100%;margin:2px"><?=$nama_instansi?></h4>
			<small class=""><?=$alamat_instansi?></small>
		</div>
	</div>
	<div class="row b">
		<div class="col-md-5 b-curr-no">
			<div class="p_curr_no" style="text-align: center;margin-top:14% ">
				<h1 class="curr_no" style="font-size: 1024%">{{curr_no}}</h1>
			</div>
			
		</div>
		<div class="col-md-7 b-video" style="overflow: hidden;">
			<video class="video-js vjs-default-skin" controls id="aplayer" volume="0.3"></video>
<button class="previous">Previous</button>
<button class="next">Next</button>
<button class="jump">Play Third</button>
		</div>
	</div> 
	<div class="row c" style="position: fixed;bottom: 0;width:100%">
		<div class="col-md-4" style="background-color: rgb(52, 152, 219);color: #fff;padding-top: 1em;padding-bottom: 0.5em">
			<div class="text-center">
				<h2 style="font-size :200%">A . <i style="font-size: 90%">BPJS</i></h2>
				<h2 style="font-size :400%">{{a_cx}}</h2>

			</div>
			
		</div>
		<div class="col-md-4" style="background-color:rgb(46, 204, 113);color: #fff;padding-top: 1em;padding-bottom: 0.5em">
			<div class="text-center">
				<h2 style="font-size :200%">B . <i style="font-size: 90%">UMUM</i></h2>
				<h2 style="font-size :400%">{{b_cx}}</h2>
				
			</div>
		</div>
		<div class="col-md-4"  style="background-color: rgb(231, 76, 60);color: #fff;padding-top: 1em;padding-bottom: 0.5em">
			<div class="text-center">
				<h2 style="font-size :200%">C . <i style="font-size: 90%">LANSIA ANAK</i></h2>
				<h2 style="font-size :400%">{{c_cx}}</h2>
				 
			</div>
		</div>
	</div> 
	
</div>

</body>
 <style type="text/css">
 	#mv{
 		height: 100%;
 		width: 100%;
 	}
 	.b-curr-no,.b-video{
 		padding: 0;
 		color: #fff;
 	}
 	body{
 		overflow-y: hidden;
 	}
 </style>
</html>
