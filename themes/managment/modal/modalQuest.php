<?php $this->layout("/modal/layout_modal"); ?>
<button id="cancelBtn">x</button>
    <div class="modal-title"><?= $title ?? "Erro!" ?></div>
    <p class="modal-message"><?= $textMessage ?? "Erro!" ?></p>
    <div class="modal-buttons">
        <?php if($urlYes): ?>
            <form action="<?= $urlYes; ?>" method="post">
                <?= csrf_input(); ?>
                <button name="btn-yes" value="yes" class="modal-button confirm-button" id="confirmBtn">Sim</button>
            </form>
        <?php endif; ?>
        <?php if($urlNo): ?>
            <form action="<?= $urlNo; ?>" method="post">
                <?= csrf_input(); ?>
                <button class="modal-button confirm-button" id="confirmBtn">Não</button>
            </form>
        <?php endif; ?>
        <?php if($cancel): ?>
            <button name="no" value="type" id="cancelBtn" class="modal-button cancel-button">Cancelar</button>
        <?php endif; ?>            
    </div>