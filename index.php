<?php
/**
 * WurmHole - Data Manipulator For Marlon & Angora
 * Marlon van der Linde marlon250f@gmail.com
 */

require_once('Loader.php');
require_once('SkillNumbers.php');

/**
 * Set these as required.
 */
const SQLITE_DIR = "sql/";      // where the wurm db sqlite files are located
const BLOCK_LOGGING = true;     // whether logging is needed. This is not good really, leave on true

$loader = new Loader(SQLITE_DIR, BLOCK_LOGGING);
$skillnumbers = new SkillNumbers();

$loader->connect('wurmplayers.db');

$players = $skill = [];
$players = $loader->ex("SELECT wurmid,name,playingtime,stamina,hunger,nutrition,thirst,ipaddress,plantedsign,kingdom,money,sleep,calories,carbs,fats,proteins FROM PLAYERS");

// SKILLS
/* Array
(
    [0] => Array
        (
            [OWNER] => 16777216
            [NUMBER] => 101
            [VALUE] => 30.0439957785196
        ) 
*/

// PLAYERS
/*
    [0] => Array
        (
            [WURMID] => 16777216
            [NAME] => Marlon
            [PLAYINGTIME] => 1656339797
            [STAMINA] => -1
            [HUNGER] => 16212
            [NUTRITION] => 0.990000009536743
            [THIRST] => 30545
            [IPADDRESS] => /196.215.72.193
            [PLANTEDSIGN] => 1502489368805
            [KINGDOM] => 4
            [MONEY] => 352440
            [SLEEP] => 18000
            [CALORIES] => 0.0
            [CARBS] => 0.0
            [FATS] => 0.0
            [PROTEINS] => 0.0
        )
*/

print "<form method='GET' id='updateform'> <table>";
print "<tr>
	<th>Player</th>
	<th>Calories</th>
	<th>Carbs</th>
	<th>Fats</th>
	<th>Proteins</th>
	<th>PlantedSign</th>
	<th>Skills</th>
	</tr>";

foreach ($players as $player) {
    $playerid = $player['WURMID'];
    $playername = $player['NAME'];
    $calories = $player['CALORIES'];
    $carbs = $player['CARBS'];
    $fats = $player['FATS'];
    $proteins = $player['PROTEINS'];
    $plantedsign = $player['PLANTEDSIGN'];

    $skills = $loader->ex("SELECT number,value FROM SKILLS where owner = $playerid order by number");

    print "<tr><td>$playername</td>";
    print "<td><input type='text' name='calories' value='$calories'></td>" . "<td><input type='text' name='carbs' value='$carbs'></td>" . "<td><input type='text' name='fats' value='$fats'></td>" . "<td><input type='text' name='proteins' value='$proteins'></td>" . "<td><input type='text' name='plantedsign' value='$plantedsign'></td>";

    foreach ($skills as $skill) {
        $number = $skill['NUMBER'];
        $value = $skill['VALUE'];
        $skillname = $skillnumbers->get($number);

        print "<td>$skillname</td>";
        print "<td><input type='text' name='$number' value='$value'></td>";
    }

    //print "<td><button type='button' form='updateform'>patch</button></td>";
    print "</tr>";
}

print "</table></form>";

