<?php

class testHandler {

    public function clearIncomingQueueAndTweets() {
        $dbEngine = new dbEngineTests();
        $dbEngine->clearIncomingQueue();
    }

    public function createIncomingTweet($screen_name, $text) {
        $dbEngine = new dbEngineTests();
        $tweet_id = rand(1000,9999);
        $dbEngine->insertIncomingTweet($tweet_id,$text,$screen_name);
        $dbEngine->insertIntoIncomingQueue($tweet_id);
    }

    public function clearLog() {
        $dbEngine = new dbEngineTests();
        $dbEngine->clearLogs();
    }

    public function clearPlayers() {
        $dbEngine = new dbEngineTests();
        $dbEngine->clearPlayers();
    }

}