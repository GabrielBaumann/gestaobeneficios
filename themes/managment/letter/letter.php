<?php $this->layout("/letter/layout"); ?>

<?php if($dataDocument["type"] === "sendcompany"): ?>
    <?= $this->insert("/letter/letterSendCompany"); ?>
<?php elseif ($type === "emergencial"): ?>
    <?= $this->insert("/card/formEmergencyCard"); ?>
<?php elseif ($type === "enviado"): ?>
    <?= $this->insert("/card/sendCard"); ?>
<?php elseif ($type === "cartao"): ?>
    <?= $this->insert("/card/activeCard"); ?>
<?php endif; ?>