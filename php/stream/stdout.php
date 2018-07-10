<?php
$fp = fopen("php://stdout", "w+");
for($i = 0; $i < 100; $i++) {
    fwrite($fp, $i . "\n");
}
fclose($fp);
