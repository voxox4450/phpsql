<?php
// courses.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Tutaj możesz dodać kod do pobierania kursów z bazy danych
// i wyświetlania ich na stronie
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Moje Kursy</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Moje Kursy</h2>
        <!-- Tutaj możesz wyświetlać kursy użytkownika -->
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
