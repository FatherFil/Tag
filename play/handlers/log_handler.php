<?php

/**
 * Created by PhpStorm.
 * User: phil.collins
 * Date: 22/02/2016
 * Time: 17:32
 */
class logHandler {

    private $_procStart;

    public function __construct($time) {
        $this->_procStart = $time;
    }

    public function writeToLog($log, $tweet_id = 0) {
        $dbEngine = new dbEngineLog();
        $complete = $this->timeToCall();
        $dbEngine->insertLog($log, $tweet_id, $complete);
    }

    private function timeToCall() {
        $_procEnd = microtime();
        return $_procEnd - $this->_procStart;
    }

}