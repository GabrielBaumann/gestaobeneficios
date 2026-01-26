<?php if (!empty($listRecharge)): ?>

    <table class="w-full bg-white/10 rounded-sm">
        <thead class="">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Mês</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Valor</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Data Requerimento</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-gray-600">
            <?php if (!empty($listRecharge)): ?>
                <?php foreach($listRecharge as $listRechargeItem):?>
                    <tr class="hover:bg-gray-800 transition-colors cursor-pointer transition-all duration-300">
                        <td class="py-3 px-4 text-sm text-white"><?= $listRechargeItem->id_card_recharge; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= $listRechargeItem->name_benefit; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= $listRechargeItem->cpf; ?></td>
                        <td class="py-3 px-4 text-center text-white"><?= fncMonthString($listRechargeItem->month_recharge); ?>/<?= $listRechargeItem->year_recharge; ?></td>
                        <td class="py-3 px-4 text-center text-white"><?= fncstr_price($listRechargeItem->value); ?></td>
                        <td class="py-3 px-4 text-center text-white"><?= date_simple($listRechargeItem->date_request); ?></td>
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

    <form 
        data-confirm="true"
        data-message="Tem certeza que deseja baixar a lista?"
        action="<?= url("/cartao/gerarrecarga"); ?>" 
        method="post">
        
        <?= csrf_input(); ?>
        <button name="btn-send" value="send" class="cursor-pointer mt-4 bg-green-800 hover:bg-green-900 transition-all duration-300 rounded-sm py-3 px-4 text-white font semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
            <span>Baixar Lista</span>
        </button>

    </form> 

<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>
