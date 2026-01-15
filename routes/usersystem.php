<?php

/** @var \CoffeeCode\Router\Router $route */

$route->namespace("Source\App\UserSystem");

// Usuário do sistema

$route->group("/usuario");

// Adicionar usuário
$route->get("/usuario", "User:addUser");
$route->post("/usuario", "User:addUser");

// Verificar se o CPF existe e se é válido
$route->get("/verificarcpf/{cpf}", "User:checkCpf");

// Verificar email
$route->get("/verificaremail/{email}", "User:checkEmail");

$route->post("/modalquest", "User:modalQuest");

