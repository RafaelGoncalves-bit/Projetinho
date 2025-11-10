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

        <button id="btnTema" class="btn-tema">
            <i class="bi bi-moon-fill"></i>
        </button>
    </div>