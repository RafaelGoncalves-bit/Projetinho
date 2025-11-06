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
    <h5 class="mt-3 mb-2">Categorias</h5>

    <!-- Formulário para nova categoria -->
    <div id="formCategoria" class="formCategoria">
        <form action="./php/novaCategoria.php" method="post">
            <input type="text" name="categorias" placeholder="Nome da Categoria" class="form-control mb-2" required>
            <input type="submit" value="Criar" class="btn btn-primary w-100">
        </form>
    </div>

    <!-- Lista de categorias -->
    <div class="categorias-lista">
        <?php foreach($categorias as $categoria): ?>
            <a href="php/categoria.php?id=<?= $categoria['id'] ?>" class="d-flex align-items-center justify-content-between">
                <span class="categoria-nome"><?= htmlspecialchars($categoria['nome']) ?></span>
                <i class="bi bi-chevron-right"></i>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Botão modo escuro -->
    <button id="btnTema" class="btn-tema">
        <i class="bi bi-moon-fill"></i>
    </button>
</div>

<!-- CONTEÚDO -->
<div class="conteudo" id="conteudo">
    <div class="container">
        <h2>Bem-vindo!</h2>
        <p>Selecione uma categoria no menu lateral para ver seus temas e tarefas.</p>
    </div>
</div>


    <script src="./js/java.js"></script>
    <script src="./js/categorias.js"></script>
</body>

</html>