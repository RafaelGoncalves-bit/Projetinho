<?php
include('conexao.php');

$id_categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;
$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';

if ($id_categoria > 0 && !empty($nome)) {
    $stmt = $conn->prepare("INSERT INTO temas (nome, id_categoria) VALUES (?, ?)");
    $stmt->bind_param("si", $nome, $id_categoria);
    $stmt->execute();
    $stmt->close();
}

header("Location: ./categoria.php?id=" . $id_categoria);
exit;
?>
