/*#################################*/
/**###### Função Url base ######*/
/**############################### */
export function getBaseURL(level = 1) {
    const origin = window.location.origin;
    const path = window.location.pathname.split("/").filter(Boolean);

    const projectFolder = path.slice(0, level).join("/");

    return `${origin}/${projectFolder}/`;
}


/*#################################*/
/**###### Função de mensagem ######*/
/**############################### */
// Mensagem de carregando
export function showSplash() {
    if(document.getElementById("response")) document.getElementById("response").remove();
    const load = document.createElement("div");
    load.id = "response";
    load.innerHTML = 
    `
        <div class="main h-full w-full bg-gray-50 absolute top-0 left-0">
            <div class="container mx-auto px-4 h-full flex items-center justify-center">
                <div class="text-center">
                    <!-- Texto animado -->
                    <h1 class="text-4xl md:text-5xl font-normal text-gray-800">
                        Carregando...
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
    return document.body.appendChild(load);
}

// Remover mensagem flash (pós evento e redirecionamento de link)
export function removeFlash() {
    const element = document.querySelectorAll(".alert-container");

    element.forEach(el => {
        setTimeout(() => {
            el.style.transition = "opacity 0.5s ease";
            el.style.opacity = "0";
            
            setTimeout(() => el.remove(), 3000);
        }, 3000);
        document.getElementById("response")?.remove();
    });
}

// função para montar a mensagem e remover a mensagem
export function fncMessage(vMessage, vErr = false) {

    // Remove qualquer mensagem que possa estar no DOM
    if(document.getElementById("response")) document.getElementById("response").remove();

    const vNewMessage = document.createElement("div");
    vNewMessage.id = "response";
    
    // Se a função for chamada sem o argumento mensagem devolve a mensagem de erro
    if(vErr) {
        vMessage = `
            <div class="alert-container">
                <div class="alert-message bg-white border border-red-400 rounded-lg p-4 text-red-700">
                    ${vMessage}
                </div>
            </div>
        `;  
    }
        
    vNewMessage.innerHTML = vMessage
    document.body.appendChild(vNewMessage);

    setTimeout(() => {
        if(!vNewMessage) return;
            vNewMessage.style.transition = "opacity 0.5s ease";
            vNewMessage.style.opacity = "0";
            setTimeout(() => vNewMessage.remove(), 1000)
    }, 4000);    
}

/*#################################*/
/**###### Função de inputs ######*/
/**############################### */
// Aviso de input vazio realce no campo e na label
export function fncCheckInput() {
    const vLabel = document.querySelectorAll("label");
    let result = false;
    vLabel.forEach(element => {
        if (element.innerText.includes("*")) {
            const elemente =  document.getElementById(element.getAttribute("for"))

            if (elemente.value === "") {
                element.classList.add("requerid-alert");
                elemente.classList.add("requerid-alert");
                result = true;
            }
        }
    })

    document.addEventListener("input", (e) => {
        if(e.target.classList.contains("requerid-alert") && e.target.value != "") {

            const label = document.querySelector(`label[for="${e.target.id}"]`)
            label.classList.remove("requerid-alert")
            e.target.classList.remove("requerid-alert")
        };
    })
    return result;
}

// Pesquisar valores e devolver resultado
export function fncSearchInput(){
    document.getElementById("search-all")?.addEventListener("click", async (e) => {

        const vInputsSearch = document.querySelectorAll(".input-search");
        const vForm = new FormData();
        const vArrayInput = [];
        const vUrl = e.target.closest("button").dataset.url;

        vInputsSearch.forEach(element => {

            const vName = element.name;
            const vValue = element.value;
            const vIndex = vArrayInput.findIndex(objt => objt.hasOwnProperty(vName));

            if (vIndex !== -1) {
                vArrayInput[vIndex][vName] = vValue;
            } else {
                vArrayInput.push({[vName] : vValue});
            }
        });

        vArrayInput.forEach(obj => {
            for (let key in obj) {
                vForm.append(key, obj[key]);
            }
        });

        let timeoutLoading = showSplash(true);

        try {
            const vResponse = await fetch(vUrl, {
                method: "POST",
                body: vForm
            })

            const vData = await vResponse.json();
            
            if(vData.message) {
                fncMessage(vData.message);
                return;
            }

            if(vData.html) {
                document.querySelector(".ajax-update").innerHTML = vData.html;
            }

        } catch (error) {
            fncMessage();
        } finally {
            timeoutLoading?.remove();
        }

    });
}

// Limpar filtro
export function fncCleanInput() {
    document.getElementById("cleaninput")?.addEventListener("click", async (e) => {
        
        const vForm = new FormData();
        const vUrl = e.target.closest("button").dataset.url; 
        vForm.append("clean", "clean");
        let timeoutLoading = showSplash(true);

        try {

            const vResponse = await fetch(vUrl, {
                method: "POST",
                body: vForm
            })

            const vData = await vResponse.json();

            if(vData.html) {
                document.querySelector(".input-search").value = "";
                document.querySelector(".ajax-update").innerHTML = vData.html;
            }

        } catch (error) {
            fncMessage();
        } finally {
            timeoutLoading?.remove();
        }

    })
}

// Retorno do controlador campos vazios true/false
 export async function fncControllerEmpty(e)  {
    let timeoutLoading = showSplash();
    const form = e.target;
    const actionForm = form.action;

    try {
        const formData = new FormData(form, e.submitter);
        formData.append("valid", true);

        const vResponse = await fetch(actionForm, {
            method: "POST",
            body: formData
        });
       
        const vData = await vResponse.json();
        document.getElementById("modal")?.remove();
        
        // Retorna mensagem
        if (vData.message) {
            fncMessage(vData.message);
            return false;
        }
        
        if(vData.status) {
            return true;
        }
        
    } catch (error) {
        fncMessage(error, true);
        return false;
    } finally {
        timeoutLoading?.remove();
    }
}

/*#################################*/
/**###### Eventos para modal ######*/
/**############################### */
// Função para chamar modal quest

let arraymodal = [];

export function fncModalQuest (vIdButton) {
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
                
                const vModal = document.querySelectorAll(".modal");
                if(vModal.length === 0) {
                    arraymodal = []
                }

                const vElement = document.createElement("div");
                vElement.id = data.idmodal;
                arraymodal.push(data.idmodal)
                vElement.innerHTML = data.html;
                vElement.className = "modal"
                document.body.appendChild(vElement);
            })
        }
    });
}


// Cancelar ação
export function fncClosedModal() {
    document.addEventListener("click", (e) => {
        const vButton = e.target.closest("button")
        if(vButton && vButton.id === "cancelBtn") {
            document.getElementById("response")?.remove();
            
            // Caso haja um segundo modal preserva o primeiro
            const vModal = e.target.closest(".modal")

                document.getElementById(vModal.id).remove();
            if(arraymodal[1]) {
                document.getElementById(arraymodal[1])?.remove()
                arraymodal.pop()
            }

        }
    });
}

// Fechar modal clicando no overlay (fora da modal)
export function fncClosedOverlay() {
    document.addEventListener("click", (e) => {
        if(e.target.id === "confirmationModal") {
            document.getElementById("response")?.remove();

            // Caso haja um segundo modal preserva o primeiro
            const vModal = e.target.closest(".modal")
            document.getElementById(vModal.id).remove();
            if(arraymodal[1]) {
                document.getElementById(arraymodal[1])?.remove()
                arraymodal.pop()
            }

        }
    })
}

// Fechar com ESC
export function fncClosedEsc() {
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {

            document.getElementById("response")?.remove();

            const modal = document.querySelectorAll(".modal");
            const lastModal = modal[modal.length - 1]

            console.log(modal)

            if (lastModal) {
                lastModal.remove()
            }

            // Caso haja um segundo modal preserva o primeiro
            if(arraymodal[1]) {
                document.getElementById(arraymodal[1])?.remove()
                arraymodal.pop()
            }
        }
    });
}

// Sanitizar input
export function cleanInputText() {

    const vInput = document.querySelectorAll(".clean-input-text")

    vInput.forEach(element => {
        document.addEventListener("input", function() {

            // Remove acentos
            let valor =element.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            // Remove números e caracteres especiais (permite apenas letras e espaço)
            valor = valor.replace(/[^a-zA-Z\s]/g, "");

            // Converte para maiúsculas
            element.value = valor.toUpperCase();

        })
    })
}