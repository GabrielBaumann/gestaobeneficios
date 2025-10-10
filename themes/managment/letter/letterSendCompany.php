<!-- Assunto -->
<p class="font-bold mb-4">Assunto: Encaminhamento Relação de usuários “Cartão Social” – <?= $dataDocument["monthDocument"]; ?>.</p>

<!-- Saudação e Corpo -->
<p class="font-bold">Prezado,</p>
<div class="text-justify indent-12">Ao cumprimentá-lo, venho por meio deste, encaminhar a relação dos usuários,
    para emissão do Cartão Social - benefício eventual de auxílio alimentação, via e-mail
    institucional <span class="text-blue-500 font-bold">cartaosocialsemdescanaa@gmail.com</span>, para o e-mail da empresa
    disponibilizado <span class="text-blue-500 font-bold">financeiro@webcard.adm.br.</span>
</div>

<!-- Total -->
<p class="text-right text-lg mb-6">TOTAL: <?= format_number($dataDocument["countCard"]); ?> USUÁRIOS.</p>