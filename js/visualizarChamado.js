document.addEventListener('DOMContentLoaded', function() {
    console.log('visualizarChamado.js carregado.');

    // Animação inicial
    const container = document.getElementById('container');
    if (container) {
        requestAnimationFrame(() => container.classList.add('loaded'));
    }

    // Controle do select de encaminhar
    const select = document.getElementById('encaminhar');
    const btnEncaminhar = document.getElementById('btn-encaminhar');
    if (select && btnEncaminhar) {
        select.addEventListener('change', function() {
            btnEncaminhar.disabled = !select.value;
        });
    }

    // Intercepta o envio do formulário "Aceitar Chamado"
    const formAceitar = document.getElementById('form_aceitar_chamado');
    if (formAceitar) {
        console.log('Form aceitar chamado encontrado e pronto para interceptar o submit.');
        formAceitar.addEventListener('submit', async function(event) {
            event.preventDefault(); // Impede o envio tradicional

            const formData = new FormData(formAceitar);
            const fallbackId = formData.get('id_chamados');

            try {
                const response = await fetch(formAceitar.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const textoResposta = await response.text();
                let resultado;

                try {
                    resultado = JSON.parse(textoResposta);
                } catch (e) {
                    console.error('Resposta do PHP não é JSON válido:', textoResposta);
                    alert('Erro na resposta do servidor. Verifique o console do navegador (F12).');
                    return;
                }

                if (resultado.sucesso) {
                    const idChamado = resultado.id_chamado || fallbackId;
                    if (!idChamado) {
                        alert('ID do chamado não foi retornado pelo servidor.');
                        return;
                    }
                    window.location.assign(`ticket_conversa.php?id_chamado=${encodeURIComponent(idChamado)}`);
                } else {
                    alert(resultado.mensagem || 'Não foi possível aceitar o chamado.');
                }
            } catch (error) {
                    console.error('Erro na requisição AJAX:', error);
                    if (fallbackId) {
                        window.location.assign(`ticket_conversa.php?id_chamado=${encodeURIComponent(fallbackId)}`);
                    } else {
                        alert('Ocorreu um erro ao processar a solicitação.');
                    }
                }
            });
            window.__aceitarChamadoIntercepted = true;
    }
});