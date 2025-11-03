<?php $this->layout("layout"); ?>
<div class="flex flex-col h-screen max-h-screen overflow-hidden w-screen md:w-auto">
    <div class="sidebar" data-menu="cartao"></div>
    <header class="py-6 px-6 flex justify-start bg-green-700 mb-4">
        <h1 class="font-semibold text-white text-4xl uppercase">Cartão Alimentação</h1>
    </header>

    <header class="w-screen md:w-auto md:flex md:justify-start flex flex-col py-3 px-6 gap-3">
        <h1 class="uppercase text-light text-gray-500">Fitrar por status gerais</h1>
        <div class="flex flex-col md:flex-row">
            <a href="<?= url("/novocartao");?>" class="main-card-menu novo py-1 px-4 text-gray-600 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full bg-green-700 text-white">Novo</a>
            <a href="<?= url("/solicitaremergencial");?>" class="main-card-menu emergencial py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Emergencial</a>
            <a href="<?= url("/recarga");?>" class="main-card-menu recarga py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Recarga</a>
        </div>
    </header>

    <?php if($menu === "novocartao"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3 flex flex-col gap-3">
            <h1 class="uppercase text-light text-gray-500">Filtros específicos</h1>
            <div class="flex flex-col md:flex-row"> 
                <a href="<?= url("/solicitado");?>" class="solicitado py-1 px-4 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full text-gray-600 solicitado text-white">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif($menu === "segundavia"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
            <h1 class="uppercase text-light text-gray-500">Filtros específicos</h1>
            <div class="flex flex-col md:flex-row"> 
                <a href="<?= url("/solicitado");?>" class="solicitado py-1 px-4 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full text-gray-600 solicitado text-white">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "novo"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
            <h1 class="uppercase text-light text-gray-500">Filtros específicos</h1>
            <div class="flex flex-col md:flex-row"> 
                <a href="<?= url("/solicitado");?>" class="main-card-menu novo py-1 px-4 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full bg-green-700 text-black text-gray-600 solicitado text-white">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "solicitacao"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
            <h1 class="uppercase text-light text-gray-500">Filtros específicos</h1>
            <div class="flex flex-col md:flex-row"> 
                <a href="<?= url("/solicitado");?>" class="main-card-menu novo py-1 px-4 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full bg-green-700 text-gray-600 solicitado">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "emergencial"): ?>
    <?php elseif ($menu === "enviado"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
            <h1 class="uppercase text-light text-gray-500">Filtros específicos</h1>
            <div class="flex flex-col md:flex-row"> 
                <a href="<?= url("/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer  font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full text-gray-600 solicitado">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="cartaoativo second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "cartao"): ?>
        <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 py-3 px-6 flex flex-col gap-3">
            <h1 class="uppercase text-light text-gray-500">Filtros específicos</h1>
            <div class="flex flex-col md:flex-row"> 
                <a href="<?= url("/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full text-gray-600 solicitado">Solicitados</a>
                <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
                <a href="<?= url("/cartaoativo"); ?>" class="cartaoativo second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
            </div>
        </header>
    <?php elseif ($menu === "listacartaoemergencial"): ?>
    <?php endif; ?>

    <main class="h-full overflow-hidden overflow-y-auto p-6">
        <div class="bg-white">
            <!-- Table -->
            <div class="p-6 px-0 hidden md:block">
                <div class="content-ajax h-full ">
                    <?php if($menu === "novocartao"): ?>
                        <?= $this->insert("/card/formNewCard"); ?>
                    <?php elseif ($menu === "novo"): ?>

                        <!-- header with options -->
                        <div class="py-4 items-center flex justify-end">
                            <div class="flex items-center gap-2">
                                <a class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-full hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
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
                        <div class="py-4 items-center flex justify-end">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-full hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
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
                        <div class="py-4 items-center flex justify-end">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-full hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
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
                        <div class="py-4 items-center flex justify-end">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/solicitarsegundaviacartao") ?>" class="flex gap-1 items-center py-2 px-3 border border-gray-400 cursor-pointer text-gray-800 rounded-full hover:bg-green-800 hover:text-white transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>2° Via</span>
                                </a>
                                <a href="<?= url("/solicitarnovocartao") ?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
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
                        <div class="py-4 items-center flex justify-end">
                            <div class="flex items-center gap-2">
                                <a href="<?= url("/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
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
                        <div class="py-4 flex items-center justify-between">
                    
                            <div class="flex flex-col gap-4">
                                <!-- Search Field  -->
                                <div class="flex items-center">
                                    <input name="recipientname" id="recipientname" type="text" class="input-search w-full pr-6 py-2 px-3 border border-gray-400 rounded-l-md" placeholder="Pesquisar Beneficiários...">
                                    <button data-url="<?= url("/procurarrecarga") ?>" class="py-2 px-4 cursor-pointer border border-gray-400 bg-gray-100 rounded-r-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex flex-col justify-center">
                                        <h1>Ano</h1>
                                        <select name="yearSearche" id="yearSearche" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                            <option value="0">Selecione</option>
                                                <?php foreach($yearRecharge as $yearRechargeItem): ?>
                                                    <option value="<?= $yearRechargeItem->year_recharge ?>"><?= $yearRechargeItem->year_recharge ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h1>Pagamento</h1>
                                        <select name="typePaymentSearch" id="typePaymentSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                            <option value="0">Selecione</option>
                                            <option value="1">Pagos</option>
                                            <option value="2">Recargas Agendadas</option>
                                            <option value="3">À Pagar</option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h1>Mês</h1>
                                        <select name="monthSearch" id="monthSearch" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                            <option value="0">Selecione</option>
                                                <?php foreach($monthRecharge as $monthRechargeItem): ?>
                                                    <option value="<?= $monthRechargeItem->month_recharge ?>"><?= fncMonthString($monthRechargeItem->month_recharge) ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h1>Remessa</h1>
                                        <select name="shipment" id="shipment" class="input-search bg-gray-100 pr-6 py-1 px-3 cursor-pointer border border-gray-200">
                                            <option value="">Selecione</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="<?= url("/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Recarga</span>
                                </a>
                                <a href="<?= url("/cartaoemergencial");?>" class="flex gap-1 items-center py-2 px-3 text-white rounded-full cursor-pointer bg-green-800 hover:bg-green-900 transition-all duration-200">
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
    const cartaoativo = document.getElementsByClassName("cartaoativo");

    if (vUrlPage === 'novocartao') {
       novo[0].classList.add('bg-green-700', 'text-white'); 
       solicitado[0].classList.add('bg-green-700', 'text-white'); 
    } else if (vUrlPage === 'solicitaremergencial') {
        emergencial[0].classList.add('bg-green-700', 'text-white'); 
        emergencial[0].classList.add('bg-green-700', 'text-white');
        novo[0].classList.remove('bg-green-700', 'text-white');
    }
      else if (vUrlPage === 'segundavia') {
        via[0].classList.add('bg-green-700', 'text-white');
    }
      else if (vUrlPage === 'recarga') {
        recarga[0].classList.add('bg-green-700', 'text-white');
        novo[0].classList.remove('bg-green-700', 'text-white');
    }
      else if (vUrlPage === 'recargaextra') {
        recarga_extra[0].classList.add('bg-green-700', 'text-white');
    }
    // bottom options
      else if (vUrlPage === 'solicitado') {
        solicitado[0].classList.add('bg-green-700', 'text-white');
        novo[0].classList.add('bg-green-700', 'text-white');
    }
      else if (vUrlPage === 'enviado') {
        enviado[0].classList.add('bg-green-700', 'text-white');
        novo[0].classList.add('bg-green-700', 'text-white');
    }
      else if (vUrlPage === 'cartaoativo') {
        cartaoativo[0].classList.add('bg-green-700', 'text-white'); 
        novo[0].classList.add('bg-green-700', 'text-white');
    }
      else if (vUrlPage === 'solicitado') {
        solicitato[0].classList.remove('text-gray-700'); 
        solicitato[0].classList.add('text-white'); 
        novo[0].classList.add('bg-green-700', 'text-white');
    }
</script>

<?php $this->start("scripts"); ?>
    <script src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>