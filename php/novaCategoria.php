<?php
include('./conexao.php'); // Conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorias = trim($_POST['categorias']);

    if (!empty($categorias)) {
        try {
            // Chamada da procedure
            $sql = "CALL inserir_categoria(?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $categorias);
            
            if ($stmt->execute()) {
                echo "<script>alert('Categoria inserida com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao inserir categoria!');</script>";
            }
            
            $stmt->close();
        } catch (Exception $e) {
            echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Preencha o nome da categoria!');</script>";
    }
}

header("Location: ../index.php");
?>
