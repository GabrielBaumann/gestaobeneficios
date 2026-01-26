<?php if (!empty($listBalance)): ?>

    <table class="w-full bg-white/10 rounded-sm">
        <thead class="">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nome</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">CPF</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">opções</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-gray-600">
                <?php foreach($listBalance as $listBalanceItem):?>
                    <tr class="hover:bg-gray-800 transition-colors cursor-pointer transition-all duration-300">
                        <td class="py-3 px-4 text-sm text-white"><?= $listBalanceItem->id_person_benefit; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= $listBalanceItem->name_benefit; ?></td>
                        <td class="py-3 px-4 text-sm text-white"><?= $listBalanceItem->cpf; ?></td>
                        <td class="py-3 px-4 text-center text-white">
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

    <form action="<?= url("/documentocartao/receberexcel"); ?>" enctype="multipart/form-data" class="flex flex-col gap-4 bg-white/10 rounded-sm mt-2 text-white p-4">
        <div class="flex flex-col gap-2">
            <label for="list-xls">Arquivo *</label>
            <input type="file" name="list-xls" id="list-xls" class="bg-gray-800 p-4 cursor-pointer">
        </div>
        <div class="flex flex-col gap-2">
            <label for="month">Mês *</label>
            <select name="month" id="month" class="bg-gray-800 p-4 cursor-pointer">
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
            <button class="bg-green-700 hover:bg-green-800 transition-all duration-300 text-white rounded-sm flex items-center justify-center py-2 px-4 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
                <span>Enviar lista</span>
            </button>
        </div>
    </form>

<?php else: ?>
    <div class="flex justify-center py-4 bg-white/10 rounded-sm">
        <h1 class="text-white text-center">Não há dados.</h1>
    </div>
<?php endif; ?>