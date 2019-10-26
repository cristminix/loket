<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tiket</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/video-js.css">

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/popper.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/video.js"></script>

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/axios.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/jquery.blockui.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/autobahn.js"></script>

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/app/helper.js"></script>

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

<div class="container-fluid">
	<div class="row headerT">
		<div class="col-md-12" style="padding-left: 3em">
			<h2 class="text-center ttl" style="margin:0 "><?=$nama_instansi?></h2>
			<p class="text-center addr" style="margin:0 "><?=$alamat_instansi?> 
			<!-- Telp.<?=$tlp_instansi?></p> -->
		</div>
	</div>
	<div class="row">

		<div class="col-md-7">
			<p class="bantuan">
				Untuk mendapatkan nomor antrian sesuai dengan pilihan anda silahkan tekan tombol berikut:
			</p>
			<nav class="navbar navbar-default">
				<ul class="nav navbar-nav" style="width: 100%">
					<?foreach($jenis_pendaftaran as $jp):?>
					<?$btn=['bpjs'=>'primary','umum'=>'success','lansia-anak'=>'danger'][$jp->slug]?>
					<li style="margin:4px"><button class="btn btn-<?=$btn?> prnt-ifr <?=$jp->slug?>" href="<?=base_url()?>tiket/cetak/<?=$jp->slug?>"><?=$jp->kode?> : <?=$jp->nama?></button></li>
					<?endforeach?>
				</ul>
			</nav>
		</div>
		<div class="col-md-5">
			<div>
				<img src="<?=base_url()?>/public/assets/images/puskesmas-big.png" style="width: 100%">
			</div>
		</div>
	</div>
	<div class="row d footer">
		<div class="col-md-12 row-a" style="color: #fff;padding:1em 1em 1em 3em">
			<h4 class="" style="font-size: 100%;margin:2px">Sistem Informasi Antrian</h4>
			<small class="">Copyright &copy; 2019 Agung Rizky Tiga </small>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-12">
		<iframe src="" id="iframeCetak" style=""></iframe>
		</div>

	
</div>

</div>
</div>
<ul class="contextmenu">
  <li><a href="javascript:;" id="resetData">RESET DATA ANTRIAN </a></li>
  <li><a href="javascript:;" id="shutdownPc">MATIKAN MESIN</a></li>
  <li><a href="javascript:;" id="restartPc">RESTART MESIN</a></li>
</ul>
<div class="col-md-12">
			<div id="audioPlayer">
				<audio id="aplayer" class="video-js vjs-default-skin" width="100" height="50" controls="controls" preload="auto" data-setup='{"autoplay":false}'>
					<source src="<?=base_url()?>tts/speak/Tm9tb3JfQW50cmlhbl8sQSwsS29zb25nLCxLb3NvbmcsLEtvc29uZywx?q=1569117054848" type="audio/mp3"/>
					</audio>
			</div>
		</div>
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				
			</div>
			<div class="modal-body">
				<span class="text"></span>
			</div>
			<div class="modal-footer">
			<!-- <button type="button" class="btn btn-default" datadismiss="modal">
			Tutup
			</button> -->
			
			</div>
		</div>
	</div>
</div>
</body>
<style type="text/css">
	.contextmenu {
  display: none;
  position: absolute;
  width: 200px;
  margin: 0;
  padding: 0;
  background: #FFFFFF;
  border-radius: 5px;
  list-style: none;
  box-shadow: 0 15px 35px rgba(50,50,90,0.1),  0 5px 15px rgba(0,0,0,0.07);
  overflow: hidden;
  z-index: 999999;
}

.contextmenu li {
  border-left: 3px solid transparent;
  transition: ease .2s;
}

.contextmenu li a {
  display: block;
  padding: 10px;
  color: #B0BEC5;
  text-decoration: none;
  transition: ease .2s;
}

.contextmenu li a:hover {
  color: #000 !important;
}

