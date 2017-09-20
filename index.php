<?php

/**
 * WurmHole - Data Manipulator For Marlon & Angora
 * Marlon van der Linde marlon250f@gmail.com
 */
require 'vendor/autoload.php';
require_once('db\SQLite.php');
require_once('SkillNumbers.php');
require_once('Helper.php');

// some less-configured configuration values :-)
const SQLITE_DIR = "sql/";                      // where the wurm db sqlite files are located
const SQLITE_DB_PLAYERS = "wurmplayers.db";     // The players database
const BLOCK_LOGGING = true;                     // whether logging is needed. This is not good really, leave on true
// router of sorts....
$player = isset($_REQUEST['player']) ? strval($_REQUEST['player']) : null;
if (!$player) {
    throw new ErrorException('Parameter player= is required');
}

$sqlite = new db\SQLite\SQLite(SQLITE_DIR . SQLITE_DB_PLAYERS);
$skillNumberMap = new SkillNumbers();
$helper = new Helper();

// determined
$playerName = 'Marlon';
$skillNumber = 2;
$newValue = 26.61;

// determinable
$skillName = $skillNumberMap->get($skillNumber);
$playerId = $sqlite->getPlayerIdByName($playerName);




// Testing a full Skill get
if (0) {
    print "Going to get all skills for player id: $playerId ($playerName)";
    print "<hr>";
    $response = $sqlite->getSkillsByPlayerId($playerId);
    $augmented = $helper->remapAllSkillsWithNames($response, $skillNumberMap);
    print "<pre>";
    print_r($augmented);
}


// Testing Update
if (0) {
    print "Going to set skill id $skillNumber ($skillName) to $newValue for player id: $playerId ($playerName)";
    print "<hr>";
    $response = $sqlite->setSkill($playerId, $skillNumber, $newValue);
    print "Rows updated: $response";
}

// Testing Player Data
if (0) {
    print "Going to get data for player-name: $playerName";
    print "<hr>";
    $response = $sqlite->getPlayerDataByName($playerName);
    print "<pre>";
    print_r($response);
}





print "<hr>";
$sqlite->getPastQueries();

