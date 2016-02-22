<?php

class actions {

    /** @var gameSession $_gameSession  */
    private $_gameSession;
    private $_recognisedCommands;

    public function __construct() {
        $this->_recognisedCommands = array();
    }

    public function addRecognisedCommand($command,$handler) {
        $this->_recognisedCommands[$command] = $handler;
    }

    public function removeRecognisedCommand($command) {
        unset($this->_recognisedCommands[$command]);
    }

    public function runCommand($command) {
        eval($this->_recognisedCommands[$command]);
    }

    private function addStandardCommands() {
        $this->addRecognisedCommand("go ", "movePlayer");
        $this->addRecognisedCommand("head ", "movePlayer");
        $this->addRecognisedCommand("travel ", "movePlayer");
    }

    private function movePlayer() {
        $command = $this->_gameSession->getCurrentCommand();

        // This was the call from the Twilio engine to get the allowed moves - we'll need something similar
        // $allowedMoves = $dbEngine->getPathsFromGridCell($this->_callSession->getCurrentGridCell());

    }
}