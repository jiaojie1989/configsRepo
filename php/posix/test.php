<?php
while(1) {
    $time = date("His");
    if (in_array(date("N"), [1, 2, 3, 4, 5])) {
        shell_exec("export DISPLAY=:0.0 && notify-send -a 'Workday NOTIFY' '" . date("Y-m-d H:i:s") . "'");
        sleep(60);
    } else {
        shell_exec("export DISPLAY=:0.0 && notify-send -a 'Workday NOTIFY' '" . date("Y-m-d H:i:s") . "'");
        sleep(60);
    }
}
