<!-- Assunto -->
<p class="font-bold mb-4">Assunto: Encaminhamento Relação de DESBLOQUEIO para
    <?= $dataDocument["monthRecharge"]; ?> dos usuários “Cartão Social”</p>

<!-- Saudação e Corpo -->
<p class="font-bold">Prezado,</p>
<div class="text-justify indent-12">Ao cumprimentá-lo, venho por meio deste, 
    encaminhar a relação dos usuários, 
    para manter ativo o cartão com valor de <?= $dataDocument["valueCard"]; ?> 
    referente ao mês de <?= $dataDocument["monthRecharge"]; ?>
    do benefício eventual de auxílio alimentação. 
    Via enviada para o e-mail institucional  <span class="text-blue-500 font-bold">financeiro@webcard.adm.br.</span>
    Segue quantitativo por Unidade de Atendimento via e-mail:
</div>

<!-- Total -->
<p class="text-right text-lg mb-6">TOTAL: <?= format_number($dataDocument["countCard"] ?? null); ?> USUÁRIOS.</p>