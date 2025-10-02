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
$route->get("/cartao", "CardPerson:startPage");

$route->get("/enivardesbloqueiocartao", "CardPerson:listExcelSendCardRecharge");

$route->get("/baixar/{type}", "CardPerson:listExcelSendCard");

$route->get("/enviado", "CardPerson:sendCard");
$route->post("/enviado", "CardPerson:sendCard");

$route->get("/solicitado", "CardPerson:requestCard");
$route->post("/solicitado", "CardPerson:requestCard");

$route->get("/novocartao", "CardPerson:newCard");
$route->get("/cartaoativo", "CardPerson:cardActive");

$route->get("/solicitaremergencial","CardPerson:requestEmergency");
$route->post("/solicitaremergencial","CardPerson:requestEmergency");

$route->get("/documento", "CardPerson:documentOffice");

// Rotas para solicitação de cartão feito nas unidades
$route->get("/solicitarcartao", "CardRequest:formCardRequest");
$route->post("/solicitarcartao", "CardRequest:formCardRequest");

$route->get("/deletesolicitacaocartao", "CardRequest:deleteRequestCard");
$route->post("/deletesolicitacaocartao", "CardRequest:deleteRequestCard");


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