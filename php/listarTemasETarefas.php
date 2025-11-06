<?php
include('conexao.php');

function listarTemasETarefas($idCategoria) {
    global $conn;

    $dados = [];
    $sqlTemas = "SELECT id, nome FROM temas WHERE id_categoria = ?";
    $stmt = $conn->prepare($sqlTemas);
    $stmt->bind_param("i", $idCategoria);
    $stmt->execute();
    $temas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($temas as $tema) {
        $sqlTarefas = "SELECT id, nome, status FROM tarefas WHERE id_tema = ?";
        $stmtT = $conn->prepare($sqlTarefas);
        $stmtT->bind_param("i", $tema['id']);
        $stmtT->execute();
        $tarefas = $stmtT->get_result()->fetch_all(MYSQLI_ASSOC);

        $dados[] = [
            'tema' => $tema['nome'],
            'tarefas' => $tarefas
        ];
    }

    return $dados;
}
?>
