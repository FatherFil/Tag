<?php

require_once ("engines/twitter.php");
require_once ("engines/db_engine.php");

// Need to get from the database the largest ID that we checked.
//$dbEngine = new dbEngine();
//$maxTweetID = $dbEngine->getHighestTweetID();

$maxTweetID = 100000000000000000; //Test value

$twitterEngine = new TwitterEngine();
$library = $twitterEngine->getTweetsToUser($maxTweetID);

echo $library->numberOfTweetsInLibrary();

// Save the tweets in the database if they don't already exist.
/** @var $tweet Tweet */
echo $library->outputTweets();