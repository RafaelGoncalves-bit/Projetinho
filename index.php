<?php 
include("./php/conexao.php");
include("./php/listarCategorias.php");
$categorias = listarCategorias();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu Lateral Funcional</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/estilo.css">
</head>

<body>
    <button id="btnMenu" class="clicado">☰ Menu</button>

    <div class="sidebar" id="sidebar">
        <a href="index.php">🏠 Home</a>
        <a href="#" id="btnCategoria">➕ Nova Categoria</a>
        <div id="formCategoria" class="formCategoria">
            <form action="./php/novaCategoria.php" method="post">
                <input type="text" name="categorias" placeholder="Nome da Categoria" class="form-control" required>
                <input type="submit" value="Criar" class="btn btn-primary mt-2">
            </form>
        </div>
        <div class="categorias-lista">
            <h5 class="mt-3 mb-2">Categorias:</h5>
            <?php foreach($categorias as $categoria): ?>
                <div class="categoria-container mb-1">
                    <div class="categoria-view w-100" id="view-<?php echo htmlspecialchars($categoria); ?>">
                        <a href="#" class="categoria-link d-flex align-items-center text-decoration-none py-1 px-2">
                            <i class="bi bi-folder-fill me-2 text-warning"></i>
                            <span class="categoria-nome flex-grow-1"><?php echo htmlspecialchars($categoria); ?></span>
                            <button class="btn btn-sm p-0 me-1 text-info" onclick="editarCategoria('<?php echo htmlspecialchars($categoria); ?>')" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm p-0 text-danger" onclick="excluirCategoria('<?php echo htmlspecialchars($categoria); ?>')" title="Excluir">
                                <i class="bi bi-trash"></i>
                            </button>
                        </a>
                    </div>
                    <form class="categoria-edit d-none w-100" id="form-<?php echo htmlspecialchars($categoria); ?>" action="./php/editarCategoria.php" method="post">
                        <div class="input-group input-group-sm">
                            <input type="hidden" name="nome_antigo" value="<?php echo htmlspecialchars($categoria); ?>">
                            <input type="text" class="form-control form-control-sm" name="novo_nome" value="<?php echo htmlspecialchars($categoria); ?>" required>
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="bi bi-check"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary" type="button" onclick="cancelarEdicao('<?php echo htmlspecialchars($categoria); ?>')">
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
        <h1>Bem-vindo!</h1>
        <p>Agora o menu lateral aparece e funciona direitinho 🎉</p>
        
      
    </div>

    <script src="./js/java.js"></script>
    <script src="./js/categorias.js"></script>
</body>

</html>