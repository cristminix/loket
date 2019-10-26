$(document).ready(()=>{
	//
	let admLaboTable = new Vue({
		'el':'#admLaboTable',
		data:{
			list:[]
		},
		mounted: function(){
			this.init_list();
		},
		methods:{
			init_list:function(skip){
				let self = this;
				let url = base_url() + 'adm/laborat_list';

				axios.post(url,{}).then((r)=>{
					console.log(r)
					self.list = r.data;
					if(typeof skip == 'undefined'){
						admPoliBox.init();
					}
					
				});
			},
			insertToQueue: function(v) {
				admPoliBox.setData(v);
			}
		}
	});
	let admPoliBox = new Vue({
		'el':'#admLaboBox',
		data:{
			lastQueue:null,
			nama:'',
			id_lab:'-1',
			poli_id:0,
			to_id_poli:'',
			alamat:'',
			callAttempt:0,
			btnSkipState:0,
			btnCallState:1,
			btnApotekState:0,
			status:-1,
			jenis:'',
			jenis_slug:'',
			row:{},
			TTS_STATE:1,
			lastPlayAttempt :0
		},
		mounted: function(){
			this.init();
			// document.title = 'Admin ' + this.nama_poli;
		},
		methods:{
			init:function(){
				this.nextQueue();
			},
			nextQueue: function(){
				for(let i = 0 ; i < admLaboTable.list.length ; i++){
					row = admLaboTable.list[i];
					if(row.status == 1){
						this.row = row;
						if(this.lastQueue == null){
							this.setData(row);
						}else{
							this.setData(this.lastQueue);
							
						}
						break;
					}
				}
			},
			resetData:function(){

				
				this.nama='';
				this.id_lab='-1';
				this.poli_id=0;
				this.alamat='';
				this.callAttempt=0;
				this.btnSkipState=0;
				this.btnCallState=1;
				this.btnApotekState=0;
				this.status=-1;
				this.jenis='';
				this.to_id_poli='',
				this.jenis_slug='';
				this.row={};
				this.TTS_STATE=1;
				this.lastPlayAttempt =0; 

				this.lastQueue = null;

			},
			setData:function(row){
				this.lastQueue = row;
				this.nama = row.nama;
				this.alamat = row.alamat;
				this.jenis = row.jenis;
				this.status = row.status;
				this.id_lab = row.id;
				this.poli_id = row.poli_id;
				this.btnSkipState = 0;
				this.btnApotekState = 0;
				
				// this.callAttempt = 0;
				// GET CALL ATTEMP FROM COOKIE
				this.callAttempt = this.getRawCookie('callAttempt',this.id_lab,0);
				if(this.callAttempt >= 1){
					this.btnSkipState = 1;
				}
				if(this.callAttempt > 0){
					this.btnApotekState=1;
				}
			},
			executeBtnProc:function(meth,a){
				let method = '_executeBtn_'+ meth;
				return this[method]( a);
			},
			_executeBtn_call:function(a){
			 	// console.log(lkt);
			 	if(typeof a == 'undefined'){
			 		return;
			 	}
			 	if(a != 1){
			 		return;
			 	}
				let self = this;
				 
				let textUri = 'Pangilan,_Kepada,__'+ this.nama.replace(/\W/,',')+',,    ,., '+this.alamat +',Mohon Segera Menuju ke Laboratorium';
				let url = base_url() + 'tts/speak/' + btoa(textUri)+'/audio.mp3?q='+(new Date()).getTime();

				videojs('aplayer').loadMedia({src:url});
				videojs('aplayer').play();

				// this.callAttempt += 1;

				// let dpl_url = base_url() + 'adm/loket_update_dal';

				// axios.post(dpl_url,lkt).then((r)=>{
				// 	console.log(r.data);
				// });
			},
			_executeBtn_register_poli:function(){
				
				let self = this;
				let apo_url = base_url() + 'adm/lab_register/'+this.id_lab;
				if(this.to_id_poli == ''){
					alert('Mohon Pilih Tujuan Poli');
					return;
				}
				let postData = {
					id_poli:this.poli_id,
					to_id_poli:this.to_id_poli,
					nama:this.nama,
					id_lab:this.id_lab,
					alamat:this.alamat,
					jenis:this.jenis
				};
				axios.post(apo_url,postData).then((r)=>{
					console.log(r.data);

					// self.status = 2;
					
					self.clearRawCookie('callAttempt',self.id_ap);
					self.resetData();
					admLaboTable.init_list();

				});
			},
			_executeBtn_skip:function(lkt){
				//ERASE COOKIE
				let self = this;
				let skip_url = base_url() + 'adm/laborat_skip/'+this.id_lab;

				axios.post(skip_url,{id:this.id_lab}).then((r)=>{
					console.log(r.data);

					// self.status = 2;
					
					self.clearRawCookie('callAttempt',self.id_lab);
					self.resetData();
					admLaboTable.init_list();

				});
			},
			_executeBtn_apotek:function(lkt){
				let self = this;
				let apo_url = base_url() + 'adm/laborat_apotek/'+this.id_lab;
				let postData = {
					id_lab:this.id_lab,
					id_poli:this.poli_id,
					nama:this.nama,
					alamat:this.alamat
				};
				axios.post(apo_url,postData).then((r)=>{
					console.log(r.data);

					// self.status = 2;
					
					self.clearRawCookie('callAttempt',self.id_lab);
					self.resetData();
					admLaboTable.init_list();

				});
			},
			
			onUpdatePlayerState:function(state){
				let self = this;
				// let kode = this.currentCode;
				// console.log(kode);

				this.btnCallState = 0;

				switch(state){
					case 'playing':
				    	// console.log('self['+kode+'].btnCallState='+self[kode].btnCallState);
					break;
					case 'ended':
						this.btnCallState = 1;
						this.TTS_STATE = 0;
						this.lastPlayAttempt = 0;

						//
						this.callAttempt = parseInt(this.callAttempt)+1;
						this.updateRawCookie('callAttempt',this.id_lab,this.callAttempt);
						if(this.callAttempt >= 1){
							this.btnSkipState = 1;
						}
						this.btnApotekState=1;
						// if(this.laborat != 0){
						// 	this.btnLaboratState = 1;
						// }
						// self._updateCookieRow(self[kode].id,{
						// 	callAttempt:self[kode].callAttempt,
						// });

						// console.log(JSON.stringify(self[kode]));
					break;
					case 'error':
						this.btnCallState = 1;
						this.TTS_STATE = 0;
						if(this.lastPlayAttempt<3){
							setTimeout(()=>{
								self._executeBtn_call();
								self.lastPlayAttempt += 1;
							},500);
							
						}else{
							alert('Tts Error Detected !!!');
						}
					break;
				}
			},
			clearRawCookie:function(prop,id){
				let cookie_key = id + '_lab_' + prop;
				eraseCookie(cookie_key);
			},
			updateRawCookie: function(prop,id,value){
				let cookie_key = id + '_lab_' + prop;
				eraseCookie(cookie_key);
				createCookie(cookie_key,value,1);
			 
			},
			getRawCookie: function(prop,id,d){
				let cookie_key = id+'_lab_'+prop;
				let r = readCookie(cookie_key);
			 
				return !r?d:r;
			},
		}
	});

	//

	let player  = videojs('aplayer');

	player.on('playing',()=>{
    	admPoliBox.onUpdatePlayerState('playing');
    });
    player.on("ended",function(){
    	admPoliBox.onUpdatePlayerState('ended');
    });
    player.on("error",function(){
    	admPoliBox.onUpdatePlayerState('error');
	});
	
	//**************************************************

	 

	let Ws = {
		conn: 0,
		instance:false,
		autoReconnectInterval : 5*1000,
		init:function() {
			Ws.conn = new ab.Session('ws://'+get_ws_server()+':8080',
				()=>{
					Ws.conn.subscribe('onRegLaborat',(cat,item)=>{
						 
						// console.log('Ada pendaftaran loket baru : '+item.data.nomor);
						// console.log(item.data);
			 			admLaboTable.init_list();

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