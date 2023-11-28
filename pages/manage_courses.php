<?php
// manage_courses.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');


// Pobierz listę kursów z bazy danych
$courses = array(); // Inicjalizacja tablicy na kursy

$selectCoursesSql = "SELECT * FROM courses";
$coursesResult = $conn->query($selectCoursesSql);

if ($coursesResult->num_rows > 0) {
    while ($courseData = $coursesResult->fetch_assoc()) {
        $courses[] = $courseData;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
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
        
        <?php
        // Wyświetlanie komunikatu błędu (jeśli istnieje)
        if (isset($_GET['error'])) {
            echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <ul>
            <li><a href="/phpsql/pages/add_course.php">Dodaj</a></li>
            <li><a href="/phpsql/pages/edit_course.php">Edytuj</a></li>
            <li><a href="/phpsql/pages/view_course.php">Wyświetl</a></li>
            <li><a href="/phpsql/pages/delete_course.php">Usuń</a></li>
        </ul>

        <h3>Lista Kursów</h3>
        <ul>
            <?php
            foreach ($courses as $course) {
                echo '<li>' . $course['title'] . ' - <a href="delete_course.php?id=' . $course['id'] . '">Usuń</a></li>';
            }
            ?>
        </ul>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
