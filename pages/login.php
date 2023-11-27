<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Logowanie</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Zaloguj się</h2>
        <form action="/phpsql/actions/login_process.php" method="post">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" name="username" required>

            <label for="password">Hasło:</label>
            <input type="password" name="password" required>

            <button type="submit">Zaloguj się</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
