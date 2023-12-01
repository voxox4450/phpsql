<?php
// user_panel.php

session_start();
include('../settings.php');
var_dump($_SESSION);
// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}
echo "Rola użytkownika: " . $_SESSION['role'];

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
        <h2 class='login_h2'>Witaj, <?php echo $_SESSION['username']; ?>, w Twoim Panelu Użytkownika!</h2>


        <!-- Dodaj linki do różnych funkcji dostępnych dla zalogowanego użytkownika -->
        <ul>
            <li><a href="/phpsql/pages/manage_courses.php">Zarządzaj swoimi kursami</a></li>
            <li><a href="/phpsql/pages/edit_profile.php">Edytuj Profil</a></li>
            <li><a href="/phpsql/pages/change_password.php">Zmień Hasło</a></li>
        </ul>

    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
