<?php if (!empty($listRecharge)): ?>
    <form action="<?= url("/gerarrecarga"); ?>" method="post" id="all">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Id</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Nome</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">CPF</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Mês</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Valor</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Sem resposta</th>
                    <th class="py-3 px-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">opções</th>
                </tr>
            </thead>
            <?php $count = 1; ?>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($listRecharge)): ?>
                    <?php foreach($listRecharge as $listRechargeItem):?>
                        <tr onclick="showRecharges()"  class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-800"><?= $listRechargeItem->id_card_recharge; ?></td>
                        <td class="py-3 px-4 text-sm text-gray-800"><?= $listRechargeItem->name_benefit; ?></td>
                        <td class="py-3 px-4 text-sm text-gray-600"><?= $listRechargeItem->cpf; ?></td>
                        <td class="py-3 px-4 text-center"><?= fncMonthString($listRechargeItem->month_recharge); ?>/<?= $listRechargeItem->year_recharge; ?></td>
                        <td class="py-3 px-4 text-center"><?= fncstr_price($listRechargeItem->value); ?></td>
                        <td class="py-3 px-4 text-center"><?= $listRechargeItem->status_recharge; ?>-<?= $listRechargeItem->type_request; ?></td>
                        <td class="py-3 px-4 text-center">
                            <input type="checkbox" name="sendrecharge-<?= $count ++; ?>" 
                                value="<?= $listRechargeItem->id_card_recharge; ?>"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        </td>
                        <td class="py-3 px-4 text-center">
                            <button type="submit" id="showModal">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </button>
                        </td>
                        </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr>
                        <td colspan="6" class="py-3 px-4 text-center text-gray-500">
                            Não há dados para exibir.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button name="btn-send" value="send" class="cursor-pointer mt-4 bg-green-700 rounded-full py-3 px-4 text-white font semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
            <span>Enviar Selecionados</span>
        </button>

    </form>

    

<?php else: ?>
    <div>Não há dados.</div>
<?php endif; ?>

<script>
    // Função para chamar modal quest
function fncModalQuest (vIdButton) {
    document.addEventListener("click", (e) => {
        const vButton = e.target.closest("button");
        if(vButton && vButton.id === vIdButton) {
            const vUrl = vButton.dataset.url;
            fetch(vUrl)
            .then(response => response.json())
            .then(data => {

                if(data.message) {
                    fncMessage(data.message);
                    return;
                }

                document.getElementById("response")?.remove();
                if (document.getElementById("modal")) return document.getElementById("modal").remove();

                const vElement = document.createElement("div");
                vElement.id = "modal";
                vElement.innerHTML = data.html;
                document.body.appendChild(vElement);
            })
        }
    });
}

// Cancelar ação
document.addEventListener("click", (e) => {
    const vButton = e.target.closest("button")
    if(vButton && vButton.id === "cancelBtn") {
        document.getElementById("response")?.remove();
        document.getElementById('modal').remove();
    }
});

// Fechar modal clicando no overlay (fora da modal)
document.addEventListener("click", (e) => {
    if(e.target.id === "confirmationModal") {
        document.getElementById("response")?.remove();
        document.getElementById("modal").remove();
    }
})

// Fechar com ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.getElementById("response")?.remove();
        document.getElementById('modal').remove();
    }
});

///////////////////////////////////

// Formulário de submição
document.addEventListener("submit", async (e)=> {

    if (e.target.tagName === "FORM") {
        e.preventDefault()

        const form = e.target;
        const formData = new FormData(form, e.submitter);
        const actionForm = e.target.action;

        // let timeoutLoading;
        // timeoutLoading = showSplash(true)

        try {
            const vResponse = await fetch(actionForm, {
            method: "POST",
            body: formData
        })
            const vData = await vResponse.json();

            document.getElementById("modal")?.remove();

            // Redireciona
            if(vData.redirect) {
                window.location.href = vData.redirect
            }
            
            // Redireciona e cria uma nova aba (impressão)
            if(vData.redirectedBlank) {
                window.open(vData.redirectedBlank, "_blank");
            }

            // Retorna mensagem
            if(vData.message){
                document.getElementById("response")?.remove();
                const vlemente = document.createElement("div");
                vlemente.id = "response"
                vlemente.innerText = vData.message;
                document.body.appendChild(vlemente);
            }

            // Retorna um elemento dinâmico ajax
            if(vData.html) {
                const vReplaceContent = document.querySelector(".content-ajax");
                vReplaceContent.innerHTML = vData.html;
            }

            // // Retorna uma janela modal
            if(vData.modal) {
                const vElement = document.createElement("div");
                vElement.id = "modal";
                vElement.innerHTML = vData.modal;
                document.body.appendChild(vElement);
            }

        } catch (error) {
            fncMessage();
        } finally {

        }
    }
});
</script>
