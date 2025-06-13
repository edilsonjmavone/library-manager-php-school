<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registar | Gestor de Biblioteca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/global.css" />
    <link rel="stylesheet" href="../styles/form.css" />
</head>

<body>
    <main>
        <form action="../controllers/addUserHandler.php" method="post">
            <div style="text-align: center; margin-bottom: 0.5rem;">
            <i class="fas fa-user-plus" style="font-size: 2rem; color: #ffb74d;"></i>

            </div>
            <h1>Registar Usuario</h1>

            <label for="username">Nome de Usuario</label>
            <input type="text" id="username" name="username" required />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />

            <label for="password">Definir Palavra-passe</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Submeter</button>

            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            <div class="more-info">
                <p>Ja tem conta? Faca o <a href="login.php">Login</a></p>
            </div>

        </form>
    </main>
</body>

</html>