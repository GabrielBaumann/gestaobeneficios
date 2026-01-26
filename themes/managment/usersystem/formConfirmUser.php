<?php $this->layout("layout"); ?>
<div class="flex items-center mx-auto max-w-[960px] h-full" data-menu="usuario">
    
    <form 
        action="<?= url("/usuario/confirmarcadastro") ?>" 
        method="post" 
        class="w-full p-4 flex flex-col gap-12"
    >
    
    <?= csrf_input(); ?>
        <div class="flex flex-col gap-2">
            <h1 class="text-xl font-semibold text-white">Confirme seu cadastro</h1>
            <p class="text-white">Crie uma nova senha</p>
            <span class="bg-gray-700 h-[3px] w-full"></span>
        </div>

        <div class="flex flex-col gap-4">
            <!-- in this div i can put many inputs i want that appears side to side on desktop -->

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="name-user" class="text-white font-semibold">Nome *</label>
                    <input type="text" value="<?= $usersystem->name_full; ?>" id="name-user" class="clean-input-text w-[300px] p-2 rounded-xs rounded-r-none bg-white/20 text-white font-semibold">
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="document" class="text-white font-semibold">CPF *</label>
                    <input type="text" value="<?=  $usersystem->cpf; ?>" id="document" class="clean-cpf w-[300px] p-2 rounded-xs rounded-r-none bg-white/20 text-white font-semibold">
                </div>
            </div>

            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="email" class="text-white font-semibold">E-mail *</label>
                    <input type="text" value="<?=  $usersystem->email; ?>" id="email" class="clean-cpf w-[300px] p-2 rounded-xs rounded-r-none bg-white/20 text-white font-semibold">
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row w-full gap-4">
                <div class="flex flex-col w-full">
                    <label for="password" class="text-white font-semibold">Senha *</label>
                    <input type="password" name="password" id="password" placeholder="*****" class="w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
                </div>
                <div class="flex flex-col w-full">
                    <label for="password-confirm" class="text-white font-semibold">Confirmar Senha *</label>
                    <input type="password" name="password-confirm" id="password-confirm" placeholder="*****" class="clean-email w-full p-2 bg-white/20 text-white font-semibold rounded-xs">
                </div>
            </div>
            
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