<?php

// Import some requireds
require 'vendor/autoload.php';
require_once('db\SQLite.php');
require_once('SkillNumbers.php');
require_once('Helper.php');

// Configure some should-be's
const SQLITE_DIR = "sql/";                      // where the wurm db sqlite files are located
const SQLITE_DB_PLAYERS = "wurmplayers.db";     // The players database
const BLOCK_LOGGING = true;                     // whether logging is needed. This is not good really, leave on true
// Instantiate some usefuls
$sqlite = new db\SQLite\SQLite(SQLITE_DIR . SQLITE_DB_PLAYERS);
$skillNumberMap = new SkillNumbers();
$helper = new Helper();
$klein = new \Klein\Klein();

// check for ?player=
$player = isset($_REQUEST['player']) ? strval($_REQUEST['player']) : null;
if (!$player) {
    throw new ErrorException('Query Parameter player= is required');
}

// determine player id.
$playerName = & $player;
$playerId = $sqlite->getPlayerIdByName($playerName);

//$klein->respond('GET', '/test', function () {
//    return 'Hello World!';
//});
//
//$klein->dispatch();
