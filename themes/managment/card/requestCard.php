<?php if (!empty($listCardName)): ?>
    <header class="pb-3 flex items-center justify-start">
        <div class="flex flex-col">
            <h1 class="text-white">Filtrar por mês</h1>
            <select name="date-month" id="" class="py-2 px-3 bg-gray-800 text-white cursor-pointer rounded-xs">
                <option value="">Selecione</option>
                <?php foreach($monthAll as $monthAllItem): ?>
                    <option value="<?= $monthAllItem; ?>"><?= $monthAllItem; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </header>
    <table class="w-full bg-white/10 md:max-h-[400px] rounded-md overflow-y-auto">
        <thead class="rounded-t-md">
        <?php if (!empty($listCardName)): ?>
            <?php foreach($listCardName as $listCardNameItem):?>
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Recarga</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Cartão</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-black/60">
                
                    <tr>
                        <td class="py-3 px-4  text-sm text-white"><?= $listCardNameItem->id_card; ?></td>
                        <td class="py-3 px-4  text-sm text-white"><?= $listCardNameItem->name_benefit; ?> <?= $listCardNameItem->status_card; ?></td>
                        <td class="py-3 px-4  text-sm text-white"><?= $listCardNameItem->cpf; ?></td>
                        <td class="py-3 px-4 text-center">
                            <input type="hidden" name="received[]" value="<?= fncEncrypt($listCardNameItem->id_card); ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="py-3 px-4 text-center text-red-500 flex justify-center cursor-pointer">
                            <form 
                                data-confirm="true" 
                                data-message="Tem cerceza que deseja deletar esse registro?"
                                action="<?= url("/cartao/deletarsolicitacaocartao"); ?>" 
                                method="post">
                                <?= csrf_input(); ?>
                                <input type="hidden" name="id-request" value="<?= $listCardNameItem->id_card_request; ?>">
                                <button type="submit">    
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>   
                <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="6" class="py-3 px-4 text-center text-gray-500">
                    Não há dados para exibir.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <form 
        data-confirm="true" 
        data-message="Tem cerceza que deseja encaminhar essas solicitações?" 
        action="<?= url("/cartao/solicitado"); ?>" 
        method="post"
        class="pt-4 flex items-end gap-3"
        >
        <?= csrf_input(); ?>
        <div class="flex items-center gap-2 bg-white/10 py-2 px-3">
            <input type="checkbox" class="cursor-pointer">
            <span class="text-white">Selecionar todos</span>
        </div>
        <button name="btn-send" value="send" class="flex items-center gap-2 bg-green-800 transition-all duration-300 hover:bg-green-900 text-white rounded-xs py-2 px-3 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
            <span>Enviar Selecionados</span>
        </button>
    </form>
<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>
