<?php
declare(ticks = 1);

$getTime = function() {
    echo "[" . date("Y-m-d H:i:s") . "] ";
};

$sigChild = function($no) use($getTime) {
    $pid = getmypid();
    $getTime();
    echo "Run in $pid, Reached `SIG CHILD` {$no}\n";
};

$sigTerminate = function($no) use($getTime) {
    $pid = getmypid();
    $getTime();
    echo "Run in $pid, Reached `SIG Terminate` {$no}\n";
};

if (pcntl_fork() <= 0) {
    sleep(1);
    $getTime();
    echo getmypid() . " CHILD WILL END\n";
    exit;
} else {

    pcntl_signal(SIGCHLD, $sigChild);
    pcntl_signal(SIGTERM, $sigTerminate);

    $status = null;
    sleep(3);
    $getTime();
    echo getmypid() . " PARENT WILL END \n";
    exit;
}

