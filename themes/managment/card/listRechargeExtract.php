<?php if (!empty($recharge)): ?>

    <table class="w-full">
        <thead class="">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id_Recarga</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Valor</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Mês</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Ano</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($recharge)): ?>
                <?php foreach($recharge as $item):?>
                    <!-- <tr onclick="showRecharges()"  class="hover:bg-gray-50 transition-colors"> -->
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $item->id_card_recharge; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-800"><?= fncstr_price($item->value); ?></td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        <?= fncMonthString($item->month_recharge); ?>

                        <?php  if($item->type_request === "recarga extra"): ?>
                            <?= $item->type_request; ?>
                        <?php endif; ?>
                        
                    </td>
                    <td class="py-3 px-4 text-center"><?= $item->year_recharge; ?></td>
                    <td class="py-3 px-4 text-center">
                        <span class="status px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <?= $item->status_recharge; ?>
                        </span>
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

<footer class="border-t border-gray-300 flex items-center justify-start gap-3 pt-3">
    <h1 class="font-semibold text-gray-800 text-xl">Saldo atual:</h1>
    <p class="text-gray-500 text-xl"><?= fncstr_price($balance->value ?? 00); ?></p>
</footer>
