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

$player = isset($_REQUEST['player']) ? strval($_REQUEST['player']) : null;
if (!$player) {
   throw new HttpInvalidParamException('Parameter player= is required');
}

$loader->connect('wurmplayers.db');

$players = $skill = [];
$playerData = $loader->getPlayerData($player);
$playerSkills = $loader->getPlayerSkills($player, $skillnumbers);

print "<pre>"; print_r($playerData);
print "</pre><hr><pre>"; print_r($playerSkills);


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

