<?php
include('conexao.php');

// Verifica se o ID foi enviado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Primeiro, verifica se a categoria existe
    $check = $conn->prepare("SELECT id FROM categorias WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Exclui temas e tarefas vinculados antes (para evitar erro de chave estrangeira)
        $conn->query("DELETE FROM tarefas WHERE id_tema IN (SELECT id FROM temas WHERE id_categoria = $id)");
        $conn->query("DELETE FROM temas WHERE id_categoria = $id");

        // Agora exclui a categoria
        $delete = $conn->prepare("DELETE FROM categorias WHERE id = ?");
        $delete->bind_param("i", $id);
        $delete->execute();

        // Redireciona de volta para o index
        header("Location: ../index.php");
        exit;
    } else {
        echo "<script>alert('Categoria não encontrada!'); window.location.href='../index.php';</script>";
    }

    $check->close();
} else {
    echo "<script>alert('ID inválido.'); window.location.href='../index.php';</script>";
}

$conn->close();
?>
