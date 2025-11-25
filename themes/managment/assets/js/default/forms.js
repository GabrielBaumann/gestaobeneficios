// url geral
import { getBaseURL, fncMessage, showSplash, fncCheckInput, fncControllerEmpty  } from "../libs/utility";

// Envio padrão de formulário
document.addEventListener("submit", async (e) => {
    if (e.target.tagName !== "FORM") return;

    e.preventDefault();

    // Verfifica os campos obrigatórios no javascritp
    const resultController = await fncControllerEmpty(e)
    
    if (!resultController) {
        // Encaminha os inputs para o controlador e devolve a resposta dos campos vazios
        fncCheckInput()
        return
    }
        
    const form = e.target;
    const actionForm = form.action;

    // Confirmação (se existir)
    if (form.dataset.confirm === "true") {
        const confirmed = await fncModalQuest(form.dataset.message);

        // Se não confirmou, para a execução aqui
        if (!confirmed) {
            return;
        }

        // Se confirmou, continua com o envio normal
    }

    // Envio normal do fomulário
    await submitForm(form, actionForm, e.submitter);
})

// Reposta do modal de confirmação
document.addEventListener("submit", async (e) => {
    if (!e.target.matches("#modal-quest")) return;

    e.preventDefault();

    const modalForm = e.target;
    const url = modalForm.action;

    let response = "";
    const formData = new FormData(modalForm, e.submitter);
  
    try {
        const vResponse = await fetch(url, {
            method: "POST",
            body: formData
        })

        const vData = await vResponse.json();

        if (vData.response) {
            // console.log("Passou")
            response = "sim"
        }

    } catch (err) {
        fncMessage(err, true)
    }

    // const response = modalForm.querySelector('input[name="resposta"]')?.value;

    document.getElementById("modal")?.remove();

    const event = new CustomEvent("modalQuestResponse", {
        detail: { resposta: response === "sim"}
    })

    document.dispatchEvent(event);

})

// Função para envio do formulário principal
async function submitForm(form, actionForm, submitter) {
    let timeoutLoading = showSplash();
    
    try {
        const formData = new FormData(form, submitter);
        const vResponse = await fetch(actionForm, {
            method: "POST",
            body: formData
        });
        
        const vData = await vResponse.json();
        document.getElementById("modal")?.remove();

        // Redireciona
        if (vData.redirected) {
            window.location.href = vData.redirected;
        }
        
        // Redireciona e cria uma nova aba (impressão)
        if (vData.redirectedBlank) {
            window.open(vData.redirectedBlank, "_blank");
        }

        // Retorna mensagem
        if (vData.message) {
            fncMessage(vData.message);
        }

        // Retorna um elemento dinâmico ajax
        if (vData.html) {
            const vReplaceContent = document.querySelector("." + vData.contentajax);
            vReplaceContent.innerHTML = vData.html;
        }

        // Retorna uma janela modal
        if (vData.modal) {
            const vElement = document.createElement("div");
            vElement.id = "modal";
            vElement.innerHTML = vData.modal;
            document.body.appendChild(vElement);
        }

    } catch (error) {
        fncMessage(error, true);
    } finally {
        timeoutLoading?.remove();
    }
}

// Chama o modal quest
async function fncModalQuest(message) {

    return new Promise(async (resolve) => {
        const timeoutLoading = showSplash();

        try {
            const url = getBaseURL() + "modalquest"
            const formData = new FormData();
            formData.append("text", message);

            const reponse = await fetch(url, {
                method: "POST",
                body: formData
            })

            const data = await reponse.json()

            // Abrir modal de confirmação
            if (data.modal) {
                const vElement = document.createElement("div");
                vElement.id = "modal";
                vElement.innerHTML = data.modal;
                document.body.appendChild(vElement); 
            }

        } catch (err) {
            fncMessage(err, true);
        } finally {
            timeoutLoading?.remove();
        }

        // Escuta a resposta do modal
        const handleResponse = (e) => {

            document.removeEventListener("modalQuestResponse", handleResponse);
            resolve(e.detail.resposta)

        };

        document.addEventListener("modalQuestResponse", handleResponse);
    });
}

// Cancelar ação
document.addEventListener("click", (e) => {
    if (e.target.matches("#cancelBtn")) {
        const event = new CustomEvent("modalQuestResponse", {
            detail: { resposta: false}
        });
        document.dispatchEvent(event);
    }
})

// Fechar modal clicando no overlay (fora da modal)
document.addEventListener("click", (e) => {
    if(e.target.id === "confirmationModal") {
        const event = new CustomEvent("modalQuestResponse", {
            detail: { resposta: false}
        });
        document.dispatchEvent(event);
    }
})

// Fechar com ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const event = new CustomEvent("modalQuestResponse", {
            detail: { resposta: false}
        });
        document.dispatchEvent(event);
    }
});