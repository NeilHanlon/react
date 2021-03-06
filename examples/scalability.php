<?php

// a simple, single-process, horizontal scalable http server listening on 10 ports

$loop = React\EventLoop\Factory::create();

for($i=0;$i<10;++$i){
    $s=stream_socket_server('tcp://127.0.0.1:'.(8000+$i));
    $loop->addReadStream($s, function ($s) use ($i) {
        $c=stream_socket_accept($s);
        $len=strlen($i)+4;
        fwrite($c,"HTTP/1.1 200 OK\r\nContent-Length: $len\r\n\r\nHi:$i\n");
        echo "Served on server number $i\n";
    });
}

$loop->run();
