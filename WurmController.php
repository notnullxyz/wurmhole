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
        $this->sqlite = new db\SQLite\SQLite(static::SQLITE_DIR . static::SQLITE_DB_PLAYERS);
        $this->skillNumberMapper = new SkillNumbers();
        $this->helper = new Helper();
    }

    /**
     * Updates a wurm skill - responds with 202 or 400
     * @param string $jsonBody
     */
    public function updateSingleSkillForPlayer(string $jsonBody) {
        $data = json_decode($jsonBody);

        $player = (string) $data->player;
        $skillNumber = (int) $data->skillNumber;
        $newValue = (float) $data->value;

        $skillName = $this->skillNumberMapper->get($skillNumber);
        $playerId = $this->sqlite->getPlayerIdByName($player);

        $response = $this->sqlite->setSkill($playerId, $skillNumber, $newValue);
        if ($response) {
            http_response_code(202);
        } else {
            http_response_code(400);
        }
    }

    public function updatePlayerDataParameter(string $jsonBody) {
        throw new Exception('Not implemented');
    }

    public function getAllSkillsForPlayer(string $jsonBody) {
        $data = json_decode($jsonBody);
        $player = (string) $data->player;
        $playerId = $this->sqlite->getPlayerIdByName($player);
        
        $response = $this->sqlite->getSkillsByPlayerId($playerId);
        $augmented = $this->helper->remapAllSkillsWithNames($response, $this->skillNumberMapper);
        
        http_response_code(200);
        echo json_encode($augmented);
    }

    public function getAllDataForPlayer(string $jsonBody) {
        throw new Exception('Not implemented');
    }

}
