<div class="flex items-center mx-auto bg-white max-w-[960px] h-full" data-menu="cartao">
    
    <form action="<?= url("/solicitarcartao") ?>" method="post" class="w-full p-4 flex flex-col gap-12">
    <?= csrf_input(); ?>
        <div class="flex flex-col gap-2">
            <h1 class="text-xl font-semibold">Solicitação de Cartão</h1>
            <p>Preencha as seguintes informações</p>
            <span class="bg-gray-200 h-[3px] w-full"></span>
        </div>

        <div class="flex flex-col gap-4">
            <!-- in this div i can put many inputs i want that appears side to side on desktop -->
            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="bene" class="text-gray-800 font-semibold">CPF</label>
                    <div class="flex gap-2">
                        <input type="text" class="w-[300px] border border-gray-300 p-2 rounded-xs">
                        <button class="cursor-pointer bg-gray-100 p-2 rounded-md hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="bene" class="text-gray-800 font-semibold">Beneficiário</label>
                    <select class="w-full border border-gray-300 p-2 rounded-xs">
                        <option value="">Selecione</option>
                        <option value="">Teste</option>
                        <option value="">AAAA</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="tec" class="text-gray-800 font-semibold">Mês inicio</label>
                    <input type="text" name="month-start" placeholder="Mês de início" class="w-full border border-gray-300 p-2 rounded-xs">
                </div>
                <div class="flex flex-col w-full">
                    <label for="tec" class="text-gray-800 font-semibold">Mês fim</label>
                    <input type="text" name="month-end" placeholder="Mês de fim" class="w-full border border-gray-300 p-2 rounded-xs">
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="tec" class="text-gray-800 font-semibold">Técnico(a)</label>
                    <select type="text" name="technician" placeholder="Técnico" class="w-full border border-gray-300 p-2 rounded-xs">
                        <option value="">Selecione</option>
                    </select>
                </div>

                <div class="flex flex-col w-full">
                    <label for="data" class="text-gray-800 font-semibold">Data da Solicitação</label>
                    <input type="date" name="date-request" placeholder="data" class="w-full border border-gray-300 p-2 rounded-xs">
                </div>
            </div>

            <div class="flex justify-end">
            <button class="rounded-md bg-green-700 text-white font-semibold px-6 py-2 cursor-pointer hover:bg-green-800">
                <span>Salvar</span>
            </button>
            </div>

        </div>

    </form>

</div>