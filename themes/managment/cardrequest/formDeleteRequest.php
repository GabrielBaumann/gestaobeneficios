<?php $this->layout("layout"); ?>
<div class="flex h-screen sidebar" data-menu="cartao">
    <!-- lateral aside -->
    <aside id="sidebar-main" class="relative hidden w-full md:flex flex-col justify-between md:w-[300px] md:min-w-[300px] md:max-w-[300px] p-6 overflow-y-auto">
        <form action="<?= url("/deletesolicitacaocartao") ?>" method="post">
            <?= csrf_input(); ?>
            <label for="bene">ID da Solicitação para exclusão</label>
            <input type="text" id="bene" name="id-request" placeholder="Beneficiário"></br>
            <button>Enviar</button>
        </form>
    </aside>
        <h2>Tabela de Solicitação</h2>
        <table>
            <thead>
                <th>id</th>
                <th>Nome</th>
                <th>Statu do Cartão</th>
                <th>Status Requisição</th>
                <th>tipo de requisição</th>
            </thead>
            <tbody>
                <?php foreach($listCard as $listCarditem):?>
                    <tr>
                        <td><?= $listCarditem->id_card_request; ?></td>
                        <td><?= $listCarditem->name; ?></td>
                        <td><?= $listCarditem->status_recharge; ?></td>
                        <td><?= $listCarditem->status_request; ?></td>
                        <td><?= $listCarditem->type_request; ?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
</div>

<?php $this->start("scripts"); ?>
  <script src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>