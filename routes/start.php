<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App\Start");

// Página de início

$route->group("/inicio");

// Início
$route->get("/inicio", "Start:startPage");

