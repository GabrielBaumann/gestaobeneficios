<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App\Web");

// Login
$route->get("/", "Web:login");
$route->post("/", "Web:login");
