<?php
session_start();
require_once 'conexao.php';

// Captura segura dos campos do formulário
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Verifica se os campos foram preenchidos
if ($email === '' || $password === '') {
    $_SESSION['flash_error'] = 'Preencha todos os dados do formulário.';
    header('Location: ./login.php');
    exit;
}

// Consulta o usuário pelo e-mail
$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o usuário existe
if ($user = $result->fetch_assoc()) {
    // Confere a senha (verifica o hash)
    if (password_verify($password, $user['senha'])) {
        // Login bem-sucedido
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['flash_error'] = 'Senha incorreta.';
        header('Location: ./login.php');
        exit;
    }
} else {
    $_SESSION['flash_error'] = 'Usuário não encontrado.';
    header('Location: ./login.php');
    exit;
}
