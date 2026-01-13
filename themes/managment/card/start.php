<?php $this->layout("layout"); ?>
<div class="md:p-4 md:h-screen">
    <div class="flex flex-col h-full overflow-hidden w-screen md:w-auto rounded-md">
        <div class="sidebar" data-menu="cartao"></div>
        <header class="p-3 flex justify-start">
            <h1 class="font-semibold text-md uppercase text-white">Cartão Alimentação</h1>
        </header>
    
        <header class="flex items-center px-3 md:px-0 pt-3 gap-3 border-b border-gray-700">
            
                <div class="overflow-x-auto flex items-center">
                    <a href="<?= url("/cartao/novocartao");?>" class="flex items-center gap-2 novo text-center justify-center main-card-menu py-3 px-4 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-gray-400 text-white border-b-2 border-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Novo</span>
                    </a>
                    <a href="<?= url("/cartao/solicitaremergencial");?>" class="flex items-center gap-2 emergencial text-center justify-center main-card-menu py-3 px-4 cursor-pointer text-gray-400 font-semibold duration-all transition-300 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>
                        <span>Emergencial</span>
                    </a>
                    <a href="<?= url("/cartao/recarga");?>" class="flex items-center gap-2 recarga text-center justify-center main-card-menu py-3 px-4 cursor-pointer text-gray-400 font-semibold duration-all transition-300 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v8.25A2.25 2.25 0 0 0 6 16.5h2.25m8.25-8.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-7.5A2.25 2.25 0 0 1 8.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 0 0-2.25 2.25v6" />
                        </svg>
                        <span>Recarga</span>
                    </a>
                    <a href="<?= url("/cartao/beneficiario");?>" class="flex items-center gap-2 beneficiario text-center justify-center main-card-menu py-3 px-4 cursor-pointer text-gray-400 font-semibold duration-all transition-300 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span>Beneficiário</span>
                    </a>
                    <a href="<?= url("/cartao/atualizarsaldo");?>" class="flex items-center gap-2 saldo text-center justify-center main-card-menu py-3 px-4 cursor-pointer text-gray-400 font-semibold duration-all transition-300 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Atualizar Saldos</span>
                    </a>
                </div>
            
        </header>
    
        <?php if($menu === "novocartao"): ?>
            <header class="p-4 pt-6 flex items-center gap-2">
                <!-- <div class="flex flex-col md:flex-row">
                    <a href="<?= url("/cartao/solicitado");?>" class="solicitado py-3 px-4 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-gray-600 solicitado text-white">Solicitados</a>
                    <a href="<?= url("/cartao/enviado");?>" class="second-card-menu enviado py-3 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto">Enviados</a>
                    <a href="<?= url("/cartao/cartaoativo"); ?>" class="second-card-menu cartao py-3 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto">Cartões</a>
                </div> -->
                <a href="" class="flex items-center gap-1 text-blue-200 cursor-pointer text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Cartão Alimentação</span>
                </a>
                <div class="text-blue-200 text-sm">></div>
                <a href="" class="flex items-center gap-1 text-blue-200 cursor-pointer text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Novo Cartão</span>
                </a>
            </header>
        <?php elseif($menu === "segundavia"): ?>
            <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
                <h1 class="uppercase text-light text-white">Filtros específicos</h1>
                <div class="flex flex-col md:flex-row">
                    <a href="<?= url("/cartao/solicitado");?>" class="solicitado py-1 px-4 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-sm text-gray-600 solicitado text-white">Solicitados</a>
                    <a href="<?= url("/cartao/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Enviados</a>
                    <a href="<?= url("/cartao/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Cartões</a>
                </div>
            </header>
        <?php elseif ($menu === "novo"): ?>
            <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-4 flex flex-col gap-3">
                <h1 class="uppercase text-light text-white">Filtros específicos</h1>
                    <div class="flex items-center">
                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                        <button data-url="<?= url("/cartao/procurarsolicitacao") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                        <button name="cleaninput" id="cleaninput" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                            <span>Limpar filtros</span>
                        </button>
                    </div>
                <div class="flex items-center overflow-x-auto">
                    <a href="<?= url("/cartao/solicitado");?>" class="main-card-menu novo py-1 px-4 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-white solicitado text-white">Solicitados</a>
                    <a href="<?= url("/cartao/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Enviados</a>
                    <a href="<?= url("/cartao/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Cartões</a>
                </div>
            </header>
        <?php elseif ($menu === "solicitacao"): ?>
            <header class="flex flex-col gap-3 px-3 md:px-0">
                
                <div class="flex items-center overflow-x-auto">
                    <a href="<?= url("/cartao/solicitado");?>" class="main-card-menu novo py-3 px-4 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-white solicitado text-center">Solicitados</a>
                    <a href="<?= url("/cartao/enviado");?>" class="second-card-menu enviado py-3 px-4 cursor-pointer text-white font-semibold duration-all transition-300 w-full md:w-auto text-sm text-center">Enviados</a>
                    <a href="<?= url("/cartao/cartaoativo"); ?>" class="second-card-menu cartao py-3 px-4 cursor-pointer text-white font-semibold duration-all transition-300 w-full md:w-auto text-sm text-center">Cartões</a>
                </div>

                
                <div class="flex flex-col md:flex-row items-center py-4 gap-3 w-full md:justify-between">
                    <div class="flex flex-col gap-2 w-full">
                        <h1 class="text-white text-xl">Pesquisar</h1>
                        <div class="flex items-center w-full">
                            <input name="recipientname" id="recipientname" type="text" class="bg-white/20 input-search w-full pr-6 py-3 px-3 rounded-xs rounded-r-none text-white font-semibold md:max-w-[40vw]" placeholder="Pesquisar Beneficiários...">
                            <button data-url="<?= url("/cartao/procurarsolicitacao") ?>" id="search-all" class="py-3 px-4 cursor-pointer text-white bg-white/20 rounded-r-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- header with options -->
                    <div class="items-center flex">
                        <div class="flex items-center gap-2">
                            <a href="<?= url("/cartao/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-white hover:bg-green-800 hover:text-white transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <span>2° Via</span>
                            </a>
                            <a href="<?= url("/cartao/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Novo Cartão</span>
                            </a>
                        </div>
                    </div>
                    <!-- <button data-url="<?= url("/cartao/procurarsolicitacao") ?>" name="cleaninput" id="cleaninput" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                        <span>Limpar filtros</span>
                    </button> -->
                </div>

            </header>
        <?php elseif ($menu === "emergencial"): ?>
        <?php elseif ($menu === "enviado"): ?>
            <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
                <h1 class="uppercase text-light text-white">Filtros específicos</h1>
                    <div class="flex items-center">
                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                        <button data-url="<?= url("/cartao/procurarenviados") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                        <button data-url="<?= url("/cartao/procurarenviados") ?>" name="cleaninput" id="cleaninput" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                            <span>Limpar filtros</span>
                        </button>
                    </div>
                <div class="flex flex-col md:flex-row">
                    <a href="<?= url("/cartao/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer  font-semibold duration-all transition-300 w-full md:w-auto text-sm text-gray-600 solicitado">Solicitados</a>
                    <a href="<?= url("/cartao/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Enviados</a>
                    <a href="<?= url("/cartao/cartaoativo"); ?>" class="cartaoativo second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Cartões</a>
                </div>
            </header>
        <?php elseif ($menu === "cartao"): ?>
            <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
                <h1 class="uppercase text-light text-white">Filtros específicos</h1>
                    <div class="flex items-center">
                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                        <button data-url="<?= url("/cartao/procurarcartao") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
                <div class="flex flex-col md:flex-row">
                    <a href="<?= url("/cartao/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm text-gray-600 solicitado">Solicitados</a>
                    <a href="<?= url("/cartao/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Enviados</a>
                    <a href="<?= url("/cartao/cartaoativo"); ?>" class="cartaoativo second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm">Cartões</a>
                </div>
            </header>
        <?php elseif ($menu === "listacartaoemergencial"): ?>
            <div class="flex items-center">
                <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                <button data-url="<?= url("/cartao/procuraremergencial") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
                <button 
                    data-url="<?= url("/cartao/procuraremergencial") ?>" 
                    name="cleaninput" 
                    id="cleaninput" 
                    class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                    <span>Limpar filtros</span>
                </button>
            </div>
        <?php elseif ($menu === "beneficiario"): ?>
            <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
                <h1 class="uppercase text-light text-white">Filtros específicos</h1>
                    <div class="flex items-center">
                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                        <button data-url="<?= url("/cartao/procurarbeneficiario") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                        <button data-url="<?= url("/cartao/procurarbeneficiario") ?>" id="cleaninput" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                            <span>Limpar filtros</span>
                        </button>
                    </div>
            </header>
        <?php elseif ($menu === "saldo"): ?>
            <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
                <h1 class="uppercase text-light text-white">Filtros específicos</h1>
                    <div class="flex items-center">
                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                        <button data-url="<?= url("/cartao/procurarcartao") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
            </header>            
        <?php endif; ?>
    
        <main class="h-full overflow-hidden overflow-y-auto p-6">
            <div class="">
                <!-- Table -->
                <div class="p-6 px-0 hidden md:block">
                    <div class="content-ajax h-full ">
                        <?php if($menu === "novocartao"): ?>
                            <?= $this->insert("/card/formNewCard"); ?>
                        <?php elseif ($menu === "novo"): ?>
    
                            <!-- header with options -->
                            <div class="py-4 items-center flex justify-end">
                                <div class="flex items-center gap-2">
                                    <a class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-white hover:bg-green-800 hover:text-white transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span>2° Via</span>
                                    </a>
                                    <a href="<?= url("/cartao/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Novo Cartão</span>
                                    </a>
                                </div>
                            </div>
    
                            <?= $this->insert("/card/requestCard"); ?>
                        <?php elseif ($menu === "solicitacao"): ?>
    
                            
                            <div class="ajax-update">
                                <?= $this->insert("/card/requestCard"); ?>
                            </div>
                        <?php elseif ($menu === "emergencial"): ?>
                            <?= $this->insert("/card/formEmergencyCard"); ?>
                        <?php elseif ($menu === "enviado"): ?>
                            <!-- header with options -->
                            
                            <div class="py-4 items-center flex justify-end">
                            <input id="checkall" type="checkbox" name="check-all">
                            <label for="checkall">Marcar todos</label>
                                <div class="flex items-center gap-2">
                                    <a href="<?= url("/cartao/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-white rounded-full hover:bg-green-800 hover:text-white transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span>2° Via</span>
                                    </a>
                                    <a href="<?= url("/cartao/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Novo Cartão</span>
                                    </a>
                                </div>
                            </div>
                            <div class="ajax-update">
                                <?= $this->insert("/card/sendCard"); ?>
                            </div>
                        <?php elseif ($menu === "cartao"): ?>
                            <!-- header with options -->
                            <div class="py-4 items-center flex justify-end">
                                <div class="flex items-center gap-2">
                                    <a href="<?= url("/cartao/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-white rounded-full hover:bg-green-800 hover:text-white transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span>2° Via</span>
                                    </a>
                                    <a href="<?= url("/cartao/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Novo Cartão</span>
                                    </a>
                                </div>
                            </div>
                            <div class="ajax-update">
                                <?= $this->insert("/card/activeCard"); ?>
                            </div>
                        <?php elseif ($menu === "listacartaoemergencial"): ?>
                            <!-- header with options -->
                            <div class="py-4 items-center flex justify-end">
                                <div class="flex items-center gap-2">
                                    <a href="<?= url("/cartao/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Novo Cartão Emergencial</span>
                                    </a>
                                </div>
                            </div>
                            <div class="ajax-update">
                                <?= $this->insert("/card/listCardEmergency"); ?>
                            </div>
                        <?php elseif ($menu === "recarga"): ?>
                            <!-- header with options -->
                            <div class="py-4 flex items-center justify-between">
    
                                <div class="flex flex-col gap-4">
                                    <!-- Search Field  -->
                                    <div class="flex items-center">
                                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                                        <button data-url="<?= url("/cartao/procurarrecarga") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- <div class="flex flex-col justify-center">
                                            <h1>Ano</h1>
                                            <select name="yearSearche" id="yearSearche" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($yearRecharge as $yearRechargeItem): ?>
                                                        <option value="<?= $yearRechargeItem->year_recharge ?>"><?= $yearRechargeItem->year_recharge ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Pagamento</h1>
                                            <select name="typePaymentSearch" id="typePaymentSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                <option value="1">Pagos</option>
                                                <option value="2">Recargas Agendadas</option>
                                                <option value="3">À Pagar</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Mês</h1>
                                            <select name="monthSearch" id="monthSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($monthRecharge as $monthRechargeItem): ?>
                                                        <option value="<?= $monthRechargeItem->month_recharge ?>"><?= fncMonthString($monthRechargeItem->month_recharge) ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Remessa</h1>
                                            <select name="shipment" id="shipment" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($shipmentRecharge as $shipmentRechargeItem): ?>
                                                        <option value="<?= $shipmentRechargeItem->shipment; ?>"><?= format_number((int)$shipmentRechargeItem->shipment, 2); ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div> -->
    
                                        <button data-url="<?= url("/cartao/procurarrecarga") ?>" id="cleaninput" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                            </svg>
                                            <span>Limpar filtros</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="<?= url("/cartao/recargacartao");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Recarga</span>
                                    </a>
                                    <a href="<?= url("/cartao/recargaextra");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Recarga Extra</span>
                                    </a>
                                </div>
                            </div>
    
                            <div class="ajax-update">
                                <?= $this->insert("/card/listRecharge"); ?>
                            </div>
                        <?php elseif ($menu === "recargageral"): ?>
                            <div class="ajax-update">
                                <?= $this->insert("/card/formRechargeAll"); ?>
                            </div>
                        <?php elseif ($menu === "recargaextra"): ?>
                            <div class="ajax-update">
                                <?= $this->insert("/card/formRechargeExtra"); ?>
                            </div>
                        <?php elseif ($menu === "segundavia"): ?>
                            <?= $this->insert("/card/formSecondCard"); ?>
                        <?php elseif ($menu === "beneficiario"): ?>
                            <div class="ajax-update">
                                <?= $this->insert("/card/listBenefit"); ?>
                            </div>
                        <?php elseif ($menu === "saldo"): ?>
                            <?= $this->insert("/card/listBalance"); ?>
                        <?php elseif ($menu === "recargaextrato"): ?>
                            <div><?= $recharge[0]->name_benefit; ?></div>
                            <?= $recharge[0]->cpf; ?>

                            <div class="py-4 flex items-center justify-between">
    
                                <div class="flex flex-col gap-4">
                                    <!-- Search Field  -->
                                    <div class="flex items-center">
                                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                                        <button data-url="<?= url("/cartao/procurarrecargabeneficiario") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- <div class="flex flex-col justify-center">
                                            <h1>Ano</h1>
                                            <select name="yearSearche" id="yearSearche" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($yearRecharge as $yearRechargeItem): ?>
                                                        <option value="<?= $yearRechargeItem->year_recharge ?>"><?= $yearRechargeItem->year_recharge ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Pagamento</h1>
                                            <select name="typePaymentSearch" id="typePaymentSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                <option value="1">Pagos</option>
                                                <option value="2">Recargas Agendadas</option>
                                                <option value="3">À Pagar</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Mês</h1>
                                            <select name="monthSearch" id="monthSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($monthRecharge as $monthRechargeItem): ?>
                                                        <option value="<?= $monthRechargeItem->month_recharge ?>"><?= fncMonthString($monthRechargeItem->month_recharge) ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Remessa</h1>
                                            <select name="shipment" id="shipment" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($shipmentRecharge as $shipmentRechargeItem): ?>
                                                        <option value="<?= $shipmentRechargeItem->shipment; ?>"><?= format_number((int)$shipmentRechargeItem->shipment, 2); ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div> -->
    
                                        <button data-url="<?= url("/cartao/procurarrecargabeneficiario") ?>" name="" id="cleaninput" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                            </svg>
                                            <span>Limpar filtros</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
    
                            <div class="ajax-update">
                                <?= $this->insert("/card/listRechargeExtract"); ?>
                            </div>
                        <?php elseif ($menu === "cartaobaneficiario"): ?>
                            <div><?= $card[0]->name_benefit; ?></div>
                            <?= $card[0]->cpf; ?>

                            <div class="py-4 flex items-center justify-between">
    
                                <div class="flex flex-col gap-4">
                                    <!-- Search Field  -->
                                    <div class="flex items-center">
                                        <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                                        <button data-url="<?= url("/cartao/procurarrecarga") ?>" id="search-all" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- <div class="flex flex-col justify-center">
                                            <h1>Ano</h1>
                                            <select name="yearSearche" id="yearSearche" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($yearRecharge as $yearRechargeItem): ?>
                                                        <option value="<?= $yearRechargeItem->year_recharge ?>"><?= $yearRechargeItem->year_recharge ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Pagamento</h1>
                                            <select name="typePaymentSearch" id="typePaymentSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                <option value="1">Pagos</option>
                                                <option value="2">Recargas Agendadas</option>
                                                <option value="3">À Pagar</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Mês</h1>
                                            <select name="monthSearch" id="monthSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($monthRecharge as $monthRechargeItem): ?>
                                                        <option value="<?= $monthRechargeItem->month_recharge ?>"><?= fncMonthString($monthRechargeItem->month_recharge) ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h1>Remessa</h1>
                                            <select name="shipment" id="shipment" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                                <option value="">Selecione</option>
                                                    <?php foreach($shipmentRecharge as $shipmentRechargeItem): ?>
                                                        <option value="<?= $shipmentRechargeItem->shipment; ?>"><?= format_number((int)$shipmentRechargeItem->shipment, 2); ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div> -->
    
                                        <button name="" id="" class="flex items-center gap-2 text-white font-semibold bg-blue-500 rounded-md py-2 px-3 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                            </svg>
                                            <span>Limpar filtros</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
    
                            <div class="ajax-update">
                                <?= $this->insert("/card/listCardBenefit"); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php $this->start("scripts"); ?>
    <script type="module" src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
    <script type="module" src="<?= theme("/js/card/card.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>
