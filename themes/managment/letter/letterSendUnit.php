
<!-- <?php foreach($dataDocument["data"] as $dataDocumentItem): ?> -->
        
    <div id="conteudo" class="pagina-pdf pl-12 pr-6 pt-4 pb-4 flex flex-col justify-between gap-5">
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
    <h1 class="text-lg font-bold uppercase mb-2 print:mb-4">Ofício Nº: <?=  format_number($dataDocumentItem["numberOffice"]); ?> – Gabinete – Semdes</h1>

    <!-- Data (alinhada à direita) -->
    <p class="text-sm text-right mb-6">Canaã dos Carajás/PA, <?= $dateNow; ?>.</p>

    <!-- De/Para -->
    <div class="mb-4">
        <p class="font-bold">Da: Setor de Benefícios Eventuais - Coordenadoria de Gestão de Benefícios Socioassistencial-CGBSA</p>
        <p class="font-bold"><?= $dataDocumentItem["unit"]; ?></p>
    </div>

    <!-- Assunto -->
    <p class="font-bold mb-4">Encaminhamento do Cartão Social.</p>

    <!-- Saudação e Corpo -->
    <p class="font-bold">Prezado,</p>
    <div class="text-justify indent-12">Ao cumprimenta-la, venho por meio deste encaminhar <?= format_number($dataDocumentItem["countCard"]); ?> cartões nominais desta unidade.</div>


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

<!-- <?php endforeach; ?> -->