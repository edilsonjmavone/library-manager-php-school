<?php
require_once '../config.php';

$success = $_GET['successMsg'] ?? null;
$error = $_GET['errMsg'] ?? null;
$backTo = $_GET['backTo'] ?? '/views/dashboard.php';

// Gerar URLs seguras
$backUrl = url($backTo);
$dashboardUrl = url('/views/dashboard.php');
$retryUrl = $_SERVER['HTTP_REFERER'] ?? $backUrl;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Mensagem</title>
    <style>
        body {
            background-color: #101010;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .message-box {
            background-color: #0a0a0a;
            border-left: 6px solid
                <?= $success ? '#28a745' : '#dc3545' ?>
            ;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(255, 101, 0, 0.3);
        }

        .message-box h2 {
            margin-bottom: 10px;
            color:
                <?= $success ? '#28a745' : '#dc3545' ?>
            ;
        }

        .buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .buttons a {
            background-color: #ff6500;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .buttons a:hover {
            background-color: #e05500;
        }
    </style>
</head>

<body>

    <div class="message-box">
        <h2><?= $success ? 'Sucesso' : 'Erro' ?></h2>
        <p><?= htmlspecialchars($success ?? $error) ?></p>
    </div>

    <div class="buttons">
        <a href="<?= htmlspecialchars($backUrl) ?>">← Voltar</a>

        <?php if ($error): ?>
            <a href="<?= htmlspecialchars($retryUrl) ?>">🔄 Tentar Novamente</a>
        <?php endif; ?>

        <a href="<?= htmlspecialchars($dashboardUrl) ?>">🏠 Ir para o Dashboard</a>
    </div>

</body>

</html>