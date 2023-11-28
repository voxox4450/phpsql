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
    <title>Dodaj Kurs</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Dodaj nowy kurs</h2>
        <form action="add_course_process.php" method="post">
            <label for="title">Tytuł kursu:</label>
            <input type="text" name="title" required>

            <label for="description">Opis kursu:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="instructor">Instruktor:</label>
            <input type="text" name="instructor" required>

            <button type="submit">Dodaj kurs</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
