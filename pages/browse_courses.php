<?php
// browse_courses.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Poniżej możesz umieścić kod HTML/CSS/PHP do przeglądania dostępnych kursów
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Przeglądaj Dostępne Kursy</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Dostępne Kursy</h2>
        <!-- Dodaj kod do wyświetlania dostępnych kursów -->

        <!-- Poniżej umieść kod HTML/CSS/PHP do wyświetlania listy kursów -->
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
