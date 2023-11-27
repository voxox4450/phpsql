<?php
// add_course_process.php
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

// Obsługa dodawania nowego kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor = $_POST['instructor'];
    $username = $_SESSION['username'];

    // Tutaj dodaj kod do dodawania kursu do bazy danych
    // np. INSERT INTO courses (title, description, instructor) VALUES ('$title', '$description', '$instructor');

    // Pomyślne dodanie kursu, przekieruj na stronę z kursami
    header("Location: courses.php");
}

$conn->close();
?>
