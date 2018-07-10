<?php
require 'sina/start.php';
$limit = 3;
$arr = array('cat', 'dog', 'bird');

foreach($arr as $k => $v) {
    $pid = pcntl_fork();
    if(checkPid($pid)) {

    } else {
        MSG($v);
        exit(0);
    }
}


function checkPid($pid) {
    switch($pid) {
        case 0:
            return false;
        case -1:
            return false;
        default:
            return true;
    }
}
