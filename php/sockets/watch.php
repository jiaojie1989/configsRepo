<?php
while(1) {
    $ret = shell_exec("netstat -alx | grep test");
    if ($ret) {
        echo $ret . "\n";
    }
}
