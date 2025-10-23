<?php $this->layout("layout"); ?>
<div class="flex flex-col h-screen w-screen md:w-auto">
    <div class="sidebar" data-menu="cartao"></div>
    <header class="p-4 px-6 flex justify-start mt-8 md:mt-0">
        <h1 class="font-semibold text-black">Cartão Alimentação</h1>
    </header>

    <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0">
        <div class="flex flex-col md:flex-row px-6">
            <a href="<?= url("/novocartao");?>" class="main-card-menu novo py-1 px-4 text-gray-600 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full bg-green-100 text-black border border-green-500">Novo</a>
            <a href="<?= url("/solicitaremergencial");?>" class="main-card-menu emergencial py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Emergencial</a>
            <a href="<?= url("/recarga");?>" class="main-card-menu recarga py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Recarga</a>
        </div>
    </header>

    <?php if($menu === "novocartao"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
            <div class="flex flex-col md:flex-row px-6"> 
                <a href="<?= url("/solicitado");?>" class="solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif($menu === "segundavia"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
            <div class="flex flex-col md:flex-row px-6"> 
                <a href="<?= url("/solicitado");?>" class="solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "novo"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
            <div class="flex flex-col md:flex-row px-6"> 
                <a href="<?= url("/solicitado");?>" class="main-card-menu novo py-1 px-4 text-gray-600 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full bg-green-100 text-black border border-green-500">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "solicitacao"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
            <div class="flex flex-col md:flex-row px-6"> 
                <a href="<?= url("/solicitado");?>" class="main-card-menu novo py-1 px-4 text-gray-600 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full bg-green-100 text-black border border-green-500">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "emergencial"): ?>
    <?php elseif ($menu === "enviado"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
            <div class="flex flex-col md:flex-row px-6"> 
                <a href="<?= url("/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "cartao"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
            <div class="flex flex-col md:flex-row px-6"> 
                <a href="<?= url("/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "listacartaoemergencial"): ?>
    <?php endif; ?>

    <main class="p-6 px-0 h-full">
        <div class="bg-white overflow-hidden">

            <!-- Table -->
            <div class="p-6 hidden md:block overflow-x-auto">
                <div class="content-ajax">
                    <?php if($menu === "novocartao"): ?>
                        <?= $this->insert("/card/formNewCard"); ?>
                    <?php elseif ($menu === "novo"): ?>

                        <!-- header with options -->
                        <div class="p-6 items-center flex justify-end border-t border-gray-300">
                            <div class="flex items-center gap-2">
                                <a class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-md hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Novo Cartão</span>
                                </a>
                            </div>
                        </div>

                        <?= $this->insert("/card/requestCard"); ?>
                    <?php elseif ($menu === "solicitacao"): ?>

                        <!-- header with options -->
                        <div class="p-6 items-center flex justify-end border-t border-gray-300">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-md hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Novo Cartão</span>
                                </a>
                            </div>
                        </div>

                        <?= $this->insert("/card/requestCard"); ?>
                    <?php elseif ($menu === "emergencial"): ?>
                        <?= $this->insert("/card/formEmergencyCard"); ?>
                    <?php elseif ($menu === "enviado"): ?>
                        <!-- header with options -->
                        <div class="p-6 items-center flex justify-end border-t border-gray-300">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-md hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Novo Cartão</span>
                                </a>
                            </div>
                        </div>

                        <?= $this->insert("/card/sendCard"); ?>
                    <?php elseif ($menu === "cartao"): ?>
                        <!-- header with options -->
                        <div class="p-6 items-center flex justify-end border-t border-gray-300">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-md hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Novo Cartão</span>
                                </a>
                            </div>
                        </div>
                        <?= $this->insert("/card/activeCard"); ?>
                    <?php elseif ($menu === "listacartaoemergencial"): ?>
                        <!-- header with options -->
                        <div class="p-6 items-center flex justify-end border-t border-gray-300">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Novo Cartão Emergencial</span>
                                </a>
                            </div>
                        </div>
                        <?= $this->insert("/card/listCardEmergency"); ?>
                    <?php elseif ($menu === "recarga"): ?>
                        <!-- header with options -->
                        <div class="p-6 items-center flex justify-end border-t border-gray-300">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Recarga</span>
                                </a>
                                <a href="<?= url("/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-md cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Recarga Extra</span>
                                </a>
                            </div>
                        </div>
                        <?= $this->insert("/card/listRecharge"); ?>
                    <?php elseif ($menu === "segundavia"): ?>
                        <?= $this->insert("/card/formSecondCard"); ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile -->
            <div class="md:hidden p-4 space-y-4">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                        <h3 class="font-medium text-gray-900">Fulano de tal</h3>
                        <p class="text-sm text-gray-600">123.456.789-10</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-3">
                        <div class="text-center">
                        <label class="block text-xs text-gray-500 mb-1">Positiva</label>
                        <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div class="text-center">
                        <label class="block text-xs text-gray-500 mb-1">Negativa</label>
                        <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div class="text-center">
                        <label class="block text-xs text-gray-500 mb-1">Sem resposta</label>
                        <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                <!-- more here -->
            </div>
        </div>
    </main>
</div>
<script>
    
    const vUrlPage =  window.location.pathname.replace(/\/$/, "").split("/").pop();
    
    const novo = document.getElementsByClassName("novo");
    const emergencial = document.getElementsByClassName("emergencial");
    const via = document.getElementsByClassName("2_via");
    const recarga = document.getElementsByClassName("recarga");
    const recarga_extra = document.getElementsByClassName("recarga_extra");

    const solicitado = document.getElementsByClassName("solicitado");
    const enviado = document.getElementsByClassName("enviado");

    if (vUrlPage === 'novocartao') {
       novo[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
    } else if (vUrlPage === 'solicitaremergencial') {
        emergencial[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
        emergencial[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500');
    }
      else if (vUrlPage === 'segundavia') {
        via[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500');
    }
      else if (vUrlPage === 'recarga') {
        recarga[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500');
    }
      else if (vUrlPage === 'recargaextra') {
        recarga_extra[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500');
    }
    // bottom options
      else if (vUrlPage === 'solicitado') {
        solicitado[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
        novo[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
    }
      else if (vUrlPage === 'enviado') {
        enviado[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
        novo[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
    }
      else if (vUrlPage === 'enviado') {
        enviado[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
        novo[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
    }
</script>

<?php $this->start("scripts"); ?>
    <script src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>