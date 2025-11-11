<?php
header('Content-Type: application/json');
include_once('../php/conexao.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método inválido']);
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$novoNome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$novaDescricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

if ($id <= 0 || empty($novoNome)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados inválidos.']);
    exit;
}

$sql = "UPDATE tarefas SET nome = ?, descricao = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $novoNome, $novaDescricao, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sucesso']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Falha ao atualizar.']);
}
$stmt->close();
$conn->close();
