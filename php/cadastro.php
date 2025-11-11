<?php
session_start();
// Se o usuário já estiver logado, manda para index
if (!empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Cadastro</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/login.css">
</head>
<body class="background-cadastro">
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-5">
      <div class="card p-4">
        <h3 class="text-center mb-3">Cadastro</h3>

        <?php if (!empty($_SESSION['flash_error'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_success'])): ?>
          <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>

        <form action="register.php" method="post" novalidate>
          <div class="mb-3">
            <label class="form-label">Nome</label>
            <input class="form-control" type="text" name="nome" required>
          </div>

          <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha" minlength="6" required>
          </div>

          <button class="btn btn-primary w-100" type="submit">Cadastrar</button>
          <div class="text-center mt-2">
            <a href="./login.php">Já tenho login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
