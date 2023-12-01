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

    // Sprawdź, czy użytkownik jest twórcą kursu
    $checkCreatorSql = "SELECT creator_id FROM courses WHERE id=$course_id";
    $result = $conn->query($checkCreatorSql);

    if ($result->num_rows > 0) {
        $courseData = $result->fetch_assoc();
        $creator_id = $courseData['creator_id'];

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
        if ($_SESSION['user_id'] !== $creator_id) {
            header("Location: /phpsql/pages/admin_panel.php");
            exit;
        }    
        header("Location: /phpsql/pages/manage_courses.php");
    } else {
        // Błąd usuwania kursu, przekieruj na stronę z zarządzaniem kursami z komunikatem błędu
        header("Location: /phpsql/pages/manage_courses.php?error=" . urlencode("Błąd usuwania kursu: " . $stmtCourse->error));
    }

    // Zamykamy prepared statement
    $stmtCourse->close();
}}
header("Location: /phpsql/pages/manage_courses.php");
// Zamykamy połączenie
$conn->close();
?>
