$(document).ready(()=>{
	
	let loket_data = {};
	let appMonitorVm = new Vue({
		el:'#appMonitor',
		data:{
			// video_url:site_url('public/assets/videos/oceans.mp4'),
			a_cx:0,
			b_cx:0,
			c_cx:0,
			curr_no:'n/a',
			kode:''
		},
		mounted:function() {
			console.log('mounted')
			// console.log(this.video_url)
			// videojs('my-player').loadMedia({src:this.video_url});
			// videojs('my-player').play();

			// setTimeout(()=>{
				try{$('video').get(0).play();}catch(e){}
			// },10000);

			this.init();
		},
		methods:{
			setData:function(data){

				this.a_cx = data.a_cx;
				this.b_cx = data.b_cx;
				this.c_cx = data.c_cx;
				this.curr_no = data.curr_no;
				if(this.curr_no == null){
					this.curr_no = 'n/a';
				}
				this.kode = this.curr_no.toLowerCase()[0];

				let colours={
					'a':'rgb(63, 196, 269)',
					'b':'rgb(99, 226, 162)',
					'c':'rgb(265, 97, 86)'
				} ;
				let colours_top={
					'a':'rgb(52, 152, 219)',
					'b':'rgb(46, 204, 113)',
					'c':'rgb(231, 76, 60)'
				} ;
				if(this.curr_no !='n/a' || this.curr_no == null){
					$('.b-curr-no').css('background-color',colours[this.kode]);
					$('.row-a').css('background-color',colours_top[this.kode]);
				}else{
					$('.b-curr-no').css('background-color','purple');
					$('.row-a').css('background-color','purple');
				}
				
			},
			init:function(){
				let url = base_url()+'antrian/loket_init';
				let self = this;
				axios.post(url,{}).then((r)=>{
					self.setData(r.data);
				})
			}
		}
	});

	//**************************************************
	let Ws = {
		conn: 0,
		instance:false,
		autoReconnectInterval : 5*1000,
		init:function() {
			Ws.conn = new ab.Session('ws://'+get_ws_server()+':8080',
				()=>{
					Ws.conn.subscribe('onUpdateDal',(cat,item)=>{
						if(item.data != null){
							if(item.data.curr_no != null){
								appMonitorVm.setData(item.data);
							}
						}else{
							appMonitorVm.init();
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

	// $(document.body).on('mouseover',()=>{
	// 	$('video').get(0).muted=false;
	// });

	$(window).resize(()=>{
		setTimeout(()=>{
			let wh = $(window).height();
			let ah = $('.row.a').height();
			let bh = $('.row.b').height();
			let ch = $('.row.c').height();
			let h1cnh = $('h1.curr_no').height();


			let rh = wh - ah - ch;
			let mgtop = (rh - (h1cnh)-10)/2; 
			$('.p_curr_no').css('margin-top',mgtop+'px');
			$('video').css('height',(rh)+'px').css('width','auto');
			setTimeout(()=>{
				try{$('video').get(0).play();}catch(e){}
			},2000);
		},500);
	}).resize();

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	var videoList = [{
	  sources: [{
	    src: base_url() + 'public/assets/videos/Animasi-Stunting.mp4',
	    type: 'video/mp4'
	  }]
	  
	}, {
	  sources: [{
	    src: base_url() + 'public/assets/videos/Pengenalan-dan-Pencegahan-Penyakit-Tuberkulosis-Paru.mp4',
	    type: 'video/mp4'
	  }]
	
	}, {
	  sources: [{
	    src: base_url() + 'public/assets/videos/Sosialisasi-Jaminan-Kesehatan-Nasional-BPJS.mp4',
	    type: 'video/mp4'
	  }]
	
	}, {
	  sources: [{
	    src: base_url() + 'public/assets/videos/Sosialisasi-Jaminan-Kesehatan-Nasional-BPJS.mp4',
	    type: 'video/mp4'
	  }]
	
	}];

	var player = videojs(document.querySelector('video'), {
	  inactivityTimeout: 0
	});
	try {
	  // try on ios
	  player.volume(1);
	  player.play();
	} catch (e) {}
	//player.playlist(videoList, 4);/// play video 5
	player.playlist(videoList);
	// document.querySelector('.previous').addEventListener('click', function() {
	//   player.playlist.previous();
	// });
	// document.querySelector('.next').addEventListener('click', function() {
	//   player.playlist.next();
	// });
	// document.querySelector('.jump').addEventListener('click', function() {
	//   player.playlist.currentItem(2); // play third
	// });

	player.playlist.autoadvance(0); // play all

	Array.prototype.forEach.call(document.querySelectorAll('[name=autoadvance]'), function(el) {
	  el.addEventListener('click', function() {
	    var value = document.querySelector('[name=autoadvance]:checked').value;
	    //alert(value);
	    player.playlist.autoadvance(JSON.parse(value));
	  });
	});

	/* ADD PREVIOUS */
	var Button = videojs.getComponent('Button');

	// Extend default
	var PrevButton = videojs.extend(Button, {
	  //constructor: function(player, options) {
	  constructor: function() {
	    Button.apply(this, arguments);
	    //this.addClass('vjs-chapters-button');
	    this.addClass('icon-angle-left');
	    this.controlText("Previous");
	  },

	  // constructor: function() {
	  //   Button.apply(this, arguments);
	  //   this.addClass('vjs-play-control vjs-control vjs-button vjs-paused');
	  // },

	  // createEl: function() {
	  //   return Button.prototype.createEl('button', {
	  //     //className: 'vjs-next-button vjs-control vjs-button',
	  //     //innerHTML: 'Next >'
	  //   });
	  // },

	  handleClick: function() {
	    console.log('click');
	    player.playlist.previous();
	  }
	});

	/* ADD BUTTON */
	//var Button = videojs.getComponent('Button');

	// Extend default
	var NextButton = videojs.extend(Button, {
	  //constructor: function(player, options) {
	  constructor: function() {
	    Button.apply(this, arguments);
	    //this.addClass('vjs-chapters-button');
	    this.addClass('icon-angle-right');
	    this.controlText("Next");
	  },

	  handleClick: function() {
	    console.log('click');
	    player.playlist.next();
	  }
	});

	// Register the new component
	videojs.registerComponent('NextButton', NextButton);
	videojs.registerComponent('PrevButton', PrevButton);
	player.getChild('controlBar').addChild('PrevButton', {}, 0);
	player.getChild('controlBar').addChild('NextButton', {}, 2);
	/////////////////////////////////////////////////////////////////////////////////////////////////////
});


