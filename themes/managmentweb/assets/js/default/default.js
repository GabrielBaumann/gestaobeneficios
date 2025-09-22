//*  Scripts padrões para todo o sistema *//
let vArrayInput = [];
removeFlash()

// Verifica o tamanho da tela e chama a função de responsividade
window.addEventListener("resize", updateResponsive);
updateResponsive();

// Função para redimencionar o modo de resposividade
function updateResponsive() {
    if(window.matchMedia("(max-width: 600px)").matches) {
        // Modo celular
        const vUrlPage =  window.location.pathname.replace(/\/$/, "").split("/").pop();
        const vMenus = document.querySelectorAll("span.mobile");

        vMenus.forEach(vElemet => {

            if(vElemet.dataset.sidebar === vUrlPage) {
                vElemet.closest("a.mobile").classList.remove("text-gray-600")
                vElemet.closest("a.mobile").classList.add("text-blue-800");
            }
        });
    } else {
        // Modo desktop
        const vUrlPage =  window.location.pathname.replace(/\/$/, "").split("/").pop();
        const vMenus = document.querySelectorAll("span.menu");

        vMenus.forEach(vElemet => {
            if(vElemet.dataset.sidebar === vUrlPage) {
                vElemet.closest("a.menu").classList.remove("text-gray-800", "border-gray-300");
                vElemet.closest("a.menu").classList.add("text-green-800", "border-l-2", "border-green-800", "hover:none");
            }
        });
    }
}

//Função usada no evendo de sidebar 
function fncSanitizeCaractere(vTextSanitize) {

    return vTextSanitize
        .toLowerCase()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
        .replace(/[^a-z0-9\s]/g, "")
        .trim();
}

// Aviso de input vazio realce no campo e na label
const vform = document.getElementsByTagName('form');
if (vform) {

    document.addEventListener("submit", (e) => {
        const vLabel = document.querySelectorAll("label");
        vLabel.forEach(element => {
            if(element.innerText.includes("*") && element.nextElementSibling.value === "") {
                element.classList.add("requerid-alert");
                element.nextElementSibling.classList.add("requerid-alert");        
            };
        })
    })

    document.addEventListener("input", (e) => {
        if(e.target.classList.contains("requerid-alert") && e.target.value != "") {
            e.target.classList.remove("requerid-alert")
            e.target.previousElementSibling.classList.remove("requerid-alert");
        };
    })
}


/*#################################*/
/**###### Função de mensagem ######*/
/**############################### */
function showSplash($new = false) {
    if(document.getElementById("response")) document.getElementById("response").remove();
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
        
    if($new) {
        return document.body.appendChild(load);
    } else {
        return setTimeout (() => {
            document.body.appendChild(load);
        }, 500);
    }
}

function removeFlash() {
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
function fncMessage(vMessage) {

    // Remove qualquer mensagem que possa estar no DOM
    if(document.getElementById("response")) document.getElementById("response").remove();

    const vNewMessage = document.createElement("div");
    vNewMessage.id = "response";
    
    // Se a função for chamada sem o argumento mensagem ela devolve a mensagem de erro
    if(!vMessage) {
        vMessage = `
            <div class="alert-container">
                <div class="alert-message bg-white border border-red-400 rounded-lg p-4 text-red-700">
                    Erro inesperado. Tente novamente.
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

// Evento para fechar mensagem no clique na mensagem
document.addEventListener("click", (e) => {
    const vButton = e.target.closest("#button-close");   
    if(vButton) {
        const vMessage =  e.target.closest(".alert-container");
        vMessage.style.transition = "opacity 0.5s ease";
        vMessage.style.opacity = "0";
        setTimeout(() => vMessage.remove(), 2000)

        document.getElementById("response")?.remove();
    }
});

/*######## End ##################*/

/**loading href */
document.addEventListener("DOMContentLoaded", function () {
    const vLinks = document.querySelectorAll("a.menu, a.mobile");

    vLinks.forEach(link => {
        if (link.hostname === window.location.hostname) {
            link.addEventListener("click", function(e) {
                if (link.target === "_black") return;
                showSplashNavigation();
            });
        }
    });
});

function showSplashNavigation() {
    if(document.getElementById("response")) document.getElementById("response").remove();
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
    return setTimeout (() => {
        document.body.appendChild(load);
    }, 300);
}



/*########################################*/
/*#############  Modal yes/no ############*/
/*########################################*/

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

// toggle menu on mobile
function toggleMenu() {
    const sidebar = document.getElementById("sidebar-main");
    const main = document.getElementById("main-area");

    if (sidebar.classList.contains("hidden")) {
        sidebar.classList.remove("hidden");
        main.classList.add("hidden");

    } else {
        sidebar.classList.add("hidden");
        main.classList.remove("hidden");
    }
}