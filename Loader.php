<?php

/**
 * Class Loader
 * Responsible for loading and abstracting sqlite data.
 *
 */
class Loader
{

    private $databases;
    private $sqldir;
    private $conn;
    private $logblock;

    public function __construct(string $sqldir, bool $donotlog = false)
    {

        $this->logblock = $donotlog;

        $this->log("construction for sqldir: '$sqldir'");
        if (!file_exists($sqldir)) {
            $this->log("non-existent sqldir $sqldir");
            throw new Exception("sqldir \"$sqldir\" does not exist.");
        }

        $this->sqldir = $sqldir;
        $this->log("Set sqldir to $sqldir");

        $dbfiles = scandir($sqldir);
        $this->databases = [];
        $this->databases = $this->filterAllowables($dbfiles);
    }

    /**
     * not cool, but hack logging is easier...
     */
    private function log(string $msg)
    {
        if (!$this->logblock) {
            $date = date("Y/m/d H:i:s");
            print "<br>$date :: $msg";
        }
    }

    /**
     * Simple filter for checking what is being opened.
     */
    private function filterAllowables(array $files): array
    {
        function allowed($test)
        {
            $only = ['wurmplayers', 'wurmlogin'];     // safety fuse for allowed db's
            $pathparts = pathinfo($test);
            if (in_array($pathparts['filename'], $only)) {
                return true;
            }
            return false;
        }

        return array_filter(array_values($files), "allowed");
    }

    /**
     * Connect to the specified database, which can only be an allowed db.
     * @param $allowedDb
     * @throws Exception
     */
    public function connect($allowedDb)
    {
        if (!in_array($allowedDb, $this->databases)) {
            $this->log("DB '$allowedDb' is not allowed.");
            throw new Exception('Security Violation: $allowedDb is not allowed');
        }
        $open = $this->sqldir . $allowedDb;

        try {
            $this->log("Going to open '$open' now...");
            $this->conn = new PDO('sqlite:' . $open);
            $this->log("Seemed like '$open' was connected OK");
        } catch (PDOException $e) {
            $this->log("Failed opening the db '$open' because: " . $e->getMessage());
            $msg = "PDOException on Connection: " . $e->getMessage();
            throw $e;
        }
    }

    public function ex($query)
    {
        $this->log("Got query '$query'");

        try {
            $statement = $this->conn->prepare($query);
            if ($statement) {
                $statement->execute();
            } else {
                $this->log("Statement did not prepare :( - " . $query);
                throw new Exception('preparation failure on query ' . $query);
            }

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->log("Got result apparently.");
            return $result;
        } catch (PDOException $e) {
            $this->log("Exception while executing query '$query' " . $e->getMessage());
            $msg = "PDOException on Execution: " . $e->getMessage();
            throw new Exception($msg);
        }
    }

    private function getPlayerIdByName(string $playerName) : int
    {
        $this->log("getPlayerIdByName request for '$playerName'");
        $query = "SELECT wurmid FROM PLAYERS WHERE name = '$playerName' LIMIT 1";
        return $this->ex($query)[0]['WURMID'];
    }

    public function getPlayerData(string $player)
    {
        $this->log("getPlayer request for '$player'");
        $query = "SELECT wurmid,name,playingtime,stamina,hunger,nutrition,thirst,ipaddress,plantedsign,kingdom,money,sleep,calories,carbs,fats,proteins FROM PLAYERS WHERE name = '$player'";

        try {
            $statement = $this->conn->prepare($query);
            if ($statement) {
                $statement->execute();
            } else {
                $this->log("Statement did not prepare :( - " . $query);
                throw new Exception('preparation failure on query ' . $query);
            }

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->log("Got result apparently.");
            return $result;
        } catch (PDOException $e) {
            $this->log("Exception while executing query '$query' " . $e->getMessage());
            $msg = "PDOException on Execution: " . $e->getMessage();
            throw new Exception($msg);
        }

    }

    public function getPlayerSkills(string $player, SkillNumbers $skillmap)
    {
        $skillData = [];
        $wurmid = $this->getPlayerIdByName($player);
        $skills = $this->ex("SELECT number,value FROM SKILLS where owner = $wurmid order by number");
        foreach ($skills as $skill) {

            $skillNumber = $skill['NUMBER'];
            $skillValue = $skill['VALUE'];
            $skillName = $skillmap->get($skillNumber);

            $skillData[] = array('number' => $skillNumber, 'value' => $skillValue, 'name' => $skillName);
        }
        return $skillData;
    }

}