<?php
session_start();

include('../settings.php');

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Sprawdź, czy przesłano poprawne dane POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];

// Zabezpieczenie przed atakami SQL Injection
$selectCourseSql = "SELECT * FROM courses WHERE id=?";
$stmt = $conn->prepare($selectCourseSql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $courseData = $result->fetch_assoc();
    $title = $courseData['title'];
} else {
    echo "Brak kursu o podanym ID.";
    exit;
}}

include '../includes/header.php';

echo '<div class="container">';
echo '<h2>Wykonaj Kurs</h2>';
echo '<p>Tytuł: ' . $title . '</p>';

// Dodaj przycisk "Ukończ kurs"
echo '<form method="post" action="/phpsql/actions/start_course_process.php">';
echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
echo '<button type="submit">Ukończ kurs</button>';
echo '</form>';

echo '</div>'; // Zamknij kontener

// Zamykanie połączenia z bazą danych
$stmt->close();
include '../includes/footer.php';
?>

