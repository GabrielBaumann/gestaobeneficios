<?php $this->layout("layout"); ?>
<div class="flex flex-col h-screen w-screen md:w-auto">
    <div class="sidebar" data-menu="cartao"></div>
    <header class="p-4 px-6 flex justify-start mt-8 md:mt-0">
        <h1 class="font-semibold text-black">Cartão Alimentação</h1>
    </header>

    <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0">
        <div class="flex flex-col md:flex-row px-6">
            <a href="<?= url("/novocartao");?>" class="main-card-menu novo py-1 px-4 text-gray-600 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Novo</a>
            <a href="<?= url("/solicitaremergencial");?>" class="main-card-menu emergencial py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Emergencial</a>
            <a href="" class="main-card-menu 2_via py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">2° Via</a>
            <a href="" class="main-card-menu recarga py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Recarga</a>
            <a href="" class="main-card-menu recarga_extra py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Recarga extra</a> 
        </div>
    </header>

    <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
        <div class="flex flex-col md:flex-row px-6"> 
            <a href="<?= url("/solicitado");?>" class="second-card-menu solicitado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Solicitados</a>
            <a href="<?= url("/enviado");?>" class="second-card-menu enviado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
            <a href="" class="second-card-menu recarga py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Recarga</a>
            <a href="" class="second-card-menu carregado py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Carregados</a>
            <a href="<?= url("/cartaoativo"); ?>" class="second-card-menu cartao py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Cartões</a>
        </div>
    </header>
 
    <main class="p-6 h-full">
        <div class="bg-white overflow-hidden">
        <!-- Table -->
        <div class="hidden md:block overflow-x-auto">
            <div class="content-ajax">
                <?php if($menu === "novocartao"): ?>
                    <?= $this->insert("/card/formNewCard"); ?>
                <?php elseif ($menu === "soliticao"): ?>
                    <?= $this->insert("/card/requestCard"); ?>
                <?php elseif ($menu === "emergencial"): ?>
                    <?= $this->insert("/card/formEmergencyCard"); ?>
                <?php elseif ($menu === "enviado"): ?>
                    <?= $this->insert("/card/sendCard"); ?>
                <?php elseif ($menu === "cartao"): ?>
                    <?= $this->insert("/card/activeCard"); ?>
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
    }
      else if (vUrlPage === 'solicitado') {
        solicitado[0].classList.add('bg-green-100', 'text-black', 'border', 'border-green-500'); 
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