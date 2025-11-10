// Mostra o formulário de edição
function editarCategoria(id, nome) {
    document.getElementById('view-' + id).classList.add('d-none');
    document.getElementById('form-' + id).classList.remove('d-none');
}

// Cancela a edição
function cancelarEdicao(id) {
    document.getElementById('view-' + id).classList.remove('d-none');
    document.getElementById('form-' + id).classList.add('d-none');
}

// Exclui categoria com confirmação
function excluirCategoria(id) {
    if (confirm('Tem certeza que deseja excluir esta categoria?')) {
        window.location.href = './php/excluirCategoria.php?id=' + encodeURIComponent(id);
    }
}

// Evita que o clique nos botões ative o link da categoria
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btn-editar, .btn-excluir").forEach(btn => {
        btn.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();

            const id = btn.getAttribute("data-id");
            const nome = btn.getAttribute("data-nome");

            if (btn.classList.contains("btn-editar")) {
                editarCategoria(id, nome);
            } else {
                excluirCategoria(id);
            }
        });
    });
});


function adicionarTarefa(idTema) {
    const nome = prompt("Nome da nova tarefa:");
    if (!nome || nome.trim() === "") return;
    const descricao = prompt("Descrição da tarefa (opcional):") || "";
    // redireciona para php/novaTarefa.php (relativo a php/categoria.php)
    window.location.href = "./novaTarefa.php?tema=" + idTema + "&nome=" + encodeURIComponent(nome) + "&descricao=" + encodeURIComponent(descricao);
}

function adicionarTema(idCategoria) {
    const nome = prompt("Nome do novo tema/coluna:");
    if (!nome || nome.trim() === "") return;
    window.location.href = "./novaTema.php?categoria=" + idCategoria + "&nome=" + encodeURIComponent(nome);
}

function editarTema(idTema, nomeAtual) {
    const novoNome = prompt("Digite o novo nome do tema:", nomeAtual);
    if (!novoNome || novoNome.trim() === "" || novoNome === nomeAtual) return;
    window.location.href = "./editarTema.php?id=" + idTema + "&nome=" + encodeURIComponent(novoNome);
}

function excluirTema(idTema) {
    if (!confirm("Tem certeza que deseja excluir este tema?")) return;
    window.location.href = "./excluirTema.php?id=" + idTema;
}