<?php
$socketPair = [];
socket_create_pair(AF_UNIX, SOCK_STREAM, 0, $socketPair);

$childNum = 4;

for($i = 0; $i < $childNum; $i++) {
    $pid = pcntl_fork();
    if ($pid > 0) {
        // father
        continue;
    } elseif ($pid == 0) {
        // child process
        socket_close($socketPair[0]);
        sleep(rand(1, 5));
        socket_write($socketPair[1], getmypid(), strlen(getmypid()));
        exit(0);
    } else {
        // error
    }
}

socket_close($socketPair[1]);
$read = $expect = [$socketPair[0]];
$write = null;
$receiveData = true;
$tv_sec = null;
while($receiveData && socket_select($read, $write, $expect, $tv_sec)) {
    $receiveData = socket_read($socketPair[0], 8192);
    var_dump($receiveData);
}
