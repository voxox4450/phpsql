<?php
// add_course_process.php
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

// Obsługa dodawania nowego kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor = $_POST['instructor'];
    $username = $_SESSION['username'];

$insertSql = "INSERT INTO courses (title, description, instructor) VALUES ('$title', '$description', '$instructor')";

if ($conn->query($insertSql) === TRUE) {
    // Pomyślne dodanie kursu, przekieruj na stronę z kursami
    header("Location: /phpsql/pages/browse_courses.php");
    exit;
} else {
    // Błąd podczas dodawania kursu
    $error_message = "Błąd podczas dodawania kursu. Spróbuj ponownie.";
}
    header("Location: /phpsql/pages/courses.php");
}

$conn->close();
?>
