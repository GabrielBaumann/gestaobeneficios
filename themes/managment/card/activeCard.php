

<table class="w-full bg-white/10 rounded-sm">
    <thead class="">
        <tr>
            <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
        <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
        <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-600">
        <?php if (!empty($listCardName)): ?>
            <?php foreach($listCardName as $listCardNameItem):?>
                <tr class="hover:bg-gray-800 transition-colors cursor-pointer transition-all duration-300">
                <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->id_person_benefit; ?></td>
                <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->name_benefit; ?></td>
                <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->cpf; ?></td>

            <?php endforeach;?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="py-3 px-4 text-center text-white">
                    Não há dados para exibir.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>