<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App");

// Beneficiários
$route->get("/beneficiarios", "PersonBenefit:startPage");

