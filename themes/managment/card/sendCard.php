<form action="<?= url("/enviado"); ?>" method="post">
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

    <tbody class="divide-y divide-gray-200">
        <?php if(!empty($listCardName)): ?>
            <?php foreach($listCardName as $listCardNameItem):?>
                <tr class="hover:bg-gray-50 transition-colors">
                <td class="py-3 px-4 text-sm text-gray-800"><?= $listCardNameItem->id_card; ?></td>
                <td class="py-3 px-4 text-sm text-gray-800"><?= $listCardNameItem->name_benefit; ?> - <?= $listCardNameItem->status_card; ?></td>
                <td class="py-3 px-4 text-sm text-gray-600"><?= $listCardNameItem->cpf; ?> - <?= $listCardNameItem->name_unit; ?></td>
                <td class="py-3 px-4 text-center">
                    <input type="checkbox" name="received[]" value="<?= fncEncrypt($listCardNameItem->id_card); ?>" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                </td>
                <td class="py-3 px-4 text-center">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                </td>
                <td class="py-3 px-4 text-center">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                </td>
                </tr>
            <?php endforeach;?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="py-3 px-4 text-center text-gray-500">
                    Não há dados para exibir.
                </td>
            </tr>
        <?php endif;?>
    </tbody>
    </table>
    <button name="btn-send" value="send">Enviar Selecionados</button>
</form>