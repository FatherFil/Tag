<?php

class commandType
{

    private $_isTravel = false;
    private $_isTake = false;
    private $_isUse = false;

    public function isTravel() {
        return $this->_isTravel;
    }

    public function isTake() {
        return $this->_isTake;
    }

    public function isUse() {
        return $this->_isUse;
    }

    public function setTravel() {
        $this->_isTravel = true;
    }

    public function setTake() {
        $this->_isTake = true;
    }

    public function setUse() {
        $this->_isUse = true;
    }

}