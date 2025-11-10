<?php
include('conexao.php');

$idTema = isset($_GET['tema']) ? intval($_GET['tema']) : 0;
$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$descricao = isset($_GET['descricao']) ? trim($_GET['descricao']) : '';

if ($idTema > 0 && $nome !== '') {
    // Buscar id da categoria associada ao tema
    $sqlCat = "SELECT id_categoria FROM temas WHERE id = ?";
    $stmtCat = $conn->prepare($sqlCat);
    $stmtCat->bind_param("i", $idTema);
    $stmtCat->execute();
    $resultCat = $stmtCat->get_result();
    $rowCat = $resultCat->fetch_assoc();
    $stmtCat->close();

    if (!$rowCat) {
        echo "<script>alert('Tema não encontrado.'); window.history.back();</script>";
        exit;
    }

    $idCategoria = $rowCat['id_categoria'];

    // Inserir tarefa com descrição
    $sql = "INSERT INTO tarefas (nome, descricao, id_tema) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $descricao, $idTema);
    $stmt->execute();
    $stmt->close();

    // Redirecionar para a categoria correta
    header("Location: ./categoria.php?id=" . $idCategoria);
    exit;
} else {
    echo "<script>alert('Dados inválidos.'); window.history.back();</script>";
}
?>
