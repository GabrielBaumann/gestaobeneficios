// Envio padrão de formulário
document.addEventListener("submit", async (e)=> {

    if (e.target.tagName === "FORM") {
        e.preventDefault()

        const form = e.target;
        const formData = new FormData(form);
        const actionForm = e.target.action;

        let timeoutLoading;
        timeoutLoading = showSplash(true)

        try {
            const vResponse = await fetch(actionForm, {
            method: "POST",
            body: formData
        })
            const vData = await vResponse.json();

            if(vData.redirected) {
                window.location.href = vData.redirected
            }
            
            if(vData.message){
                fncMessage(vData.message)
            }

            if(vData.html) {
                const vReplaceContent = document.querySelector(".content-ajax");
                vReplaceContent.innerHTML = vData.html;
            }

        } catch (error) {
            fncMessage();
        } finally {
            timeoutLoading?.remove();
        }
    }
});