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
        $session = $dbEngine->createNewPlayer($this->_tweetID);
    }

    public function buildOutgoingTweet() {
        $tweet = "";
        if ($this->_isExistingPlayer) {

        } else {
            $tweet = WELCOME_TWEET;
        }
        return $this->_playerScreenName.' '.$tweet;
    }

}