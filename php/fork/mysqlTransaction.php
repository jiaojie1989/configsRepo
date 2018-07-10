<?php
$pid = pcntl_fork();
if ($pid) {
    $father = 1;
    $mine = getmypid();
    echo "Father {$mine} | Child {$pid}\n\n";
    runMe();
    $status = 1;
    pcntl_waitpid($pid, $status);
} else {
    $father = 0;
    runMe();
}


function getConn() {
    return mysql_connect("127.0.0.1", "root", "jiaojie");
}

function runMe() {
    global $father;
    $pid = getmypid();
    $conn = getConn();
    mysql_select_db("stp_test");
    $ret = mysql_query("set autocommit=0");
    logger($pid, $ret, "set autocommit 0");
    $ret = mysql_query("start transaction");
    logger($pid, $ret, "start transaction");

//    $father && sleep(3);
    sleep(1);

    $father && $sql = "update money_account_currents set money=100 where sid=1 and money=0";
    !$father && $sql = "update money_account_currents set money=90 where sid=1 and money=0";

    $ret = mysql_query($sql);
    $ret = mysql_affected_rows();
    logger($pid, $ret, "{$sql}");

    $father && $sql = "update money_account_currents_bak set money=-100 where sid=2 and money=0";
    !$father && $sql = "update money_account_currents_bak set money=-90 where sid=2 and money=0";

    $ret = mysql_query($sql);
    $ret = mysql_affected_rows();
    logger($pid, $ret, "{$sql}");

//    sleep(5);
    if ($ret > 0) {
        $ret = mysql_query("commit");
        logger($pid, $ret, "commit");
    } else {
        $ret = mysql_query("rollback");
        logger($pid, $ret, "rollback");
    }
}

function logger($pid, $status, $msg) {
    $log = "[" . date("Y-m-d H:i:s") . "] ";
    $log .= "[{$pid}] ";
    if ($status === true) {
        $log .= "{TRUE}";
    } elseif ($status === false) {
        $log .= "{FALSE}";
    } else {
        $log .= "{{$status}}";
    }
    $log .= " - $msg\n";
    echo $log;
}
