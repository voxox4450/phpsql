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

    // Zaktualizuj dane kursu w bazie danych
    $sql = "UPDATE courses SET title='$title', description='$description' WHERE id=$course_id";

    if ($conn->query($sql) === TRUE) {
        echo "Zmiany zostały zapisane pomyślnie";
    } else {
        echo "Błąd podczas zapisywania zmian: " . $conn->error;
    }

    // Zamknij połączenie z bazą danych
    $conn->close();
} else {
    // Przekieruj użytkownika w przypadku próby dostępu bez przesłania formularza
    header("Location: /phpsql/pages/user_panel.php");
    exit;
}
?>
