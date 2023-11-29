<?php
// edit_course_process.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Obsługa edycji kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Aktualizacja danych kursu w bazie danych
    $updateCourseSql = "UPDATE courses SET title='$title', description='$description' WHERE id=$course_id";

    // Pomyślna edycja kursu, przekieruj na stronę z zarządzaniem kursami
    header("Location: manage_courses.php");
}

$conn->close();
?>
