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

    // Tutaj możesz dodać walidację danych, jeśli to konieczne

    include('../settings.php');

    // Sprawdź, czy użytkownik jest twórcą kursu
    $checkCreatorSql = "SELECT creator_id FROM courses WHERE id=$course_id";
    $result = $conn->query($checkCreatorSql);

    if ($result->num_rows > 0) {
        $courseData = $result->fetch_assoc();
        $creator_id = $courseData['creator_id'];

        // Zaktualizuj dane kursu w bazie danych
        $updateSql = "UPDATE courses SET title='$title', description='$description' WHERE id=$course_id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Zmiany zostały zapisane pomyślnie";
        } else {
            echo "Błąd podczas zapisywania zmian: " . $conn->error;
        }

    } else {
        echo "Błąd podczas sprawdzania twórcy kursu";
    }

    // Zamknij połączenie z bazą danych
    $conn->close();
}
// Jeśli użytkownik nie jest twórcą kursu, przekieruj do panelu administratora
if ($_SESSION['user_id'] !== $creator_id) {
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
}
header("Location: /phpsql/pages/manage_courses.php");
exit;
?>
