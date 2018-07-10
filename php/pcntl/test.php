<?php
require 'sina/start.php';
$limit = 3;
$db = &DBO('trade_db');
$sql = 'select * from us_quotes_index limit 1';

for($i = 0; $i < $limit; $i++) {
    $pid = pcntl_fork();
    if(checkPid($pid)) {
        MSG('[FATHER] ' . 'PID - ' . $pid);
    } else {
        $gid = posix_getgid();
       // MSG("[GID] {$gid}");
        $pid = posix_getpid();
       // MSG("[PID] {$pid}");
        $rand = rand(1, 10);
        usleep($rand * 1000000);
        $data = $db->queryAll($sql);
        MSG($rand);
        MSG(json_encode($data));
        //sleep(60);
        exit;
    }
    MSG("[FATHER] CHILD PROCESS %{$i}%");
}
sleep(12);
MSG("[FATHER] FATHER END");


function checkPid($pid) {
    switch($pid) {
        case 0:
            MSG('[CHILD] CHILD PROCESS');
            return false;
        case -1:
            MSG('[ERROR] NO FORK');
            return false;
        default:
            MSG('[FATHER] FATHER PROCESS');
            return true;
    }
}
