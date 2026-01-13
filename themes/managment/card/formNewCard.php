<div class="flex items-center mx-auto max-w-[960px] h-full" data-menu="cartao">
    
    <form 
        data-confirm="true" 
        data-message="Tem cerceza que deseja fazer essa solicitação?" 
        action="<?= url("/cartao/solicitarcartao") ?>" 
        method="post" 
        class="w-full p-4 flex flex-col gap-12"
    >
    
    <?= csrf_input(); ?>
        <div class="flex flex-col gap-2">
            <h1 class="text-xl font-semibold text-white">Solicitação de Cartão</h1>
            <p class="text-white">Preencha as seguintes informações</p>
            <span class="bg-gray-700 h-[3px] w-full"></span>
        </div>

        <div class="flex flex-col gap-4">
            <!-- in this div i can put many inputs i want that appears side to side on desktop -->
            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="bene" class="text-white font-semibold">CPF</label>
                    <div class="flex items-center">
                        <input type="text" class="w-[300px] p-2 rounded-xs rounded-r-none bg-white/20 text-white font-semibold">
                        <button class="cursor-pointer p-2 rounded-r-full text-white bg-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="person-benefit" class="text-white font-semibold">Beneficiário *</label>
                        <select name="person-benefit" id="person-benefit" class="w-full p-2 bg-white/20 text-white font-semibold">
                            <option value="">Selecione</option>
                            <?php foreach($personbenefit as $personbenefititem): ?>    
                                <option value="<?= $personbenefititem->id_person_benefit; ?>"><?= $personbenefititem->name_benefit; ?></option>
                            <?php endforeach; ?>
                        </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="month-start" class="text-white font-semibold">Mês inicio *</label>
                    <input type="text" name="month-start" id="month-start" placeholder="Mês de início" class="w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
                </div>
                <div class="flex flex-col w-full">
                    <label for="month-end" class="text-white font-semibold">Mês fim *</label>
                    <input type="text" name="month-end" id="month-end" placeholder="Mês de fim" class="w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="technician" class="text-white font-semibold">Técnico(a) *</label>
                    <select type="text" name="technician" id="technician" placeholder="Técnico" class="rounded-xs w-full p-2 bg-white/20 text-white font-semibold">
                        <option value="">Selecione</option>
                        <option value="1">LUCAS DOS SANTOS SILVA</option>
                        <option value="2">ALDENORA BAIA</option>
                        <option value="3">KARINA COSTA BARROS</option>
                        <option value="4">GABRIEL</option>
                    </select>
                </div>

                <div class="flex flex-col w-full">
                    <label for="date-request" class="text-white font-semibold">Data da Solicitação *</label>
                    <input type="date" name="date-request" id="date-request" placeholder="data" class="rounded-xs w-full p-2 bg-white/20 text-white font-semibold">
                </div>
            </div>

            <div class="flex justify-end">
            <button class="rounded-xs bg-green-700 text-white font-semibold px-6 py-2 cursor-pointer hover:bg-green-800">
                <span>Salvar</span>
            </button>
            </div>

        </div>

    </form>

</div>