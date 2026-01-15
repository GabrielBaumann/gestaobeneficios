<?php $this->layout("/layout_email", ["title" => "Confirma e ative sua conta no SysCerberus"]); ?>
<div class="content">
    <h2>Olá, <?= $name; ?>!</h2>
    <p>Seja muito bem-vindo(a) ao nosso sistema de cadastro de contas!</p>
    <p>Seu cadastro foi realizado com sucesso em nosso sistema. Abaixo estão os detalhes da sua conta:</p>
    
    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p><strong>Nome:</strong> <?= $name; ?></p>
        <p><strong>Email:</strong> <?= $email; ?></p>
        <p><strong>ID da conta:</strong> <?= $id; ?></p>
    </div>
    
    <p>Para ativar completamente sua conta, clique no botão abaixo:</p>
    
    <p style="text-align: center;">
        <a href="<?= $confirm_link; ?>" class="button">Ativar Minha Conta</a>
    </p>
    
    <p>Se o botão não funcionar, copie e cole o seguinte link em seu navegador:</p>
    <p style="word-break: break-all; color: #4a6fff;"><?= $confirm_link; ?></p>
    
    <div class="divider"></div>
    
    <p><strong>Dúvidas?</strong></p>
    <p>Consulte nossa <a href="#" style="color: #4a6fff;">central de ajuda</a> ou entre em contato conosco pelo email <a href="mailto:support@sistemafinanceiro.com" style="color: #4a6fff;">support@sistemafinanceiro.com</a></p>
    
    <p>Atenciosamente,<br>Equipe do Sistema Financeiro</p>
</div>