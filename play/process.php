<?php

    $_procStart = microtime();
    require_once ("handlers/queue_handler.php");
    require_once ("handlers/log_handler.php");

// get the queue of incoming commands
// loop around the queue

    $log = new logHandler();
    $log->writeToLog("Start cronjob");

    $queueHandler = new queueHandler();
    $waitingActions = $queueHandler->getIncomingQueue();

    foreach($waitingActions as $row) {
        $log->writeToLog("Start row for ".$row['tweet_id']);

        //   load/populate the player session
        //   load recognised commands from current cell
        $action = new gameAction();
        $action->loadSessionFromTweetID($row['tweet_id']);
        $action->loadRecognisedCommands();
        $action->loadAction();

        //   is the move the player has asked for a recognised command
        if ($action->isActionRecognisedCommand()) {
            $log->writeToLog("Action is a recognised command");
            //   if so
            //      parse the command and process
            //      -> check standard actions first, then extra actions
            $action->processAction();
            //      get the result into a string
            $action->constructReturnMessage();
            $output = $action->getReturnMessage();
        } else {
            $log->writeToLog("Action is NOT a recognised command");
            //   else if not
            //      get the error text into a string
            //      -> we need to make sure we pick a suitable message back
            //      -> or pick from a vast array of messages back
            $output = "Unable to recognise command.";
        }

        //   end if
        //   push string to outgoing twitter queue
        $queueHandler->addToOutgoingQueue();

        $_procEnd = microtime();
        $_procComplete = $_procEnd - $_procStart;

        //   write output to log
        $log->writeToLog("End row - Time to complete ".$_procComplete);

    }

// end loop
// write timings of processing to log

    $_procEnd = microtime();
    $_procComplete = $_procEnd - $_procStart;

    $log->writeToLog("End cronjob - Time to complete ".$_procComplete);






    /*

    require_once "game_engine/game_constants.php";
    require_once "game_engine/game_engine.php";

    // Collect the posted array
    $_arrPOST = $_POST;

    // Check to see if we have POST vars, if not set up some test vars.
    if (!isset($_arrPOST["Body"])) {
        $_arrPOST["SmsSid"] = "test";
        $_arrPOST["From"] = "localtest";
        $_arrPOST["Body"] = "south";
    }

    // Check to see if the user has played before
    $_returnText = array();
    $dbEngine = new dbEngine();
    $hasCallerPlayedBefore = $dbEngine->hasCallerPlayedBefore($_arrPOST["From"]);
    if ($hasCallerPlayedBefore === false) {
        $_returnText[] = $dbEngine->getTextForAudioID("game_start");
        $_returnText[] = $dbEngine->getTextForAudioID("call_costs");
        $_arrPOST["Body"] = "";
    } else {
        $_arrPOST["Body"] = strtolower($_arrPOST["Body"]);
        $hasCallerCompletedGame = $dbEngine->hasCallerCompletedGame($_arrPOST["From"]);
        if ($hasCallerCompletedGame === true) {
            if ($_arrPOST["Body"] == TEXT_COMMAND_RESET) {
                $dbEngine->resetPlayerEntry($_arrPOST["From"]);
                $_arrPOST["Body"] = null;
            } else {
                $_returnText[] = $dbEngine->getTextForAudioID("reset_game");
            }
        }
    }

    // Setup a new game engine session
    $_playingByText = true;
    $_gameEngine = new gameEngine($_arrPOST, $_playingByText);

    // What did the user want to do?
    if (isset($_arrPOST["Body"]) && !empty($_arrPOST["Body"])) {
        if (in_array($_arrPOST["Body"], array(TEXT_COMMAND_NORTH, TEXT_COMMAND_SOUTH, TEXT_COMMAND_EAST, TEXT_COMMAND_WEST))) {
            $checkAction = $_gameEngine->processAction();
            if (!$checkAction) {
                $_returnText[] = $_gameEngine->getResponseForInvalidMove();
            }
        } else {
            $_returnText[] = $_gameEngine->getResponseForInvalidKeyPress();
        }
    } elseif ($hasCallerPlayedBefore === true) {
        $_returnText[] = $dbEngine->getTextForAudioID("game_start");
        $_returnText[] = $dbEngine->getTextForAudioID("call_costs");
    }

    // Get the audio files we need to play
    $_sendText = $_gameEngine->getResponse();
    foreach ($_sendText as $text) {
        $_returnText[] = $text;
    }

    // Create the outgoing Twilio XML and echo it to the session
    $_returnXML = $_gameEngine->createReturnXMLForSMS($_returnText);

    // -----------------------------------------------------
    $_procEnd = microtime();
    $_procComplete = $_procEnd - $_procStart;

    // Log this information in the db as a game move
    $_gameEngine->logEvent($_procComplete);

    // Last job is to echo out the return XML to Twilio
    echo "\n".$_returnXML;

    */

?>

