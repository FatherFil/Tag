<?php

require_once("game_commands.php");
require_once("game_session.php");
require_once("game_gridcell.php");

class gameAction extends gameSession {

    private $_commands;
    private $_currentAction;
    private $_gridCell;

    public function __construct() {
        $this->_commands = new gameCommands();
        $this->_gridCell = new gameCell();
        parent::__construct();
    }

    public function loadCurrentCell() {
        $this->_gridCell->populateCellDetails(parent::getCurrentGridCell());
    }

    public function loadAction() {
        $dbEngine = new dbEngineGame();
        $this->_currentAction = $dbEngine->loadActionFromTweetID(parent::getTweetID());
    }

    public function loadRecognisedCommands() {
        $this->_commands->loadRecognisedCommands();
    }

    public function constructReturnMessage() {

    }

    public function processAction() {

    }

    public function isActionRecognisedCommand() {

    }

    public function isAllowedCommand() {
        return $this->_commands->isActionInCommands($this->_currentAction);
    }

}