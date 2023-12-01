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

    // Prosta walidacja długości tytułu i opisu
    if (strlen($title) < 6 || strlen($description) < 25) {
        $error_message = "Tytuł musi mieć co najmniej 6 znaków, a opis co najmniej 25 znaków.";
        header("Location: /phpsql/pages/edit_course.php?id=$course_id&error=" . urlencode($error_message));
        exit;
    }

    include('../settings.php');

    // Sprawdź, czy użytkownik jest twórcą kursu
    $checkCreatorSql = "SELECT creator_id FROM courses WHERE id=$course_id";
    $result = $conn->query($checkCreatorSql);

    if ($result->num_rows > 0) {
        $courseData = $result->fetch_assoc();
        $creator_id = $courseData['creator_id'];

        // Sprawdź, czy nie istnieje już kurs o podanym tytule i opisie (oprócz aktualnie edytowanego)
        $checkDuplicateSql = "SELECT * FROM courses WHERE title = ? AND description = ? AND id <> ?";
        $stmtCheckDuplicate = $conn->prepare($checkDuplicateSql);

        if (!$stmtCheckDuplicate) {
            die("Prepared statement error (check duplicate): " . $conn->error);
        }

        $stmtCheckDuplicate->bind_param("ssi", $title, $description, $course_id);
        $stmtCheckDuplicate->execute();
        $stmtCheckDuplicate->store_result();

        if ($stmtCheckDuplicate->num_rows > 0) {
            // Kurs o podanym tytule i opisie już istnieje (oprócz aktualnie edytowanego)
            $stmtCheckDuplicate->close();
            $error_message = "Kurs o podanym tytule i opisie już istnieje.";
            header("Location: /phpsql/pages/edit_course.php?id=$course_id&error=" . urlencode($error_message));
            exit;
        }

        // Zamykamy prepared statement
        $stmtCheckDuplicate->close();

        // Zaktualizuj dane kursu w bazie danych
        $updateSql = "UPDATE courses SET title=?, description=? WHERE id=?";
        $stmtUpdate = $conn->prepare($updateSql);

        if (!$stmtUpdate) {
            die("Prepared statement error (update): " . $conn->error);
        }

        $stmtUpdate->bind_param("ssi", $title, $description, $course_id);

        if ($stmtUpdate->execute()) {
            // Pomyślne zaktualizowanie kursu, przekieruj na stronę z zarządzaniem kursami
            $stmtUpdate->close();
            header("Location: /phpsql/pages/manage_courses.php");
            exit;
        } else {
            // Błąd podczas aktualizacji kursu
            $stmtUpdate->close();
            $error_message = "Błąd podczas aktualizacji kursu. Spróbuj ponownie.";
            header("Location: /phpsql/pages/edit_course.php?id=$course_id&error=" . urlencode($error_message));
            exit;
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
