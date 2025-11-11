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

// ======== Marcar tarefa como concluída ========
function marcarConcluida(idTarefa) {
    const tarefa = document.getElementById(`tarefa-${idTarefa}`);
    if (!tarefa) return;

    // Atualiza visualmente
    tarefa.classList.toggle('concluida');

    // Atualiza no banco de dados via AJAX
    fetch(`./concluirTarefa.php?id=${idTarefa}`)
        .then(resp => {
            if (!resp.ok) throw new Error("Erro ao atualizar tarefa");
        })
        .catch(err => {
            console.error(err);
            // Desfaz visualmente se deu erro
            tarefa.classList.toggle('concluida');
            alert("Não foi possível atualizar o status da tarefa.");
        });
}

function editarTarefa(id) {
    const novoNome = prompt("Novo nome da tarefa:");
    const novaDescricao = prompt("Nova descrição da tarefa:");

    if (!novoNome) return;

    fetch('../php/editarTarefa.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&nome=${encodeURIComponent(novoNome)}&descricao=${encodeURIComponent(novaDescricao)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'sucesso') {
            location.reload();
        } else {
            alert('Erro: ' + data.mensagem);
        }
    })
    .catch(err => console.error('Erro na requisição:', err));
}


function excluirTarefa(id) {
    if (!confirm("Tem certeza que deseja excluir esta tarefa?")) return;

    fetch('../php/excluirTarefa.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'sucesso') {
            location.reload();
        } else {
            alert('Erro: ' + data.mensagem);
        }
    })
    .catch(err => console.error('Erro na requisição:', err));
}

