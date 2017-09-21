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
    const HTTP_OK = 200;
    const HTTP_ACCEPTED = 202;
    const HTTP_NOTFOUND = 404;
    const HTTP_BADREQUEST = 400;
    const HTTP_SERVERERR = 500;

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
            http_response_code(static::HTTP_ACCEPTED);
        } else {
            http_response_code(static::HTTP_BADREQUEST);
        }
    }

    /**
     * This updates some parameters from the PLAYERS table.
     * Most values could end in disaster, so only going to allow updating of some.
     * safe'ish: EMAIL,SLEEP,KARMA,CALORIES,CARBS,PROTEINS,FATS,PLANTEDSIGN
     * The rest will be ignored.
     * 
     * @param string $jsonBody
     */
    public function updatePlayerDataParameter(string $jsonBody) {
        $data = json_decode($jsonBody);

        $player = (string) $data->player;
        $playerId = $this->sqlite->getPlayerIdByName($player);

        if (!$playerId) {
            http_response_code(static::HTTP_NOTFOUND);
            die();
        }

        $safes = ['email', 'sleep', 'karma', 'calories', 'carbs', 'proteins',
            'fats', 'plantedsign'];

        $dataAry = (array) $data;
        unset($dataAry['player']);
        $totalUpdate = $totalSkip = $totalFail = 0;

        foreach ($dataAry as $attr => $newValue) {
            $key = strtolower($attr);
            if (in_array($key, $safes)) {
                $rows = $this->sqlite->setPlayerDataAttr($playerId, $player, $key, $newValue);
                if ($rows == 1) {
                    $totalUpdate += $rows;
                } else {
                    $totalFail++;
                }
            } else {
                $totalSkip++;
            }
        }

        $result = [
            'updated' => $totalUpdate,
            'failed' => $totalFail,
            'skipped' => $totalSkip
        ];
        
        http_response_code(static::HTTP_OK);
        echo json_encode($result);
    }

    public function getAllSkillsForPlayer(string $jsonBody) {
        $data = json_decode($jsonBody);
        $player = (string) $data->player;
        $playerId = $this->sqlite->getPlayerIdByName($player);

        if (!$playerId) {
            http_response_code(static::HTTP_NOTFOUND);
            die();
        }

        $response = $this->sqlite->getSkillsByPlayerId($playerId);
        $augmented = $this->helper->remapAllSkillsWithNames($response, $this->skillNumberMapper);

        http_response_code(static::HTTP_OK);
        echo json_encode($augmented);
    }

    public function getAllDataForPlayer(string $jsonBody) {
        $data = json_decode($jsonBody);
        $player = (string) $data->player;

        $playerId = $this->sqlite->getPlayerIdByName($player);

        if (!$playerId) {
            http_response_code(static::HTTP_NOTFOUND);
            die();
        }

        $response = $this->sqlite->getPlayerDataByName($player);
        http_response_code(static::HTTP_OK);
        echo json_encode(array_pop($response));
    }

}
