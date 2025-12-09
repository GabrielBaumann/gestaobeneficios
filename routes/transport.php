<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Transporte
$route->get("/transporte", "Transport:startPage");

