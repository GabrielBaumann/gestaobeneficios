<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

// BOOTSTRAP

use Source\Core\Session;
use CoffeeCode\Router\Router;

$session = new Session();
$route = new Router(url(), ":");

// WEB
// Login
$route->namespace("Source\App");

$route->get("/", "Web:login");


// Início
$route->get("/inicio", "Start:startPage");

// Benficiários
$route->get("/beneficiarios", "PersonBenefit:startPage");

// Aluguel
$route->get("/aluguel", "Rent:startPage");

// Energia
$route->get("/energia", "Energy:startPage");

// Natalidade
$route->get("/natalidade", "Birth:startPage");

// Transporte
$route->get("/transporte", "Transport:startPage");

// Funeral
$route->get("/funeral", "Funeral:startPage");

// Água
$route->get("/agua", "Water:startPage");

// Cartão
$route->get("/cartao", "Card:startPage");

// Emolumentos
$route->get("/emolumentos", "Emoluments:startPage");

// Gás
$route->get("/gas", "Gas:startPage");


// ERROR ROUTES

$route->namespace("Source\App")->group("/ops");
$route->get("/{errcode}", "Web:error");

// ROUTE

$route->dispatch();

// ERROR REDIRECT

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();