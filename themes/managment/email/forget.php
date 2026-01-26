<?php $this->layout("/email/layout_email", ["title" => "Recuperar senha!"]); ?>
<div class="content">
    <h2>Recuperação de Senha</h2>
    <p>Olá, [NOME]!</p>
    <p>Recebemos uma solicitação para redefinir a senha da sua conta. Se não foi você, ignore este email.</p>
    
    <div class="warning">
        <p><strong>Importante:</strong> Por segurança, este link expirará em [TEMPO_EXPIRACAO] ou após o uso.</p>
    </div>
    
    <p>Para redefinir sua senha, clique no botão abaixo:</p>
    
    <p style="text-align: center;">
        <a href="[LINK_RECUPERACAO]" class="button">Redefinir Minha Senha</a>
    </p>
    
    <p>Se o botão não funcionar, copie e cole o seguinte link em seu navegador:</p>
    <p style="word-break: break-all; color: #4a6fff; font-size: 14px;">[LINK_RECUPERACAO]</p>
    
    <div class="divider"></div>
    
    <p><strong>Código de verificação (se necessário):</strong></p>
    <div class="code">[CODIGO_VERIFICACAO]</div>
    
    <div class="divider"></div>
    
    <p><strong>Dúvidas?</strong></p>
    <p>Consulte nossa <a href="#" style="color: #4a6fff;">central de ajuda</a> ou entre em contato conosco pelo email <a href="mailto:support@sistemafinanceiro.com" style="color: #4a6fff;">support@sistemafinanceiro.com</a></p>
    
    <p>Atenciosamente,<br>Equipe do Sistema Financeiro</p>
</div>