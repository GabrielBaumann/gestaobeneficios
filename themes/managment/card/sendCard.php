<form 
    data-confirm="true" 
    data-message="Tem cerceza que deseja enviar os cartões?" 
    action="<?= url("/cartao/enviado"); ?>" 
    method="post"
    >
    <?= csrf_input(); ?>
    <table class="w-full bg-white/10 rounded-sm">
        <thead class="">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Positiva</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-600">
            <?php if(!empty($listCardName)): ?>
                <?php foreach($listCardName as $listCardNameItem):?>
                    <tr class="hover:bg-gray-700 transition-colors cursor-pointer transition-all duration-300">
                        <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->id_card; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->name_benefit; ?> - <?= $listCardNameItem->status_card; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->cpf; ?> - <?= $listCardNameItem->name_unit; ?></td>
                        <td class="py-3 px-4 text-center text-white">
                            <input type="checkbox" name="received[]" value="<?= fncEncrypt($listCardNameItem->id_card); ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="py-3 px-4 text-center text-gray-300">
                        Não há dados para exibir.
                    </td>
                </tr>
            <?php endif;?>
        </tbody>
    </table>

    <div class="mt-4">
        <button name="btn-send" value="send" class="flex items-center gap-2 bg-green-800 transition-all duration-300 hover:bg-green-900 text-white rounded-xs py-2 px-3 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
            <span>Enviar Selecionados</span>
        </button>
    </div>
</form>