<script>
    
    const vUrlPage =  window.location.pathname.replace(/\/$/, "").split("/").pop();
    const vUrlPageSub = window.location.pathname.replace(/\/$/, "").split("/");

    const novo = document.getElementsByClassName("novo");
    const emergencial = document.getElementsByClassName("emergencial");
    const via = document.getElementsByClassName("2_via");
    const recarga = document.getElementsByClassName("recarga");
    const recarga_extra = document.getElementsByClassName("recarga_extra");
    const benefit = document.getElementsByClassName("beneficiario");
    const balance = document.getElementsByClassName("saldo");

    const solicitado = document.getElementsByClassName("solicitado");
    const enviado = document.getElementsByClassName("enviado");
    const cartaoativo = document.getElementsByClassName("cartaoativo");

    if (vUrlPage === 'novocartao') {
<<<<<<< HEAD
       novo[0].classList.add('border-b-4', 'border-gray-900', 'text-gray-800'); 
       solicitado[0].classList.add('border-b-4', 'border-gray-900', 'text-gray-800');
    } 
      else if (vUrlPage === 'solicitaremergencial') {
        emergencial[0].classList.add('border-b-4', 'border-gray-900', 'text-gray-800'); 
        novo[0].classList.remove('border-b-4', 'border-gray-900', 'text-gray-800');
=======
       novo[0].classList.add('border-b-2', 'border-green-500', 'text-white'); 
       solicitado[0].classList.add('border-b-2', 'border-green-500', 'text-white'); 
    } else if (vUrlPage === 'solicitaremergencial') {
        emergencial[0].classList.add('border-b-2', 'border-green-500', 'text-white'); 
        emergencial[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.remove('border-b-2', 'border-green-500', 'text-white');
>>>>>>> 948986fb10da7f4cda56072d70ef7575b75e6641
    }
      else if (vUrlPage === 'cartaoemergencial') {
        novo[0].classList.remove('border-b-4', 'border-gray-900', 'text-gray-800');   
        emergencial[0].classList.add('border-b-4', 'border-gray-900', 'text-gray-800');
    }
      else if (vUrlPage === 'segundavia') {
        via[0].classList.add('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPage === 'recarga') {
        recarga[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.remove('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPage === 'beneficiario') {
        benefit[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.remove('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPageSub[3] === 'recargabeneficiario') {
        benefit[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.remove('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPageSub[3] === 'cardsbeneficiario') {
        benefit[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.remove('border-b-2', 'border-green-500', 'text-white');
    }
        else if (vUrlPage === 'atualizarsaldo') {
        balance[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.remove('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPage === 'recargaextra') {
        recarga_extra[0].classList.add('border-b-2', 'border-green-500', 'text-white');
    }
    // bottom options
      else if (vUrlPage === 'solicitado') {
        solicitado[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.add('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPage === 'enviado') {
        enviado[0].classList.add('border-b-2', 'border-green-500', 'text-white');
        novo[0].classList.add('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPage === 'cartaoativo') {
        cartaoativo[0].classList.add('border-b-2', 'border-green-500', 'text-white'); 
        novo[0].classList.add('border-b-2', 'border-green-500', 'text-white');
    }
      else if (vUrlPage === 'solicitado') {
        solicitato[0].classList.remove('text-gray-700'); 
        solicitato[0].classList.add('text-white'); 
        novo[0].classList.add('border-b-2', 'border-green-500', 'text-white');
    }
</script>