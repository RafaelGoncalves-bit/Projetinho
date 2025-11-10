<?php
include('conexao.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    // pegar categoria para redirecionar
    $stmt = $conn->prepare("SELECT id_categoria FROM temas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $tema = $res->fetch_assoc();
    $stmt->close();

    // opcional: apagar tarefas relacionadas ao tema
    $conn->query("DELETE FROM tarefas WHERE id_tema = " . intval($id));

    $del = $conn->prepare("DELETE FROM temas WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $del->close();

    if ($tema && !empty($tema['id_categoria'])) {
        header("Location: ./categoria.php?id=" . intval($tema['id_categoria']));
        exit;
    }
}
header("Location: ../index.php");
exit;
