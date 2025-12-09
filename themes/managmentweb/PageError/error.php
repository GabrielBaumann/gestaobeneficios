<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada | SINE360</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
        }
        .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 20px;
            line-height: 1;
        }
        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .error-description {
            margin-bottom: 30px;
            color: #7f8c8d;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .logo {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo">SINE360</div>
        <div class="error-code">404</div>
        <div class="error-message">Página não encontrada</div>
        <div class="error-description">
            A página que você está tentando acessar não existe ou foi movida.
        </div>
        <a href="<?= url("/") ?>" class="btn">Voltar para a página inicial</a>
    </div>
</body>
</html>