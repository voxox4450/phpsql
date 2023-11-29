<?php
session_start();

include('../settings.php');

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Pobierz ID kursu z parametru w URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Pobierz dane kursu na podstawie ID
    $selectCourseSql = "SELECT * FROM courses WHERE id=$course_id";
    $courseResult = $conn->query($selectCourseSql);

    if ($courseResult->num_rows > 0) {
        $courseData = $courseResult->fetch_assoc();
        $title = $courseData['title'];
    }

    include '../includes/header.php';

    echo '<div class="container">';
    echo '<h2>Przeglądaj Kurs</h2>';
    echo '<p>Tytuł: ' . $title . '</p>';
 

    // Dodaj przycisk "Rozpocznij Kurs"
    echo '<form method="post" action="/phpsql/pages/start_course_process.php">';
    echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
    echo '<button type="submit">Ukończ kurs</button>';
    echo '</form>';
    

    echo '</div>'; // Zamknij kontener
    include '../includes/footer.php';
} else {
    echo "Błędne dane przesłane do formularza.";s
}
?>
