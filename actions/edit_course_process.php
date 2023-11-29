<?php
// edit_course_process.php

// Sprawdź, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sprawdź, czy użytkownik jest zalogowany
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: /phpsql/pages/login.php");
        exit;
    }

    // Pobierz dane z formularza
    $course_id = $_POST["course_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];


include('../settings.php');
// Obsługa edycji kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Aktualizacja danych kursu w bazie danych przy użyciu prepared statements
    $updateCourseSql = "UPDATE courses SET title=?, description=? WHERE id=?";
    
    $stmt = $conn->prepare($updateCourseSql);
    $stmt->bind_param("ssi", $title, $description, $course_id);

    if ($stmt->execute()) {
        // Pomyślna edycja kursu, przekieruj na stronę z zarządzaniem kursami
        header("Location: /phpsql/pages/manage_courses.php");
    } else {
        // Błąd edycji kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode("Błąd edycji kursu: " . $stmt->error));
    }

    $stmt->close();
}
?>
