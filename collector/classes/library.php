<?php

/**
 * Created by PhpStorm.
 * User: phil.collins
 * Date: 18/01/2016
 * Time: 12:45
 */
class Library
{

    private $_tweets;

    public function addTweet($tweet) {
        $this->_tweets[] = $tweet;
    }

    public function numberOfTweetsInLibrary() {
        return count($this->_tweets);
    }

    public function outputTweets() {
        $output = "";
        /**
         * @var $tweet Tweet
         */
        foreach ($this->_tweets as $tweet) {
            $output .= $tweet->outputTweet() ."\n";
        }
        return $output;
    }

}