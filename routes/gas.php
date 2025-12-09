<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Gás
$route->get("/gas", "Gas:startPage");
