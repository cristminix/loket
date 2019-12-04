<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Loket Pendaftaran</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/video-js.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/modules/adm/loket.css">


	<script type="text/javascript" src="<?=base_url()?>public/assets/js/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/popper.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/axios.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/vue.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/video.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/grocery_crud/themes/flexigrid/js/cookies.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/autobahn.js"></script>

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/app/helper.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/modules/adm/loket.js?_=<?=md5(microtime())?>"></script>
<script type="text/javascript">
	function get_xmode() {
		return '<?=$mode?>';
	}
	function base_url(){
		return '<?=base_url()?>';
	}
	function get_ws_server(){
		return '<?=$ws_server?>';
	}
	function get_mode(){
		return 'all';
	}
</script>
</head>
<body>

<div class="container-fluid">
	<div class="row headerT">
		<div class="col-md-12" style="">
			<h4 class="text-left" style="margin:0"><?=$nama_instansi?></h4>
			<small class="text-left"><?=$alamat_instansi?> </small>
			
		</div>
	</div>
	<div class="row" style="margin-bottom: 70px;padding-top: 1em">

		<div class="col-md-6 leftPane">
			<div class="row" style="padding-top: 5px">
				<div class="col-md-12" style="">
					<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border-bottom: none;">
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-list-tab" data-toggle="tab" href="#nav-list" role="tab" aria-controls="nav-list" aria-selected="true">List Antrian Pendaftaran</a>
                                <a class="nav-item nav-link" id="nav-form-tab" data-toggle="tab" href="#nav-form" role="tab" aria-controls="nav-form" aria-selected="false">Form Pendaftaran</a>
                            </div>
					     
					</div>
					</nav>
					 <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                        	<table class="table table-bordered" style="margin-top: 1px">
								<thead>
									<tr>
										<th>#</th>
										<th>NOMOR</th>
										<th>WAKTU AMBIL TIKET</th>
										<th>JENIS</th>
										<th>STATUS</th>
									</tr>
								</thead>
								<tbody id="list_antrian_body">
									<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
                        </div>
                        <div class="tab-pane" id="nav-form" role="tabpanel" aria-labelledby="nav-form-tab">
                        	<form class="form-horizontal" style="padding-top: 1em" action="javascript:;">
                        		<div class="form-group row">
                        			<label class="col-md-3 text-right">No. Antrian</label>
                        			<div class="col-md-6">
                        				<input type="text" disabled v-model="form.nomor" name="nomor" class="form-control" />
                        				<input type="hidden" v-model="form.id_antrian" name="id_antrian" class="form-control" />
                        			</div>
                        		</div>
                        		<div class="form-group row">
                        			<label class="col-md-3 text-right">Nama Pasien</label>
                        			<div class="col-md-8">
                        				<input type="text" :disabled="form.id_antrian==''" v-model="form.nama" name="nama" class="form-control" />
                        			</div>
                        		</div>
                        		<div class="form-group row">
                        			<label class="col-md-3 text-right">Alamat Pasien</label>
                        			<div class="col-md-8">
                        				<input type="text" :disabled="form.id_antrian==''" v-model="form.alamat" name="alamat" class="form-control" />
                        			</div>
                        		</div>
                        		<div class="form-group row">
                        			<label class="col-md-3 text-right">Poli Tujuan</label>
                        			<div class="col-md-8">
                        				<?=$dd_poli_all?>
                        			</div>
                        			<input type="hidden" name="nama_poli" v-model="form.nama_poli">
                        			<input type="hidden" name="dt" v-model="form.dt">
                        		</div>
                        		<div class="form-group row" style="padding: 0 0 1em">
                        			<div class="col-md-3"></div>
                        			<div class="col-md-8 text-right">
                        				<button class="btn btn-success" :disabled="invalidForm()" @click="doRegisterForm()"><i class="fas fa-check"></i> Selesai</button>
                        			</div>
                        		</div>
                        	</form>
                        </div>
                     </div>           
					 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row" id="admLoket" style="padding: 0 15px">
				<div class="col-md-4 kotak-a">
					<h4 class="text-center kotak-title">A . <i><?=app_cfg('adm_box_titles','bpjs')?></i></h4>
					<p class="text-center">{{a.nomor}}</p>
					<div class="row" style="padding: .5em">
						<div class="col-md-6">
							<button class="btn btn-primary" :disabled="a.status!=1 || a.btnCallState!=1" @click="executeBtnProc('a','call')"><i class="fas fa-volume-up"></i> Call <span>({{a.callAttempt}})</span></button>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<button class="btn btn-danger" :disabled="a.btnSkipState!=1" @click="executeBtnProc('a','skip')"><i class="fas fa-square"></i> Skip</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center mt1em" >
							<button class="btn btn-warning" :disabled="a.btnRegisterState!=1 " @click="executeBtnProc('a','register')"><i class="fas  fa-credit-card"></i> Pendaftaran</button>
						</div>
						<div>&nbsp;</div>
					</div>
				</div>
				<div class="col-md-4 kotak-b">
					<h4 class="text-center kotak-title" style="background-color: rgb(46, 204, 113)">B . <i><?=app_cfg('adm_box_titles','umum')?></i></h4>
					<p class="text-center">{{b.nomor}}</p>

					<div class="row" style="padding: .5em">
						<div class="col-md-6">
							<button class="btn btn-primary" :disabled="b.status!=1 || b.btnCallState!=1" @click="executeBtnProc('b','call')"><i class="fas fa-volume-up"></i> Call <span v-text="'('+b.callAttempt+')'"></button>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<button class="btn btn-danger" :disabled="b.btnSkipState!=1" @click="executeBtnProc('b','skip')"><i class="fas fa-square"></i> Skip</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center mt1em">
							<button class="btn btn-warning" :disabled="b.btnRegisterState!=1" @click="executeBtnProc('b','register')"><i class="fas  fa-credit-card"></i> Pendaftaran</button>
						</div>
					</div>
				</div>
				<div class="col-md-4 kotak-c">
					<h4 class="text-center kotak-title" style="background-color: #e74c3c">C . <i><?=app_cfg('adm_box_titles','lansia-anak')?></i></h4>
					<p class="text-center">{{c.nomor}}</p>

					<div class="row" style="padding: .5em">
						<div class="col-md-6">
							<button class="btn btn-primary" :disabled="c.status!=1 || c.btnCallState!=1" @click="executeBtnProc('c','call')"><i class="fas fa-volume-up"></i> Call <span v-text="'('+c.callAttempt+')'"></span></button>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<button class="btn btn-danger" :disabled="c.btnSkipState!=1" @click="executeBtnProc('c','skip')"><i class="fas fa-square"></i> Skip</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center mt1em">
							<button class="btn btn-warning" :disabled="c.btnRegisterState!=1" @click="executeBtnProc('c','register')"> <i class="fas  fa-credit-card"></i> Pendaftaran</button>
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