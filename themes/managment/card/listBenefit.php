<?php if (!empty($listBenefit)): ?>

    <table class="w-full bg-white/10 md:max-h-[400px] rounded-md overflow-y-auto">
        <thead class="rounded-t-md">
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
                <?php foreach($listBenefit as $listBenefitItem):?>
                    <!-- <tr onclick="showRecharges()"  class="hover:bg-gray-50 transition-colors"> -->
                    <td class="py-3 px-4  text-sm text-white"><?= $listBenefitItem->id_person_benefit; ?></td>
                    <td class="py-3 px-4  text-sm text-white"><?= $listBenefitItem->name_benefit; ?></td>
                    <td class="py-3 px-4  text-sm text-white"><?= $listBenefitItem->cpf; ?></td>
                    <td class="py-3 px-4">
                        
                        <a href="<?=  url("/cartao/recargabeneficiario") . "/" . fncEncrypt($listBenefitItem->id_person_benefit); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer text-white cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        
                    </td>
                    <td class="py-3 px-4">
                        
                        <a href="<?=  url("/cartao/cardsbeneficiario") . "/" . fncEncrypt($listBenefitItem->id_person_benefit); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer text-white cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        
                    </td>
                    </tr>
                <?php endforeach;?>
        </tbody>
    </table>

<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>
