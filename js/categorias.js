function editarCategoria(nome) {
    // Esconde a visualização e mostra o formulário
    document.getElementById('view-' + nome).classList.add('d-none');
    document.getElementById('form-' + nome).classList.remove('d-none');
}

function cancelarEdicao(nome) {
    // Esconde o formulário e mostra a visualização
    document.getElementById('view-' + nome).classList.remove('d-none');
    document.getElementById('form-' + nome).classList.add('d-none');
}

function excluirCategoria(nome) {
    if (confirm('Tem certeza que deseja excluir esta categoria?')) {
        window.location.href = './php/excluirCategoria.php?id=' + encodeURIComponent(nome);
    }
}