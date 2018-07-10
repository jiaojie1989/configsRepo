<?php
define("SOCK_FILE", "/tmp/test.sock");
unlink(SOCK_FILE);

$sock = socket_create(AF_UNIX, SOCK_STREAM, 0);
socket_bind($sock, SOCK_FILE);

socket_listen($sock);

//socket_select($temp = array($sock), $temp = null, $temp = null, 20);
//socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, ["sec"=>1, "usec" => 0]);
$linger = array('l_linger' => 1, 'l_onoff' => 1);
//socket_set_option($sock, SOL_SOCKET, SO_LINGER, $linger);
socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);

while(1) {
$client = socket_accept($sock);
//socket_set_nonblock($client);
socket_set_block($client);
//while(true) {
    echo "[".microtime()."] [" . date("Y-m-d H:i:s") . "]";
    //socket_set_nonblock($client);
    $buffer = socket_read($client, 4096);
    var_dump(strlen($buffer));
//}
socket_close($client);
}

//var_dump(socket_connect($sock, SOCK_FILE));

socket_close($sock);
unlink(SOCK_FILE);
