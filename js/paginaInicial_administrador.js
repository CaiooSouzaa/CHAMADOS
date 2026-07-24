let formAtual = null;

// Modal de Exclusão
function abrirModal(form) {
  formAtual = form;
  document.getElementById("modalOverlay").classList.add("active");
}

function fecharModal() {
  document.getElementById("modalOverlay").classList.remove("active");
  formAtual = null;
}

function confirmarExclusao() {
  if (formAtual) {
    formAtual.submit();
  }
}

// Fechar com clique fora ou tecla ESC
document.addEventListener("click", function (e) {
  const modalExcluir = document.getElementById("modalOverlay");
  const modalChamado = document.getElementById("modalChamadoOverlay");

  if (e.target === modalExcluir) fecharModal();
  if (e.target === modalChamado) fecharModalChamado();
});

document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    fecharModal();
    fecharModalChamado();
  }
});

// Modal de Gestão de Chamados
let chamadoEstado = {
  aceito: false,
  responsavelId: null
};

// Usa delegação de eventos para capturar o clique no botão de visualizar chamado
document.addEventListener("click", function (e) {
  // Procura se o clique veio do botão de ver chamado (ou de seu SVG interno)
  const btn = e.target.closest(".btn-ver-chamado");

  if (btn) {
    // Extrai os dados armazenados nos atributos data-* do botão
    const id = btn.dataset.id;
    const solicitante = btn.dataset.solicitante;
    const titulo = btn.dataset.titulo;
    const descricao = btn.dataset.descricao;

    abrirModalChamado(id, solicitante, titulo, descricao);
  }
});

function abrirModalChamado(id, solicitante, titulo, descricao) {
  document.getElementById('chamadoId').innerText = '#' + (id || '');
  document.getElementById('chamadoSolicitante').innerText = solicitante || 'Não informado';
  document.getElementById('chamadoTitulo').innerText = titulo || 'Sem título';
  document.getElementById('chamadoDescricao').innerText = descricao || 'Sem descrição fornecida.';

  voltarParaDetalhes();
  document.getElementById('modalChamadoOverlay').classList.add('active');
}

function fecharModalChamado() {
  document.getElementById('modalChamadoOverlay').classList.remove('active');
}

// Navegação entre telas do modal
function irParaEncaminhar() {
  document.getElementById('stepDetalhes').classList.remove('active');
  document.getElementById('stepEncaminhar').classList.add('active');
}

function voltarParaDetalhes() {
  document.getElementById('stepEncaminhar').classList.remove('active');
  document.getElementById('stepDetalhes').classList.add('active');
}

// Ações do chamado
function aceitarChamado() {
  chamadoEstado.aceito = true;
  
  // Atualiza a interface
  document.getElementById('statusBadge').className = 'badge badge-progress';
  document.getElementById('statusBadge').innerText = 'Em Andamento';
  
  document.getElementById('acoesIniciais').classList.add('hidden');
  document.getElementById('acoesEmAndamento').classList.remove('hidden');

  alert('Você aceitou o chamado!');
}

function confirmarEncaminhamento() {
  const select = document.getElementById('selectResponsavel');

  if (!select.value) {
    alert('Por favor, selecione um funcionário.');
    return;
  }

  const responsavelNome = select.options[select.selectedIndex].text;
  chamadoEstado.responsavelId = select.value;

  alert(`Chamado encaminhado para: ${responsavelNome}`);
  
  voltarParaDetalhes();
  fecharModalChamado();
}

function finalizarChamado() {
  document.getElementById('statusBadge').className = 'badge badge-done';
  document.getElementById('statusBadge').innerText = 'Finalizado';
  
  alert('Chamado finalizado com sucesso!');
  fecharModalChamado();
}