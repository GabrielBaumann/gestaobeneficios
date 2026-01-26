<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background-color: #4a6fff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4a6fff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .divider {
            border-top: 1px solid #eeeeee;
            margin: 25px 0;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Sistema Financeiro</div>
        </div>
        
        <?= $this->section("content"); ?>
        
        <div class="footer">
            <p>© 2023 Sistema Financeiro. Todos os direitos reservados.</p>
            <p>Este é um email automático, por favor não responda diretamente a esta mensagem.</p>
            <p>Você está recebendo este email porque se cadastrou em nosso sistema.</p>
            <p><a href="#" style="color: #666666;">Política de Privacidade</a> | <a href="#" style="color: #666666;">Termos de Uso</a></p>
        </div>
    </div>
</body>
</html>