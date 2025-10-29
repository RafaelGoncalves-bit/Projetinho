<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_antigo = $_POST['nome_antigo'];
    $novo_nome = trim($_POST['novo_nome']);
    
    if (!empty($novo_nome)) {
        try {
            $sql = "UPDATE categorias SET nome = ? WHERE nome = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $novo_nome, $nome_antigo);
            
            if ($stmt->execute()) {
                echo "<script>alert('Categoria atualizada com sucesso!'); window.location.href='../index.php';</script>";
            } else {
                echo "<script>alert('Erro ao atualizar categoria!'); window.location.href='../index.php';</script>";
            }
            
            $stmt->close();
        } catch (Exception $e) {
            echo "<script>alert('Erro: " . $e->getMessage() . "'); window.location.href='../index.php';</script>";
        }
    } else {
        echo "<script>alert('O nome da categoria não pode estar vazio!'); window.location.href='../index.php';</script>";
    }
} else {
    $nome = isset($_GET['id']) ? $_GET['id'] : '';
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Categoria</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Editar Categoria</h2>
            <form action="editarCategoria.php" method="post">
                <input type="hidden" name="nome_antigo" value="<?php echo htmlspecialchars($nome); ?>">
                <div class="mb-3">
                    <label for="novo_nome" class="form-label">Novo nome da categoria:</label>
                    <input type="text" class="form-control" id="novo_nome" name="novo_nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="../index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>