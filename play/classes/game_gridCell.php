<?php

class gameCell {

    private $_cellID;
    private $_pathNorth;
    private $_pathSouth;
    private $_pathEast;
    private $_pathWest;
    private $_pathBlocked;
    private $_itemNeed;
    private $_itemGain;

    public function populateCellDetails($currentCell) {
        $this->_cellID = $currentCell;
        $dbEngine = new dbEngineGame();
        $gridCellDetails = $dbEngine->getGridCellDetails($this->_cellID);

        $this->_pathNorth = $gridCellDetails->north;
        $this->_pathSouth = $gridCellDetails->south;
        $this->_pathEast = $gridCellDetails->east;
        $this->_pathWest = $gridCellDetails->west;
        $this->_pathBlocked = $gridCellDetails->blocked;
        $this->_itemNeed = $gridCellDetails->need;
        $this->_itemGain = $gridCellDetails->gain;
    }

}