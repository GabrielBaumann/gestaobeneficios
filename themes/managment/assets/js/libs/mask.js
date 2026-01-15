import { fncMessage } from "./utility";

// Máscara para CPF em qualquer input mesmo se adicionado dinamicamente
export function fncMaskCpf() {

    const vInput = document.querySelectorAll(".clean-cpf")

    vInput.forEach(element => {
        element.addEventListener("input", function() {
    
        let value = this.value.replace(/\D/g, '');

        // Limita a 11 dígitos
        value = value.slice(0, 11);

        // Aplica a máscara do CPF
        if (value.length >= 10) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        } else if (value.length >= 7) {
            value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        } else if (value.length >= 4) {
            value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        }

        // Atualiza apenas se houve mudança para evitar problemas com cursor
        if (this.value !== value) {
            this.value = value;
        }
        })
    })

}

export function fncCheckedCPF() {

    const vInput = document.querySelectorAll(".clean-cpf")

    vInput.forEach(ele => {
        ele.addEventListener("blur", async function  () {

            const vCpf = this.value.replace(/\D/g, '')
            const vLabel = document.querySelector('label[for="'+ this.id +'"]');

            if(vCpf.length === 11) {

                const vUrlCpf = this.dataset.url + "/" + vCpf

                try {

                    const vReponse = await fetch(vUrlCpf);

                    const vData = await vReponse.json()

                    if(vData.status === false) {
                        fncMessage(vData.message)

                        this.classList.add("requerid-alert");
                        vLabel.classList.add("requerid-alert")

                        return;
                    }

                        this.classList.remove("requerid-alert");
                        vLabel.classList.remove("requerid-alert")


                } catch (error) {
                    fncMessage()
                }

            }
            this.classList.remove("requerid-alert");
            vLabel.classList.remove("requerid-alert")            
        })
    })

}

// Verificar email
export function fncCheckedEmail() {

    const vInput = document.querySelectorAll(".clean-email")

    vInput.forEach(ele => {
        ele.addEventListener("blur", async function  () {

            const vEmail = this.value
            const vLabel = document.querySelector('label[for="'+ this.id +'"]');

            if(vEmail.length !== 0) {

                const vEmailUrl = this.dataset.url + "/" + vEmail

                try {

                    const vReponse = await fetch(vEmailUrl);

                    const vData = await vReponse.json()

                    if(vData.status === false) {
                        fncMessage(vData.message)
                        
                        this.classList.add("requerid-alert");
                        vLabel.classList.add("requerid-alert")

                        return;
                    }

                        this.classList.remove("requerid-alert");
                        vLabel.classList.remove("requerid-alert")


                } catch (error) {
                    fncMessage()
                }

            }
            this.classList.remove("requerid-alert");
            vLabel.classList.remove("requerid-alert")            
        })
    })

}

// Validar número de CPF
function validarCPF(cpf) {
    // Remove tudo que não for número
    cpf = cpf.replace(/\D/g, '');

    // Verifica se tem 11 dígitos
    if (cpf.length !== 11) return false;

    // Elimina CPFs inválidos conhecidos (todos os dígitos iguais)
    if (/^(\d)\1+$/.test(cpf)) return false;

    // Validação do primeiro dígito verificador
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }

    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) return false;

    // Validação do segundo dígito verificador
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }

    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) return false;

    return true;
}

// document.addEventListener("focusin", (e) => {
//     if (e.target.id === "cpf" && document.getElementById("idSystemUser")?.value !== "") {
//         cpfInitialEdit = e.target.value;
//     }

//     if (e.target.id === "cpf" && document.getElementById("idSystemUser")?.value === "") {
//         cpfInitialEdit = "";
//     }
// });

// // Verificar quantidade de digito no cpf
// document.addEventListener("focusout", function(e) {
//     if (e.target.id === "cpf") {
//         if(e.target.value !== "") {
            
//             const vLabel = e.target.name;
//             const vValue = e.target.value;
//             const vUrl = e.target.dataset.url;
//             const vForm = new FormData();
//             vForm.append(vLabel, vValue.replace(/\D/g, ''));

//             // Verificar se existe o ID para não editar o CPF
//             if(document.getElementById("idSystemUser")?.value !== "") {
//                 const vIdUserSystem = document.getElementById("idSystemUser");
//                 vForm.append(vIdUserSystem.name, vIdUserSystem.value);
//             }
      
//             fetch(vUrl, {
//                 method: "POST",
//                 body: vForm
//             })
//             .then(response => response.json())
//             .then(data => {

//                 if(data.message) {
//                     fncMessage(data.message)
//                 }
                
//                 if(data.erro === true) {
//                     if(cpfInitialEdit) {
//                         document.getElementById("cpf").value = cpfInitialEdit;
//                     } else {
//                         document.getElementById("cpf").value = "";
//                     }
//                 }
//             })
//         }
//     }
// });

// Máscara para telefone
export function fncPhone () {
    
    const vInput = document.querySelectorAll(".clean-input-phone")
    
    vInput.forEach(element => {
        document.addEventListener('input', function() {
            let value = element.value.replace(/\D/g, '');

                if (value.length > 11) value = value.substring(0, 11);
                
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                element.value = value;       
        });
    })
}

// document.addEventListener("focusout", function(e) {
//     if (e.target.id === "telephone") {
//         const vCountCpf = e.target.value.replace(/\D/g, '');
//         if (vCountCpf.length < 11) {
//             e.target.value ="";
//         }
//     }
// })
