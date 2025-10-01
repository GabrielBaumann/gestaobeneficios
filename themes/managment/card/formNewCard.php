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
                    <label for="bene" class="text-gray-800 font-semibold">Beneficiário</label>
                    <input type="text" name="person-benefit" class="w-full border border-gray-300 p-2 rounded-xs">
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
                    <input type="text" name="technician" placeholder="Técnico" class="w-full border border-gray-300 p-2 rounded-xs">
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