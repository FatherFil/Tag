<?php

require_once "meekrodb.2.1.class.php";

class dbEngine
{

    // Properties

    // Constructor

    // Methods
    public function getHighestTweetID() {
        $sqlQuery = "SELECT max(id) ".
                    "FROM   tweets ".
                    "WHERE  processed = 0";
        return DB::queryFirstField($sqlQuery);
    }

    //$id,$text,$created,$author_id,$author_name,$profileImageUrl,$timezone
    /**
     * @param $tweet Tweet
     */
    public function insertIntoTweets($tweet) {
        $sqlQuery = "INSERT INTO tweets ".
                    "(tweet_id, text, created_at, author_id, author_name, profile_image_url, timezone) VALUES ".
                    "(%s0, %s1, %s2, %s3, %s4, %s5, %s6)";
        DB::query($sqlQuery, $tweet->getID(),
                             $tweet->getText(),
                             $tweet->getCreatedAt(),
                             $tweet->getAuthorID(),
                             $tweet->getAuthorName(),
                             $tweet->getProfileImageURL(),
                             $tweet->getTimezone());
    }

    public function insertIntoIncomingQueue($tweetID, $author) {
        $sqlQuery = "INSERT INTO queue_incoming ".
                    "(tweet_id, author_name) VALUES ".
                    "(%s0, %s1)";
        DB::query($sqlQuery, $tweetID, $author);
    }

    public function saveTweetJson($tweetID, $json) {
        $sqlQuery = "INSERT INTO tweets_json ".
                    "(tweet_id, json) VALUES ".
                    "(%s0, %s1)";
        DB::query($sqlQuery, $tweetID, $json);
    }

}
