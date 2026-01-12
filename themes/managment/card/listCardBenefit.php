<?php if (!empty($card)): ?>

    <table class="w-full">
        <thead class="">
            <tr>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Id_card</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Nº Cartão</th>
                <th class="py-3 px-4 text-left text-sm font-medium text-white uppercase tracking-wider">Data Requerimento</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Tipo</th>
                <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Status</th>
                 <th class="py-3 px-4 text-center text-sm font-medium text-white uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <?php $count = 1; ?>
        <tbody class="divide-y divide-gray-200">
            <?php if (!empty($card)): ?>
                <?php foreach($card as $item):?>
                    <!-- <tr onclick="showRecharges()"  class="hover:bg-gray-50 transition-colors"> -->
                    <td class="py-3 px-4 text-sm text-white"><?= $item->id_card; ?></td>
                    <td class="py-3 px-4 text-sm text-white"><?= $item->number_card ?? 000; ?></td>
                    <td class="py-3 px-4 text-sm text-white"><?= date_simple($item->date_request); ?></td>
                    <td class="py-3 px-4 text-center"><?= $item->type_request; ?></td>
                    <td class="py-3 px-4 text-center">
                        <span class="status px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <?= $item->status_card; ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <?php if($item->status_card == "ativo"): ?>

                            <!-- Canceled card -->
                            <button type="submit" id="showModal" data-url="<?=  url("/cartao/cancelarcard/" . fncEncrypt($item->id_card)); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer text-red-500 text-center">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>

                        <?php elseif($item->status_card == "cancelado"): ?>

                            <!-- Aditar ou reativar cartão -->
                            <!-- <button type="submit" id="showModal" data-url="<?=  url("/cartao/cancelarcardedit/" . fncEncrypt($item->id_card)); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button> -->
                            ...
                        <?php else: ?>
                            ....
                        <?php endif; ?>
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

