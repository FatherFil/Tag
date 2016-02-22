<?php

class gameSession {

    private $_playerID;
    private $_playerScreenName;
    private $_currentGridCell;
    private $_currentCommand;

    public function getCurrentCommand() {
        return $this->_currentCommand;
    }

}