<?php
require_once '../config.php';

$success = $_GET['successMsg'] ?? null;
$error = $_GET['errMsg'] ?? null;
$backTo = $_GET['backTo'] ?? '/views/dashboard.php';
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

        a {
            color: #ff6500;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="message-box">
        <h2><?= $success ? 'Sucesso' : 'Erro' ?></h2>
        <p><?= htmlspecialchars($success ?? $error) ?></p>
    </div>
    <a href="<?= htmlspecialchars($backTo) ?>">← Voltar</a>

</body>

</html>