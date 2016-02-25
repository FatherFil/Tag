<?php

class gameCommands  {

    private $_commands;

    public function loadRecognisedCommands() {
        $this->fillStandardCommandsWithAllCompassPoints();
    }

    public function isActionInCommands($action) {
        return in_array($action, $this->_commands);
    }

    private function fillStandardCommandsWithAllCompassPoints() {
        $commands = array("go","head","walk","run","take the");
        $compass = array("north" => "goNorth", "south" => "goSouth", "east" => "goEast", "west" => "goWest");
        foreach ($commands as $command) {
            foreach ($compass as $point => $function) {
                $this->addRecognisedCommand($command.' '.$point, $function);
            }
        }
    }

    private function addRecognisedCommand($command,$functionCall) {
        $this->_commands[$command] = $functionCall;
    }

    private function pickupItem($item_name) {
        gameSession::addToInventory($item_name);
    }

}