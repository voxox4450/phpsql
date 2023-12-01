<?php
// delete_user_process.php
session_start();

// Sprawdź, czy użytkownik jest zalogowany i ma rolę admina
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Obsługa usuwania użytkownika po potwierdzeniu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Sprawdź, czy użytkownik nie próbuje usunąć samego siebie
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error_message'] = "Nie możesz usunąć swojego własnego konta.";
        header("Location: /phpsql/pages/admin_panel.php");
        exit;
    }

    // Przygotuj i wykonaj zapytanie do usuwania ocen kursów utworzonych przez użytkownika
    $deleteUserCourseRatingsSql = "DELETE cr FROM course_ratings cr 
                                    JOIN courses c ON cr.course_id = c.id
                                    WHERE c.creator_id = ?";
    $stmtUserCourseRatings = $conn->prepare($deleteUserCourseRatingsSql);
    $stmtUserCourseRatings->bind_param("i", $user_id);
    if (!$stmtUserCourseRatings->execute()) {
        echo "Błąd usuwania ocen kursów utworzonych przez użytkownika: " . $stmtUserCourseRatings->error;
        exit;
    }
    $stmtUserCourseRatings->close();

    // Przygotuj i wykonaj zapytanie do usuwania ocen kursów wystawionych przez użytkownika
    $deleteUserRatingsSql = "DELETE FROM course_ratings WHERE user_id = ?";
    $stmtUserRatings = $conn->prepare($deleteUserRatingsSql);
    $stmtUserRatings->bind_param("i", $user_id);
    if (!$stmtUserRatings->execute()) {
        echo "Błąd usuwania ocen kursów wystawionych przez użytkownika: " . $stmtUserRatings->error;
        exit;
    }
    $stmtUserRatings->close();

    // Przygotuj i wykonaj zapytanie do usuwania zależności od użytkownika w tabeli completed_courses
    $deleteCompletedCoursesSql = "DELETE FROM completed_courses WHERE user_id = ?";
    $stmtCompletedCourses = $conn->prepare($deleteCompletedCoursesSql);
    $stmtCompletedCourses->bind_param("i", $user_id);
    if (!$stmtCompletedCourses->execute()) {
        echo "Błąd usuwania zależności od użytkownika w tabeli completed_courses: " . $stmtCompletedCourses->error;
        exit;
    }
    $stmtCompletedCourses->close();

    // Przygotuj i wykonaj zapytanie do usuwania kursów utworzonych przez użytkownika
    $deleteUserCoursesSql = "DELETE FROM courses WHERE creator_id = ?";
    $stmtUserCourses = $conn->prepare($deleteUserCoursesSql);
    $stmtUserCourses->bind_param("i", $user_id);
    if (!$stmtUserCourses->execute()) {
        echo "Błąd usuwania kursów utworzonych przez użytkownika: " . $stmtUserCourses->error;
        exit;
    }
    $stmtUserCourses->close();

    // Przygotuj i wykonaj zapytanie do usuwania użytkownika z bazy danych
    $deleteUserSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteUserSql);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        echo "Błąd usuwania użytkownika: " . $stmt->error;
        exit;
    }
    $stmt->close();

    $_SESSION['success_message'] = "Użytkownik został pomyślnie usunięty.";

    // Przekieruj z powrotem do panelu administratora
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
} else {
    $_SESSION['error_message'] = "Nieprawidłowe żądanie usuwania użytkownika.";
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
}
?>
