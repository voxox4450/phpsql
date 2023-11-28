<?php
// user_panel.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');


// Pobierz informacje o zalogowanym użytkowniku (możesz pobierać więcej informacji z bazy danych, jeśli potrzebujesz)
$username = $_SESSION['username'];

// Pobierz kursy użytkownika z bazy danych
$selectUserCoursesSql = "SELECT * FROM courses WHERE creator_id IN (SELECT id FROM users WHERE username='$username')";
$userCoursesResult = $conn->query($selectUserCoursesSql);

$userCourses = array(); // Inicjalizacja tablicy do przechowywania kursów użytkownika

if ($userCoursesResult->num_rows > 0) {
    while ($courseData = $userCoursesResult->fetch_assoc()) {
        $userCourses[] = $courseData;
    }
}
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
    <?php include '../includes/header.php'; 
    
    // Sprawdzenie, czy istnieje parametr error w adresie URL
    if (isset($_GET['error'])) {
    $error_message = urldecode($_GET['error']);
    echo '<div style="color: red;">' . $error_message . '</div>';
}
    ?>

    <div class="container">
        <h2>Zarządzaj Kursami</h2>

        
        
        <!-- Dodaj kurs -->
        <a href="/phpsql/pages/add_course.php">Dodaj kurs</a>

        <!-- Wyświetl kursy użytkownika w listach rozwijanych -->
        <?php
        if (!empty($userCourses)) {
            foreach ($userCourses as $course) {
                echo '<details>';
                echo '<summary>' . $course['title'] . '</summary>';
                echo '<ul>';
                echo '<li><a href="/phpsql/pages/edit_course.php?id=' . $course['id'] . '">Edytuj</a></li>';
                echo '<li><a href="/phpsql/pages/view_course.php?id=' . $course['id'] . '">Wyświetl</a></li>';
                echo '<li><a href="/phpsql/pages/delete_course.php?id=' . $course['id'] . '">Usuń</a></li>';
                echo '</ul>';
                echo '</details>';
            }
        } else {
            echo '<p>Brak dostępnych kursów.</p>';
        }
        ?>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
