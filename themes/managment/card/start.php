<?php $this->layout("layout"); ?>
<div class="flex flex-col h-screen w-screen md:w-auto">

    <header class="p-4 px-6 flex justify-start mt-8 md:mt-0">
        <h1 class="font-semibold text-black">Cartão Alimentação</h1>
    </header>

    <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0">
        <div class="flex flex-col md:flex-row px-6"> 
            <a href="" class="py-1 px-4 text-sm cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-green-800 bg-green-100 rounded-full border border-green-500">Novo</a>
            <a href="" class="py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Emergencial</a>
            <a href="" class="py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">2° Via</a>
            <a href="" class="py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Recarga</a>
            <a href="" class="py-1 px-4 text-sm cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto rounded-full">Recarga extra</a> 
        </div>
    </header>

    <header class="w-screen md:w-auto md:flex md:justify-start mt-6 md:mt-0 pt-2">
        <div class="flex flex-col md:flex-row px-6"> 
            <a href="" class="py-1 px-4 cursor-pointer font-semibold duration-all transition-300 w-full md:w-auto text-green-800 text-sm rounded-full bg-green-100 border border-green-500">Solicitados</a>
            <a href="" class="py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Enviados</a>
            <a href="" class="py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Recarga</a>
            <a href="" class="py-1 px-4 cursor-pointer text-gray-600 font-semibold duration-all transition-300 w-full md:w-auto text-sm rounded-full">Carregados</a>
        </div>
    </header>
 
    <main class="p-6 h-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Table -->
        <div class="hidden md:block overflow-x-auto">
            <form action="<?= url("/enivarcartaounidade"); ?>" method="post">
                <?= csrf_input(); ?>
                <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Id</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nome</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">CPF</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Positiva</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Negativa</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Sem resposta</th>
                    </tr>
                </thead>
                <?php $count = 1; ?>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach($listCardName as $listCardNameItem):?>
                        <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-800"><?= $listCardNameItem->id_card_request; ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= $listCardNameItem->name; ?></td>
                        <td class="py-3 px-4 text-sm text-gray-600"><?= $listCardNameItem->cpf; ?></td>
                        <td class="py-3 px-4 text-center">
                            <input type="checkbox" name="received-<?= $count ++; ?>" value="<?= fncEncrypt($listCardNameItem->id_card_request); ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="py-3 px-4 text-center">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="py-3 px-4 text-center">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        </tr>
                    <?php endforeach;?>
                    <!-- More lines -->
                </tbody>
                </table>
                <button>Enviar Selecionados</button>
            </form>
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
<?php $this->start("scripts"); ?>
    <script src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>