<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= theme("/css/message.css", CONF_VIEW_APP); ?>">
    <link rel="icon" href="<?= theme("/img/white-logo-gs.png", CONF_VIEW_APP); ?>">
    <title>Entrar - Gestão socioassistencial</title>
    <style>
        body {
            font-family: 'Montserrat';
        }
    </style>
</head>
<body>
    <div class="h-screen">
        
        <div class="w-full mx-auto md:w-2/5 2xl:w-2/7 p-12 flex flex-col justify-center">
            <div class="text-center mb-10">
                <img src="<?= theme("/img/logo.png")?>" alt="logo" class="h-[60px] mx-auto text-[#095998]">
            </div>
            
            <form class="space-y-6" action="<?= url("/") ?>" method="post">
                <div><?= flash(); ?></div>
                <?= csrf_input(); ?>
                <div>
                    <label for="cpf" class="block text-sm font-light text-gray-700 mb-1">CPF</label>
                    <input 
                        type="text"
                        id="cpfuser"
                        type="text"
                        required
                        name="cpfuser"
                        placeholder="000.000.000-00"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-800 focus:border-green-800 outline-none transition duration-200 font-light"
                    >
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-light text-gray-700 mb-1">Senha</label>
                    <input 
                        id="password"
                        type="password"
                        required
                        name="password"
                        placeholder="********"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-800 focus:border-green-800 outline-none transition duration-200 font-light"
                    >
                </div>
                
                <div>
                    <button class="cursor-pointer shadow-xl w-full flex justify-center py-3 px-4 border border-transparent rounded-full md:rounded-lg md:shadow-sm text-md font-light text-white bg-green-800 hover:bg-green-900 transition duration-200">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
        
    </div>
    <script src="<?= theme("/js/forms.js", CONF_VIEW_THEME); ?>"></script>
</html>