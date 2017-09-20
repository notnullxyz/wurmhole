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
        $data = json_decode($jsonBody);
        
        $player = (string)$data->player;
        $skillNumber = (int)$data->skillNumber;
        $newValue = (float)$data->value;
        
        $skillName = $this->skillNumberMapper->get($skillNumber);
        $playerId = $this->sqlite->getPlayerIdByName($player);

        $response = $this->sqlite->setSkill($playerId, $skillNumber, $newValue);
        print "Response: ";
        print_r($response);

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
