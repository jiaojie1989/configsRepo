<?php
$connArr = [
    "server" => "mongodb://",
    "options" => [
        "username" => "f**k",
        "password" => "f**k",
        "connect" => true,
        "db" => "i_do_not_konw",
        "replicaSet" => "a_repi_set",
    ],
];

$mongo = new MongoClient($connArr["server"], $connArr["options"]);
$collection = $mongo->selectCollection("f", "php_errors");
$data = $collection->find([], [])->sort(["datetime" => -1])->limit(10);
//var_dump(iterator_to_array($data));
var_dump($data);
foreach($data as $v) {
    var_dump($v);
}


//var_dump($mongo->getConnections());
//var_dump($mongo->getHosts());
