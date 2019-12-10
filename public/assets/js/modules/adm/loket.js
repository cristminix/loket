function reQueue(item_64){
	if(confirm('Aktifkan Kembali ?')){
		let item = JSON.parse(atob(item_64));
		// console.log(item);
		let url = base_url()+'adm/loket_requeue/'+item_64;
		let url_reactivate = base_url()+'adm/loket_reactivate/'+item_64;
		axios.post(url_reactivate,{id:item}).then((r)=>{

		});
	}
	
}
$(document).ready(()=>{
	console.log('Mode:'+get_xmode());
	
	function create_loket(item,obj){
		if(typeof obj == 'undefined'){
			obj = {};
		}
		$.each(item,(i,j)=>{
			if(typeof obj[i] == 'undefined'){
				obj[i] = j;
			}
		});
		return $.extend({},obj);
	}

	function create_lkt(kode,nomor,obj){
		let lkt = {kode:kode,nomor:nomor,id:-1,status:-1,jp_id:-1,

			
		 
			btnCallState:1,
			btnSkipState:0,
			btnRegisterState:0,
			callAttempt:0 // kontrol button enabled
		}
		 
		if(typeof obj != 'object'){
			obj = {};
		}
		$.each(lkt,(i,j)=>{
			if(typeof obj[i] == 'undefined'){
				obj[i] = j;
			}
		});

		return $.extend({},obj);
	}

	let loket_data = {};
	let admLoketVm = new Vue({
		el : '#admLoket',
		data:{
			lds: {},
			invalid_ld:{
				id:-1,
				nomor:'n/a',
				waktu_mulai:'-',
				slug:''
			},
			a:create_lkt('a',''),
			b:create_lkt('b',''),
			c:create_lkt('c',''),
			ttsState : 0,
			firstTime:false,
			lastPlayerId:'',
			lastPlayAttempt:0,
			currentCode : ''
		},
		methods:{
			onUpdatePlayerState:function(state){
				let self = this;
				let kode = this.currentCode;
				// console.log(kode);

				self[kode].btnCallState = 0;

				switch(state){
					case 'playing':
				    	// console.log('self['+kode+'].btnCallState='+self[kode].btnCallState);
					break;
					case 'ended':
						self[kode].btnCallState = 1;
						self.ttsState = 0;
						self.lastPlayAttempt = 0;

						//
						self[kode].btnRegisterState =1;
						self[kode].callAttempt +=1;

						if(self[kode].callAttempt >= 1){
							self[kode].btnSkipState = 1;
						}
						
						self._updateCookieRow(self[kode].id,{
							callAttempt:self[kode].callAttempt,
						});

						// console.log(JSON.stringify(self[kode]));
					break;
					case 'error':
						self[kode].btnCallState = 1;
						self.ttsState = 0;
						if(self.lastPlayAttempt<3){
							setTimeout(()=>{
								self._executeBtn_call(lkt);
								self.lastPlayAttempt += 1;
							},500);
							
						}else{
							alert('Tts Error Detected !!!');
						}
					break;
				}
			},
			executeBtnProc:function(kode,meth){
				let lkt = this[kode];
				let method = '_executeBtn_'+ meth;
				return this[method](lkt);
			},
			_executeBtn_call:function(lkt){
				// console.log('called')
				if(this.ttsState!=0){
					console.log('dont run twice');
					return;
				}
				this.ttsState = 0;
				let kode = lkt.kode.toLowerCase();
				this.currentCode = kode;
				let self = this;
				// console.log(JSON.stringify(lkt))
				let textUri = 'Nomor_Antrian_'+extract_tts(lkt.nomor)+",Menuju ke Pendaftaran";
				let url = base_url() + 'tts/speak/' + btoa(textUri)+'/audio.mp3?q='+(new Date()).getTime();

				videojs('aplayer').loadMedia({src:url});
				videojs('aplayer').play();
				videojs('aplayer').muted(true);
				

				let dpl_url = base_url() + 'adm/loket_update_dal?repeatCall=true';

				axios.post(dpl_url,lkt).then((r)=>{
					console.log(r.data);
				});
				
			},
			_executeBtn_skip:function(lkt){
				// console.log('called')
				if(!confirm('Apakah Anda yakin ingin melewati antrian '+lkt.nomor+'?')){
					return;
				}
				let self = this;
				let kode = lkt.kode.toLowerCase();
				let url = base_url() + 'adm/loket_skip/' + lkt.id;
				// this.currentCode = kode;

				axios.get(url).then(()=>{
					// console.log(lkt.id+':skipped');
					// lkt.status = 3;
					self[kode] = create_lkt(kode,'');
					self.lds[lkt.slug] = create_lkt(kode,'');
					self._clearCookieRow(lkt);

					frmRegVm.resetFormData();
	 				update_list_loket(loket_data);

				});
				// console.log(url)

			},
			_executeBtn_register:function(lkt){
				let self = this;
				// activate form tab
				$('#nav-form-tab').click();
				frmRegVm.setFormData(lkt);
				// self[lkt.kode.toLowerCase()].btnSkipState = 0;
				// console.log(lkt)
			},
			_afterRegister: function(lkt){
				let self = this;
				let kode = lkt.kode.toLowerCase();
				
				self[kode] = create_lkt(kode,'');
				self.lds[lkt.slug] = create_lkt(kode,'');
				self._clearCookieRow(lkt);
	 			update_list_loket(loket_data);
				
				
			},
			_clearCookieRow:function(lkt){
				eraseCookie(lkt.id+'_'+'_callAttempt');
			},
			_updateCookieRow: function(id,obj){
				let key = id;
				$.each(obj,function(i,j){
					let cookie_key = key + '_' + i;
					createCookie(cookie_key,j,1);
				});
			},
			_getCookieRow: function(id,key){
				let cookie_key = id+'_'+key;
				return readCookie(cookie_key);
			},
			init_lkt:function(n){
				let self=this;
				$.each(n,(i,j)=>{
					
					let kode = j.kode.toLowerCase();
					
					self[kode] = create_lkt(kode,j.nomor,j,true);

					let callAttempt = self._getCookieRow(self[kode].id,'callAttempt');
					callAttempt = parseInt(callAttempt)+0;
					if(!isNaN(callAttempt)){
						self[kode].callAttempt = callAttempt;
						if(callAttempt >= 1){
							self[kode].btnRegisterState= 1;
						}
						if(callAttempt >= 3){
							self[kode].btnSkipState = 1;
						}
					}
				});
			}
		},
		watch:{

			// a:function(n,o){

			// },
			// b:function(n,o){

			// },
			// c:function(n,o){

			// },
			lds:function(n,o){
				this.init_lkt(n);
			}
		}
	});
	let frmRegVm = new Vue({
		el:'#nav-form',
		data:{
			lkt:{},
			form:{
				nomor:'',
				id_antrian:'',
				nama:'',
				alamat:'',
				nama_poli:'',
				id_poli:'',
				dt:''
			}
		},
		
		methods:{
			onChangePoli:function(){
				let node = $('select[name=id_poli]');
				this.form.nama_poli = node.find('option:selected').text();

			},
			invalidForm:function(){
				let p_valid = 0;
				let p_invalid = [];
				$.each(this.form,(i,j)=>{
					if(j.length == ''){
						p_invalid.push(i);
					}else{
						p_valid += 1;
					}
				});
				return p_invalid.length > 0;
			},
			isFormOpen:function(){

			},
			doRegisterForm:function(){
				let self = this;
				let max_valid = 6;
				let p_valid = 0;
				let p_invalid = [];
				$.each(this.form,(i,j)=>{
					if(j.length == ''){
						p_invalid.push(i);
					}else{
						p_valid += 1;
					}
				});
				if(p_invalid.length > 0){
					alert('Mohon Lengkapi Data Anda');
					setTimeout(()=>{
						$('input[name='+p_invalid[0]+']').focus();
					},500);
					return;
				}
				let url = base_url() + 'adm/loket_register';
				axios.post(url,this.form).then((r)=>{
					let result = r.data;
					if(result.status){
						admLoketVm._afterRegister(self.lkt);
						alert('Register Berhasil !');
						self.resetFormData();
					}
				});
				// console.log(this.form);
			},
			resetFormData:function(){
				this.form = {
					nomor:'',
					id_antrian:'',
					nama:'',
					alamat:'',
					nama_poli:'',
					id_poli:'5',
					kode:'',
					dt:''
				};
			},
			setFormData: function(lkt){
				let self = this;
				this.lkt = lkt;
				this.form.nomor = lkt.nomor;
				this.form.kode = lkt.kode;
				this.form.id_antrian = lkt.id;
				
				if(get_mode() != 'all'){
					this.form.id_poli = 5;
					this.form.nama_poli="Poli Kesehatan Awal";
				}
				

				this.form.dt = mysql_now();
				setTimeout(()=>{
					$('#nav-form input[name=nama]').focus();

				},1000);
			}
		}
	});
	function update_list_loket(ld,firstTime) {
		let mode = get_xmode();
		let url = base_url()+'adm/loket_list?mode='+ mode;

		if(mode == 'multiple'){
			url += '&jp_id='+get_jp_id();
		}
		if(mode == 'merge'){
			url += '&jp_ids='+get_jp_ids();
		}
		axios.get(url).then((r)=>{
			//console.log(r);
			let content = '';
			let loket_data= $.extend({},admLoketVm.lds);
			// let lds = {};
			if(r.data.length == 0){
				content += '<tr><td colspan="5">Belum ada data antrian</td></tr>';

			}
			$.each(r.data,(id,item)=>{
				// content += '<tr jp_id="'+item.jp_id+'"><td>'+(id+1)+'</td><td>'+item.nomor+'</td><td>'+item.waktu_mulai+'</td><td>'+item.slug.toUpperCase()+'</td><td>'+(item.status=='1'?'Menunggu':(item.status=='3'?'Lewat':'-'))+'</td></tr>'
				let number = id+1;
				let slug=item.slug.toUpperCase();
				let item_64 = btoa(JSON.stringify(item));
				let lewat_a = `<a href="javascript:;" onclick="reQueue('${item_64}')">Lewat</a>`;
				let status_text=item.status=='1'?'Menunggu':(item.status=='3'?lewat_a:'-');

				content += `<tr jp_id="${item.jp_id}">
							<td>${number}</td>
							<td>${item.nomor}</td>
							<td>${item.waktu_mulai}</td>
							<td>${slug}</td>
							<td>${status_text}</td></tr>`;	

				if(item.status == 1){
					if( typeof loket_data[item.slug] == 'undefined'){
						loket_data[item.slug] = create_loket(item,{});
						// console.log(loket_data[item.slug]);
					}
					else if(typeof loket_data[item.slug] != 'undefined'){
						if( loket_data[item.slug].status == -1){
							loket_data[item.slug] = create_loket(item,{});
							// console.log(loket_data[item.slug]);

						}
						
					}
				}	
					
				
			});
			if(firstTime){
				admLoketVm.firstTime =true;
			}
			admLoketVm.lds=loket_data;
			$('#list_antrian_body').html(content);
		}).then((e)=>{

			
		});
	}

	// setInterval(()=>{
	//  	update_list_loket(loket_data);
	//  },2000);
	update_list_loket(loket_data,true);

	//**************************************************

	 

	let Ws = {
		conn: 0,
		instance:false,
		autoReconnectInterval : 5*1000,
		init:function() {
			Ws.conn = new ab.Session('ws://'+get_ws_server()+':8080',
				()=>{
					Ws.conn.subscribe('onCetakTiket',(cat,item)=>{
						 
						// console.log('Ada pendaftaran loket baru : '+item.data.nomor);
						// console.log(item.data);
			 			update_list_loket(loket_data);

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

	let player  = videojs('aplayer');

	player.on('playing',()=>{
    	admLoketVm.onUpdatePlayerState('playing');
    });
    player.on("ended",function(){
    	admLoketVm.onUpdatePlayerState('ended');
    });
    player.on("error",function(){
    	admLoketVm.onUpdatePlayerState('error');
    });
});