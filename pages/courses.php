<?php
// courses.php
session_start();

include('../settings.php');

// Pobierz kursy z bazy danych
$selectCoursesSql = "SELECT courses.*, users.username as creator_name FROM courses
                     JOIN users ON courses.creator_id = users.id";
$coursesResult = $conn->query($selectCoursesSql);

$courses = array(); // Inicjalizacja tablicy do przechowywania kursów

if ($coursesResult->num_rows > 0) {
    while ($courseData = $coursesResult->fetch_assoc()) {
        $courses[] = $courseData;
    }
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Kursy</title>
</head>
<body>

    <div class="container">
        <h2>Kursy</h2>
        <?php
        // Wyświetl kursy
        if (!empty($courses)) {
            foreach ($courses as $course) {
                echo '<div class="course">';
                echo '<h3>' . $course['title'] . '</h3>';
                echo '<p>' . $course['description'] . '</p>';
                echo '<p>Twórca: ' . $course['creator_name'] . '</p>';
                echo '<a href="view_course.php?id=' . $course['id'] . '">Przeglądaj</a>';
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

