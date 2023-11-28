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

    // Usunięcie rekordów z tabeli course_ratings związanych z danym kursem
    $deleteRatingsSql = "DELETE FROM course_ratings WHERE course_id=?";
    $stmtRatings = $conn->prepare($deleteRatingsSql);

    if (!$stmtRatings) {
        die("Prepared statement error (ratings): " . $conn->error);
    }

    $stmtRatings->bind_param("i", $course_id);
    $stmtRatings->execute();
    $stmtRatings->close();

    // Usunięcie kursu
    $deleteCourseSql = "DELETE FROM courses WHERE id=?";
    $stmtCourse = $conn->prepare($deleteCourseSql);

    if (!$stmtCourse) {
        die("Prepared statement error (course): " . $conn->error);
    }

    $stmtCourse->bind_param("i", $course_id);
    $stmtCourse->execute();

    if ($stmtCourse->affected_rows > 0) {
        // Pomyślne usunięcie kursu, przekieruj na stronę z zarządzaniem kursami
        header("Location: /phpsql/pages/manage_courses.php");
    } else {
        // Błąd usuwania kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode("Błąd usuwania kursu: " . $stmtCourse->error));
    }

    // Zamykamy prepared statement
    $stmtCourse->close();
}

// Zamykamy połączenie
$conn->close();
?>
