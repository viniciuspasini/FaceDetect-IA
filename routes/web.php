<?php

use app\controllers\HomeController;
use core\library\Router;

$router = $app->container->get(Router::class);
//GET
$router->add('GET', '/', [HomeController::class, 'index']);

//POST
$router->add('POST', '/facedetect', [HomeController::class, 'faceDetect']);

$router->execute();
