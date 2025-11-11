<?php
include_once('conexao.php');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo "ID não informado.";
    exit;
}

$id = intval($_GET['id']);

$sql = "UPDATE tarefas SET concluida = NOT concluida WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "ok";
} else {
    http_response_code(500);
    echo "Erro ao atualizar tarefa.";
}

$stmt->close();
$conn->close();
?>
