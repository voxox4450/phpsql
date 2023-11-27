<?php
// edit_course_process.php
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

// Obsługa edycji kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor = $_POST['instructor'];

    // Tutaj dodaj kod do aktualizacji danych kursu w bazie danych
    // np. UPDATE courses SET title='$title', description='$description', instructor='$instructor' WHERE id=$course_id;

    // Pomyślna edycja kursu, przekieruj na stronę z zarządzaniem kursami
    header("Location: manage_courses.php");
}

$conn->close();
?>
