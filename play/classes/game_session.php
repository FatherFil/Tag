<?php

/* This class is extended by the gameAction class */

class gameSession {

    private $_playerID;
    private $_playerScreenName;
    private $_currentGridCell;
    private $_inventory;

    public function loadSessionFromTweetID($tweetID) {

    }

    public function addToInventory($item) {
        $this->_inventory[] = $item;
    }

    public function removeItemFromInventory($item) {
        unset($this->_inventory[$item]);
    }

    public function isItemInInventory($item) {
        return in_array($item, $this->_inventory);
    }

}