<?php
$fp = fopen("php://stderr", "w+");
for($i = 0; $i < 100; $i++) {
    fwrite($fp, $i . "\n");
}
fclose($fp);
