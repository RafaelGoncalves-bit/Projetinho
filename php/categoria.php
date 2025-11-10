<?php 
include_once('../php/conexao.php');
include_once('../php/listarCategorias.php');

$id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_categoria <= 0) die("<h2>Categoria inválida.</h2>");

// Buscar nome da categoria
$sqlCat = "SELECT nome FROM categorias WHERE id = ?";
$stmt = $conn->prepare($sqlCat);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$resultCat = $stmt->get_result();
$categoriaAtual = $resultCat->fetch_assoc();
$stmt->close();

if (!$categoriaAtual) die("<h2>Categoria não encontrada.</h2>");

// Buscar categorias para a sidebar
$categorias = listarCategorias();

// Buscar temas e tarefas da categoria atual
$sqlTemas = "
    SELECT 
        t.id AS tema_id, 
        t.nome AS tema_nome,
        ta.id AS tarefa_id, 
        ta.nome AS tarefa_nome,
        ta.descricao AS tarefa_desc
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
            'nome' => $row['tarefa_nome'],
            'descricao' => $row['tarefa_desc']
        ];
    }
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($categoriaAtual['nome']) ?> - Kanban</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/categoria.css">
</head>

<body>
    <button id="btnMenu" class="clicado">☰ Menu</button>

    <div class="sidebar" id="sidebar">
        <a href="../index.php">🏠 Home</a>
        <a href="#" id="btnCategoria">➕ Nova Categoria</a>

        <div id="formCategoria" class="formCategoria">
            <form action="../php/novaCategoria.php" method="post">
                <input type="text" name="categorias" placeholder="Nome da Categoria" class="form-control" required>
                <input type="submit" value="Criar" class="btn btn-primary mt-2">
            </form>
        </div>

        <div class="categorias-lista">
            <h5 class="mt-3 mb-2">Categorias:</h5>
            <?php foreach($categorias as $categoria): ?>
                <div class="categoria-container mb-1">
                    <div class="categoria-view w-100 d-flex align-items-center justify-content-between px-1" 
                         id="view-<?php echo $categoria['id']; ?>">
                        <div class="d-flex align-items-center flex-grow-1">
                            <i class="bi bi-folder-fill me-2 text-warning"></i>
                            <a href="categoria.php?id=<?php echo $categoria['id']; ?>" 
                               class="text-decoration-none text-light flex-grow-1 categoria-nome">
                               <?php echo htmlspecialchars($categoria['nome']); ?>
                            </a>
                        </div>
                        <div class="botoes d-flex align-items-center">
                            <button class="btn btn-sm text-info p-0 me-2 btn-editar" 
                                data-id="<?php echo $categoria['id']; ?>"
                                data-nome="<?php echo htmlspecialchars($categoria['nome']); ?>"
                                title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm text-danger p-0 btn-excluir" 
                                data-id="<?php echo $categoria['id']; ?>"
                                title="Excluir">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <form class="categoria-edit d-none mt-1" 
                          id="form-<?php echo $categoria['id']; ?>" 
                          action="../php/editarCategoria.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" 
                                   name="novo_nome" 
                                   value="<?php echo htmlspecialchars($categoria['nome']); ?>" required>
                            <button class="btn btn-success btn-sm" type="submit">
                                <i class="bi bi-check"></i>
                            </button>
                            <button class="btn btn-secondary btn-sm" type="button" 
                                    onclick="cancelarEdicao('<?php echo $categoria['id']; ?>')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <button id="btnTema" class="btn-tema">
            <i class="bi bi-moon-fill"></i>
        </button>
    </div>

    <div class="conteudo" id="conteudo">
        <h1><?= htmlspecialchars($categoriaAtual['nome']) ?></h1>

        <div class="kanban">
            <?php if (!empty($temas)): ?>
                <?php foreach ($temas as $tema): ?>
                    <div class="coluna" id="coluna-<?= $tema['id'] ?>">
                        <div class="tema-header">
                            <h4 id="tema-nome-<?= $tema['id'] ?>"><?= htmlspecialchars($tema['nome']) ?></h4>
                            <div class="tema-actions">
                                <button class="btn-editar-tema" onclick="editarTema(<?= $tema['id'] ?>, '<?= htmlspecialchars($tema['nome'], ENT_QUOTES) ?>')" title="Editar tema">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn-excluir-tema" onclick="excluirTema(<?= $tema['id'] ?>)" title="Excluir tema">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="tarefas">
                            <?php if (!empty($tema['tarefas'])): ?>
                                <?php foreach ($tema['tarefas'] as $tarefa): ?>
                                    <div class="tarefa-card">
                                        <strong><?= htmlspecialchars($tarefa['nome']) ?></strong>
                                        <?php if (!empty($tarefa['descricao'])): ?>
                                            <p><?= nl2br(htmlspecialchars($tarefa['descricao'])) ?></p>
                                        <?php else: ?>
                                            <p><em>Sem descrição</em></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="sem-tarefas">Sem tarefas</p>
                            <?php endif; ?>
                        </div>

                        <button class="add-tarefa" onclick="adicionarTarefa(<?= $tema['id'] ?>)">+ Adicionar tarefa</button>
                    </div>
                <?php endforeach; ?>

                <div class="coluna nova-coluna">
                    <button class="btn-novo-tema" onclick="adicionarTema(<?= $id_categoria ?>)">+ Adicionar novo tema</button>
                </div>
            <?php else: ?>
                <div class="coluna">
                    <div class="tema-header">
                        <h4>Tema</h4>
                    </div>
                    <p class="sem-tarefas">Sem tarefas</p>
                </div>
                <div class="coluna nova-coluna">
                    <button class="btn-novo-tema" onclick="adicionarTema(<?= $id_categoria ?>)">+ Adicionar novo tema</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../js/java.js"></script>
    <script src="../js/categorias.js"></script>
</body>
</html>
