<div class="flex h-screen sidebar" data-menu="cartao">
    <!-- lateral aside -->
    <aside id="sidebar-main" class="relative hidden w-full md:flex flex-col justify-between md:w-[300px] md:min-w-[300px] md:max-w-[300px] p-6 overflow-y-auto">
        <form action="<?= url("/solicitarcartao") ?>" method="post">
            <?= csrf_input(); ?>
            <label for="bene">Beneficiáio</label>
            <input type="text" id="bene" name="person-benefit" placeholder="Beneficiário"></br>

            <label for="tec">Mês inicio</label>
            <input type="text" name="month-start" placeholder="Mês de início"></br>

            <label for="tec">Mês fim</label>
            <input type="text" name="month-end" placeholder="Mês de fim"></br>

            <label for="tec">Técico(a)</label>
            <input type="text" name="technician" placeholder="Técnico"></br>

            <label for="data">data solicitação</label>
            <input type="date" name="date-request" placeholder="data"></br>
            <button>Enviar</button>
        </form>
    </aside>
</div>