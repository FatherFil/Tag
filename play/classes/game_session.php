<?php

require_once ('game_inventory.php');

/* This class is extended by the gameAction class */

class gameSession {

    private $_playerID;
    private $_tweetID;
    private $_playerScreenName;
    private $_currentGridCell;
    private $_isExistingPlayer = false;
    private $_inventory;
    private $_outgoingMessage;

    public function __construct() {
        $this->_inventory = new gameInventory();
    }

    public function assignTweetID($tweetID) {
        $this->_tweetID = $tweetID;
    }

    public function isExistingPlayer() {
        $dbEngine = new dbEngineGame();
        $this->_isExistingPlayer = $dbEngine->doesPlayerExistByTweetID($this->_tweetID);
        return $this->_isExistingPlayer;
    }

    public function loadSessionFromTweetID() {
        $dbEngine = new dbEngineGame();
        $session = $dbEngine->loadSessionFromTweetID($this->_tweetID);

        $this->_playerID = $session["player_id"];
        $this->_playerScreenName = $session["twitter_name"];
        $this->_currentGridCell = $session["current_grid_square"];
        $this->_inventory->loadInventory($this->_playerID);
    }

    public function buildNewPlayer() {
        $dbEngine = new dbEngineGame();
        $dbEngine->createNewPlayer($this->_tweetID);
        $this->loadSessionFromTweetID();
    }

    public function buildWelcomeTweet() {
        $this->_outgoingMessage = WELCOME_TWEET;
    }

    public function queueOutgoingTweet() {
        $queueHandler = new queueHandler();
        $queueHandler->addToOutgoingQueue($this->buildTweetString());
    }

    public function getOutgoingTweet() {
        return $this->buildTweetString();
    }

    public function getCurrentGridCell() {
        return $this->_currentGridCell;
    }

    public function getTweetID() {
        return $this->_tweetID;
    }

    private function buildTweetString() {
        return sprintf('@%s %s',$this->_playerScreenName, $this->_outgoingMessage);
    }

}