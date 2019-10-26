<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Antrian Poli</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/video-js.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/modules/adm/poli.css">


	<script type="text/javascript" src="<?=base_url()?>public/assets/js/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/popper.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/axios.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/vue.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/video.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/grocery_crud/themes/flexigrid/js/cookies.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/autobahn.js"></script>

	
<script type="text/javascript">
	function base_url(){
		return '<?=base_url()?>';
	}
	function get_id_poli(){
		return '<?=$id_poli?>';
	}
	function get_nama_poli(){
		return '<?=$daftar_poli[$id_poli]?>';
	}
	function get_laborat_status(){
		return parseInt('<?=$map->laborat?>');
	}
	function get_ws_server(){
		return '<?=$ws_server?>';
	}
</script>
<script type="text/javascript" src="<?=base_url()?>public/assets/js/app/helper.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/modules/adm/poli.js"></script>
</head>
<body>

<div class="container-fluid"  id="admPoli">
	<div class="row headerT">
		<div class="col-md-12" style="">
			<h4 class="text-left" style="margin:0"><?=$nama_instansi?></h4>
			<small class="text-left"><?=$alamat_instansi?> </small>
		</div>
	</div>
	<div class="row" style="margin-bottom: 70px;padding-top: 1em">

		<div class="col-md-9 leftPane" id="admPoliTable">
			<div class="row" style="padding-top: 5px">
				<div class="col-md-12" style="">
					<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border-bottom: none;">
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-list-tab" data-toggle="tab" href="#nav-list" role="tab" aria-controls="nav-list" aria-selected="true">List Antrian Poli</a>
                              
                            </div>
					     
					</div>
					</nav>
					 <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                        	<table class="table table-bordered" style="margin-top: 1px">
								<thead>
									<tr>
										<th>#</th>
										<th>NAMA</th>
										<th>ALAMAT</th>
										<th>WAKTU DAFTAR</th>
										<th>STATUS</th>
									</tr>
								</thead>
								<tbody id="list_antrian_body">
									<tr v-if="list.length==0">
										<td colspan="8">Tida ada antrian.</td>
									</tr>
									<tr v-else v-for="(v,idx) in list">
										<td><span v-text="idx+1"></span></td>
										<td><span v-text="v.nama"></span></td>
										<td><span v-text="v.alamat"></span></td>
										<td><span v-text="v.waktu_mulai"></span></td>
										<td><span v-text="v.status=='1'?'Menunggu':(v.status==3?'Lewat':'-')"></span></td>
									</tr>
								</tbody>
							</table>
                        </div>
                        
                     </div>           
					 
				</div>
			</div>
		</div>
		<div class="col-md-3" id="admPoliBox">
			<div class="row" style="padding: 0 15px">
				<div class="col-md-12 kotak-a">

					<h4  class="text-center kotak-title">
						<i v-show="id_poli.length>0" v-text="nama_poli"></i>
						<?=$dd_poli_all?>
					</h4>
					<p class="text-center" v-text="id_ap!=-1?nama+ '('+alamat+')':'Belum Ada Pasien'"></p>
					<div class="row" style="padding: .5em">
						<div class="col-md-6">
							<button class="btn btn-primary" :disabled="status!=1 || btnCallState!=1" @click="executeBtnProc('call',1)"><i class="fas fa-volume-up"></i> Call <span v-text="'('+callAttempt+')'"></span></button>
						</div>
						<div class="col-md-6" style="text-align: center;">
							<button class="btn btn-danger" :disabled="btnSkipState!=1" @click="executeBtnProc('skip')"><i class="fas fa-square"></i> Skip</button>
						</div>
					</div>
					<div class="row" v-if="laborat==0">
						<div class="col-md-12 text-center mt1em" >
							<button class="btn btn-warning" :disabled="btnApotikState!=1 " @click="executeBtnProc('apotek')"><i class="fas  fa-credit-card"></i> Apotik</button>
						</div>
						<div>&nbsp;</div>
					</div>
					<div class="row" v-if="laborat==1" style="padding-bottom: 1em">
						<div class="col-md-6 text-center mt1em" >
							<button class="btn btn-warning" :disabled="btnApotikState!=1 " @click="executeBtnProc('apotek')"><i class="fas  fa-credit-card"></i> Apotik</button>
						</div>
						<div class="col-md-6 text-center mt1em" >
							<button class="btn btn-warning" :disabled="btnLaboratState!=1 " @click="executeBtnProc('laborat')"><i class="fas  fa-caret-right"></i> Laborat</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-12">
			<div id="audioPlayer">
				<audio id="aplayer" class="video-js vjs-default-skin" width="100" height="50" controls="controls" preload="auto" data-setup='{"autoplay":false}'>
					<source src="<?=base_url()?>tts/speak/Tm9tb3JfQW50cmlhbl8sQSwsS29zb25nLCxLb3NvbmcsLEtvc29uZywx?q=1569117054848" type="audio/mp3"/>
					</audio>
			</div>
		</div>

	
</div>
<div class="row d footer">
		<div class="col-md-12 row-a text-center" style="color: #fff;padding:.5em">
			<h4 class="" style="font-size: 100%;margin:2px">Sistem Informasi Antrian</h4>
			<small class="">Copyright &copy; 2019 Agung Rizky Tiga </small>
		</div>
	</div>
</div>
<style type="text/css">
	body{
		background: #eee;
	}
	.headerT{
		background:#34495e; 
		color: #fff;
		padding: 1em;
	}
	.row.d.footer{
		background:#34495e; 
		color: #fff;
		padding: .5em 0;
		position: fixed;
		bottom: 0;
		width: 100%;
	}
	.leftPane{
		/*background: #95a5a6;*/
	}
	.tab-content{
		background: #fff;
	}
	.nav-tabs > .nav-item.nav-link{
		color: #fff;
		background: #7f8c8d;
	}
	.nav-tabs > .nav-item.nav-link.active{
		color: #fff;
		background: #34495e;
	}
</style>
</body>
</html>