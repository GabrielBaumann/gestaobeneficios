<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($dataDocument["title"]); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.2/html2pdf.bundle.min.js"></script>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }
        * {
            -webkit-print-color-adjust: exact; 
        }
        
        body { background-color: #f3f4f6; padding: 20px; }
        .conteudo { background: white; max-width: 210mm; margin: 0 auto; min-height: 1045px;}
    </style>
</head>
<body class="font-[Arial] p-0 bg-black/80">

    <header class="bg-white/10 flex items-center justify-center py-2 mb-2">
        <button id="gerarPdf" class="text-white border border-white bg-transparent hover:bg-white hover:text-black transition-all duration-300 py-2 px-4 rounded-full flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
            </svg>
            <span class="">Baixar PDF</span>
        </button>
    </header>  

    <div class="flex flex-col gap-4 w-full">

        <?php foreach($dataDocument["data"] as $dataItem): ?>
            <div id="conteudo1" class="pagina-pdf conteudo pl-12 pr-6 pt-4 pb-4 flex flex-col justify-between gap-5">
                    <!-- Cabeçalho com logos (substitua src pelas URLs reais dos brasões) -->
                    <div class="flex justify-between items-center gap-12 h-full">
                        <div class="flex flex-col">
                            <img src="<?= theme("/img/brazao.png", CONF_VIEW_APP); ?>" alt="Brasão Estado do Pará" class="w-[60px]">
                        </div>
                        <!-- Endereço -->
                        <div class="flex flex-col text-xs font-bold">
                            <p class="flex justify-center text-center">ESTADO DO PARÁ</p>
                            <p class="flex justify-center text-center">PREFEITURA MUNICIPAL DE CANAÃ DOS CARAJÁS</p>
                            <p class="flex justify-center text-center">SECRETARIA MUNICIPAL DE DESENVOLVIMENTO SOCIAL</p>
                        </div>
                        <div>
                            <img src="<?= theme("/img/pmcc.png", CONF_VIEW_APP); ?>" alt="Logo Canaã" class="w-[120px]">
                        </div>
                    </div>
                <div class="h-[3px] w-full bg-gradient-to-r from-blue-500 via-green-500 to-yellow-500"></div>
                
                <!-- Título do Ofício -->
                <h1 class="text-lg font-bold uppercase mb-2 print:mb-4">Ofício Nº: <?=  format_number($dataItem["numberOffice"] ?? 000); ?> – Gabinete – Semdes</h1>
                <!-- Data (alinhada à direita) -->
                <p class="text-sm text-right mb-6">Canaã dos Carajás/PA, <?= $dateNow; ?>.</p>
                <!-- De/Para -->
                <div class="mb-4">
                    <p class="font-bold">Da: Setor de Benefícios Eventuais - Coordenadoria de Gestão de Benefícios Socioassistencial-CGBSA</p>
                    <p class="font-bold"><?= $dataItem["unit"] ??  null; ?></p>
                </div>

                <!-- Assunto -->
                <p class="font-bold mb-4">Encaminhamento do Cartão Social.</p>

                <!-- Saudação e Corpo -->
                <p class="font-bold">Prezado,</p>
                <div class="text-justify indent-12">Ao cumprimenta-la, venho por meio deste encaminhar <?= format_number($dataItem["countCard"]); ?> cartões nominais desta unidade.</div>

                <p class="mb-8">Atenciosamente,</p>
                    <div class="mt-[70px]">
                        <!-- Assinatura (alinhada à direita) -->
                        <div class="text-center mb-6 mb-[70px]">
                            <p class="font-bold text-lg">Victor Nunes Lara</p>
                            <p class="font">Coordenadoria de Gestão de Benefícios</p>
                            <p class="text-sm">Mat: 0282067</p>
                        </div>
                        <div class="h-[3px] w-full bg-gradient-to-r from-blue-500 via-green-500 to-yellow-500"></div>
                        <!-- Rodapé com logos e endereço -->
                    <div class="flex flex-col items-center text-sm">
                        <div class="flex items-center gap-2">
                            <img src="<?= theme("/img/logo_semdes.jpeg", CONF_VIEW_APP); ?>" alt="logo semdes" class="w-[90px]">
                            <img src="<?= theme("/img/pmcc.png", CONF_VIEW_APP); ?>" alt="Logo Canaã" class="w-[120px]">
                        </div>
                        <p>SECRETARIA DE DESENVOLVIMENTO SOCIAL - SEMDES</p>
                        <p>Avenida Ipanema S/N, - Novo Horizonte II - CEP 68.356.193 - Canaã dos Carajás/PA</p>
                        <div>e-mail institucional: <span class="text-blue-500 font-bold">semdes@canaadoscarajas.pa.gov.br</span></div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>

    <script src="<?= theme("/js/letter/download.js", CONF_VIEW_APP); ?>">
    </script>
</body>
</html>