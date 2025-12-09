<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Funeral
$route->get("/funeral", "Funeral:startPage");

