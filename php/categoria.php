<?php
include_once('conexao.php');

$id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_categoria <= 0) {
    die("<h2>Categoria inválida.</h2>");
}

// Buscar nome da categoria
$sqlCat = "SELECT nome FROM categorias WHERE id = ?";
$stmt = $conn->prepare($sqlCat);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$resultCat = $stmt->get_result();
$categoria = $resultCat->fetch_assoc();
$stmt->close();

if (!$categoria) {
    die("<h2>Categoria não encontrada.</h2>");
}

// Buscar temas e tarefas
$sqlTemas = "
    SELECT t.id AS tema_id, t.nome AS tema_nome,
           ta.id AS tarefa_id, ta.nome AS tarefa_nome
    FROM temas t
    LEFT JOIN tarefas ta ON ta.id_tema = t.id
    WHERE t.id_categoria = ?
    ORDER BY t.id, ta.id
";
$stmt = $conn->prepare($sqlTemas);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();

$temas = [];
while ($row = $result->fetch_assoc()) {
    $temaId = $row['tema_id'];
    if (!isset($temas[$temaId])) {
        $temas[$temaId] = [
            'id' => $temaId,
            'nome' => $row['tema_nome'],
            'tarefas' => []
        ];
    }
    if (!empty($row['tarefa_id'])) {
        $temas[$temaId]['tarefas'][] = [
            'id' => $row['tarefa_id'],
            'nome' => $row['tarefa_nome']
        ];
    }
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($categoria['nome']) ?> - Kanban</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../css/estilo.css">
<style>
.kanban {
    display: flex;
    gap: 20px;
    padding: 20px;
    overflow-x: auto;
}
.coluna {
    background: #222;
    color: #fff;
    border-radius: 10px;
    padding: 15px;
    min-width: 250px;
    flex-shrink: 0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.4);
    transition: 0.2s;
}
body.light-mode .coluna {
    background: #f8f8f8;
    color: #333;
}
.coluna:hover {
    transform: scale(1.02);
}
.tarefa {
    background: #444;
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
    transition: 0.2s;
}
body.light-mode .tarefa {
    background: #e1e1e1;
}
.tarefa:hover {
    background: #666;
}
.add-tarefa {
    margin-top: 10px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    width: 100%;
    padding: 8px;
    cursor: pointer;
}
.add-tarefa:hover {
    background: #0056b3;
}
</style>
</head>
<body>

<button id="btnMenu" class="clicado">☰ Menu</button>

<div class="sidebar" id="sidebar">
    <a href="../index.php">🏠 Voltar</a>
    <h5><?= htmlspecialchars($categoria['nome']) ?></h5>
    <button id="btnTema" class="btn-tema"><i class="bi bi-moon-fill"></i></button>
</div>

<div class="conteudo" id="conteudo">
    <div class="kanban">
        <?php if (!empty($temas)): ?>
            <?php foreach ($temas as $tema): ?>
                <div class="coluna">
                    <h4><?= htmlspecialchars($tema['nome']) ?></h4>

                    <?php if (!empty($tema['tarefas'])): ?>
                        <?php foreach ($tema['tarefas'] as $tarefa): ?>
                            <div class="tarefa"><?= htmlspecialchars($tarefa['nome']) ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="opacity:0.6;">Sem tarefas</p>
                    <?php endif; ?>

                    <button class="add-tarefa" onclick="adicionarTarefa(<?= $tema['id'] ?>)">+ Adicionar tarefa</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h3 style="margin-left:20px;">Nenhum tema cadastrado para esta categoria.</h3>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnMenu = document.getElementById('btnMenu');
    const sidebar = document.getElementById('sidebar');
    const conteudo = document.getElementById('conteudo');
    const btnTema = document.getElementById('btnTema');

    if (btnMenu && sidebar && conteudo) {
        btnMenu.addEventListener('click', () => {
            sidebar.classList.toggle('ativo');
            conteudo.classList.toggle('shift');
        });
    }

    if (btnTema) {
        btnTema.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            const icon = btnTema.querySelector('i');
            if (document.body.classList.contains('light-mode')) {
                icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
            } else {
                icon.classList.replace('bi-sun-fill', 'bi-moon-fill');
            }
        });
    }
});

function adicionarTarefa(idTema) {
    const nome = prompt("Nome da nova tarefa:");
    if (nome && nome.trim() !== "") {
        window.location.href = "./php/novaTarefa.php?tema=" + idTema + "&nome=" + encodeURIComponent(nome);
    }
}
</script>
</body>
</html>
