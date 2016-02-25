<?php

require_once("game_commands.php");

class gameAction extends gameSession {

    private $_returnMessage;
    private $_commands;
    private $_currentAction;

    public function __construct() {
        $this->_commands = new gameCommands();
    }

    public function loadAction() {

    }

    public function loadRecognisedCommands() {
        $this->_commands->loadRecognisedCommands();
    }

    public function constructReturnMessage() {

    }

    public function processAction() {

    }

    public function getReturnMessage() {
        return $this->_returnMessage;
    }

    public function isAllowedCommand() {
        return $this->_commands->isActionInCommands($this->_currentAction);
    }

}