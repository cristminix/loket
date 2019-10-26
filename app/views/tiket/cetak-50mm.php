<!DOCTYPE html>
<html>
<head>
	<title>OK_PRINT</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/paper.css">
	<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css"> -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css"> -->
</head>
<body style="text-align: center;">
<div id="kertas">
	<div id="inner">
		<table id="tiket" class="table table-bordered">
			<thead>
				<tr>
					<td colspan="3" style="border: none;">
						<h4 class="title"><?=$nama_instansi?></h4>	
						<h4 class="title"><?=$nama_kabupaten?></h4>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="border-right: none;padding: 2px;">
						<?=$hari?>
					</td>
					<td style="border-left: none;border-right: none;padding: 2px;">
						<?=$tanggal?>
					</td>
					<td style="border-left: none;padding: 2px;">
						<?=$waktu?>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="border: none">
						<h4 class="title" style="font-size: 1em">NO. ANTRIAN <?=strtoupper($jenis)?></h4>	
						<h1 style="font-size: 4em;margin: 0;"><?=$nomor_antrian?></h1>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="footer" style="border: none">
						<p>Silahkan Menunggu Sampai</p>
						<p>Nomor Tiket Anda Dipanggil</p>
						<i>Terima Kasih Atas Kunjungan Anda</i>
					</td>
				</tr>
			</tbody>
		</table>
	
	<!-- <p><img style="width: 50px;margin: 0" src="<?=base_url()?>public/assets/images/puskesmas.png"></p> -->	
	
<!-- 	<small>Terima kasih atas kunjungan Anda</small><br>
	<small style="font-size: 50%"><?=$tanggal_waktu?> WIB.</small> -->
	</div>
</div>
</body>
<style type="text/css">
	body{
		margin:0;
		/*font-family:"Arial";*/
		font-size:82%;
		padding:0;
	}
	table#tiket{
		width: 100%;
		margin:0;
	}
	table#tiket.table-bordered thead th,
	table#tiket.table-bordered tbody td,
	table#tiket.table-bordered thead td{
		border:solid 1px #000 ;
	}
	td.footer{
		border-top: none !important;
		padding-top: 0;
		font-size:90%;
	}
	td.footer > p{
		margin: 0;
	}
	div#kertas{
		/*border: solid 1px #000;*/
		padding: 0;
		width: 50mm;
	}
	div#inner{
		/*border: solid 1px #000;*/
		width: 100%;
	}
	table#tiket,
	table#tiket.table-bordered thead th,
	table#tiket.table-bordered tbody td,
	table#tiket.table-bordered thead td
	{
		border-color: #000 !important;
	}
	h4.title{
		margin:0;
		font-size: 90%;
	}
</style>
</html>