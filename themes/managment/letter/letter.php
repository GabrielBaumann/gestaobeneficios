<?php $this->layout("/letter/layout"); ?>

<?php if($dataDocument["type"] === "sendcompany"): ?>
    <?= $this->insert("/letter/letterSendCompany"); ?>
<?php elseif ($dataDocument["type"] === "emergency"): ?>
    <?= $this->insert("/letter/letterEmergency"); ?>
<?php elseif ($type === "enviado"): ?>
    <?= $this->insert("/card/sendCard"); ?>
<?php elseif ($type === "cartao"): ?>
    <?= $this->insert("/card/activeCard"); ?>
<?php endif; ?>