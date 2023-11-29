<?php
// edit_course_process.php
session_start();

include('../settings.php');

// Obsługa edycji kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Aktualizacja danych kursu w bazie danych
    $updateCourseSql = "UPDATE courses SET title='$title', description='$description' WHERE id=$course_id";

    if ($conn->query($updateCourseSql) === TRUE) {
        // Pomyślna edycja kursu, przekieruj na stronę z zarządzaniem kursami
        header("Location: /phpsql/pages/manage_courses.php");
    } else {
        // Błąd edycji kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode("Błąd edycji kursu: " . $conn->error));
    }
}

$conn->close();
?>
