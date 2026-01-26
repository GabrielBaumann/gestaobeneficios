<?php if (!empty($recharge)): ?>

    <table class="w-full bg-white/10 rounded-sm">
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
        <tbody class="divide-y divide-gray-600">
            <?php if (!empty($recharge)): ?>
                <?php foreach($recharge as $item):?>
                    <tr onclick="showRecharges()"  class="hover:bg-gray-800 transition-colors cursor-pointer transition-all duration-300">
                        <td class="py-3 px-4 text-sm text-white"><?= $item->id_card_recharge; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= fncstr_price($item->value); ?></td>
                        <td class="py-3 px-4 text-sm text-white">
                            <?= fncMonthString($item->month_recharge); ?>

                            <?php  if($item->type_request === "recarga extra"): ?>
                                <?= $item->type_request; ?>
                            <?php endif; ?>
                            
                        </td>
                        <td class="py-3 px-4 text-center text-white"><?= $item->year_recharge; ?></td>
                        <td class="py-3 px-4 text-center text-white">
                            <span class="status px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <?= $item->status_recharge; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="6" class="py-3 px-4 text-center text-white">
                        Não há dados para exibir.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>

<footer class="flex items-center justify-start gap-3 pt-3">
    <h1 class="font-semibold text-white text-xl">Saldo atual:</h1>
    <p class="text-white text-xl"><?= fncstr_price($balance->value ?? 00); ?></p>
</footer>
