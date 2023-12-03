<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Logowanie</title>
</head>
<body>
    <?php include '../includes/header.php';
    session_start(); ?>

    <div class="container width_30">
        <h2 class = 'login_h2'>Zaloguj się</h2>

        <form class = 'flex_column gap_5'action="/phpsql/actions/login_process.php" method="post">
        <div class="flex_column gap_4">    
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" name="username" required>
        </div>
        <div class="flex_column gap_4">
            <label for="password">Hasło:</label>
            <input type="password" name="password" required>
        </div>
            <button type="submit">Zaloguj się</button>
        </form>
        <?php
        // Sprawdź, czy sesja zawiera komunikat o błędzie
        if (isset($_SESSION['error_message'])) {
            echo '<p class="error">' . $_SESSION['error_message'] . '</p>';
            // Usuń komunikat o błędzie z sesji, aby nie był wyświetlany ponownie po odświeżeniu strony
            unset($_SESSION['error_message']);
        }

        // Sprawdź, czy sesja zawiera komunikat o sukcesie
        if (isset($_SESSION['success_message'])) {
            echo '<p class="success">' . $_SESSION['success_message'] . '</p>';
            // Usuń komunikat o sukcesie z sesji, aby nie był wyświetlany ponownie po odświeżeniu strony
            unset($_SESSION['success_message']);
        }
        ?>

    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
