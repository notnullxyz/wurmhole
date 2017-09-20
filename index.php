<?php

require_once 'WurmController.php';

// check for action=
$player = isset($_REQUEST['action']) ? strval($_REQUEST['action']) : null;
if (!$player) {
    throw new ErrorException('Query Parameter action= is required');
}

/**
 * ..... Now for some quick home-routing without a framework .....
 */

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// only care about params
if (($pos = strpos($requestUri, "?")) !== FALSE) {
    $queryParams = substr($requestUri, $pos + 1);
}

parse_str($queryParams, $params);

$action = $params['action'];
$body = file_get_contents('php://input');
$wurmCon = new WurmController();

switch ($requestMethod) {
    case 'GET':
        if ($action == 'allSkills') {
            $wurmCon->getAllSkillsForPlayer($body);
        } elseif ($action == 'allData') {
            $wurmCon->getAllDataForPlayer($body);
        }
        break;

    case 'PUT':
        if ($action == 'putSkill') {
            $wurmCon->updateSingleSkillForPlayer($body);
        } elseif ($action == 'putPlayerData') {    
            $wurmCon->updatePlayerDataParameter($body);
        }      
        break;

    default:
        throw new Exception("Improper usage.");
}

