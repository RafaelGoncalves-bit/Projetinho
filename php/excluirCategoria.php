<?php
include('conexao.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $sql = "DELETE FROM categorias WHERE nome = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Categoria excluída com sucesso!'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir categoria!'); window.location.href='../index.php';</script>";
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "'); window.location.href='../index.php';</script>";
    }
} else {
    header("Location: ../index.php");
}
?>