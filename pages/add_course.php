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
    <title>Dodaj Kurs</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container width_30">
        <h2 class = 'login_h2'>Dodaj nowy kurs</h2>
        <form class = 'flex_column gap_5' action="/phpsql/actions/add_course_process.php" method="post">
        <div class="flex_column gap_4">
            <label for="title">Tytuł kursu:</label>
            <input type="text" name="title" required>
        </div>
        <div class="flex_column gap_4">
            <label for="description">Opis kursu:</label>
            <textarea name="description" rows="4" required></textarea>
        </div>
            <button type="submit">Dodaj kurs</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
