<?php
// change_password.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Zmień Hasło</title>
</head>
<body>
    <div class="container">
        <h2>Zmień Hasło</h2>

        <?php
        // Wyświetlanie komunikatów o błędach, jeśli istnieją
        if (isset($_SESSION['error_messages']) && !empty($_SESSION['error_messages'])) {
            echo '<div class="error">';
            foreach ($_SESSION['error_messages'] as $error_message) {
                echo '<p>' . $error_message . '</p>';
            }
            echo '</div>';
            unset($_SESSION['error_messages']); // Usunięcie komunikatów o błędach po wyświetleniu
        }
        ?>

        <form action="/phpsql/actions/change_password_process.php" method="post">
            <label for="current_password">Aktualne Hasło:</label>
            <input type="password" name="current_password" required>

            <label for="new_password">Nowe Hasło:</label>
            <input type="password" name="new_password" required>

            <label for="confirm_new_password">Potwierdź Nowe Hasło:</label>
            <input type="password" name="confirm_new_password" required>

            <button type="submit">Zmień Hasło</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
