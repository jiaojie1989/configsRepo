<?php
class test {
    protected $observer = array();
    public function addObserver($callable, $params) {
        $this->observer[] = array(
                    "callable" => $callable,
                    "params" => $params,
                );
    }
    public function commit() {
        if (!empty($this->observer)) {
            foreach($this->observer as $key => $observer) {
                call_user_func_array($observer["callable"], $observer["params"]);
                unset($this->observer[$key]);
            }
        } else {
            echo "No observer found ! \n";
        }
    }
}


class observer {
    protected $timestamp;
    protected $rand;
    public function __construct() {
        $this->timestamp = microtime();
        $this->rand = rand();
    }
    public function printTime() {
        echo "[$this->timestamp] The rand is {$this->rand}!\n";
    }
}

$test = new test();
// register observers
$test->addObserver(array(new observer, "printTime"), array());
$test->addObserver(array(new observer, "printTime"), array());
// Show different observer results.
$test->commit();
// No observer found!
$test->commit();
