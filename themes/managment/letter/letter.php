<?php $this->layout("/letter/layout"); ?>

<?php if($typedocument === "sendcompany"): ?>
    <?= $this->insert("/letter/letterSendCompany"); ?>
<?php elseif ($typedocument === "emergency"): ?>
    <?= $this->insert("/letter/letterEmergency"); ?>
<?php elseif ($typedocument === "enviado"): ?>
    <?= $this->insert("/card/sendCard"); ?>
<?php elseif ($typedocument === "cartao"): ?>
    <?= $this->insert("/card/activeCard"); ?>
<?php endif; ?>