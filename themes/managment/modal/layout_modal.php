<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title); ?></title>
    <style>
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
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 600px;
            max-width: 90%;
            text-align: center;
            animation: fadeIn 0.4s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div><?= flash(); ?></div>
    <!-- Modal de confirmação -->
    <div class="modal-overlay" id="confirmationModal">
        <div class="modal-content max-h-[70vh] overflow-y-auto">
            <?= $this->section("content"); ?>
        </div>
    </div>
</body>
</html>