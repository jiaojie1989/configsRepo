<?php
$fp = fopen("php://stdin", "r+");
while(!feof($fp)) {
    var_dump(fread($fp, 1024));
}
fclose($fp);
