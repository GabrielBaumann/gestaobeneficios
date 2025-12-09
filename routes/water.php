<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Água
$route->get("/agua", "Water:startPage");
