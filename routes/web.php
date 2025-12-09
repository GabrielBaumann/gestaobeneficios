<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Login
$route->get("/", "Web:login");

