<?php
pcntl_fork() && exit(0);
posix_setsid();
pcntl_fork() && exit(0);

fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
chdir("/");
umask(0);

$formatOutput = function(&$fortune, $crit = false) {
    $fortune[0] = "<b>{$fortune[0]}</b> (1 min)";
    $fortune[1] = "<i>{$fortune[1]}</i> (5 min)";
    $fortune[2] = "<i>{$fortune[2]}</i> (15 min)";
    if (!$crit) {
        $fortune = "System Load Info\n" . implode(", ", $fortune);
    } else {
        $fortune = "<b>System Load Warning</b>\n" . implode(", ", $fortune);
    }
};

while(1) {
    $time = date("His");
    //$fortune = shell_exec("/usr/games/fortune -e fortunes");
    //$fortune = shell_exec("/usr/bin/w");
    $fortune = sys_getloadavg();
    if($fortune[0] > 4) {
        $formatOutput($fortune, true);
        shell_exec("export DISPLAY=:0.0 && notify-send -i /usr/share/app-install/icons/_usr_share_openstreetmap-client_media_maps.svg 'Overload Warning  @" . date("Y-m-d H:i:s") . "' '{$fortune}'");
        sleep(5);
        continue;
    }
    $formatOutput($fortune);
   if (in_array(date("N"), [1, 2, 3, 4, 5])) {
        shell_exec("export DISPLAY=:0.0 && notify-send -i /usr/share/app-install/icons/_usr_share_openstreetmap-client_media_maps.svg 'Working Notice @" . date("Y-m-d H:i:s") . "' '{$fortune}'");
        sleep(30);
    } else {
        shell_exec("export DISPLAY=:0.0 && notify-send -i /usr/share/app-install/icons/_usr_share_openstreetmap-client_media_maps.svg 'Weekend Notice @" . date("Y-m-d H:i:s") . "' '{$fortune}'");
        sleep(30);
    }
}


