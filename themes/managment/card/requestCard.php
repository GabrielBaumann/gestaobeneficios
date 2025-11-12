<?php if (!empty($listCardName)): ?>
    <table class="w-full">

        <thead class="bg-gray-50">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Opções</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($listCardName)): ?>
                <?php foreach($listCardName as $listCardNameItem):?>
                    <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $listCardNameItem->id_card; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $listCardNameItem->name_benefit; ?> <?= $listCardNameItem->status_card; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-600"><?= $listCardNameItem->cpf; ?></td>
                    <td class="py-3 px-4 text-center">
                        <input type="hidden" name="received[]" value="<?= fncEncrypt($listCardNameItem->id_card); ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    </td>
                        <td class="py-3 px-4 text-center text-red-500 flex justify-center cursor-pointer">
                            <form action="<?= url("/deletarsolicitacaocartao/"); ?>" method="post">
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
    <form action="<?= url("/solicitado"); ?>" method="post">
    <?= csrf_input(); ?>
        <select name="date-month" id="">
            <option value="">Selecione</option>
            <?php foreach($monthAll as $monthAllItem): ?>
                <option value="<?= $monthAllItem; ?>"><?= $monthAllItem; ?></option>
            <?php endforeach;?>
        </select>
        <button name="btn-send" value="send">
            Enviar Selecionados
        </button>
    </form>
<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>
