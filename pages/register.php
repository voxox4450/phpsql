<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Rejestracja</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Zarejestruj się</h2>

        <form action="/phpsql/actions/register_process.php" method="post">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" name="username" required>

            <label for="password">Hasło:</label>
            <input type="password" name="password" required>

            <button type="submit">Zarejestruj się</button>
        </form>
        <?php
        if (isset($_SESSION['registration_message'])) {
            echo '<p class="error">' . $_SESSION['registration_message'] . '</p>';
            unset($_SESSION['registration_message']); // Usunięcie komunikatu po wyświetleniu
        }
        ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
