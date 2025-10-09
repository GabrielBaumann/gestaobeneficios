// document.addEventListener("click", (e) =>{
//     const conteudos = document.querySelectorAll("[id^='conteudo']");

//     // document.getElementById("gerarPdf").remove();

//     if (conteudos.length === 0) {
//         alert("Nenhum conteúdo encontrado!");
//         // return;
//     }

//     // Cria um contêiner invisível para armazenar os clones das páginas
//     // const container = document.createElement("div");
//     // container.style.position = "absolute";
//     // container.style.left = "-9999px";
//     // container.style.width = "210mm";
//     // container.style.background = "white";

//     const container = document.body.cloneNode(true);

//     // Clona o body inteiro para cada conteúdo
//     conteudos.forEach((conteudo, index) => {
//         const bodyClone = document.body.cloneNode(true);
   

//         // Substitui o conteúdo dinâmico
//         const target = bodyClone.querySelector("#conteudo");
//         if (target) {
//             target.innerHTML = conteudo.innerHTML;
//         }

//         // Adiciona quebra de página (exceto no último)
//         if (index < conteudos.length - 1) {
//             const quebra = document.createElement("div");
//             quebra.style.pageBreakAfter = "always";
//             bodyClone.appendChild(quebra);
//         }

//         container.appendChild(bodyClone);
//     });

//     document.body.appendChild(container);

//     // Configuração do PDF
//     const opcoes = {
//         margin: 0,
//         filename: "Oficio_SEMDES_CartaoSocial.pdf",
//         image: { type: "jpeg", quality: 0.98 },
//         html2canvas: { scale: 2, useCORS: true },
//         jsPDF: { unit: "mm", format: "a4", orientation: "portrait" }
//     };

//     html2pdf().set(opcoes).from(container).save();

//     // Remove o container temporário
//     document.body.removeChild(container);
// })

// document.getElementById('gerarPdf').addEventListener('click', function() {
//     // Seleciona todos os elementos que serão páginas
//     const elementos = document.querySelectorAll('.pagina-pdf');

//     const opcoes = {
//         filename: 'Oficio_SEMDES_CartaoSocial.pdf',
//         margin: 10,
//         image: { type: 'jpeg', quality: 0.98 },
//         html2canvas: { scale: 2 },
//         jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
//     };

//     const pdf = html2pdf();
    
//     // Configura as opções
//     pdf.set(opcoes);
    
//     // Adiciona cada elemento como uma página
//     elementos.forEach(elemento => {
//         console.log(elemento);
//         pdf.from(elemento);
//     });
    
//     // Salva o PDF com todas as páginas
//     pdf.save();
// });

document.getElementById('gerarPdf').addEventListener('click', function() {
    const elementos = document.querySelectorAll('.pagina-pdf');
    
    const opcoes = {
        filename: 'Oficio_SEMDES_CartaoSocial.pdf',
        margin: 10,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { 
            scale: 2,
            useCORS: true,
            logging: false
        },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Abordagem 1: Criar um elemento container temporário
    const containerTemp = document.createElement('div');
    // containerTemp.style.position = 'absolute';
    // containerTemp.style.left = '1000px';
     
    // Clona cada página para o container temporário
    elementos.forEach(pagina => {
        console.log(pagina.getBoundingClientRect().height)
        const clone = pagina.cloneNode(true);
        containerTemp.appendChild(clone);
    });
    
    document.body.appendChild(containerTemp);
    
    // Gera o PDF a partir do container temporário
    html2pdf()
        .set(opcoes)
        .from(containerTemp)
        .save()
        .then(() => {
            // Remove o container temporário após gerar o PDF
            document.body.removeChild(containerTemp);
            console.log('PDF gerado com sucesso!');
        })
        .catch(error => {
            console.error('Erro ao gerar PDF:', error);
            document.body.removeChild(containerTemp);
        });
});