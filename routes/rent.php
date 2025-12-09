<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Aluguel
$route->get("/aluguel", "Rent:startPage");

