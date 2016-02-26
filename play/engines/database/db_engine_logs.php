<?php

require_once ('db_engine.php');

class dbEngineLog extends dbEngine {

    public function insertLog($text, $tweet_id, $time) {
        $sqlQuery = "INSERT INTO log ".
                    "(proc, tweet_id, text, time_in_proc) VALUES ".
                    "('play', %s0, %s1, %s2)";
        DB::query($sqlQuery, $tweet_id, $text, $time);
    }

}
