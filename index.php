<?php

use Medoo\Medoo;

/**
 * WurmHole - Data Manipulator For Marlon & Angora
 * Marlon van der Linde marlon250f@gmail.com
 */
require 'vendor/autoload.php';
require_once('SkillNumbers.php');

// some less-configured configuration values :-)
const SQLITE_DIR = "sql/";                      // where the wurm db sqlite files are located
const SQLITE_DB_PLAYERS = "wurmplayers.db";     // The players database
const BLOCK_LOGGING = true;                     // whether logging is needed. This is not good really, leave on true

$database = new Medoo([
    'database_type' => 'sqlite',
    'database_file' => SQLITE_DIR . SQLITE_DB_PLAYERS
]);


// router of sorts....
$player = isset($_REQUEST['player']) ? strval($_REQUEST['player']) : null;
if (!$player) {
   throw new HttpInvalidParamException('Parameter player= is required');
}

$players = $skill = [];
$playerData = $loader->getPlayerData($player);
$playerSkills = $loader->getPlayerSkills($player, $skillnumbers);
