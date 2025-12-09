<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Natalidade
$route->get("/natalidade", "Birth:startPage");

