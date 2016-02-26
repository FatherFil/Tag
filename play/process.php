<?php

    $_procStart = microtime();

    require_once ("config.php");
    require_once ("classes/game_gameAction.php");
    require_once ("handlers/queue_handler.php");
    require_once ("handlers/log_handler.php");
    require_once ("engines/database/db_engine_game.php");
    require_once ("engines/database/db_engine_logs.php");

    // get the queue of incoming commands
    // loop around the queue

    /* ********************************************* */
    /* Test setup here - comment out when not needed */
    require_once ("handlers/test_handler.php");
    require_once ("engines/database/db_engine_tests.php");

    $test = new testHandler();
    $test->clearLog();
    $test->clearIncomingQueueAndTweets();
    $test->clearPlayers();
    $test->createIncomingTweet("bob","Hello");
    $test->createIncomingTweet("john","Hello");
    $test->createIncomingTweet("fred","Hello");
    /* End test strings */
    /* **************** */

    $log = new logHandler($_procStart);
    $log->writeToLog("Start cronjob");

    $queueHandler = new queueHandler();
    $waitingActions = $queueHandler->getIncomingQueue();

    $log->writeToLog("Ready to parse rows. ". count($waitingActions) ." rows to process.");

    foreach($waitingActions as $row) {
        $log->writeToLog("Start row", $row['tweet_id']);

        // load/populate the player session
        // load recognised commands from current cell
        $action = new gameAction();
        $action->assignTweetID($row['tweet_id']);

        // have we seen this player before? are they new?
        if ($action->isExistingPlayer()) {
            $action->loadSessionFromTweetID();
            $action->loadRecognisedCommands();
            $action->loadAction();

            //   is the move the player has asked for a recognised command
            if ($action->isActionRecognisedCommand()) {
                $log->writeToLog("Action is a recognised command", $row['tweet_id']);
                // if so
                //   parse the command and process
                //   -> check standard actions first, then extra actions
                $action->processAction();
                // get the result into a string
                $action->constructReturnMessage();
                $output = $action->getReturnMessage();
            } else {
                $log->writeToLog("Action is NOT a recognised command", $row['tweet_id']);
                // else if not
                //   get the error text into a string
                //   -> we need to make sure we pick a suitable message back
                //   -> or pick from a vast array of messages back
                $output = "Unable to recognise command.";
            }
        } else {
            // New player!
            $log->writeToLog("New player found", $row['tweet_id']);
            $action->buildNewPlayer();
        }

        // end if
        // push string to outgoing twitter queue
        $tweet = $action->buildOutgoingTweet();
        $queueHandler->addToOutgoingQueue($tweet);

        //   write output to log
        $log->writeToLog("End of row", $row['tweet_id']);

    }

    // end loop
    // write timings of processing to log

    $log->writeToLog("End cronjob");

?>

