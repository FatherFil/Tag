<?php

class queueHandler {

    public function getIncomingQueue() {
        $dbEngine = new dbEngineGame();
        $queue = $dbEngine->getIncomingQueue();
        return $queue;
    }

    public function addToOutgoingQueue($tweet) {
        $dbEngine = new dbEngineGame();
        $dbEngine->addToOutgoingQueue($tweet);
    }

}