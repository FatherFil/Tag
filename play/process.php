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
        $test->clearOutgoingQueue();
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

        $action = new gameAction();
        $action->assignTweetID($row['tweet_id']);

        if ($action->isExistingPlayer()) {
            $action->loadSessionFromTweetID();
            $action->loadCurrentCell();
            $action->loadRecognisedCommands();
            $action->loadAction();

            if ($action->isActionRecognisedCommand()) {
                $log->writeToLog("Action is a recognised command", $row['tweet_id']);
                $action->processAction();
                $action->constructReturnMessage();
                $output = $action->getOutgoingTweet();
            } else {
                $log->writeToLog("Action is NOT a recognised command", $row['tweet_id']);
                // else if not
                //   get the error text into a string
                //   -> we need to make sure we pick a suitable message back
                //   -> or pick from a vast array of messages back
                $output = "Unable to recognise command.";
            }
        } else {
            $log->writeToLog("New player found", $row['tweet_id']);
            $action->buildNewPlayer();
            $action->loadSessionFromTweetID();

            $action->buildWelcomeTweet();
            $action->queueOutgoingTweet();
            $log->writeToLog("Built outgoing tweet - ". $action->getOutgoingTweet());
        }

        $action->constructReturnMessage();
        $log->writeToLog("Built outgoing tweet - ". $action->getOutgoingTweet());
        $action->queueOutgoingTweet();

        $log->writeToLog("End of row", $row['tweet_id']);

    }

    $log->writeToLog("End cronjob");

?>

