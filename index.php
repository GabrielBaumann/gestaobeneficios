<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

// BOOTSTRAP

use Source\Core\Session;
use CoffeeCode\Router\Router;

$session = new Session();
$route = new Router(url(), ":");

/**
 * Arquivos de rotas
 */

// Rotas gerais 
require __DIR__ . "/routes/web.php";

// Início
require __DIR__ . "/routes/start.php";

// Módulos específicos
require __DIR__ . "/routes/card.php";
require __DIR__ . "/routes/benefit.php";
require __DIR__ . "/routes/rent.php";
require __DIR__ . "/routes/energy.php";
require __DIR__ . "/routes/birth.php";
require __DIR__ . "/routes/transport.php";
require __DIR__ . "/routes/funeral.php";
require __DIR__ . "/routes/water.php";
require __DIR__ . "/routes/emoluments.php";
require __DIR__ . "/routes/gas.php";


// ERROR ROUTES

$route->namespace("Source\App")->group("/ops");
$route->get("/{errcode}", "Web:error");

$route->dispatch();

// ERROR REDIRECT

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();