<?php
// user_panel.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Pobierz informacje o zalogowanym użytkowniku (możesz pobierać więcej informacji z bazy danych, jeśli potrzebujesz)
$username = $_SESSION['username'];

// Poniżej możesz umieścić kod HTML/CSS, który wyświetli panel użytkownika
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Panel Użytkownika</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Witaj, <?php echo $username; ?>, w Twoim Panelu Użytkownika!</h2>
        <!-- Dodaj linki do różnych funkcji dostępnych dla zalogowanego użytkownika -->
        <ul>
            <li><a href="/phpsql/pages/profile.php">Przejdź do Profilu</a></li>
            <li><a href="/phpsql/pages/browse_courses.php">Przeglądaj Dostępne Kursy</a></li>
            <li><a href="/phpsql/pages/edit_profile.php">Edytuj Profil</a></li>
            <li><a href="/phpsql/pages/change_password.php">Zmień Hasło</a></li>
            <li><a href="/phpsql/pages/logout.php">Wyloguj</a></li>
        </ul>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>