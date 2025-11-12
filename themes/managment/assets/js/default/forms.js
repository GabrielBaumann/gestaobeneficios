// Envio padrão de formulário
document.addEventListener("submit", async (e)=> {

    if (e.target.tagName === "FORM") {

        e.preventDefault()

        const form = e.target;
        const formData = new FormData(form, e.submitter);
        const actionForm = e.target.action;

        let timeoutLoading;
        timeoutLoading = showSplash(true)

        try {
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
            fncMessage();
        } finally {
            timeoutLoading?.remove();
        }
    }
});