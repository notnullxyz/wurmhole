<?php

namespace db\SQLite;

use Medoo\Medoo;

/**
 * Abstractions for sqlite specifics.
 *
 * @author Marlon
 */
class SQLite {

    const DB_SKILLS = "SKILLS";
    const DB_PLAYERS = "PLAYERS";

    /**
     * Representation of the db connection on sqlite
     * @var type
     */
    private $db;
    
    public function __construct(string $database) {

        if (file_exists($database)) {
            $sqliteMedoo = [
                'database_type' => 'sqlite',
                'database_file' => $database,
                'logging' => true
            ];
        } else {
            throw new Exception('That Database is not valid: ' . $database);
        }

        $this->db = new Medoo($sqliteMedoo);
    }
        
    public function getSkillsByPlayerId(int $playerId) : array {
        //"SELECT number,value FROM SKILLS where owner = 123 order by number"
        $select = [
            'ID',
            'NUMBER',
            'VALUE'
        ];
        
        $where = [
            'OWNER' => $playerId
        ];
        
        return $this->db->select(static::DB_SKILLS, $select, $where);
    }
    
    /**
     * Return the wurmid associated with a player name, if it exists, else 0 zero.
     * @param string $playerName
     * @return int
     */
    public function getPlayerIdByName(string $playerName) : int {
        // SELECT name from PLAYERS where WURMID = 16777216
        
        $select = [
            'WURMID'
        ];
        
        $where = [
            'NAME' => $playerName
        ];
        
        $data = $this->db->select(static::DB_PLAYERS, $select, $where);
        $value = array_pop($data)['WURMID'] ?? 0;
        return $value;
    }
        
    public function getPlayerDataByName(string $playerName) : array {
        //"SELECT wurmid,name,playingtime,stamina,hunger,nutrition,thirst,ipaddress,plantedsign,kingdom,money,sleep,calories,carbs,fats,proteins FROM PLAYERS WHERE NAME = marlon"    
        $select = [
            'NAME',
            'WURMID',
            'FACE',
            'CREATIONDATE',
            'LASTLOGOUT',
            'PLAYINGTIME',
            'SEX',
            'STAMINA',
            'HUNGER',
            'NUTRITION',
            'THIRST',
            'PLANTEDSIGN',
            'BANNED',
            'WARNINGS',
            'FAITH',
            'DEITY',
            'ALIGNMENT',
            'GOD',
            'FAVOUR',
            'KINGDOM',
            'MONEY',
            'FAT',
            'TITLE',
            'PET',
            'NICOTINE',
            'ALCOHOL',
            'EMAIL',
            'SLEEP',
            'DISEASE',
            'HOTAWINS',
            'KARMA',
            'CALORIES',
            'FATS',
            'PROTEINS',
            'CARBS'
        ];
        
        $where = [
            'NAME' => $playerName
        ];
        
        return $this->db->select(static::DB_PLAYERS, $select, $where);        
    }
    
    /**
     * Update a specific skill for a specific wurm player.
     * @param int $playerId - the wurmid of the player
     * @param int $skillIdNumber - the number of the skill in the wurm db
     * @param float $newValue - the new value to set the skill to
     * @return int rows-affected
     */
    public function setSkill(int $playerId, int $skillIdNumber, float $newValue) : int {
        $replace = [
            "VALUE" => $newValue
        ];
        
        $where = [
            "OWNER[=]" => $playerId,
            "NUMBER[=]" => $skillIdNumber
        ];
        
        $data = $this->db->update(static::DB_SKILLS, $replace, $where);
//        $data = $this->db->query(
//                'UPDATE "SKILLS" SET "VALUE" = :newvalue WHERE "OWNER" = :owner AND "NUMBER" = :number',
//                [
//                    ":newvalue" => $newValue,
//                    ":owner" => $playerId,
//                    ":number" => $skillIdNumber
//                ]);
        
        return $data->rowCount();
    }

    public function getPastQueries() {
        $all = $this->db->log();
        print '<h3>Queries Executed (' . count($all) . ')</h3><ul>';
        foreach($all as $query) {
            print "<li>$query</li>";
        }
        print '</ul>';
    }
    
}
    