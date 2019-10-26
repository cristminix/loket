<!DOCTYPE html>
<html>
<head>
	<title>OK_PRINT</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/paper.css">
	<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-grid.min.css"> -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/css/bootstrap-reboot.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css"> -->
<style type="text/css">
@page { margin: 0 }
body { margin: 0 }
.sheet {
  margin: 0;
  overflow: hidden;
  position: relative;
  box-sizing: border-box;
  page-break-after: always;
}

/** Paper sizes **/
body.A3           .sheet { width: 297mm; height: 419mm }
body.A3.landscape .sheet { width: 420mm; height: 296mm }
body.A4           .sheet { width: 210mm; height: 296mm }
body.A4.landscape .sheet { width: 297mm; height: 209mm }
body.A5           .sheet { width: 148mm; height: 209mm }
body.A5.landscape .sheet { width: 210mm; height: 147mm }

/** Padding area **/
.sheet.padding-10mm { padding: 10mm }
.sheet.padding-15mm { padding: 15mm }
.sheet.padding-20mm { padding: 20mm }
.sheet.padding-25mm { padding: 25mm }

/** For screen preview **/
@media screen {
  body { background: #e0e0e0 }
  .sheet {
    background: white;
    box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
    margin: 5mm;
  }
}

/** Fix for Chrome issue #273306 **/
@media print {
           body.A3.landscape { width: 420mm }
  body.A3, body.A4.landscape { width: 297mm }
  body.A4, body.A5.landscape { width: 210mm }
  body.A5                    { width: 148mm }
}

/*!
 * Bootstrap Reboot v4.0.0 (https://getbootstrap.com)
 * Copyright 2011-2018 The Bootstrap Authors
 * Copyright 2011-2018 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * Forked from Normalize.css, licensed MIT (https://github.com/necolas/normalize.css/blob/master/LICENSE.md)
 */*,::after,::before{box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}@-ms-viewport{width:device-width}article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#fff}[tabindex="-1"]:focus{outline:0!important}hr{box-sizing:content-box;height:0;overflow:visible}h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}abbr[data-original-title],abbr[title]{text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted;cursor:help;border-bottom:0}address{margin-bottom:1rem;font-style:normal;line-height:inherit}dl,ol,ul{margin-top:0;margin-bottom:1rem}ol ol,ol ul,ul ol,ul ul{margin-bottom:0}dt{font-weight:700}dd{margin-bottom:.5rem;margin-left:0}blockquote{margin:0 0 1rem}dfn{font-style:italic}b,strong{font-weight:bolder}small{font-size:80%}sub,sup{position:relative;font-size:75%;line-height:0;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}a:hover{color:#0056b3;text-decoration:underline}a:not([href]):not([tabindex]){color:inherit;text-decoration:none}a:not([href]):not([tabindex]):focus,a:not([href]):not([tabindex]):hover{color:inherit;text-decoration:none}a:not([href]):not([tabindex]):focus{outline:0}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}pre{margin-top:0;margin-bottom:1rem;overflow:auto;-ms-overflow-style:scrollbar}figure{margin:0 0 1rem}img{vertical-align:middle;border-style:none}svg:not(:root){overflow:hidden}table{border-collapse:collapse}caption{padding-top:.75rem;padding-bottom:.75rem;color:#6c757d;text-align:left;caption-side:bottom}th{text-align:inherit}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color}button,input,optgroup,select,textarea{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button,select{text-transform:none}[type=reset],[type=submit],button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=date],input[type=datetime-local],input[type=month],input[type=time]{-webkit-appearance:listbox}textarea{overflow:auto;resize:vertical}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;max-width:100%;padding:0;margin-bottom:.5rem;font-size:1.5rem;line-height:inherit;color:inherit;white-space:normal}progress{vertical-align:baseline}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{outline-offset:-2px;-webkit-appearance:none}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}output{display:inline-block}summary{display:list-item;cursor:pointer}template{display:none}[hidden]{display:none!important}
/*# sourceMappingURL=bootstrap-reboot.min.css.map */
</style>
</head>
<body style="text-align: center;">
<div id="kertas">
	<div id="inner">
		<table id="tiket" class="table table-bordered">
			<thead>
				<tr>
					<td colspan="3" style="border: none;">
						<h4 class="title" style="line-height: 0;margin: 15px 9px 9px 9px"><?=$nama_instansi?></h4>	
						<h4 class="title"><?=$nama_kabupaten?></h4>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="border-left:none;border-right: none;padding: 2px;">
						<?=$hari?>
					</td>
					<td style="border-left: none;border-right: none;padding: 2px;">
						<?=$tanggal?>
					</td>
					<td style="border-left: none;padding: 2px;border-right: none;">
						<?=$waktu?>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="border: none">
						<h4 class="title" style="font-size: 1em">NO. ANTRIAN <?=strtoupper($jenis)?></h4>	
						<h1 style="font-size: 4em;margin-bottom: 12px;line-height: 1"><?=$nomor_antrian?></h1>
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
		font-size:200%;
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
		padding: 1px;
		width: 585px;
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
		font-size: 110%;
	}
</style>
</html>