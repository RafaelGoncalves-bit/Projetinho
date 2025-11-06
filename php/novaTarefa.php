<?php
include('conexao.php');

$idTema = isset($_GET['tema']) ? intval($_GET['tema']) : 0;
$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';

if ($idTema > 0 && $nome !== '') {
    $sql = "INSERT INTO tarefas (nome, id_tema) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nome, $idTema);
    $stmt->execute();
    $stmt->close();

    header("Location: ../categoria.php?id=" . $idTema);
    exit;
} else {
    echo "<script>alert('Dados inválidos.'); window.history.back();</script>";
}
?>
