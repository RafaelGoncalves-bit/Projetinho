<?php
include_once('conexao.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';

if ($id <= 0 || $nome === '') {
    die("Dados inválidos.");
}

$stmt = $conn->prepare("UPDATE temas SET nome = ? WHERE id = ?");
$stmt->bind_param("si", $nome, $id);

if ($stmt->execute()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Erro ao atualizar o tema.";
}
$stmt->close();
?>
