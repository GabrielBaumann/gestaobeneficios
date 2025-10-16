
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
     
    // Clona cada página para o container temporário
    elementos.forEach(pagina => {
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
