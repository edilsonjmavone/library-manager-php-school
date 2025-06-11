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
                https://fontawesome.com/icons/book-medical?f=classic&s=solid
            </div>

            <h1>Registar Livro</h1>

            <label for="title">Titulo</label>
            <input type="text" id="title" name="title" required />

            <label for="genre">Genero</label>
            <input type="text" name="genre" id="genre" required>

            <label for="genre">Nome do Autor</label>
            <select name="genre" id="genre">
                <option value=""></option>
            </select>

            <label for="publication_date">Data de Publicacao</label>
            <input type="date" name="publication_date" id="publication_date">

            <button type="submit">Adicionar</button>

            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

        </form>
        <div>

        </div>
    </main>
</body>

</html>