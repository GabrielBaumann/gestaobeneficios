<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App\Water");

// Água
$route->group("/agua");
$route->get("/agua", "Water:startPage");
