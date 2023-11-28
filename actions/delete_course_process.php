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

    // Przygotowanie i wykonanie zapytania SQL z użyciem prepared statement
    $deleteCourseSql = "DELETE FROM courses WHERE id=?";
    
    // Użycie prepared statement do zabezpieczenia przed SQL Injection
    $stmt = $conn->prepare($deleteCourseSql);

    if (!$stmt) {
        die("Prepared statement error: " . $conn->error);
    }

    $stmt->bind_param("i", $course_id); // "i" oznacza, że oczekujemy na parametr typu integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Pomyślne usunięcie kursu, przekieruj na stronę z zarządzaniem kursami
        header("Location: /phpsql/pages/manage_courses.php");
    } else {
        // Błąd usuwania kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode("Błąd usuwania kursu: " . $stmt->error));
    }

    // Zamykamy prepared statement
    $stmt->close();
}

// Zamykamy połączenie
$conn->close();
?>
