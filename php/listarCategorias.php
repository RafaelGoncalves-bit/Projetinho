<?php
include('conexao.php');

function listarCategorias() {
    global $conn;
    $categorias = array();
    
    try {
        $sql = "SELECT nome FROM categorias ORDER BY nome";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $categorias[] = $row['nome'];
            }
        }
        
        return $categorias;
        
    } catch (Exception $e) {
        echo "<script>alert('Erro ao listar categorias: " . $e->getMessage() . "');</script>";
        return array();
    }
}
?>
