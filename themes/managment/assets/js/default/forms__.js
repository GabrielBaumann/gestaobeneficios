// url geral
import { getBaseURL, fncMessage, showSplash  } from "../libs/utility";

// Envio padrão de formulário
document.addEventListener("submit", async (e)=> {

    if (e.target.tagName !== "FORM") return;

        e.preventDefault()

        const form = e.target;
        const actionForm = form.action;
        let timeoutLoading;
        
        // ---- CONFIRMAÇÃO (se existir) ----
        if(form.dataset.confirm === "true") {
            
            // timeoutLoading = showSplash();
            const teste = await fncModalQuest(form.dataset.message)
            // console.log(teste);
            if (teste) {
                return;
            }

            // Resposta de um evento de clique de fora desse escopo

        }   
        
        // -------- ENVIO NORMAL DO FOMULÁRIO -----
        //  e.preventDefault()
        // const form = e.target;
        // const formData = new FormData(form, e.submitter);
        // const actionForm = e.target.action;

        // let timeoutLoading;
        timeoutLoading = showSplash();
        
        try {
            const formData = new FormData(form, e.submitter);

            const vResponse = await fetch(actionForm, {
            method: "POST",
            body: formData
        })
            const vData = await vResponse.json();
            
            document.getElementById("modal")?.remove();

            // Redireciona
            if(vData.redirected) {
                window.location.href = vData.redirected
            }
            
            // Redireciona e cria uma nova aba (impressão)
            if(vData.redirectedBlank) {
                window.open(vData.redirectedBlank, "_blank");
            }

            // Retorna mensagem
            if(vData.message){
                fncMessage(vData.message)
            }

            // Retorna um elemento dinâmico ajax
            if(vData.html) {
                const vReplaceContent = document.querySelector("." + vData.contentajax);
                vReplaceContent.innerHTML = vData.html;
            }

            // Retorna uma janela modal
            if(vData.modal) {
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
    // }
});

// Resposta do modal
document.addEventListener("submit", async (e) => {
    if(!e.target.matches("#modal-quest")) return;

    e.preventDefault();
    console.log(e);
    return true;
})

// Chama o modal quest
async function fncModalQuest(message) {
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

        // Se o backedn retornou confirmação 
        if (data.response === true) {
            confirmed = true
        }

    } catch (err) {
        fncMessage(err, true);
    } finally {
        timeoutLoading?.remove();
    }
    return true;
}

