<?php $this->layout("/email/layout_email", ["title" => "Confirma e ative sua conta no SysCerberus"]); ?>
<div class="content">
<div class="success-icon">✓</div>
            <h2>Identidade Confirmada com Sucesso!</h2>
            <p>Olá, <strong><?= $name; ?></strong>!</p>
            <p>Sua identidade foi confirmada com sucesso em nosso sistema. Agora você tem acesso completo à sua conta.</p>
            
            <div class="divider"></div>
            
            <h3>Próximos Passos</h3>
            
            <div class="step">
                <strong>1. Faça login em sua conta</strong>
                <p>Use suas credenciais para acessar o sistema</p>
            </div>
            
            <div class="step">
                <strong>2. Complete seu perfil</strong>
                <p>Adicione informações adicionais para melhorar sua experiência</p>
            </div>
            
            <div class="step">
                <strong>3. Explore os recursos</strong>
                <p>Descubra todas as funcionalidades disponíveis em sua conta</p>
            </div>
            
            <div class="divider"></div>
            
            <p>Clique no botão abaixo para fazer login em sua conta:</p>
            
            <a href="<?= $url; ?>" class="button">Fazer Login</a>
            
            <p>Ou copie e cole o seguinte link em seu navegador:<br>
            <span style="color: #4a6fff; font-size: 14px;">[URL_LOGIN]</span></p>
</div>