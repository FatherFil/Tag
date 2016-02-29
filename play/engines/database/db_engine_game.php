<?php

require_once ('db_engine.php');

class dbEngineGame extends dbEngine {

    // Properties

    // Constructor

    // Methods

    public function createNewPlayer($tweetID) {
        $sqlQuery = "INSERT INTO players ".
                    "(twitter_name, current_grid_square, total_moves_made, completed_story) ".
                    "SELECT author_screen_name, %s0, 0, 0 ".
                    "FROM   tweets_incoming ti ".
                    "WHERE  ti.tweet_id = %s1";
        return DB::query($sqlQuery, START_GRID_CELL, $tweetID);
    }

    public function getIncomingQueue() {
        $sqlQuery = "SELECT tweet_id ".
                    "FROM   queue_incoming ".
                    "LIMIT  10";
        return DB::query($sqlQuery);
    }

    public function addToOutgoingQueue($tweet) {
        $sqlQuery = "INSERT INTO queue_outgoing ".
                    "(tweet, created_date) VALUES ".
                    "(%s0, NOW())";

        return DB::query($sqlQuery, $tweet);

    }

    public function doesPlayerExistByTweetID($tweetID) {
        $sqlQuery = "SELECT pl.player_id ".
                    "FROM   players pl, tweets_incoming ti ".
                    "WHERE  pl.twitter_name = ti.author_screen_name ".
                    "AND    ti.tweet_id = %s";
        $playerID = (DB::queryFirstField($sqlQuery,$tweetID));
        if ($playerID == null) {
            return false;
        } else {
            return true;
        }
    }

    public function loadSessionFromTweetID($tweetID) {
        $sqlQuery = "SELECT pl.player_id, pl.twitter_name, pl.current_grid_square ".
                    "FROM   players pl, tweets_incoming ti ".
                    "WHERE  pl.twitter_name = ti.author_screen_name ".
                    "AND    ti.tweet_id = %s";
        return DB::queryFirstRow($sqlQuery,$tweetID);
    }

    public function loadInventoryByPlayerID($playerID) {
        $sqlQuery = "SELECT item.name ".
                    "FROM   items item, inventory invent ".
                    "WHERE  invent.item_id = item.item_id ".
                    "AND    invent.player_id = %s";
        return DB::query($sqlQuery,$playerID);
    }

    public function getGridCellDetails($currentGridCell) {
        // get the grid cells into which the player can pass
        $sqlQuery = "SELECT path_north as north, path_south as south, ".
            "       path_east as east, path_west as west, path_blocked as blocked, ".
            "       itemID_gain as gain, itemID_need as need".
            "FROM   grid ".
            "WHERE  gridID = %s0";
        $gridDetails = DB::queryFirstRow($sqlQuery, $currentGridCell);
        return $gridDetails;
    }

    public function loadActionFromTweetID($tweetID) {
        $sqlQuery = "SELECT text ".
                    "FROM   tweets_incoming ".
                    "WHERE  tweet_id = %s";
        return DB::queryFirstField($sqlQuery,$tweetID);

    }

