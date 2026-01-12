<?php $this->layout("/modal/layout_modal"); ?>

<header class="flex items-center justify-end border-b border-gray-300 p-4 bg-gray-300">
      <?= isset($edit) ? "Editar Cancelamento" : "Cancelar cartão"; ?>    
      <button id="cancelBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
      </button>
</header>

<div class="p-8 flex flex-col gap-4">

      <header class="flex flex-col items-start pb-4">
            <h1 class="text-gray-800 text-xl font-semibold"><?= $card->name_benefit; ?></h1>
            <p class="text-gray-500 text-md"><?= $card->cpf; ?></p>
      </header>
      
      <div class="flex flex-col gap-2">
            <span class="text-gray-500 text-left">Cartão Nº: <?= $card->number_card ?? 000; ?></span>

            <div class="overflow-x-auto max-h-[310px]">
                  <form 
                  data-confirm="true" 
                  data-message="Tem certeza que deseja cancelar esse cartão?"  
                  action="<?=  url("/cartao/cancelarcard") ?>" 
                  method="post">

                        <?= csrf_input(); ?>
                        <input type="hidden" name="id-card-request" value="<?= fncEncrypt($card->id_card_request); ?>">
                        <input type="hidden" name="id-person-benefit" value="<?= fncEncrypt($card->id_person_benefit); ?>">
                        <?php if(isset($edit)): ?>
                              <input type="hidden" name="id-card-canceled" value="<?= fncEncrypt($data->id_card_canceled); ?>">
                        <?php endif; ?>
                        <label for="reason-canceled">Motivo cancelamento *</label>
                              <select name="reason-canceled" id="reason-canceled">
                                    <option value="">selecione</option>
                                    <option value="1" <?=  ($data->reason ?? "") == "1" ? "selected" : "" ?>>Extravio</option>
                                    <option value="2" <?=  ($data->reason ?? "") == "2" ? "selected" : "" ?>>Roubo</option>

                              </select>
                        <label for="observation">Observação: </label>
                        <textarea name="observation" id="observation"><?=  $data->observation ?? null; ?></textarea>
                        <button type="submit">
                              <?= isset($edit) ? "Atualizar Cancelamento" : "Salvar"; ?>
                        </button>
                  </form>
            </div>
      </div>

</div>