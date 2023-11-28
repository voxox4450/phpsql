<?php
// delete_course.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obsługa usuwania kursu
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Tutaj dodaj kod do usuwania kursu z bazy danych
    // np. DELETE FROM courses WHERE id=$course_id;

    // Pomyślne usunięcie kursu, przekieruj na stronę z zarządzaniem kursami
    header("Location: manage_courses.php");
}

$conn->close();
?>
