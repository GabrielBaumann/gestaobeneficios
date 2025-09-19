let load = "";

document.addEventListener("submit", async (e)=> {

    if (e.target.tagName === "FORM") {
        e.preventDefault()

        const form = e.target;
        const formData = new FormData(form);
        const actionForm = e.target.action;

        let timeoutLoading;

        // Agenda a exibição do "carregamento..." após 300 milesimo
        timeoutLoading = showSplash()

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

                if(document.getElementById("response")) document.getElementById("response").remove()

                const novoResponse = document.createElement("div")
                novoResponse.id = "response";
                novoResponse.innerHTML = vData.message

                document.body.appendChild(novoResponse);

                setTimeout(() => {
                    removeElement(novoResponse)
                }, 3000)
            }

            if(vData.element) {
                const novoResponse = document.createElement("div")
                novoResponse.id = "link";
                novoResponse.innerHTML = vData.element
                document.body.appendChild(novoResponse);
            }

        } catch (error) {
            const erroResponse = document.createElement("div");
            erroResponse.id = "response";
            erroResponse.innerHTML = `
                <div class="alert-container">
                    <div class="alert-message bg-white border border-red-400 rounded-lg p-4 text-red-700">
                        Erro inesperado. Tente novamente.
                    </div>
                </div>
            `;
           document.body.appendChild(erroResponse);

           setTimeout(() => {
                removeElement(erroResponse)
           }, 3000);           
        } finally {
            timeoutLoading?.remove();
        }
    }
});

/**
 * evento para fechar messagem
 */
document.body.addEventListener("click", (e) => {
    const botao = e.target.closest("#botao");
    const message = e.target.closest(".alert-container");

    if (botao && message) {
        message.style.transition = "opacity 0.5s ease";
        message.style.opacity = "0";
        setTimeout(() => message.remove(), 2000);
    }
})

/**
 * Função para evento de saída 
 */
function removeElement(element, duration = 1000) {
    if(!element) return;
        element.style.transition = "opacity 0.5s ease";
        element.style.opacity = "0";
    setTimeout(()=> element.remove(), duration);
}

// Remove mensagem flash
window.onload = function () {
    const e = document.querySelector('.alert-container');
    if(e) {
        setTimeout(() => {
            removeElement(e, 3000);
        }, 3000);
    }
}


// Função para chamar tela de splash e remover mensagens anteriores
function showSplash () {
    return document.body.appendChild(fncSplash());
}

// Funcção que cria tela de splash
function fncSplash() {
    load = document.createElement("div");
    load.id = "response";
    load.innerHTML = 
    `
        <div class="main h-full w-full bg-gray-50 absolute top-0 left-0">
            <div class="container mx-auto px-4 h-full flex items-center justify-center">
                <div class="text-center">
                    <!-- Texto animado -->
                    <h1 class="text-4xl md:text-5xl font-normal text-gray-800">
                        Carregando
                    </h1>
                    <div class="dots flex space-x-6 mt-10 justify-center">
                        <div class="dot-1 w-6 h-6 bg-blue-900"></div>
                        <div class="dot-2 w-6 h-6 bg-blue-600"></div>
                        <div class="dot-3 w-6 h-6 bg-blue-500"></div>
                    </div>
                </div>
            </div>
        </div>

        `;
    return load;
}

// document.addEventListener("input", function(e) {
//     if (e.target && e.target.id === "cpfuser") {
//         let value = e.target.value.replace(/\D/g, '');

//         // Limita a 11 dígitos
//         value = value.slice(0, 11);

//         // Aplica a máscara do CPF
//         if (value.length >= 10) {
//             value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
//         } else if (value.length >= 7) {
//             value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
//         } else if (value.length >= 4) {
//             value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
//         }

//         e.target.value = value;
//     }
// });