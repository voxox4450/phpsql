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

$conn->close();
?>
