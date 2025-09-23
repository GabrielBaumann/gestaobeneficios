<?php $this->layout("layout"); ?>
<div class="flex h-screen">
    <!-- lateral aside -->
    <aside id="sidebar-main" class="relative hidden w-full md:flex flex-col justify-between md:w-[300px] md:min-w-[300px] md:max-w-[300px] p-6 overflow-y-auto">
        <form action="<?= url("/unidadecartaoalimentacao") ?>" method="post">
            <?= csrf_input(); ?>
            <label for="bene">Beneficiáio</label>
            <input type="text" id="bene" name="person-benefit" placeholder="Beneficiário"></br>

            <label for="tec">Quantidade</label>
            <input type="text" name="amount-recharge" placeholder="Quantidade"></br>

            <label for="tec">Mês inicio</label>
            <input type="text" name="month-start" placeholder="Mês de início"></br>

            <label for="tec">Mês fim</label>
            <input type="text" name="month-end" placeholder="Mês de fim"></br>

            <label for="tec">Técico(a)</label>
            <input type="text" name="type" placeholder="Técnico"></br>

            <label for="data">data solicitação</label>
            <input type="text" name="date-request" placeholder="data"></br>
            <button>Enviar</button>
        </form>
    </aside>
</div>
<?php $this->start("scripts"); ?>
  <script src="<?= theme("/js/default/forms.js", CONF_VIEW_APP); ?>"></script>
<?php $this->stop("scripts"); ?>