<?php

// Import some requireds
require 'vendor/autoload.php';
require_once('db\SQLite.php');
require_once('SkillNumbers.php');
require_once('Helper.php');


class WurmController {

    // Configure some should-be's
    const SQLITE_DIR = "sql/";                      // where the wurm db sqlite files are located
    const SQLITE_DB_PLAYERS = "wurmplayers.db";     // The players database
    const BLOCK_LOGGING = true;                     // whether logging is needed. This is not good really, leave on true

    private $sqlite;
    private $skillNumberMapper;
    private $helper;

    public function __construct() {

        // Instantiate some usefuls
        $this->sqlite = new db\SQLite\SQLite(static::SQLITE_DIR. static::SQLITE_DB_PLAYERS);
        $this->skillNumberMapper = new SkillNumbers();
        $this->helper = new Helper();
        
    }

    public function updateSingleSkillForPlayer(string $jsonBody) {
        $skillNumber = 2;
        $newValue = 26.61;
        $skillName = $skillNumberMap->get($skillNumber);

        print "Going to set skill id $skillNumber ($skillName) to $newValue for player id: $playerId ($playerName)";
        print "<hr>";
        $response = $sqlite->setSkill($playerId, $skillNumber, $newValue);
        print "Rows updated: $response";
    }
    
    public function updatePlayerDataParameter(string $jsonBody) {
        throw new Exception('Not implemented');
    }
    
    public function getAllSkillsForPlayer(string $jsonBody) {
        throw new Exception('Not implemented');
    }
    
    public function getAllDataForPlayer(string $jsonBody) {
        throw new Exception('Not implemented');
    }
    
}
