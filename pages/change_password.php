<?php
// change_password.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Dołączenie pliku z ustawieniami bazy danych
include '../settings.php';

// Pobranie informacji o zalogowanym użytkowniku
$username = $_SESSION['username'];

// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
} else {
    // Użytkownik nie istnieje w bazie danych (coś poszło nie tak)
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
        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>

        <form action="change_password_process.php" method="post">
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

<?php
$conn->close();
?>
