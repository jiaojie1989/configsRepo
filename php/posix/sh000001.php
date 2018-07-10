#! /opt/php56/bin/php
<?php
set_time_limit(0);
pcntl_fork() && exit(0);
posix_setsid();
pcntl_fork() && exit(0);

fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
chdir("/");
umask(0); 
$redis = new Redis();

$formatOutput = function($data, $rate, $state) {
    $output = "Rate: <b>" . bcmul($rate, 100, 2) . "% [{$state}]</b>\n";;
    $output .= "Now: <i>{$data["now"]}</i>\n";
    $output .= "Open: {$data["open"]}\n";
//    $output .= "Close: {$data["close"]}\n";
//    $output .= "High: {$data["high"]}\n";
//    $output .= "Low: {$data["low"]}\n";
    $output = substr($output, 0, -1);
    shell_exec("export DISPLAY=:0.0 && notify-send -i /usr/share/app-install/icons/bustle.png '{$data["name"]} [" . date("Y-m-d H:i:s") . "]' '{$output}'");
};

$filterData = function($data) {
    $data = iconv("gbk", "utf-8", $data);
    $data = str_replace("var hq_str_sh000001=\"", "", $data);
    $data = str_replace("\";", "", $data);
    list($name, $open, $close, $now, $high, $low) = explode(",", $data);
    return [
        "name" => $name,
        "now" => $now,
        "open" => $open,
        "close" => $close,
        "high" => $high,
        "low" => $low,
    ];
};

while(1) {
    if ((date("H") > 15 || date("H") < 9) || (date("H") == 15 && date("i") > 0) || (date("H") == 9 && date("i") < 15) || in_array(date("N"), [6, 7])) {
        sleep(900);
        continue;
   };

    try {
        $redis->connect("localhost", 6379);
        $time = date("H:i:s");

        do {
            $data = file_get_contents("http://i.hq.sinajs.cn/list=sh000001", false, stream_context_create(["http" => ["timeout" => 3]]));
        } while(empty($data));

        $data = $filterData($data);

        $rate = bcdiv(bcsub($data["now"], $data["close"], 10), $data["close"], 4);

        $lastNow = $redis->getSet("sh000001LastPoints", $data["now"]);
        if ($lastNow == $data["now"]) {
            $state = " -- ";
        } elseif($lastNow > $data["now"]) {
            $state = "DOWN";
        } else {
            $state = " UP ";
        };

        $formatOutput($data, $rate, $state);
        if ($rate > 0) {
            sleep(30);
        } elseif($rate > -0.05) {
            sleep(10);
        } else {
            sleep(5);
        }
    } catch(RedisException $e) {
        sleep(5);
    }
}


