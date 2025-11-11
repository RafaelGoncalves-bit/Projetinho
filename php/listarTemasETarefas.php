<?php
include('conexao.php');

// Listar categorias
$categorias = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

while ($cat = $categorias->fetch_assoc()) {
    echo "<div class='categoria'>";
    echo "<h3>" . htmlspecialchars($cat['nome']) . "</h3>";

    // Buscar temas dessa categoria (corrigido o nome da coluna)
    $stmt = $conn->prepare("SELECT id, nome FROM temas WHERE id_categoria = ?");
    $stmt->bind_param("i", $cat['id']);
    $stmt->execute();
    $temas = $stmt->get_result();

    echo "<div class='temas'>";
    if ($temas->num_rows > 0) {
        // Mostra os temas existentes
        while ($tema = $temas->fetch_assoc()) {
            echo "<div class='tema'>";
            echo htmlspecialchars($tema['nome']);
            echo "</div>";
        }
    } else {
        // Se não houver nenhum tema
        echo "<div class='tema tema-padrao'>Tema</div>";
    }
    echo "</div>";

    echo "</div>";
}
?>
