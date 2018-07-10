<?php
//error_reporting(E_ERROR);
define("SOCK_FILE", "/tmp/test.sock");

$gen =  function() {
    $rand = rand(1, 9);
    $ret = function($rand) {
        $str = "";
        for($i = 0; $i < $rand; $i++) {
            $str .= "a";
        }
        return $str;
    };
    return $ret($rand);
};

while(1) {
$fp = fsockopen("unix://" . SOCK_FILE);
//while(true) {
for($i = 0; $i < 1; $i++) {
    //$send = rand(10000, 99999);
    $send = $gen();
    fwrite($fp, $send);
    $send = strlen($send);
    echo "Sending {$send} ...\n";
    usleep(100000);
}

fclose($fp);
}
