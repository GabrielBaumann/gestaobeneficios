<?php $this->layout("/modal/layout_modal"); ?>
<button id="cancelBtn">x</button>
<div class="modal-title">Lista de pessoas</div>

<p class="modal-message">
    Confira os dados abaixo antes de baixar a lista em Excel.
</p>

<div class="lista-pessoas-wrapper overflow-y-auto max-h-[60vh]">
    <table class="lista-pessoas-tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th style="text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listFound)) : ?>
                <?php foreach ($listFound as $listFoundItem) : ?>
                    <tr>
                        <td><?= $listFoundItem->name; ?></td>
                        <td><?= $listFoundItem->cpf; ?></td>
                        <td class="valor">
                            <?= number_format($listFoundItem->value, 2, ",", "."); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td class="lista-pessoas-sem-registros" colspan="3">
                        Nenhum registro encontrado.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal-buttons bottom-0 left-0 w-full absolute fixed bg-white">
    <form action="<?= url("/documentocartao/baixarlista") ?>" method="post">
        <input type="hidden" name="month" value="<?=  $listFound[0]->month_reference; ?>">
        <button type="submit"
                class="modal-button confirm-button"
                id="btnBaixarExcel">
            Baixar lista em Excel
        </button>

        <button type="button"
                class="modal-button cancel-button"
                id="cancelBtn">
            Cancelar
        </button>
    </form>
</div>