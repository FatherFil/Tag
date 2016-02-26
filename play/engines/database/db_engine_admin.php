<?php

class dbEngineAdmin extends dbEngine {

    // Properties

    // Constructor

    // Methods
    public function getMissingInventory($type) {
        // get a list of inventory references that are required in the grid and not in the inventory table
        $sqlQuery = "SELECT itemID_". $type ." as itemID ".
                    "FROM   grid ".
                    "WHERE  itemID_". $type ." is not null ".
                    "AND    NOT EXISTS (".
                    "   SELECT 'x' ".
                    "   FROM   items ".
                    "   WHERE  itemID = grid.itemID_". $type.
                    ")";
        $sqlResult = DB::query($sqlQuery);
        return $sqlResult;
    }

    function getLeaderboard() {
        $sqlQuery = "SELECT * ".
                    "FROM   players ".
                    "WHERE  completedStory = '1' ".
                    "ORDER BY totalMovesMade ASC, totalSecondsPlay ASC";
        $leaderboard = DB::query($sqlQuery);
        return $leaderboard;
    }

    function getAllUncompletedPlayers() {
        $sqlQuery = "SELECT * ".
                    "FROM   players ".
                    "WHERE  completedStory = '0' ".
                    "ORDER BY telNumber";
        $uncompleted = DB::query($sqlQuery);
        return $uncompleted;
    }

}
