<?php
// browse_courses.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');

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
        

<div class="container">
    <h2>Dostępne Kursy</h2>

    <?php
    
    $sql = "SELECT * FROM courses";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="course">';
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p>Instruktor: ' . $row['instructor'] . '</p>';
            echo '<a href="view_course.php?id=' . $row['id'] . '">Przeglądaj</a>';
            echo '</div>';
        }
    } else {
        echo '<p>Brak dostępnych kursów.</p>';
    }
    ?>

</div>



    <?php include '../includes/footer.php'; ?>
</body>
</html>
