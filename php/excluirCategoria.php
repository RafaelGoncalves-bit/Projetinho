<?php
include('conexao.php');

function listarCategorias() {
    global $conn;
    $sql = "SELECT id, nome FROM categorias ORDER BY nome";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
