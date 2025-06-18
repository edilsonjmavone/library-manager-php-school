<?php
require_once '../../db_connection.php';
require_once '../../config.php';

session_start();

$result = $db->query("SELECT id, name FROM author");
$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Gestor de Biblioteca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles/global.css" />
    <link rel="stylesheet" href="../../styles/form.css" />
</head>

<body>
    <main>
        <form action="<?= BASE_URL ?>/controllers/addAuthorHandler.php" method="post">
            <!-- Inside the <form>, above the <h1> -->
            <div style="text-align: center; margin-bottom: 0.5rem;">
                <i class="fas fa-book" style="font-size: 2rem; color: #ffb74d;"></i>
            </div>

            <h1>Registar Autor</h1>

            <label for="name">Nome</label>
            <input type="text" id="name" name="name" required />

            <button type="submit">Adicionar Autor</button>

            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

        </form>
        <div>
            <a href="<?= BASE_URL ?>/views/dashboard.php" class="exitBtn">Regressar ao dashboard</a>
        </div>
    </main>
</body>

</html>