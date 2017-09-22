<?php
/**
 * Index routing for WurmHole.
 * 
 * Copyright (c) 2017 Marlon B van der Linde <marlon@notnull.xyz>
 * Licensed Under the MIT License https://opensource.org/licenses/MIT
 */

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/vendor/autoload.php';
require_once 'WurmController.php';

const DEBUG = TRUE;
const DBFILE = 'sql/wurmlogin.db';

$app = new Silex\Application();
$app['debug'] = DEBUG;

// only if content-type on request is application/json, we parse it as json...
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

if (!file_exists(DBFILE)) {
    die('Cannot open the DBFILE: ' . DBFILE);
}

$wurmCon = new WurmController(DBFILE);

// ROUTES

$app->get('/data', function (Request $request) use ($app) {
    //return 'GET DATA ';
    $player = $request->request->get('player');
    
    
    return $app->json($player, 201);
    
});

$app->get('/skills', function (Request $request) use ($app) {
    return 'GET SKILLS ';
});

$app->put('/skill', function (Request $request) use ($app) {
    return 'PUT SKILLS ';
});

$app->put('/data', function (Request $request) use ($app) {
    return 'PUT DATA';
});


$app->run();
