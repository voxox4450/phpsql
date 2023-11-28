<?php
// change_password.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Połączenie z bazą danych (zakładam, że masz już plik settings.php z konfiguracją)
include '../settings.php';

// Pobierz informacje o zalogowanym użytkowniku
$username = $_SESSION['username'];


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

// Obsługa formularza zmiany hasła
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    // Sprawdź, czy aktualne hasło jest poprawne
    if (password_verify($currentPassword, $row['password'])) {
        // Aktualne hasło jest poprawne
        if ($newPassword === $confirmNewPassword) {
            // Nowe hasło zostało potwierdzone
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Aktualizuj hasło w bazie danych (parametryzowane zapytanie)
            $updateSql = "UPDATE users SET password=? WHERE id=?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("si", $hashedNewPassword, $userId);

            if ($stmt->execute()) {
                // Aktualizacja hasła zakończona sukcesem
                header("Location: /phpsql/pages/profile.php");
                exit;
            } else {
                // Błąd podczas aktualizacji hasła
                $error_message = "Błąd podczas aktualizacji hasła. Spróbuj ponownie.";
            }
        } else {
            // Nowe hasła nie pasują do siebie
            $error_message = "Nowe hasło i jego potwierdzenie muszą być identyczne.";
        }
    } else {
        // Aktualne hasło jest niepoprawne
        $error_message = "Aktualne hasło jest niepoprawne.";
    }
}


$conn->close();
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
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Zmień Hasło</h2>

        <?php
        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>

        <form action="change_password.php" method="post">
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
