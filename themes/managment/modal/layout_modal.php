<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 450px;
            max-width: 90%;
            text-align: center;
            animation: fadeIn 0.4s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        .modal-title {
            font-size: 22px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .modal-message {
            color: #34495e;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 25px;
        }
        
        .modal-button {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            font-size: 16px;
            min-width: 120px;
        }
        
        .confirm-button {
            background-color: #27ae60;
            color: white;
            box-shadow: 0 4px 6px rgba(39, 174, 96, 0.2);
        }
        
        .confirm-button:hover {
            background-color: #2ecc71;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(39, 174, 96, 0.3);
        }
        
        .cancel-button {
            background-color: #e74c3c;
            color: white;
            box-shadow: 0 4px 6px rgba(231, 76, 60, 0.2);
        }
        
        .cancel-button:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(231, 76, 60, 0.3);
        }
    </style>
</head>
<body>
    <!-- Modal de confirmação -->
    <div class="modal-overlay" id="confirmationModal">
        <div class="modal-content">
            <?= $this->section("content"); ?>
        </div>
    </div>
</body>
</html>