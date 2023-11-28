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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Zarządzaj Kursami</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Zarządzaj Kursami</h2>
        <ul>
            <li><a href="/phpsql/pages/add_course.php">Dodaj</a></li>
            <li><a href="/phpsql/pages/edit_course.php">Edytuj</a></li>
            <li><a href="/phpsql/pages/view_course.php">Wyświetl</a></li>
            <li><a href="/phpsql/pages/delete_course.php">Usuń</a></li>
        </ul>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
