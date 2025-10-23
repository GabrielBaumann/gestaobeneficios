<?php if (!empty($listRecharge)): ?>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Mês</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Valor</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Sem resposta</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($listRecharge)): ?>
                <?php foreach($listRecharge as $listRechargeItem):?>
                    <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $listRechargeItem->id_card_recharge; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $listRechargeItem->name_benefit; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-600"><?= $listRechargeItem->cpf; ?></td>
                    <td class="py-3 px-4 text-center"><?= fncMonthString($listRechargeItem->month_recharge); ?>/<?= $listRechargeItem->year_recharge; ?></td>
                    <td class="py-3 px-4 text-center"><?= str_price($listRechargeItem->value); ?></td>
                    <td class="py-3 px-4 text-center"><?= $listRechargeItem->status_recharge; ?>-<?= $listRechargeItem->type_request; ?></td>
                    <td class="py-3 px-4 text-center">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
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
<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>
