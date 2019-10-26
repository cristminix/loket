<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pengaturan</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/fontawesome/css/all.min.css">

	<script type="text/javascript" src="<?=base_url()?>public/assets/js/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/popper.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>public/assets/js/axios.min.js"></script>

</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h1>Pengaturan</h1>
		</div>
	</div>
	<div class="row">

		<div class="col-md-12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Pengaturan</th>
						<th>Nilai</th>
						<th>Aksi</th>
						<th>Keterangan</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?foreach($settings as $s):?>
					<tr key="<?=$s->key?>" validation="<?=$s->validation?>">
						<td class="s-name"><?=$s->name?></td>
						<td><textarea class="form-control s-edit hidden" key="<?=$s->key?>"><?=$s->value?></textarea><code class="s-value"><?=$s->value?></code></td>
						<td>
							<button class="btn btn-default edit-btn" key="<?=$s->key?>"><i class="fa fa-pencil"></i> Edit</button>
							<button class="btn btn-default save-btn hidden" key="<?=$s->key?>"><i class="fa fa-check"></i> </button>
							<button class="btn btn-default cancel-btn hidden" key="<?=$s->key?>"><i class="fa fa-times"></i> </button>
						</td>
						<td class="s-keterangan"><?=parse_setting_template($s->keterangan)?></td>
						<td class="s-url"><?=$s->url?></td>
					</tr>
					<?endforeach?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		
		<div class="col-md-12">
		
		</div>

	
</div>
</div>

</body>
<style type="text/css">
	.hidden{
		display: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(()=>{
		$('button.edit-btn').on('click',()=>{
			let nd  = $(event.currentTarget);
			let key = nd.attr('key');
			let p   = nd.closest('tr[key='+key+']');

			p.find('.s-edit').removeClass('hidden').focus();
			p.find('.s-value').addClass('hidden');
			p.find('.save-btn').removeClass('hidden').focus();
			p.find('.cancel-btn').removeClass('hidden').focus();
			p.find('.edit-btn').addClass('hidden');

			console.log(key)
		});

		$('button.save-btn').on('click',(a,b,c)=>{
			// console.log(arguments)
			let nd  = $(event.currentTarget);
			let key = nd.attr('key');
			let p   = nd.closest('tr[key='+key+']');
			let url = '<?=base_url()?>pengaturan/save';
			let value = p.find('.s-edit').val();
			 
			let validation = p.attr('validation');
			let rgx = new RegExp(validation);
			if(validation.length > 4){
				if(!value.match(rgx)){
					alert('format '+validation);
					return false;
				}
			}
			axios.post(url,{'key':key,'value':value})
				 .then((r)=>{
					console.log(r.data)
					p.find('.s-edit').addClass('hidden').focus();
					p.find('.s-value').html(r.data.value).removeClass('hidden');

					p.find('.save-btn').addClass('hidden').focus();
					p.find('.cancel-btn').addClass('hidden').focus();
					p.find('.edit-btn').removeClass('hidden');	
				}).then((e)=>{
					console.log(e);
				});

			

			console.log(key)
		});

		$('button.cancel-btn').on('click',(a,b,c)=>{
			// console.log(arguments)
			let nd  = $(event.currentTarget);
			let key = nd.attr('key');
			let p   = nd.closest('tr[key='+key+']');

			p.find('.s-edit').addClass('hidden').focus();
			p.find('.s-value').removeClass('hidden');

			p.find('.save-btn').addClass('hidden').focus();
			p.find('.cancel-btn').addClass('hidden').focus();
			p.find('.edit-btn').removeClass('hidden');

			console.log(key)
		});
	});
</script>
</html>