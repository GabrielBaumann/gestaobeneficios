<?php if (!empty($listCardName)): ?>
    <table class="w-full bg-white/10 rounded-sm">
    <thead class="">
        <tr>
            <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
            <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
            <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
            <!-- <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Positiva</th> -->
        </tr>
    </thead>
    <?php $count = 1; ?>
    <tbody class="divide-y divide-gray-600">
        <?php if (!empty($listCardName)): ?>
            <?php foreach($listCardName as $listCardNameItem):?>
                <tr class="hover:bg-gray-800 transition-colors cursor-pointer transition-all duration-300">
                <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->id_card_request; ?></td>
                <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->name_benefit; ?> <?= $listCardNameItem->status_card; ?></td>
                <td class="py-3 px-4 text-sm text-white"><?= $listCardNameItem->cpf; ?></td>
                <!-- <td class="py-3 px-4 text-center">
                    <form action="<?=  url("/cartao/")  ?>">    
                        <input type="submit"  value="Excluir" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    </form>
                </td> -->
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
<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>
