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
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Aktualizacja danych kursu w bazie danych przy użyciu prepared statements
    $updateCourseSql = "UPDATE courses SET title=?, description=? WHERE id=?";
    
    // Użycie prepared statements, aby zapobiec atakom SQL Injection
    $stmt = $conn->prepare($updateCourseSql);
    $stmt->bind_param("ssi", $title, $description, $course_id);

    if ($stmt->execute()) {
        // Pomyślna edycja kursu, przekieruj na stronę z zarządzaniem kursami
        header("Location: /phpsql/pages/manage_courses.php");
        exit; // Warto dodatkowo zakończyć działanie skryptu po przekierowaniu
    } else {
        // Błąd edycji kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        $error_message = "Błąd edycji kursu: " . $stmt->error;
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode($error_message));
        exit; // Warto dodatkowo zakończyć działanie skryptu po przekierowaniu
    }

    $stmt->close();
}

$conn->close();
?>
