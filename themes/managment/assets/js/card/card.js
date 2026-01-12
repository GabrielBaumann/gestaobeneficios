// Status do cartão do beneficiário
const statuscard = document.querySelectorAll(".status")

statuscard.forEach((e) => {
    if (e.textContent.trim() === "cancelado") {
        e.classList.replace("bg-green-100","bg-red-100")
        e.classList.replace("text-green-800","text-red-800")
    }

    if (e.textContent.trim() === "confecção") {
        e.classList.replace("bg-green-100","bg-orange-100")
        e.classList.replace("text-green-800","text-orange-800")
    }

    if (e.textContent.trim() === "aguardando cartão") {
        e.classList.replace("bg-green-100","bg-blue-100")
        e.classList.replace("text-green-800","text-blue-800")
    }

    if (e.textContent.trim() === "cancelado ocorrencia") {
        e.classList.replace("bg-green-100","bg-red-100")
        e.classList.replace("text-green-800","text-red-800")
    }

    if (e.textContent.trim() === "solicitado") {
        e.classList.replace("bg-green-100","bg-yellow-100")
        e.classList.replace("text-green-800","text-yellow-800")
    }

})
