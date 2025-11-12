<?php $this->layout("/letter/layout"); ?>

<?php if($typedocument === "sendcompany"): ?>
    <?= $this->insert("/letter/letterSendCompany"); ?>
<?php elseif ($typedocument === "emergency"): ?>
    <?= $this->insert("/letter/letterEmergency"); ?>
<?php elseif ($typedocument === "sendcompanyrecharge"): ?>
    <?= $this->insert("/letter/letterSendCompanyRecharge"); ?>
<?php elseif ($typedocument === "cartao"): ?>
    <?= $this->insert("/card/activeCard"); ?>
<?php endif; ?>