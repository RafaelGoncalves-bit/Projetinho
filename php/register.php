<?php
session_start();
require_once 'conexao.php';

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($nome === '' || $email === '' || $senha === '') {
    $_SESSION['flash_error'] = 'Preencha todos os campos corretamente.';
    header('Location: ./cadastro.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['flash_error'] = 'E-mail inválido.';
    header('Location: ./cadastro.php');
    exit;
}

// verifica se email já existe
$stmt = $conn->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->fetch_assoc()) {
    $_SESSION['flash_error'] = 'E-mail já cadastrado.';
    header('Location: ./cadastro.php');
    exit;
}

// inserir usuário com hash de senha
$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO usuarios (email, senha, nome) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $email, $hash, $nome);
$ok = $stmt->execute();

if ($ok) {
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $nome;
    header('Location: ../index.php');
    exit;
} else {
    $_SESSION['flash_error'] = 'Erro ao cadastrar. Tente novamente.';
    header('Location: ./cadastro.php');
    exit;
}
