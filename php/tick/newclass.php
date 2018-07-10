<?php

class pr {
    
    protected $parentPid;
    protected $childNum;
    protected $childPids = [];
    protected $registedThings = [];
    
    public function __construnct() {
        $this->parentPid = getmypid();
        $this->childNum = 0;
        $this->registerSignalHandler();
    }

    protected function isParent() {
        if ($this->parentPid == getmypid()) {
            return true;
        } else {
            return false;
        }
    }

    protected function isChild() {
        return !$this->isParent();
    }

    public function doThings($callable, $params) {
        array_push($this->registedThings, ["func" => $callable, "params" => $params]);
   }

    protected function childBegin($callable, $params) {
        $pid = pcntl_fork();
        if ($pid > 0) {
            $this->childPids[$pid] = 1;
            $this->childNum++;
        } elseif($pid == 0) {
            $this->restoreSignalHandler();
            call_user_func_array($callable, $params);
            echo "Child " . getmypid() . " Will Exit!\n";
            exit;
        } else {
            
        }
    }

    public function begin() {
        while($arr = array_pop($this->registedThings)) {
            pcntl_signal_dispatch();
            $this->childBegin($arr["func"], $arr["params"]);
        }
        echo "Child Dispatched Already ! \n";
        do {
            $this->registerSignalHandler();
            pcntl_signal_dispatch();
            //echo $this->childNum . "\n";
        } while($this->childNum > 0);
        echo "Father " . getmypid() . " Will Exit!\n";
        exit;
    }

    protected function killChild($pid) {
        if (in_array($pid, $this->childPids) && $this->isParent()) {
            posix_kill($pid, SIGTERM);
        }
    }

    protected function registerSignalHandler() {
        pcntl_signal(SIGCHLD, array($this, "childSigHandler"));
        pcntl_signal(SIGTERM, SIG_IGN);
    }

    protected function restoreSignalHandler() {
        pcntl_signal(SIGTERM, SIG_DFL);
        pcntl_signal(SIGCHLD, SIG_DFL);
    }

    protected function childSigHandler($signo) {
        $status = null;
//        $pid = pcntl_wait($status);
        echo "Received Exit Notice! \n";
//        unset($this->childPids[$pid]);
        $this->childNum--;
    }

}

class ts {
    public function __construnct() {}

    public function getPid() {
        $sleep = rand(1, 5);
        echo "Doing Child Things " . getmypid() . " & Sleep For {$sleep} Seconds\n";
        sleep($sleep);
        return getmypid();
    }
}

$pr = new pr();

for($i = 0; $i < 50; $i++) {
    $pr->doThings(array(new ts(), "getPid"), array());
    $pr->doThings(array(new ts(), "getPid"), array());
    $pr->doThings(array(new ts(), "getPid"), array());
    $pr->doThings(array(new ts(), "getPid"), array());
}

$pr->begin();
 
