<?php
// delete_course_process.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');


// Obsługa usuwania kursu po potwierdzeniu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Usunięcie kursu z bazy danych
    $deleteCourseSql = "DELETE FROM courses WHERE id=$course_id";

    if ($conn->query($deleteCourseSql) === TRUE) {
        // Pomyślne usunięcie kursu, przekieruj na stronę z zarządzaniem kursami
        header("Location: /phpsql/pages/manage_courses.php");
    } else {
        // Błąd usuwania kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode("Błąd usuwania kursu: " . $conn->error));
    }
}

$conn->close();
?>
