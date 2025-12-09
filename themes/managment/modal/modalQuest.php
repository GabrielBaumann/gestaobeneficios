<?php $this->layout("/modal/layout_modal"); ?>
<button id="cancelBtn">x</button>
    <div class="modal-title"><?= $title ?? "Erro!" ?></div>
    <p class="modal-message"><?= $textMessage ?? "Erro!" ?></p>
    <div class="modal-buttons">
        <form id="modal-quest" action="<?= url("/cartao/modalquest"); ?>" method="post">
            <?= csrf_input(); ?>
            <button name="btn-yes" value="yes" class="modal-button confirm-button" id="confirmBtn">Sim</button>
            <button name="no" value="type" id="cancelBtn" class="modal-button cancel-button">Cancelar</button>
        </form>
    </div>