<?php
/**
 * Index routing for WurmHole.
 * 
 * Copyright (c) 2017 Marlon B van der Linde <marlon@notnull.xyz>
 * Licensed Under the MIT License https://opensource.org/licenses/MIT
 */

require_once __DIR__.'/vendor/autoload.php';
require_once 'WurmController.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

const DEBUG = TRUE;
const DBFILE = 'sql/wurmplayers.db';

$app = new Silex\Application();
$app['debug'] = DEBUG;

// only if content-type on request is application/json, we parse it as json...
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

if (!is_writeable(DBFILE)) {
    die("Cannot write or otherwise use the database file: " . DBFILE);
}

$wurmCon = new WurmController(DBFILE);

// ROUTES

$app->get('/data', function (Request $request) use ($app, $wurmCon) {
    //return 'GET DATA ';
    $player = $request->request->get('player') ?? '';
    $response = $wurmCon->getAllDataForPlayer($player);
    if (!$response) {
        return $app->json([], Response::HTTP_NOT_FOUND);
    } else {
        return $app->json($response, Response::HTTP_OK);
    }
});

$app->get('/skills', function (Request $request) use ($app, $wurmCon) {
    $player = $request->request->get('player') ?? '';
    $response = $wurmCon->getAllSkillsForPlayer($player);
    if (!$response) {
        return $app->json([], Response::HTTP_NOT_FOUND);
    } else {
        return $app->json($response, Response::HTTP_OK);
    }
});

$app->get('/skillname', function (Request $request) use ($app, $wurmCon) {
    $prettyName = $request->request->get('skill-dump-name') ?? '';
    $response = $wurmCon->getSkillInternalNameBySkillDumpName($prettyName);
    if (!$response) {
        return $app->json([], Response::HTTP_NOT_FOUND);
    } else {
        return $app->json($response, Response::HTTP_OK);
    }
       
});

$app->put('/skill', function (Request $request) use ($app, $wurmCon) {
    $player = $request->request->get('player');
    $skillNumber = $request->request->get('skillNumber');
    $value = $request->request->get('value');
    
    $response = $wurmCon->updateSingleSkillForPlayer($player, $skillNumber, $value);
    
    if (!$response) {
        return $app->json([], Response::HTTP_NOT_FOUND);
    } else {
        return $app->json([], Response::HTTP_OK);
    }    
});

$app->put('/data', function (Request $request) use ($app, $wurmCon) {
    $player = $request->request->get('player') ?? '';
    $data = $request->request->get('update') ?? '{}';
    $response = $wurmCon->updatePlayerDataParameter($player, $data);
    if ($response) {
        return $app->json($response, Response::HTTP_ACCEPTED);
    } else {
        return $app->json('{}', Response::HTTP_BAD_REQUEST);
    }
});


$app->run();