.contextmenu li:hover a { color: #FFFFFF; }
	h4.ttl{
		    margin: 0;
		    font-size: 4em;
		    text-align: center;
	}
	p.addr{
		    margin: 0;
	    font-size: 2em;
	    text-align: center;
	}
	.row.d.footer{
		background:#34495e; 
		color: #fff;
		padding: .5em 0;
		position: fixed;
		bottom: 0;
		width: 100%;
	}
	p.bantuan{
		font-size: 24px;
	}
	#iframeCetak{
		width: 1px;
	    height:1px;
	    position: absolute;
	    top: 0;
	    overflow: hidden;
	    opacity: .5;
	}
	button.prnt-ifr{
		width: 100%;
	    text-align: left;
	    font-size: 4em;
	    margin: 8px;
	    padding: .5em;
	}
	.bantuan{
	    margin: 1em 1em 0em 2em;
	    display: block;
	    width: 484px;
	}
	/*button.prnt-ifr.bpjs{
		background: #3498db;
		border-color: #3498db;
	}*/
	body{
		background: #eee;
	}
	.headerT{
		background:#34495e; 
		color: #fff;
		padding: 1em 0;
	}
	#audioPlayer{
	width: 1px;
    height:1px;
    position: absolute;
    top: 0;
    overflow: hidden;
    opacity: .5;
}
</style>
<script type="text/javascript">
	$(document).ready(() => {
		$('button.prnt-ifr').click(()=>{
			let btn = $(event.target);
			var url = btn.attr('href');
			// console.log(url)
			btn.attr('disabled',true);
			lock_browser('<h4>Mencetak Tiket <span id="dot">.</span></h4>');
			
			let idot = setInterval(()=>{
				let sdot = $('span#dot');
				let text  = sdot.text();
				let tlen  = text.length;

				if(tlen >= 4){
					text = '.';
				}else{
					text += '.';
				}

				sdot.text(text);

			},1000);
			// setIFrameSrc('iframeCetak', url, btn);
			axios.post(url,{}).then((r)=>{
				let status = r.data.status;
				let text = r.data.message;

				if(status == 'ERR_TIMEOUT'){
					$('#info-modal .modal-title').text('Informasi');
			    	$('#info-modal span.text').html('<span style="font-size: 150%;font-style: italic;">'+text+'</span>');
			    	$('#info-modal').modal();
				} 
				btn.attr('disabled',false);
				unlock_browser();
				clearInterval(idot);
			});

			return false;
		});
		

		function setIFrameSrc(idFrame, url, btn) {
		    var originalFrame = document.getElementById(idFrame);
		    var newFrame = document.createElement("iframe");
		    newFrame.id = originalFrame.getAttribute("id");
		    newFrame.width = originalFrame.getAttribute("width");
		    newFrame.height = originalFrame.getAttribute("height");
		    newFrame.src = url;    
		    var parent = originalFrame.parentNode;
		    parent.replaceChild(newFrame, originalFrame);

		    $('#'+idFrame).on('load',() => {
			    console.log('load the iframe')
			    let cw = $('#'+idFrame).get(0).contentWindow;
			    if(cw.document.title === 'OK_PRINT'){
			    	cw.print();
			    	setTimeout(()=>{
			    		setIFrameSrc(idFrame, '');
						btn.attr('disabled',false);
						unlock_browser();

			    	},3000);
			    }else if(cw.document.title === 'ERR_TIMEOUT'){
			    	let text = $(cw.document.body).text();
			    	$('#info-modal .modal-title').text('Informasi');
			    	$('#info-modal span.text').html('<span style="font-size: 150%;font-style: italic;">'+text+'</span>');
			    	$('#info-modal').modal();
			    	setTimeout(()=>{
			    		setIFrameSrc(idFrame, '');
						btn.attr('disabled',false);
						unlock_browser();

			    	},3000);

			    };
			    //the console won't show anything even if the iframe is loaded.
			});
		}

		////////////////////////////////////////////////////////////////////////////
		//Show contextmenu:
		  $(document).contextmenu(function(e){
		    //Get window size:
		    var winWidth = $(document).width();
		    var winHeight = $(document).height();
		    //Get pointer position:
		    var posX = e.pageX;
		    var posY = e.pageY;
		    //Get contextmenu size:
		    var menuWidth = $(".contextmenu").width();
		    var menuHeight = $(".contextmenu").height();
		    //Security margin:
		    var secMargin = 10;
		    //Prevent page overflow:
		    if(posX + menuWidth + secMargin >= winWidth
		    && posY + menuHeight + secMargin >= winHeight){
		      //Case 1: right-bottom overflow:
		      posLeft = posX - menuWidth - secMargin + "px";
		      posTop = posY - menuHeight - secMargin + "px";
		    }
		    else if(posX + menuWidth + secMargin >= winWidth){
		      //Case 2: right overflow:
		      posLeft = posX - menuWidth - secMargin + "px";
		      posTop = posY + secMargin + "px";
		    }
		    else if(posY + menuHeight + secMargin >= winHeight){
		      //Case 3: bottom overflow:
		      posLeft = posX + secMargin + "px";
		      posTop = posY - menuHeight - secMargin + "px";
		    }
		    else {
		      //Case 4: default values:
		      posLeft = posX + secMargin + "px";
		      posTop = posY + secMargin + "px";
		    };
		    //Display contextmenu:
		    $(".contextmenu").css({
		      "left": posLeft,
		      "top": posTop
		    }).show();
		    //Prevent browser default contextmenu.
		    return false;
		  });

		  //Hide contextmenu:
		  $(document).click(function(){
		    $(".contextmenu").hide();
		  });
		  $('a#resetData').on('click',()=>{
		  	if(confirm('Apakah Anda yakin ingin mereset data ?')){
		  		let postData = {

		  		};
		  		lock_browser('<h4>Mohon Menunggu ...</h4>');
		  		let url = base_url() + 'tiket/reset';

		  		axios.post(url, postData).then((r)=>{
		  			$('#info-modal .modal-title').text('Informasi');
			    	$('#info-modal span.text').html('<span style="font-size: 150%;font-style: italic;"> Data antrian telah direset !</span>');
			    	$('#info-modal').modal();

		  			// alert('Data antrian telah direset !');
		  			// console.log(r);
		  			unlock_browser();
		  		});
		  	}
		  });
		  $('a#shutdownPc').on('click',()=>{
		  	if(confirm('Apakah Anda yakin ingin mematikan mesin ?')){
		  		let postData = {

		  		};
		  		lock_browser('<h4>Mohon Menunggu ...</h4>');
		  		let url = base_url() + 'tiket/shutdown';

		  		axios.post(url, postData).then((r)=>{
		  		
		  			// unlock_browser();
		  		});
		  	}
		  });
		  $('a#restartPc').on('click',()=>{
		  	if(confirm('Apakah Anda yakin ingin mematikan mesin ?')){
		  		let postData = {

		  		};
		  		lock_browser('<h4>Mohon Menunggu ...</h4>');
		  		let url = base_url() + 'tiket/reboot';

		  		axios.post(url, postData).then((r)=>{
		  		
		  		});
		  	}
		  });
		///////////////////////////////////////////////////////////////////////////
	//**************************************************
	let Ws = {
		conn: 0,
		instance:false,
		autoReconnectInterval : 5*1000,
		init:function() {
			Ws.conn = new ab.Session('ws://'+get_ws_server()+':8080',
				()=>{
					Ws.conn.subscribe('onRepeatCall',(cat,item)=>{
						if(item.data != null){
							// appMonitorVm.setData(item.data);
							console.log(item.data);

							let lkt = item.data;
							
							if(lkt.curr_no !=null ){
								let kode = lkt.curr_no[0];
								$nama_loket = kode == 'A' ? 'BPJS':'UMUM';
								let textUri = 'Nomor_Antrian_'+extract_tts(lkt.curr_no)+",Menuju ke Pendaftaran ";// +$nama_loket;
								let url = base_url() + 'tts/speak/' + btoa(textUri)+'/audio.mp3?speed=2&q='+(new Date()).getTime();

								videojs('aplayer').loadMedia({src:url});
								videojs('aplayer').play();

								let dpl_url = base_url() + 'adm/loket_update_dal';

								axios.post(dpl_url,lkt).then((r)=>{
									console.log(r.data);
								});
							}
								
						}else{
							// appMonitorVm.init();
						}
						
			 			// console.log(cat)
			 			// console.log(item.data)

					});
				},
				()=>{
					console.warn('koneksi WecbSocket ditutup');
					Ws.reconnect();
				},
				{'skipSubprotocolCheck': true}
			); 
		},
		reconnect : function( ){
			console.log('Ws: retry in '+Ws.autoReconnectInterval+'ms' );
			var self = Ws;
			setTimeout(function(){
				console.log("Ws: reconnecting...");
				self.init();
			},Ws.autoReconnectInterval);
		}

	}
	
	Ws.init();
	//*************************************************

	});	
</script>


</html>