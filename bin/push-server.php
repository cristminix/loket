<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$loop 	= React\EventLoop\Factory::create();
$pusher = new Loket\Pusher;
$pusher2 = new Loket\Pusher;

// Liste untuk web server untuk membuat ZeroMQ push setelah ajax request
$context = new React\ZMQ\context($loop);
$pull = $context->getSocket(ZMQ::SOCKET_PULL);
// Bind ke ip 127.0.0.1 maksudnya hanya klien yang bisa terhubung dengan sendirinya
$pull->bind('tcp://127.0.0.1:5555'); 
$pull->on('message',[$pusher, 'onRealtimeUpdate']);
// $pull->on('message',[$pusher2, 'onUpdateDal']);

// setup WebSocket server buat klien yang ingin update realtime
// Bind ke ip 0.0.0.0 aksudnya remote juga bisa konek
$webSock = new React\Socket\Server('0.0.0.0:8080',$loop); 
$webServer = new Ratchet\Server\IoServer(
	new Ratchet\Http\HttpServer(
		new Ratchet\WebSocket\WsServer(
			new Ratchet\Wamp\WampServer(
				$pusher
			)
		)
	),
	$webSock
);

$loop->run();