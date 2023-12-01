<?php
// add_course_process.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Obsługa dodawania nowego kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $creator_id = $_SESSION['user_id']; // Pobierz ID twórcy kursu z sesji

    // Prosta walidacja długości tytułu i opisu
    if (strlen($title) < 6 || strlen($description) < 25) {
        $error_message = "Tytuł musi mieć co najmniej 6 znaków, a opis co najmniej 25 znaków.";
        header("Location: /phpsql/pages/browse_courses.php?error=" . urlencode($error_message));
        exit;
    }

    // Sprawdzenie, czy nie ma już kursu o tym samym tytule i opisie
    $checkDuplicateSql = "SELECT * FROM courses WHERE title = ? AND description = ?";
    $stmtCheckDuplicate = $conn->prepare($checkDuplicateSql);

    if (!$stmtCheckDuplicate) {
        die("Prepared statement error (check duplicate): " . $conn->error);
    }

    $stmtCheckDuplicate->bind_param("ss", $title, $description);
    $stmtCheckDuplicate->execute();
    $stmtCheckDuplicate->store_result();

    if ($stmtCheckDuplicate->num_rows > 0) {
        // Kurs o podanym tytule i opisie już istnieje
        $stmtCheckDuplicate->close();
        $error_message = "Kurs o podanym tytule i opisie już istnieje.";
        header("Location: /phpsql/pages/browse_courses.php?error=" . urlencode($error_message));
        exit;
    }

    // Zamykamy prepared statement
    $stmtCheckDuplicate->close();

    // Wstawianie nowego kursu do bazy danych
    $insertSql = "INSERT INTO courses (title, description, creator_id) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($insertSql);

    if (!$stmtInsert) {
        die("Prepared statement error (insert): " . $conn->error);
    }

    $stmtInsert->bind_param("ssi", $title, $description, $creator_id);

    if ($stmtInsert->execute()) {
        // Pomyślne dodanie kursu, przekieruj na stronę z kursami
        $stmtInsert->close();
        header("Location: /phpsql/pages/browse_courses.php");
        exit;
    } else {
        // Błąd podczas dodawania kursu
        $stmtInsert->close();
        $error_message = "Błąd podczas dodawania kursu. Spróbuj ponownie.";
        header("Location: /phpsql/pages/browse_courses.php?error=" . urlencode($error_message));
        exit;
    }
}

// Zamykamy połączenie
$conn->close();
?>
