<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['categorias']);

    if (!empty($nome)) {
        try {
            // Chama a procedure ao invés de fazer INSERT manual
            $stmt = $conn->prepare("CALL inserir_categoria(?)");
            $stmt->bind_param("s", $nome);
            $stmt->execute();
            $stmt->close();

            echo "<script>
                    alert('Categoria criada com sucesso!');
                    window.location.href='../index.php';
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    alert('Erro ao criar categoria: " . $e->getMessage() . "');
                    window.location.href='../index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('O nome da categoria não pode estar vazio!');
                window.history.back();
              </script>";
    }
}
?>
