<?php
$settled = array(
            "SINA" => 1,
            "BIDU" => 2,
            "BABA" => 4,
        );

$unsettled = array(
            "SINA" => 11,
            "BIDU" => 52,
        );

$frozen = array(
            "SINA" => 15,
            "BIDU" => 265,
            "FB" => 12,
        );

$newArr = array();

$combineFunc = function(&$newArr, $oldArr) {
    foreach($oldArr as $key => $val) {
        if(array_key_exists($key, $newArr)) {
            $newArr[$key] += $val;
        } else {
            $newArr[$key] = $val;
        }
    }
};

$combineFunc($settled, $unsettled);
$combineFunc($settled, $frozen);
ksort($settled);
$settled = array_slice($settled, 1, 3);
var_dump($settled);
