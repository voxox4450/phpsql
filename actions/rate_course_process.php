<?php
// rate_course_process.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_courses";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obsługa oceniania kursu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id']) && isset($_POST['rating'])) {
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $username = $_SESSION['username'];

    // Tutaj dodaj kod do dodawania oceny do bazy danych
    // np. INSERT INTO ratings (course_id, username, rating) VALUES ($course_id, '$username', $rating);

    // Pomyślne ocenienie kursu, przekieruj na stronę z zarządzaniem kursami
    header("Location: manage_courses.php");
}

$conn->close();
?>
