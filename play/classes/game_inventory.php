<?php

class gameInventory
{
    private $_inventoryItems;

    public function loadInventory($playerID) {
        $dbEngine = new dbEngineGame();
        $inventory = $dbEngine->loadInventoryByPlayerID($playerID);
        foreach($inventory as $item) {
            $this->_inventoryItems[] = $item;
        }
    }

    public function addToInventory($item) {
        if (isset($this->_inventoryItems[$item])) {
            $this->_inventoryItems[$item] = 1;
        } else {
            $this->_inventoryItems[$item] ++;
        }
    }

    public function removeItemFromInventory($item) {
        if ($this->_inventoryItems[$item] == 1) {
            unset($this->_inventoryItems[$item]);
        } else {
            $this->_inventoryItems[$item] --;
        }
    }

    public function isItemInInventory($item) {
        if (in_array($item, $this->_inventoryItems)) {
            if ($this->_inventoryItems[$item] > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}