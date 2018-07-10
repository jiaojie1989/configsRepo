<?php
declare(ticks = 1);

$redis = new Redis();
$redis->connect("localhost", 6379);
$max = 3;
$sigStatus = null;

echo "Father: " . getmypid() . "\n";

$tickFunc = function() use ($redis) {
    $redis->getSet("tmptimestamp", microtime()) . "\n";
};

$childPids = [];

register_tick_function($tickFunc);

for($i = 0; $i < $max; $i++) {
    if ($pid = pcntl_fork()) {
        
    } else {
        echo "Child: " . getmypid() . " Start\n";
        sleep(4);
        $a = 1;
        echo "Child: " . getmypid() . " Exit\n";
        exit;
    }
}

while(true) {
    $ret = pcntl_wait($sigStatus);
    if (!$ret) {
        var_dump($ret);
        echo "Father Exit.\n";
        exit;
    } else {
        var_dump($ret);
    }
}