    /*
    public function getPlayerID($callSID) {
        $sqlQuery = "SELECT playerID ".
                    "FROM   players ".
                    "WHERE  callID = %s0";
        return DB::queryFirstField($sqlQuery,$callSID);
    }

    public function getLastGridCell($callSID) {
        // get the last grid cell the player was in
        $sqlQuery = "SELECT gridID ".
                    "FROM   players ".
                    "WHERE  callID = %s0";
        $lastGridCell = DB::queryFirstField($sqlQuery, $callSID);
        if ($lastGridCell == null) {
            return START_GRID_CELL;
        } else {
            return $lastGridCell;
        }
    }

    public function checkForInventoryGainInGridCell($currentGridCell) {
        // get any inventory IDs for this current cell
        $sqlQuery = "SELECT itemID_gain ".
                    "FROM   grid ".
                    "WHERE  gridID = %s0";
        $inventoryGainInGridCell = DB::queryFirstField($sqlQuery, $currentGridCell);
        if ($inventoryGainInGridCell == null) {
            return false;
        } else {
            return $inventoryGainInGridCell;
        }
    }

    public function checkForInventoryNeedInGridCell($currentGridCell) {
        // get any inventory IDs for this current cell
        $sqlQuery = "SELECT itemID_need ".
                    "FROM   grid ".
                    "WHERE  gridID = %s0";
        $inventoryNeedInGridCell = DB::queryFirstField($sqlQuery, $currentGridCell);
        if ($inventoryNeedInGridCell == null) {
            return false;
        } else {
            return $inventoryNeedInGridCell;
        }
    }

    public function updatePlaysTableWithCurrentPlay($telNumber, $callSID) {
        $sqlQuery = "INSERT INTO players ".
                    "(telNumber, callID, gridID, lastTimerAlert, startTimeCurrentPlay) VALUES ".
                    "(%s0, %s1, %s2, 0, now()) ".
                    "ON DUPLICATE KEY UPDATE ".
                    "callID = %s1, lastTimerAlert = 0, startTimeCurrentPlay = NOW()";
        DB::query($sqlQuery, $telNumber, $callSID, START_GRID_CELL);
    }

    public function updatePlaysTableWithNewGridCell($newCell,$callSID) {
        $sqlQuery = "UPDATE players ".
                    "SET    gridID = %s0, ".
                    "       totalMovesMade = totalMovesMade + 1, ".
                    "       totalSecondsPlay = (totalSecondsPlay + (TIME_TO_SEC(CURTIME()) - TIME_TO_SEC(lastUpdated))) ".
                    "WHERE  callID = %s1";
        DB::query($sqlQuery, $newCell, $callSID);
    }

    public function hasPlayerGotItem($itemID,$playerID) {
        $sqlQuery = "SELECT 'x' ".
                    "FROM   inventory ".
                    "WHERE  playerID = %s0 ".
                    "AND    itemID = %s1";
        $hasPlayerGotItem = DB::queryFirstField($sqlQuery,$playerID,$itemID);
        if ($hasPlayerGotItem == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getTextForInventoryGain($itemID) {
        $sqlQuery = "SELECT audio.smstext ".
                    "FROM   audio, items ".
                    "WHERE  audio.audioID = items.audioID_gain ".
                    "AND    items.itemID = %s0";
        return DB::queryFirstField($sqlQuery,$itemID);
    }

    public function getAudioFilenameForInventoryGain($itemID) {
        $sqlQuery = "SELECT audio.filename ".
                    "FROM   audio, items ".
                    "WHERE  audio.audioID = items.audioID_gain ".
                    "AND    items.itemID = %s0";
        return DB::queryFirstField($sqlQuery,$itemID);
    }

    public function getTextForInventoryUse($itemID) {
        $sqlQuery = "SELECT audio.smstext ".
                    "FROM   audio, items ".
                    "WHERE  audio.audioID = items.audioID_use ".
                    "AND    items.itemID = %s0";
        return DB::queryFirstField($sqlQuery,$itemID);
    }

    public function getTextForInventoryNotFound($itemID) {
        $sqlQuery = "SELECT audio.smstext ".
                    "FROM   audio, items ".
                    "WHERE  audio.audioID = items.audioID_notfound ".
                    "AND    items.itemID = %s0";
        return DB::queryFirstField($sqlQuery,$itemID);
    }

    public function addItemToInventoryForPlayer($itemID,$playerID) {
        $sqlQuery = "INSERT INTO inventory ".
                    "(playerID, itemID) VALUES ".
                    "(%s0, %s1)";
        DB::query($sqlQuery, $playerID, $itemID);
        echo "<!-- Adding inventory item:". $itemID ." -->\n";
    }

    public function callerHasCompletedGame($callID) {
        $sqlQuery = "UPDATE players ".
                    "SET    completedStory = 1 ".
                    "WHERE  callID = %s0";
        DB::query($sqlQuery, $callID);
    }

    public function hasCallerCompletedGame($telNumber) {
        $sqlQuery = "SELECT completedStory ".
                    "FROM   players ".
                    "WHERE  telNumber = %s0";
        $hasCallerCompletedGame = DB::queryFirstField($sqlQuery, $telNumber);
        if ($hasCallerCompletedGame == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function resetPlayerEntry($telNumber) {
        $sqlQuery = "UPDATE players ".
                    "SET    telNumber = CONCAT('xx',telNumber), ".
                    "       callID = '' ".
                    "WHERE  telNumber = %s0";
        DB::query($sqlQuery, $telNumber);
    }
*/

}
