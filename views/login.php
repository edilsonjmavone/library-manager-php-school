<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Gestor de Biblioteca</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="../styles/form.css" />
</head>

<body>
  <main>
    <form action="../controllers/loginHandler.php" method="post">
      <!-- Inside the <form>, above the <h1> -->
      <div style="text-align: center; margin-bottom: 0.5rem;">
        <i class="fas fa-book" style="font-size: 2rem; color: #ffb74d;"></i>
      </div>


      <h1>Login</h1>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Palavra-passe</label>
      <input type="password" id="password" name="password" required />

      <button type="submit">Entrar</button>

      <?php if (isset($_GET['error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
      <?php endif; ?>
      <div class="more-info">
        <p>Nao tem conta? Faca o seu <a href="registarUsuario.php">Cadastro</a></p>
      </div>

    </form>
    <div>

    </div>
  </main>
</body>

</html>