<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Energia
$route->get("/energia", "Energy:startPage");

