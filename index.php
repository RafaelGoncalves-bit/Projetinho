<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./php/login.php');
    exit;
}

include("./php/conexao.php");
include("./php/listarCategorias.php");
$categorias = listarCategorias();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel - Tarefas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/estilo.css">
</head>

<body>
    <button id="btnMenu" class="clicado">☰ Menu</button>

    <div class="sidebar" id="sidebar">
        <a href="index.php">🏠 Home</a>
        <a href="#" id="btnCategoria">➕ Nova Categoria</a>

        <!-- Formulário para nova categoria -->
        <div id="formCategoria" class="formCategoria">
            <form action="./php/novaCategoria.php" method="post">
                <input type="text" name="categorias" placeholder="Nome da Categoria" class="form-control" required>
                <input type="submit" value="Criar" class="btn btn-primary mt-2">
            </form>
        </div>

        <!-- Lista de categorias -->
        <div class="categorias-lista flex-grow-1">
            <h5 class="mt-3 mb-2 text-light">Categorias:</h5>

            <?php foreach($categorias as $categoria): ?>
                <div class="categoria-container mb-1">
                    <!-- Visualização -->
                    <div class="categoria-view w-100 d-flex align-items-center justify-content-between px-1" 
                         id="view-<?php echo $categoria['id']; ?>">
                        <div class="d-flex align-items-center flex-grow-1">
                            <i class="bi bi-folder-fill me-2 text-warning"></i>
                            <a href="php/categoria.php?id=<?php echo $categoria['id']; ?>" 
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

                    <!-- Formulário de edição -->
                    <form class="categoria-edit d-none mt-1" 
                          id="form-<?php echo $categoria['id']; ?>" 
                          action="./php/editarCategoria.php" method="post">
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

        <!-- Botão de logout no fim da sidebar -->
        <div class="logout-section mt-auto mb-3 text-center">
            <a href="php/logout.php" 
               class="btn btn-danger w-75 fw-bold">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>

        <button id="btnTema" class="btn-tema">
            <i class="bi bi-moon-fill"></i>
        </button>
    </div>

    <div class="conteudo" id="conteudo">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <p>Selecione uma categoria ao lado para começar a gerenciar suas tarefas.</p>
    </div>

    <script src="./js/java.js"></script>
    <script src="./js/categorias.js"></script>
</body>
</html>
