<?php

// Import some requireds
//require 'vendor/autoload.php';

//require_once('db\SQLite.php');
require_once('SkillNumbers.php');
require_once('Helper.php');
require_once('./db/SQLite.php');

class WurmController {
    private $sqlite;
    private $helper;
    private $dbFileLocation;

    public function __construct(string $dbLocation) {

        $this->dbFileLocation = $dbLocation;
        
        try {
            $this->sqlite = new SQLite($dbLocation);
        } catch (ErrorException $ee) {
            die('WurmController Suffers: ' . $ee->getMessage());
        }

        $this->helper = new Helper(new SkillNumbers());
    }

    /**
     * Updates a wurm skill - responds with 202 or 400
     * @param string $jsonBody
     */
    public function updateSingleSkillForPlayer(string $playerName, int $skillNumber, $newValue) {
        $playerId = $this->sqlite->getPlayerIdByName($playerName);

        if (!$playerId) {
            return null;
        }
        
        $result = $this->sqlite->setSkill($playerId, $skillNumber, $newValue);
        return $result;
    }

    /**
     * This updates some parameters on the PLAYERS table.
     * Most values could end in disaster, so only going to allow updating of some.
     * safe hardcodes: EMAIL,SLEEP,KARMA,CALORIES,CARBS,PROTEINS,FATS,PLANTEDSIGN
     * 
     * The rest will be ignored. An array is returned detailing the updates, skips and fails.
     * 
     * @param string $data
     * @param array $data
     */
    public function updatePlayerDataParameter(string $playerName, array $data) {
        $playerId = $this->sqlite->getPlayerIdByName($playerName);

        if (!$playerId) {
            return null;
        }

        $safes = ['email', 'sleep', 'karma', 'calories', 'carbs', 'proteins',
            'fat', 'plantedsign'];

        $dataAry = (array) $data;
        unset($dataAry['player']);
        $totalUpdate = $totalSkip = $totalFail = [];

        foreach ($dataAry as $attr => $newValue) {
            $key = strtolower($attr);
            if (in_array($key, $safes)) {
                $rows = $this->sqlite->setPlayerDataAttr($playerId, $playerName, $key, $newValue);
                
                if ($rows === 1) {
                    $totalUpdate[] = $attr;
                } else {
                    $totalFail[] = $attr;
                }

            } else {
                $totalSkip[] = $attr;
            }
        }

        $result = ['updated' => $totalUpdate,'failed' => $totalFail,'skipped' => $totalSkip];
        return $result;
    }

    /**
     * Get all the available skills for the given player name.
     * @param string $playerName
     */
    public function getAllSkillsForPlayer(string $playerName) {
        $playerId = $this->sqlite->getPlayerIdByName($playerName);

        if (!$playerId) {
            return null;
        }

        $response = $this->sqlite->getSkillsByPlayerId($playerId);
        return $this->helper->remapAllSkillsWithNames($response);
    }
    
    /**
     * Get the internal name for the pretty names given in skill dump files.
     * 
     * @param string $prettyName
     * @return string internal-name
     */
    public function getSkillInternalNameBySkillDumpName(string $prettyName) : array {
        if (!$prettyName || strlen($prettyName) < 2) {
            return null;
        }
        
        return [
            'internal-name' => $this->helper->getInternalSkillNameByPrettyName($prettyName),
            'skill-dump-name' => $prettyName
        ];
    }

    /**
     * Get all the available player attributes for the player name.
     * @param string $playerName
     */
    public function getAllDataForPlayer(string $playerName) {
        $playerId = $this->sqlite->getPlayerIdByName($playerName);

        if (!$playerId) {
            return null;
        }

        $response = $this->sqlite->getPlayerDataByName($playerName);
        return array_pop($response);
    }

}
