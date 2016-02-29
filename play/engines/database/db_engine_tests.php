<?php

class dbEngineTests extends dbEngine {

    public function insertIncomingTweet($tweet_id, $text, $author_screen_name) {
        $sqlQuery = "INSERT INTO tweets_incoming ".
                    "(tweet_id, text, author_screen_name) VALUES ".
                    "(%s0, %s1, %s2)";
        DB::query($sqlQuery, $tweet_id, $text, $author_screen_name);
    }

    public function insertIntoIncomingQueue($tweet_id) {
        $sqlQuery = "INSERT INTO queue_incoming ".
                    "(tweet_id) VALUES ".
                    "(%s0)";
        DB::query($sqlQuery, $tweet_id);
    }

    public function clearIncomingQueue() {
        $sqlQuery = "TRUNCATE TABLE queue_incoming";
        DB::query($sqlQuery);
        $sqlQuery = "TRUNCATE TABLE tweets_incoming";
        DB::query($sqlQuery);
    }

    public function clearLogs() {
        $sqlQuery = "TRUNCATE TABLE log";
        DB::query($sqlQuery);
    }

    public function clearPlayers() {
        $sqlQuery = "TRUNCATE TABLE players";
        DB::query($sqlQuery);
    }

    public function clearOutgoingQueue() {
        $sqlQuery = "TRUNCATE TABLE queue_outgoing";
        DB::query($sqlQuery);

    }

}
