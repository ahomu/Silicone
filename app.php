<?php

require dirname(__FILE__).'/bootstrap.php';
require dirname(__FILE__).'/config.php';

use Silicone\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application($config);

/*
 * Write here your presentation logic for web request.
 * You can include other php file which wrote any logic.
 */
$app->get('/', function (Request $req, Application $app) {

});
