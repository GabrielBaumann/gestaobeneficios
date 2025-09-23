<?php

use Soap\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= theme("/css/message.css", CONF_VIEW_APP); ?>">
    <?= $this->section("css") ?>
    <title>Document</title>
    <style>
        body {
            font-family: 'Montserrat';
        }
    </style>
<body>
    <div class="flex h-screen">
        <!-- lateral aside -->
        <aside id="sidebar-main" class="relative hidden w-full md:flex flex-col justify-between md:w-[300px] md:min-w-[300px] md:max-w-[300px] p-6 overflow-y-auto">
            <button class="md:hidden absolute top-4 right-4" onclick="toggleMenu()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="flex flex-col gap-8">
                <div class="flex items-center justify-center font-semibold text-blue-900 md:text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                    <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                    <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                    </svg>
                    <span>GestaoDeBeneficios</span>
                </div>
                
                <div class="flex flex-col">
                    <span class="uppercase text-light text-gray-600 px-4">principal</span>
                    <div class="flex flex-col ml-6">
                        <a href="<?= url("/inicio"); ?>" class="menu flex items-center gap-2 transition-all duration-300 px-3 py-2 cursor-pointer text-gray-800 font-semibold border-l border-gray-300 hover:border-blue-800 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span class="menu" data-sidebar="inicio">Início</span>
                        </a>
                        <a href="<?= url("/beneficiarios"); ?>" class="menu flex items-center gap-2 transition-all duration-300 px-3 py-2 cursor-pointer text-gray-800 font-semibold border-l border-gray-300 hover:border-blue-800 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="menu" data-sidebar="beneficiarios">Beneficiários</span>
                        </a>
                    </div>
                    <span class="uppercase text-light text-gray-600 px-4 mt-4">benefícios</span>
                    <div id="menu-links" class="flex flex-col ml-6">
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span class="menu" data-sidebar="aluguelsocial">Aluguel Social</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Energia Elétrica</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Natalidade</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Transporte</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Funeral</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Água</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Cartão Alimentação</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Emolumentos</span>
                        </a>
                        <a href="" class="px-3 py-2 border-l border-gray-300 hover:text-blue-800 hover:border-blue-800 flex items-center gap-2 transition-all duration-300 cursor-pointer text-gray-800 font-semibold">
                            <span>Gás</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <span class="uppercase text-light text-gray-600 px-4 mt-4">mais opções</span>
                <div class="flex flex-col ml-6">
                    <a href="" class="flex items-center gap-2 transition-all duration-300 py-2 px-3 cursor-pointer text-black font-semibold border-l border-gray-300 hover:border-blue-800 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>Configurações</span>
                    </a>
                    <div class="flex items-center gap-2 text-gray-500 py-2 px-3 border-l border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span>Gabriel Baumann</span>
                    </div>
                    <div class="flex items-center gap-2 font-semibold text-black border-l border-gray-300 transition-all duration-300 cursor-pointer py-2 px-3 hover:border-red-500 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        <a href="">Sair</a>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- main area -->
        <main id="main-area" class="relative h-screen md:w-full">
            <!-- mobile -->
            <?= $this->insert("/mobile/start") ?>

            <?= $this->section("content"); ?>

        </main>

    </div>

    <script src="<?= theme("/js/default/default.js", CONF_VIEW_APP); ?>">
        // toggle menu on mobile
        function toggleMenu() {
            const sidebar = document.getElementById("sidebar-main");
            const main = document.getElementById("main-area");

            if (sidebar.classList.contains("hidden")) {
                sidebar.classList.remove("hidden");
                main.classList.add("hidden");

            } else {
                sidebar.classList.add("hidden");
                main.classList.remove("hidden");
            }
        }

    </script>
    <?= $this->section("scripts") ?>
</body>
</html>