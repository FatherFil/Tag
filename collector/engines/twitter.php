<?php

/**
 * Created by PhpStorm.
 * User: phil.collins
 * Date: 18/01/2016
 * Time: 14:15
 */
require_once('libraries/TwitterAPIExchange.php');
require_once('classes/library.php');
require_once('classes/tweet.php');

class TwitterEngine
{

    private $_apiURL = "https://api.twitter.com/1.1/";
    private $_requestMethod = "GET";
    private $_oauth_access_token = "5687642-FcGJOGxnfUuBlxV8RzGuPbRwq5nS4rCCc5baoQMTtt";
    private $_oauth_access_token_secret = "qijeqsYkU5lBvky7de9eXt0ec0J6D6XXZHFuzDfiT4ZwH";
    private $_consumer_key = "oVCx1N5q90KVYTsgqcUkBvRmf";
    private $_consumer_secret = "32gR7RjEp9Lr8bR8acopc54Ng9YKzf8gXoJDzktsIbLsYBioUC";

    public function getTweetsToUser($sinceID) {
        $twitter = new TwitterAPIExchange($this->constructSettings());

        $apiURL = $this->_apiURL."statuses/mentions_timeline.json";
        $getRequest = '?include_entities=false&since_id='. $sinceID ;
        $response = $twitter->setGetfield($getRequest)
            ->buildOauth($apiURL, $this->_requestMethod)
            ->performRequest();

        unset($twitter);

        $library = new Library();
        $responses = json_decode($response);
        //die(print_r($responses));

        foreach ($responses as $block) {
            $tweet = new Tweet($block->id_str,
                               $block->text,
                               $block->created_at,
                               $block->user->id,
                               $block->user->screen_name,
                               $block->user->profile_image_url,
                               $block->user->time_zone,
                               json_encode($block));
            $library->addTweet($tweet);
        }

        return $library;
    }

    private function constructSettings() {
        $settings = array (
            'oauth_access_token' => $this->_oauth_access_token,
            'oauth_access_token_secret' => $this->_oauth_access_token_secret,
            'consumer_key' => $this->_consumer_key,
            'consumer_secret' => $this->_consumer_secret);
        return $settings;
    }
}