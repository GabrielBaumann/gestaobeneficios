<?php if (!empty($listBalance)): ?>

    <table class="w-full">
        <thead class="">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">opções</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-gray-200">
                <?php foreach($listBalance as $listBalanceItem):?>
                    <!-- <tr onclick="showRecharges()"  class="hover:bg-gray-50 transition-colors"> -->
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $listBalanceItem->id_person_benefit; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-800"><?= $listBalanceItem->name_benefit; ?></td>
                    <td class="py-3 px-4 text-sm text-gray-600"><?= $listBalanceItem->cpf; ?></td>
                    <td class="py-3 px-4 text-center">
                        <button type="submit" id="showModal" data-url="<?=  url("/cartao/modalrecarga") . "/" . fncEncrypt($listBenefitItem->id_person_benefit); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                    </td>
                    </tr>
                <?php endforeach;?>
        </tbody>
    </table>

<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>

<form action="<?= url("/documentocartao/receberexcel"); ?>" enctype="multipart/form-data">
    <label for="list-xls">Arquivo *</label>
    <input type="file" name="list-xls" id="list-xls">
    <div>
        <label for="month">Mês *</label>
        <select name="month" id="month">
            <option value="">Selecionar</option>
            <option value="1">Janeiro</option>
            <option value="2">Fevereiro</option>
            <option value="3">Março</option>
            <option value="4">Abril</option>            
            <option value="5">Maio</option>
            <option value="6">Junho</option>
            <option value="7">Julho</option>
            <option value="8">Agosto</option>            
            <option value="9">Setembro</option>
            <option value="10">Outubro</option>
            <option value="11">Novembro</option>
            <option value="12">Dezembro</option>
        </select>
    </div>
    <div>    
        <button>Enviar lista</button>
    </div>
</form>