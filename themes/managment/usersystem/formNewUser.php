<?php $this->layout("layout"); ?>
<div class="flex items-center mx-auto max-w-[960px] h-full" data-menu="usuario">
    
    <form 
        data-confirm="true" 
        data-message="Tem cerceza que deseja fazer essa solicitação?" 
        action="<?= url("/usuario/usuario") ?>" 
        method="post" 
        class="w-full p-4 flex flex-col gap-12"
    >
    
    <?= csrf_input(); ?>
        <div class="flex flex-col gap-2">
            <h1 class="text-xl font-semibold text-white">Novo Usuário</h1>
            <p class="text-white">Preencha as seguintes informações</p>
            <span class="bg-gray-700 h-[3px] w-full"></span>
        </div>

        <div class="flex flex-col gap-4">
            <!-- in this div i can put many inputs i want that appears side to side on desktop -->

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="name-user" class="text-white font-semibold">Nome *</label>
                    <input type="text" name="name-user" id="name-user" class="clean-input-text w-[300px] p-2 rounded-xs rounded-r-none bg-white/20 text-white font-semibold">
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="document" class="text-white font-semibold">CPF *</label>
                    <input type="text" data-url="<?=  url("/usuario/verificarcpf"); ?>" name="document" id="document" class="clean-cpf w-[300px] p-2 rounded-xs rounded-r-none bg-white/20 text-white font-semibold">
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="date-birth" class="text-white font-semibold">Data de nascimento *</label>
                    <input type="date" name="date-birth" id="date-birth" class="w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
                </div>
                <div class="flex flex-col w-full">
                    <label for="email" class="text-white font-semibold">E-mail *</label>
                    <input type="email" data-url="<?=  url("/usuario/verificaremail"); ?>" name="email" id="email" placeholder="fulano@gmail.com" class="clean-email w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
                </div>
            </div>
            
            <div class="flex flex-col w-full">
                <label for="phone" class="text-white font-semibold">Telefone *</label>
                <input type="text"  name="phone" id="phone" placeholder="(94) 99999-9999" class="clean-input-phone w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
            </div>

            <label for="unit" class="text-white font-semibold">Unidade *</label>
                <select type="text" name="unit" id="unit" class="rounded-xs w-full p-2 bg-white/20 text-white font-semibold">
                    <option value="">Selecione</option>
                    <option value="1">CED</option>
                    <option value="2">SEMDES</option>
                    <option value="3">CRAS NOVO BRASIL</option>
                </select>
            </div>


            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="type-access" class="text-white font-semibold">Tipo de acesso *</label>
                    <select type="text" name="type-access" id="type-access" class="rounded-xs w-full p-2 bg-white/20 text-white font-semibold">
                        <option value="">Selecione</option>
                        <option value="MANUTENÇÃO">MANUTENÇÃO</option>
                        <option value="COORDENADORIA">COORDENADORIA</option>
                        <option value="MEDIO">MEDIO</option>
                        <option value="MEDIO">TECNICO</option>
                    </select>
                </div>

                <div class="flex flex-col w-full">
                    <label for="function-unit" class="text-white font-semibold">Função na unidade *</label>
                    <select type="text" name="function-unit" id="function-unit" class="rounded-xs w-full p-2 bg-white/20 text-white font-semibold">
                        <option value="">Selecione</option>
                        <option value="1">ANALISTA</option>
                        <option value="2">COORDENADORIA</option>
                        <option value="3">AUXILIAR ADMINISTRATIVA</option>
                        <option value="4">PEDAGOGO(A)</option>
                        <option value="5">ASSISTENTE SOCIAL</option>
                    </select>
                </div>
            <div class="flex justify-end">

            <button class="rounded-xs bg-green-700 text-white font-semibold px-6 py-2 cursor-pointer hover:bg-green-800">
                <span>Salvar</span>
            </button>
            </div>

        </div>

    </form>

</div>
<?php $this->start("scripts"); ?>
    <script type="module" src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>