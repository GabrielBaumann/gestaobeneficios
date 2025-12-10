<?php $this->layout("/modal/layout_modal"); ?>

<header class="flex items-center justify-between border-b border-gray-300 p-4 bg-gray-300">
        <div class="modal-title text-gray-500"><?= $title ?? "Erro!" ?></div>
      <button id="cancelBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
      </button>
</header>

<div class="p-8 flex flex-col gap-4">
    <p class="modal-message"><?= $textMessage ?? "Erro!" ?></p>
    <div class="flex items-center gap-5 justify-center">
        <form id="modal-quest" action="<?= url("/cartao/modalquest"); ?>" method="post">
            <?= csrf_input(); ?>
            <button name="btn-yes" value="yes" class="py-2 px-4 text-white rounded-md font-semibold bg-green-800 hover:bg-green-900 transition-all duration-300 cursor-pointer" id="confirmBtn">Sim</button>
            <button name="no" value="type" id="cancelBtn" class="py-2 px-4 text-white rounded-md font-semibold bg-red-400 hover:bg-red-500 transition-all duration-300 cursor-pointer">Cancelar</button>
        </form>
    </div>
</div>